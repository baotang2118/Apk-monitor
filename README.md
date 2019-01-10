# apk-monitor

The purpose of this project are filtering out some major function like sendBroadcast, onReceive, startService, onHandleIntent, startActivity, getIntent; counting them; showing Permission and Components's export status which matched "True"  
This project help people locate sensity function easily.

To use this apk monitor:  
Install AndroidGuard -> for analysis  
Install XAMPP -> for mysql DB and inllustrating report in Web UI  

Put apk-monitor.py, sql.py, sqlstorehash.py into 1 folder  
Run sql.CreateDB(), sql.Creatable(), sql.DangerousPermission() for the first time run analysis - line 95, 96, 97  
then comment it, we dont need it anymore  
Change the folder which you want to analysis at line 105  
By default, xampp doesnt have root psswd, so just run  

Create a folder name's "monitor" in "httdocs" in XAMPP  
Put all file in "php" into "monitor"  
then start service and enjoy  

App can be searched in report by its name, ID or hashes.
