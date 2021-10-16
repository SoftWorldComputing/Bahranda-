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
Route::domain(env('API_URL'))->group(function() {
    Route::get('/', function() {
        return response(['status' => 'success', 'message' => 'Sorry, you\'re not supposed to be here.']);
    });
Route::prefix('auth')->group(function () {
    // Unprotected routes
    Route::group(['middleware' => 'guest:api'], function () {

        Route::post('login', 'Api\SessionController@loginUser');
        Route::post('signup', 'Api\SessionController@signupUser');
        Route::post('activate', 'Api\SessionController@confirmPin');
        Route::post('forgot-password', 'Api\SessionController@forgotPassword');
        Route::post('check-pin', 'Api\SessionController@checkPin');
        Route::post('change-password', 'Api\SessionController@changePassword');

       
    });
    

});

Route::group(['prefix' => 'front','middleware' => 'guest:api'],function(){
    Route::get('team-members','Api\FrontController@getAllTeamMembers');
    Route::get('faqs','Api\FrontController@getAllFaqs');
    Route::get('reviews','Api\FrontController@getReviews');
    Route::get('privacy','Api\FrontController@getPrivacy');
    Route::get('terms','Api\FrontController@getTerms');
    Route::post('contact-us','Api\FrontController@contactUs');
    Route::post('newsletter','Api\FrontController@subscribeUser');
    Route::get('commodities','Api\FrontController@getCommodities');
});

Route::prefix('user')->name('api.')->group(function () {
    // protected routes
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('home',"Api\UserDashboardController@getUserDashboardInfo")->name('user.dadhboard');

        Route::get('commodities/fetch',"Api\UserCommodityController@fetchActiveCommodities")->name('user.commodities');

        Route::get('commodities/{commodity}/show',"Api\UserCommodityController@getSingleCommodity")->name('user.commodities.show');

        Route::get('commodities/{commodity}/{quantity}/calculate',"Api\UserCommodityController@calculateCommodityPrice")->name('user.commodities.calculate');

        Route::get('commodities/related-commodities',"Api\UserCommodityController@getRelatedCommodity")->name('user.commodities.related');

        Route::post('commodities/purchase',"Api\UserCommodityController@purchase")->name('user.commodities.purchase');


        Route::post('commodities/purchase_from_wallet',"Api\UserCommodityController@purchaseFromWallet")->name('user.commodities.purchase_from_wallet');

        

        
        Route::group(["prefix" =>"deals"],function(){
                Route::get('all','Api\UserDealsController@fetchAllDeals');
                Route::get('{deal}/show','Api\UserDealsController@getSingleDeal');
                
        });

        Route::group(["prefix" =>"wallet"],function(){
            Route::get('','Api\UserWalletController@getUserWallet');
           
            Route::get('wallet-history','Api\UserWalletController@getWalletHistory');

            Route::get('wallet-requests','Api\UserWalletController@getWalletRequest');

            Route::post('request-withdrawal','Api\UserWalletController@requestWithdrawal');

            Route::patch('set-pin','Api\UserWalletController@setPin');

            Route::patch('account-information','Api\UserWalletController@updateAccountInfo');

            Route::post('fund-wallet','Api\UserWalletController@fundWallet');
       });

       Route::group(["prefix" =>"profile"],function(){

           Route::get('','Api\UserProfileController@getUserProfile');

          Route::patch('update','Api\UserProfileController@updateProfile');

          Route::patch('password/change','Api\UserProfileController@changePassword');

       });

     
        
    });



});
});