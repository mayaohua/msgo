#!/usr/bin/python3

import pymysql
import json
import requests
import re
import time

# 打开数据库连接
db_location = pymysql.connect(host="192.168.1.111",user="ayncMobile_com",password="eG6HMAQjWSHTrZ2W",database="ayncMobile_com",charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor )
db_remote = pymysql.connect(host="192.144.230.179",user="msgo_xyz",password="XXiMJtFRsZD7PASM",database="msgo_xyz",charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor )

# 读取地址数据
f = open('cityArea.json',encoding='utf-8')
res=f.read()
areaDict = json.loads(res)
# 读取规则数据

f = open('rules.json',encoding='utf-8')
ruled = f.read()
ruleDict = json.loads(ruled)

#获取卡种
def cards():
    cursor = db_remote.cursor()
    sql = "select a.*,b.case_name from cards a inner join card_cases b on a.card_case_id = b.id where b.best_show = 1"
    cursor.execute(sql)
    cursor.close()
    return cursor.fetchall()

#通过名称获取对应的城市
def getAreaData(provice_name,city_name):
    areaData = None
    for provice in areaDict:
        if provice['name'] == provice_name:
            for city in provice['children']:
                pattern = re.compile(r'^'+city_name)
                if pattern.search(city['name']) != None:
                    temp_provice = provice.copy()
                    del temp_provice['children']
                    areaData = {'city':city,'provice':temp_provice}
                    break
    return areaData
            

#获取号码拥有的规则
def getRuleData(phone):
    data = []
    for rule in ruleDict:
        ret = re.match(r""+rule['ze_rule'], phone)
        if ret:
            data.append({'rule_name':rule['ze_name']})
    return data

#插入数据
def setDataToDb(data):
    if selectNumber(data['mobile_number']):
        return
    sql="insert into best_mobiles(mobile_number,\
    provice_code,provice_name,city_code,city_name,\
    card_name,card_id,is_sell,data,mobile_from,created_at,updated_at) \
    values(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)"
    cursor = db_location.cursor()
    cursor.execute(sql,(data['mobile_number'],data['provice_code'],
    data['provice_name'],data['city_code'],data['city_name'],
    data['card_name'],data['card_id'],data['is_sell'],
    data['data'],data['mobile_from'],data['created_at'],data['updated_at']))
    cursor.close()
    db_location.commit()

#删除数据
def deleteOldData(mobile_from):
    sql = "DELETE FROM best_mobiles WHERE mobile_from = %s"
    cursor = db_location.cursor()
    cursor.execute(sql,(mobile_from))
    cursor.close()
    db_location.commit()

#查询是否存在号码
def selectNumber(mobile_number):
    sql = 'select * from best_mobiles where mobile_number = %s'
    cursor = db_location.cursor()
    cursor.execute(sql,(mobile_number))
    results = cursor.fetchall()
    cursor.close()
    if len(results):
        return True
    return False
    