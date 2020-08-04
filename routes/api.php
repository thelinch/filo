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

Route::group(["prefix" => "files"], function () {
    Route::get("/find", "File\FileGetController@__invoke");
    Route::get("/delete", "File\FileDeleteController@__invoke");
    Route::post("/save", "File\FileSaveController@__invoke");


    /* Route::post("/save"); */
});
Route::group(["prefix" => "partners"], function () {
    Route::get("list", "PartnerListController@__invoke");
    Route::get("{categoryId}/list", "PartnerFindCategoryController@__invoke");

    Route::get("get", "PartnerGetController@__invoke");
    Route::get("{idPartner}/transactions", "Transaction\TransactionFindByPartnerController@__invoke");
    Route::get("{partnerId}/products", "Menu\MenuListController@__invoke");
    Route::post("{partnerId}/deleteWorkday", "PartnerDeleteWorkDayController@__invoke");
    Route::post("{partnerId}/addAndUpdateWorkDay", "PartnerAddWorkDayController@__invoke");
    Route::get("{idPartner}/delete", "PartnerDeleteController@__invoke");
    Route::post("save", "PartnerPostController@__invoke");
    Route::post("update", "PartnerUpdateController@__invoke");
});

Route::group(["prefix" => "products"], function () {
    Route::post("save", "Menu\MenuPostController@__invoke");
    Route::get("{idMenu}/find", "Menu\MenuGetController@__invoke");
    Route::post("{idMenu}/update", "Menu\MenuUpdateController@__invoke");
    Route::get("{idMenu}/deletePhoto", "Menu\MenuDeletePhotoController@__invoke");
    Route::get("{idMenu}/delete", "Menu\MenuDeleteController@__invoke");
    Route::get("{idMenu}/incrementVotes", "Menu\MenuUpdateVotesController@__invoke");
});

Route::group(["prefix" => "users"], function () {
    Route::post("save", "User\UserPostController@__invoke")->name("register");
    Route::post("login", "User\UserLoginController@__invoke")->name("login");
    Route::post("update", "User\UserUpdateController@__invoke");
    Route::get("{idUser}/find", "User\UserGetController@__invoke");
    Route::get("me", "User\UserAuthController@__invoke");
    Route::get("{idUser}/delete", "User\UserDeleteController@__invoke");
});
Route::group(["prefix" => "transactions"], function () {
    Route::post("save", "Transaction\TransactionPostController@__invoke");
    Route::get("{transactionId}/cancelled", "Transaction\TransactionCancelledGetController@__invoke");
    Route::get("{transactionId}/onMyWay", "Transaction\TransactionStateOnMyWayController@__invoke");
    Route::get("{transactionId}/attended", "Transaction\TransactionStateAttendedController@__invoke");
});
Route::group(["prefix" => "categories"], function () {
    Route::get("all", "Category\CategoryGetController@__invoke");
});
