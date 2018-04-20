#!/bin/sh
export LANG=en_US.UTF-8
sudo svn cleanup $3
sudo svn up --username $1 --password $2 $3 --no-auth-cache --non-interactive
