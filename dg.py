#!/usr/bin/python3

import json
import requests
import time
import appbase
import sys
import hashlib

serviceKey = 'dg_9309_IQYI4DIKLG29W7J96KXC86YIX'
global card_tel_num
global min_phone_num
global req_count
min_phone_num = 10

def test():
    for provice in appbase.areaDict:
        for city in provice['children']:
            for card in appbase.cards():
                show_name = card['case_name'] +'-'+ card['card_name']
                if(card['case_name'] == card['card_name']):
                    show_name = card['case_name']
                temp_provice = provice.copy()
                del temp_provice['children']
                areaData = {'city':city,'provice':temp_provice}
                data = {
                    'card_name':show_name,
                    'card_id':card['id'],
                    'card_product_id':card['card_product_id'],
                    'areaData':areaData
                }
                yield data

def addSign(params):
    temp_params = params.copy()
    for param in params:
        if temp_params[param] == '' or temp_params[param] == None:
            del temp_params[param]
    temp_params['serviceKey'] = serviceKey
    # print(temp_params)
    sort_params = {}
    for p in sorted(temp_params):
        sort_params[p] = temp_params[p]
    signStr = json.dumps(sort_params,ensure_ascii=False, separators=(',', ':'))
    signStr = signStr.encode("utf-8")
    m = hashlib.md5()
    m.update(signStr)
    sign = m.hexdigest()
    sign = sign.upper()
    sort_params['sign'] = sign
    return sort_params

def request_dg(resData):
    payload = {'searchCategory': '3','searchType':'','searchValue':'','amounts':'20'}
    payload['provinceCode'] = resData['areaData']['provice']['ess_code']
    payload['cityCode'] = resData['areaData']['city']['ess_code']
    payload['goodsId'] = resData['card_product_id']
    payload = addSign(payload)
    headers = {'Content-Type': 'application/json; charset=utf-8'}
    phoneArr = []
    global req_count
    global card_tel_num
    if req_count > 10:
        card_tel_num = min_phone_num + 1
    try:
        r = requests.post(url="https://kingcard.dgunicom.com/dgZop/api/numSelect" , headers = headers, data = json.dumps(payload,ensure_ascii=False) ,timeout=5)
        respData = r.json()
        if r.status_code == 200 and respData['rspCode'] == 'M0':
            for phone in respData['body']['numArray']:
                phone = str(phone)
                if len(phone) == 11:
                    phoneArr.append(phone)
        if respData['rspCode'] == 'M9999':
            card_tel_num = min_phone_num + 1
        if respData['rspCode'] != 'M9999' and respData['rspCode'] != 'M0':
            print(respData['rspCode'])
            sys.exit()
    except Exception as re:
        print('获取失败')
    req_count = req_count + 1
    return tuple(phoneArr)

def selectNum(resData):
    telArr = request_dg(resData)
    global card_tel_num
    for tel in telArr:
        ruleData = appbase.getRuleData(tel)
        if len(ruleData):
            now_date = time.strftime("%Y-%m-%d %H:%M:%S", time.localtime())
            data = {
                'mobile_number':tel,
                'provice_code':resData['areaData']['provice']['ess_code'],
                'provice_name':resData['areaData']['provice']['name'],
                'city_code':resData['areaData']['city']['ess_code'],
                'city_name':resData['areaData']['city']['name'],
                'card_name':resData['card_name'],
                'card_id':resData['card_id'],
                'is_sell':0,
                'data':json.dumps({'area':resData['areaData'],'rule':ruleData},ensure_ascii=False),
                'mobile_from':'dg',
                'created_at':now_date,
                'updated_at':now_date,
            }
            card_tel_num = card_tel_num + 1
            appbase.setDataToDb(data)
    if card_tel_num <= min_phone_num:
        selectNum(resData)

#appbase.deleteOldData('dg')
t = test()
while True:
    try:
        resData = next(t)
        print(resData)
        card_tel_num = 0
        req_count = 0
        selectNum(resData)
    except StopIteration:
        sys.exit()
appbase.db_location.close()
appbase.db_remote.close()