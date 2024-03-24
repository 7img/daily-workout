#!/bin/bash

# Define the name of the zip file
zip_file="daily-workout.zip"

# Define the name of the destination directory
destination_dir="dist"

# Define the files to exclude
exclude_files=(docker-compose.yml ".*" "release.sh")

# Remove existing files
rm -rf dist
rm -rf daily-workout.zip

# Create the destination directory
mkdir -p "$destination_dir"

# Copy all files except those to be excluded to the destination directory
shopt -s extglob
cp -r !(docker-compose.yml|.|..|.*|release.sh|dist|storage) "$destination_dir"

# Change directory to the destination directory
cd "$destination_dir" || exit

# Zip the contents of the destination directory
zip -r "../$zip_file" *

# Return to the previous directory
cd ..

rm -rf dist

echo "Files zipped successfully!"