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

        //kyc forms:
        Route::get('/forms/kyc','seo');
        Route::get('/forms/book','book');
        Route::get('/forms/website','website');
        Route::get('/forms/cld','cld');

        //qaform:
        Route::get('/forms/qaform_d','qaform');
        Route::get('/forms/qaform/{id}','qaform_prefilled');
        Route::get('/forms/newqaform/{id}','new_qaform');
        Route::get('/forms/editnewqaform/{id}','edit_new_qaform');

       //qaformprocess :
        Route::post('/forms/qaform_getproduction/process','qaform_getproduction');
        Route::post('/forms/qaform_d/process','qaform_direct_process');
        Route::post('/forms/qaform/{id}/process','qaform_prefilled_process');
        Route::post('/forms/editnewqaform/{id}/process','edit_new_qaform_process');








        Route::get('/forms/seo_qaform','seo_qaform');
        Route::get('/forms/book_qaform','book_qaform');
        Route::get('/forms/website_qaform','website_qaform');
        Route::get('/forms/cld_qaform','cld_qaform');

        //projects form:
        Route::get('/client/project','clientProject');
        Route::get('/client/project/{id}','clientProject_prefilled');
        Route::get('/client/project/productions/{id}','Project_production');
        Route::get('/client/project/productions/users/{id}','ProjectProduction_users');
        Route::get('/client/editproject/{id}','editproject');
        Route::get('/client/project/editproductions/{id}','Edit_Project_production');
        Route::get('/client/project/deleteproductions/{id}','deleteproduction');



        Route::get('/forms/renewalrecurring','renewalrecurring');
        Route::get('/forms/revenueloss','revenueloss');
        Route::get('/forms/paymentconfirmation','paymentconfirmation');
        Route::get('/client/details/{id}','getclientDetails');
        Route::get('/all/clients','allclients');

        //payment
        Route::get('/forms/payment/{id}','payment');



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
        ROute::post('/client/project/production/{id}/process','Project_ProductionProcess');
        Route::post('/client/editproject/{id}/process','editProjectProcess');
        Route::post('/client/project/editproduction/{id}/process','Edit_Project_production_Process');
        Route::post('/client/payment','clientPayment');


        //REPORTS:
        Route::get('/userreport','userreport');
        Route::get('/client/project/qareport/{id}','projectQaReport');
        Route::get('/client/project/qareport/view/{id}','projectQaReport_view');
        Route::get('/project/report/{id}','projectreport');


        //settings:
        //QA ISSUES:
        Route::get('/settings/qa_issues','qa_issues');
        Route::post('/settings/qa_issues/Process','qa_issues_process');
        Route::get('/settings/delete_qa_issues/{id}','delete_qa_issues');

        //PRODUCTION SERVICES:
        Route::get('/settings/Production/services','Production_services');
        Route::post('/settings/Production/services/Process','Production_services_process');
        Route::get('/settings/delete_kycservices/{id}','delete_Production_services');

        //ASSIGN PROJECT:
        Route::get('/settings/user/client','Assign_Client_to_qaperson');
        Route::post('/settings/user/client/Process','Assign_Client_to_qaperson_process');
        Route::get('/settings/user/client/delete/{id}','delete_Assign_Client_to_qaperson');



        Route::get('/picture','picturedisplay');


    });

    Route::middleware(['authCheckStaff'])->group(function () {
         Route::get('/employee/dashboard','staffdashboard');

         //SEO KYC:
         Route::get('/employee/forms/kyc','seo');
         Route::post('/employee/forms/kyc/process/client','kycclientprocess');
    });

});


