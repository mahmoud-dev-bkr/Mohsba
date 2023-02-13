<?php

use App\Http\Controllers\Api\EmployeesController;

use Illuminate\Support\Facades\Route;



/*
salah
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API! tarek
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Auth::routes();

/* Api Routes
   important default prefix => 'api' */


Route::group(['as' => 'api.', 'namespace' => 'Api'], function () {

    // Employees Apis
    Route::post('employees/employee_login', 'EmployeesController@employeeLogin'); // parameters ($email, $password)
    Route::post('employees/is_employee_phone_exist', 'EmployeesController@isEmployeePhoneExist'); // parameters ($phone)
    Route::post('employees/reset_password', 'EmployeesController@resetPassword'); // parameters ($id,$password,$newpassword)
    Route::post('employees/forget_password', 'EmployeesController@forgetPassword'); // parameters ($mobile_mac_address,$phone)
    Route::post('employees/get_forgeten_password','EmployeesController@CheckForgetenPassword');
    Route::post('employees/change_password', 'EmployeesController@changePassword'); // parameters ($id,$oldpassword,$newpassword)
    Route::post('employees/getData', 'EmployeesController@getData');
    Route::post('employee_requests/getData', 'EmployeeRequestController@getData');
    Route::post('employee/update', 'EmployeesController@employeeUpdate');
    Route::post('employee/getData', 'EmployeesController@getEmployeeData');
    Route::post('employee_requests/store', 'EmployeeRequestController@store');
    Route::post('employees/attend_methods', [EmployeesController::class, 'get_employee_attendenceMethods']);
    // Comppost Apis
    // Attepostce Methodd Apis
    Route::post('attend_methods/getData', 'AttendMethodController@getEmployeeAttenance');
    // employee attenance and departure
    // Route::post('employees/set_employees_attenance', 'AttendanceController@set_employee_attendence');
    // Route::post('employees/set_employees_departure', 'DepartureController@set_employee_departure');

    Route::post('employee/appointments', 'AttendanceAndDepartureController@getEmployeeAppointments');

    Route::post('employee/today_appointments', 'AttendanceAndDepartureController@Today_appointments');

    //attendance and Departure //
    Route::post('employees/set_employees_attendance', 'AttendanceAndDepartureController@set_employee_attendance');
    Route::post('employees/set_employees_departure', 'AttendanceAndDepartureController@set_employee_departure');

    //employees alerts
    Route::post('employees/attendance_alters','RandomRequestsController@EmployeesAlerts');
    Route::post('employees/update_attendance','RandomRequestsController@updateRandomAttendance');
    Route::post('employees/update_firebase_token','RandomRequestsController@updateFirebaseToken');
    Route::post('employees/test_firebase_token','RandomRequestsController@testFirebaseToken');

    // for developers //
    Route::post('employee/loginwithid','EmployeesController@Loginwithid');
    Route::post('employee/delete_atttendance_and_departure','AttendanceAndDepartureController@deleteAttendanceDeparture');
    Route::post('employee/delete_image_and_voice','EmployeesController@deleteImageAndVoice');
    /////////



    Route::post('salary', 'SalaryController@performSave')->name('salary.perform-save');

    // will be removed later
    Route::post('make_password_null', 'EmployeesController@make_null');

    //otp //
    Route::post('generate_otp','AppointmentController@updateOtp');
});
