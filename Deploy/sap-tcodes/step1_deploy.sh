#!/bin/sh

sudo rm    -rf  /var/www/common-php
sudo mkdir -p   /var/www/common-php
sudo cp    -r  ../../Web/common-php/.           /var/www/common-php/

sudo rm    -rf /var/www/html/*
sudo cp    -r  ../../Web/org.sap-tcodes.www/.   /var/www/html/

echo "Deploy finished"

