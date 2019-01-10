#!/usr/bin/env python

import mysql.connector

def CreateDB():
	mydb = mysql.connector.connect(
		host="localhost",
		user="root",
		passwd=""
		)

	mycursor = mydb.cursor()
	ExitFlag = False

	y = "(u\'ANDROID_APP_LIST\',)"
	mycursor.execute("SHOW DATABASES")
	for x in mycursor:
		if(y == str(x)):
			ExitFlag = True

	if(ExitFlag == True):
		mycursor.close()
		mydb.close()
	else:
		mycursor.execute("CREATE DATABASE ANDROID_APP_LIST")
		mycursor.close()
		mydb.close()
	return

def CreateTable():
	mydb = mysql.connector.connect(
		host="localhost",
		user="root",
		passwd="",
		database="ANDROID_APP_LIST"
		)

	mycursor = mydb.cursor()

	mycursor.execute("CREATE TABLE App (AppID VARCHAR(6),"
				" AppName NVARCHAR(200) NOT NULL,"
				"MD5 VARCHAR(35) NOT NULL,"
				"SHA1 VARCHAR(40) NOT NULL,"
				"SHA256 VARCHAR(64) NOT NULL,"
				"sendBroadcast INT NOT NULL,"
				"onReceive INT NOT NULL,"
				"startService INT NOT NULL,"
				"onHandleIntent INT NOT NULL,"
				"startActivity INT NOT NULL,"
				"getIntent INT NOT NULL,"
				"PRIMARY KEY (AppID));")

	mycursor.execute("CREATE TABLE Permission (AppID VARCHAR(6),"
				"PermissionName VARCHAR(100) NOT NULL,"
				"PRIMARY KEY (AppID,PermissionName));")

	mycursor.execute("CREATE TABLE Component (AppID VARCHAR(6),"
				"ComponentName VARCHAR(300) NOT NULL,"
				"ComponentType VARCHAR(20) NOT NULL,"
				"ExportStatus VARCHAR(10) NOT NULL,"
				"PRIMARY KEY (AppID,ComponentName));")

	mycursor.execute("ALTER TABLE Component ADD CONSTRAINT FK_ComponentAppID FOREIGN KEY (AppID) REFERENCES App(AppID);")
	mycursor.execute("ALTER TABLE Permission ADD CONSTRAINT FK_PermissonAppID FOREIGN KEY (AppID) REFERENCES App(AppID);")
	mycursor.close()
	mydb.close()

def InsertApp(AppInput, MD5, SHA1, SHA256):
	mydb = mysql.connector.connect(
		host="localhost",
		user="root",
		passwd="",
		database="ANDROID_APP_LIST"
		)

	mycursor = mydb.cursor()
	
	for i in xrange(len(AppInput)):
		if(i == 0):
			f = open("config","r")
			AppID = f.read()
			f.close()
			f = open("config", "w")
			f.write(str(int(AppID)+1))
			f.close()
			while(len(AppID)<4):
				AppID = '0' + AppID
			print AppID
		if(i == 1):
			AppName = AppInput[1]
			print AppName
		if(i == 2):
			sendBroadcast = AppInput[i]
			print sendBroadcast
		if(i == 3):
			onReceive = AppInput[i]
			print onReceive
		if(i == 4):
			startService = AppInput[i]
			print startService
		if(i == 5):
			onHandleIntent = AppInput[i]
			print onHandleIntent
		if(i == 6):
			startActivity = AppInput[i]
			print startActivity
		if(i == 7):
			getIntent = AppInput[i]
			print getIntent
		if(i == 8):
			ComponentType = AppInput[i]
			print ComponentType
		if(i == 9):
			ComponentName = AppInput[i]
			print ComponentName
		if(i == 10):
			ExportStatus = AppInput[i]
			print ExportStatus
		if(i == 11):
			PermissionName = AppInput[i]
			print PermissionName

	if((sendBroadcast or onReceive or startService or onHandleIntent or startActivity or getIntent) == "Failed!" ):
		sql = "INSERT INTO App (AppID, AppName, MD5, SHA1, SHA256, sendBroadcast, onReceive, startService, onHandleIntent, startActivity, getIntent) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
		val = (AppID, AppName, MD5, SHA1, SHA256, -1, -1, -1, -1, -1, -1 )
		mycursor.execute(sql,val)
		mydb.commit()	
		mycursor.close()
		mydb.close()		
		return

	sql = "INSERT INTO App (AppID, AppName, MD5, SHA1, SHA256, sendBroadcast, onReceive, startService, onHandleIntent, startActivity, getIntent) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
	val = (AppID, AppName, MD5, SHA1, SHA256, sendBroadcast, onReceive, startService, onHandleIntent, startActivity, getIntent )
	mycursor.execute(sql,val)
	mydb.commit()

	sql = "INSERT INTO Component (AppID, ComponentName, ComponentType, ExportStatus) VALUES (%s,%s,%s,%s)"
	for i in xrange(len(ComponentType)):
		try:
			val = (AppID, ComponentName[i], ComponentType[i], str(ExportStatus[i]))
			mycursor.execute(sql,val)
			mydb.commit()
		except Exception, e:
			val = (AppID, ComponentName[i] +"-UiT4317"+str(i), ComponentType[i], str(ExportStatus[i]))
			mycursor.execute(sql,val)
			mydb.commit()

	sql = "INSERT INTO Permission (AppID, PermissionName) VALUES (%s,%s)"
	for i in xrange(len(PermissionName)):
		try:
			val = (AppID, PermissionName[i])
			mycursor.execute(sql,val)
			mydb.commit()
		except Exception, e:
			val = (AppID, PermissionName[i] +"-UiT4317"+str(i))
			mycursor.execute(sql,val)
			mydb.commit()
	
	mycursor.close()
	mydb.close()

