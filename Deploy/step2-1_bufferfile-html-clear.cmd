echo off

cd C:\Data\Business\SAPDatasheet\Runtime\www-root\abap
del /S *.html

cd C:\Data\Business\SAPDatasheet\Runtime\www-root\wul\abap
del /S *.html

timeout 60
exit
