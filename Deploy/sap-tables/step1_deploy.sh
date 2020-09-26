#!/bin/sh

sudo rm    -rf  /var/www/common-php
sudo mkdir -p   /var/www/common-php
sudo cp    -r  ../../Web/common-php/.           /var/www/common-php/

sudo rm    -rf  /var/www/html/*
sudo cp    -r  ../../Web/org.sap-tables.www/.   /var/www/html/

# Open the permission for the test folder.
# - This folder does not exists in production system for security.
sudo chmod -R 777 /var/www/html/test

echo "Deploy finished"

