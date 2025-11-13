
clang -g -fsanitize=address,undefined,fuzzer artifacts/fuzzing/fuzzing.cc libmini_proto.a -o artifacts/fuzzing/fuzz_out

./artifacts/fuzzing/fuzz_out artifacts/fuzzing/corpus