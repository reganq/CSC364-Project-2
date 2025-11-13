extern "C" {
#include <stdlib.h>
#include <stdint.h>
#include <stddef.h>
#include <string.h>
#include <stdio.h>
#include "../../mini_proto.h"
}

static int same_record(const record_t *a, const record_t *b) {
    if (strcmp(a->name, b->name) != 0) return 0;
    if (a->age != b->age) return 0;
    if (a->score_count != b->score_count) return 0;
    return memcmp(a->scores, b->scores, a->score_count * sizeof(uint16_t)) == 0;
}

extern "C" int LLVMFuzzerTestOneInput(const uint8_t *Data, size_t Size) {
  // Treat the input data like a record, with the extra data being the scores.

  if (Size < (MAX_NAME - 1 + sizeof(uint8_t) + sizeof(uint16_t))) {
    // Not enough input to create a record
    return 0;
  }
  record_t *in = (record_t *) malloc(sizeof(record_t));

  // Copy name
  memcpy(in->name, Data, MAX_NAME - 1);
  in->name[MAX_NAME - 1] = '\0';

  // Copy age
  in->age = (uint8_t) *(Data + ((MAX_NAME - 1) * sizeof(char)));

  // Use the rest as scores
  in->score_count = (uint32_t) ((Size - MAX_NAME + 1 - sizeof(uint8_t)) / sizeof(uint16_t));
  in->scores = (uint16_t *) (Data + ((MAX_NAME - 1) * sizeof(char)) + sizeof(uint8_t));

  size_t need = encode_record(in, NULL, 0);
  uint8_t *buf = (uint8_t *) malloc(need);
  size_t wrote = encode_record(in, buf, need);
  if (wrote == 0) {
    fprintf(stderr, "❌ Encode failed\n");
    free(buf);
    return 1;
  }

  record_t *out = NULL;
  size_t used = decode_record(buf, wrote, &out);
  if (used == 0 || !out) {
    fprintf(stderr, "❌ Decode failed\n");
    free(buf);
    return 1;
  }

  if (!same_record(in, out)) {
    free(buf);
    free_record(out);
    in->scores = NULL;
    free(in);
    return 1;
  }

  free(buf);
  free_record(out);
  in->scores = NULL;
  free(in);
  return 0;
}