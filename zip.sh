cd /home/reganquartus/CSC364-Project-2
mkdir project
cd project

mkdir p1
mkdir p2

# copy part 1
cd p1
mkdir artifacts
cp -r ../../p1/artifacts/* artifacts

rm artifacts/fuzzing/fuzz_out
rm artifacts/*/*.c

cd ..

# copy part 2
cd p2
mkdir artifacts
cp -r ../../p2/artifacts/* artifacts

rm artifacts/exploits/*/*.php

cd ../..
zip -r project2.zip project
rm -rf project
