#!/bin/bash

scriptpath=`realpath -s $0`
scriptfodr=`dirname $scriptpath`
echo "$0 folder is $scriptfodr"

# Clear the Test Folder from production
cd /var/www/html
sudo rm -rf test

# Generate zip package
cd /var/www
sudo mv     html org.sap-tcodes.www
sudo rm     *.zip
sudo zip -r "sap-tcodes_$(date '+%Y-%m-%d_%H.%M.%S').zip" common-php org.sap-tcodes.www
sudo mv     org.sap-tcodes.www html

# Deploy to dist folder
cd $scriptfodr && pwd
mkdir -p                   ../../dist
sudo  mv   /var/www/*.zip  ../../dist/
ls    -alh                 ../../dist/
