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

    
    //PROCESSING PAGES
    Route::post('/registration','registration');
    Route::post('/loginProcess','loginProcess');
    

    Route::middleware(['authCheck'])->group(function () {
        Route::get('/dashboard','dashboard');
        Route::get('/setupcompany','setupcompany');
        Route::get('/companies','companies');
        Route::get('/addbrand/{id}','setupbrand');
        Route::get('/brandlist','brandlist');
        Route::get('/setupdepartments/{id}','setupdepartments');
        Route::get('/userlist','userlist');
        Route::get('/createuser','createuser');
        Route::get('/forms/kyc','kyc');
        Route::get('/forms/qaform','qaform');
        Route::get('/forms/renewalrecurring','renewalrecurring');
        Route::get('/forms/revenueloss','revenueloss');
        Route::get('/forms/paymentconfirmation','paymentconfirmation');

        //PROCESSES
        Route::post('/setupcompany/process','setupcompanyprocess');
        Route::post('/setupbrand/process','setupbrandprocess');
        Route::post('/createuser/process','createuserprocess');
    }); 

});


