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
    Route::get('/logout', 'HomeController@logout')->name('logout');
    Route::get('/reset-password', 'HomeController@resetPassword');
    Route::post('/reset-password-action', 'HomeController@resetPasswordAction');
    Route::get('/reset-avatar', 'HomeController@resetAvatar');
    Route::post('/reset-avatar-action', 'HomeController@resetAvatarAction');
    Route::get('/edit-profile-view', 'HomeController@editProfileView');
    Route::post('/edit-profile-action', 'HomeController@editProfileAction');

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
            Route::get('/manage-teacher-view', 'StaffController@manageTeacherView')->name('manage-teacher-view');
            Route::get('/manage-student-view', 'StaffController@manageStudentView')->name('manage-student-view');
            Route::get('/manage-guardian-view', 'StaffController@manageGuardianView')->name('manage-guardian-view');
            Route::get('/manage-class-view', 'StaffController@manageClass')->name('manage-class-view');
            Route::get('/manage-finance-view', 'StaffController@manageFinance')->name('manage-finance-view');
            Route::get('/get-all-teacher', 'StaffController@getAllTeacher');
            Route::post('/add-teacher', 'StaffController@addTeacher');
            Route::post('/get-teacher', 'StaffController@getTeacher');
            Route::post('/find-teacher', 'StaffController@findTeacher');
            Route::post('/edit-teacher', 'StaffController@editTeacher');
            Route::post('/delete-teacher', 'StaffController@deleteTeacher');
            Route::get('/get-guardian-teacher', 'StaffController@getGuardianTeacher');
            Route::get('/get-all-class', 'StaffController@getAllClass');
            Route::post('/add-class', 'StaffController@addClass');
            Route::post('/find-class', 'StaffController@findClass');
            Route::post('/edit-class', 'StaffController@editClass');
            Route::post('/delete-class', 'StaffController@deleteClass');
            Route::get('/get-all-guardian', 'StaffController@getAllGuardian');
            Route::get('/get-guardian', 'StaffController@getGuardian');
            Route::post('/add-guardian', 'StaffController@addGuardian');
            Route::post('/find-guardian', 'StaffController@findGuardian');
            Route::post('/edit-guardian', 'StaffController@editGuardian');
            Route::post('/delete-guardian', 'StaffController@deleteGuardian');
            Route::get('/get-all-student/{class_id}', 'StaffController@getAllStudent');
            Route::post('/add-student', 'StaffController@addStudent');
            Route::post('/edit-student', 'StaffController@editStudent');
            Route::get('/find-student/{student_id}', 'StaffController@findStudent');
            Route::get('/delete-student/{student_id}'   , 'StaffController@deleteStudent');
            Route::get('/get-all-student-without-class', 'StaffController@getAllStudentWithoutClass');
            Route::get('/manage-course-view', 'StaffController@manageCourseView')->name('manage-course-view');
            Route::get('/find-course/{id}', 'StaffController@findCourse');
            Route::post('/edit-course', 'StaffController@editCourse');
            Route::post('/delete-course', 'StaffController@deleteCourse');
            Route::post('/add-course', 'StaffController@addCourse');
            Route::get('/get-all-course', 'StaffController@getAllCourse');
        });
        Route::group(['middleware' => 'resetavatar'], function () {
            Route::group(['middleware' => 'teacher', 'prefix' => 'teacher'], function () {
                Route::get('/manage-class-view', 'TeacherController@manageClassView')->name('manage-class-view');
                Route::get('/manage-packet-question-view', 'TeacherController@managePacketQuestionView')->name('manage-packet-question-view');
            });
            Route::group(['middleware' => 'student', 'prefix' => 'student'], function () {

            });
        });
        Route::group(['middleware' => 'guardian', 'prefix' => 'guardian'], function () {

        });
    });

});

Auth::routes();