def CheckExist(AppInput, MD5, SHA1, SHA256):
	mydb = mysql.connector.connect(
		host="localhost",
		user="root",
		passwd="",
		database="ANDROID_APP_LIST"
		)

	mycursor = mydb.cursor()

	sql = "SELECT AppName, MD5, SHA1, SHA256 FROM App WHERE AppName = %s AND MD5 = %s AND SHA1 = %s AND SHA256 = %s"
	val = (AppInput, MD5, SHA1, SHA256,)
	mycursor.execute(sql, val)
	myresult = mycursor.fetchall()

	if (len(myresult) != 0):
		print myresult
		return True
	else:
		return False

def DangerousPermission():
	mydb = mysql.connector.connect(
		host="localhost",
		user="root",
		passwd="",
		database="ANDROID_APP_LIST"
		)

	mycursor = mydb.cursor()

	mycursor.execute("CREATE TABLE DangerousPermission (PermissionGroup VARCHAR(15),"
				"PermissionName VARCHAR(30) NOT NULL,"
				"PRIMARY KEY (PermissionGroup,PermissionName));")
	sql = "INSERT INTO DangerousPermission (PermissionGroup, PermissionName) VALUES (%s,%s)"
	val = ("CALENDAR", "READ_CALENDAR" )
	mycursor.execute(sql,val)
	val = ("CALENDAR", "WRITE_CALENDAR" )
	mycursor.execute(sql,val)

	val = ("CALL_LOG", "READ_CALL_LOG" )
	mycursor.execute(sql,val)
	val = ("CALL_LOG", "WRITE_CALL_LOG" )
	mycursor.execute(sql,val)
	val = ("CALL_LOG", "PROCESS_OUTGOING_CALLS" )
	mycursor.execute(sql,val)
	
	val = ("CAMERA", "CAMERA" )
	mycursor.execute(sql,val)
	
	val = ("CONTACTS", "READ_CONTACTS" )
	mycursor.execute(sql,val)
	val = ("CONTACTS", "WRITE_CONTACTS" )
	mycursor.execute(sql,val)
	val = ("CONTACTS", "GET_ACCOUNTS" )
	mycursor.execute(sql,val)
	
	val = ("LOCATION", "ACCESS_FINE_LOCATION" )
	mycursor.execute(sql,val)
	val = ("LOCATION", "ACCESS_COARSE_LOCATION" )
	mycursor.execute(sql,val)
	
	val = ("MICROPHONE", "RECORD_AUDIO" )
	mycursor.execute(sql,val)
	
	val = ("PHONE", "READ_PHONE_STATE" )
	mycursor.execute(sql,val)
	val = ("PHONE", "READ_PHONE_NUMBERS" )
	mycursor.execute(sql,val)
	val = ("PHONE", "CALL_PHONE" )
	mycursor.execute(sql,val)
	val = ("PHONE", "ANSWER_PHONE_CALLS" )
	mycursor.execute(sql,val)
	val = ("PHONE", "ADD_VOICEMAIL" )
	mycursor.execute(sql,val)
	val = ("PHONE", "USE_SIP" )
	mycursor.execute(sql,val)

	val = ("SENSORS", "BODY_SENSORS" )
	mycursor.execute(sql,val)
	
	val = ("SMS", "SEND_SMS" )
	mycursor.execute(sql,val)
	val = ("SMS", "RECEIVE_SMS" )
	mycursor.execute(sql,val)
	val = ("SMS", "READ_SMS" )
	mycursor.execute(sql,val)
	val = ("SMS", "RECEIVE_WAP_PUSH" )
	mycursor.execute(sql,val)
	val = ("SMS", "RECEIVE_MMS" )
	mycursor.execute(sql,val)
	
	val = ("STORAGE", "READ_EXTERNAL_STORAGE" )
	mycursor.execute(sql,val)
	val = ("STORAGE", "WRITE_EXTERNAL_STORAGE" )
	mycursor.execute(sql,val)
	mydb.commit()
