#!/bin/sh

cd /var/www/html/test
rm *.er
rm *.pdf
rm *.png

php test.php

echo "Test finished"

