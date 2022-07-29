<?php

Auth::routes();

Route::get('/','Admin\HomeController@index')->name('home');


Route::get('/PhoneBillOrder/list','Admin\PhoneBillOrderController@index')->name('PhoneBillOrderList');
Route::post('/PhoneBillOrder/del/{id}','Admin\PhoneBillOrderController@del')->name('PhoneBillOrderDel');
Route::get('/PhoneCardOrder/list','Admin\PhoneCardOrderController@index')->name('PhoneCardOrderList');
Route::post('/PhoneCardOrder/reset','Admin\PhoneCardOrderController@resetAction')->name('PhoneCardOrderResetAction');

Route::get('/Suggest/list','Admin\SuggestController@list')->name('SuggestList');

// Route::get('/BillCase/list','Admin\PhoneBillOrderController@caseList')->name('BillCaseList');
// Route::post('/BillCase/edit/{oid}','Admin\PhoneBillOrderController@caseEdit')->name('BillcaseEdit');
// Route::post('/BillCase/add','Admin\PhoneBillOrderController@caseAdd')->name('BillcaseAdd');
// Route::post('/BillCase/reset','Admin\PhoneBillOrderController@caseReset')->name('BillcaseReset');
// Route::post('/BillCase/del/{id}','Admin\PhoneBillOrderController@caseDel')->name('BillcaseDel');

Route::get('/Bill/list','Admin\BillController@index')->name('Bill');
Route::post('/Bill/action/{action}','Admin\BillController@action')->name('BillAction');
Route::post('/Bill/del/{id}','Admin\BillController@delAction')->name('BillDelAction');
Route::post('/Bill/edit/{oid}','Admin\BillController@caseEdit')->name('BillEdit');
Route::post('/Bill/add','Admin\BillController@caseAdd')->name('BillAdd');
Route::post('/Bill/reset','Admin\BillController@caseReset')->name('BillReset');
Route::post('/Bill/checkPrice','Admin\BillController@checkPrice')->name('BillCheckPrice');
Route::any('/Bill/sysBillData','Admin\BillController@sysBillData')->name('BillSysBillData');

Route::get('/Card/list','Admin\CardController@index')->name('Card');
Route::post('/Card/action/{action}','Admin\CardController@action')->name('CardAction');
Route::post('/Card/del/{id}','Admin\CardController@delAction')->name('CardDelAction');

Route::get('/WebUser/list', 'Admin\WebUserController@list')->name('WebUser');
Route::post('/WebUser/edit/{id}', 'Admin\WebUserController@edit')->name('WebUserEdit');

Route::get('/UserSellOrder/list', 'Admin\UserSellOrderController@list')->name('UserSellOrder');
Route::post('/UserSellOrder/edit/{id}', 'Admin\UserSellOrderController@edit')->name('UserSellOrderEdit');
Route::post('/UserSellOrder/del/{id}', 'Admin\UserSellOrderController@del')->name('UserSellOrderDel');

Route::get('/UserTiXian/list', 'Admin\UserTiXianController@list')->name('UserTiXian');
Route::post('/UserTiXian/edit/{id}', 'Admin\UserTiXianController@edit')->name('UserTiXianEdit');

Route::get('/Setting/index','Admin\SettingController@index')->name('SettingIndex');
Route::post('/Setting/index/{type}','Admin\SettingController@indexAction')->name('SettingIndexAction');
Route::post('/Setting/upload','Admin\SettingController@uploadAction')->name('SettinguploadAction');

Route::post('/upload','Admin\Controller@uploadAction')->name('uploadAction');

Route::get('/test','Admin\Controller@test')->name('test');