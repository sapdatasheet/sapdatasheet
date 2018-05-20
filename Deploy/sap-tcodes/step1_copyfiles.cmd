cd C:\Data\Business\SAP-TCodes\Runtime\www-root
del /S /Q *.css
del /S /Q *.eot
del /S /Q *.gif
del /S /Q *.html
del /S /Q *.ico
del /S /Q *.js
del /S /Q *.jpg
del /S /Q *.less
del /S /Q *.map
del /S /Q *.otf
del /S /Q *.php
del /S /Q *.scss
del /S /Q *.svg
del /S /Q *.ttf
del /S /Q *.woff
del /S /Q *.woff2


cd C:\Data\Business\SAP-TCodes\Repos\www.sap-tcodes.org-ssl
xcopy *.css      ..\..\Runtime\www-root /S /Y
xcopy *.eot      ..\..\Runtime\www-root /S /Y
xcopy *.gif      ..\..\Runtime\www-root /S /Y
xcopy *.html     ..\..\Runtime\www-root /S /Y
xcopy *.ico     ..\..\Runtime\www-root /S /Y
xcopy *.js       ..\..\Runtime\www-root /S /Y
xcopy *.jpg      ..\..\Runtime\www-root /S /Y
xcopy *.less     ..\..\Runtime\www-root /S /Y
xcopy *.map      ..\..\Runtime\www-root /S /Y
xcopy *.otf      ..\..\Runtime\www-root /S /Y
xcopy *.php      ..\..\Runtime\www-root /S /Y
xcopy *.scss     ..\..\Runtime\www-root /S /Y
xcopy *.svg      ..\..\Runtime\www-root /S /Y
xcopy *.ttf      ..\..\Runtime\www-root /S /Y
xcopy *.woff     ..\..\Runtime\www-root /S /Y
xcopy *.woff2    ..\..\Runtime\www-root /S /Y


cd C:\Data\Business\SAP-TCodes\Repos\Deploy
