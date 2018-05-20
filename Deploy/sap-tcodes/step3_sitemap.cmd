cd C:\Data\Business\SAP-TCodes\Runtime\www-root\sitemap

del *.xml

php analytics.php
php download.php
php tcode.php

php sitemaps.php >> sitemaps.xml

cd C:\Data\Business\SAP-TCodes\Repos\Deploy
