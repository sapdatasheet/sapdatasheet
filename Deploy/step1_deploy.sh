#!/bin/sh

sudo cp -r  /data/github/sapdatasheet/Web/www.sapdatasheet.org-ssl/. /var/www/html/
sudo rm -rf /var/www/html/nbproject/

echo "Deploy finished"
sleep 1
