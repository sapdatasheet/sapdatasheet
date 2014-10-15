cd C:\Data\Business\SAPDatasheet\Runtime\www-root
del /S /Q *.php
cd C:\Data\Business\SAPDatasheet\Development\Repos\PHPWebSite
xcopy *.php ..\..\..\Runtime\www-root /S /Y
xcopy *.css ..\..\..\Runtime\www-root /S /Y
xcopy *.png ..\..\..\Runtime\www-root /S /Y
xcopy *.ico ..\..\..\Runtime\www-root /S /Y
xcopy *.txt ..\..\..\Runtime\www-root /S /Y
xcopy *.htaccess ..\..\..\Runtime\www-root /S /Y
copy  .\include\footer.html ..\..\..\Runtime\www-root\include
pause