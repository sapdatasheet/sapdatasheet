echo off

cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy
FOR /F %%i IN (config-a-x.txt)       DO @call:BuffGenerate bmfr  %%i
call:BuffGenerate                                          bmfr  TOP

cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy
call:BuffGenerate                                          cvers ""

cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy
FOR /F %%i IN (config-a-x-slash.txt) DO @call:BuffGenerate devc  %%i

cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy
FOR /F %%i IN (config-a-x-slash.txt) DO @call:BuffGenerate doma  %%i

cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy
FOR /F %%i IN (config-a-x-slash.txt) DO @call:BuffGenerate dtel  %%i

cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy
FOR /F %%i IN (config-a-0-slash.txt) DO @call:BuffGenerate fugr  %%i

cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy
FOR /F %%i IN (config-a-0-slash.txt) DO @call:BuffGenerate func  %%i
call:BuffGenerate                                          func  rfc

cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy
FOR /F %%i IN (config-a-x-slash.txt) DO @call:BuffGenerate prog  %%i

cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy
call:BuffGenerate                                          sqlt  ""

cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy
FOR /F %%i IN (config-a-x-slash.txt) DO @call:BuffGenerate tabl  %%i
call:BuffGenerate                                          tabl  cluster
call:BuffGenerate                                          tabl  pool

cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy
FOR /F %%i IN (config-a-0-slash.txt) DO @call:BuffGenerate tran  %%i

cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy
FOR /F %%i IN (config-a-x-slash.txt) DO @call:BuffGenerate view  %%i


echo "Generate file for site map now, click any key to continue or close window to cancel..."
pause

cd C:\Data\Business\SAPDatasheet\Runtime\www-root\sitemap
php abap-bmfr.php
php abap-cvers.php
php abap-devc.php
php abap-doma.php
php abap-dtel.php
php abap-fugr.php
php abap-func.php
php abap-prog.php
php abap-sqlt.php
php abap-tabl.php
php abap-table-field.php
php abap-tran.php
php abap-view.php
php index.php
php sitemaps.php

pause

::----------------------------------------------
::-- Buffer Generate
::
::-- parameter 1. The entity,          example bmfr, tabl
::-- parameter 2. The index character, example a, b, c
::----------------------------------------------
:BuffGenerate
echo =====================================================================
echo == Processing for %~1  %~2

set buf_folder=C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\%~1
FOR /F %%j IN (config-sap-desc-langu.txt) DO @call:BuffGenerateI18N  %buf_folder% %~2 %%j
goto:eof


::----------------------------------------------
::-- Buffer Generate with I18N
::
::-- parameter 1. The target folder,   example C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\bmfr
::-- parameter 2. The index character, example a, b, c
::-- parameter 3. The SAP language,    example D, E, F, 1
::----------------------------------------------
:BuffGenerateI18N
echo =====================================================================
echo == Processing for Language %~1  %~2  %~3

cd %~1
php -f index.php %~2  %~3
cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy

goto:eof
