First, compile the program ensuring that the `SAN=1` option is given, so sanitizers are enabled.

Next, use the compiled `libmini_proto.a` file to create the fuzzing executable:

```
clang -g -fsanitize=address,undefined,fuzzer artifacts/fuzzing/fuzzing.cc libmini_proto.a -o artifacts/fuzzing/fuzz_out
```

Once the fuzzing executable has been compiled, you can use it to run new fuzzing or to check previously-discovered bugs. To run fuzzing with the previously-collected corpus as a seed, run

```
./artifacts/fuzzing/fuzz_out artifacts/fuzzing/corpus
```

To instead test a single, known bug case, first navigate to the bug directory (i.e. `p1/artifacts/bugN`) and determine which bug you are testing, then copy the path to the crash file. Run the test as
```
./artifacts/fuzzing/fuzz_out -runs=1 path/to/crash-file
```

For instance, bug1 has the crash file `crash-da39a3ee5e6b4b0d3255bfef95601890afd80709` so you can re-test that case with:
```
./artifacts/fuzzing/fuzz_out -runs=1 p1/artifacts/bug1/crash-da39a3ee5e6b4b0d3255bfef95601890afd80709
```

For furture work, adding fuzzing for `encode_record` would be helpful. This could be done by casting the array of bytes (the "fuzz") to a record, and passing that into the method.