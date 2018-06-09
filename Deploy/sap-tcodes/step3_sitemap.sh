#!/bin/sh

cd   /var/www/html/sitemap

sudo rm  *.xml
sudo php tcode.php
sudo rm  *.php

echo "Generate sitemap finished"
