#!/bin/sh

# Clear the Test Folder from production
cd /var/www/html
sudo rm -rf test

# Zip the folders
cd /var/www
sudo mv     html org.sap-tables.www
sudo rm     *.zip
sudo zip -r "sap-tables_$(date '+%Y-%m-%d_%H.%M.%S').zip" common-php org.sap-tables.www
sudo mv     org.sap-tables.www html

