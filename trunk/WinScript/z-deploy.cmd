cd C:\Data\Business\SAPDatasheet\Runtime\www-root
del /S /Q *.php
cd C:\Data\Business\SAPDatasheet\Development\Repos\www.sapdatasheet.org
xcopy *.php      ..\..\..\Runtime\www-root /S /Y
xcopy *.css      ..\..\..\Runtime\www-root /S /Y
xcopy *.png      ..\..\..\Runtime\www-root /S /Y
xcopy *.ico      ..\..\..\Runtime\www-root /S /Y
xcopy *.txt      ..\..\..\Runtime\www-root /S /Y
copy  .\admin\index.html  ..\..\..\Runtime\www-root\admin
copy  .\include\footer.html  ..\..\..\Runtime\www-root\include
copy  .\sitemap\index.html   ..\..\..\Runtime\www-root\sitemap
mkdir ..\..\..\Runtime\www-root\site
copy  .\site\*.html          ..\..\..\Runtime\www-root\site
copy  z-generate-buffer.cmd  ..\..\..\Runtime\scripts
pause
