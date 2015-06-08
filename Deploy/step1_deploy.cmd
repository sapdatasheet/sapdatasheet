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
copy  .\abap\icon\index.html  ..\..\..\Runtime\www-root\abap\icon
copy  .\admin\index.html      ..\..\..\Runtime\www-root\admin
copy  .\include\google\*.html ..\..\..\Runtime\www-root\include\google
copy  .\sitemap\index.html    ..\..\..\Runtime\www-root\sitemap
mkdir ..\..\..\Runtime\www-root\site
copy  .\site\*.html           ..\..\..\Runtime\www-root\site
pause
