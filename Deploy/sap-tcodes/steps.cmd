
cd C:\Data\Business\SAP-TCodes\Repos\Deploy
call step0_sync-include.cmd

cd C:\Data\Business\SAP-TCodes\Repos\Deploy
call step1_copyfiles.cmd

cd C:\Data\Business\SAP-TCodes\Repos\Deploy
call step2_generate-book.cmd

cd C:\Data\Business\SAP-TCodes\Repos\Deploy
call step2_generate-sheet.cmd

cd C:\Data\Business\SAP-TCodes\Repos\Deploy
call step3_sitemap.cmd

cd C:\Data\Business\SAP-TCodes\Repos\Deploy
call step4_zip.cmd

pause
