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

Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/profile/{username}/pdf', 'Api\EmployeeProfileController@previewPDF');
Route::get('/leaves/{username}/report', 'Api\EmployeeLeaveReportController@reportPDF');
Route::get('/{vue?}', function() {
    return view('index');
})->where('vue', '[\/\w\.-]*')->name('index');
