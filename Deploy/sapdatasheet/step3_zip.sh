#!/bin/sh

cd /var/www/html
sudo rm     release.zip
sudo zip -r release.zip *

