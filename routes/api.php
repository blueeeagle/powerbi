<?php
header('Access-Control-Allow-Origin: *');
header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );

Route::group(['prefix' => 'v1',  'namespace' => 'Api\V1'], function () {
    
    //Route::get('apikey', 'UsersController@getApiKey');
    //Route::middleware('api_key')->group(function () { 
        Route::apiResource('users', 'UsersController');
        Route::post('login', 'UsersController@login');        
        Route::apiResource('/report', 'ReportController')->only(['index', 'show']); 
        Route::apiResource('/twomodelstrack', 'TwoModelsTrackController')->only(['index', 'show']);  
        Route::middleware('auth:api')->group(function () {            
            
            //Route::apiResource('/report', 'ReportController')->only(['index', 'show']);                                        
            
        });
    //});    
});
