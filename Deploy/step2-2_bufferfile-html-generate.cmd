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

timeout 60
exit

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

start /min "BuffGenerate HTML Job" "C:\Data\Business\SAPDatasheet\Development\Repos\Deploy\bufferfile-generate-html.cmd" %~1 %~2 %~3


setlocal enableextensions enabledelayedexpansion
:loop
  for /f "tokens=1,*" %%a in ('tasklist ^| find /I /C "cmd.exe"') do set cmd_count=%%a
  echo Command count = %cmd_count%
  if %cmd_count% GEQ 8 (
    timeout 1
    goto loop
  )
endlocal
  
cd C:\Data\Business\SAPDatasheet\Development\Repos\Deploy

goto:eof
