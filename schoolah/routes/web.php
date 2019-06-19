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
    Route::get('/logout', 'HomeController@logout')->name('logout');
    Route::get('/get-user-data', 'HomeController@getUserData');
    Route::get('/reset-password', 'HomeController@resetPassword');
    Route::post('/reset-password-action', 'HomeController@resetPasswordAction');
    Route::get('/reset-avatar', 'HomeController@resetAvatar');
    Route::post('/reset-avatar-action', 'HomeController@resetAvatarAction');
    Route::get('/edit-profile-view', 'HomeController@editProfileView');
    Route::post('/add-feedback', 'HomeController@addFeedback');
    Route::post('/edit-profile-action', 'HomeController@editProfileAction');

    Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/manage-school-view', 'AdminController@schoolView')->name('manage-school-view');
        Route::get('/feedback-view', 'AdminController@feedbackView')->name('feedback-view');
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
        Route::get('/get-all-feedback', 'AdminController@getAllFeedback');
        Route::post('/delete-feedback', 'AdminController@deleteFeedback');
    });
    Route::group(['middleware' => 'resetpassword'], function () {
        Route::group(['middleware' => 'staff', 'prefix' => 'staff'], function () {
            Route::get('/', 'HomeController@index')->name('home');
            Route::get('/manage-teacher-view', 'StaffController@manageTeacherView')->name('manage-teacher-view');
            Route::get('/manage-student-view', 'StaffController@manageStudentView')->name('manage-student-view');
            Route::get('/manage-guardian-view', 'StaffController@manageGuardianView')->name('manage-guardian-view');
            Route::get('/manage-class-view', 'StaffController@manageClassView')->name('staff-manage-class-view');
            Route::get('/manage-class-schedule-view', 'StaffController@manageClassScheduleView')->name('staff-manage-class-schedule-view');
            Route::get('/manage-packet-view', 'StaffController@managePacketView')->name('manage-packet-view');
            Route::get('/manage-course-view', 'StaffController@manageCourseView')->name('manage-course-view');
            Route::get('/manage-schedule-shift-view', 'StaffController@manageScheduleShiftView')->name('manage-schedule-shift-view');
            Route::get('/manage-tuition-view', 'StaffController@manageTuitionView')->name('manage-tuition-view');
            Route::get('/manage-period-view', 'StaffController@managePeriodView')->name('manage-period-view');
            Route::get('/get-all-teacher', 'StaffController@getAllTeacher');
            Route::post('/add-teacher', 'StaffController@addTeacher');
            Route::post('/get-teacher', 'StaffController@getTeacher');
            Route::post('/find-teacher', 'StaffController@findTeacher');
            Route::get('/find-teacher-by-user-id/{user_id}', 'StaffController@findTeacherByUserId');
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
            Route::get('/get-student/{id}', 'StaffController@getStudent');
            Route::get('/get-student-class/{id}', 'StaffController@getStudentClass');
            Route::post('/add-student-class', 'StaffController@addStudentClass');
            Route::post('/remove-student-class', 'StaffController@removeStudentClass');
            Route::get('/find-course/{id}', 'StaffController@findCourse');
            Route::post('/edit-course', 'StaffController@editCourse');
            Route::post('/delete-course', 'StaffController@deleteCourse');
            Route::post('/add-course', 'StaffController@addCourse');
            Route::get('/get-all-course', 'StaffController@getAllCourse');
            Route::post('/add-teacher-class-course', 'StaffController@addTeacherClassCourse');
            Route::get('/get-teacher-class-course/{class_id}', 'StaffController@getTeacherClassCourse');
            Route::get('/get-all-course-class/{class_id}', 'StaffController@getAllCourseClass');
            Route::post('/remove-teacher-class-course/{teacher_course_id}', 'StaffController@removeTeacherClassCourse');
            Route::get('/get-all-course-for-option', 'StaffController@getAllCourseForOption');
            Route::get('/get-all-teacher-for-option/{packet_id}', 'StaffController@getAllTeacherForOption');
            Route::post('/add-packet', 'StaffController@addPacket');
            Route::post('/edit-packet', 'StaffController@editPacket');
            Route::post('/delete-packet', 'StaffController@deletePacket');
            Route::get('/get-all-packet', 'StaffController@getAllPacket');
            Route::get('/get-all-exam-packet', 'StaffController@getAllExamPacket');
            Route::get('/get-packet/{packet_id}', 'StaffController@getPacketById');
            Route::get('/get-packet-contributor/{packet_id}', 'StaffController@getPacketContributor');
            Route::get('/get-teacher-name-by-teacher-id/{teacher_id}', 'StaffController@getTeacherNameByTeacherId');
            Route::post('/add-packet-contributor', 'StaffController@addPacketContributor');
            Route::post('/delete-packet-contributor', 'StaffController@deletePacketContributor');
            Route::post('/add-schedule-shift', 'StaffController@addScheduleShift');
            Route::post('/edit-schedule-shift', 'StaffController@editScheduleShift');
            Route::post('/delete-schedule-shift', 'StaffController@deleteScheduleShift');
            Route::get('/get-all-schedule-shift', 'StaffController@getAllScheduleShift');
            Route::post('/get-schedule-shift', 'StaffController@getScheduleShift');
            Route::get('/get-selected-course/{day}/{shift}/{class_id}', 'StaffController@getSelectedCourse');
            Route::post('/add-schedule', 'StaffController@addSchedule');
            Route::post('/delete-schedule', 'StaffController@deleteSchedule');
            Route::get('/get-all-class-schedule/{class_id}', 'StaffController@getAllClassSchedule');
            Route::post('/add-tuition', 'StaffController@addTuition');
            Route::get('/get-tuition/{class_id}', 'StaffController@getTuitionByClassId');
            Route::post('/create-schedule-holiday', 'StaffController@createScheduleHoliday');
            Route::get('/get-holiday-schedules/{class_id}', 'StaffController@getHolidaySchedules');
            Route::post('/remove-holiday-schedule', 'StaffController@removeHolidaySchedule');
            Route::post('/create-schedule-exam', 'StaffController@createScheduleExam');
            Route::get('/get-exam-schedules/{class_id}', 'StaffController@getExamSchedules');
            Route::post('/remove-exam-schedule', 'StaffController@removeExamSchedule');
            Route::get('/get-exam-schedule/{id}', 'StaffController@getExamScheduleById');
            Route::post('/edit-exam-schedule', 'StaffController@editExamSchedule');
            Route::post('/create-period', 'StaffController@createPeriod');
            Route::get('/get-all-period', 'StaffController@getAllPeriod');
            Route::get('/get-period/{id}', 'StaffController@getPeriodById');
            Route::post('/delete-period', 'StaffController@deletePeriod');
            Route::post('/edit-period', 'StaffController@editPeriod');
            Route::get('/get-period-option', 'StaffController@getPeriodForOption');
            Route::post('/reject-tuition', 'StaffController@rejectTuition');
            Route::post('/approve-tuition', 'StaffController@approveTuition');
        });
        Route::group(['middleware' => 'resetavatar'], function () {
            Route::group(['middleware' => 'teacher', 'prefix' => 'teacher'], function () {
                Route::get('/', 'HomeController@index')->name('home');
                Route::get('/manage-class-view', 'TeacherController@manageClassView')->name('manage-class-view');
                Route::get('/manage-schedule-view', 'TeacherController@manageScheduleView')->name('manage-schedule-view');
                Route::get('/manage-packet-question-view', 'TeacherController@managePacketQuestionView')->name('manage-packet-question-view');
                Route::get('/manage-forum-view', 'TeacherController@manageForumView')->name('manage-forum-view');
                Route::get('/get-packet-question', 'TeacherController@packetQuestion');
                Route::post('/add-question', 'TeacherController@addQuestion');
                Route::post('/edit-question', 'TeacherController@editQuestion');
                Route::post('/delete-question', 'TeacherController@deleteQuestion');
                Route::get('/get-all-question/{packet_id}', 'TeacherController@getAllQuestion');
                Route::get('/get-question/{question_id}', 'TeacherController@getQuestionById');
                Route::get('/get-schedule', 'TeacherController@getSchedule');
                Route::get('/get-teacher-class', 'TeacherController@getTeacherClasses');
                Route::get('/get-teacher-class/{teacher_class_id}', 'TeacherController@getTeacherClassById');
                Route::post('/add-assignment', 'TeacherController@addAssignment');
                Route::post('/add-material', 'TeacherController@addMaterial');
                Route::get('/get-assignments/{teacher_class_id}', 'TeacherController@getAssignments');
                Route::get('/get-materials/{teacher_class_id}', 'TeacherController@getMaterials');
                Route::get('/get-history-assignment/{id}', 'TeacherController@getHistoryAssignment');
                Route::get('/get-all-chat/{teacher_class_id}', 'TeacherController@getAllChatWithTeacherClassId');
                Route::post('/send-chat', 'TeacherController@sendChat');
            });
            Route::group(['middleware' => 'student', 'prefix' => 'student'], function () {
                Route::get('/', 'HomeController@index')->name('home');
                Route::get('/student-schedule-view', 'StudentController@studentScheduleView')->name('student-schedule-view');
                Route::get('/student-quiz-view', 'StudentController@studentQuizView')->name('student-quiz-view');
                Route::get('/tuition-view', 'StudentController@tuitionView')->name('tuition-view');
                Route::get('/assignment-view', 'StudentController@assignmentView')->name('assignment-view');
                Route::get('/course-view', 'StudentController@courseView')->name('course-view');
                Route::get('/absence-view', 'StudentController@absenceView')->name('absence-view');
                Route::get('/get-schedule', 'StudentController@getSchedule');
                Route::get('/get-course', 'StudentController@getCourse');
                Route::get('/get-quiz-packet/{level}/{course_id}', 'StudentController@getQuizPacket');
                Route::post('/check-answer', 'StudentController@checkAnswer');
                Route::get('/get-packet-history/{course_id}', 'StudentController@getPacketHistoryByCourseId');
                Route::get('/get-packet-history/{course_id}', 'StudentController@getPacketHistoryByCourseId');
                Route::get('/get-packet-history-detail/{student_packet_id}', 'StudentController@getPacketHistoryDetail');
                Route::get('/get-tuitions', 'StudentController@getTuitions');
                Route::get('/get-history-detail/{tuition_history_id}', 'StudentController@getHistoryDetail');
                Route::post('/save-image', 'StudentController@saveImage');
                Route::get('/get-teacher-profile/{grade_id}/{course_id}', 'StudentController@getTeacherProfile');
                Route::get('/get-material/{teacher_class_id}', 'StudentController@getMaterialByTeacherClassId');
                Route::get('/get-assignment-by-grade', 'StudentController@getAssignmentByGrade');
                Route::post('/upload-assignment', 'StudentController@uploadAssignment');
                Route::get('/get-history-assignment/{id}', 'StudentController@getHistoryAssignment');
            });
        });
        Route::group(['middleware' => 'guardian', 'prefix' => 'guardian'], function () {
            Route::get('/', 'HomeController@index')->name('home');
        });
    });
});
