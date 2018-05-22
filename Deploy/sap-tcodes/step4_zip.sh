#!/bin/sh

cd /var/www
sudo mv     html org.sap-tcodes.www
sudo rm     *.zip
sudo zip -r "sap-tcodes_$(date '+%Y-%m-%d_%H.%M.%S').zip" common-php org.sap-tcodes.www
sudo mv     org.sap-tcodes.www html
