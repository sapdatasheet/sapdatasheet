::----------------------------------------------
::-- Buffer Generate with I18N
::
::-- parameter 1. The target folder,   example C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\bmfr
::-- parameter 2. The index character, example a, b, c
::-- parameter 3. The SAP language,    example D, E, F, 1
::----------------------------------------------

cd %~1
php -f index.php %~2  %~3
exit