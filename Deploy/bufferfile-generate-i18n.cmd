echo off

rem  cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy
rem  FOR /F %%i IN (config-a-x.txt) DO @call:BuffGenerate  bmfr  %%i
rem  call:BuffGenerate                                     bmfr  TOP

rem  cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy
rem  call:BuffGenerate                                     cvers ""

cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy
FOR /F %%i IN (config-a-x-slash.txt) DO @call:BuffGenerate devc  %%i



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
