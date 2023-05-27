#!/bin/bash

fuser -k 3000/tcp  # php server
fuser -k 8000/tcp  # predict app
fuser -k 8545/tcp  # ganache

