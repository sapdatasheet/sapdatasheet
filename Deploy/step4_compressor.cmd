echo off

cd C:\Data\Business\SAPDatasheet\Repos\Deploy

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\wil\abap
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\wil\abap\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\wul\abap
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\wul\abap\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\bmfr
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\bmfr\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\clas
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\clas\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\cus0
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\cus0\%%i

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

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\intf
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\intf\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\msag
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\msag\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\prog
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\prog\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\shlp
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\shlp\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\sqlt
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\sqlt\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\tabl
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\tabl\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\tran
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\tran\%%i

call:HtmlCompress                                               html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\view
FOR /F %%i IN (config-sap-desc-langu.txt) DO @call:HtmlCompress html C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\view\%%i

call:HtmlCompress                                               xml  C:\Data\Business\SAPDatasheet\Runtime\www-root\sitemap


timeout 60


::----------------------------------------------
::-- Compress Buffer files
::
::-- parameter 1. File Type,  example html, xml
::-- parameter 2. The folder, example C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\doma   C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\doma\1
::----------------------------------------------
:HtmlCompress
echo =====================================================================
echo == Processing for %~1  %~2

cd C:\Data\Business\SAPDatasheet\Repos\Deploy
start /min "Compress Buffer Files Job" "C:\Data\Business\SAPDatasheet\Repos\Deploy\bufferfile-compress.cmd" %~1 %~2

setlocal enableextensions enabledelayedexpansion
:loop
  for /f "tokens=1,*" %%a in ('tasklist ^| find /I /C "cmd.exe"') do set cmd_count=%%a
  echo Command count = %cmd_count%
  if %cmd_count% GEQ 5 (
    timeout 1
    goto loop
  )
endlocal

goto:eof
