#!/usr/bin/python3

import json
import requests
import time
import appbase

payload = {'all': 'y'}
r = requests.get("http://lt.haokazhushou.com/api/seach/?all=y", params=payload ,timeout=5)
datas = r.json()
if len(datas) > 2:
    appbase.deleteOldData('dsf')
for index in range(len(datas)):
    data = datas[index]
    if index == 0 or data['city'] == "-" or data['phone'] == "":
        continue
    area = data['city'].split('-')

    if area[1] == '巴音郭勒':
        area[1] = '巴音郭楞'
    area[1] = area[1].replace('蒙古族藏族自治','')

    areaData = appbase.getAreaData(area[0],area[1])
    if areaData == None:
        #print('未找到市：'+area)
        continue
    ruleData = appbase.getRuleData(data['phone'])
    now_date = time.strftime("%Y-%m-%d %H:%M:%S", time.localtime())
    data = {
        'mobile_number':data['phone'],
        'provice_code':areaData['provice']['ess_code'],
        'provice_name':areaData['provice']['name'],
        'city_code':areaData['city']['ess_code'],
        'city_name':areaData['city']['name'],
        'card_name':'腾讯王卡 - 大王卡',
        'card_id': 1,
        'is_sell':0,
        'data':json.dumps({'area':areaData,'rule':ruleData},ensure_ascii=False),
        'mobile_from':'dsf',
        'created_at':now_date,
        'updated_at':now_date,
    }
    appbase.setDataToDb(data)
    print(data)
appbase.db_location.close()
appbase.db_remote.close()
