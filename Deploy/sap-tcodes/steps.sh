#!/bin/bash

./step1_deploy.sh
./step2_generate-book.sh
./step2_generate-sheet.sh
./step3_sitemap.sh
./step4_zip.sh

echo "Finished"
