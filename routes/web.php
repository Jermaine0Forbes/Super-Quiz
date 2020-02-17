<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', "QuizController@index")->name("home");

Route::get("/get", "TestController@get");

Route::prefix("quiz")->group(function(){
  Route::get('/', "QuizController@preQuiz")->name("quiz");
  Route::get('/get', "QuizController@startQuiz")->name("quiz.start");
  Route::post('/store', "QuizController@storeQuiz")->name("store_quiz");
  Route::get('/index/{id}', "QuizController@showQuiz")->name("index_quiz");

});


Route::prefix("questions")->group(function(){
  Route::get("/","QuestionController@index")->name("quest.list");
  Route::post("/getSubsects","QuestionController@getSubsect");
  Route::get("/{id}","QuestionController@showQuest");
  // Route::get("/{id}/ajax","QuestionController@getAJAX");
});

Route::prefix("subsections")->group(function(){
  Route::get("/", "SubsectionController@index")->name("sub.list");
  Route::get("/create", "SubsectionController@createSubsect")->name("sub.create");
  Route::get("/create/ajax", "SubsectionController@createSubsectAJAX")->name("sub.create.ajax");
  Route::post("/store", "SubsectionController@storeSubsect")->name("sub.store");
  Route::post("/store/ajax", "SubsectionController@storeSubsectAJAX")->name("sub.store.ajax");
  Route::get("/edit/{id}", "SubsectionController@editSubsect")->name("sub.edit");
  Route::post("/update/{id}", "SubsectionController@updateSubsect")->name("sub.update");
  Route::get("/{id}", "SubsectionController@showSubsect")->name("sub.show");
});


Route::prefix("question")->group(function(){
  Route::get("create","QuestionController@createQuest")->name("quest.create");
  Route::get("create/ajax","QuestionController@createQuestAJAX")->name("quest.create.ajax");
  Route::post("store","QuestionController@storeQuest")->name("store");
  Route::post("store/ajax","QuestionController@storeQuestAJAX")->name("store.ajax");
  Route::get("edit/{id}","QuestionController@editQuest")->name("edit");
  Route::post("update/{id}","QuestionController@updateQuest")->name("update");
  Route::get("delete/{id}","QuestionController@deleteQuest")->name("delete");
});
