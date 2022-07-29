#!/usr/bin/python3

import pymysql
import json

# 打开数据库连接
db_location = pymysql.connect(host="192.168.1.111",user="ayncMobile_com",password="eG6HMAQjWSHTrZ2W",database="ayncMobile_com",charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor )
db_remote = pymysql.connect(host="192.144.230.179",user="msgo_xyz",password="XXiMJtFRsZD7PASM",database="msgo_xyz",charset='utf8mb4', cursorclass=pymysql.cursors.DictCursor )

cursor = db_remote.cursor()
sql = "select * from cards a inner join card_cases b on a.card_case_id = b.id where b.best_show = 1"
cursor.execute(sql)
case_results = cursor.fetchall()

# print(case_results)
# exit()
# 读取数据
f =open('cityArea.json',encoding='utf-8')
res=f.read()
resDict = json.loads(res)
for provice in resDict:
    for city in provice['children']:
        show_loca_name = provice['name']+'-'+city['name']
        for row in case_results:
            show_name = row['case_name'] +'-'+ row['card_name']
            if(row['case_name'] == row['card_name']):
                show_name = row['case_name']
            print(show_loca_name+'~~~~~~'+show_name)
exit()

# 使用 cursor() 方法创建一个游标对象 cursor
cursor = db_remote.cursor()
sql = "select * from cards a inner join card_cases b on a.card_case_id = b.id where b.best_show = 1"
cursor.execute(sql)
results = cursor.fetchall()

print ("Database version : %s " % len(results))

# 关闭数据库连接
db_remote.close()