echo off

call:BuffGenerateSitemap abap-bmfr.php
call:BuffGenerateSitemap abap-clas.php
call:BuffGenerateSitemap abap-cus0.php
call:BuffGenerateSitemap abap-cvers.php
call:BuffGenerateSitemap abap-devc.php
call:BuffGenerateSitemap abap-doma.php
call:BuffGenerateSitemap abap-dtel.php
call:BuffGenerateSitemap abap-fugr.php
call:BuffGenerateSitemap abap-func.php
call:BuffGenerateSitemap abap-intf.php
call:BuffGenerateSitemap abap-msag-msgnr.php
call:BuffGenerateSitemap abap-msag.php
call:BuffGenerateSitemap abap-prog.php
call:BuffGenerateSitemap abap-shlp.php
call:BuffGenerateSitemap abap-sqlt.php
call:BuffGenerateSitemap abap-tabl.php
call:BuffGenerateSitemap abap-table-field.php
call:BuffGenerateSitemap abap-tran.php
call:BuffGenerateSitemap abap-view.php
call:BuffGenerateSitemap index.php
call:BuffGenerateSitemap sitemaps.php

timeout 60
exit

::----------------------------------------------
::-- Buffer Generate for Sitemap
::
::-- parameter 1. the Index file name. Example: abap-bmfr.php
::----------------------------------------------
:BuffGenerateSitemap
echo =====================================================================
echo == Processing for Sitemap %~1

start /min "BuffGenerate Sitemap Job" "C:\Data\Business\SAPDatasheet\Development\Repos\Deploy\bufferfile-generate-sitemap.cmd" %~1

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
