echo off

cd C:\Data\Business\SAPDatasheet\Runtime\www-root
del /S /Q *.php
cd C:\Data\Business\SAPDatasheet\Development\Repos\www.sapdatasheet.org
xcopy *.php      ..\..\..\Runtime\www-root /S /Y
xcopy *.css      ..\..\..\Runtime\www-root /S /Y
xcopy *.png      ..\..\..\Runtime\www-root /S /Y
xcopy *.ico      ..\..\..\Runtime\www-root /S /Y
xcopy *.txt      ..\..\..\Runtime\www-root /S /Y
xcopy *.gif      ..\..\..\Runtime\www-root /S /Y
xcopy *.js       ..\..\..\Runtime\www-root /S /Y
xcopy *.html     ..\..\..\Runtime\www-root /S /Y
pause
