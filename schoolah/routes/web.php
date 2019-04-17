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

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/get-user-data', 'HomeController@getUserData');
    Route::get('/reset-password', 'HomeController@resetPassword');
    Route::post('/reset-password-action', 'HomeController@resetPasswordAction');
    Route::get('/logout', 'HomeController@logout')->name('logout');

    Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
        Route::get('/manage-school-view', 'AdminController@schoolView')->name('manage-school-view');
        Route::get('/get-all-school', 'AdminController@getAllSchool');
        Route::post('/get-school', 'AdminController@getSchool');
        Route::post('/add-school', 'AdminController@addSchool');
        Route::post('/edit-school', 'AdminController@editSchool');
        Route::post('/delete-school', 'AdminController@deleteSchool');
        Route::post('/get-staff', 'AdminController@getStaff');
        Route::post('/add-staff', 'AdminController@addStaff');
        Route::post('/find-staff', 'AdminController@findStaff');
        Route::post('/edit-staff', 'AdminController@editStaff');
        Route::post('/delete-staff', 'AdminController@deleteStaff');
    });
    Route::group(['middleware' => 'resetpassword'], function () {
        Route::group(['middleware' => 'staff', 'prefix' => 'staff'], function () {
            Route::get('manage-teacher-view', 'StaffController@manageTeacherView')->name('manage-teacher-view');
            Route::get('manage-student-view', 'StaffController@manageStudentView')->name('manage-student-view');
            Route::get('manage-guardian-view', 'StaffController@manageGuardianView')->name('manage-guardian-view');
            Route::get('manage-class-view', 'StaffController@manageClass')->name('manage-class-view');
            Route::get('manage-finance-view', 'StaffController@manageFinance')->name('manage-finance-view');
            Route::get('get-all-teacher', 'StaffController@getAllTeacher');
            Route::post('add-teacher', 'StaffController@addTeacher');
            Route::post('get-teacher', 'StaffController@getTeacher');
            Route::post('edit-teacher', 'StaffController@editTeacher');
            Route::post('delete-teacher', 'StaffController@deleteTeacher');
            Route::get('get-guardian-teacher', 'StaffController@getGuardianTeacher');
            Route::get('get-all-class', 'StaffController@getAllClass');
            Route::post('add-class', 'StaffController@addClass');
            Route::post('find-class', 'StaffController@findClass');
            Route::post('edit-class', 'StaffController@editClass');
            Route::post('delete-class', 'StaffController@deleteClass');
        });
        Route::group(['middleware' => 'teacher', 'prefix' => 'teacher'], function () {

        });
        Route::group(['middleware' => 'student', 'prefix' => 'student'], function () {

        });
        Route::group(['middleware' => 'guardian', 'prefix' => 'guardian'], function () {

        });
    });

});

Auth::routes();
