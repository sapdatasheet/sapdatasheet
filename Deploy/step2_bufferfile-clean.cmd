echo off

cd C:\Data\Business\SAPDatasheet\Runtime\www-root\abap
del /S *.html

echo "Click any key to Continue delete site map files or close window to cancel..."
pause

cd ..\sitemap
del *.xml

pause
