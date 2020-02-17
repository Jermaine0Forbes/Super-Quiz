<?php

use Illuminate\Http\Request;

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

Route::prefix("question")->group(function(){
  Route::post("/search", "QuestionAPIController@queryQuest");
  Route::get("/filter","QuestionAPIController@getFilter");
  Route::get("/{id}", "QuestionAPIController@getAJAX");
});
