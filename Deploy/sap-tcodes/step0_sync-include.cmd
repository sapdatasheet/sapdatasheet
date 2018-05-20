rem  Download the Common files

cd C:\Data\Business\SAPDatasheet\Repos\Web\www.sapdatasheet.org-ssl\include\common
xcopy *.php      C:\Data\Business\SAP-TCodes\Repos\www.sap-tcodes.org-ssl\include\common /S /Y

cd C:\Data\Business\SAPDatasheet\Repos\Web\www.sapdatasheet.org-ssl\
copy page404.php C:\Data\Business\SAP-TCodes\Repos\www.sap-tcodes.org-ssl
copy favicon.ico C:\Data\Business\SAP-TCodes\Repos\www.sap-tcodes.org-ssl

cd C:\Data\Business\SAPDatasheet\Repos\Web\www.sapdatasheet.org-ssl\include\google
copy adsense-*   C:\Data\Business\SAP-TCodes\Repos\www.sap-tcodes.org-ssl\include\google

rem  Download the 3rd Party files

cd C:\Data\Business\SAPDatasheet\Repos\Web\www.sapdatasheet.org-ssl\include\3rdparty
xcopy *.json     C:\Data\Business\SAP-TCodes\Repos\www.sap-tcodes.org-ssl\include\3rdparty /S /Y
xcopy *.lock     C:\Data\Business\SAP-TCodes\Repos\www.sap-tcodes.org-ssl\include\3rdparty /S /Y
xcopy *.php      C:\Data\Business\SAP-TCodes\Repos\www.sap-tcodes.org-ssl\include\3rdparty /S /Y
xcopy *.txt      C:\Data\Business\SAP-TCodes\Repos\www.sap-tcodes.org-ssl\include\3rdparty /S /Y

cd C:\Data\Business\SAP-TCodes\Repos\Deploy
