#!/bin/bash

# Clear existing sitemap
sudo rm /var/www/html/sitemap/*.xml

# Generate Sitemap one by one
cd /var/www/html/sitemap/
sudo php abap.php

cd /var/www/html/sitemap/
sudo rm *.php

