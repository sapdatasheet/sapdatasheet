
cd C:\Data\Business\SAPDatasheet\Repos\Deploy
call step1_deploy.cmd
echo "Step 1 finished"

timeout 3
cd C:\Data\Business\SAPDatasheet\Repos\Deploy
call step2-1_bufferfile-html-clear.cmd

timeout 3
cd C:\Data\Business\SAPDatasheet\Repos\Deploy
call step2-2_bufferfile-html-generate.cmd

timeout 3
cd C:\Data\Business\SAPDatasheet\Repos\Deploy
call step3-1_bufferfile-sitemap-clear.cmd

timeout 3
cd C:\Data\Business\SAPDatasheet\Repos\Deploy
call step3-2_bufferfile-sitemap-generate.cmd

timeout 3
cd C:\Data\Business\SAPDatasheet\Repos\Deploy
call step4_compressor.cmd

timeout 3
cd C:\Data\Business\SAPDatasheet\Repos\Deploy
call step5_zip.cmd

timeout 60
echo "All finished"
pause
