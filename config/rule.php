<?php
return [[
	"ze_order" => "1",
	"ze_name" => "AAA",
	"ze_rule" => '.*(.)\\1{2}.*',
	"ze_status" => "1",	
], [
	"ze_order" => "2",
	"ze_name" => "AAAA",
	"ze_rule" => ".*(\d)\\1{3}.*",
	"ze_status" => "1",	
], [
	"ze_order" => "3",
	"ze_name" => "AAAAA",
	"ze_rule" => ".*\d{6}([0-9])\\1{4}.*",
	"ze_status" => "1",	
], [
	"ze_order" => "5",
	"ze_name" => "结尾AA",
	"ze_rule" => ".*\d{8}([0-9])(?!\\1)([0-9])\\2{1}.*",
	"ze_status" => "1",

], [
	"ze_order" => "6",
	"ze_name" => "结尾AAA",
	"ze_rule" => ".*\d{7}([0-9])(?!\\1)([0-9])\\2{2}.*",
	"ze_status" => "1",
], [
	"ze_order" => "7",
	"ze_name" => "结尾AAAA",
	"ze_rule" => ".*\d{6}([0-9])(?!\\1)([0-9])\\2{3}.*",
	"ze_status" => "1",	
], [
	"ze_order" => "8",
	"ze_name" => "结尾AABB",
	"ze_rule" => ".*\d{6}([0-9])(?!\\1)([0-9])\\2(?!\\2)([0-9])\\3.*",
	"ze_status" => "1",	
], [
	"ze_order" => "10",
	"ze_name" => "结尾ABAB",
	"ze_rule" => ".*\d{6}([0-9])(?!\\1)([0-9])\\2(?!\\2)([0-9])\\3.*",
	"ze_status" => "1",	
], [
	"ze_order" => "14",
	"ze_name" => "结尾AAAB",
	"ze_rule" => ".*\d{6}([0-9])(?!\\1)([0-9])\\2{2}(?!\\2)([0-9]).*",
	"ze_status" => "1",	
], [
	"ze_order" => "22",
	"ze_name" => "不带4和7",
	"ze_rule" => "(0|1|2|3|5|6|8|9){11}",
	"ze_status" => "1",
], [
	"ze_order" => "24",
	"ze_name" => "不带4",
	"ze_rule" => "(0|1|2|3|5|6|7|8|9){11}",
	"ze_status" => "1",
], [
	"ze_order" => "41",
	"ze_name" => "结尾ABC",
	"ze_rule" => "\d{7}([0-9]012|[^0]123|[^1]234|[^2]345|[^3]456|[^4]567|[^5]678|[^6]789)",
	"ze_status" => "1",	
], [
	"ze_order" => "42",
	"ze_name" => "结尾ABCD",
	"ze_rule" => "\d{6}([0-9]0123|[^0]1234|[^1]2345|[^2]3456|[^3]4567|[^4]5678|[^5]6789)",
	"ze_status" => "1",	
], [
	"ze_order" => "43",
	"ze_name" => "结尾ABCDABCD",
	"ze_rule" => "([\d]{4})\\1$",
	"ze_status" => "1",	
], [
	"ze_order" => "44",
	"ze_name" => "AAAB",
	"ze_rule" => "(.)\\1\\1.$",
	"ze_status" => "1",	
], [
	"ze_order" => "45",
	"ze_name" => "ABCD",
	"ze_rule" => "(?:0(?=1)|1(?=2)|2(?=3)|3(?=4)|4(?=5)|5(?=6)|6(?=7)|7(?=8)|8(?=9)){3}\d",
	"ze_status" => "1",	
], [
	"ze_order" => "46",
	"ze_name" => "AABB",
	"ze_rule" => "(.)\\1(.)\\2",
	"ze_status" => "1",	
], [
	"ze_order" => "47",
	"ze_name" => "ABAB",
	"ze_rule" => "(\w\w)(\\1)",
	"ze_status" => "1",	
], [
	"ze_order" => "48",
	"ze_name" => "ABC",
	"ze_rule" => "(1\d{2})\d{5}(?:0(?=1)|1(?=2)|2(?=3)|3(?=4)|4(?=5)|5(?=6)|6(?=7)|7(?=8)|8(?=9)){2}\d",
	"ze_status" => "1",
	
], [
	"ze_order" => "49",
	"ze_name" => "*AAA*",
	"ze_rule" => "\d([0-9])(?!\\1)([0-9])\\2{2}\d",
	"ze_status" => "1",	
], [
	"ze_order" => "50",
	"ze_name" => "AAAABA",
	"ze_rule" => "(.)\\1\\1\\1.\\1",
	"ze_status" => "1",	
], [
	"ze_order" => "51",
	"ze_name" => "结尾AAABA",
	"ze_rule" => "(.)\\1\\1.\\1$",
	"ze_status" => "1",	
], [
	"ze_order" => "52",
	"ze_name" => "ABABAB",
	"ze_rule" => "(.)(.)\\1\\2\\1\\2",
	"ze_status" => "1",	
], [
	"ze_order" => "53",
	"ze_name" => "AAABBB",
	"ze_rule" => "(.)\\1\\1(.)\\2\\2",
	"ze_status" => "1",	
], [
	"ze_order" => "54",
	"ze_name" => "AABBBB",
	"ze_rule" => "(.)\\1(.)\\2\\2\\2",
	"ze_status" => "1",	
], [
	"ze_order" => "55",
	"ze_name" => "AABAAA",
	"ze_rule" => "(.)\\1.\\1\\1\\1",
	"ze_status" => "1",	
], [
	"ze_order" => "56",
	"ze_name" => "AAAABAA",
	"ze_rule" => "(.)\\1\\1\\1.\\1\\1",
	"ze_status" => "1",	
], [
	"ze_order" => "57",
	"ze_name" => "AAAABB",
	"ze_rule" => "(.)\\1\\1\\1(.)\\2",
	"ze_status" => "1",	
], [
	"ze_order" => "58",
	"ze_name" => "AAABAAAB",
	"ze_rule" => "(.)\\1\\1.(.)\\2\\2.",
	"ze_status" => "1",	
], [
	"ze_order" => "59",
	"ze_name" => "假山1",
	"ze_rule" => "..(.{3}).\\1.",
	"ze_status" => "1",	
], [
	"ze_order" => "60",
	"ze_name" => "假山2",
	"ze_rule" => "...(.{3}).\\1",
	"ze_status" => "1",	
], [
	"ze_order" => "61",
	"ze_name" => "中间EDCBA",
	"ze_rule" => ".+(98765|87654|76543|65432|54321|43210).+",
	"ze_status" => "1",	
], [
	"ze_order" => "62",
	"ze_name" => "AAABB",
	"ze_rule" => "(.)\\1\\1(.)\\2",
	"ze_status" => "1",	
], [
	"ze_order" => "63",
	"ze_name" => "BBAAA",
	"ze_rule" => "(.)\\1(.)\\2\\2",
	"ze_status" => "1",	
], [
	"ze_order" => "64",
	"ze_name" => "AABBBBAA",
	"ze_rule" => "(.)(.)(.)(.)\\3\\4\\1\\2$",
	"ze_status" => "1",	
], [
	"ze_order" => "65",
	"ze_name" => "结尾AAAABA",
	"ze_rule" => "(.)\\1\\1\\1.\\1$",
	"ze_status" => "1",	
], [
	"ze_order" => "66",
	"ze_name" => "回旋号",
	"ze_rule" => "(.)(.)(.)(.)\\4\\3\\2\\1$",
	"ze_status" => "1",	
], [
	"ze_order" => "67",
	"ze_name" => "AAABBA",
	"ze_rule" => "(.)\\1\\1(.)\\2\\1$",
	"ze_status" => "1",	
], [
	"ze_order" => "68",
	"ze_name" => "结尾ABCABC",
	"ze_rule" => "(.)(.)(.)\\1\\2\\3$",
	"ze_status" => "1",	
], [
	"ze_order" => "69",
	"ze_name" => "AABBCC",
	"ze_rule" => "(.)\\1(.)\\2(.)\\3",
	"ze_status" => "1",	
], [
	"ze_order" => "70",
	"ze_name" => "风水号",
	"ze_rule" => "(1349|191413|131419|141319)$",
	"ze_status" => "1",	
], [
	"ze_order" => "71",
	"ze_name" => "中间ABCDE",
	"ze_rule" => ".+(01234|12345|23456|34567|45678|56789).+",
	"ze_status" => "1",	
], [
	"ze_order" => "72",
	"ze_name" => "AABBCCDD",
	"ze_rule" => "(.)\\1(.)\\2(.)\\3(.)\\4",
	"ze_status" => "1",	
], [
	"ze_order" => "73",
	"ze_name" => "666*6",
	"ze_rule" => "(6)\\1\\1.\\1$",
	"ze_status" => "1",	
], [
	"ze_order" => "74",
	"ze_name" => "领导号",
	"ze_rule" => "(0)\\1\\1.\\1$",
	"ze_status" => "1",	
], [
	"ze_order" => "75",
	"ze_name" => "发财号",
	"ze_rule" => "(8)\\1\\1.\\1$",
	"ze_status" => "1",	
], [
	"ze_order" => "76",
	"ze_name" => "结尾AABB",
	"ze_rule" => "\d{6}([0-9])(?!\\1)([0-9])\\2(?!\\2)([0-9])\\3",
	"ze_status" => "1",	
], [
	"ze_order" => "77",
	"ze_name" => "AAABAA",
	"ze_rule" => "(.)\\1\\1.\\1\\1",
	"ze_status" => "1",	
], [
	"ze_order" => "78",
	"ze_name" => "ABCABCABC",
	"ze_rule" => "(.)(.)(.)\\1\\2\\3\\1\\2\\3",
	"ze_status" => "1",	
], [
	"ze_order" => "79",
	"ze_name" => "结尾ABBA",
	"ze_rule" => "\d{7}([0-9])(?!\\1)([0-9])\\2\\1",
	"ze_status" => "1",	
], [
	"ze_order" => "81",
	"ze_name" => "结尾ABBABB",
	"ze_rule" => "\d{5}([0-9])(?!\\1)([0-9])\\2\\1\\2\\2",
	"ze_status" => "1",	
], [
	"ze_order" => "82",
	"ze_name" => "*AAAAA*",
	"ze_rule" => "\d([0-9])(?!\\1)([0-9])\\2{4}\d",
	"ze_status" => "1",	
], [
	"ze_order" => "83",
	"ze_name" => "结尾AABBCC",
	"ze_rule" => "\d{4}([0-9])(?!\\1)([0-9])\\2(?!\\2)([0-9])\\3(?!\\3)([0-9])\\4",
	"ze_status" => "1",	
], [
	"ze_order" => "84",
	"ze_name" => "结尾AABBCCDD",
	"ze_rule" => "\d{3}([0-9])\\1([0-9])\\2([0-9])\\3([0-9])\\4",
	"ze_status" => "1",	
], [
	"ze_order" => "85",
	"ze_name" => "大山ABCDEABCDE",
	"ze_rule" => "(.)(.)(.)(.)(.)\\1\\2\\3\\4\\5",
	"ze_status" => "1",	
], [
	"ze_order" => "86",
	"ze_name" => "结尾ABAA",
	"ze_rule" => "(.).\\1{2}$",
	"ze_status" => "1",	
], [
	"ze_order" => "87",
	"ze_name" => "AB**AB**",
	"ze_rule" => "\d{3}(\d{2})(?!\\1)(\d{2})\\1(\d{2})",
	"ze_status" => "1",	
], [
	"ze_order" => "88",
	"ze_name" => "结尾88",
	"ze_rule" => "\d{9}(88)",
	"ze_status" => "1",	
], [
	"ze_order" => "89",
	"ze_name" => "生日类",
	"ze_rule" => "\d{7}(?:0[13578]|1[02])(?:0[1-9]|[12]\d|3[01])|(?:0[469]|11)(?:0[1-9]|[12]\d|30)|02(?:0[1-9]|1\d|2[0-8])",
	"ze_status" => "1",
], [
	"ze_order" => "91",
	"ze_name" => "ABCDE",
	"ze_rule" => "\d{6}(01234|12345|23456|34567|45678|56789)",
	"ze_status" => "1",	
], [
	"ze_order" => "92",
	"ze_name" => "EDCBA",
	"ze_rule" => "\d{6}(43210|54321|65432|76543|87654|98765)",
	"ze_status" => "1",	
], [
	"ze_order" => "93",
	"ze_name" => "7拖1",
	"ze_rule" => "\d{2}([0-9])(?!\\1)([0-9])\\2{6}(?!\\2)([0-9])",
	"ze_status" => "1",	
], [
	"ze_order" => "94",
	"ze_name" => "**AB**AB",
	"ze_rule" => "\d{5}(\d{2})(?!\\1)(\d{2})\\1",
	"ze_status" => "1",	
], [
	"ze_order" => "95",
	"ze_name" => "7拖2",
	"ze_rule" => "\d{1}([0-9])(?!\\1)([0-9])\\2{6}(?!\\2)([0-9])\\3",
	"ze_status" => "1",	
], [
	"ze_order" => "96",
	"ze_name" => "8拖1",
	"ze_rule" => "\d{1}([0-9])(?!\\1)([0-9])\\2{7}(?!\\2)([0-9])",
	"ze_status" => "1",	
], [
	"ze_order" => "97",
	"ze_name" => "6拖2 AAAAAABB",
	"ze_rule" => "\d{2}([0-9])(?!\\1)([0-9])\\2{5}(?!\\2)([0-9])\\3",
	"ze_status" => "1",	
], [
	"ze_order" => "98",
	"ze_name" => "6拖1 AAAAAAB",
	"ze_rule" => "\d{3}([0-9])(?!\\1)([0-9])\\2{5}(?!\\2)([0-9])",
	"ze_status" => "1",	
], [
	"ze_order" => "99",
	"ze_name" => "年份类",
	"ze_rule" => "\d{7}((19[5-9][0-9])|(20[0-1][0-9]))",
	"ze_status" => "1",	
], [
	"ze_order" => "100",
	"ze_name" => "4拖2 AAAABB",
	"ze_rule" => "\d{4}([0-9])(?!\\1)([0-9])\\2{3}(?!\\2)([0-9])\\3",
	"ze_status" => "1",	
], [
	"ze_order" => "101",
	"ze_name" => "4拖1 AAAAB",
	"ze_rule" => "\d{5}([0-9])(?!\\1)([0-9])\\2{3}(?!\\2)([0-9])",
	"ze_status" => "1",	
], [
	"ze_order" => "102",
	"ze_name" => "5拖2 AAAAAB",
	"ze_rule" => "\d{3}([0-9])(?!\\1)([0-9])\\2{4}(?!\\2)([0-9])\\3",
	"ze_status" => "1",	
], [
	"ze_order" => "103",
	"ze_name" => "5拖1 AAAAAB",
	"ze_rule" => "\d{4}([0-9])(?!\\1)([0-9])\\2{4}(?!\\2)([0-9])",
	"ze_status" => "1",	
], [
	"ze_order" => "104",
	"ze_name" => "结尾66",
	"ze_rule" => "\d{9}(66)",
	"ze_status" => "1",	
], [
	"ze_order" => "105",
	"ze_name" => "双豹子1",
	"ze_rule" => "(.)\\1\\1..(.)\\2\\2.",
	"ze_status" => "1",	
], [
	"ze_order" => "106",
	"ze_name" => "双豹子2",
	"ze_rule" => "(.)\\1\\1...(.)\\2\\2.",
	"ze_status" => "1",	
], [
	"ze_order" => "107",
	"ze_name" => "ABABXXAB",
	"ze_rule" => "(.)(.)\\1\\2..\\1\\2$",
	"ze_status" => "1",	
], [
	"ze_order" => "112",
	"ze_name" => "AABBCCDDEE",
	"ze_rule" => "\d{3}([0-9])\\1([0-9])\\2([0-9])\\3([0-9])\\4",
	"ze_status" => "1",	
], [
	"ze_order" => "114",
	"ze_name" => "*AAAA*",
	"ze_rule" => ".*\d([0-9])(?!\\1)([0-9])\\2{3}\d.*",
	"ze_status" => "1",	
], [
	"ze_order" => "115",
	"ze_name" => "AAAAAA",
	"ze_rule" => "\d{5}([0-9])\\1{5}",
	"ze_status" => "1",	
], [
	"ze_order" => "116",
	"ze_name" => "AAABCBC",
	"ze_rule" => "(.)\\1\\1(.)(.)\\2\\3",
	"ze_status" => "1",	
], [
	"ze_order" => "117",
	"ze_name" => "AABB-ABBA",
	"ze_rule" => "(.)\\1(.)\\2(.)(.)\\4\\3$",
	"ze_status" => "1",	
], [
	"ze_order" => "118",
	"ze_name" => "ABABAAA",
	"ze_rule" => "(.)(.)\\1\\2(.)\\3\\3",
	"ze_status" => "1",	
], [
	"ze_order" => "121",
	"ze_name" => "全段0-3",
	"ze_rule" => "(0|1|2|3){11}",
	"ze_status" => "1",
], [
	"ze_order" => "123",
	"ze_name" => "全段1\/3\/6",
	"ze_rule" => "(1|3|6){11}",
	"ze_status" => "1"
]];
