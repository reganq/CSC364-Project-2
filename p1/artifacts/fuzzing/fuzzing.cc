extern "C" {
#include <stdlib.h>
#include <stdint.h>
#include <stddef.h>
#include <string.h>
#include <stdio.h>
#include "../../mini_proto.h"
}

extern "C" int LLVMFuzzerTestOneInput(const uint8_t *Data, size_t Size) {
  // Treat the input data like an encoded record
  record_t *out = NULL;
  size_t used = decode_record(Data, Size, &out);
  if (out) {
    // Double check encoding again
    size_t need = encode_record(out, NULL, 0);
    uint8_t *buf = (uint8_t *) malloc(need);
    encode_record(out, buf, Size);

    free(buf);
    free_record(out);
  }

  return 0;
}