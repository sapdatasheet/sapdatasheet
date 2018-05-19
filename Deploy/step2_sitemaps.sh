#!/bin/sh

# Clear existing sitemap
sudo rm /var/www/html/sitemap/*.xml

# Generate Sitemap one by one
cd /var/www/html/sitemap/

sudo php  abap-bmfr.php
sudo php  abap-clas.php
sudo php  abap-cus0.php
sudo php  abap-cvers.php
sudo php  abap-devc.php
sudo php  abap-doma.php
sudo php  abap-dtel.php
sudo php  abap-fugr.php
sudo php  abap-func.php
sudo php  abap-intf.php
sudo php  abap-msag-msgnr.php
sudo php  abap-msag.php
sudo php  abap-prog.php
sudo php  abap-shlp.php
sudo php  abap-sqlt.php
sudo php  abap-tabl.php
sudo php  abap-table-field.php
sudo php  abap-tran.php
sudo php  abap-view.php

sudo php  index.php
sudo php  wil-abap.php
sudo php  wul-abap.php

sudo php  sitemaps-abap.php
sudo php  sitemaps-wil.php
sudo php  sitemaps-wul.php





