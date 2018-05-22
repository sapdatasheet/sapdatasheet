#!/bin/sh

cd   /var/www/html/sitemap

sudo rm *.xml

sudo php analytics.php
sudo php download.php
sudo php tcode.php

sudo touch               sitemaps.xml
sudo truncate -s 0       sitemaps.xml
sudo chmod       777     sitemaps.xml
sudo php sitemaps.php >> sitemaps.xml

sudo rm *.php

echo "Generate sitemap finished"
