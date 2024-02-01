<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::controller(BasicController::class)->group(function (){

    //FRONTEND WEBPAGES
    Route::get('/','login');
    Route::get('/register','register');
    Route::get('/logout','logout');
    Route::get('/staffLogin','stafflogin');

    //PROCESSING PAGES
    Route::post('/registration','registration');
    Route::post('/loginProcess','loginProcess');
    Route::post('/loginProcessStaff','loginProcessStaff');


    Route::middleware(['authCheck'])->group(function () {
        Route::get('/dashboard','dashboard');

        Route::get('/setupcompany','setupcompany');
        Route::get('/companies','companies');
        Route::get('/editcompany/{id}','editcompany');
        Route::get('/deletecompany/{id}','deletecompany');

        Route::get('/addbrand/{id}','setupbrand');
        Route::get('/brandlist','brandlist');
        Route::get('/editbrand/{id}','editbrand');
        Route::get('/deletebrand/{id}','deletebrand');

        Route::get('/setupdepartments','setupdepartments');
        Route::get('/departmentlist','departmentlist');
        Route::get('/editdepartment/{id}','editdepartment');
        Route::get('/deletedepartment/{id}','deletedepartment');
        Route::get('/departmentusers/{id}','departmentusers');

        Route::get('/userlist','userlist');
        Route::get('/createuser','createuser');
        Route::get('/edituser/{id}','edituser');
        Route::get('/deleteuser/{id}','deleteuser');
        Route::get('/userprofile/{id}','userprofile');

        Route::get('/forms/kyc','seo');
        Route::get('/forms/book','book');
        Route::get('/forms/website','website');
        Route::get('/forms/cld','cld');
        Route::get('/client/project','clientProject');
        Route::get('/forms/qaform','qaform');
        Route::get('/forms/renewalrecurring','renewalrecurring');
        Route::get('/forms/revenueloss','revenueloss');
        Route::get('/forms/paymentconfirmation','paymentconfirmation');
        Route::get('/client/details/{id}','getclientDetails');
        Route::get('/all/clients','allclients');



        //PROCESSES
        Route::post('/setupcompany/process','setupcompanyprocess');
        Route::post('/editcompany/{id}/process','editcompanyprocess');

        Route::post('/setupbrand/process','setupbrandprocess');
        Route::post('/editbrand/{id}/process','editbrandprocess');

        Route::post('/createuser/process','createuserprocess');
        Route::post('/edituser/{id}/process','edituserprocess');


        Route::post('/setupdepartment/process','setupdepartmentsProcess');
        Route::post('/editdepartment/{id}/process','editdepartmentprocess');
        Route::post('/forms/kyc/process/client','kycclientprocess');
        Route::post('/client/project/process','clientProjectProcess');

        //REPORTS:
        Route::get('/userreport','userreport');

    });

    Route::middleware(['authCheckStaff'])->group(function () {
         Route::get('/employee/dashboard','staffdashboard');
    });

});


