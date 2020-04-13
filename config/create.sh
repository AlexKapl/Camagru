#!/bin/bash

cmd="DROP DATABASE IF EXISTS camagru;CREATE DATABASE camagru;"

if [ `uname` == Darwin ]; then
	if [ -n "$1" ] && [ -n "$2" ]; then
		mysql=$HOME/Library/Containers/MAMP/mysql/bin/mysql
		echo $cmd | mysql -u$1 -p$2
	fi
else
	echo $cmd | mysql
fi
