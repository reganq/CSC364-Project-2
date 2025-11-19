#include "mini_proto.h"
#include <stdlib.h>
#include <string.h>
#include <stdio.h>

size_t encode_record(const record_t *rec, uint8_t **out_buf) {
    size_t name_len = strnlen(rec->name, MAX_NAME);
    size_t space = 1 + name_len + 1 + 4;
    if (rec->score_count > (SIZE_MAX - space) / 2) {
        return 0;
    }
    space = space + 2 * rec->score_count;

    uint8_t *buf = malloc(space);

    size_t off = 0;
    buf[off++] = (uint8_t)name_len;
    memcpy(buf + off, rec->name, name_len); off += name_len;

    buf[off++] = rec->age;

    memcpy(buf + off, &rec->score_count, 4); off += 4;
    memcpy(buf + off, rec->scores, 2 * rec->score_count);

    off += 2 * rec->score_count;

    *out_buf = buf;
    return off;
}

size_t decode_record(const uint8_t *buf, size_t len, record_t **out) {
    size_t off = 0;
    if (len < sizeof(uint8_t)) {
        return 0;
    }
    uint8_t name_len = buf[off++];
    if (name_len >= MAX_NAME) {
        name_len = MAX_NAME - 1;
    }

    record_t *rec = malloc(sizeof(record_t));
    if (!rec) return 0;

    if (len < off + name_len) {
        free(rec);
        return 0;
    }
    memcpy(rec->name, buf + off, name_len);
    rec->name[name_len] = '\0';
    off += name_len;

    if (len < off + sizeof(uint8_t)) {
        free(rec);
        return 0;
    }
    rec->age = buf[off++];

    if (len < off + sizeof(uint32_t)) {
        free(rec);
        return 0;
    }
    memcpy(&rec->score_count, buf + off, 4); off += 4;
    if (rec->score_count >= (len - off) / sizeof(uint16_t)) {
        rec->score_count = (len - off) / sizeof(uint16_t);
    }

    size_t space = rec->score_count * 2;
    rec->scores = malloc(space);
    if (len < off + space) {
        free(rec->scores);
        free(rec);
        return 0;
    }
    memcpy(rec->scores, buf + off, space);
    off += space;

    *out = rec;
    return off;
}

void free_record(record_t *rec) {
    if (!rec) return;
    free(rec->scores);
    free(rec);
}

