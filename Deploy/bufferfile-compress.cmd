::----------------------------------------------
::-- Compress Buffer files
::
::-- parameter 1. File Type,  example html, xml
::-- parameter 2. The folder, example C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\doma   C:\Data\Business\SAPDatasheet\Runtime\www-root\abap\doma\1
::----------------------------------------------

cd C:\Data\Business\SAPDatasheet\Runtime\htmlcompressor
java -jar htmlcompressor-1.5.3.jar --type %~1 -o %~2 %~2

exit
