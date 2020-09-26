#!/bin/sh

cd /var/www
sudo mv     html org.sapdatasheet.www
sudo rm     *.zip
sudo zip -r "sapdatasheet_$(date '+%Y-%m-%d_%H.%M.%S').zip" common-php org.sapdatasheet.www
sudo mv     org.sapdatasheet.www html

