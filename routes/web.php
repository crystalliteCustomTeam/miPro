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


Route::view('/unauthorized','Unauthorized')->name('Unauthorized');

Route::controller(BasicController::class)->group(function () {

    //FRONTEND WEBPAGES
    Route::get('/', 'login')->name('Login');
    Route::get('/register', 'register');
    Route::get('/logout', 'logout')->name('Logout');

    //seo_sale_kyc
    Route::get('/auth', 'get_email')->name('Front_login');
    Route::post('/auth/process', 'get_email_process');
    Route::get('/kyclogout', 'kyclogout')->name('Front_Logout');
    //book_sale_kyc
    Route::get('/book_auth', 'get_book_email')->name('Front_login_Book');
    Route::post('/book_auth/process', 'get_book_email_process');
    Route::get('/kyclogoutbook', 'kyclogoutbook')->name('Front_Logout_Book');

    Route::middleware(['GuestUser'])->group(function () {
        Route::get('/seo_kyc_form', 'seo_kyc_form')->name('Front_SEO_kyc');
        Route::post('/seo_kyc_form/process', 'seo_kyc_form_process');

        Route::get('/book_kyc_form', 'book_kyc_form')->name('Front_Book_kyc');
        Route::post('/book_kyc_form/process', 'book_kyc_form_process');
    });



    //PROCESSING PAGES
    Route::post('/registration', 'registration');
    Route::post('/loginProcess', 'loginProcess');


    Route::middleware(['authCheck'])->group(function () {
        Route::get('/changetheme', 'changetheme')->name('changetheme');

        Route::get('/abc', 'abc')->name('abc');
        Route::get('/def', 'def')->name('def');
        Route::get('/ghi/{id}', 'ghi')->name('ghi');
        Route::get('/jkl', 'jkl')->name('jkl');

        Route::get('/dashboard', 'dashboard')->name('Home');

        Route::get('/setupcompany', 'setupcompany')->name('Create_Company');
        Route::get('/companies', 'companies')->name('All_Company_List');
        Route::get('/editcompany/{id}', 'editcompany')->name('Edit_Company');
        Route::get('/deletecompany/{id}', 'deletecompany')->name('Delete_Company');

        Route::get('/addbrand/{id}', 'setupbrand')->name('Create_Brand');
        Route::get('/brandlist', 'brandlist')->name('All_Brand_List');
        Route::get('/editbrand/{id}', 'editbrand')->name('Edit_Brand');
        Route::get('/deletebrand/{id}', 'deletebrand')->name('Delete_Brand');

        Route::get('/setupdepartments', 'setupdepartments')->name('Create_Department');
        Route::get('/setupdepartments/{id}', 'setupdepartments_withBrand')->name('Create_Department_From_Brand');
        Route::get('/departmentlist', 'departmentlist')->name('All_Department_List');
        Route::get('/editdepartment/{id}', 'editdepartment')->name('Edit_Department');
        Route::get('/deletedepartment/{id}', 'deletedepartment')->name('Delete_Department');
        Route::get('/departmentusers/{id}', 'departmentusers')->name('Department_Members');

        Route::get('/userlist', 'userlist')->name('All_User_List');
        Route::get('/createuser', 'createuser')->name('Create_User');
        Route::get('/edituser/{id}', 'edituser')->name('Edit_User');
        Route::get('/deleteuser/{id}', 'deleteuser')->name('Delete_User');
        Route::get('/userprofile/{id}', 'userprofile')->name('User_Profile');

        //kyc forms:
        Route::get('/forms/kyc', 'seo')->name('SEO_kyc');
        Route::get('/forms/book', 'book')->name('Book_kyc');
        Route::get('/forms/website', 'website')->name('Website_kyc');
        Route::get('/forms/cld', 'cld')->name('CLD_kyc');
        Route::get('/forms/csv_uploads', 'csv_client')->name('Client_CSV');
        Route::get('/forms/csv_uploads_projects', 'csv_project')->name('Project_CSV');
        Route::post('/forms/csv_uploads_upload/process', 'csv_project_process');

        Route::get('/forms/kyc/edit/{id}', 'editClient')->name('Edit_kyc');
        Route::get('/clientmetaupdate/{id}/{n}', 'editClientmeta')->name('Edit_kyc_Otherdetails');

        //pushemailstometa
        Route::get('/client/emails', 'pushEmailtometa')->name('Push_Email');
        Route::get('/client/emails/newpayments', 'pushnewpayments')->name('Push_payments');
        //Mark Client as Completed
        Route::get('/client/completed/{id}', 'Client_MarkasCompleted')->name('Client_MarkasCompleted');

        //qaform:
        Route::get('/forms/qaform_d', 'qaform')->name('QAForm_Project');
        Route::get('/allfilled/qaforms', 'filledqaformIndv')->name('QAForm_Indv_Forms');
        Route::post('/forms/qaform_getproduction/process', 'qaform_getproduction');
        Route::get('/forms/newqaform/{id}', 'new_qaform')->name('QAForm');
        Route::post('/forms/qaform/{id}/process', 'qaform_prefilled_process');

        Route::get('/forms/editnewqaform/{id}', 'edit_new_qaform')->name('Edit_QAForm');
        Route::post('/forms/editnewqaform/{id}/process', 'edit_new_qaform_process');
        Route::get('/forms/deletenewqaform/{id}', 'new_qaform_delete')->name('Delete_QAForm');

        //projects form:
        Route::get('/client/project', 'clientProject')->name('Create_Project');
        Route::get('/assignedclient/project', 'assgnedclientProject')->name('Create_Project_Indv_Assigned');

        Route::get('/client/project/{id}', 'clientProject_prefilled')->name('Create_Project_from_Portal');
        Route::get('/client/project/productions/{id}', 'Project_production')->name('Create_Project_Production');
        Route::get('/client/project/productions/users/{id}', 'ProjectProduction_users')->name('Project_Production_List');
        Route::get('/client/editproject/{id}', 'editproject')->name('Edit_Project');
        Route::get('/client/deleteproject/{id}', 'deleteproject')->name('Delete_Project');
        Route::get('/client/project/editproductions/{id}', 'Edit_Project_production')->name('Edit_Project_Production');
        Route::get('/client/project/deleteproductions/{id}', 'deleteproduction')->name('Delete_Project_Production');
        Route::get('/client/details/{id}', 'getclientDetails')->name('Client_Portal');
        Route::get('/all/clients', 'allclients')->name('All_Client_List');
        Route::get('/all/clients/active', 'allclientsActive')->name('All_Client_List_Active');
        Route::get('/all/newclients', 'monthClient')->name('All_NewClient_List');
        Route::get('/assigned/clients', 'assignedclients')->name('All_AssignedClient_List');

        //payment

        // (New Payment Direct payment:)
        Route::get('/newclient/payment', 'newClientPayment')->name('NewLead_Add_Payment');
        Route::post('/newclient/payment/process', 'newClientPaymentprocess');


        Route::get('/forms/payment/{id}', 'payment')->name('Create_Payment');
        Route::get('/client/add/payment', 'addPayment')->name('AddPayment_Project');
        Route::post('/client/add/payment/process', 'addPaymentProcess');
        Route::get('/client/project/payment/view/{id}', 'payment_view')->name('View_Payments');
        Route::get('/client/project/payment/report/view/{id}', 'payment_view1')->name('View_Payment');
        Route::get('/client/project/payment/all', 'all_payments')->name('All_Payments_List');

        Route::get('/client/project/payment/all/active', 'all_paymentsActive')->name('All_Payments_List_Active');
        //refund
        Route::get('/client/project/payment/Refund/{id}', 'payment_Refund')->name('Create_Refund');
        Route::post('/client/project/payment/Refund/process', 'payment_Refund_Process');
        Route::post('/client/project/payment/Refund/{id}/process', 'payment_Refund_stripePayment_Process');

        Route::get('/client/project/payment/editRefund/{id}', 'payment_RefundEdit')->name('Edit_Refund');
        Route::post('/client/project/payment/EditRefund/process/{id}', 'payment_RefundEdit_Process');
        //dispute:
        Route::get('/client/project/payment/Dispute/{id}', 'payment_Dispute')->name('Create_Dispute');
        Route::post('/client/project/payment/Dispute/process', 'payment_Dispute_Process');

        Route::get('/client/project/payment/editDispute/{id}', 'payment_Edit_Dispute')->name('Edit_Dispute');
        Route::post('/client/project/payment/EditDispute/process/{id}', 'payment_Edit_Dispute_Process');
        //disputeTable
        Route::get('/client/project/payment/disputes', 'all_disputes')->name('All_Dispute_List');
        //disputeLost:
        Route::get('/client/project/payment/Dispute/lost/{id}', 'payment_Dispute_lost')->name('Create_Dispute_Lost');
        Route::post('/client/project/payment/Dispute/process/lost', 'payment_Dispute_Process_lost');
        //disputeWon:
        Route::get('/client/project/payment/Dispute/won/{id}', 'payment_Dispute_won')->name('Create_Dispute_Won');
        Route::post('/client/project/payment/Dispute/process/won', 'payment_Dispute_Process_won');
        //dispute view:
        Route::get('/client/project/payment/Dispute/view/{id}', 'projectpayment_view_dispute')->name('View_Dispute');

        //remaining
        // Route::get('/client/project/payment/remaining/{id}', 'payment_remaining_amount');
        // Route::post('/client/project/payment/remaining/{id}/process', 'payment_remaining_amount_process');

        //pending (Upcoming)
        Route::get('/client/project/payment/pending/{id}', 'payment_pending_amount')->name('Create_Renewal_Recurring_Payments');
        Route::post('/client/project/payment/pending/{id}/process', 'payment_pending_amount_process');
        //Edit
        Route::get('/client/project/payment/edit/{id}', 'payment_edit_amount')->name('Edit_Payments');
        Route::post('/client/project/payment/edit/{id}/process', 'payment_edit_amount_process');
        //deletePayments:
        Route::get('/client/project/payment/delete/{id}', 'delete_payment')->name('Delete_Payments');
        //new payments:
        Route::get('/client/new/payment', 'new_payments')->name('New_Payment_Srtipe');
        Route::post('/client/new/payment/process', 'new_payments_process');
        //csv_paymentsFromstripeUpload:
        Route::get('/forms/csv_uploads_stripePayments', 'csv_stripepayments')->name('Stripe_CSV');
        Route::post('/forms/csv_uploads_stripePayments/process', 'csv_stripepayments_process');

        //csv_paymentsFromSheet_SEO(previous data upload):
        Route::get('/forms/csv_uploads_sheetinvoicing', 'csv_sheetpayments')->name('SEO_Invoicing_CSV');
        Route::post('/forms/csv_uploads_sheetinvoicing/process', 'csv_sheetpayments_process');

        //csv_paymentsFromSheet_book(previous data upload):
        Route::get('/forms/csv_uploads_sheetinvoicingbook', 'csv_sheetpaymentsBook')->name('Book_Invoicing_CSV');
        Route::post('/forms/csv_uploads_sheetinvoicingbook/process', 'csv_sheetpayments_processBook');

        //csv_paymentsFromSheet_bitswits(previous data upload):
        Route::get('/forms/csv_uploads_sheetinvoicingbitswits', 'csv_sheetpaymentsbitswits')->name('Bitswite_Invoicing_CSV');
        Route::post('/forms/csv_uploads_sheetinvoicingbitswits/process', 'csv_sheetpayments_processbitswits');

        //csv_paymentsFromSheet_ClickfirstSMM(previous data upload):
        Route::get('/forms/csv_uploads_sheetinvoicingClientFirstSMM', 'csv_sheetpaymentsClientFirstSMM')->name('ClientFirstSMM_Invoicing_CSV');
        Route::post('/forms/csv_uploads_sheetinvoicingClientFirstSMM/process', 'csv_sheetpayments_processClientFirstSMM');

        //csv_paymentsFromSheet_creative(previous data upload):
        Route::get('/forms/csv_uploads_sheetinvoicingcreative', 'csv_sheetpaymentscreative')->name('Creative_Invoicing_CSV');
        Route::post('/forms/csv_uploads_sheetinvoicingcreative/process', 'csv_sheetpayments_processcreative');


        //csv_paymentsFromSheet_infinity(previous data upload):
        Route::get('/forms/csv_uploads_sheetinvoicingInfinity', 'csv_sheetpaymentsinfinity')->name('Infinity_Invoicing_CSV');
        Route::post('/forms/csv_uploads_sheetinvoicinginfinity/process', 'csv_sheetpayments_processinfinity');

        //csv_paymentsFromSheet_webdesignhub(previous data upload):
        Route::get('/forms/csv_uploads_sheetinvoicingWebDesignHub', 'csv_sheetpaymentswebdesignhub')->name('InfinityWeb_and_SrpDesign_Invoicing_CSV');
        Route::post('/forms/csv_uploads_sheetinvoicingWebDesignHub/process', 'csv_sheetpayments_processwebdesignhub');


        //Unmatched Payments:
        Route::get('/payments/unmatched', 'unmatchedPayments')->name('Unmatched_Stripe');
        //unlinked payments sheet:
        Route::get('/payments/unmatched/sheet', 'unmatchedPaymentsSheet')->name('Unmatched_Sheets');

        //not found clients fron invoicing:
        Route::get('/payments/invoicing/notfoundclient', 'notfoundclient')->name('NotFound_Client');

        //Link New Payment Email With Client:
        Route::get('/client/newemail/{id}', 'NewEmailLinkCLient')->name('Add_Email_Client');
        Route::post('/client/newemail/process', 'NewEmailLinkCLientprocess');

        //Edit New Payment Email With Client:
        // Route::get('/client/editnewemail/{id}','NewEmail_unlinkededit');
        // Route::post('/client/editnewemail/process/{id}','NewEmail_unlinkededit_process');

        //create_salesTeam:
        Route::get('/forms/create/team', 'createteam')->name('Create_SalesTeam');
        Route::post('/forms/create/team/process', 'createteam_process');

        //delete salesteam:
        Route::get('/deletesalesteam/{id}','deleteSalesteam')->name('Delete_SalesTeam');

        //sales team view:
        Route::get('/sales/teams', 'salesteam_view')->name('View_SalesTeam');

        //Edit Sales Team:
        Route::get('/editsalesteam/{id}', 'editsalesteam')->name('Edit_SalesTeam');
        Route::post('/editsalesteam/{id}/process', 'editsalesteamprocess');


        //PROCESSES
        Route::post('/setupcompany/process', 'setupcompanyprocess');
        Route::post('/editcompany/{id}/process', 'editcompanyprocess');

        Route::post('/setupbrand/process', 'setupbrandprocess');
        Route::post('/editbrand/{id}/process', 'editbrandprocess');

        Route::post('/createuser/process', 'createuserprocess');
        Route::post('/edituser/{id}/process', 'edituserprocess');


        Route::post('/setupdepartment/process', 'setupdepartmentsProcess');
        // Route::get('/setupdepartment/users/{id}', 'selectdepartusers');
        // Route::post('/setupdepartment/setusers/{id}', 'addusersIndepart');
        Route::post('/editdepartment/{id}/process', 'editdepartmentprocess');
        Route::post('/forms/kyc/process/client', 'kycclientprocess');
        Route::post('/forms/csv_uploads/process', 'importExcel');
        Route::post('/forms/kyc/process/editclient/{id}', 'editClientProcess');
        Route::post('/forms/kyc/process/editclientwithoutmeta/{id}', 'editClientProcess_withoutmeta');
        Route::post('/forms/kyc/process/editclientwithoutmeta_metacreationprocess', 'editClientProcess_withoutmeta_metacreationprocess');
        Route::post('/client/project/process', 'clientProjectProcess');
        ROute::post('/client/project/production/{id}/process', 'Project_ProductionProcess');
        Route::post('/client/editproject/{id}/process', 'editProjectProcess');
        Route::post('/client/project/editproduction/{id}/process', 'Edit_Project_production_Process');
        Route::post('/client/payment', 'clientPayment');
        Route::post('/client/payment/unlinked/{id}', 'clientPayment_Unlinked');


        //REPORTS:
        // Route::get('/userreport', 'userreport');
        Route::get('/generate/report/{id}', 'clientReport')->name('Client_Report');
        Route::get('/client/project/qareport/{id}', 'projectQaReport')->name('Project_QA_Report');
        Route::get('/client/project/qareport/view/{id}', 'projectQaReport_view')->name('View_QAForms');
        Route::get('/client/project/qaform/view/{id}', 'projectQaReport_view_without_backButton')->name('View_QAForm');
        Route::get('/allproject/report/{id?}', 'projectreport')->name('QA_Report_layout1');
        Route::get('/project/report/{id?}', 'newprojectreport')->name('QA_Report_layout2');

        Route::get('/client/revenue/{id?}', 'revenuereport')->name('Reneue_Report_layout1');
        Route::get('/allclient/revenue/{id?}', 'new_revenuereport')->name('Renenue_Report_layout2');

        Route::get('/payment/daily/{id?}', 'dailystats')->name('Today_Payment');

        //yearly brand ststs
        Route::get('/yearly/brand/stats/{id?}', 'yearlybrandStats')->name('Yearly_Brand_Stats');
        //yearly agents ststs
        Route::get('/yearly/agents/stats/{id?}', 'agentwisetargetstats')->name('Yearly_Agents_Stats');

         //qa person ststs
         Route::get('/qaperson/stats/{id?}', 'qapersonwisformstats')->name('QAperson_Stats');


        //settings:
        //QA ISSUES:
        Route::get('/settings/qa_issues', 'qa_issues')->name('Create_QA_Issue');
        Route::post('/settings/qa_issues/Process', 'qa_issues_process');
        Route::get('/settings/delete_qa_issues/{id}', 'delete_qa_issues')->name('Delete_QA_Issue');

        //PRODUCTION SERVICES:
        Route::get('/settings/Production/services', 'Production_services')->name('Create_Production_Services');
        Route::post('/settings/Production/services/Process', 'Production_services_process');
        Route::get('/settings/delete_kycservices/{id}', 'delete_Production_services')->name('Delete_Production_Services');

        //ASSIGN PROJECT:
        Route::get('/settings/user/client', 'Assign_Client_to_qaperson')->name('Create_Assign_Client');
        Route::post('/settings/user/client/Process', 'Assign_Client_to_qaperson_process');
        Route::get('/settings/changeuser/client/{id}', 'Edit_Assign_Client_to_qaperson')->name('Edit_Assign_Client');
        Route::post('/settings/changeuser/client/{id}/Process', 'Edit_Assign_Client_to_qaperson_process');
        Route::get('/settings/user/client/delete/{id}', 'delete_Assign_Client_to_qaperson')->name('Delete_Assign_Client');

        //allpayment dashboard:
        Route::get('/finalallpaymentdashboard/{id?}', 'finalpaymentdashboard')->name('All_Brand_Dashboard');

        //month stats dashboard:
        Route::get('/stats/{id?}', 'monthStats')->name('Month_Stats');

        //Sales Original role
        Route::get('/sales/originalroles', 'originalroles')->name('Create_Agents_Original_Roles');
        Route::post('/sales/originalroles/process', 'originalrolesProcess');
        Route::get('/sales/originalroles/view', 'originalrolesProcess_View')->name('View_Agents_Original_Roles');

        Route::get('/sales/originalroles/edit/{id}', 'originalrolesedit')->name('Edit_Agents_Original_Roles');
        Route::post('/sales/originalroles/process/edit/{id}', 'originalrolesProcessedit');

        Route::get('/originalrolesdelete/{id}','originalrolesdelete')->name('Delete_Agents_Original_Roles');

        //brandTarget
        Route::get('/settarget', 'brandtarget')->name('Create_Brand_Target');
        Route::post('/settarget/process', 'brandtargetprocess');
        Route::get('/brandtarget', 'viewbrandtarget')->name('All_Brand_Target_List');
        Route::get('/settarget/edit/{id}', 'brandtargetedit')->name('Edit_Brand_Target');
        Route::post('/settarget/edit/process/{id}', 'brandtargetprocesseditprocess');
        //agentTarget
        Route::get('/setagenttarget', 'agenttarget')->name('Create_Agents_Target');
        Route::post('/setagenttarget/process', 'agent_targetprocess');
        Route::get('/setagenttarget/edit/{id}', 'agenttargetedit')->name('Edit_Agent_Target');
        Route::post('/setagenttarget/edit/process/{id}', 'agenttargetprocesseditprocess');
        Route::get('/allagenttarget', 'viewagenttarget')->name('All_Agent_Target_List');

        //csv_ppc:
        Route::get('/forms/csv_uploads_ppc', 'csv_ppc')->name('PPc_CSV');
        Route::post('/forms/csv_uploads_ppc/process', 'csv_ppc_process');
        // Route::get('/viewppc', 'viewppc');

        //csv_leads:
        Route::get('/forms/csv_uploads_leads', 'csv_leads')->name('Leads_CSV');
        Route::post('/forms/csv_uploads_leads/process', 'csv_leads_process');
        // Route::get('/viewleads', 'viewleads');

        //csv_target:
        Route::get('/forms/csv_uploads_target', 'target_csv')->name('targets_CSV');
        Route::post('/forms/csv_uploads_target/process', 'csv_target_process');


        //create_permitted_roles:
         Route::get('/assign/permissions', 'assignroles')->name('Create_Assign_Roles');
         Route::post('/assign/permissions/process', 'assignroles_process');
        //Edit_permitted_roles
         Route::get('/assign/permissions/edit/{id}', 'Editassignroles')->name('Edit_Roles');
         Route::post('/assign/permissions/Edit/process/{id}', 'Edit_assignroles_process');

         Route::get('/routes/permissions', 'routePermission_view')->name('All_Asssign_Roles_List');



        // Route::get('routes', function () {
        //     $routeCollection = Route::getRoutes();

        //     echo "<table style='width:100%'>";
        //     echo "<tr>";
        //     echo "<td width='10%'><h4>HTTP Method</h4></td>";
        //     echo "<td width='10%'><h4>Route</h4></td>";
        //     echo "<td width='10%'><h4>Name</h4></td>";
        //     echo "<td width='70%'><h4>Corresponding Action</h4></td>";
        //     echo "</tr>";
        //     foreach ($routeCollection as $value) {
        //         if($value->methods()[0] == "GET"){
        //         echo "<tr>";
        //         echo "<td>" . $value->methods()[0] . "</td>";
        //         echo "<td>" . $value->uri() . "</td>";
        //         echo "<td>" . $value->getName() . "</td>";
        //         echo "<td>" . $value->getActionName() . "</td>";
        //         echo "</tr>";
        //         }
        //     }
        //     echo "</table>";
        // });


    });
});
