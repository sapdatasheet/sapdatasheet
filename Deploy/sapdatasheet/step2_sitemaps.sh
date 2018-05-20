#!/bin/sh

# Clear existing sitemap
sudo rm /var/www/html/sitemap/*.xml

# Generate Sitemap one by one
cd /var/www/html/sitemap/
for i in *.php; do sudo php $i; done

cd /var/www/html/sitemap/
sudo rm *.php
