<?php

Route::group(['middleware' => ['api']], function(){
    Route::post('/auth/signup','AuthController@signup');
    Route::post('/auth/signin','AuthController@signin');
    Route::post('/auth/logout','AuthController@logout');
    Route::get('/tutorial','TutorialController@index');
    Route::get('/tutorial/{id}','TutorialController@show');

    Route::group(['middleware' => ['auth']], function(){
        Route::post('/auth/refresh','AuthController@refresh');
        Route::post('/me','AuthController@me');

        //----ROUTE TUTORIAL---
        Route::post('/tutorial','TutorialController@create');
        Route::put('/tutorial/update/{id}','TutorialController@update');
        Route::delete('/tutorial/delete/{id}','TutorialController@delete');

         //----ROUTE COMMENT---
         Route::post('/comment/{id_tutorial}','CommentController@create');
    });

});
