echo off

cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\bmfr
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\bmfr\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\cvers
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\cvers\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\devc
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\devc\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\doma
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\doma\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\dtel
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\dtel\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\fugr
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\fugr\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\func
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\func\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\prog
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\prog\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\sqlt
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\sqlt\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\tabl
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\tabl\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\tran
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\tran\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\view
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\view\%%i

call:HtmlCompress                                               xml  C:\Data\Business\SAPDatasheet\Runtime\www-root\sitemap

pause

::----------------------------------------------
::-- Buffer Generate with I18N
::
::-- parameter 1. File Type,  example html, xml
::-- parameter 2. The folder, example C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\doma   C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\doma\1
::----------------------------------------------
:HtmlCompress
echo =====================================================================
echo == Processing for %~1  %~2

cd C:\Data\Business\SAPDatasheet\Runtime\htmlcompressor
java -jar htmlcompressor-1.5.3.jar --type %~1 -o %~2 %~2
cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy

goto:eof
