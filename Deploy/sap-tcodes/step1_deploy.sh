#!/bin/sh

sudo rm    -rf /var/www/common-php
sudo mkdir -p  /var/www/common-php
sudo cp    -r  /data/github/sapdatasheet/Web/common-php/.           /var/www/common-php/

sudo rm    -rf /var/www/html/*
sudo cp    -r  /data/github/sapdatasheet/Web/org.sap-tcodes.www/.   /var/www/html/

echo "Deploy finished"
sleep 1
