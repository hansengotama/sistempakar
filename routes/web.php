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

Route::group(['middleware' => 'notlogin'], function () {
    Route::get('/', 'HomeController@loginPage')->name('login-page');
});

Route::get('/logout', 'HomeController@logout');
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/home-admin', 'AdminController@home')->name('home-admin');
        Route::get('/disease-view', 'AdminController@diseaseView')->name('disease-view');
        Route::get('/get-disease', 'AdminController@getDisease');
        Route::get('/get-disease/{id}', 'AdminController@getDiseaseById');
        Route::post('/add-disease', 'AdminController@addDisease');
        Route::post('/edit-disease', 'AdminController@editDisease');
        Route::post('/delete-disease', 'AdminController@deleteDisease');
        Route::get('/solution-view', 'AdminController@solutionView')->name('solution-view');
        Route::get('/get-solutions', 'AdminController@getSolutions');
        Route::get('/get-solution/{id}', 'AdminController@getSolutionById');
        Route::post('/add-solution', 'AdminController@addSolution');
        Route::post('/edit-solution', 'AdminController@editSolution');
        Route::post('/delete-solution', 'AdminController@deleteSolution');
        Route::get('/question-view', 'AdminController@questionView')->name('question-view');
        Route::get('/get-questions', 'AdminController@getQuestions');
        Route::get('/get-question-disease/{disease_id}', 'AdminController@getQuestionByDiseaseId');
        Route::get('/get-question/{id}', 'AdminController@getQuestionById');
        Route::post('/add-question', 'AdminController@addQuestion');
        Route::post('/edit-question', 'AdminController@editQuestion');
        Route::post('/delete-question', 'AdminController@deleteQuestion');
        Route::get('/patient list-view', 'AdminController@patientListView')->name('patient-list-view');
        Route::get('/get-list-patients', 'AdminController@getListPatients');
        Route::get('/disease-solution-view', 'AdminController@diseaseSolutionView')->name('disease-solution-view');
        Route::get('/get-disease-solutions', 'AdminController@getDiseaseSolutions');
        Route::get('/get-disease-solution/{id}', 'AdminController@getDiseaseSolutionById');
        Route::post('/add-disease-solution', 'AdminController@addDiseaseSolution');
        Route::post('/edit-disease-solution', 'AdminController@editDiseaseSolution');
        Route::post('/delete-disease-solution', 'AdminController@deleteDiseaseSolution');
    });

    Route::group(['middleware' => 'patient'], function () {
        Route::get('/home-patient', 'PatientController@home')->name('home-patient');
        Route::get('/consultation-view', 'PatientController@consultationView')->name('consultation-view');
    });
});