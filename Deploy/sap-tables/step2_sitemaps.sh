#!/bin/bash

# Clear existing sitemap
sudo rm /var/www/html/sitemap/*.xml

# Generate Sitemaps
cd /var/www/html/sitemap/
sudo php table.php

# Clean Unused sitemap generator
cd /var/www/html/sitemap/
sudo rm *.php

