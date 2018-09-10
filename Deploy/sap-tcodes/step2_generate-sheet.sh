#!/bin/sh

cd   /var/www/html/download/sheet
sudo rm     -rf    dist
sudo mkdir         dist

sudo touch         script.sh
sudo truncate -s 0 script.sh
sudo chmod 777     script.sh

sudo php scriptgen.php >> script.sh
sudo ./script.sh

sudo rm            script.sh
sudo rm            scriptgen.php
sudo rm            download.php

echo "Generate data sheet finished"
