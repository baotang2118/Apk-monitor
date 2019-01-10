#!/usr/bin/env python

from __future__ import print_function
from argparse import ArgumentParser
from androguard.cli import androlyze_main
from androguard.core.androconf import *
from androguard.misc import *
import os
import sql
import sqlstorehash

LIST_NAME_METHODS=["sendBroadcast", "onReceive","startService","onHandleIntent","startActivity","getIntent"];
LIST_HEADER=["STT","APK Name"]+LIST_NAME_METHODS+["Component Type", "Component Name", "Exported Status","getPermissions"]

def count_Method_APK(methodName, listMethods):
    count=0
    newlist=list()
    for element in listMethods:
        newlist.append(element.__repr__())
    for l in newlist:
        if methodName in l:
            count+=1
    return count

def attribute_Component(apk_Obj):
    manifest_Obj=apk_Obj.get_android_manifest_xml()
    application_Tag=manifest_Obj.findall("application")
    latrr=list()
    list_Component=list()
    dem=0
    for childs in application_Tag:
        for child in childs:
            keys=list()
            keys=child.keys()
            newdict=dict()
            list_Component.append(child.tag)
            for key in keys:
                lsplit=key.split("}")
                newdict[lsplit[-1]]=child.get(key)
            latrr.append(newdict)
    return latrr, list_Component

def get_Atrribute(listDict):
    list_Name_Of_Component=list()
    list_Exported_Of_Component=list()
    for dictt in listDict:
        list_Name_Of_Component.append(dictt.get('name'))
        list_Exported_Of_Component.append(dictt.get('exported'))
    return list_Name_Of_Component, list_Exported_Of_Component

def get_List_Contens(path, nameAPK):
    try:
        a, d, dx=AnalyzeAPK(path)
        listMethods=list(dx.get_methods())
        list_Count_Methods=list()
        list_Count_Methods.append(nameAPK)
        for i in range(0,len(LIST_NAME_METHODS)):
            list_Count_Methods.append(count_Method_APK(LIST_NAME_METHODS[i], listMethods))
        atrrs, components=attribute_Component(a)
        names, exports=get_Atrribute(atrrs)
        list_Count_Methods.append(components)
        list_Count_Methods.append(names)
        list_Count_Methods.append(exports)
        list_Count_Methods.append(a.get_permissions())
    except:
        for i in range(0,len(LIST_NAME_METHODS)):
            list_Count_Methods.append("Failed!")
    return list_Count_Methods

def get_Path_Files(pathFolder):
    Fjoin=os.path.join
    lapkname=os.listdir(pathFolder)
    list_Of_Path_Files=[Fjoin(pathFolder,f) for f in os.listdir(pathFolder)]
    return list_Of_Path_Files, lapkname

def map_List_Methods(pathFolder):
    lspath, lsnameAPK=get_Path_Files(pathFolder)
    newlist=list()
    newlist.append(LIST_HEADER)
    i=1    
    for (lp,ln) in zip(lspath,lsnameAPK):
        #hash here
        md5, sha1, sha256 = sqlstorehash.hashMd5Sha1Sha256(lp)
        if(sql.CheckExist(ln,md5, sha1, sha256) == False):
            ltemp=get_List_Contens(lp,ln)
            ltemp.insert(0,i)
            newlist.append(ltemp)
            #sql here
            sql.InsertApp(ltemp, md5, sha1, sha256)
        print ("Completed " + str(round(i/float(len(lspath))*100))+"%.")
        i=i+1
    return newlist

def main():
    #sql.CreateDB();
    #sql.CreateTable();
	#sql.DangerousPermission();
    try:
        fh = open("config","r")
        fh.close()
    except:
        fh = open("config","w")
        fh.write('1')
        fh.close()
    map_List_Methods("/root/Downloads/Test")

if __name__ == '__main__':
    main()