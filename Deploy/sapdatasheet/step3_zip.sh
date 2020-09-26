#!/bin/bash

scriptpath=`realpath -s $0`
scriptfodr=`dirname $scriptpath`
echo "$0 folder is $scriptfodr"

# Zip the folders
cd /var/www
sudo mv     html org.sapdatasheet.www
sudo rm     *.zip
sudo zip -r "sapdatasheet_$(date '+%Y-%m-%d_%H.%M.%S').zip" common-php org.sapdatasheet.www
sudo mv     org.sapdatasheet.www html


# Deploy to dist folder
cd $scriptfodr && pwd
mkdir -p                   ../../dist
sudo  mv   /var/www/*.zip  ../../dist/
ls    -alh                 ../../dist/
