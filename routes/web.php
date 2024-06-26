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

    //seo_sale_kyc
    Route::get('/auth','get_email');
    Route::post('/auth/process','get_email_process');
    Route::get('/kyclogout','kyclogout');
    //book_sale_kyc
    Route::get('/book_auth','get_book_email');
    Route::post('/book_auth/process','get_book_email_process');
    Route::get('/kyclogoutbook','kyclogoutbook');

    Route::middleware(['GuestUser'])->group(function () {
        Route::get('/seo_kyc_form','seo_kyc_form');
        Route::post('/seo_kyc_form/process','seo_kyc_form_process');

        Route::get('/book_kyc_form','book_kyc_form');
        Route::post('/book_kyc_form/process','book_kyc_form_process');
    });



    //PROCESSING PAGES
    Route::post('/registration','registration');
    Route::post('/loginProcess','loginProcess');


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
        Route::get('/setupdepartments/{id}','setupdepartments_withBrand');
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
        Route::get('/forms/csv_uploads','csv_client');
        Route::get('/forms/csv_uploads_projects','csv_project');
        Route::post('/forms/csv_uploads_upload/process','csv_project_process');

        Route::get('/forms/kyc/edit/{id}','editClient');
        Route::get('/clientmetaupdate/{id}/{n}','editClientmeta');

        //pushemailstometa
        Route::get('/client/emails','pushEmailtometa');

        //qaform:
        Route::get('/forms/qaform_d','qaform');
        Route::get('/allfilled/qaforms','filledqaformIndv');
        Route::post('/forms/qaform_getproduction/process','qaform_getproduction');
        Route::get('/forms/newqaform/{id}','new_qaform');
        Route::post('/forms/qaform/{id}/process','qaform_prefilled_process');

        Route::get('/forms/editnewqaform/{id}','edit_new_qaform');
        Route::post('/forms/editnewqaform/{id}/process','edit_new_qaform_process');
        Route::get('/forms/deletenewqaform/{id}','new_qaform_delete');
        // Route::get('/forms/qaform/{id}','qaform_prefilled');
        // Route::post('/forms/qaform_d/process','qaform_direct_process');

        //projects form:
        Route::get('/client/project','clientProject');
        Route::get('/assignedclient/project','assgnedclientProject');

        Route::get('/client/project/{id}','clientProject_prefilled');
        Route::get('/client/project/productions/{id}','Project_production');
        Route::get('/client/project/productions/users/{id}','ProjectProduction_users');
        Route::get('/client/editproject/{id}','editproject');
        Route::get('/client/deleteproject/{id}','deleteproject');
        Route::get('/client/project/editproductions/{id}','Edit_Project_production');
        Route::get('/client/project/deleteproductions/{id}','deleteproduction');
        Route::get('/client/details/{id}','getclientDetails');
        Route::get('/all/clients','allclients');
        Route::get('/all/newclients','monthClient');
        Route::get('/assigned/clients','assignedclients');

        //payment

        // (New Payment Direct payment:)
        Route::get('/newclient/payment','newClientPayment');
        Route::post('/newclient/payment/process','newClientPaymentprocess');


        Route::get('/forms/payment/{id}','payment');
        Route::get('/client/add/payment','addPayment');
        Route::post('/client/add/payment/process','addPaymentProcess');
        Route::get('/client/project/payment/view/{id}','payment_view');
        Route::get('/client/project/payment/report/view/{id}','payment_view1');
        Route::get('/client/project/payment/all','all_payments');
        //refund
        Route::get('/client/project/payment/Refund/{id}','payment_Refund');
        Route::post('/client/project/payment/Refund/process','payment_Refund_Process');
        Route::post('/client/project/payment/Refund/{id}/process','payment_Refund_stripePayment_Process');
        //dispute:
        Route::get('/client/project/payment/Dispute/{id}','payment_Dispute');
        Route::post('/client/project/payment/Dispute/process','payment_Dispute_Process');
        //disputeTable
        Route::get('/client/project/payment/disputes','all_disputes');
        //disputeLost:
         Route::get('/client/project/payment/Dispute/lost/{id}','payment_Dispute_lost');
         Route::post('/client/project/payment/Dispute/process/lost','payment_Dispute_Process_lost');
        //disputeWon:
        Route::get('/client/project/payment/Dispute/won/{id}','payment_Dispute_won');
        Route::post('/client/project/payment/Dispute/process/won','payment_Dispute_Process_won');
        //dispute view:
        Route::get('/client/project/payment/Dispute/view/{id}','projectpayment_view_dispute');

        //remaining
        Route::get('/client/project/payment/remaining/{id}','payment_remaining_amount');
        Route::post('/client/project/payment/remaining/{id}/process','payment_remaining_amount_process');
        //pending (Upcoming)
        Route::get('/client/project/payment/pending/{id}','payment_pending_amount');
        Route::post('/client/project/payment/pending/{id}/process','payment_pending_amount_process');
        //Edit
        Route::get('/client/project/payment/edit/{id}','payment_edit_amount');
        Route::post('/client/project/payment/edit/{id}/process','payment_edit_amount_process');
        //deletePayments:
        Route::get('/client/project/payment/delete/{id}','delete_payment');
        //new payments:
        Route::get('/client/new/payment','new_payments');
        Route::post('/client/new/payment/process','new_payments_process');
        //csv_paymentsFromstripeUpload:
        Route::get('/forms/csv_uploads_stripePayments','csv_stripepayments');
        Route::post('/forms/csv_uploads_stripePayments/process','csv_stripepayments_process');

        //csv_paymentsFromSheet_SEO(previous data upload):
        Route::get('/forms/csv_uploads_sheetinvoicing','csv_sheetpayments');
        Route::post('/forms/csv_uploads_sheetinvoicing/process','csv_sheetpayments_process');

        //csv_paymentsFromSheet_book(previous data upload):
        Route::get('/forms/csv_uploads_sheetinvoicingbook','csv_sheetpaymentsBook');
        Route::post('/forms/csv_uploads_sheetinvoicingbook/process','csv_sheetpayments_processBook');

         //csv_paymentsFromSheet_bitswits(previous data upload):
         Route::get('/forms/csv_uploads_sheetinvoicingbitswits','csv_sheetpaymentsbitswits');
         Route::post('/forms/csv_uploads_sheetinvoicingbitswits/process','csv_sheetpayments_processbitswits');

        //Unmatched Payments:
        Route::get('/payments/unmatched','unmatchedPayments');

         //not found clients fron invoicing:
         Route::get('/payments/invoicing/notfoundclient','notfoundclient');

        //Link New Payment Email With Client:
        Route::get('/client/newemail/{id}','NewEmailLinkCLient');
        Route::post('/client/newemail/process','NewEmailLinkCLientprocess');

        //create_salesTeam:
        Route::get('/forms/create/team','createteam');
        Route::post('/forms/create/team/process','createteam_process');

          //sales team view:
          Route::get('/sales/teams','salesteam_view');


        //PROCESSES
        Route::post('/setupcompany/process','setupcompanyprocess');
        Route::post('/editcompany/{id}/process','editcompanyprocess');

        Route::post('/setupbrand/process','setupbrandprocess');
        Route::post('/editbrand/{id}/process','editbrandprocess');

        Route::post('/createuser/process','createuserprocess');
        Route::post('/edituser/{id}/process','edituserprocess');


        Route::post('/setupdepartment/process','setupdepartmentsProcess');
        Route::get('/setupdepartment/users/{id}','selectdepartusers');
        Route::post('/setupdepartment/setusers/{id}','addusersIndepart');
        Route::post('/editdepartment/{id}/process','editdepartmentprocess');
        Route::post('/forms/kyc/process/client','kycclientprocess');
        Route::post('/forms/csv_uploads/process','importExcel');
        Route::post('/forms/kyc/process/editclient/{id}','editClientProcess');
        Route::post('/forms/kyc/process/editclientwithoutmeta/{id}','editClientProcess_withoutmeta');
        Route::post('/forms/kyc/process/editclientwithoutmeta_metacreationprocess','editClientProcess_withoutmeta_metacreationprocess');
        Route::post('/client/project/process','clientProjectProcess');
        ROute::post('/client/project/production/{id}/process','Project_ProductionProcess');
        Route::post('/client/editproject/{id}/process','editProjectProcess');
        Route::post('/client/project/editproduction/{id}/process','Edit_Project_production_Process');
        Route::post('/client/payment','clientPayment');
        Route::post('/client/payment/unlinked/{id}','clientPayment_Unlinked');


        //REPORTS:
        Route::get('/userreport','userreport');
        Route::get('/generate/report/{id}','clientReport');
        Route::get('/client/project/qareport/{id}','projectQaReport');
        Route::get('/client/project/qareport/view/{id}','projectQaReport_view');
        Route::get('/client/project/qaform/view/{id}','projectQaReport_view_without_backButton');
        Route::get('/allproject/report/{id?}','projectreport');
        Route::get('/project/report/{id?}','newprojectreport');

        Route::get('/client/revenue/{id?}','revenuereport');
        Route::get('/allclient/revenue/{id?}','new_revenuereport');


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
        Route::get('/settings/changeuser/client/{id}','Edit_Assign_Client_to_qaperson');
        Route::post('/settings/changeuser/client/{id}/Process','Edit_Assign_Client_to_qaperson_process');
        Route::get('/settings/user/client/delete/{id}','delete_Assign_Client_to_qaperson');
        //payment dashboard:
        Route::get('/paymentdashboard/{id?}','paymentdashboard');
        //allpayment dashboard:
         Route::get('/allpaymentdashboard/{id?}','allpaymentdashboard');

         Route::get('/finalallpaymentdashboard/{id?}','finalpaymentdashboard');
        //brandTarget
        Route::get('/settarget','brandtarget');
        Route::post('/settarget/process','brandtargetprocess');
        Route::get('/brandtarget','viewbrandtarget');
        Route::get('/settarget/edit/{id}','brandtargetedit');
        Route::post('/settarget/edit/process/{id}','brandtargetprocesseditprocess');
        //agentTarget
        Route::get('/setagenttarget','agenttarget');
        Route::post('/setagenttarget/process','agent_targetprocess');
        Route::get('/setagenttarget/edit/{id}','agenttargetedit');
        Route::post('/setagenttarget/edit/process/{id}','agenttargetprocesseditprocess');
        Route::get('/allagenttarget','viewagenttarget');

        //csv_ppc:
         Route::get('/forms/csv_uploads_ppc','csv_ppc');
         Route::post('/forms/csv_uploads_ppc/process','csv_ppc_process');
         Route::get('/viewppc','viewppc');

        //csv_leads:
          Route::get('/forms/csv_uploads_leads','csv_leads');
          Route::post('/forms/csv_uploads_leads/process','csv_leads_process');
          Route::get('/viewleads','viewleads');

        //csv_target:
         Route::get('/forms/csv_uploads_target','target_csv');
         Route::post('/forms/csv_uploads_target/process','csv_target_process');



    });



});


