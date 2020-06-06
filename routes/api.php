<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(["prefix" => "partners"], function () {
    Route::get("list", "PartnerListController@__invoke");
    Route::get("{idPartner}/find", "PartnerGetController@__invoke");
    Route::get("{idPartner}/delete", "PartnerDeleteController@__invoke");
    Route::post("save", "PartnerPostController@__invoke");
    Route::post("update", "PartnerUpdateController@__invoke");
});

Route::group(["prefix" => "menus"], function () {
    Route::post("save", "Menu\MenuPostController@__invoke");
    Route::get("{idMenu}/find", "Menu\MenuGetController@__invoke");
    Route::get("{idMenu}/delete", "Menu\MenuDeleteController@__invoke");
});
