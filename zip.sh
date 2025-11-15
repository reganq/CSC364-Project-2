cd /home/reganquartus/CSC364-Project-2
mkdir project
cd project

# copy part 1
mkdir artifacts
cp -r ../p1/artifacts/* artifacts

rm artifacts/fuzzing/fuzz_out
rm artifacts/*/mini_proto.c

# copy part 2

cd ..
zip -r project2.zip project
rm -rf project
