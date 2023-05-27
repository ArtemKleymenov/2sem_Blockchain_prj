#!/bin/bash

find ./php.scripts/ -name *.json -delete
rm -rf ./php.scripts/session/*

echo 'Starting ganache...'
ganache-cli &

echo 'Starting php server...'
cd ./php.scripts/
php -S localhost:3000 &

echo 'Starting prediction webapp...'
cd $1
source .venv/bin/activate
tox -e webapp &


#jobs

