cd C:\Data\Business\SAP-TCodes\Runtime\www-root\download\book
del *.cmd
rmdir /S /Q dist
mkdir dist

php scriptgen.php >> script.cmd
script.cmd

cd C:\Data\Business\SAP-TCodes\Repos\Deploy
