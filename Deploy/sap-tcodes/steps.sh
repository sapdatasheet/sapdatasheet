#!/bin/sh

/data/github/sapdatasheet/Deploy/sap-tcodes/step1_deploy.sh
/data/github/sapdatasheet/Deploy/sap-tcodes/step2_generate-book.sh
/data/github/sapdatasheet/Deploy/sap-tcodes/step2_generate-sheet.sh
/data/github/sapdatasheet/Deploy/sap-tcodes/step3_sitemap.sh
/data/github/sapdatasheet/Deploy/sap-tcodes/step4_zip.sh

echo "Finished"
