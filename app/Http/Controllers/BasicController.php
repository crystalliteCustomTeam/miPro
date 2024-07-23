<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Brand;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Client;
use App\Models\ClientMeta;
use App\Models\Project;
use App\Models\ClientPayment;
use App\Models\EmployeePayment;
use App\Models\QAFORM;
use App\Models\QAFORM_METAS;
use App\Models\ProjectProduction;
use App\Models\QaIssues;
use App\Models\ProductionServices;
use App\Models\QaPersonClientAssign;
use App\Models\NewPaymentsClients;
use App\Models\RefundPayments;
use App\Models\UnmatchedPayments;
use App\Models\Disputedpayments;
use App\Models\BrandTarget;
use App\Models\AgentTarget;
use App\Models\PPC;
use App\Models\Leads;
use App\Models\Payments;
use App\Models\Salesteam;
use App\Models\BrandSalesRole;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClientImport;
use Illuminate\Support\Facades\Validator;

use function GuzzleHttp\json_decode;

class BasicController extends Controller
{
    function login()
    {
        return view('login');
    }

    function register()
    {
        return view('register');
    }

    function get_email()
    {
        return view("get_email");
    }

    function get_email_process(Request $request)
    {
        $email = $request->input('email');
        $match_email = Employee::where('email', $email)->get();
        $match_count = count($match_email);
        if ($match_count > 0) {
            $request->session()->put('GuestUser', $match_email);
            return redirect('/seo_kyc_form');
        } else {
            return redirect()->back()->with('Error', "Email Not Found!!");
        }
    }

    function kyclogout(Request $request)
    {
        $request->session()->forget(['GuestUser']);
        $request->session()->flush();
        return redirect('/auth');
    }

    function get_book_email()
    {
        return view("get_book_email");
    }

    function get_book_email_process(Request $request)
    {
        $email = $request->input('email');
        $match_email = Employee::where('email', $email)->get();
        $match_count = count($match_email);
        if ($match_count > 0) {
            $request->session()->put('GuestUser', $match_email);
            return redirect('/book_kyc_form');
        } else {
            return redirect()->back()->with('Error', "Email Not Found!!");
        }
    }

    function kyclogoutbook(Request $request)
    {
        $request->session()->forget(['GuestUser']);
        $request->session()->flush();
        return redirect('/book_auth');
    }

    function seo_kyc_form(Request $request)
    {
        $brand = Brand::all();
        $projectManager = Employee::get();
        $frontSeller = $request->session()->get('GuestUser');
        $department = Department::get();
        $productionservices = ProductionServices::get();

        return view('seo_kyc_form', [
            'Brands' => $brand,
            'ProjectManagers' => $projectManager,
            'frontSeller' => $frontSeller,
            'departments' => $department,
            'productionservices' => $productionservices
        ]);
    }

    // function seo_kyc_form(Request $request)
    // {
    //     $brand = Brand::all();
    //     $client = Client::all();
    //     $projectManager = Employee::get();
    //     $frontSeller = $request->session()->get('GuestUser');
    //     // echo("<pre>");
    //     // print_r($frontSeller[1]);
    //     // die();
    //     $department = Department::get();
    //     $productionservices = ProductionServices::get();

    //     return view('new_seo_kyc_form', [
    //         'Brands' => $brand,
    //         'clients' => $client,
    //         'ProjectManagers' => $projectManager,
    //         'frontSeller' => $frontSeller,
    //         'departments' => $department,
    //         'productionservices' => $productionservices
    //     ]);
    // }


    function seo_kyc_form_process(Request $request)
    {
        $firstemail = $request->input('email');

        $findclient = Client::where('email', $request->input('email'))->get();
        if (count($findclient) > 0) {
            return redirect()->back()->with('Error', 'Client Email Found Please Used New Email');
        }

        $createClient = Client::insertGetId([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $firstemail[0],
            'brand' => $request->input('brand'),
            'frontSeler' => $request->input('saleperson'),
            'website' => $request->input('website'),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s')
        ]);



        $SEO_ARRAY = [
            "KEYWORD_COUNT" => $request->input('KeywordCount'),
            "TARGET_MARKET" => $request->input('TargetMarket'),
            "OTHER_SERVICE" => $request->input('OtherServices'),
            "LEAD_PLATFORM" => $request->input('leadplatform'),
            "Payment_Nature" => $request->input('paymentnature'),
            "ANY_COMMITMENT" => $request->input('anycommitment')
        ];
        $clientmeta = DB::table('clientmetas')->insert([
            'clientID' => $createClient,
            'service' => $request->input('serviceType'),
            'packageName' => $request->input('package'),
            'amountPaid' =>  $request->input('projectamount'),
            'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
            'nextPayment' =>  $request->input('nextamount'),
            'paymentRecuring' => $request->input('ChargingPlan'),
            'orderDetails' => json_encode($SEO_ARRAY),
            'otheremail' => json_encode($firstemail),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s')
        ]);


        return redirect('/kyclogout');
    }

    function book_kyc_form(Request $request)
    {
        $brand = Brand::all();
        $projectManager = Employee::get();
        $frontSeller = $request->session()->get('GuestUser');
        $department = Department::get();
        $productionservices = ProductionServices::get();

        return view('book_kyc_form', [
            'Brands' => $brand,
            'ProjectManagers' => $projectManager,
            'frontSeller' => $frontSeller,
            'departments' => $department,
            'productionservices' => $productionservices
        ]);
    }

    function book_kyc_form_process(Request $request)
    {
        $firstemail = $request->input('email');

        $findclient = Client::where('email', $request->input('email'))->get();
        if (count($findclient) > 0) {
            return redirect()->back()->with('Error', 'Client Email Found Please Used New Email');
        }

        $createClient = Client::insertGetId([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $firstemail[0],
            'brand' => $request->input('brand'),
            'frontSeler' => $request->input('saleperson'),
            'website' => $request->input('website'),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s')
        ]);



        $BOOK_ARRAY = [
            "PRODUCT" => $request->input('product'),
            "MENU_SCRIPT" => $request->input('menuscript'),
            "BOOK_GENRE" => $request->input('bookgenre'),
            "COVER_DESIGN" => $request->input('coverdesign'),
            "TOTAL_NUMBER_OF_PAGES" => $request->input('totalnumberofpages'),
            "PUBLISHING_PLATFORM" => $request->input('publishingplatform'),
            "ISBN_OFFERED" => $request->input('isbn_offered'),
            "LEAD_PLATFORM" => $request->input('leadplatform'),
            "ANY_COMMITMENT" => $request->input('anycommitment')
        ];
        $clientmeta = DB::table('clientmetas')->insert([
            'clientID' => $createClient,
            'service' => $request->input('serviceType'),
            'packageName' => $request->input('package'),
            'amountPaid' =>  $request->input('projectamount'),
            'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
            'nextPayment' =>  $request->input('nextamount'),
            'paymentRecuring' => $request->input('ChargingPlan'),
            'orderDetails' => json_encode($BOOK_ARRAY),
            'otheremail' => json_encode($firstemail),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s')
        ]);


        return redirect('/kyclogoutbook');
    }

    function roleExits($request)
    {
        $loginUser = $request->session()->get('AdminUser');
        $array = json_decode(json_encode($loginUser), true);
        if (array_key_exists("userRole", $array)) {
            $superUser = $loginUser->userRole;
            $userID = $loginUser->id;
        } else {
            $superUser = 1;
            $userID = $loginUser[0]->id;
        }


        $departmentAccess = Department::whereJsonContains('users', "$userID")->get();
        return [$departmentAccess, $loginUser, $superUser];
    }

    function dashboard(Request $request)
    {
        $depart = Department::count();
        if ($depart > 0) {
            $loginUser = $this->roleExits($request);
            if ($loginUser[2] == 0) {
                $brand = Brand::get();
                $eachbranddata = [];
                foreach ($brand as $brands) {
                    $brandName = Brand::where("id", $brands->id)->get();
                    $brandclient = Client::where('brand', $brands->id)->count();
                    $brandrefund_Month = QAFORM::where('brandID', $brands->id)->whereMonth('created_at', now())->where('status', 'Refund')->Distinct('projectID')->latest('created_at')->count();
                    $branddispute_Month = QAFORM::where('brandID', $brands->id)->whereMonth('created_at', now())->where('status', 'Dispute')->Distinct('projectID')->latest('created_at')->count();
                    $eachbranddata[] = [$brandName, $brandclient, $brandrefund_Month, $branddispute_Month];
                }
                $idInQadepart = Department::where('name', 'LIKE', 'Q%')->get();
                $qapersons = json_decode($idInQadepart[0]->users);
                $eachPersonqaform = [];
                foreach ($qapersons as $users) {
                    $personName = Employee::where("id", $users)->get();
                    $qapersonsclients = QaPersonClientAssign::where("user", $users)->count();
                    $today_count = QAFORM::where('qaPerson', $users)->whereDate('created_at', '=', now()->toDateString())->count();
                    $currentMonth_disputedClients = QAFORM::where('qaPerson', $users)->whereMonth('created_at', now())->where('status', 'Dispute')->Distinct('projectID')->latest('created_at')->count();
                    $currentMonth_refundClients = QAFORM::where('qaPerson', $users)->whereMonth('created_at', now())->where('status', 'Refund')->Distinct('projectID')->latest('created_at')->count();
                    $eachPersonqaform[] = [$personName, $qapersonsclients, $today_count, $currentMonth_disputedClients, $currentMonth_refundClients];
                }
                $last5qaform = QAFORM::where('client_satisfaction', 'Extremely Dissatisfied')->orwhere('status_of_refund', 'High')->latest('id')->limit(5)->get();
                $last5qaformstatus = Count($last5qaform);
                $totalClient = Client::count();
                $totalrefund =  QAFORM::where('Refund_Requested', 'Yes')->Distinct('projectID')->latest('created_at')->count();
                $totaldispute =  QAFORM::where('status', 'Dispute')->Distinct('projectID')->latest('created_at')->count();
                //pie charts
                $status_OnGoing = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status', 'On Going')->count();
                $status_Dispute = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status', 'Dispute')->count();
                $status_Refund = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status', 'Refund')->count();
                $status_NotStartedYet = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status', 'Not Started Yet')->count();
                $remark_ExtremelySatisfied = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('client_satisfaction', 'Extremely Satisfied')->count();
                $remark_SomewhatSatisfied = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('client_satisfaction', 'Somewhat Satisfied')->count();
                $remark_NeitherSatisfiednorDissatisfied = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('client_satisfaction', 'Neither Satisfied nor Dissatisfied')->count();
                $remark_SomewhatDissatisfied = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('client_satisfaction', 'Somewhat Dissatisfied')->count();
                $remark_ExtremelyDissatisfied = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('client_satisfaction', 'Extremely Dissatisfied')->count();
                $ExpectedRefundDispute_GoingGood = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status_of_refund', 'Going Good')->count();
                $ExpectedRefundDispute_Low = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status_of_refund', 'Low')->count();
                $ExpectedRefundDispute_Moderate = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status_of_refund', 'Moderate')->count();
                $ExpectedRefundDispute_High = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status_of_refund', 'High')->count();
                //renewal,recurring,dispute,refund
                $Renewal_Month = NewPaymentsClients::whereYear('futureDate', now())
                    ->whereMonth('futureDate', now())
                    ->where('paymentNature', 'Renewal Payment')
                    ->where('refundStatus', 'Pending Payment')
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->get();
                $Renewal_Month_count = NewPaymentsClients::whereYear('futureDate', now())
                    ->whereMonth('futureDate', now())
                    ->where('paymentNature', 'Renewal Payment')
                    ->where('refundStatus', 'Pending Payment')
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->distinct('ClientID')->count();
                $Renewal_Month_sum = NewPaymentsClients::whereYear('futureDate', now())
                    ->whereMonth('futureDate', now())
                    ->where('paymentNature', 'Renewal Payment')
                    ->where('refundStatus', 'Pending Payment')
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->SUM('TotalAmount');

                $Recurring_Month = NewPaymentsClients::whereYear('futureDate', now())
                    ->whereMonth('futureDate', now())
                    ->where('paymentNature', 'Recurring Payment')
                    ->where('refundStatus', 'Pending Payment')
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->get();
                $Recurring_Month_count = NewPaymentsClients::whereYear('futureDate', now())
                    ->whereMonth('futureDate', now())
                    ->where('paymentNature', 'Recurring Payment')
                    ->where('refundStatus', 'Pending Payment')
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->distinct('ClientID')
                    ->count();
                $Recurring_Month_sum = NewPaymentsClients::whereYear('futureDate', now())
                    ->whereMonth('futureDate', now())
                    ->where('paymentNature', 'Recurring Payment')
                    ->where('refundStatus', 'Pending Payment')
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->SUM('TotalAmount');

                $Refund_Month = NewPaymentsClients::whereYear('paymentDate', now())
                    ->whereMonth('paymentDate', now())
                    ->where('refundStatus', 'Refund')
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->get();
                $Refund_count = NewPaymentsClients::whereYear('paymentDate', now())
                    ->whereMonth('paymentDate', now())
                    ->where('refundStatus', 'Refund')
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->distinct('ClientID')
                    ->count();
                $Refund_sum = NewPaymentsClients::whereYear('paymentDate', now())
                    ->whereMonth('paymentDate', now())
                    ->where('refundStatus', 'Refund')
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->SUM('TotalAmount');
                $Dispute_Month = NewPaymentsClients::whereYear('paymentDate', now())
                    ->whereMonth('paymentDate', now())
                    ->where('dispute', 'Dispute')
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->get();
                $Dispute_count = NewPaymentsClients::whereYear('paymentDate', now())
                    ->whereMonth('paymentDate', now())
                    ->where('dispute', 'Dispute')
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->distinct('ClientID')
                    ->count();
                $Dispute_sum = NewPaymentsClients::whereYear('paymentDate', now())
                    ->whereMonth('paymentDate', now())
                    ->where('dispute', 'Dispute')
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->SUM('TotalAmount');

                $eachbrand_RevenueStatus = [];
                foreach ($brand as $brands) {
                    $brandName = Brand::where("id", $brands->id)->get();
                    $brand_renewal = NewPaymentsClients::where('BrandID', $brands->id)->whereYear('futureDate', now())->whereMonth('futureDate', now())
                        ->where('paymentNature', 'Renewal Payment')
                        ->where('refundStatus', 'Pending Payment')
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->SUM('TotalAmount');
                    $brandrefund_recurring = NewPaymentsClients::where('BrandID', $brands->id)->whereYear('futureDate', now())->whereMonth('futureDate', now())
                        ->where('paymentNature', 'Recurring Payment')
                        ->where('refundStatus', 'Pending Payment')
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->SUM('TotalAmount');
                    $branddispute_refund = NewPaymentsClients::where('BrandID', $brands->id)->whereMonth('created_at', now())->whereYear('futureDate', now())->whereMonth('futureDate', now())
                        ->where('refundStatus', 'Refund')
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->SUM('TotalAmount');
                    $branddispute_dispute = NewPaymentsClients::where('BrandID', $brands->id)->whereMonth('created_at', now())->whereYear('futureDate', now())->whereMonth('futureDate', now())
                        ->where('dispute', 'Dispute')
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->SUM('TotalAmount');
                    $eachbrand_RevenueStatus[] = [$brandName, $brand_renewal, $brandrefund_recurring, $branddispute_refund, $branddispute_dispute];
                }

                // echo("<pre>");
                // print_r($eachbrand_RevenueStatus);
                // die();

                return view('dashboard', [
                    'eachbranddatas' => $eachbranddata,
                    'eachPersonqaform' => $eachPersonqaform,
                    'last5qaform' => $last5qaform,
                    'last5qaformstatus' => $last5qaformstatus,
                    'totalClient' => $totalClient,
                    'totalrefund' => $totalrefund,
                    'totaldispute' => $totaldispute,
                    'LoginUser' => $loginUser[1],
                    'departmentAccess' => $loginUser[0],
                    'superUser' => $loginUser[2],
                    //pie charts
                    'status_OnGoing' => $status_OnGoing,
                    'status_Dispute' => $status_Dispute,
                    'status_Refund' => $status_Refund,
                    'status_NotStartedYet' => $status_NotStartedYet,
                    'remark_ExtremelySatisfied' => $remark_ExtremelySatisfied,
                    'remark_SomewhatSatisfied' => $remark_SomewhatSatisfied,
                    'remark_NeitherSatisfiednorDissatisfied' => $remark_NeitherSatisfiednorDissatisfied,
                    'remark_SomewhatDissatisfied' => $remark_SomewhatDissatisfied,
                    'remark_ExtremelyDissatisfied' => $remark_ExtremelyDissatisfied,
                    'ExpectedRefundDispute_GoingGood' => $ExpectedRefundDispute_GoingGood,
                    'ExpectedRefundDispute_Low' => $ExpectedRefundDispute_Low,
                    'ExpectedRefundDispute_Moderate' => $ExpectedRefundDispute_Moderate,
                    'ExpectedRefundDispute_High' => $ExpectedRefundDispute_High,
                    //renewal,recurring,upsell
                    'Renewal_Months' => $Renewal_Month,
                    'Renewal_Month_counts' => $Renewal_Month_count,
                    'Renewal_Month_sums' => $Renewal_Month_sum,
                    'Recurring_Months' => $Recurring_Month,
                    'Recurring_Month_counts' => $Recurring_Month_count,
                    'Recurring_Month_sums' => $Recurring_Month_sum,
                    'Refund_Month' => $Refund_Month,
                    'Refund_count' => $Refund_count,
                    'Refund_sum' => $Refund_sum,
                    'Dispute_Month' => $Dispute_Month,
                    'Dispute_count' => $Dispute_count,
                    'Dispute_sum' => $Dispute_sum,
                    'eachbrand_RevenueStatus' => $eachbrand_RevenueStatus
                ]);
            } else {
                $total_client = QaPersonClientAssign::where("user", $loginUser[1][0]->id)->get();
                $client_status = Count($total_client);
                $today_count = QAFORM::where('qaPerson', $loginUser[1][0]->id)->whereDate('created_at', '=', now()->toDateString())->count();
                $week_count = QAFORM::where('qaPerson', $loginUser[1][0]->id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                $month_count = QAFORM::where('qaPerson', $loginUser[1][0]->id)->whereMonth('created_at', now())->count();
                $currentMonth_lowRiskClients = QAFORM::where('qaPerson', $loginUser[1][0]->id)->whereMonth('created_at', now())->where('status_of_refund', 'Low')->Distinct('projectID')->latest('created_at')->count();
                $currentMonth_mediumRiskClients = QAFORM::where('qaPerson', $loginUser[1][0]->id)->whereMonth('created_at', now())->where('status_of_refund', 'Moderate')->Distinct('projectID')->latest('created_at')->count();
                $currentMonth_highRiskClients = QAFORM::where('qaPerson', $loginUser[1][0]->id)->whereMonth('created_at', now())->where('status_of_refund', 'High')->Distinct('projectID')->latest('created_at')->count();
                $currentMonth_ongoingClients = QAFORM::where('qaPerson', $loginUser[1][0]->id)->whereMonth('created_at', now())->where('status', 'On Going')->Distinct('projectID')->latest('created_at')->count();
                $currentMonth_disputedClients = QAFORM::where('qaPerson', $loginUser[1][0]->id)->whereMonth('created_at', now())->where('status', 'Dispute')->Distinct('projectID')->latest('created_at')->count();
                $currentMonth_refundClients = QAFORM::where('qaPerson', $loginUser[1][0]->id)->whereMonth('created_at', now())->where('status', 'Refund')->Distinct('projectID')->latest('created_at')->count();
                $Total_disputedClients = QAFORM::where('qaPerson', $loginUser[1][0]->id)->where('status', 'Dispute')->Distinct('projectID')->latest('created_at')->count();
                $Total_refundClients = QAFORM::where('qaPerson', $loginUser[1][0]->id)->where('status', 'Refund')->Distinct('projectID')->latest('created_at')->count();
                $last5qaform = QAFORM::where('qaPerson', $loginUser[1][0]->id)->where(function ($query) {
                    $query->where('client_satisfaction', 'Extremely Dissatisfied')
                        ->orWhere('status_of_refund', 'High');
                })->latest('id')->limit(5)->get();
                $last5qaformstatus = Count($last5qaform);
                return view('dashboard', [
                    'currentMonth_lowRiskClients' => $currentMonth_lowRiskClients,
                    'currentMonth_mediumRiskClients' => $currentMonth_mediumRiskClients,
                    'currentMonth_highRiskClients' => $currentMonth_highRiskClients,
                    'currentMonth_ongoingClients' => $currentMonth_ongoingClients,
                    'currentMonth_disputedClients' => $currentMonth_disputedClients,
                    'currentMonth_refundClients' => $currentMonth_refundClients,
                    'Total_disputedClients' => $Total_disputedClients,
                    'Total_refundClients' => $Total_refundClients,
                    'total_client' => $total_client,
                    'client_status' => $client_status,
                    'todayform' => $today_count,
                    'weekform' => $week_count,
                    'monthform' => $month_count,
                    'last5qaform' => $last5qaform,
                    'last5qaformstatus' => $last5qaformstatus,
                    'LoginUser' => $loginUser[1],
                    'departmentAccess' => $loginUser[0],
                    'superUser' => $loginUser[2]
                ]);
            }
        } else {
            $loginUser = $request->session()->get('AdminUser');
            $superUser = $loginUser->userRole;
            $userID = $loginUser->id;

            return view('dashboard_without_department', [
                'LoginUser' => $loginUser,
                'departmentAccess' => $userID,
                'superUser' => $superUser
            ]);
        }
    }

    function paymentdashboard(Request $request, $id = null)
    {
        $loginUser = $this->roleExits($request);
        $brands = Brand::get();
        $salesteams = Salesteam::get();

        $Allsalesteams = Salesteam::get();

        $month = date('m');

        if ($month == 1) {
            $target = "January";
        } elseif ($month == 2) {
            $target = "February";
        } elseif ($month == 3) {
            $target = "March";
        } elseif ($month == 4) {
            $target = "April";
        } elseif ($month == 5) {
            $target = "May";
        } elseif ($month == 6) {
            $target = "June";
        } elseif ($month == 7) {
            $target = "July";
        } elseif ($month == 8) {
            $target = "August";
        } elseif ($month == 9) {
            $target = "September";
        } elseif ($month == 10) {
            $target = "October";
        } elseif ($month == 11) {
            $target = "November";
        } elseif ($month == 12) {
            $target = "December";
        }

        $year = date('Y');
        // echo($year);
        // die();

        $mainsalesTeam = [];
        $membersstatus = [];

        foreach ($Allsalesteams as $Allsalesteam) {
            //for lead;
            $leadfront = NewPaymentsClients::where('SalesPerson', $Allsalesteam->teamLead)
                ->whereMonth('paymentDate', now())
                ->where('paymentNature', 'New Lead')
                ->where('refundStatus', 'On Going')
                ->where('dispute', null)
                ->SUM('Paid');

            $leadback = NewPaymentsClients::where('SalesPerson', $Allsalesteam->teamLead)
                ->whereMonth('paymentDate', now())
                ->where('refundStatus', 'On Going')
                ->where('paymentNature', '!=', 'New Lead')
                ->where('dispute', null)
                ->SUM('Paid');

            $leadrefund = NewPaymentsClients::where('SalesPerson', $Allsalesteam->teamLead)
                ->whereMonth('paymentDate', now())
                ->where('refundStatus', 'Refund')
                ->where('dispute', null)
                ->SUM('Paid');

            $leadtarget = AgentTarget::where('AgentID', $Allsalesteam->teamLead)
                ->where('Year', $year)
                ->SUM($target);

            $netgainslead = $leadfront + $leadback - $leadrefund;

            $leadnet = $leadtarget - $netgainslead;


            $members = json_decode($Allsalesteam->members);

            foreach ($members as $member) {

                $emploeename = Employee::where('id', $member)->get();

                $memberfront = NewPaymentsClients::where('SalesPerson', $member)
                    ->whereMonth('paymentDate', now())
                    ->where('paymentNature', 'New Lead')
                    ->where('refundStatus', 'On Going')
                    ->where('dispute', null)
                    ->SUM('Paid');

                $memberback = NewPaymentsClients::where('SalesPerson', $member)
                    ->whereMonth('paymentDate', now())
                    ->where('refundStatus', 'On Going')
                    ->where('paymentNature', '!=', 'New Lead')
                    ->where('dispute', null)
                    ->SUM('Paid');

                $memberrefund = NewPaymentsClients::where('SalesPerson', $member)
                    ->whereMonth('paymentDate', now())
                    ->where('refundStatus', 'Refund')
                    ->where('dispute', null)
                    ->SUM('Paid');

                $membertarget = AgentTarget::where('AgentID', $member)
                    ->where('Year', $year)
                    ->SUM($target);

                $netgainsmember = $memberfront + $memberback - $memberrefund;
                $membernet = $membertarget - $netgainsmember;

                $membersstatus[] = [
                    'memberID' => $emploeename[0]->name,
                    'membertarget' => $membertarget,
                    'memberfront' => $memberfront,
                    'memberback' => $memberback,
                    'memberrefund' => $memberrefund,
                    'membernet' => $membernet,
                ];
            }

            $emploeenamelead = Employee::where('id', $Allsalesteam->teamLead)->get();



            $mainsalesTeam[] = [
                'leadID' => $emploeenamelead[0]->name,
                'leadtarget' => $leadtarget,
                'leadfront' => $leadfront,
                'leadback' => $leadback,
                'leadrefund' => $leadrefund,
                'leadnet' => $leadnet,
                'membersdata' => $membersstatus
            ];
        }


        foreach ($mainsalesTeam as &$mainsalesTeams) {
            $memberTargets = array();
            $memberNET = array();

            foreach ($mainsalesTeams['membersdata'] as $ind) {
                $memberTargets[] = $ind['membertarget'];
                $memberNET[] = $ind['membernet'];
            }

            $b = array_sum($memberTargets);
            $c = array_sum($memberNET);

            $eachteamtarget = $b + $mainsalesTeams['leadtarget'];
            $eachteamnetsales = $c + $mainsalesTeams['leadnet'];

            $mainsalesTeams['totalteamtarget'] = $eachteamtarget;
            $mainsalesTeams['totalteamnet'] = $eachteamnetsales;
        }


        return view('paymentDashboard', [
            'brands' => $brands,
            'salesteams' => $salesteams,
            'mainsalesTeam' => $mainsalesTeam,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    public function fetchbranddata(Request $request)
    {
        if ($request->month_id == "January") {
            $month = 1;
        } elseif ($request->month_id == "February") {
            $month = 2;
        } elseif ($request->month_id == "March") {
            $month = 3;
        } elseif ($request->month_id == "April") {
            $month = 4;
        } elseif ($request->month_id == "May") {
            $month = 5;
        } elseif ($request->month_id == "June") {
            $month = 6;
        } elseif ($request->month_id == "July") {
            $month = 7;
        } elseif ($request->month_id == "August") {
            $month = 8;
        } elseif ($request->month_id == "September") {
            $month = 9;
        } elseif ($request->month_id == "October") {
            $month = 10;
        } elseif ($request->month_id == "November") {
            $month = 11;
        } elseif ($request->month_id == "December") {
            $month = 12;
        }

        $getdepartment = Department::where('brand', $request->brand_id)
            ->where(function ($query) {
                $query->where('name', 'LIKE', '%Project Manager')
                    ->orWhere('name', 'LIKE', 'Project manager%')
                    ->orWhere('name', 'LIKE', '%Project manager%')
                    ->orwhere('name', 'LIKE', '%sale')
                    ->orWhere('name', 'LIKE', 'sale%')
                    ->orWhere('name', 'LIKE', '%sale%');
            })->get();


        $allUsers = [];

        foreach ($getdepartment as $getdepartments) {
            $allarrays = json_decode($getdepartments->users);
            array_push($allUsers, $allarrays);
        }

        $mergedArray = [];



        for ($i = 0; $i < count($allUsers); $i++) {
            for ($j = 0; $j < count($allUsers[$i]); $j++) {
                $mergedArray[] = $allUsers[$i][$j];
            }
        }

        // // Optionally, remove duplicates
        $mergedArray = array_unique($mergedArray);
        $employees = Employee::whereIn('id', $mergedArray)->get();
        $employeepayment = [];
        $employeetodayspayment = [];

        foreach ($employees as $employee) {

            $todayemppay = NewPaymentsClients::where('SalesPerson', $employee->id)
                ->where("BrandID", $request->brand_id)
                ->whereDate('paymentDate', '=', now()->toDateString())
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where(function ($query) {
                    $query->where('refundStatus', '!=', 'Refund')
                        ->orWhere('dispute', null);
                })
                ->sum('Paid');

            $employeetodayspayment[] = [
                'userID' => $employee->id,
                'name' => $employee->name,
                'allrevenue' => $todayemppay
            ];
        }

        foreach ($employees as $employee) {
            $getcomplete = NewPaymentsClients::where('SalesPerson', $employee->id)
                ->where("BrandID", $request->brand_id)
                ->whereYear('paymentDate', $request->year_id)
                ->whereMonth('paymentDate', $month)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                // ->where('paymentNature', 'New Lead')
                ->where(function ($query) {
                    $query->where('refundStatus', '!=', 'Refund')
                        ->orWhere('dispute', null);
                })
                ->get();

            $getcompletesum = NewPaymentsClients::where('SalesPerson', $employee->id)
                ->where("BrandID", $request->brand_id)
                ->whereYear('paymentDate', $request->year_id)
                ->whereMonth('paymentDate', $month)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                // ->where('paymentNature', 'New Lead')
                ->where(function ($query) {
                    $query->where('refundStatus', '!=', 'Refund')
                        ->orWhere('dispute', null);
                })
                ->sum('Paid');

            $getfront = NewPaymentsClients::where('SalesPerson', $employee->id)
                ->where("BrandID", $request->brand_id)
                ->whereYear('paymentDate', $request->year_id)
                ->whereMonth('paymentDate', $month)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('paymentNature', 'New Lead')
                ->where('paymentNature', '!=', 'Remaining')
                ->where(function ($query) {
                    $query->where('refundStatus', '!=', 'Refund')
                        ->orWhere('dispute', null);
                })
                ->get();

            $getfrontsum = NewPaymentsClients::where('SalesPerson', $employee->id)
                ->where("BrandID", $request->brand_id)
                ->whereYear('paymentDate', $request->year_id)
                ->whereMonth('paymentDate', $month)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('paymentNature', 'New Lead')
                ->where('paymentNature', '!=', 'Remaining')
                ->where(function ($query) {
                    $query->where('refundStatus', '!=', 'Refund')
                        ->orWhere('dispute', null);
                })
                ->sum('Paid');

            $getback = NewPaymentsClients::where('SalesPerson', $employee->id)
                ->where("BrandID", $request->brand_id)
                ->whereYear('paymentDate', $request->year_id)
                ->whereMonth('paymentDate', $month)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('paymentNature', '!=', 'New Lead')
                ->where('paymentNature', '!=', 'Remaining')
                ->where(function ($query) {
                    $query->where('refundStatus', '!=', 'Refund')
                        ->orWhere('dispute', null);
                })
                ->get();

            $getbacksum = NewPaymentsClients::where('SalesPerson', $employee->id)
                ->where("BrandID", $request->brand_id)
                ->whereYear('paymentDate', $request->year_id)
                ->whereMonth('paymentDate', $month)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('paymentNature', '!=', 'New Lead')
                ->where('paymentNature', '!=', 'Remaining')
                ->where(function ($query) {
                    $query->where('refundStatus', '!=', 'Refund')
                        ->orWhere('dispute', null);
                })
                ->sum('Paid');

            $getdispute = NewPaymentsClients::where('SalesPerson', $employee->id)
                ->where("BrandID", $request->brand_id)
                ->whereMonth('paymentDate', $month)
                ->whereYear('paymentDate', $request->year_id)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where(function ($query) {
                    $query->where('refundStatus', 'On Going')
                        ->where('dispute', "!=", null);
                })
                // ->get();
                ->sum('Paid');

            $getrefund = NewPaymentsClients::where('SalesPerson', $employee->id)
                ->where("BrandID", $request->brand_id)
                ->whereMonth('paymentDate', $month)
                ->whereYear('paymentDate', $request->year_id)
                ->where('refundStatus', 'Refund')
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('dispute', null)
                // ->get();
                ->sum('Paid');
            $countuserexist = AgentTarget::where('AgentID', $employee->id)
                ->where('Year', $request->year_id)
                ->count();
            if ($countuserexist > 0) {
                // $agenttarget = 101;
                $agenttargets = AgentTarget::where('AgentID', $employee->id)
                    ->where('Year', $request->year_id)
                    ->get();
                $desiredagentmonth = $request->month_id;
                $agenttarget  = $agenttargets[0]->$desiredagentmonth;
            } else {
                $agenttarget = 0;
            }


            $employeepayment[] = [
                'userID' => $employee->id,
                'name' => $employee->name,
                'allrevenue' => $getcomplete,
                'getcompletesum' => $getcompletesum,
                'front' => $getfront,
                'getfrontsum' => $getfrontsum,
                'back' => $getback,
                'getbacksum' => $getbacksum,
                'dispute' => $getdispute,
                'refund' => $getrefund,
                'agenttarget' => $agenttarget
            ];
        }

        $finalpaymentswithrem = [];
        $a = [];
        $b = [];
        $c = [];
        foreach ($employeepayment as $employeepayments) {
            $allrevforrem = $employeepayments['allrevenue'];
            foreach ($allrevforrem as $revenueremaining) {
                if (!is_null($revenueremaining->remainingID)) {
                    $allrevrem = NewPaymentsClients::select("Paid")
                        ->where("BrandID", $request->brand_id)
                        ->whereYear('paymentDate', $request->year_id)
                        ->whereMonth('paymentDate', $month)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('remainingID', $revenueremaining->remainingID)
                        ->where(function ($query) {
                            $query->where('refundStatus', '!=', 'Refund')
                                ->orWhere('dispute', null);
                        })
                        ->get();
                    // ->sum('Paid');
                    $a[] = [$allrevrem];
                }
            }

            $frontforrem = $employeepayments['front'];
            foreach ($frontforrem as $frontforrems) {
                if (!is_null($frontforrems->remainingID)) {
                    $frontrem = NewPaymentsClients::select("Paid")
                        ->where("BrandID", $request->brand_id)
                        ->whereYear('paymentDate', $request->year_id)
                        ->whereMonth('paymentDate', $month)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('remainingID', $frontforrems->remainingID)
                        ->where(function ($query) {
                            $query->where('refundStatus', '!=', 'Refund')
                                ->orWhere('dispute', null);
                        })
                        ->get();
                    // ->sum('Paid');
                    $b[] = [$frontrem];
                }
            }

            $backforrem = $employeepayments['back'];
            foreach ($backforrem as $backforrems) {
                if (!is_null($backforrems->remainingID)) {
                    $backrem = NewPaymentsClients::select("Paid")
                        ->where("BrandID", $request->brand_id)
                        ->whereYear('paymentDate', $request->year_id)
                        ->whereMonth('paymentDate', $month)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('remainingID', $backforrems->remainingID)
                        ->where(function ($query) {
                            $query->where('refundStatus', '!=', 'Refund')
                                ->orWhere('dispute', null);
                        })
                        ->get();
                    // ->sum('Paid');
                    $c[] = [$backrem];
                }
            }

            $finalpaymentswithrem[] = [
                'userID' => $employeepayments['userID'],
                'allrevenuerem' => array_sum($a),
                'frontrem' => array_sum($b),
                'backrem' => array_sum($c)
            ];
        }

        $emppaymentarray = [];

        foreach ($employeepayment as $detail) {
            $matched = false;

            // Iterate through each payment
            foreach ($finalpaymentswithrem as $payment) {
                // Check if the IDs match
                if ($detail['userID'] == $payment['userID']) {
                    $matched = true;
                    $emppaymentarray[] = [
                        'employeeID' => $detail['userID'],
                        'name' => $detail['name'],
                        'getcompletesum' => $detail['getcompletesum'],
                        'allrevenuerem' => $payment['allrevenuerem'],
                        'getfrontsum' => $detail['getfrontsum'],
                        'frontrem' => $payment['frontrem'],
                        'getbacksum' => $detail['getbacksum'],
                        'backrem' => $payment['backrem'],
                        'dispute' => $detail['dispute'],
                        'refund' => $detail['refund'],
                        'target' => $detail['agenttarget']
                    ];
                } else {
                    continue;
                }
            }
        }

        foreach ($emppaymentarray as &$emppaymentarrays) {
            $emppaymentarrays['totalcomplete'] = $emppaymentarrays['getcompletesum'] + $emppaymentarrays['allrevenuerem'];
            $emppaymentarrays['totalfront'] = $emppaymentarrays['getfrontsum'] + $emppaymentarrays['frontrem'];
            $emppaymentarrays['totalback'] = $emppaymentarrays['getbacksum'] + $emppaymentarrays['backrem'];
        }
        unset($emppaymentarrays);


        $brandtarget = BrandTarget::where("BrandID", $request->brand_id)->where('Year', $request->year_id)->first();
        $desiredBrand = $request->brand_id;
        $brandfronttodaypayment = NewPaymentsClients::where('BrandID', $desiredBrand)
            ->whereDate('paymentDate', '=', now()->toDateString())
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('paymentNature', 'New Lead')
            ->where(function ($query) {
                $query->where('refundStatus', '!=', 'Refund')
                    ->orWhere('dispute', null);
            })
            ->sum('Paid');

        $brandbacktodaypayment = NewPaymentsClients::where('BrandID', $desiredBrand)
            ->whereDate('paymentDate', '=', now()->toDateString())
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('paymentNature', '!=', 'New Lead')
            ->where(function ($query) {
                $query->where('refundStatus', '!=', 'Refund')
                    ->orWhere('dispute', null);
            })
            ->sum('Paid');

        $brandalltodaypayment = NewPaymentsClients::where('BrandID', $desiredBrand)
            ->whereDate('paymentDate', now()->toDateString())
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where(function ($query) {
                $query->where('refundStatus', '!=', 'Refund')
                    ->orWhereNull('dispute'); // Changed to orWhereNull for clarity
            })
            ->sum('Paid');


        $selectedbrandname = Brand::select('name')->where('id', $desiredBrand)->get();


        $brandsales = NewPaymentsClients::where("BrandID", $request->brand_id)
            ->whereMonth('paymentDate', $month)
            ->whereYear('paymentDate', $request->year_id)
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where(function ($query) {
                $query->where('refundStatus', '!=', 'Refund')
                    ->orwhere('dispute', null);
            })
            ->sum('Paid');


        $chargeback = NewPaymentsClients::where("BrandID", $request->brand_id)
            ->whereYear('paymentDate', $request->year_id)
            ->whereMonth('paymentDate', $month)
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where(function ($query) {
                $query->where('refundStatus', 'Refund')
                    ->orwhere('dispute', "!=", null);
            })
            ->sum('Paid');


        $net_revenue = $brandsales - $chargeback;

        $dispute =  NewPaymentsClients::where("BrandID", $request->brand_id)
            ->whereMonth('paymentDate', $month)
            ->whereYear('paymentDate', $request->year_id)
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where(function ($query) {
                $query->where('refundStatus', 'On Going')
                    ->where('dispute', "!=", null);
            })
            ->sum('Paid');

        $refund = NewPaymentsClients::where("BrandID", $request->brand_id)
            ->whereMonth('paymentDate', $month)
            ->whereYear('paymentDate', $request->year_id)
            ->where('refundStatus', 'Refund')
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('dispute', null)
            ->sum('Paid');

        $disputefees = NewPaymentsClients::where("BrandID", $request->brand_id)
            ->whereMonth('paymentDate', $month)
            ->whereYear('paymentDate', $request->year_id)
            ->where('refundStatus', 'Refund')
            ->where('paymentNature', 'Dispute Lost')
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('dispute', null)
            ->sum('disputefee');

        $front = NewPaymentsClients::where("BrandID", $request->brand_id)
            ->whereYear('paymentDate', $request->year_id)
            ->whereMonth('paymentDate', $month)
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('paymentNature', 'New Lead')
            ->where('paymentNature', '!=', 'Remaining')
            ->where(function ($query) {
                $query->where('refundStatus', '!=', 'Refund')
                    ->orWhere('dispute', null);
            })
            ->get();

        $frontsum = NewPaymentsClients::where("BrandID", $request->brand_id)
            ->whereYear('paymentDate', $request->year_id)
            ->whereMonth('paymentDate', $month)
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('paymentNature', 'New Lead')
            ->where('paymentNature', '!=', 'Remaining')
            ->where(function ($query) {
                $query->where('refundStatus', '!=', 'Refund')
                    ->orWhere('dispute', null);
            })
            ->sum("Paid");

        $remaining = [];

        foreach ($front as $fronts) {
            if (!is_null($fronts->remainingID)) {
                $frontnew = NewPaymentsClients::select('Paid')
                    ->where("BrandID", $request->brand_id)
                    ->whereYear('paymentDate', $request->year_id)
                    ->whereMonth('paymentDate', $month)
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->where('refundStatus', '!=', 'Pending Payment')
                    ->where('remainingID', $fronts->remainingID)
                    ->where('paymentNature', 'Remaining')
                    ->where(function ($query) {
                        $query->where('refundStatus', '!=', 'Refund')
                            ->orWhere('dispute', null);
                    })
                    ->get();
                // ->sum("Paid");
                $remaining[] = [$frontnew];
            }
        }
        $arraysum = array_sum($remaining);

        $totalfront = $arraysum + $frontsum;

        $back = NewPaymentsClients::where("BrandID", $request->brand_id)
            ->whereYear('paymentDate', $request->year_id)
            ->whereMonth('paymentDate', $month)
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('paymentNature', '!=', 'New Lead')
            ->where('paymentNature', '!=', 'Remaining')
            ->where(function ($query) {
                $query->where('refundStatus', '!=', 'Refund')
                    ->orWhere('dispute', null);
            })
            ->get();

        $backsum = NewPaymentsClients::where("BrandID", $request->brand_id)
            ->whereYear('paymentDate', $request->year_id)
            ->whereMonth('paymentDate', $month)
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('paymentNature', '!=', 'New Lead')
            ->where('paymentNature', '!=', 'Remaining')
            ->where(function ($query) {
                $query->where('refundStatus', '!=', 'Refund')
                    ->orWhere('dispute', null);
            })
            ->sum("Paid");

        $remainingback = [];

        foreach ($back as $backs) {
            if (!is_null($backs->remainingID)) {
                $backnew = NewPaymentsClients::Select("Paid")
                    ->where("BrandID", $request->brand_id)
                    ->whereYear('paymentDate', $request->year_id)
                    ->whereMonth('paymentDate', $month)
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->where('refundStatus', '!=', 'Pending Payment')
                    ->where('remainingID', $backs->remainingID)
                    ->where('paymentNature', 'Remaining')
                    ->where(function ($query) {
                        $query->where('refundStatus', '!=', 'Refund')
                            ->orWhere('dispute', null);
                    })
                    ->get();
                // ->sum("Paid");
                $remainingback[] = [$backnew];
            }
        }
        $arraysumback = array_sum($remainingback);
        $totalback = $arraysumback + $backsum;


        $brandrefundDispute = NewPaymentsClients::where('BrandID', $request->brand_id)
            ->whereYear('paymentDate', $request->year_id)
            ->whereMonth('paymentDate', $month)
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where(function ($query) {
                $query->where('refundStatus', 'Refund')
                    ->orWhere('dispute', '!=', null);
            })
            ->get();

        $disputerefund = [];
        foreach ($brandrefundDispute as $brandrefundDisputes) {
            $salespersonname = Employee::where('id', $brandrefundDisputes->SalesPerson)->get();
            $supportpersonname = Employee::where('id', $brandrefundDisputes->ProjectManager)->get();
            $clientname = Client::where('id', $brandrefundDisputes->ClientID)->get();
            $brandname = Brand::where('id', $brandrefundDisputes->BrandID)->get();

            if ($brandrefundDisputes->dispute == null) {
                $type = "Dispute";
            } else {
                $type = "Refund";
            }

            $disputerefund[] = [
                "date" => $brandrefundDisputes->paymentDate,
                "brand" => $brandname[0]->name,
                "client" => $clientname[0]->name,
                "amount" => $brandrefundDisputes->TotalAmount,
                "services" => $brandrefundDisputes->Description,
                "upseller" => 0,
                "support" => $supportpersonname[0]->name,
                "type" => $type,
                "frontperson" => $salespersonname[0]->name,

            ];
        }



        $brand_ongoing = NewPaymentsClients::whereMonth('paymentDate', now())
            ->where('BrandID', $request->brand_id)
            ->where('refundStatus', 'On Going')
            ->where('dispute', null)
            ->SUM('Paid');
        $brand_refund = NewPaymentsClients::whereMonth('paymentDate', now())
            ->where('BrandID', $request->brand_id)
            ->where('refundStatus', 'Refund')
            ->SUM('Paid');
        $brand_chargeback = NewPaymentsClients::whereMonth('paymentDate', now())
            ->where('BrandID', $request->brand_id)
            ->where('dispute', '!=', null)
            ->SUM('Paid');


        //is renewal and recurring both are included?
        $brand_renewal = NewPaymentsClients::whereMonth('paymentDate', now())
            ->where('BrandID', $request->brand_id)
            ->where('paymentNature', 'Renewal Payment')
            ->where('refundStatus', 'On Going')
            ->where('dispute', null)
            ->SUM('Paid');

        $brand_upsell = NewPaymentsClients::whereMonth('paymentDate', now())
            ->where('BrandID', $request->brand_id)
            ->where('paymentNature', 'Upsell')
            ->where('refundStatus', 'On Going')
            ->where('dispute', null)
            ->SUM('Paid');
        //is clearify the criteria of remainig
        $brand_newlead = NewPaymentsClients::whereMonth('paymentDate', now())
            ->where('BrandID', $request->brand_id)
            ->where('paymentNature', 'New Lead')
            ->where('refundStatus', 'On Going')
            ->where('dispute', null)
            ->SUM('Paid');


        if ($brandtarget == false) {

            $return_array = [
                "selectedbrandname" => $selectedbrandname,
                "message" => "NO BRAND FOUND !",
                "brandsales" => $brandsales,
                "chargeback" => $chargeback,
                "net_revenue" => $net_revenue,
                "dispute" => $dispute,
                "refund" => $refund,
                "disputefees" => $disputefees,
                "front" => $totalfront,
                "back" => $totalback,
                "employees" => $emppaymentarray,
                "brandfronttodaypayment" => $brandfronttodaypayment,
                "brandbacktodaypayment" => $brandbacktodaypayment,
                "brandalltodaypayment" => $brandalltodaypayment,
                "employeetodayspayment" => $employeetodayspayment,
                "disputerefund" => $disputerefund,
                "brand_ongoing" => $brand_ongoing,
                "brand_refund" => $brand_refund,
                "brand_chargeback" => $brand_chargeback,
                "brand_renewal" => $brand_renewal,
                "brand_upsell" => $brand_upsell,
                "brand_newlead" => $brand_newlead
            ];
        } else {
            $desiredmonth = $request->month_id;
            $brandtargetofMonth = $brandtarget->$desiredmonth;
            // $month = 0;
            if ($request->month_id == "January") {
                $month = 1;
            } elseif ($request->month_id == "February") {
                $month = 2;
            } elseif ($request->month_id == "March") {
                $month = 3;
            } elseif ($request->month_id == "April") {
                $month = 4;
            } elseif ($request->month_id == "May") {
                $month = 5;
            } elseif ($request->month_id == "June") {
                $month = 6;
            } elseif ($request->month_id == "July") {
                $month = 7;
            } elseif ($request->month_id == "August") {
                $month = 8;
            } elseif ($request->month_id == "September") {
                $month = 9;
            } elseif ($request->month_id == "October") {
                $month = 10;
            } elseif ($request->month_id == "November") {
                $month = 11;
            } elseif ($request->month_id == "December") {
                $month = 12;
            }

            $return_array = [
                "selectedbrandname" => $selectedbrandname,
                "brandtargetofMonth" => $brandtargetofMonth,
                "brandsales" => $brandsales,
                "chargeback" => $chargeback,
                "net_revenue" => $net_revenue,
                "dispute" => $dispute,
                "refund" => $refund,
                "disputefees" => $disputefees,
                "front" => $totalfront,
                "back" => $totalback,
                "employees" => $emppaymentarray,
                "brandfronttodaypayment" => $brandfronttodaypayment,
                "brandbacktodaypayment" => $brandbacktodaypayment,
                "brandalltodaypayment" => $brandalltodaypayment,
                "employeetodayspayment" => $employeetodayspayment,
                "disputerefund" => $disputerefund,
                "brand_ongoing" => $brand_ongoing,
                "brand_refund" => $brand_refund,
                "brand_chargeback" => $brand_chargeback,
                "brand_renewal" => $brand_renewal,
                "brand_upsell" => $brand_upsell,
                "brand_newlead" => $brand_newlead
            ];
        }

        return response()->json($return_array);
    }

    function allpaymentdashboard(Request $request, $id = null)
    {
        $loginUser = $this->roleExits($request);
        $brands = Brand::get();
        $salesteams = Salesteam::get();

        $Allsalesteams = Salesteam::get();

        $month = date('m');

        if ($month == 1) {
            $target = "January";
        } elseif ($month == 2) {
            $target = "February";
        } elseif ($month == 3) {
            $target = "March";
        } elseif ($month == 4) {
            $target = "April";
        } elseif ($month == 5) {
            $target = "May";
        } elseif ($month == 6) {
            $target = "June";
        } elseif ($month == 7) {
            $target = "July";
        } elseif ($month == 8) {
            $target = "August";
        } elseif ($month == 9) {
            $target = "September";
        } elseif ($month == 10) {
            $target = "October";
        } elseif ($month == 11) {
            $target = "November";
        } elseif ($month == 12) {
            $target = "December";
        }

        $year = date('Y');
        // echo($year);
        // die();

        $mainsalesTeam = [];
        $membersstatus = [];

        foreach ($Allsalesteams as $Allsalesteam) {
            //for lead;
            // $leadfront = NewPaymentsClients::where('SalesPerson', $Allsalesteam->teamLead)
            //     ->whereMonth('paymentDate', now())
            //     ->where('paymentNature', 'New Lead')
            //     ->where('refundStatus', 'On Going')
            //     ->where('dispute', null)
            //     ->SUM('Paid');

            $leadfront = NewPaymentsClients::where('SalesPerson', $Allsalesteam->teamLead)
                ->whereYear('paymentDate', now())
                ->whereMonth('paymentDate', now())
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus', '!=', 'Refund')
                ->where('transactionType', 'New Lead')
                ->sum("Paid");

            $leadback = NewPaymentsClients::where('SalesPerson', $Allsalesteam->teamLead)
                ->whereMonth('paymentDate', now())
                ->where('refundStatus', 'On Going')
                ->where('paymentNature', '!=', 'New Lead')
                ->where('dispute', null)
                ->SUM('Paid');

            $leadrefund = NewPaymentsClients::where('SalesPerson', $Allsalesteam->teamLead)
                ->whereMonth('paymentDate', now())
                ->where('refundStatus', 'Refund')
                ->where('dispute', null)
                ->SUM('Paid');

            $leadtarget = AgentTarget::where('AgentID', $Allsalesteam->teamLead)
                ->where('Year', $year)
                ->SUM($target);

            $netgainslead = $leadfront + $leadback - $leadrefund;

            $leadnet = $leadtarget - $netgainslead;


            $members = json_decode($Allsalesteam->members);

            foreach ($members as $member) {

                $emploeename = Employee::where('id', $member)->get();

                $memberfront = NewPaymentsClients::where('SalesPerson', $member)
                    ->whereMonth('paymentDate', now())
                    ->where('paymentNature', 'New Lead')
                    ->where('refundStatus', 'On Going')
                    ->where('dispute', null)
                    ->SUM('Paid');

                $memberback = NewPaymentsClients::where('SalesPerson', $member)
                    ->whereMonth('paymentDate', now())
                    ->where('refundStatus', 'On Going')
                    ->where('paymentNature', '!=', 'New Lead')
                    ->where('dispute', null)
                    ->SUM('Paid');

                $memberrefund = NewPaymentsClients::where('SalesPerson', $member)
                    ->whereMonth('paymentDate', now())
                    ->where('refundStatus', 'Refund')
                    ->where('dispute', null)
                    ->SUM('Paid');

                $membertarget = AgentTarget::where('AgentID', $member)
                    ->where('Year', $year)
                    ->SUM($target);

                $netgainsmember = $memberfront + $memberback - $memberrefund;
                $membernet = $membertarget - $netgainsmember;

                $membersstatus[] = [
                    'memberID' => $emploeename[0]->name,
                    'membertarget' => $membertarget,
                    'memberfront' => $memberfront,
                    'memberback' => $memberback,
                    'memberrefund' => $memberrefund,
                    'membernet' => $membernet,
                ];
            }

            $emploeenamelead = Employee::where('id', $Allsalesteam->teamLead)->get();



            $mainsalesTeam[] = [
                'leadID' => $emploeenamelead[0]->name,
                'leadtarget' => $leadtarget,
                'leadfront' => $leadfront,
                'leadback' => $leadback,
                'leadrefund' => $leadrefund,
                'leadnet' => $leadnet,
                'membersdata' => $membersstatus
            ];
        }


        foreach ($mainsalesTeam as &$mainsalesTeams) {
            $memberTargets = array();
            $memberNET = array();

            foreach ($mainsalesTeams['membersdata'] as $ind) {
                $memberTargets[] = $ind['membertarget'];
                $memberNET[] = $ind['membernet'];
            }

            $b = array_sum($memberTargets);
            $c = array_sum($memberNET);

            $eachteamtarget = $b + $mainsalesTeams['leadtarget'];
            $eachteamnetsales = $c + $mainsalesTeams['leadnet'];

            $mainsalesTeams['totalteamtarget'] = $eachteamtarget;
            $mainsalesTeams['totalteamnet'] = $eachteamnetsales;
        }


        return view('allBrandpaymentDashboard', [
            'brands' => $brands,
            'salesteams' => $salesteams,
            'mainsalesTeam' => $mainsalesTeam,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function fetchALLbranddata(Request $request)
    {
        ini_set('max_execution_time', 300);

        $checkbrand = $request->brand_id;
        $checkmonth = $request->month_id;
        $checkyear = $request->year_id;

        if ($checkbrand != null &&  $checkmonth != null && $checkyear != null) {
            $allbrandarray = $request->brand_id;
            $months = $request->month_id;
            $years = $request->year_id;
        } elseif ($checkbrand == null &&  $checkmonth != null && $checkyear != null) {
            $allbrandarray = Brand::pluck('id')->toArray();
            $months = $request->month_id;
            $years = $request->year_id;
        } elseif ($checkbrand != null &&  $checkmonth == null && $checkyear != null) {
            $allbrandarray = $request->brand_id;
            $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            $years = $request->year_id;
        } elseif ($checkbrand != null &&  $checkmonth != null && $checkyear == null) {
            $allbrandarray = $request->brand_id;
            $months =  $request->month_id;
            $currentYear = date("Y");
            $years = [];

            for ($i = 0; $i < 5; $i++) {
                $years[] = $currentYear - $i;
            }

            $years = array_reverse($years);

            $currentYear = date("Y");
            $years = [];

            for ($i = 0; $i < 5; $i++) {
                $years[] = $currentYear - $i;
            }

            $years = array_reverse($years);
        } elseif ($checkbrand == null &&  $checkmonth == null && $checkyear != null) {
            $allbrandarray = Brand::pluck('id')->toArray();
            $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            $years = $request->year_id;
        } elseif ($checkbrand != null &&  $checkmonth == null && $checkyear == null) {
            $allbrandarray =  $request->brand_id;
            $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            $currentYear = date("Y");
            $years = [];

            for ($i = 0; $i < 5; $i++) {
                $years[] = $currentYear - $i;
            }

            $years = array_reverse($years);

            $currentYear = date("Y");
            $years = [];

            for ($i = 0; $i < 5; $i++) {
                $years[] = $currentYear - $i;
            }

            $years = array_reverse($years);
        } elseif ($checkbrand == null &&  $checkmonth != null && $checkyear == null) {
            $allbrandarray = Brand::pluck('id')->toArray();
            $months = $request->month_id;
            $currentYear = date("Y");
            $years = [];

            for ($i = 0; $i < 5; $i++) {
                $years[] = $currentYear - $i;
            }

            $years = array_reverse($years);

            $currentYear = date("Y");
            $years = [];

            for ($i = 0; $i < 5; $i++) {
                $years[] = $currentYear - $i;
            }

            $years = array_reverse($years);
        } else {
            // $checkbrand == null &&  $checkmonth == null && $checkyear == null
            $allbrandarray = Brand::pluck('id')->toArray();
            $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            $currentYear = date("Y");
            $years = [];

            for ($i = 0; $i < 5; $i++) {
                $years[] = $currentYear - $i;
            }

            $years = array_reverse($years);

            $currentYear = date("Y");
            $years = [];

            for ($i = 0; $i < 5; $i++) {
                $years[] = $currentYear - $i;
            }

            $years = array_reverse($years);
        }

        $allbrandsrev = [];
        $allemployeepaymentfinal = [];
        $allbrandtodayspayments = [];
        $allemployeetodayspayments = [];
        $allbrandsalesdistributiongraph = [];
        $allbrandrefunddisputegraph = [];
        $allbrandschargebacks = [];
        $allbrandschargebacks1 = [];

        $days = [];
        $currentMonth = 0;
        $currentYear = 0;
        $daysInMonth = 0;

        if ($checkmonth != null && $checkyear != null && !isset($checkyear[1]) && !isset($checkmonth[1])) {

            $currentMonth = $checkmonth[0];
            if ($currentMonth == 1) {
                $monthinAlphabetic = "January";
            } elseif ($currentMonth == 2) {
                $monthinAlphabetic = "February";
            } elseif ($currentMonth == 3) {
                $monthinAlphabetic = "March";
            } elseif ($currentMonth == 4) {
                $monthinAlphabetic = "April";
            } elseif ($currentMonth == 5) {
                $monthinAlphabetic = "May";
            } elseif ($currentMonth == 6) {
                $monthinAlphabetic = "June";
            } elseif ($currentMonth == 7) {
                $monthinAlphabetic = "July";
            } elseif ($currentMonth == 8) {
                $monthinAlphabetic = "August";
            } elseif ($currentMonth == 9) {
                $monthinAlphabetic = "September";
            } elseif ($currentMonth == 10) {
                $monthinAlphabetic = "October";
            } elseif ($currentMonth == 11) {
                $monthinAlphabetic = "November";
            } elseif ($currentMonth == 12) {
                $monthinAlphabetic = "December";
            }
            $currentYear = $checkyear[0];
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
            $workingDays = [];
            $workingDayfinal = [];
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = Carbon::create($currentYear, $currentMonth, $day);
                $days[] = [
                    'date' => $date->toDateString(),
                    'name' => $date->format('l'),
                    'number' => $date->dayOfWeek,
                ];

                $dayOfWeek = $date->dayOfWeek;
                // Exclude weekends (Saturday and Sunday)
                if ($dayOfWeek != Carbon::SATURDAY && $dayOfWeek != Carbon::SUNDAY) {
                    $workingDays[] = $date;
                    $workingDayfinal[] = [
                        'date' => $date->toDateString(),
                        'name' => $date->format('l'),
                        'number' => $date->dayOfWeek,
                    ];
                }
            }

            $dayNames = array_column($days, 'name');

            $counts = array_count_values($dayNames);

            $totalworkingdays =  count($days) - $counts['Saturday'] -  $counts['Sunday'];

            $today = Carbon::today();


            $todaysindex = null;

            foreach ($workingDayfinal as $index => $day) {
                if ($day['date'] == $today->toDateString()) {
                    $todaysindex = $index;
                    break;
                }
            }

            $currentMonthcheck = $today->month;
            $currentYearcheck = $today->year;

            if ($currentMonth == $currentMonthcheck && $currentYear == $currentYearcheck) {
                $remainingWeekdays = count($days) - $counts['Saturday'] - $counts['Sunday'] - ($todaysindex + 1);
            } else {
                $remainingWeekdays = 0;
            }

            $workingdayscount = count($workingDays);

            $blankarrayall = [];
            $targetchasingraph = [];

            foreach ($workingDayfinal as $index => $day) {
                $blankarray = [];
                $targetdata = [];

                foreach ($allbrandarray as $brandID) {
                    $getpreviouspayment = NewPaymentsClients::whereMonth('paymentDate', now())
                        ->whereDate('paymentDate', '<', $day['date'])
                        ->where('BrandID', $brandID)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('paymentNature', '!=', 'Remaining')
                        ->where(function ($query) {
                            $query->where('paymentNature', 'New Lead')
                                ->orWhere('paymentNature', 'Upsell')
                                ->orWhere('paymentNature', 'Renewal Payment');
                        })
                        ->where(function ($query) {
                            $query->where('refundStatus', '!=', 'Refund')
                                ->orWhere('dispute', null);
                        })
                        ->sum('Paid');
                    $brand = Brand::find($brandID);


                    $datefrontpay = NewPaymentsClients::whereDate('paymentDate', $day['date'])
                        ->where('BrandID', $brandID)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('paymentNature', 'New Lead')
                        ->where('paymentNature', '!=', 'Remaining')
                        ->where(function ($query) {
                            $query->where('refundStatus', '!=', 'Refund')
                                ->orWhere('dispute', null);
                        })
                        ->sum('Paid');

                    $dateUpsellpay = NewPaymentsClients::whereDate('paymentDate', $day['date'])
                        ->where('BrandID', $brandID)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('paymentNature', 'Upsell')
                        ->where('paymentNature', '!=', 'Remaining')
                        ->where(function ($query) {
                            $query->where('refundStatus', '!=', 'Refund')
                                ->orWhere('dispute', null);
                        })
                        ->sum('Paid');

                    $dateRenewalpay = NewPaymentsClients::whereDate('paymentDate', $day['date'])
                        ->where('BrandID', $brandID)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('paymentNature', 'Renewal Payment')
                        ->where('paymentNature', '!=', 'Remaining')
                        ->where(function ($query) {
                            $query->where('refundStatus', '!=', 'Refund')
                                ->orWhere('dispute', null);
                        })
                        ->sum('Paid');

                    $monthbrandtarget = brandtarget::where('BrandID', $brandID)->where('Year', date('Y'))->sum(date('F'));
                    $perdaytarget = $monthbrandtarget / $totalworkingdays;

                    $remainingdayss = $workingdayscount - ($index + 1);
                    if ($remainingdayss == 0) {
                        $remainingdays = 1;
                    } else {
                        $remainingdays = $workingdayscount - ($index);
                    }

                    $outcome = ($monthbrandtarget - ($datefrontpay + $dateUpsellpay + $dateRenewalpay + $getpreviouspayment)) / $remainingdays;
                    $formattedOutcome = number_format($outcome, 0);


                    $blankarray[] = [
                        "brand" => $brand->name,
                        "front" => $datefrontpay,
                        "upsell" => $dateUpsellpay,
                        "renewal" => $dateRenewalpay,
                        "Aggregated_Sales" => $datefrontpay + $dateUpsellpay + $dateRenewalpay + $getpreviouspayment,
                        "Target" =>  $perdaytarget * ($index + 1),
                        "Daily_Target" => $formattedOutcome,
                    ];

                    // $dailyrevenues = NewPaymentsClients::whereDate('paymentDate', $day['date'])
                    //     ->where('BrandID', $brandID)
                    //     ->where('remainingStatus', '!=', 'Unlinked Payments')
                    //     ->where('refundStatus', '!=', 'Pending Payment')
                    //     ->where(function ($query) {
                    //         $query->where('refundStatus', '!=', 'Refund')
                    //             ->orWhere('dispute', null);
                    //     })
                    //     ->sum('Paid');

                    // $dailyrevenues = NewPaymentsClients::whereYear('paymentDate', date('Y', strtotime($day['date'])))
                    //     ->whereMonth('paymentDate', date('m', strtotime($day['date'])))
                    //     ->whereDate('paymentDate', '<=', $day['date'])
                    //     ->where('BrandID', $brandID)
                    //     ->where('remainingStatus', '!=', 'Unlinked Payments')
                    //     ->where('refundStatus', '!=', 'Pending Payment')
                    //     ->where(function ($query) {
                    //         $query->where('refundStatus', '!=', 'Refund')
                    //             ->orWhereNull('dispute');
                    //     })
                    //     ->sum('Paid');

                    // $dailyrevenues =NewPaymentsClients::whereYear('paymentDate', date('Y', strtotime($day['date'])))
                    //     ->whereMonth('paymentDate', date('m', strtotime($day['date'])))
                    //     ->whereDate('paymentDate', '<=', $day['date'])
                    //     ->where('BrandID', $brandID)
                    //     ->where('remainingStatus', '!=', 'Unlinked Payments')
                    //     ->where('refundStatus', '!=', 'Pending Payment')
                    //     ->where('refundStatus', '!=', 'Refund')
                    //     ->WhereNull('dispute')
                    //     ->sum('Paid');

                    // $dailyrevenues = DB::table('newpaymentsclients')
                    //     ->whereYear('paymentDate', date('Y', strtotime($day['date'])))
                    //     ->whereMonth('paymentDate', date('m', strtotime($day['date'])))
                    //     ->whereDate('paymentDate', '<=', $day['date'])
                    //     ->where('remainingStatus', '!=', 'Unlinked Payments')
                    //     ->where('refundStatus', '!=', 'Pending Payment')
                    //     ->where('refundStatus', '!=', 'Refund')
                    //     ->where('transactionType', 'New Lead')
                    //     ->sum("Paid");



                    $brandsales222 = DB::table('newpaymentsclients')
                        ->where('BrandID', $brandID)
                        ->whereYear('paymentDate', date('Y', strtotime($day['date'])))
                        ->whereMonth('paymentDate', date('m', strtotime($day['date'])))
                        ->whereDate('paymentDate', '<=', $day['date'])
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('refundStatus', '!=', 'Refund')
                        ->sum('Paid');

                    $dispute222 = DB::table('newpaymentsclients')
                        ->where('BrandID', $brandID)
                        ->whereYear('paymentDate', date('Y', strtotime($day['date'])))
                        ->whereMonth('paymentDate', date('m', strtotime($day['date'])))
                        ->whereDate('paymentDate', '<=', $day['date'])
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('refundStatus',  '!=', 'Refund')
                        ->where('dispute', '!=', null)
                        ->SUM('disputeattackamount');

                    $refund222 = DB::table('newpaymentsclients')
                        ->where('BrandID', $brandID)
                        ->whereYear('paymentDate', date('Y', strtotime($day['date'])))
                        ->whereMonth('paymentDate', date('m', strtotime($day['date'])))
                        ->whereDate('paymentDate', '<=', $day['date'])
                        ->where('refundStatus', 'Refund')
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('dispute', null)
                        ->sum('Paid');

                    $dailyrevenues = $brandsales222 - $dispute222 - $refund222;


                    $dailyrevenue = (int)$dailyrevenues;

                    $perdaytargetbrands = $perdaytarget * ($index + 1);
                    if ($perdaytargetbrands == 0) {
                        $perdaytargetbrand = 1;
                    } else {
                        $perdaytargetbrand = $perdaytargetbrands;
                    }

                    $targetforecast =   $dailyrevenue / $perdaytargetbrand;

                    $monthbrandtarget1 = brandtarget::where('BrandID', $brandID)->where('Year', $currentYear)->sum($monthinAlphabetic);

                    $perdaytargetforgraph = $monthbrandtarget1 / $totalworkingdays;

                    $targetdata[] = [
                        "brand" => $brand->name,
                        "revenue" => $dailyrevenue,
                        // "revenueforeast" => 0,
                        "Target" =>  $perdaytargetforgraph * ($index + 1),
                    ];
                }

                $blankarrayall[] = [
                    "date" => $day['date'],
                    "data" => $blankarray
                ];




                $targetchasingraph[] = [
                    "date" => $day['date'],
                    "data" => $targetdata
                ];
            }

            // Separate data for each brand by date
            // $separatedData = [];
            // foreach ($targetchasingraph as $entry) {
            //     $date = $entry['date'];
            //     foreach ($entry['data'] as $brandData) {
            //         $brand = $brandData['brand'];
            //         $separatedData[$brand][$date] = $brandData;
            //     }
            // }

            $separatedData = [];
            foreach ($targetchasingraph as $entry) {
                $date = $entry['date'];
                foreach ($entry['data'] as $brandData) {
                    $brandData['date'] = $date;  // Add date to brandData
                    $brand = $brandData['brand'];
                    $separatedData[$brand][] = $brandData;  // Append brandData to the brand array
                }
            }



            foreach ($separatedData as &$separatedDatas) {
                foreach ($separatedDatas as $key => &$separatedDatass) {
                    if ($key >= 2) {
                        $currectrevenue = $separatedDatass['revenue'];
                        $oneindexpreviousrevenue1 = $separatedDatas[$key - 1]['revenue'];

                        if ($oneindexpreviousrevenue1 != 0) {
                            $oneindexpreviousrevenue = $separatedDatas[$key - 1]['revenue'];
                        } elseif ($oneindexpreviousrevenue1 == 0) {
                            if (isset($separatedDatas[$key - 1]['revenueforecast']) && $separatedDatas[$key - 1]['revenueforecast'] != null) {
                                $oneindexpreviousrevenue = $separatedDatas[$key - 1]['revenueforecast'];
                            } else {
                                $oneindexpreviousrevenue = $separatedDatas[$key - 1]['revenue'];
                            }
                        } else {
                            $oneindexpreviousrevenue = $separatedDatas[$key - 1]['revenue'];
                        }

                        $twoindexpreviousrevenue1 = $separatedDatas[$key - 2]['revenue'];

                        if ($twoindexpreviousrevenue1 != 0) {
                            $twoindexpreviousrevenue = $separatedDatas[$key - 1]['revenue'];
                        } elseif ($twoindexpreviousrevenue1 == 0) {
                            if (isset($separatedDatas[$key - 1]['revenueforecast']) && $separatedDatas[$key - 1]['revenueforecast'] != null) {
                                $twoindexpreviousrevenue = $separatedDatas[$key - 1]['revenueforecast'];
                            } else {
                                $twoindexpreviousrevenue = $separatedDatas[$key - 1]['revenue'];
                            }
                        } else {
                            $twoindexpreviousrevenue = $separatedDatas[$key - 1]['revenue'];
                        }
                        $sumofrevenue = $currectrevenue + $oneindexpreviousrevenue + $twoindexpreviousrevenue;
                        $finalforecast = $sumofrevenue / 3;
                    } else {
                        $finalforecast = 0;
                    }

                    $separatedDatass['revenueforecast'] = $finalforecast;
                }
            }
        } else {
            $remainingWeekdays = 0;
            $separatedData = ['no data'];
            $blankarrayall[] = [
                "date" => 'nothing',
                "data" => 'nothing'
            ];
        }

        // agentswise:
        $allbranddepart = [];
        foreach ($allbrandarray  as $allbrandarrays) {
            $getdepartment = Department::where('brand', $allbrandarrays)
                ->where(function ($query) {
                    $query->where('name', 'LIKE', '%Project Manager')
                        ->orWhere('name', 'LIKE', 'Project manager%')
                        ->orWhere('name', 'LIKE', '%Project manager%')
                        ->orwhere('name', 'LIKE', '%sale')
                        ->orWhere('name', 'LIKE', 'sale%')
                        ->orWhere('name', 'LIKE', '%sale%');
                })
                ->get();
            foreach ($getdepartment as $getdepartments) {
                if (isset($getdepartments->users) && $getdepartments->users != null) {
                    $allbranddepart[] = [$getdepartments->users];
                } else {
                    // continue;
                    $allbranddepart[] = ['No Department Exist'];
                }
            }
        }



        $allUsers = [];

        foreach ($allbranddepart as $allbranddeparts) {
            if ($allbranddeparts[0] != 'No Department Exist') {
                $allarrays = json_decode($allbranddeparts[0]);
                array_push($allUsers, $allarrays);
            } else {
                continue;
            }
        }
        $mergedArray = [];



        for ($i = 0; $i < count($allUsers); $i++) {
            for ($j = 0; $j < count($allUsers[$i]); $j++) {
                $mergedArray[] = $allUsers[$i][$j];
            }
        }

        // // Optionally, remove duplicates
        $mergedArray = array_unique($mergedArray);
        $employees = Employee::whereIn('id', $mergedArray)->get();

        $employeetodayspayment = [];
        $employeepayment = [];

        if (isset($employees[0]->id) && $employees[0]->id != null) {
            foreach ($allbrandarray as $allbrandarrays) {
                $brandwise = [];
                $eachbrandname = Brand::where('id', $allbrandarrays)->get();
                foreach ($employees as $employee) {
                    $getcomplete = DB::table('newpaymentsclients')
                        ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                        ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                        ->where('BrandID', $allbrandarrays)
                        ->where('SalesPerson', $employee->id)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('refundStatus', '!=', 'Refund')
                        ->get();


                    $getcompletesum = DB::table('newpaymentsclients')
                        ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                        ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                        ->where('BrandID', $allbrandarrays)
                        ->where('SalesPerson', $employee->id)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('refundStatus', '!=', 'Refund')
                        ->sum('Paid');

                    $getfrontsum = DB::table('newpaymentsclients')
                        ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                        ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                        ->where('BrandID', $allbrandarrays)
                        ->where('SalesPerson', $employee->id)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('refundStatus', '!=', 'Refund')
                        ->where('transactionType', 'New Lead')
                        ->sum("Paid");

                    $getbacksum = DB::table('newpaymentsclients')
                        ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                        ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                        ->where('BrandID', $allbrandarrays)
                        ->where('SalesPerson', $employee->id)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('refundStatus', '!=', 'Refund')
                        ->where('transactionType', '!=', 'New Lead')
                        ->sum("Paid");

                    $getdispute = DB::table('newpaymentsclients')
                        ->whereIn(DB::raw('YEAR(disputeattack)'), $years)
                        ->whereIn(DB::raw('MONTH(disputeattack)'), $months)
                        ->where('BrandID', $allbrandarrays)
                        ->where('ProjectManager', $employee->id)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('refundStatus',  '!=', 'Refund')
                        ->where('dispute', '!=', null)
                        ->SUM('disputeattackamount');

                    $getrefund = DB::table('newpaymentsclients')
                        ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                        ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                        ->where('BrandID', $allbrandarrays)
                        ->where('ProjectManager', $employee->id)
                        ->where('refundStatus', 'Refund')
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('dispute', null)
                        ->sum('Paid');

                    $countuserexist = AgentTarget::where('AgentID', $employee->id)
                        ->whereIn('Year', $years)
                        ->count();
                    $monthsum = [];
                    if ($countuserexist > 0) {

                        foreach ($months as $month) {

                            if ($month == 1) {
                                $montha = "January";
                            } elseif ($month == 2) {
                                $montha = "February";
                            } elseif ($month == 3) {
                                $montha = "March";
                            } elseif ($month == 4) {
                                $montha = "April";
                            } elseif ($month == 5) {
                                $montha = "May";
                            } elseif ($month == 6) {
                                $montha = "June";
                            } elseif ($month == 7) {
                                $montha = "July";
                            } elseif ($month == 8) {
                                $montha = "August";
                            } elseif ($month == 9) {
                                $montha = "September";
                            } elseif ($month == 10) {
                                $montha = "October";
                            } elseif ($month == 11) {
                                $montha = "November";
                            } elseif ($month == 12) {
                                $montha = "December";
                            }
                            $agenttargets =  AgentTarget::where('AgentID', $employee->id)
                                ->whereIn('Year', $years)
                                ->sum($montha);

                            $monthsum[] = [$agenttargets];
                        }

                        $agenttarget = 0;

                        foreach ($monthsum as $innerArray) {
                            // Sum the values of the inner arrays
                            $agenttarget += $innerArray[0];
                        }
                    } else {
                        $agenttarget = 0;
                    }


                    $brandwise[] = [
                        'userID' => $employee->id,
                        'name' => $employee->name,
                        // 'allrevenue' => $getcomplete,
                        'getcompletesum' => $getcompletesum,
                        'getfrontsum' => $getfrontsum,
                        'getbacksum' => $getbacksum,
                        'dispute' => $getdispute,
                        'refund' => $getrefund,
                        'agenttarget' => $agenttarget,
                    ];
                }

                $checkcomplesum = 0;
                $checkrefundsum = 0;
                $checkdisputesum = 0;

                foreach ($brandwise as $brandwises) {
                    // Sum the values of the inner arrays
                    $checkcomplesum += $brandwises["getcompletesum"];
                    $checkrefundsum += $brandwises["refund"];
                    $checkdisputesum += $brandwises["dispute"];
                }

                if ($checkcomplesum != 0 && $checkrefundsum == 0 && $checkdisputesum == 0) {
                    $check = "True";
                } elseif ($checkcomplesum == 0 && $checkrefundsum != 0 && $checkdisputesum == 0) {
                    $check = "True";
                } elseif ($checkcomplesum == 0 && $checkrefundsum == 0 && $checkdisputesum != 0) {
                    $check = "True";
                } elseif ($checkcomplesum != 0 && $checkrefundsum != 0 && $checkdisputesum == 0) {
                    $check = "True";
                } elseif ($checkcomplesum == 0 && $checkrefundsum != 0 && $checkdisputesum != 0) {
                    $check = "True";
                } elseif ($checkcomplesum != 0 && $checkrefundsum == 0 && $checkdisputesum != 0) {
                    $check = "True";
                } elseif ($checkcomplesum != 0 && $checkrefundsum != 0 && $checkdisputesum != 0) {
                    $check = "True";
                } else {
                    $check = "False";
                }

                $employeepayment[] = [
                    'brandname' => $eachbrandname[0]->name,
                    'data' => $brandwise,
                    'check' => $check
                ];
            }
            //employees todays payment:
            $employeetodayspayment = [];
            foreach ($employees as $employee) {

                $todayemppay = NewPaymentsClients::where('SalesPerson', $employee->id)
                    ->whereDate('paymentDate', '=', now()->toDateString())
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->where('refundStatus', '!=', 'Pending Payment')
                    ->where('refundStatus', '!=', 'Refund')
                    ->sum('Paid');

                $employeetodayspayment[] = [
                    'userID' => $employee->id,
                    'name' => $employee->name,
                    'allrevenue' => $todayemppay
                ];
            }
        } else {

            $employeepayment[] = [
                // 'userID' => 0,
                // 'name' => 'No Department',
                // 'allrevenue' => 0,
                // 'getcompletesum' => 0,
                // 'getfrontsum' => 0,
                // 'getbacksum' => 0,
                // 'dispute' => 0,
                // 'refund' => 0,
                // 'agenttarget' => 0
                'brandname' => 0,
                'data' => 0,
                'check' => "False"
            ];

            $employeetodayspayment[] = [
                'userID' => 0,
                'name' => 'No Department',
                'allrevenue' => 0
            ];
        }

        foreach ($allbrandarray as $allbrandarrays) {

            //target, sales,refund,net;

            $selectedbrandname = Brand::where('id', $allbrandarrays)->get();


            $monthsumbrand = [];

            foreach ($months as $month) {

                if ($month == 1) {
                    $montha = "January";
                } elseif ($month == 2) {
                    $montha = "February";
                } elseif ($month == 3) {
                    $montha = "March";
                } elseif ($month == 4) {
                    $montha = "April";
                } elseif ($month == 5) {
                    $montha = "May";
                } elseif ($month == 6) {
                    $montha = "June";
                } elseif ($month == 7) {
                    $montha = "July";
                } elseif ($month == 8) {
                    $montha = "August";
                } elseif ($month == 9) {
                    $montha = "September";
                } elseif ($month == 10) {
                    $montha = "October";
                } elseif ($month == 11) {
                    $montha = "November";
                } elseif ($month == 12) {
                    $montha = "December";
                }

                $brandtargets =  BrandTarget::where("BrandID", $allbrandarrays)
                    ->whereIn('Year', $years)
                    ->sum($montha);

                $monthsumbrand[] = [$brandtargets];
            }

            $brandtarget = 0;

            foreach ($monthsumbrand as $innerArray) {
                // Sum the values of the inner arrays
                $brandtarget += $innerArray[0];
            }


            $brandsales = DB::table('newpaymentsclients')
                ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                ->where('BrandID', $allbrandarrays)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus', '!=', 'Refund')
                ->sum('Paid');

            //ok
            $chargeback = DB::table('newpaymentsclients')
                ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                ->where('BrandID', $allbrandarrays)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where(function ($query) {
                    $query->where('refundStatus', 'Refund')
                        ->orwhere('dispute', "!=", null);
                })
                ->sum('Paid');




            $frontsum = DB::table('newpaymentsclients')
                ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                ->where('BrandID', $allbrandarrays)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus', '!=', 'Refund')
                ->where('transactionType', 'New Lead')
                ->sum("Paid");

            $totalfront = $frontsum;

            $backsum = DB::table('newpaymentsclients')
                ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                ->where('BrandID', $allbrandarrays)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus', '!=', 'Refund')
                ->where('transactionType', '!=', 'New Lead')
                ->sum("Paid");

            $totalback =  $backsum;

            $frontBacksum = $totalfront + $totalback;

            //disputes:

            $dispute = DB::table('newpaymentsclients')
                ->whereIn(DB::raw('YEAR(disputeattack)'), $years)
                ->whereIn(DB::raw('MONTH(disputeattack)'), $months)
                ->where('BrandID', $allbrandarrays)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus',  '!=', 'Refund')
                ->where('dispute', '!=', null)
                ->SUM('disputeattackamount');

            $refund = DB::table('newpaymentsclients')
                ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                ->where('BrandID', $allbrandarrays)
                ->where('refundStatus', 'Refund')
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('dispute', null)
                ->sum('Paid');

            $net_revenue = $brandsales - $dispute -  $refund;

            $disputefees = DB::table('newpaymentsclients')
                ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                ->where('BrandID', $allbrandarrays)
                ->where('refundStatus', 'Refund')
                // ->where('paymentNature', 'Dispute Lost')
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('dispute', '!=', null)
                ->sum('disputefee');

            $allbrandsrev[] = [
                "name" => $selectedbrandname[0]->name,
                "brandtarget" => $brandtarget,
                "brandsales" => $brandsales,
                "disputes" => $chargeback,
                "net_revenue" => $net_revenue,
                "totalfront" => $totalfront,
                "totalback" => $totalback,
                "frontBacksum" => $frontBacksum,
                "dispute" => $dispute,
                "refund" => $refund,
                "disputefees" => $disputefees
            ];

            //brands today payment ;
            $brandfronts = NewPaymentsClients::where('BrandID', $allbrandarrays)
                ->whereDate('paymentDate', '=', now()->toDateString())
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus', '!=', 'Refund')
                ->where('transactionType', 'New Lead')
                ->sum('Paid');


            if (isset($brandfronts) && $brandfronts != null) {
                $brandfront = $brandfronts;
            } else {
                $brandfront = 0;
            }

            $brandbacks = NewPaymentsClients::where('BrandID', $allbrandarrays)
                ->whereDate('paymentDate', '=', now()->toDateString())
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('transactionType', '!=', 'New Lead')
                ->where('refundStatus', '!=', 'Refund')
                // ->where('paymentNature', 'New Lead')
                ->sum('Paid');

            if (isset($brandbacks) && $brandbacks != null) {
                $brandback = $brandbacks;
            } else {
                $brandback = 0;
            }

            $brandalls = NewPaymentsClients::where('BrandID', $allbrandarrays)
                ->whereDate('paymentDate', '=', now()->toDateString())
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus', '!=', 'Refund')
                ->sum('Paid');

            if (isset($brandalls) && $brandalls != null) {
                $brandall = $brandalls;
            } else {
                $brandall = 0;
            }


            $allbrandtodayspayments[] = [
                "name" => $selectedbrandname[0]->name,
                "front" => $brandfront,
                "back" => $brandback,
                "all" => $brandall
            ];


            //graphs:
            $brand_ongoings = DB::table('newpaymentsclients')
                ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                ->where('BrandID', $allbrandarrays)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus', '!=', 'Refund')
                ->where('dispute', null)
                ->SUM('Paid');

            $brand_refund = DB::table('newpaymentsclients')
                ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                ->where('BrandID', $allbrandarrays)
                ->where('refundStatus', 'Refund')
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('dispute', null)
                ->sum('Paid');

            $brand_ongoing = $brand_ongoings - $brand_refund;

            $brand_chargeback = DB::table('newpaymentsclients')
                ->whereIn(DB::raw('YEAR(disputeattack)'), $years)
                ->whereIn(DB::raw('MONTH(disputeattack)'), $months)
                ->where('BrandID', $allbrandarrays)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus',  '!=', 'Refund')
                ->where('dispute', '!=', null)
                ->SUM('disputeattackamount');



            $allbrandrefunddisputegraph[] = [
                "name" => $selectedbrandname[0]->name,
                "brand_ongoing" => $net_revenue,
                "brand_refund" => $brand_refund,
                "brand_chargeback" => $brand_chargeback
            ];


            $brand_renewal = DB::table('newpaymentsclients')
                ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                ->where('BrandID', $allbrandarrays)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus', '!=', 'Refund')
                ->whereIn('paymentNature', ['Renewal Payment', 'Recurring Payment'])
                ->sum("Paid");

            $brand_upsell = DB::table('newpaymentsclients')
                ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                ->where('BrandID', $allbrandarrays)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus', '!=', 'Refund')
                ->where('paymentNature', 'Upsell')
                ->sum("Paid");

            $brand_newlead = DB::table('newpaymentsclients')
                ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                ->where('BrandID', $allbrandarrays)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus', '!=', 'Refund')
                ->where('transactionType', 'New Lead')
                ->sum("Paid");

            $allbrandsalesdistributiongraph[] = [
                "name" => $selectedbrandname[0]->name,
                "brand_renewal" => $brand_renewal,
                "brand_upsell" => $brand_upsell,
                "brand_newlead" => $brand_newlead
            ];

            //brand dispute and refund:
            $brandrefundDispute = DB::table('newpaymentsclients')
                ->whereIn(DB::raw('YEAR(paymentDate)'), $years)
                ->whereIn(DB::raw('MONTH(paymentDate)'), $months)
                ->where('BrandID', $allbrandarrays)
                ->where('refundStatus', 'Refund')
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('dispute', null)
                ->get();

            $disputerefund = [];
            if (isset($brandrefundDispute[0]->SalesPerson) && $brandrefundDispute[0]->SalesPerson != null) {
                foreach ($brandrefundDispute as $brandrefundDisputes) {
                    $salespersonname = Employee::where('id', $brandrefundDisputes->SalesPerson)->get();
                    $supportpersonname = Employee::where('id', $brandrefundDisputes->ProjectManager)->get();
                    $clientname = Client::where('id', $brandrefundDisputes->ClientID)->get();
                    $brandname = Brand::where('id', $brandrefundDisputes->BrandID)->get();

                    if (isset($supportpersonname[0]->name)) {
                        $sname = $supportpersonname[0]->name;
                    } else {
                        $sname = "Undefined";
                    }

                    if (isset($salespersonname[0]->name)) {
                        $selname = $salespersonname[0]->name;
                    } else {
                        $selname = "Undefined";
                    }

                    if (isset($brandname[0]->name)) {
                        $bname = $brandname[0]->name;
                    } else {
                        $bname = "Undefined";
                    }

                    if (isset($clientname[0]->name)) {
                        $cname = $clientname[0]->name;
                    } else {
                        $cname = "Undefined";
                    }

                    $disputerefund[] = [
                        "date" => $brandrefundDisputes->paymentDate,
                        "brand" => $bname,
                        "client" => $cname,
                        "amount" => $brandrefundDisputes->Paid,
                        "services" => $brandrefundDisputes->Description,
                        "upseller" => 0,
                        "support" => $sname,
                        "type" => "Refund",
                        "frontperson" => $selname,

                    ];
                }
            } else {
                $disputerefund[] = [

                    "date" => '--',
                    "brand" => '--',
                    "client" => '--',
                    "amount" => '--',
                    "services" => '--',
                    "upseller" => '--',
                    "support" => '--',
                    "type" => '--',
                    "frontperson" => '--'

                ];
            }

            $allbrandschargebacks[] = [
                "chargebacks" => $disputerefund
            ];

            $brandrefundDispute1 = DB::table('newpaymentsclients')
                ->whereIn(DB::raw('YEAR(disputeattack)'), $years)
                ->whereIn(DB::raw('MONTH(disputeattack)'), $months)
                ->where('BrandID', $allbrandarrays)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus',  '!=', 'Refund')
                ->where('dispute', '!=', null)
                ->get();

            $disputerefund1 = [];
            if (isset($brandrefundDispute1[0]->SalesPerson) && $brandrefundDispute1[0]->SalesPerson != null) {
                foreach ($brandrefundDispute1 as $brandrefundDisputes) {
                    $salespersonname = Employee::where('id', $brandrefundDisputes->SalesPerson)->get();
                    $supportpersonname = Employee::where('id', $brandrefundDisputes->ProjectManager)->get();
                    $clientname = Client::where('id', $brandrefundDisputes->ClientID)->get();
                    $brandname = Brand::where('id', $brandrefundDisputes->BrandID)->get();

                    if (isset($supportpersonname[0]->name)) {
                        $sname = $supportpersonname[0]->name;
                    } else {
                        $sname = "Undefined";
                    }

                    if (isset($salespersonname[0]->name)) {
                        $selname = $salespersonname[0]->name;
                    } else {
                        $selname = "Undefined";
                    }

                    if (isset($brandname[0]->name)) {
                        $bname = $brandname[0]->name;
                    } else {
                        $bname = "Undefined";
                    }

                    if (isset($clientname[0]->name)) {
                        $cname = $clientname[0]->name;
                    } else {
                        $cname = "Undefined";
                    }

                    $disputerefund1[] = [
                        "date" => $brandrefundDisputes->paymentDate,
                        "brand" => $bname,
                        "client" => $cname,
                        "amount" => $brandrefundDisputes->disputeattackamount,
                        "services" => $brandrefundDisputes->Description,
                        "upseller" => 0,
                        "support" => $sname,
                        "type" => "Dispute",
                        "frontperson" => $selname,

                    ];
                }
            } else {
                $disputerefund1[] = [

                    "date" => '--',
                    "brand" => '--',
                    "client" => '--',
                    "amount" => '--',
                    "services" => '--',
                    "upseller" => '--',
                    "support" => '--',
                    "type" => '--',
                    "frontperson" => '--'

                ];
            }


            $allbrandschargebacks1[] = [
                "chargebacks" => $disputerefund1
            ];
        }


        $onlyrefunds = [];
        foreach ($allbrandschargebacks as $allbrandschargebackss) {
            if ($allbrandschargebackss['chargebacks'][0]['date'] != "--") {
                $abc = $allbrandschargebackss['chargebacks'];
                foreach ($abc as $abcs) {
                    $onlyrefunds[] = [$abcs];
                }
            } else {
                continue;
            }
        }

        $onlydisputes = [];
        foreach ($allbrandschargebacks1 as $allbrandschargebacksss) {
            if ($allbrandschargebacksss['chargebacks'][0]['date'] != "--") {
                $abc1 = $allbrandschargebacksss['chargebacks'];
                foreach ($abc1 as $abcss) {
                    $onlydisputes[] = [$abcss];
                }
            } else {
                continue;
            }
        }

        $groupedData = [];

        foreach ($onlyrefunds as $entry) {
            foreach ($entry as $record) {
                $brand = $record['brand'];
                if (!isset($groupedData[$brand])) {
                    $groupedData[$brand] = [];
                }
                $groupedData[$brand][] = $record;
            }
        }

        foreach ($onlydisputes as $entry1) {
            foreach ($entry1 as $record1) {
                $brand = $record1['brand']; // Corrected variable to $record1
                if (!isset($groupedData[$brand])) {
                    $groupedData[$brand] = [];
                }
                $groupedData[$brand][] = $record1;
            }
        }

        // print_r($groupedData);
        // die();

        $return_array = [
            "netrevenue" => $allbrandsrev,
            "brandtoday" => $allbrandtodayspayments,
            "salesgraph" => $allbrandsalesdistributiongraph,
            "disputegraph" => $allbrandrefunddisputegraph,
            "chargebacks" => $onlyrefunds,
            "chargebacks1" => $onlydisputes,
            "combinebrandwiserefdis" => $groupedData,
            "employeepayment" => $employeepayment,
            "emptodayspayment" => $employeetodayspayment,
            "days" => $blankarrayall,
            "targetchasingraph" => $separatedData,
            'remainingworkingdays' => $remainingWeekdays,
            // "emppaymentarray1" => $employeepayment1,
        ];

        return response()->json($return_array);
    }

    function finalpaymentdashboard(Request $request, $id = null)
    {
        $loginUser = $this->roleExits($request);
        $brands = Brand::get();
        $salesteams = Salesteam::get();

        $Allsalesteams = Salesteam::get();

        $month = date('m');

        if ($month == 1) {
            $target = "January";
        } elseif ($month == 2) {
            $target = "February";
        } elseif ($month == 3) {
            $target = "March";
        } elseif ($month == 4) {
            $target = "April";
        } elseif ($month == 5) {
            $target = "May";
        } elseif ($month == 6) {
            $target = "June";
        } elseif ($month == 7) {
            $target = "July";
        } elseif ($month == 8) {
            $target = "August";
        } elseif ($month == 9) {
            $target = "September";
        } elseif ($month == 10) {
            $target = "October";
        } elseif ($month == 11) {
            $target = "November";
        } elseif ($month == 12) {
            $target = "December";
        }

        $year = date('Y');

        $mainsalesTeam = [];

        foreach ($Allsalesteams as $Allsalesteam) {
            //for lead;

            $leadfront = NewPaymentsClients::where('SalesPerson', $Allsalesteam->teamLead)
                ->whereYear('paymentDate',  now())
                ->whereMonth('paymentDate',  now())
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus', '!=', 'Refund')
                ->where('transactionType', 'New Lead')
                ->sum("Paid");

            $leadback = NewPaymentsClients::where('SalesPerson', $Allsalesteam->teamLead)
                ->whereYear('paymentDate',  now())
                ->whereMonth('paymentDate',  now())
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus', '!=', 'Refund')
                ->where('transactionType', '!=', 'New Lead')
                ->sum("Paid");

            $dispute = NewPaymentsClients::where('SalesPerson', $Allsalesteam->teamLead)
                ->whereYear('disputeattack',  now())
                ->whereMonth('disputeattack',  now())
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus',  '!=', 'Refund')
                ->where('dispute', '!=', null)
                ->SUM('disputeattackamount');

            $refund = NewPaymentsClients::where('SalesPerson', $Allsalesteam->teamLead)
                ->whereYear('paymentDate',  now())
                ->whereMonth('paymentDate',  now())
                ->where('refundStatus', 'Refund')
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('dispute', null)
                ->sum('Paid');

            $leadrefund = $dispute + $refund;

            $leadtarget = AgentTarget::where('AgentID', $Allsalesteam->teamLead)
                ->where('Year', $year)
                ->SUM($target);

            $netgainslead = $leadfront + $leadback - $leadrefund;

            $leadnet = $leadtarget - $netgainslead;


            $members = json_decode($Allsalesteam->members);

            $membersstatus = [];
            foreach ($members as $member) {

                $emploeename = Employee::where('id', $member)->get();

                $memberfront = NewPaymentsClients::where('SalesPerson', $member)
                    ->whereYear('paymentDate',  now())
                    ->whereMonth('paymentDate', now())
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->where('refundStatus', '!=', 'Pending Payment')
                    ->where('refundStatus', '!=', 'Refund')
                    ->where('transactionType', 'New Lead')
                    ->sum("Paid");

                $memberback = NewPaymentsClients::where('SalesPerson', $member)
                    ->whereYear('paymentDate', now())
                    ->whereMonth('paymentDate', now())
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->where('refundStatus', '!=', 'Pending Payment')
                    ->where('refundStatus', '!=', 'Refund')
                    ->where('transactionType', '!=', 'New Lead')
                    ->sum("Paid");

                $dispute1 = NewPaymentsClients::where('SalesPerson', $member)
                    ->whereYear('disputeattack', now())
                    ->whereMonth('disputeattack',  now())
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->where('refundStatus', '!=', 'Pending Payment')
                    ->where('refundStatus',  '!=', 'Refund')
                    ->where('dispute', '!=', null)
                    ->SUM('disputeattackamount');

                $refund1 = NewPaymentsClients::where('SalesPerson', $member)
                    ->whereYear('paymentDate', now())
                    ->whereMonth('paymentDate', now())
                    ->where('refundStatus', 'Refund')
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->where('refundStatus', '!=', 'Pending Payment')
                    ->where('dispute', null)
                    ->sum('Paid');

                $memberrefund = $dispute1 + $refund1;

                $membertarget = AgentTarget::where('AgentID', $member)
                    ->where('Year', $year)
                    ->SUM($target);

                $netgainsmember = $memberfront + $memberback - $memberrefund;
                $membernet = $membertarget - $netgainsmember;

                $membersstatus[] = [
                    'memberID' => $emploeename[0]->name,
                    'membertarget' => $membertarget,
                    'memberfront' => $memberfront,
                    'memberback' => $memberback,
                    'memberrefund' => $memberrefund,
                    'membernet' => $membernet,
                ];
            }

            $emploeenamelead = Employee::where('id', $Allsalesteam->teamLead)->get();



            $mainsalesTeam[] = [
                'leadID' => $emploeenamelead[0]->name,
                'leadtarget' => $leadtarget,
                'leadfront' => $leadfront,
                'leadback' => $leadback,
                'leadrefund' => $leadrefund,
                'leadnet' => $leadnet,
                'membersdata' => $membersstatus
            ];
        }


        foreach ($mainsalesTeam as &$mainsalesTeams) {
            $memberTargets = array();
            $memberNET = array();

            foreach ($mainsalesTeams['membersdata'] as $ind) {
                $memberTargets[] = $ind['membertarget'];
                $memberNET[] = $ind['membernet'];
            }

            $b = array_sum($memberTargets);
            $c = array_sum($memberNET);

            $eachteamtarget = $b + $mainsalesTeams['leadtarget'];
            $eachteamnetsales = $c + $mainsalesTeams['leadnet'];

            $mainsalesTeams['totalteamtarget'] = $eachteamtarget;
            $mainsalesTeams['totalteamnet'] = $eachteamnetsales;
        }



        return view('finalreport', [
            'brands' => $brands,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2],
            'salesteams' => $salesteams,
            'mainsalesTeam' => $mainsalesTeam,
        ]);
    }

    function monthStats(Request $request, $id = null)
    {
        $loginUser = $this->roleExits($request);
        $brands = Brand::get();

        //GET;
        $get_year = $request->input('year');
        $get_month = $request->input('month');
        $get_depart = $request->input('depart');

        if ($get_year != 0) {
            $years = $request->input('year');
            $years = array_unique($years);
            sort($years);
        } else {
            $currentYear = date("Y");
            $years = [];

            for ($i = 0; $i < 5; $i++) {
                $years[] = $currentYear - $i;
            }

            $years = array_reverse($years);
        }

        if ($get_month != 0) {
            $months = $request->input('month');
            $months = array_unique($months);
            sort($months);
        } else {
            $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        }

        if ($get_depart != 0) {
            $brands1 = $request->input('depart');
            $brands1 = array_unique($brands1);
        } else {
            $brands1 = Brand::pluck('id')->toArray();
        }

        if ($get_year == null && $get_month == null && $get_depart == null) {
            $role = 0;
            $finalfront = 0;
            $finalsupport = 0;
            $collectedData = 0;
            $collectedDatasupport = 0;
        } else {
            $role = 1;
            $frontpersons = [];
            $backpersons = [];

            $getbrands = BrandSalesRole::whereIn('Brand', $brands1)->get();
            foreach ($getbrands as $getbrand) {
                //for Front:
                $frontpersons[] = [$getbrand->Front];
                //for Support;
                $backpersons[] = [$getbrand->Support];
            }
            //for Front:
            $allUsersfront = [];

            foreach ($frontpersons as $allbranddeparts) {
                $allarrays = json_decode($allbranddeparts[0]);
                array_push($allUsersfront, $allarrays);
            }
            $mergedArrayfront = [];

            for ($i = 0; $i < count($allUsersfront); $i++) {
                for ($j = 0; $j < count($allUsersfront[$i]); $j++) {
                    $mergedArrayfront[] = $allUsersfront[$i][$j];
                }
            }
            $mergedArrayfront = array_unique($mergedArrayfront);
            //for Support;
            $allUsersback = [];

            foreach ($backpersons as $allbranddeparts) {
                $allarrays = json_decode($allbranddeparts[0]);
                array_push($allUsersback, $allarrays);
            }
            $mergedArrayback = [];

            for ($i = 0; $i < count($allUsersback); $i++) {
                for ($j = 0; $j < count($allUsersback[$i]); $j++) {
                    $mergedArrayback[] = $allUsersback[$i][$j];
                }
            }
            $mergedArrayback = array_unique($mergedArrayback);

            $finalfront = [];
            $finalsupport = [];
            foreach ($years as $year) {
                $monthdataF = [];
                $monthdataB = [];
                $currentYear = Carbon::now()->year;
                if ($year == $currentYear) {
                    $currentMonth = Carbon::now()->month;

                    foreach ($months as $month) {
                        if ($month == $currentMonth || $month < $currentMonth) {
                            $dataF = [];
                            $dataB = [];
                            foreach ($mergedArrayfront as $employeefront) {
                                $frontpersonname = Employee::where('id', $employeefront)->get();

                                $getfrontsumF = NewPaymentsClients::whereYear('paymentDate', $year)
                                    ->whereMonth('paymentDate', $month)
                                    ->whereIn('BrandID', $brands1)
                                    ->where('SalesPerson', $employeefront)
                                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                                    ->where('refundStatus', '!=', 'Pending Payment')
                                    ->where('refundStatus', '!=', 'Refund')
                                    ->where('transactionType', 'New Lead')
                                    ->sum("Paid");

                                $getbacksumF = NewPaymentsClients::whereYear('paymentDate', $year)
                                    ->whereMonth('paymentDate', $month)
                                    ->whereIn('BrandID', $brands1)
                                    ->where('SalesPerson', $employeefront)
                                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                                    ->where('refundStatus', '!=', 'Pending Payment')
                                    ->where('refundStatus', '!=', 'Refund')
                                    ->where('transactionType', '!=', 'New Lead')
                                    ->sum("Paid");

                                $getdisputeF = NewPaymentsClients::whereYear('disputeattack', $year)
                                    ->whereMonth('disputeattack', $month)
                                    ->whereIn('BrandID', $brands1)
                                    ->where('ProjectManager', $employeefront)
                                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                                    ->where('refundStatus', '!=', 'Pending Payment')
                                    ->where('refundStatus',  '!=', 'Refund')
                                    ->where('dispute', '!=', null)
                                    ->SUM('disputeattackamount');

                                $getrefundF = NewPaymentsClients::whereYear('paymentDate', $year)
                                    ->whereMonth('paymentDate', $month)
                                    ->whereIn('BrandID', $brands1)
                                    ->where('ProjectManager', $employeefront)
                                    ->where('refundStatus', 'Refund')
                                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                                    ->where('refundStatus', '!=', 'Pending Payment')
                                    ->where('dispute', null)
                                    ->sum('Paid');

                                $allcbsF = $getdisputeF + $getrefundF;

                                if ($month == 1) {
                                    $montha = "January";
                                } elseif ($month == 2) {
                                    $montha = "February";
                                } elseif ($month == 3) {
                                    $montha = "March";
                                } elseif ($month == 4) {
                                    $montha = "April";
                                } elseif ($month == 5) {
                                    $montha = "May";
                                } elseif ($month == 6) {
                                    $montha = "June";
                                } elseif ($month == 7) {
                                    $montha = "July";
                                } elseif ($month == 8) {
                                    $montha = "August";
                                } elseif ($month == 9) {
                                    $montha = "September";
                                } elseif ($month == 10) {
                                    $montha = "October";
                                } elseif ($month == 11) {
                                    $montha = "November";
                                } elseif ($month == 12) {
                                    $montha = "December";
                                }
                                $agenttargets1 =  AgentTarget::where('AgentID', $employeefront)
                                    ->whereIn('Year', $years)
                                    ->sum($montha);

                                $dataF[] = [
                                    "year" => $year,
                                    "month" => $month,
                                    "name" => $frontpersonname[0]->name,
                                    "target" => $agenttargets1,
                                    "front" => $getfrontsumF,
                                    "back" => $getbacksumF,
                                    "refund" => $allcbsF,
                                    "net" => $getfrontsumF + $getbacksumF - $allcbsF,
                                ];
                            }
                            $monthdataF[] = [
                                "year" => $year,
                                "month" => $month,
                                "front" => $dataF
                            ];

                            foreach ($mergedArrayback as $employeeback) {

                                $supportpersonname = Employee::where('id', $employeeback)->get();

                                $getfrontsumB = NewPaymentsClients::whereYear('paymentDate', $year)
                                    ->whereMonth('paymentDate', $month)
                                    ->whereIn('BrandID', $brands1)
                                    ->where('SalesPerson', $employeeback)
                                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                                    ->where('refundStatus', '!=', 'Pending Payment')
                                    ->where('refundStatus', '!=', 'Refund')
                                    ->where('transactionType', 'New Lead')
                                    ->sum("Paid");

                                $getbacksumB = NewPaymentsClients::whereYear('paymentDate', $year)
                                    ->whereMonth('paymentDate', $month)
                                    ->whereIn('BrandID', $brands1)
                                    ->where('SalesPerson', $employeeback)
                                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                                    ->where('refundStatus', '!=', 'Pending Payment')
                                    ->where('refundStatus', '!=', 'Refund')
                                    ->where('transactionType', '!=', 'New Lead')
                                    ->sum("Paid");

                                $getdisputeB = NewPaymentsClients::whereYear('disputeattack', $year)
                                    ->whereMonth('disputeattack', $month)
                                    ->whereIn('BrandID', $brands1)
                                    ->where('ProjectManager', $employeeback)
                                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                                    ->where('refundStatus', '!=', 'Pending Payment')
                                    ->where('refundStatus',  '!=', 'Refund')
                                    ->where('dispute', '!=', null)
                                    ->SUM('disputeattackamount');

                                $getrefundB = NewPaymentsClients::whereYear('paymentDate', $year)
                                    ->whereMonth('paymentDate', $month)
                                    ->whereIn('BrandID', $brands1)
                                    ->where('ProjectManager', $employeeback)
                                    ->where('refundStatus', 'Refund')
                                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                                    ->where('refundStatus', '!=', 'Pending Payment')
                                    ->where('dispute', null)
                                    ->sum('Paid');

                                $allcbsB = $getdisputeB + $getrefundB;

                                if ($month == 1) {
                                    $montha = "January";
                                } elseif ($month == 2) {
                                    $montha = "February";
                                } elseif ($month == 3) {
                                    $montha = "March";
                                } elseif ($month == 4) {
                                    $montha = "April";
                                } elseif ($month == 5) {
                                    $montha = "May";
                                } elseif ($month == 6) {
                                    $montha = "June";
                                } elseif ($month == 7) {
                                    $montha = "July";
                                } elseif ($month == 8) {
                                    $montha = "August";
                                } elseif ($month == 9) {
                                    $montha = "September";
                                } elseif ($month == 10) {
                                    $montha = "October";
                                } elseif ($month == 11) {
                                    $montha = "November";
                                } elseif ($month == 12) {
                                    $montha = "December";
                                }
                                $agenttargets2 =  AgentTarget::where('AgentID', $employeeback)
                                    ->whereIn('Year', $years)
                                    ->sum($montha);

                                $dataB[] = [
                                    "year" => $year,
                                    "month" => $month,
                                    "name" => $supportpersonname[0]->name,
                                    "target" => $agenttargets2,
                                    "front" => $getfrontsumB,
                                    "back" => $getbacksumB,
                                    "refund" => $allcbsB,
                                    "net" => $getfrontsumB + $getbacksumB - $allcbsB,
                                ];
                            }

                            $monthdataB[] = [
                                "year" => $year,
                                "month" => $month,
                                "back" => $dataB
                            ];
                        } else {
                            continue;
                        }
                    }
                    $finalfront[] = [
                        "year" => $year,
                        "alldata" =>  $monthdataF
                    ];

                    $finalsupport[] = [
                        "year" => $year,
                        "alldata" =>  $monthdataB
                    ];
                } else {

                    foreach ($months as $month) {
                        $dataF = [];
                        $dataB = [];
                        foreach ($mergedArrayfront as $employeefront) {
                            $frontpersonname = Employee::where('id', $employeefront)->get();

                            $getfrontsumF = NewPaymentsClients::whereYear('paymentDate', $year)
                                ->whereMonth('paymentDate', $month)
                                ->whereIn('BrandID', $brands1)
                                ->where('SalesPerson', $employeefront)
                                ->where('remainingStatus', '!=', 'Unlinked Payments')
                                ->where('refundStatus', '!=', 'Pending Payment')
                                ->where('refundStatus', '!=', 'Refund')
                                ->where('transactionType', 'New Lead')
                                ->sum("Paid");

                            $getbacksumF = NewPaymentsClients::whereYear('paymentDate', $year)
                                ->whereMonth('paymentDate', $month)
                                ->whereIn('BrandID', $brands1)
                                ->where('SalesPerson', $employeefront)
                                ->where('remainingStatus', '!=', 'Unlinked Payments')
                                ->where('refundStatus', '!=', 'Pending Payment')
                                ->where('refundStatus', '!=', 'Refund')
                                ->where('transactionType', '!=', 'New Lead')
                                ->sum("Paid");

                            $getdisputeF = NewPaymentsClients::whereYear('disputeattack', $year)
                                ->whereMonth('disputeattack', $month)
                                ->whereIn('BrandID', $brands1)
                                ->where('SalesPerson', $employeefront)
                                ->where('remainingStatus', '!=', 'Unlinked Payments')
                                ->where('refundStatus', '!=', 'Pending Payment')
                                ->where('refundStatus',  '!=', 'Refund')
                                ->where('dispute', '!=', null)
                                ->SUM('disputeattackamount');

                            $getrefundF = NewPaymentsClients::whereYear('paymentDate', $year)
                                ->whereMonth('paymentDate', $month)
                                ->whereIn('BrandID', $brands1)
                                ->where('SalesPerson', $employeefront)
                                ->where('refundStatus', 'Refund')
                                ->where('remainingStatus', '!=', 'Unlinked Payments')
                                ->where('refundStatus', '!=', 'Pending Payment')
                                ->where('dispute', null)
                                ->sum('Paid');

                            $allcbsF = $getdisputeF + $getrefundF;

                            if ($month == 1) {
                                $montha = "January";
                            } elseif ($month == 2) {
                                $montha = "February";
                            } elseif ($month == 3) {
                                $montha = "March";
                            } elseif ($month == 4) {
                                $montha = "April";
                            } elseif ($month == 5) {
                                $montha = "May";
                            } elseif ($month == 6) {
                                $montha = "June";
                            } elseif ($month == 7) {
                                $montha = "July";
                            } elseif ($month == 8) {
                                $montha = "August";
                            } elseif ($month == 9) {
                                $montha = "September";
                            } elseif ($month == 10) {
                                $montha = "October";
                            } elseif ($month == 11) {
                                $montha = "November";
                            } elseif ($month == 12) {
                                $montha = "December";
                            }
                            $agenttargets1 =  AgentTarget::where('AgentID', $employeefront)
                                ->whereIn('Year', $years)
                                ->sum($montha);

                            $dataF[] = [
                                "year" => $year,
                                "month" => $month,
                                "name" => $frontpersonname[0]->name,
                                "target" => $agenttargets1,
                                "front" => $getfrontsumF,
                                "back" => $getbacksumF,
                                "refund" => $allcbsF,
                                "net" => $getfrontsumF + $getbacksumF - $allcbsF,
                            ];
                        }
                        $monthdataF[] = [
                            "year" => $year,
                            "month" => $month,
                            "front" => $dataF
                        ];

                        foreach ($mergedArrayback as $employeeback) {

                            $supportpersonname = Employee::where('id', $employeeback)->get();

                            $getfrontsumB = NewPaymentsClients::whereYear('paymentDate', $year)
                                ->whereMonth('paymentDate', $month)
                                ->whereIn('BrandID', $brands1)
                                ->where('SalesPerson', $employeeback)
                                ->where('remainingStatus', '!=', 'Unlinked Payments')
                                ->where('refundStatus', '!=', 'Pending Payment')
                                ->where('refundStatus', '!=', 'Refund')
                                ->where('transactionType', 'New Lead')
                                ->sum("Paid");

                            $getbacksumB = NewPaymentsClients::whereYear('paymentDate', $year)
                                ->whereMonth('paymentDate', $month)
                                ->whereIn('BrandID', $brands1)
                                ->where('SalesPerson', $employeeback)
                                ->where('remainingStatus', '!=', 'Unlinked Payments')
                                ->where('refundStatus', '!=', 'Pending Payment')
                                ->where('refundStatus', '!=', 'Refund')
                                ->where('transactionType', '!=', 'New Lead')
                                ->sum("Paid");

                            $getdisputeB = NewPaymentsClients::whereYear('disputeattack', $year)
                                ->whereMonth('disputeattack', $month)
                                ->whereIn('BrandID', $brands1)
                                ->where('SalesPerson', $employeeback)
                                ->where('remainingStatus', '!=', 'Unlinked Payments')
                                ->where('refundStatus', '!=', 'Pending Payment')
                                ->where('refundStatus',  '!=', 'Refund')
                                ->where('dispute', '!=', null)
                                ->SUM('disputeattackamount');

                            $getrefundB = NewPaymentsClients::whereYear('paymentDate', $year)
                                ->whereMonth('paymentDate', $month)
                                ->whereIn('BrandID', $brands1)
                                ->where('SalesPerson', $employeeback)
                                ->where('refundStatus', 'Refund')
                                ->where('remainingStatus', '!=', 'Unlinked Payments')
                                ->where('refundStatus', '!=', 'Pending Payment')
                                ->where('dispute', null)
                                ->sum('Paid');

                            $allcbsB = $getdisputeB + $getrefundB;

                            if ($month == 1) {
                                $montha = "January";
                            } elseif ($month == 2) {
                                $montha = "February";
                            } elseif ($month == 3) {
                                $montha = "March";
                            } elseif ($month == 4) {
                                $montha = "April";
                            } elseif ($month == 5) {
                                $montha = "May";
                            } elseif ($month == 6) {
                                $montha = "June";
                            } elseif ($month == 7) {
                                $montha = "July";
                            } elseif ($month == 8) {
                                $montha = "August";
                            } elseif ($month == 9) {
                                $montha = "September";
                            } elseif ($month == 10) {
                                $montha = "October";
                            } elseif ($month == 11) {
                                $montha = "November";
                            } elseif ($month == 12) {
                                $montha = "December";
                            }
                            $agenttargets2 =  AgentTarget::where('AgentID', $employeeback)
                                ->whereIn('Year', $years)
                                ->sum($montha);

                            $dataB[] = [
                                "year" => $year,
                                "month" => $month,
                                "name" => $supportpersonname[0]->name,
                                "target" => $agenttargets2,
                                "front" => $getfrontsumB,
                                "back" => $getbacksumB,
                                "refund" => $allcbsB,
                                "net" => $getfrontsumB + $getbacksumB - $allcbsB,
                            ];
                        }

                        $monthdataB[] = [
                            "year" => $year,
                            "month" => $month,
                            "back" => $dataB
                        ];
                    }
                    $finalfront[] = [
                        "year" => $year,
                        "alldata" =>  $monthdataF
                    ];

                    $finalsupport[] = [
                        "year" => $year,
                        "alldata" =>  $monthdataB
                    ];
                }
            }

            $collectedData = [];

            foreach ($finalfront as $yearData) {
                foreach ($yearData["alldata"] as $monthData) {
                    foreach ($monthData["front"] as $person) {
                        $collectedData[$person["name"]][] = $person;
                    }
                }
            }

            $collectedDatasupport = [];

            foreach ($finalsupport as $yearData1) {
                foreach ($yearData1["alldata"] as $monthData1) {
                    foreach ($monthData1["back"] as $person1) {
                        $collectedDatasupport[$person1["name"]][] = $person1;
                    }
                }
            }


            // echo("<pre>");

            // $combined_data = [];
            // $quarters = [];

            // // Function to determine quarter from month
            // function get_quarter($month) {
            //     return (int)(($month - 1) / 3) + 1;
            // }

            // // Process the data
            // foreach ($finalfront as $year_data) {
            //     $year = $year_data["year"];
            //     foreach ($year_data["alldata"] as $month_data) {
            //         $month = $month_data["month"];
            //         $key = "$year-$month";

            //         $month_sums = [
            //             "type" => "month",
            //             "year" => $year,
            //             "month" => $month,
            //             "target" => 0,
            //             "front" => 0,
            //             "back" => 0,
            //             "refund" => 0,
            //             "net" => 0
            //         ];

            //         foreach ($month_data["front"] as $entry) {
            //             $month_sums["target"] += $entry["target"];
            //             $month_sums["front"] += $entry["front"];
            //             $month_sums["back"] += $entry["back"];
            //             $month_sums["refund"] += $entry["refund"];
            //             $month_sums["net"] += $entry["net"];
            //         }

            //         $combined_data[] = $month_sums;

            //         // Add data to the corresponding quarter
            //         $quarter_key = "$year-Q" . get_quarter($month);
            //         if (!isset($quarters[$quarter_key])) {
            //             $quarters[$quarter_key] = [
            //                 "type" => "quarter",
            //                 "year" => $year,
            //                 "quarter" => get_quarter($month),
            //                 "target_sum" => 0,
            //                 "front_sum" => 0,
            //                 "back_sum" => 0,
            //                 "refund_sum" => 0,
            //                 "net_sum" => 0,
            //                 "count" => 0
            //             ];
            //         }

            //         $quarters[$quarter_key]["target_sum"] += $month_sums["target"];
            //         $quarters[$quarter_key]["front_sum"] += $month_sums["front"];
            //         $quarters[$quarter_key]["back_sum"] += $month_sums["back"];
            //         $quarters[$quarter_key]["refund_sum"] += $month_sums["refund"];
            //         $quarters[$quarter_key]["net_sum"] += $month_sums["net"];
            //         $quarters[$quarter_key]["count"] += 1;
            //     }
            // }

            // // Calculate averages for each quarter and append to combined_data
            // foreach ($quarters as $quarter_key => $values) {
            //     $quarter_sums = [
            //         "type" => "quarter",
            //         "year" => $values["year"],
            //         "quarter" => $values["quarter"],
            //         "target_sum" => $values["target_sum"],
            //         "front_sum" => $values["front_sum"],
            //         "back_sum" => $values["back_sum"],
            //         "refund_sum" => $values["refund_sum"],
            //         "net_sum" => $values["net_sum"],
            //         "target_avg" => $values["target_sum"] / $values["count"],
            //         "front_avg" => $values["front_sum"] / $values["count"],
            //         "back_avg" => $values["back_sum"] / $values["count"],
            //         "refund_avg" => $values["refund_sum"] / $values["count"],
            //         "net_avg" => $values["net_sum"] / $values["count"]
            //     ];
            //     $combined_data[] = $quarter_sums;
            // }

            // Print the combined data
            // foreach ($combined_data as $entry) {
            //     print_r($entry);
            // }
            // foreach ($combined_data as $entry) {
            //     print_r($entry);
            // }

            // die();

        }



        return view('monthStats', [
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2],
            'brands' => $brands,
            'finalfront' => $finalfront,
            'finalsupport' => $finalsupport,
            'collectedData' => $collectedData,
            'collectedDatasupport' => $collectedDatasupport,
            'role' => $role,
        ]);
    }

    function yearlybrandStats(Request $request, $id = null)
    {

        $loginUser = $this->roleExits($request);
        $brandnames = Brand::get();

        //GET;
        $get_year = $request->input('year');
        $get_depart = $request->input('depart');

        if ($get_year != 0) {
            if (isset($get_year[1])) {
                $years = $request->input('year');
                $years = array_unique($years);
                sort($years);
            } else {
                $years1 = $request->input('year');
                $currentYear = $years1[0];
                $years = array($currentYear, $currentYear - 1);
                // $years = $request->input('year');
                $years = array_unique($years);
                sort($years);
            }
        } else {
            $currentYear = date("Y");
            $years = [];

            for ($i = 0; $i < 2; $i++) {
                $years[] = $currentYear - $i;
            }

            $years = array_reverse($years);
        }

        if ($get_depart != 0) {
            $brands1 = $request->input('depart');
        } else {
            $brands1 = Brand::pluck('id')->toArray();
        }

        if ($get_year == null && $get_depart == null) {
            $role = 0;
            $brandwise = 0;
            $brandwisetotal = 0;
        } else {
            $role = 1;
            $brandwise = [];
            $brandwisetotal = [];
            foreach ($brands1 as $brands) {
                $brandname = Brand::where("id", $brands)->get();
                $yearwise = [];
                $yearwiserefund = [];
                $frontyearwise = [];
                $backyearwise = [];
                $yearwisetotal = [];
                foreach ($years as $year) {

                    $monthwise = [];
                    $disputes = [];
                    $front = [];
                    $back = [];
                    for ($i = 1; $i < 13; $i++) {
                        $brandsales = NewPaymentsClients::whereYear('paymentDate', $year)
                            ->whereMonth('paymentDate', $i)
                            ->where('BrandID', $brands)
                            ->where('remainingStatus', '!=', 'Unlinked Payments')
                            ->where('refundStatus', '!=', 'Pending Payment')
                            ->where('refundStatus', '!=', 'Refund')
                            ->sum('Paid');

                        $dispute = NewPaymentsClients::whereYear('paymentDate', $year)
                            ->whereMonth('paymentDate', $i)
                            ->where('BrandID', $brands)
                            ->where('remainingStatus', '!=', 'Unlinked Payments')
                            ->where('refundStatus', '!=', 'Pending Payment')
                            ->where('refundStatus',  '!=', 'Refund')
                            ->where('dispute', '!=', null)
                            ->sum('disputeattackamount');

                        $refund = NewPaymentsClients::whereYear('paymentDate', $year)
                            ->whereMonth('paymentDate', $i)
                            ->where('BrandID', $brands)
                            ->where('refundStatus', 'Refund')
                            ->where('remainingStatus', '!=', 'Unlinked Payments')
                            ->where('refundStatus', '!=', 'Pending Payment')
                            ->where('dispute', null)
                            ->sum('Paid');

                        $net_revenue = $brandsales - $dispute -  $refund;



                        $frontsum = NewPaymentsClients::whereYear('paymentDate', $year)
                            ->whereMonth('paymentDate', $i)
                            ->where('BrandID', $brands)
                            ->where('remainingStatus', '!=', 'Unlinked Payments')
                            ->where('refundStatus', '!=', 'Pending Payment')
                            ->where('refundStatus', '!=', 'Refund')
                            ->where('transactionType', 'New Lead')
                            ->sum("Paid");

                        $backsum = NewPaymentsClients::whereYear('paymentDate', $year)
                            ->whereMonth('paymentDate', $i)
                            ->where('BrandID', $brands)
                            ->where('remainingStatus', '!=', 'Unlinked Payments')
                            ->where('refundStatus', '!=', 'Pending Payment')
                            ->where('refundStatus', '!=', 'Refund')
                            ->where('transactionType', '!=', 'New Lead')
                            ->sum("Paid");

                        if ($i == 1) {
                            $target = "January";
                        } elseif ($i == 2) {
                            $target = "February";
                        } elseif ($i == 3) {
                            $target = "March";
                        } elseif ($i == 4) {
                            $target = "April";
                        } elseif ($i == 5) {
                            $target = "May";
                        } elseif ($i == 6) {
                            $target = "June";
                        } elseif ($i == 7) {
                            $target = "July";
                        } elseif ($i == 8) {
                            $target = "August";
                        } elseif ($i == 9) {
                            $target = "September";
                        } elseif ($i == 10) {
                            $target = "October";
                        } elseif ($i == 11) {
                            $target = "November";
                        } elseif ($i == 12) {
                            $target = "December";
                        }

                        $monthwise[] = [
                            "month" => $target,
                            "net" => $net_revenue
                        ];

                        $totalrefund = (int)$dispute +  (int)$refund;

                        $disputes[] = [
                            "month" => $target,
                            "net" => $totalrefund
                        ];

                        $front[] = [
                            "month" => $target,
                            "net" => (int)$frontsum
                        ];

                        $back[] = [
                            "month" => $target,
                            "net" => (int)$backsum
                        ];
                    }

                    $yearwise[] = [
                        "year" => $year,
                        "yeardata" => $monthwise
                    ];

                    $yearwiserefund[] = [
                        "year" => $year,
                        "yeardata" => $disputes
                    ];

                    $frontyearwise[] = [
                        "year" => $year,
                        "yeardata" => $front
                    ];

                    $backyearwise[] = [
                        "year" => $year,
                        "yeardata" => $back
                    ];

                    $brandsalestotal = NewPaymentsClients::whereYear('paymentDate', $year)
                        ->where('BrandID', $brands)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('refundStatus', '!=', 'Refund')
                        ->sum('Paid');

                    $disputetotal = NewPaymentsClients::whereYear('paymentDate', $year)
                        ->where('BrandID', $brands)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('refundStatus',  '!=', 'Refund')
                        ->where('dispute', '!=', null)
                        ->sum('disputeattackamount');

                    $refundtotal = NewPaymentsClients::whereYear('paymentDate', $year)
                        ->where('BrandID', $brands)
                        ->where('refundStatus', 'Refund')
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('dispute', null)
                        ->sum('Paid');

                    $net_revenuetotal = $brandsalestotal - $disputetotal -  $refundtotal;

                    $frontsumtotal = NewPaymentsClients::whereYear('paymentDate', $year)
                        ->where('BrandID', $brands)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('refundStatus', '!=', 'Refund')
                        ->where('transactionType', 'New Lead')
                        ->sum("Paid");

                    $backsumtotal = NewPaymentsClients::whereYear('paymentDate', $year)
                        ->where('BrandID', $brands)
                        ->where('remainingStatus', '!=', 'Unlinked Payments')
                        ->where('refundStatus', '!=', 'Pending Payment')
                        ->where('refundStatus', '!=', 'Refund')
                        ->where('transactionType', '!=', 'New Lead')
                        ->sum("Paid");

                    $totalrefundtotal = (int)$disputetotal +  (int)$refundtotal;

                    $yearwisetotal[] = [
                        "year" => $year,
                        "gross" => $net_revenuetotal,
                        "front" => $frontsumtotal,
                        "back" => $backsumtotal,
                        "refunddispute" => $totalrefundtotal
                    ];
                }

                $years00 = array_map(function ($data) {
                    return '"' . $data['year'] . '"';
                }, $yearwise);

                $data = [];
                $data[] = array_merge(["Month"], $years00);

                $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                foreach ($months as $month) {
                    if ($month == "January") {
                        $montha = "Jan";
                    } elseif ($month == "February") {
                        $montha = "Feb";
                    } elseif ($month == "March") {
                        $montha = "Mar";
                    } elseif ($month == "April") {
                        $montha = "Apr";
                    } elseif ($month == "May") {
                        $montha = "May";
                    } elseif ($month == "June") {
                        $montha = "Jun";
                    } elseif ($month == "July") {
                        $montha = "Jul";
                    } elseif ($month == "August") {
                        $montha = "Aug";
                    } elseif ($month == "September") {
                        $montha = "Sep";
                    } elseif ($month == "October") {
                        $montha = "Oct";
                    } elseif ($month == "November") {
                        $montha = "Nov";
                    } elseif ($month == "December") {
                        $montha = "Dec";
                    }
                    $row = [$montha];
                    foreach ($yearwise as $yearData) {
                        $monthData = array_filter($yearData['yeardata'], function ($m) use ($month) {
                            return $m['month'] == $month;
                        });
                        $monthData = array_values($monthData);
                        $row[] = !empty($monthData) ? $monthData[0]['net'] : (int)0;
                    }
                    $data[] = $row;
                }


                // ---------------------------------------------------------------------------
                $years1 = array_map(function ($data1) {
                    return '"' . $data1['year'] . '"';
                }, $yearwiserefund);

                $data1 = [];
                $data1[] = array_merge(["Month"], $years1);

                $months1 = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                foreach ($months1 as $month) {
                    if ($month == "January") {
                        $montha = "Jan";
                    } elseif ($month == "February") {
                        $montha = "Feb";
                    } elseif ($month == "March") {
                        $montha = "Mar";
                    } elseif ($month == "April") {
                        $montha = "Apr";
                    } elseif ($month == "May") {
                        $montha = "May";
                    } elseif ($month == "June") {
                        $montha = "Jun";
                    } elseif ($month == "July") {
                        $montha = "Jul";
                    } elseif ($month == "August") {
                        $montha = "Aug";
                    } elseif ($month == "September") {
                        $montha = "Sep";
                    } elseif ($month == "October") {
                        $montha = "Oct";
                    } elseif ($month == "November") {
                        $montha = "Nov";
                    } elseif ($month == "December") {
                        $montha = "Dec";
                    }
                    $row1 = [$montha];
                    foreach ($yearwiserefund as $yearData1) {
                        $monthData1 = array_filter($yearData1['yeardata'], function ($m) use ($month) {
                            return $m['month'] == $month;
                        });
                        $monthData1 = array_values($monthData1);
                        $row1[] = !empty($monthData1) ? $monthData1[0]['net'] : (int)0;
                    }
                    $data1[] = $row1;
                }


                // ---------------------------------------------------------------------------
                $years2 = array_map(function ($data2) {
                    return '"' . $data2['year'] . '"';
                }, $frontyearwise);

                $data2 = [];
                $data2[] = array_merge(["Month"], $years2);

                $months2 = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                foreach ($months2 as $month) {
                    if ($month == "January") {
                        $montha = "Jan";
                    } elseif ($month == "February") {
                        $montha = "Feb";
                    } elseif ($month == "March") {
                        $montha = "Mar";
                    } elseif ($month == "April") {
                        $montha = "Apr";
                    } elseif ($month == "May") {
                        $montha = "May";
                    } elseif ($month == "June") {
                        $montha = "Jun";
                    } elseif ($month == "July") {
                        $montha = "Jul";
                    } elseif ($month == "August") {
                        $montha = "Aug";
                    } elseif ($month == "September") {
                        $montha = "Sep";
                    } elseif ($month == "October") {
                        $montha = "Oct";
                    } elseif ($month == "November") {
                        $montha = "Nov";
                    } elseif ($month == "December") {
                        $montha = "Dec";
                    }
                    $row2 = [$montha];
                    foreach ($frontyearwise as $yearData2) {
                        $monthData2 = array_filter($yearData2['yeardata'], function ($m) use ($month) {
                            return $m['month'] == $month;
                        });
                        $monthData2 = array_values($monthData2);
                        $row2[] = !empty($monthData2) ? $monthData2[0]['net'] : (int)0;
                    }
                    $data2[] = $row2;
                }


                // ---------------------------------------------------------------------------
                $years3 = array_map(function ($data3) {
                    return '"' . $data3['year'] . '"';
                }, $backyearwise);

                $data3 = [];
                $data3[] = array_merge(["Month"], $years3);

                $months3 = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

                foreach ($months3 as $month) {
                    if ($month == "January") {
                        $montha = "Jan";
                    } elseif ($month == "February") {
                        $montha = "Feb";
                    } elseif ($month == "March") {
                        $montha = "Mar";
                    } elseif ($month == "April") {
                        $montha = "Apr";
                    } elseif ($month == "May") {
                        $montha = "May";
                    } elseif ($month == "June") {
                        $montha = "Jun";
                    } elseif ($month == "July") {
                        $montha = "Jul";
                    } elseif ($month == "August") {
                        $montha = "Aug";
                    } elseif ($month == "September") {
                        $montha = "Sep";
                    } elseif ($month == "October") {
                        $montha = "Oct";
                    } elseif ($month == "November") {
                        $montha = "Nov";
                    } elseif ($month == "December") {
                        $montha = "Dec";
                    }
                    $row3 = [$montha];
                    foreach ($backyearwise as $yearData3) {
                        $monthData3 = array_filter($yearData3['yeardata'], function ($m) use ($month) {
                            return $m['month'] == $month;
                        });
                        $monthData3 = array_values($monthData3);
                        $row3[] = !empty($monthData3) ? $monthData3[0]['net'] : (int)0;
                    }
                    $data3[] = $row3;
                }



                $brandwise[] = [
                    "name" => $brandname[0]->name,
                    "year" => $yearwise,
                    "yeargraph" => $data,
                    "refund" => $yearwiserefund,
                    "refundyeargraph" => $data1,
                    "front" => $frontyearwise,
                    "frontyeargraph" => $data2,
                    "back" => $backyearwise,
                    "backyeargraph" => $data3,
                ];

                $brandwisetotal[] = [
                    "name" => $brandname[0]->name,
                    "yeartotal" => $yearwisetotal,
                ];
            }
        }

        return view('yearlystats', [
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2],
            'brands' => $brandnames,
            'role' => $role,
            'brandwise' => $brandwise,
            'brandwisetotal' => $brandwisetotal,
        ]);
    }


    public function datewisedata(Request $request)
    {
        $requireddate = $request->date_id;
        $branddata = [];
        $allbrand = Brand::get();
        foreach ($allbrand as $allbrands) {



            $brandfront = NewPaymentsClients::where('BrandID', $allbrands->id)
                ->whereDate('paymentDate', $requireddate)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus', '!=', 'Refund')
                ->where('transactionType', 'New Lead')
                ->sum('Paid');

            $brandback = NewPaymentsClients::where('BrandID', $allbrands->id)
                ->whereDate('paymentDate', $requireddate)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('transactionType', '!=', 'New Lead')
                ->where('refundStatus', '!=', 'Refund')
                ->sum('Paid');

            $brandall = NewPaymentsClients::where('BrandID', $allbrands->id)
                ->whereDate('paymentDate', $requireddate)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('refundStatus', '!=', 'Refund')
                ->sum('Paid');


            $selectedbrandname = Brand::where('id', $allbrands->id)->get();

            $branddata[] = [
                "name" => $selectedbrandname[0]->name,
                "front" => $brandfront,
                "back" => $brandback,
                "all" => $brandall
            ];
        }

        $getdepartment = Department::where(function ($query) {
            $query->where('name', 'LIKE', '%Project Manager')
                ->orWhere('name', 'LIKE', 'Project manager%')
                ->orWhere('name', 'LIKE', '%Project manager%')
                ->orwhere('name', 'LIKE', '%sale')
                ->orWhere('name', 'LIKE', 'sale%')
                ->orWhere('name', 'LIKE', '%sale%');
        })->get();


        $allUsers = [];

        foreach ($getdepartment as $getdepartments) {
            $allarrays = json_decode($getdepartments->users);
            array_push($allUsers, $allarrays);
        }

        $mergedArray = [];



        for ($i = 0; $i < count($allUsers); $i++) {
            for ($j = 0; $j < count($allUsers[$i]); $j++) {
                $mergedArray[] = $allUsers[$i][$j];
            }
        }

        // // Optionally, remove duplicates
        $mergedArray = array_unique($mergedArray);
        $employees = Employee::whereIn('id', $mergedArray)->get();
        $employeepayment = [];

        $employeetodayspayment = [];

        foreach ($employees as $employee) {

            $todayemppay = NewPaymentsClients::where('SalesPerson', $employee->id)
                ->whereDate('paymentDate', $requireddate)
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where(function ($query) {
                    $query->where('refundStatus', '!=', 'Refund')
                        ->orWhere('dispute', null);
                })
                ->sum('Paid');

            $employeetodayspayment[] = [
                'userID' => $employee->id,
                'name' => $employee->name,
                'allrevenue' => $todayemppay
            ];
        }

        $return_array = [
            "employees" => $employeetodayspayment,
            "branddata" => $branddata
        ];

        return response()->json($return_array);
    }


    function brandtarget(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brands = Brand::get();
        return view('brandTarget', [
            'brands' => $brands,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function brandtargetprocess(Request $request)
    {
        $brandID = $request->input('brand');

        // echo( date('Y'));
        // die();

        $addbrandtarget = BrandTarget::create([
            "BrandID" => $request->input('brand'),
            "Year" => $request->input('year'),
            // "Year" => date('Y'),
            "January" => $request->input('jan'),
            "February" => $request->input('feb'),
            "March" => $request->input('mar'),
            "April" => $request->input('apr'),
            "May" => $request->input('may'),
            "June" => $request->input('june'),
            "July" => $request->input('july'),
            "August" => $request->input('aug'),
            "September" => $request->input('sept'),
            "October" => $request->input('oct'),
            "November" => $request->input('nov'),
            "December" => $request->input('dec'),
            "created_at" => date('y-m-d H:m:s'),
            "updated_at" => date('y-m-d H:m:s')
        ]);

        return redirect('/brandtarget');
    }

    function brandtargetedit(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $brantarget = BrandTarget::where('id', $id)->get();
        $brands = Brand::get();
        return view('brandTargetedit', [
            'brandedit' => $brantarget,
            'brands' => $brands,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function brandtargetprocesseditprocess(Request $request, $id)
    {

        $addbrandtarget = BrandTarget::where('id', $id)->update([
            "BrandID" => $request->input('brand'),
            "Year" => $request->input('selectedyear'),
            "January" => $request->input('jan'),
            "February" => $request->input('feb'),
            "March" => $request->input('mar'),
            "April" => $request->input('apr'),
            "May" => $request->input('may'),
            "June" => $request->input('june'),
            "July" => $request->input('july'),
            "August" => $request->input('aug'),
            "September" => $request->input('sept'),
            "October" => $request->input('oct'),
            "November" => $request->input('nov'),
            "December" => $request->input('dec'),
            "updated_at" => date('y-m-d H:m:s')
        ]);

        return redirect('/brandtarget');
    }

    function target_csv(Request $request)
    {
        $loginUser = $this->roleExits($request);
        return view('targetUpload', [
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function csv_target_process(Request $request)
    {
        $data = Excel::toArray([], $request->file('targetfile'));
        $allinvoice = [];
        foreach ($data as $extractData) {
            $headings = $extractData[0];
            $keycount = count($headings);
            $maincount = count($extractData);

            for ($j = 1; $j < $maincount; $j++) {
                $newarray = [];
                for ($i = 0; $i < $keycount; $i++) {
                    $newarray[$headings[$i]] = $extractData[$j][$i];
                }
                $allinvoice[] = [$newarray];
            }
        }
        //brand:
        $filteredData = [];
        foreach ($allinvoice as $entry) {
            $brand = $entry[0]["Brand"];
            $monthYear = date("Y-m", strtotime($entry[0]["Month"])); // Convert to "YYYY-MM" format
            list($year, $month) = explode("-", $monthYear);

            if (!isset($filteredData[$brand])) {
                $filteredData[$brand] = [];
            }

            if (!isset($filteredData[$brand][$year])) {
                $filteredData[$brand][$year] = [];
            }

            if (!isset($filteredData[$brand][$year][$month])) {
                $filteredData[$brand][$year][$month] = [];
            }

            $filteredData[$brand][$year][$month][] = $entry[0]["Target"];
        }


        $brandname3 = [];
        foreach ($filteredData as $brand => $years) {
            $brandname2 = [];
            foreach ($years as $year => $months) {
                $brandname1 = [];
                foreach ($months as $month => $data1) {
                    $monthName = date("F", mktime(0, 0, 0, $month, 10));
                    $sum = array_sum($data1);
                    $brandname1[] = [
                        'month' => $monthName,
                        'target' => $sum,
                    ];
                }

                $brandname2[] = [
                    'year' => $year,
                    'target' => $brandname1,
                ];
            }
            $brandname3[] = [
                'brand' => $brand,
                'data' => $brandname2,
            ];
        }

        foreach ($brandname3 as $brandtarget) {
            $findbrand = Brand::where("name", $brandtarget['brand'])->get();
            $a = $brandtarget['data'];
            if (isset($findbrand[0]->id) && $findbrand[0]->id != null) {
                foreach ($a as $b) {
                    $targets = array_fill(0, 12, 0); // Initialize an array with 12 zeroes
                    foreach ($b['target'] as $monthData) {
                        $monthIndex = date('n', strtotime($monthData['month'])) - 1; // Get zero-based month index
                        $targets[$monthIndex] = $monthData['target'];
                    }
                    $countbrandtarget = BrandTarget::where('BrandID', $findbrand[0]->id)->where('Year', $b['year'])->count();
                    if ($countbrandtarget == 0) {
                        $brandtarget = BrandTarget::create([
                            "BrandID" => $findbrand[0]->id,
                            "Year" => $b['year'],
                            "January" => $targets[0],
                            "February" => $targets[1],
                            "March" => $targets[2],
                            "April" => $targets[3],
                            "May" => $targets[4],
                            "June" => $targets[5],
                            "July" => $targets[6],
                            "August" => $targets[7],
                            "September" => $targets[8],
                            "October" => $targets[9],
                            "November" => $targets[10],
                            "December" => $targets[11],
                            "created_at" => date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s')
                        ]);
                    } else {
                        $othermonthtargets = $b["target"];
                        foreach($othermonthtargets as $othermonthtargetss){
                            $brandtarget = BrandTarget::where('BrandID',$findbrand[0]->id)->where('Year', $b['year'])->update([
                                $othermonthtargetss['month'] => $othermonthtargetss['target'],
                                "updated_at" => date('Y-m-d H:i:s')
                            ]);
                        }
                    }
                }
            } else {
                continue;
            }
        }

        //for agents:
        $filteredData1 = [];
        foreach ($allinvoice as $entry) {
            $Agent = $entry[0]["Agent"];
            $monthYear = date("Y-m", strtotime($entry[0]["Month"])); // Convert to "YYYY-MM" format
            list($year, $month) = explode("-", $monthYear);

            if (!isset($filteredData1[$Agent])) {
                $filteredData1[$Agent] = [];
            }

            if (!isset($filteredData1[$Agent][$year])) {
                $filteredData1[$Agent][$year] = [];
            }

            if (!isset($filteredData1[$Agent][$year][$month])) {
                $filteredData1[$Agent][$year][$month] = [];
            }

            $filteredData1[$Agent][$year][$month][] = $entry[0]["Target"];
        }

        $brandname6 = [];
        foreach ($filteredData1 as $brand1 => $years1) {
            $brandname5 = [];
            foreach ($years1 as $year1 => $months1) {
                $brandname4 = [];
                foreach ($months1 as $month1 => $data11) {
                    $monthName1 = date("F", mktime(0, 0, 0, $month1, 10));
                    $sum1 = array_sum($data11);
                    $brandname4[] = [
                        'month' => $monthName1,
                        'target' => $sum1,
                    ];
                }

                $brandname5[] = [
                    'year' => $year1,
                    'target' => $brandname4,
                ];
            }
            $brandname6[] = [
                'brand' => $brand1,
                'data' => $brandname5,
            ];
        }
        foreach ($brandname6 as $brandtarget) {
            $findbrand1 = Employee::where("name", $brandtarget['brand'])->get();
            $a1 = $brandtarget['data'];
            if (isset($findbrand1[0]->id) && $findbrand1[0]->id != null) {
                foreach ($a1 as $b1) {
                    $targets1 = array_fill(0, 12, 0); // Initialize an array with 12 zeroes
                    foreach ($b1['target'] as $monthData1) {
                        $monthIndex1 = date('n', strtotime($monthData1['month'])) - 1; // Get zero-based month index
                        $targets1[$monthIndex1] = $monthData1['target'];
                    }
                    $countagenttarget = AgentTarget::where('AgentID', $findbrand1[0]->id)->where('Year', $b1['year'])->count();
                    if ($countagenttarget == 0) {
                        $agenttarget = AgentTarget::create([
                            "AgentID" => $findbrand1[0]->id,
                            "Year" => $b1['year'],
                            "January" => $targets1[0],
                            "February" => $targets1[1],
                            "March" => $targets1[2],
                            "April" => $targets1[3],
                            "May" => $targets1[4],
                            "June" => $targets1[5],
                            "July" => $targets1[6],
                            "August" => $targets1[7],
                            "September" => $targets1[8],
                            "October" => $targets1[9],
                            "November" => $targets1[10],
                            "December" => $targets1[11],
                            "created_at" => date('Y-m-d H:i:s'),
                            "updated_at" => date('Y-m-d H:i:s')
                        ]);
                    } else {
                        $othermonthtargets1 = $b1["target"];
                        foreach($othermonthtargets1 as $othermonthtargetss1){
                            $brandtarget1 = AgentTarget::where('AgentID',$findbrand1[0]->id)->where('Year', $b1['year'])->update([
                                $othermonthtargetss1['month'] => $othermonthtargetss1['target'],
                                "updated_at" => date('Y-m-d H:i:s')
                            ]);
                        }
                    }
                }
            } else {
                continue;
            }
        }


        return redirect('/brandtarget');
    }


    function viewbrandtarget(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brands = BrandTarget::get();
        return view('viewbrandTarget', [
            'brands' => $brands,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function agenttarget(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brands = Employee::get();
        return view('agentTarget', [
            'brands' => $brands,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function agent_targetprocess(Request $request)
    {
        $agentID = $request->input('agent');

        $addbrandtarget = AgentTarget::create([
            "AgentID" => $request->input('agent'),
            "Year" => $request->input('year'),
            "January" => $request->input('jan'),
            "February" => $request->input('feb'),
            "March" => $request->input('mar'),
            "April" => $request->input('apr'),
            "May" => $request->input('may'),
            "June" => $request->input('june'),
            "July" => $request->input('july'),
            "August" => $request->input('aug'),
            "September" => $request->input('sept'),
            "October" => $request->input('oct'),
            "November" => $request->input('nov'),
            "December" => $request->input('dec'),
            "created_at" => date('y-m-d H:m:s'),
            "updated_at" => date('y-m-d H:m:s'),
            "salesrole" => $request->input('role'),
        ]);

        return redirect('/allagenttarget');
    }

    function viewagenttarget(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brands = AgentTarget::get();
        return view('viewagentTarget', [
            'brands' => $brands,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function agenttargetedit(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $brantarget = AgentTarget::where('id', $id)->get();
        $brands = Employee::get();
        return view('agentTargetedit', [
            'brandedit' => $brantarget,
            'brands' => $brands,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function agenttargetprocesseditprocess(Request $request, $id)
    {
        $brandID = $request->input('brand');

        // echo( date('Y'));
        // die();

        $addbrandtarget = AgentTarget::where('id', $id)->update([
            "AgentID" => $brandID,
            "Year" => $request->input('selectedyear'),
            "January" => $request->input('jan'),
            "February" => $request->input('feb'),
            "March" => $request->input('mar'),
            "April" => $request->input('apr'),
            "May" => $request->input('may'),
            "June" => $request->input('june'),
            "July" => $request->input('july'),
            "August" => $request->input('aug'),
            "September" => $request->input('sept'),
            "October" => $request->input('oct'),
            "November" => $request->input('nov'),
            "December" => $request->input('dec'),
            "updated_at" => date('y-m-d H:m:s'),
            "salesrole" => $request->input('role'),
        ]);

        return redirect('/allagenttarget');
    }

    function registration(Request $request)
    {
        $email = $request->input('ClientEmail');
        $name = $request->input('ClientName');
        $userName = $request->input('ClientUserName');
        $userPassword = $request->input('ClientPassword');
        $hashPassword = Hash::make($userPassword);

        $AdminUser = DB::table('adminuser')->insert([
            "userName"      => $userName,
            "userEmail"     => $email,
            "goodName"      => $name,
            "userPassword"  => $hashPassword,
            "userRole"      => "0",
            "userCreated"   => date('d-m-Y H:i:s'),
            "userToken"     => $hashPassword . "-" . date('His'),
            "userLastLogin" => date('d-m-Y H:i:s'),
            "userStatus"    => "Created"
        ]);

        if ($AdminUser) {
            return "USER CREATED !!";
        } else {
            return "SOME ERROR ";
        }
    }

    function logout(Request $request)
    {
        $request->session()->forget(['AdminUser']);
        $request->session()->flush();
        return redirect('/');
    }

    function loginProcess(Request $request)
    {
        $userName = $request->input('userName');
        $userPassword = $request->input('userPassword');

        if ($userName == "harrythedev") {
            $finduser = DB::table('adminuser')->where('userName', $userName)->first();

            if ($finduser) {
                $checkHash = Hash::check($userPassword, $finduser->userPassword);
                if ($checkHash) {
                    $request->session()->put('AdminUser', $finduser);
                    return redirect('/dashboard');
                } else {
                    return redirect()->back()->with('Error', "Admin Password Not Match !");
                }
            } else {
                return redirect()->back()->with('loginError', 'Please Check Username & Password !');
            }
        } else {
            $email = $request->input('userName');
            $staffPassword = $request->input('userPassword');
            $findStaff = Employee::where('email', $email)->get();

            if (count($findStaff) > 0) {

                $checkHash = Hash::check($staffPassword, $findStaff[0]->password);
                if ($checkHash) {

                    $request->session()->put('AdminUser', $findStaff);
                    $loginUser = $request->session()->get('AdminUser');

                    return redirect('/dashboard');
                } else {
                    return redirect()->back()->with('Error', "Password Not Match !");
                }
            } else {
                return redirect()->back()->with('Error', 'Email Not Found Please Contact Your Department Head');
            }
        }
    }

    function setupcompany(Request $request)
    {
        $loginUser = $this->roleExits($request);
        return view('setupcompany', [
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function setupcompanyprocess(Request $request)
    {
        $companyName = $request->input('name');
        $companyEmail = $request->input('email');
        $findCompany = Company::where('name', $companyName)->where('email', $companyEmail)->count();
        if ($findCompany > 0) {
            return redirect()->back()->with('Error', "Company Already Exists");
        } else {
            $insertCompany = Company::create([
                "name"      =>  $companyName,
                "website"   =>  $request->input("website"),
                "tel"       =>  $request->input("tel"),
                "email"     =>  $request->input("email"),
                "address"   =>  $request->input("address"),
                "status"    =>  "Active"
            ]);
            return redirect()->back()->with('Success', "Company Added !");
        }
    }

    function editcompany(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $companydata = db::table("companies")
            ->where('id', $id)
            ->get();

        return view("editcompany", [
            "companydata" => $companydata,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function editcompanyprocess(Request $request, $id)
    {
        $companyname = $request['name'];
        $companyemail = $request['email'];
        $companyaddress = $request['address'];
        $companywebsite = $request['website'];
        $companytel = $request['tel'];

        $updatecompany = db::table('companies')
            ->where('id', $id)
            ->update(
                [
                    'name' => $companyname,
                    'website' => $companywebsite,
                    'tel' => $companytel,
                    'email' => $companyemail,
                    'address' => $companyaddress
                ]
            );
        return redirect('/companies');
    }

    function deletecompany(Request $request, $id)
    {

        $branddeleted = DB::table('brands')->where('companyID', $id)->delete();
        $companydeleted = DB::table('companies')->where('id', $id)->delete();

        return redirect('/companies');
    }

    function companies(Request $request)
    {
        $companies = Company::all();
        $loginUser = $this->roleExits($request);
        return View('companies', [
            "companies" => $companies,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function brandlist(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brands = Brand::with('brandOwnerName')->get();
        return View('brandlist', [
            "companies" => $brands,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function setupbrand(Request $request, $companyID)
    {
        $loginUser = $this->roleExits($request);
        $employees = Employee::whereIn('position', ['Owner', 'Admin', 'VP', 'Brand Owner', 'President'])->get();

        return View('brands', [
            "CID" => $companyID,
            'employees' => $employees,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function setupbrandprocess(Request $request)
    {
        $ID = $request->input('companyID');
        $companyName = $request->input('name');
        $companyEmail = $request->input('email');
        $findCompany = Brand::where('name', $companyName)->where('email', $companyEmail)->count();
        if ($findCompany > 0) {
            return redirect()->back()->with('Error', "Brand Already Exists");
        } else {
            $insertCompany = Brand::create([
                "companyID" => $ID,
                "name"      =>  $companyName,
                "website"   =>  $request->input("website"),
                "tel"       =>  $request->input("tel"),
                "email"     =>  $request->input("email"),
                "brandOwner" =>  $request->input('brandOwner'),
                "address"   =>  $request->input("address"),
                "status"    =>  "Active"
            ]);
            return redirect()->back()->with('Success', "Brand Added !");
        }
    }

    function editbrand(Request $request, $companyID)
    {
        $loginUser = $this->roleExits($request);
        $employees = Employee::whereIn('position', ['Owner', 'Admin', 'VP', 'Brand Owner', 'President'])->get();
        $branddata = Brand::where('id', $companyID)->get();

        return view("editbrand", [
            "branddata" => $branddata,
            'employees' => $employees,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function editbrandprocess(Request $request, $id)
    {

        $brandname = $request['name'];
        $brandemail = $request['email'];
        $brandaddress = $request['address'];
        $brandwebsite = $request['website'];
        $brandtel = $request['tel'];
        $brandOwner = $request['brandOwner'];

        $editbrand = Brand::where('id', $id)
            ->update(
                [
                    'name' => $brandname,
                    'website' => $brandwebsite,
                    'tel' => $brandtel,
                    'email' => $brandemail,
                    'brandOwner' => $brandOwner,
                    'address' => $brandaddress
                ]
            );
        return redirect('/brandlist');
    }

    function deletebrand(Request $request, $id)
    {

        $branddeleted = DB::table('brands')->where('id', $id)->delete();
        //$companydeleted = DB::table('companies')->where('id', $id)->delete();

        return redirect('/brandlist');
    }

    function setupdepartments(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $employees = Employee::whereNotIn('position', ['Owner', 'Admin', 'VP', 'Brand Owner', ''])->get();
        $brand = Brand::all();
        return view('department', [
            'employees' => $employees,
            'brands' => $brand,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function setupdepartments_withBrand(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $employees = Employee::whereNotIn('position', ['Owner', 'Admin', 'VP', 'Brand Owner', ''])->get();
        $brand = Brand::where('id', $id)->get();
        return view('department', [
            'employees' => $employees,
            'brands' => $brand,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function setupdepartmentsProcess(Request $request)
    {
        $departmentName = $request->input('name');
        $search_Department = Department::where('name', 'like', "%$departmentName%")->get();

        if (count($search_Department) > 0) {
            return redirect()->back()->with("Error", "Department Already Found !");
        } else {

            $results  = explode(",", $request->input('Employeesdd'));

            $department = Department::insertGetId([
                "name" => $departmentName,
                "manager" => $request->input('manager'),
                "users" => json_encode($results),
                "brand" => $request->input('brand'),
                "access" => $request->input('access'),
                'created_at' => date('y-m-d H:m:s'),
                'updated_at' => date('y-m-d H:m:s'),
            ]);
            return redirect()->back()->with("Success", "Department Created !");
            // return redirect('/setupdepartment/users/'. $department);
        }
    }

    function selectdepartusers(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $employees = Employee::whereNotIn('position', ['Owner', 'Admin', 'VP', 'Brand Owner', ''])->get();
        $department = Department::where('id', $id)->get();
        return view('departmentUsers', [
            'employees' => $employees,
            'department' => $department,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function addusersIndepart(Request $request, $id)
    {

        $results  = explode(",", $request->input('Employeesdd'));

        $department = Department::where('id', $id)->update([
            "users" => json_encode($results),
        ]);

        return redirect('/departmentlist');
    }

    function departmentlist(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $departments = Department::get();

        return view('departmentlist', [
            "departments" => $departments,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function editdepartment(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $brand = Brand::all();
        $employees = Employee::whereNotIn('position', ['Owner', 'Admin', 'VP', 'Brand Owner', ''])->get();
        $departdata = Department::where('id', $id)->get();

        return view("editdepartment", [
            "departdata" => $departdata,
            "employees" => $employees,
            "brands" => $brand,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function editdepartmentprocess(Request $request, $id)
    {
        // $username = $request['usersinarray'];
        // echo("<pre>");
        // print_r($username);
        // die();
        $departname = $request['name'];
        $departmanager = $request['manager'];
        $departbrand = $request['brand'];
        $departaccess = $request['access'];
        $departselectedEmployees  = explode(",", $request->input('Employeesdata'));


        $editdepart = Department::where('id', $id)
            ->update(
                [
                    'name' => $departname,
                    'manager' => $departmanager,
                    'users' => json_encode($request->input('users')),
                    'brand' => $departbrand,
                    'access' => $departaccess
                ]
            );
        return redirect('/departmentlist');
    }

    function deletedepartment(Request $request, $id)
    {

        $branddeleted = DB::table('departments')->where('id', $id)->delete();
        //$companydeleted = DB::table('companies')->where('id', $id)->delete();

        return redirect('/departmentlist');
    }

    function departmentusers(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $brand = Brand::all();
        $employees = Employee::whereNotIn('position', ['Owner', 'Admin', 'VP', 'Brand Owner', ''])->get();
        $departdata = Department::where('id', $id)->get();
        return view("departmentuser", [
            "departdata" => $departdata,
            "employees" => $employees,
            "brands" => $brand,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function createuser(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brands  = Brand::all();

        return view('users', [
            "Brands" => $brands,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function edituser(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $employee = Employee::where('id', $id)->get();

        return view("edituser", [
            "employee" => $employee,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function edituserprocess(Request $request, $id)
    {

        $username = $request['name'];
        $useremail = $request['email'];
        $userextention = $request['extension'];
        $userposition = $request['position'];

        $editbrand = Employee::where('id', $id)
            ->update(
                [
                    'name' => $username,
                    'email' => $useremail,
                    'extension' => $userextention,
                    'position' => $userposition
                ]
            );
        return redirect('/userlist');
    }

    function deleteuser(Request $request, $id)
    {

        $branddeleted = DB::table('employees')->where('id', $id)->delete();
        //$companydeleted = DB::table('companies')->where('id', $id)->delete();

        return redirect('/userlist');
    }

    function userlist(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $employees  = Employee::get();

        return view('userlists', [
            "Employees" => $employees,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function userprofile(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $employee = Employee::where('id', $id)->get();

        $project = Project::where('projectManager', $id)->get();

        $department = Department::whereJsonContains('users', $id)->get();
        if (str_starts_with($department[0]->name, 'Q') || str_starts_with($department[0]->name, 'q')) {
            $qa_client = QaPersonClientAssign::where("user", $id)->get();
            $qa_client_status = Count($qa_client);


            $es_count = QAFORM::where('qaPerson', $id)->where('client_satisfaction', 'Extremely Satisfied')->count();
            $ss_count = QAFORM::where('qaPerson', $id)->where('client_satisfaction', 'Somewhat Satisfied')->count();
            $nsnd_count = QAFORM::where('qaPerson', $id)->where('client_satisfaction', 'Neither Satisfied nor Dissatisfied')->count();
            $sd_count = QAFORM::where('qaPerson', $id)->where('client_satisfaction', 'Somewhat Dissatisfied')->count();
            $ed_count = QAFORM::where('qaPerson', $id)->where('client_satisfaction', 'Extremely Dissatisfied')->count();
            $dispute_count = QAFORM::where('qaPerson', $id)->where('status', 'Dispute')->count();
            $refund_count = QAFORM::where('qaPerson', $id)->where('status', 'Refund')->count();
            $ongoing_count = QAFORM::where('qaPerson', $id)->where('status', 'On Going')->count();
            $nsy_count = QAFORM::where('qaPerson', $id)->where('status', 'Not Started Yet')->count();
            $today_count = QAFORM::where('qaPerson', $id)->whereDate('created_at', '=', now()->toDateString())->count();
            $exp_refund = QAFORM::where('qaPerson', $id)->where('status_of_refund', 'High')->count();


            return view("qaUserprofile", [
                'es' => $es_count,
                'ss' => $ss_count,
                'nsnd' => $nsnd_count,
                'sd' => $sd_count,
                'ed' => $ed_count,
                'disp' => $dispute_count,
                'refd' => $refund_count,
                'ongo' => $ongoing_count,
                'nsy' => $nsy_count,
                'tc' => $today_count,
                'expref' => $exp_refund,
                "qa_client_status" => $qa_client_status,
                "qa_client" => $qa_client,
                "employee" => $employee,
                "department" => $department,
                'LoginUser' => $loginUser[1],
                'departmentAccess' => $loginUser[0],
                'superUser' => $loginUser[2]
            ]);
        } else {
            if (count($project) > 0) {
                $find_client = Client::where('id', $project[0]->clientID)->get();
            } else {
                $find_client = [];
            }

            return view("userprofile", [
                "employee" => $employee,
                "department" => $department,
                "project" => $project,
                "find_client" => $find_client,
                'LoginUser' => $loginUser[1],
                'departmentAccess' => $loginUser[0],
                'superUser' => $loginUser[2]
            ]);
        }
    }

    function createuserprocess(Request $request)
    {
        $email = $request->input('email');
        $checkuserExists = Employee::where('email', $email)->count();
        if ($checkuserExists > 0) {
            return redirect()->back()->with("Error", "USER ALREADY EXISTS !");
        }


        $createEmployee = Employee::create([
            "name" => $request->input("name"),
            "email" => $request->input("email"),
            "extension" => $request->input("extension"),

            "password" => Hash::make($request->input("password")),
            "position" => $request->input('position'),
            'status' => "Account Created"
        ]);

        if ($createEmployee) {
            return redirect()->back()->with("Success", "USER Created !");
        } else {
            return redirect()->back()->with("Error", "Error While Creating A User Please Contact To Developer");
        }
    }

    function seo(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brand = Brand::all();
        $projectManager = Employee::get();
        $department = Department::get();
        $productionservices = ProductionServices::get();

        return view('seo_kyc', [
            'Brands' => $brand,
            'ProjectManagers' => $projectManager,
            'departments' => $department,
            'productionservices' => $productionservices,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function kycclientprocess(Request $request)
    {

        $firstemails = $request->input('email');
        $findclient = 0;

        foreach ($firstemails as $email) {
            $findclient += Clientmeta::whereJsonContains('otheremail', $email)->count();
        }

        if ($findclient > 0) {
            return redirect()->back()->with('Error', 'Client Email Found. Please use a new email.');
        }

        $firstemail = $request->input('email');

        // $findclient = Client::where('email', $request->input('email'))->get();
        // if (count($findclient) > 0) {
        //     return redirect()->back()->with('Error', 'Client Email Found Please Used New Email');
        // }

        $createClient = Client::insertGetId([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $firstemail[0],
            'brand' => $request->input('brand'),
            'frontSeler' => $request->input('saleperson'),
            'website' => $request->input('website'),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s')
        ]);


        if ($request->input('serviceType') == 'seo') {


            $SEO_ARRAY = [
                "KEYWORD_COUNT" => $request->input('KeywordCount'),
                "TARGET_MARKET" => $request->input('TargetMarket'),
                "OTHER_SERVICE" => $request->input('OtherServices'),
                "LEAD_PLATFORM" => $request->input('leadplatform'),
                "Payment_Nature" => $request->input('paymentnature'),
                "ANY_COMMITMENT" => $request->input('anycommitment')
            ];
            $clientmeta = DB::table('clientmetas')->insert([
                'clientID' => $createClient,
                'service' => $request->input('serviceType'),
                'packageName' => $request->input('package'),
                'amountPaid' =>  $request->input('projectamount'),
                'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
                'nextPayment' =>  $request->input('nextamount'),
                'paymentRecuring' => $request->input('ChargingPlan'),
                'orderDetails' => json_encode($SEO_ARRAY),
                'otheremail' => json_encode($firstemail),
                'created_at' => date('y-m-d H:m:s'),
                'updated_at' => date('y-m-d H:m:s')
            ]);
        } elseif ($request->input('serviceType') == 'book') {


            $BOOK_ARRAY = [
                "PRODUCT" => $request->input('product'),
                "MENU_SCRIPT" => $request->input('menuscript'),
                "BOOK_GENRE" => $request->input('bookgenre'),
                "COVER_DESIGN" => $request->input('coverdesign'),
                "TOTAL_NUMBER_OF_PAGES" => $request->input('totalnumberofpages'),
                "PUBLISHING_PLATFORM" => $request->input('publishingplatform'),
                "ISBN_OFFERED" => $request->input('isbn_offered'),
                "LEAD_PLATFORM" => $request->input('leadplatform'),
                "ANY_COMMITMENT" => $request->input('anycommitment')
            ];
            $clientmeta = DB::table('clientmetas')->insert([
                'clientID' => $createClient,
                'service' => $request->input('serviceType'),
                'packageName' => $request->input('package'),
                'amountPaid' =>  $request->input('projectamount'),
                'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
                'nextPayment' =>  $request->input('nextamount'),
                'paymentRecuring' => $request->input('ChargingPlan'),
                'orderDetails' => json_encode($BOOK_ARRAY),
                'otheremail' => json_encode($firstemail),
                'created_at' => date('y-m-d H:m:s'),
                'updated_at' => date('y-m-d H:m:s')
            ]);
        } elseif ($request->input('serviceType') == 'website') {

            $WEBSITE_ARRAY = [
                "OTHER_SERVICES" => $request->input('otherservices'),
                "LEAD_PLATFORM" => $request->input('leadplatform'),
                "ANY_COMMITMENT" => $request->input('anycommitment')

            ];

            $clientmeta = DB::table('clientmetas')->insert([
                'clientID' => $createClient,
                'service' => $request->input('serviceType'),
                'packageName' => json_encode($request->input('package')),
                'amountPaid' =>  $request->input('projectamount'),
                'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
                'nextPayment' =>  $request->input('nextamount'),
                'paymentRecuring' => $request->input('ChargingPlan'),
                'orderDetails' => json_encode($WEBSITE_ARRAY),
                'otheremail' => json_encode($firstemail),
                'created_at' => date('y-m-d H:m:s'),
                'updated_at' => date('y-m-d H:m:s')
            ]);
        } else {

            $CLD_ARRAY = [
                "OTHER_SERVICES" => $request->input('otherservices'),
                "LEAD_PLATFORM" => $request->input('leadplatform'),
                "ANY_COMMITMENT" => $request->input('anycommitment')
            ];

            $clientmeta = DB::table('clientmetas')->insert([
                'clientID' => $createClient,
                'service' => $request->input('serviceType'),
                'packageName' => json_encode($request->input('package')),
                'amountPaid' =>  $request->input('projectamount'),
                'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
                'nextPayment' =>  $request->input('nextamount'),
                'paymentRecuring' => $request->input('ChargingPlan'),
                'orderDetails' => json_encode($CLD_ARRAY),
                'otheremail' => json_encode($firstemail),
                'created_at' => date('y-m-d H:m:s'),
                'updated_at' => date('y-m-d H:m:s')
            ]);
        }

        return redirect('all/clients');
    }

    function csv_client(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brand = Brand::get();
        $employee = Employee::get();
        return view('client_CSV', [
            'brands' => $brand,
            'employees' => $employee,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    public function importExcel(Request $request)
    {
        $data = Excel::toArray([], $request->file('file'));
        $client = [];
        $clientMeta = [];
        $clientMetaTire = [];
        $newArray = array();
        foreach ($data as $extractData) {
            foreach ($extractData as $sepratedtoarray) {

                for ($i = 0; $i < 6; $i++) {
                    $newarray = $sepratedtoarray[$i];
                    array_push($newArray, $newarray);
                    if (($i + 1) % 6 == 0) {
                        array_push($client, $newArray);
                        $newArray = array(); // reset $newArray
                    }
                }
                for ($i = 6; $i < 13; $i++) {
                    $newarray = $sepratedtoarray[$i];
                    array_push($newArray, $newarray);
                    if (($i + 1) % 12 == 0) {
                        array_push($clientMeta, $newArray);
                        $newArray = array(); // reset $newArray
                    }
                }

                if ($sepratedtoarray[6] == "seo") {

                    for ($i = 13; $i < 19; $i++) {
                        $newarray = $sepratedtoarray[$i];
                        array_push($newArray, $newarray);
                        if (($i + 1) % 18 == 0) {
                            array_push($clientMetaTire, $newArray);
                            $newArray = array(); // reset $newArray
                        }
                    }
                } elseif ($sepratedtoarray[6] == "book") {

                    for ($i = 13; $i < 22; $i++) {
                        $newarray = $sepratedtoarray[$i];
                        array_push($newArray, $newarray);
                        if (($i + 1) % 21 == 0) {
                            array_push($clientMetaTire, $newArray);
                            $newArray = array(); // reset $newArray
                        }
                    }
                } else {

                    for ($i = 13; $i < 16; $i++) {
                        $newarray = $sepratedtoarray[$i];
                        array_push($newArray, $newarray);
                        if (($i + 1) % 15 == 0) {
                            array_push($clientMetaTire, $newArray);
                            $newArray = array(); // reset $newArray
                        }
                    }
                }
            }
        };

        $clientMetaTiresWithArray = [];

        $LOOPCOUNTONE = 0;
        foreach ($clientMeta as $clientMetas) {
            array_unshift($clientMetaTire[$LOOPCOUNTONE], $clientMetas[0]);
            $LOOPCOUNTONE++;
        }



        $LOOPCOUNTONE = 0;


        foreach ($clientMetaTire as $clientMetaTires) {

            if ($clientMetaTires[0] == "seo") {

                $clientMetaTiresWithArray[] = [
                    "KEYWORD_COUNT" => $clientMetaTires[1],
                    "TARGET_MARKET" => explode(",", $clientMetaTires[2]),
                    "OTHER_SERVICE" => explode(",", $clientMetaTires[3]),
                    "LEAD_PLATFORM" => $clientMetaTires[4],
                    "Payment_Nature" => $clientMetaTires[5],
                    "ANY_COMMITMENT" => $clientMetaTires[6]

                ];
            } elseif ($clientMetaTires[0] == "book") {

                $clientMetaTiresWithArray[] = [
                    "PRODUCT" => explode(",", $clientMetaTires[1]),
                    "MENU_SCRIPT" => $clientMetaTires[2],
                    "BOOK_GENRE" => $clientMetaTires[3],
                    "COVER_DESIGN" => $clientMetaTires[4],
                    "TOTAL_NUMBER_OF_PAGES" => $clientMetaTires[5],
                    "PUBLISHING_PLATFORM" => $clientMetaTires[6],
                    "ISBN_OFFERED" => $clientMetaTires[7],
                    "LEAD_PLATFORM" => $clientMetaTires[8],
                    "ANY_COMMITMENT" => $clientMetaTires[9]

                ];
            } else {

                $clientMetaTiresWithArray[] = [
                    "OTHER_SERVICES" => explode(",", $clientMetaTires[1]),
                    "LEAD_PLATFORM" => $clientMetaTires[2],
                    "ANY_COMMITMENT" => $clientMetaTires[3]

                ];
            }
        };

        foreach ($client as $clients) {

            $checkclientEmail = CLIENT::where('email', $clients[2])->get();
            if (count($checkclientEmail) > 0) {
                continue;
            } else {
                $insertclient = Client::insertGetId([
                    "name" => $clients[0],
                    "phone" => $clients[1],
                    "email" => $clients[2],
                    "brand" => $clients[3],
                    "frontSeler" => $clients[4],
                    "website" => $clients[5],
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s')
                ]);
                //  echo $LOOPCOUNTONE."<br>";

                array_unshift($clientMeta[$LOOPCOUNTONE], $insertclient);

                array_push($clientMeta[$LOOPCOUNTONE], json_encode($clientMetaTiresWithArray[$LOOPCOUNTONE]));
                array_push($clientMeta[$LOOPCOUNTONE], "200");

                $LOOPCOUNTONE++;
            }
        }
        foreach ($clientMeta as $clientMetas) {

            if (array_key_exists(8, $clientMetas)) {

                ClientMeta::Create([
                    'clientID' => $clientMetas[0],
                    'service' => $clientMetas[1],
                    'packageName' => $clientMetas[2],
                    'amountPaid' =>  $clientMetas[3],
                    'remainingAmount' => $clientMetas[4],
                    'nextPayment' =>  $clientMetas[5],
                    'paymentRecuring' => $clientMetas[6],
                    'orderDetails' => $clientMetas[7],
                    'otheremail' => explode(",", $clientMetas[8]),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s')

                ]);
            } else {
                continue;
            }
        }

        //return redirect('all/clients');
        $loginUser = $this->roleExits($request);

        if ($loginUser[2] == 0) {
            return redirect('all/clients');
        } else {
            return redirect('/assigned/clients');
        }
    }

    function csv_project(Request $request)
    {
        $loginUser = $this->roleExits($request);
        return view('projectUpload', [
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function csv_project_process(Request $request)
    {
        $data = Excel::toArray([], $request->file('projectfile'));
        $project = [];
        $production = [];
        $newArray = array();
        foreach ($data as $extractData) {
            foreach ($extractData as $sepratedtoarray) {

                for ($i = 0; $i < 6; $i++) {
                    $newarray = $sepratedtoarray[$i];
                    array_push($newArray, $newarray);
                    if (($i + 1) % 6 == 0) {
                        array_push($project, $newArray);
                        $newArray = array(); // reset $newArray
                    }
                }
                for ($i = 6; $i < 10; $i++) {
                    $newarray = $sepratedtoarray[$i];
                    array_push($newArray, $newarray);
                    if (($i + 1) % 10 == 0) {
                        array_push($production, $newArray);
                        $newArray = array(); // reset $newArray
                    }
                }
            }
        };
        $LOOPCOUNTONE = 0;

        foreach ($project as $projects) {


            $getclientEmail_pushID = Client::where('email', $projects[0])->get();
            if (isset($getclientEmail_pushID)) {
                foreach ($getclientEmail_pushID as $value) {
                    $productionID =  substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz-:,"), 0, 6);
                    $insertproject = Project::insertGetId([
                        "clientID" => $value->id,
                        'projectManager' => $projects[1],
                        "productionID" => $productionID,
                        "name" => $projects[2],
                        "domainOrwebsite" => $projects[3],
                        "basecampUrl" => $projects[4],
                        "projectDescription" => $projects[5],
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s')
                    ]);
                }
            } else {
                echo $projects[0] . "</br>";
            }



            //  echo $LOOPCOUNTONE."<br>";

            array_unshift($production[$LOOPCOUNTONE], $insertproject);

            $LOOPCOUNTONE++;
        }




        foreach ($production as $productions) {
            $project = Project::where('id', $productions[0])->get();


            $check = ProjectProduction::Create([
                'clientID' => $project[0]->clientID,
                'projectID' => $project[0]->productionID,
                'departmant' => $productions[1],
                'responsible_person' =>  $productions[2],
                'services' => $productions[3],
                'anycomment' =>  $productions[4],
                'created_at' => date('y-m-d H:m:s'),
                'updated_at' => date('y-m-d H:m:s')

            ]);
        }

        //return redirect('all/clients');

        $loginUser = $this->roleExits($request);

        if ($loginUser[2] == 0) {
            return redirect('all/clients');
        } else {
            return redirect('/assigned/clients');
        }
    }

    function editClient(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $brand = Brand::all();
        $projectManager = Employee::get();
        $department = Department::get();
        $productionservices = ProductionServices::get();
        $Client = Client::where('id', $id)->get();
        $ClientMeta = ClientMeta::where('clientID', $id)->get();
        $clientMetaCount = Count($ClientMeta);

        return view('editClient', [
            'clients' => $Client,
            'clientmetas' => $ClientMeta,
            'clientMetaCount' => $clientMetaCount,
            'Brands' => $brand,
            'ProjectManagers' => $projectManager,
            'departments' => $department,
            'productionservices' => $productionservices,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function editClientProcess(Request $request, $id)
    {
        $firstemail = $request->input('email');

        $createClient = Client::where('id', $id)
            ->Update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $firstemail[0],
                'brand' => $request->input('brand'),
                'frontSeler' => $request->input('saleperson'),
                'website' => $request->input('website'),
                'updated_at' => date('y-m-d H:m:s')
            ]);

        $ClientMeta = ClientMeta::where('clientID', $id)->get();
        if ($ClientMeta[0]->service == 'seo') {


            $SEO_ARRAY = [
                "KEYWORD_COUNT" => $request->input('KeywordCount'),
                "TARGET_MARKET" => $request->input('TargetMarket'),
                "OTHER_SERVICE" => $request->input('OtherServices'),
                "LEAD_PLATFORM" => $request->input('leadplatform'),
                "Payment_Nature" => $request->input('paymentnature'),
                "ANY_COMMITMENT" => $request->input('anycommitment')
            ];
            $clientmeta = DB::table('clientmetas')->where('clientID', $id)->update([
                'packageName' => $request->input('package'),
                'amountPaid' =>  $request->input('projectamount'),
                'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
                'nextPayment' =>  $request->input('nextamount'),
                'paymentRecuring' => $request->input('ChargingPlan'),
                'orderDetails' => json_encode($SEO_ARRAY),
                'otheremail' => json_encode($firstemail),
                'updated_at' => date('y-m-d H:m:s')
            ]);
        } elseif ($ClientMeta[0]->service == 'book') {


            $BOOK_ARRAY = [
                "PRODUCT" => $request->input('product'),
                "MENU_SCRIPT" => $request->input('menuscript'),
                "BOOK_GENRE" => $request->input('bookgenre'),
                "COVER_DESIGN" => $request->input('coverdesign'),
                "TOTAL_NUMBER_OF_PAGES" => $request->input('totalnumberofpages'),
                "PUBLISHING_PLATFORM" => $request->input('publishingplatform'),
                "ISBN_OFFERED" => $request->input('isbn_offered'),
                "LEAD_PLATFORM" => $request->input('leadplatform'),
                "ANY_COMMITMENT" => $request->input('anycommitment')
            ];
            $clientmeta = DB::table('clientmetas')->where('clientID', $id)->update([
                'packageName' => $request->input('package'),
                'amountPaid' =>  $request->input('projectamount'),
                'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
                'nextPayment' =>  $request->input('nextamount'),
                'paymentRecuring' => $request->input('ChargingPlan'),
                'orderDetails' => json_encode($BOOK_ARRAY),
                'otheremail' => json_encode($firstemail),
                'updated_at' => date('y-m-d H:m:s')
            ]);
        } elseif ($ClientMeta[0]->service == 'website') {

            $WEBSITE_ARRAY = [
                "OTHER_SERVICES" => $request->input('otherservices'),
                "LEAD_PLATFORM" => $request->input('leadplatform'),
                "ANY_COMMITMENT" => $request->input('anycommitment')

            ];

            $clientmeta = DB::table('clientmetas')->where('clientID', $id)->update([
                'packageName' => json_encode($request->input('package')),
                'amountPaid' =>  $request->input('projectamount'),
                'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
                'nextPayment' =>  $request->input('nextamount'),
                'paymentRecuring' => $request->input('ChargingPlan'),
                'orderDetails' => json_encode($WEBSITE_ARRAY),
                'otheremail' => json_encode($firstemail),
                'updated_at' => date('y-m-d H:m:s')
            ]);
        } else {

            $CLD_ARRAY = [
                "OTHER_SERVICES" => $request->input('otherservices'),
                "LEAD_PLATFORM" => $request->input('leadplatform'),
                "ANY_COMMITMENT" => $request->input('anycommitment')
            ];

            $clientmeta = DB::table('clientmetas')->where('clientID', $id)->update([
                'packageName' => json_encode($request->input('package')),
                'amountPaid' =>  $request->input('projectamount'),
                'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
                'nextPayment' =>  $request->input('nextamount'),
                'paymentRecuring' => $request->input('ChargingPlan'),
                'orderDetails' => json_encode($CLD_ARRAY),
                'otheremail' => json_encode($firstemail),
                'updated_at' => date('y-m-d H:m:s')
            ]);
        }

        $loginUser = $this->roleExits($request);

        if ($loginUser[2] == 0) {
            return redirect('all/clients');
        } else {
            return redirect('/assigned/clients');
        }

        //return redirect('all/clients');
    }

    function editClientProcess_withoutmeta(Request $request, $id)
    {
        $firstemail = $request->input('email');

        $createClient = Client::where('id', $id)
            ->Update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $firstemail[0],
                'brand' => $request->input('brand'),
                'frontSeler' => $request->input('saleperson'),
                'website' => $request->input('website'),
                'updated_at' => date('y-m-d H:m:s')
            ]);

        $domain = $request->input('domain');

        return redirect('/clientmetaupdate/' . $id . '/' . $domain);
    }

    function editClientmeta(Request $request, $id, $domain)
    {
        $loginUser = $this->roleExits($request);
        $clientid = $id;
        $domains = $domain;
        $productionservice = ProductionServices::get();
        return view('client_meta_editcreation', [
            'clientid' => $clientid,
            'domains' => $domains,
            'productionservices' => $productionservice,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function editClientProcess_withoutmeta_metacreationprocess(Request $request)
    {
        $domain = $request->input('serviceType');
        $client = $request->input('clientID');
        $findclient = Client::where('id', $client)->get();
        $a =  json_encode([$findclient[0]->email]);


        if ($domain == 'seo') {


            $SEO_ARRAY = [
                "KEYWORD_COUNT" => $request->input('KeywordCount'),
                "TARGET_MARKET" => $request->input('TargetMarket'),
                "OTHER_SERVICE" => $request->input('OtherServices'),
                "LEAD_PLATFORM" => $request->input('leadplatform'),
                "Payment_Nature" => $request->input('paymentnature'),
                "ANY_COMMITMENT" => $request->input('anycommitment')
            ];
            $clientmeta = ClientMeta::create([
                'clientID' => $client,
                'service' => $domain,
                'packageName' => $request->input('package'),
                'amountPaid' =>  $request->input('projectamount'),
                'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
                'nextPayment' =>  $request->input('nextamount'),
                'paymentRecuring' => $request->input('ChargingPlan'),
                'orderDetails' => json_encode($SEO_ARRAY),
                'otheremail' =>  $a,
                'updated_at' => date('y-m-d H:m:s')
            ]);
        } elseif ($domain == 'book') {


            $BOOK_ARRAY = [
                "PRODUCT" => $request->input('product'),
                "MENU_SCRIPT" => $request->input('menuscript'),
                "BOOK_GENRE" => $request->input('bookgenre'),
                "COVER_DESIGN" => $request->input('coverdesign'),
                "TOTAL_NUMBER_OF_PAGES" => $request->input('totalnumberofpages'),
                "PUBLISHING_PLATFORM" => $request->input('publishingplatform'),
                "ISBN_OFFERED" => $request->input('isbn_offered'),
                "LEAD_PLATFORM" => $request->input('leadplatform'),
                "ANY_COMMITMENT" => $request->input('anycommitment')
            ];
            $clientmeta = ClientMeta::create([
                'clientID' => $client,
                'service' => $domain,
                'packageName' => $request->input('package'),
                'amountPaid' =>  $request->input('projectamount'),
                'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
                'nextPayment' =>  $request->input('nextamount'),
                'paymentRecuring' => $request->input('ChargingPlan'),
                'orderDetails' => json_encode($BOOK_ARRAY),
                'otheremail' =>  $a,
                'updated_at' => date('y-m-d H:m:s')
            ]);
        } elseif ($domain == 'website') {

            $WEBSITE_ARRAY = [
                "OTHER_SERVICES" => $request->input('otherservices'),
                "LEAD_PLATFORM" => $request->input('leadplatform'),
                "ANY_COMMITMENT" => $request->input('anycommitment')

            ];

            $clientmeta = ClientMeta::create([
                'clientID' => $client,
                'service' => $domain,
                'packageName' => json_encode($request->input('package')),
                'amountPaid' =>  $request->input('projectamount'),
                'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
                'nextPayment' =>  $request->input('nextamount'),
                'paymentRecuring' => $request->input('ChargingPlan'),
                'orderDetails' => json_encode($WEBSITE_ARRAY),
                'otheremail' =>  $a,
                'updated_at' => date('y-m-d H:m:s')
            ]);
        } else {

            $CLD_ARRAY = [
                "OTHER_SERVICES" => $request->input('otherservices'),
                "LEAD_PLATFORM" => $request->input('leadplatform'),
                "ANY_COMMITMENT" => $request->input('anycommitment')
            ];

            $clientmeta = ClientMeta::create([
                'clientID' => $client,
                'service' => $domain,
                'packageName' => json_encode($request->input('package')),
                'amountPaid' =>  $request->input('projectamount'),
                'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
                'nextPayment' =>  $request->input('nextamount'),
                'paymentRecuring' => $request->input('ChargingPlan'),
                'orderDetails' => json_encode($CLD_ARRAY),
                'otheremail' =>  $a,
                'updated_at' => date('y-m-d H:m:s')
            ]);
        }

        $loginUser = $this->roleExits($request);

        if ($loginUser[2] == 0) {
            return redirect('all/clients');
        } else {
            return redirect('/assigned/clients');
        }

        //return redirect('all/clients');


    }

    function book(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brand = Brand::all();
        $projectManager = Employee::get();
        $department = Department::get();
        $productionservices = ProductionServices::get();

        return view('book_kyc', [
            'Brands' => $brand,
            'ProjectManagers' => $projectManager,
            'departments' => $department,
            'productionservices' => $productionservices,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function website(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brand = Brand::all();
        $projectManager = Employee::get();
        $department = Department::get();
        $productionservices = ProductionServices::get();

        return view('website_kyc', [
            'Brands' => $brand,
            'ProjectManagers' => $projectManager,
            'departments' => $department,
            'productionservices' => $productionservices,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function cld(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brand = Brand::all();
        $projectManager = Employee::get();
        $department = Department::get();
        $productionservices = ProductionServices::get();

        return view('cld_kyc', [
            'Brands' => $brand,
            'ProjectManagers' => $projectManager,
            'departments' => $department,
            'productionservices' => $productionservices,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function clientProject(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $findclient = Client::get();
        $employee = Employee::get();
        $user_id = 2;
        return view('project', [
            'user_id' => $user_id,
            'clients' => $findclient,
            'employee' => $employee,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function assgnedclientProject(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $findclient = QaPersonClientAssign::where('user', $loginUser[1][0]->id)->get();
        $employee = Employee::get();
        $user_id = 1;
        return view('project', [
            'user_id' => $user_id,
            'clients' => $findclient,
            'employee' => $employee,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function clientProjectProcess(Request $request)
    {
        Project::create([
            'clientID' => $request->input('client'),
            'projectManager' => $request->input('pm'),
            'productionID' => $request->input('productionID'),
            'name' => $request->input('name'),
            "domainOrwebsite" => $request->input('website'),
            "basecampUrl" => $request->input('basecampurl'),
            "projectDescription" =>  $request->input('openingcomments')
        ]);

        return redirect('/client/project/productions/' . $request->input('productionID'));
    }

    function clientProject_prefilled(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $findclient = Client::Where('id', $id)->get();
        $employee = Employee::get();
        $user_id = 2;
        return view('project', [
            'user_id' => $user_id,
            'clients' => $findclient,
            'employee' => $employee,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function Project_production(Request $request, string $id)
    {
        $loginUser = $this->roleExits($request);
        $production = ProjectProduction::where('projectID', $id)->get();
        $productionservices = ProductionServices::get();

        $project = Project::where('productionID', $id)->get();
        $department = Department::get();
        $departstatus = Count($department);
        $employee = Employee::get();

        return view('projectProduction', [
            'departstatus' => $departstatus,
            'departments' => $department,
            'employees' => $employee,
            'project_id' => $project,
            'productions' => $production,
            'projects' => $project,
            'productionservices' => $productionservices,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function Project_ProductionProcess(Request $request, $id)
    {

        ProjectProduction::create([
            'clientID' =>  $request->input('clientname'),
            'projectID' =>  $request->input('projectid'),
            'departmant' => $request->input('department'),
            'responsible_person' => $request->input('production'),
            "services" => json_encode($request->input('services')),
            "anycomment" => $request->input('Description'),
        ]);

        return redirect('/client/project/productions/' . $request->input('projectid'));
    }

    function ProjectProduction_users(Request $request, string $id)
    {
        $loginUser = $this->roleExits($request);
        $project = Project::where('productionID', $id)->get();
        $projectProduction = ProjectProduction::where('projectID', $id)->get();

        return view('projectproductionUsers', [
            'projects' => $project,
            'productions' => $projectProduction,
            'prjectid' => $id,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function editproject(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $findproject = Project::Where('id', $id)->get();
        $findclient = Client::get();
        $employee = Employee::get();
        return view('editproject', [
            'clients' => $findclient,
            'employee' => $employee,
            'projects' => $findproject,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function editProjectProcess(Request $request, $id)
    {
        $editproject = Project::where('id', $id)
            ->update([
                'clientID' => $request->input('client'),
                'projectManager' => $request->input('pm'),
                'name' => $request->input('name'),
                "domainOrwebsite" => $request->input('website'),
                "basecampUrl" => $request->input('basecampurl'),
                "projectDescription" =>  $request->input('openingcomments')
            ]);

        return redirect('/client/details/' . $request->input('client'));
    }

    function deleteproject(Request $request, $id)
    {
        $project = Project::where('id', $id)->get();
        $projectProduction = ProjectProduction::where('projectID', $project[0]->productionID)->get();

        $deleteproduction = DB::table('project_productions')->where('projectID', $project[0]->productionID)->delete();
        $deleteProject = DB::table('projects')->where('id', $id)->delete();


        return redirect('/client/details/' . $project[0]->clientID);
    }

    function Edit_Project_production(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $projectProduction = ProjectProduction::where('id', $id)->get();
        $department = Department::get();
        $employee = Employee::get();
        $productionservices = ProductionServices::get();

        return view('edit_project_production', [
            'projectProductions' => $projectProduction,
            'departments' => $department,
            'employees' => $employee,
            'productionservices' => $productionservices,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function Edit_Project_production_Process(Request $request, $id)
    {
        $projectid = ProjectProduction::where('id', $id)->get();
        $projectproduction = ProjectProduction::where('id', $id)
            ->update([
                'departmant' => $request->input('department'),
                'responsible_person' => $request->input('production'),
                'services' => json_encode($request->input('services')),
                'anycomment' => $request->input('Description'),
            ]);


        return redirect('/client/project/productions/users/' . $projectid[0]->projectID);
    }

    function deleteproduction($id)
    {
        $production_id = ProjectProduction::where('id', $id)->get();
        $deletedproduction = DB::table('project_productions')->where('id', $id)->delete();

        //$companydeleted = DB::table('companies')->where('id', $id)->delete();

        return redirect('/client/project/productions/users/' . $production_id[0]->projectID);
    }

    function getclientDetails(Request $request, $clientID)
    {
        $loginUser = $this->roleExits($request);
        $findclient = Client::where('id', $clientID)->get();
        $allprojects = Project::where('clientID', $clientID)->get();
        $recentClients = Client::where('id', '!=', $clientID)->limit(5)->get();
        $clientPayments = NewPaymentsClients::where('ClientID', $clientID)
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->get();

        $qaAssignee = QaPersonClientAssign::where('client', $clientID)->get();
        if (count($allprojects) > 0) {
            $findProject_Manager = Employee::where('id', $allprojects[0]->projectManager)->get();
        } else {
            $findProject_Manager = [];
        }

        foreach ($allprojects as $allproject) {
            $COUNT = QAFORM::where('projectID', $allproject->id)->count();
            $Payment = NewPaymentsClients::where('ProjectID', $allproject->id)->count();
            $allproject->project_count = $COUNT;
            $allproject->payment_count = $Payment;
        }

        // $projectforPayments = Project::select('id')->where('clientID', $clientID)->get();

        // $uniquepaymentarray = [];
        // foreach ($projectforPayments as $allproject) {
        //     $Payment = NewPaymentsClients::where('ClientID', $clientID)
        //         ->where('ProjectID', $allproject->id)
        //         ->where('refundStatus', 'Pending Payment')
        //         ->where('remainingStatus','!=','Unlinked Payments')
        //         ->get();

        //         foreach ($Payment as $transaction) {
        //             $transactionType = $transaction['transactionType'];

        //             if (!array_key_exists($transactionType, $uniquepaymentarray)) {
        //                 $allproject[$transactionType] = $transaction;
        //             }
        //         }


        // }

        $uniquepaymentarray = [];

        foreach ($allprojects as $allproject) {

            $transactions = NewPaymentsClients::where('ClientID', $clientID)
                ->where('ProjectID', $allproject->id)
                ->where('refundStatus', 'Pending Payment')
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->get();

            foreach ($transactions as $transaction) {
                $transactionType = $transaction['transactionType'];


                if (!array_key_exists($allproject->id, $uniquepaymentarray)) {
                    $uniquepaymentarray[$allproject->id] = [];
                }

                if (!array_key_exists($transactionType, $uniquepaymentarray[$allproject->id])) {
                    $uniquepaymentarray[$allproject->id][$transactionType] = $transaction;
                }
            }
        }

        $checkingpayments = NewPaymentsClients::where('ClientID', $clientID)
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->get();

        foreach ($checkingpayments as $checkingpayment) {

            $RefundPayments = RefundPayments::where('PaymentID', $checkingpayment->id)->get();
            $checkingpayment->refund_with_payments = $RefundPayments;
        }

        $clientrefundcount = NewPaymentsClients::where('ClientID', $clientID)
            ->where('refundStatus', '!=', 'On Going')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('dispute', null)
            ->count();
        $clientPaid = NewPaymentsClients::where('ClientID', $clientID)
            ->where('refundStatus', 'On Going')
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('refundID', null)
            ->where('dispute', null)
            ->SUM('Paid');
        $clienttotalwithoutRefund = NewPaymentsClients::where('ClientID', $clientID)
            ->where('refundStatus', 'On Going')
            ->where('paymentNature', '!=', 'Remaining')
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundID', null)
            ->where('dispute', null)
            ->SUM('TotalAmount');
        $clientallpayment = NewPaymentsClients::where('ClientID', $clientID)->get();
        $storeremianingpayment = [];
        foreach ($clientallpayment as  $clientallpayments) {
            if (((isset($clientallpayments->refundID)) || (isset($clientallpayments->dispute))) && isset($clientallpayments->remainingID)) {
                $paymentofremaining = NewPaymentsClients::where('ClientID', $clientID)
                    ->select('id', 'TotalAmount')
                    ->where('remainingID', $clientallpayments->remainingID)
                    ->where('paymentNature', 'Remaining')
                    ->where('remainingStatus', '!=', 'Unlinked Payments')
                    ->where('refundID', null)
                    ->where('dispute', null)
                    ->get();
                $storeremianingpayment[] = [$paymentofremaining];
            } else {
                continue;
            }
        }

        $totalSum = 0;

        foreach ($storeremianingpayment as $paymentArray) {
            foreach ($paymentArray as $paymentObject) {
                if (isset($paymentObject[0]->TotalAmount) &&  $paymentObject[0]->TotalAmount != null) {
                    $a = $paymentObject[0]->TotalAmount;
                } else {
                    $a = 0;
                }
                $totalSum += $a;
            }
        }

        $total = $clienttotalwithoutRefund + $totalSum;
        $clientRemaining = $total - $clientPaid;

        $unlinkedpayment = NewPaymentsClients::where('ClientID', $clientID)
            ->where('remainingStatus', 'Unlinked Payments')
            ->where('dispute', null)
            ->count();

        $disputepayment = Disputedpayments::where('ClientID', $clientID)
            ->get();




        $paymentreceived = NewPaymentsClients::where('ClientID', $clientID)
            ->where('refundStatus', 'On Going')
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('refundID', null)
            ->where('dispute', null)
            ->SUM('amt_after_transactionfee');

        $disputefee = NewPaymentsClients::where('ClientID', $clientID)
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('paymentNature', 'Dispute Lost')
            ->SUM('disputefee');

        $deisputelosttransactionfee = NewPaymentsClients::where('ClientID', $clientID)
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('paymentNature', 'Dispute Lost')
            ->SUM('transactionfee');

        $refundtransactionfeedata = NewPaymentsClients::where('ClientID', $clientID)
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('paymentNature', '!=', 'Dispute Lost')
            ->where('refundStatus', '!=', 'Refund')
            ->where('refundID', '!=', null)
            ->where('dispute', null)
            ->SUM('transactionfee');


        $netReceivedamt = $paymentreceived - $disputefee - $deisputelosttransactionfee - $refundtransactionfeedata;


        return view('clientDetail', [
            'client' => $findclient,
            'qaAssignee' => $qaAssignee,
            'recentClients' => $recentClients,
            'clientPayments' => $clientPayments,
            'uniquepaymentarray' => $uniquepaymentarray,
            'cashflows' => $checkingpayments,
            'projects' => $allprojects,
            'findProject_Manager' => $findProject_Manager,
            'clientPaid' => $clientPaid,
            'clientRemaining' => $clientRemaining,
            'clienttotalwithoutRefund' => $total,
            'clientrefundcount' => $clientrefundcount,
            'disputepayment' => $disputepayment,
            'unlinkedpayment' => $unlinkedpayment,
            'netReceivedamt' => $netReceivedamt,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function allclients(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $findclient = Client::get();
        $user_id = 0;
        return view('allclients', [
            'user_id' => $user_id,
            'clients' => $findclient,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function monthClient(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $findclient = Client::whereMonth('created_at', now())->get();
        $user_id = count($findclient);
        return view('currentMonth_Client', [
            'user_id' => $user_id,
            'clients' => $findclient,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function assignedclients(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $findclient = QaPersonClientAssign::where('user', $loginUser[1][0]->id)->get();
        $user_id = 1;
        return view('allclients', [
            'user_id' => $user_id,
            'clients' => $findclient,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function addPayment(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brand = Brand::get();
        $department = Department::get();
        $employee = Employee::get();
        $project = Project::get();
        $client = Client::get();
        $qa_issues = QaIssues::get();
        $qarole = 0;
        return view('select_clientProjectPayment', [
            'qarole' => $qarole,
            'brands' => $brand,
            'departments' => $department,
            'projects' => $project,
            'clients' => $client,
            'employees' => $employee,
            'qaissues' => $qa_issues,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }
    function addPaymentProcess(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $paymenttype = $request->input('payment_type');
        if ($paymenttype == 0) {
            return redirect('/forms/payment/' . $request->input('projectname'));
        } else {
            return redirect('/client/project/payment/Refund/' . $request->input('projectname'));
        }
    }


    function newClientPayment(Request $request)
    {

        $loginUser = $this->roleExits($request);
        $findemployee = Employee::get();
        $brand = Brand::get();
        return view('newclientpayment', [
            'employee' => $findemployee,
            'brands' => $brand,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function newClientPaymentprocess(Request $request)
    {

        $loginUser = $this->roleExits($request);

        if($loginUser[2] == 0){
            $userid = 0;
        }else{
            $qaPerson = $request->session()->get('AdminUser');
            $userid = $qaPerson[0]->id;
        }


        $firstemails = $request->input('email');
        $findclient = 0;

        foreach ($firstemails as $email) {
            $findclient += Clientmeta::whereJsonContains('otheremail', $email)->count();
        }

        if ($findclient > 0) {
            return redirect()->back()->with('Error', 'Client Email Found. Please use a new email.');
        }


        $createClient = Client::insertGetId([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $firstemails[0],
            'brand' => $request->input('brand'),
            'frontSeler' => $request->input('saleperson'),
            'website' => $request->input('website'),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s')
        ]);

        $paymentType = $request->input('paymentType');
        $paymentNature = $request->input('paymentNature');
        $findusername = DB::table('employees')->where('id', $request->input('saleperson'))->get();
        $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
        $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
        $brandID = $request->input('brand');

        if ($remainingamt == 0) {
            $remainingstatus = "Not Remaining";
        } else {
            $remainingstatus = "Remaining";
        }

        if ($request->file('bankWireUpload') != null) {
            $bookwire = $request->file('bankWireUpload')->store('Payment');
        } else {
            $bookwire = "--";
        }

        $transactionType = $request->input('paymentNature');

        if ($request->input('nextpaymentdate') != null) {
            $date =  $request->input('nextpaymentdate');
        } elseif ($request->input('ChargingPlan') != null && $request->input('nextpaymentdate') == null) {
            $today = date('Y-m-d');
            if ($request->input('ChargingPlan') == "One Time Payment") {
                $date = null;
            } elseif ($request->input('ChargingPlan') == "Monthly") {
                $date = date('Y-m-d', strtotime('+1 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "2 Months") {
                $date = date('Y-m-d', strtotime('+2 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "3 Months") {
                $date = date('Y-m-d', strtotime('+3 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "4 Months") {
                $date = date('Y-m-d', strtotime('+4 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "5 Months") {
                $date = date('Y-m-d', strtotime('+5 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "6 Months") {
                $date = date('Y-m-d', strtotime('+6 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "7 Months") {
                $date = date('Y-m-d', strtotime('+7 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "8 Months") {
                $date = date('Y-m-d', strtotime('+8 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "9 Months") {
                $date = date('Y-m-d', strtotime('+9 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "10 Months") {
                $date = date('Y-m-d', strtotime('+10 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "11 Months") {
                $date = date('Y-m-d', strtotime('+11 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "12 Months") {
                $date = date('Y-m-d', strtotime('+1 Year', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "2 Years") {
                $date = date('Y-m-d', strtotime('+2 Year', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "3 Years") {
                $date = date('Y-m-d', strtotime('+3 Year', strtotime($today)));
            }
        } else {
            $date = $request->input('nextpaymentdate');
        }

        $transactionfee = $request->input('clientpaid') * 0.03;

        $createpayment = NewPaymentsClients::insertGetId([
            "BrandID" => $brandID,
            "ClientID" => $createClient,
            "ProjectID" => 0,
            "ProjectManager" => 0,
            "paymentNature" => $request->input('paymentNature'),
            "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
            "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
            "Platform" => $request->input('platform'),
            "Card_Brand" => $request->input('cardBrand'),
            "Payment_Gateway" => $request->input('paymentgateway'),
            "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
            "TransactionID" => $request->input('transactionID'),
            "paymentDate" => $request->input('paymentdate'),
            "futureDate" => $date,
            "SalesPerson" => $request->input('saleperson'),
            "TotalAmount" => $request->input('totalamount'),
            "Paid" => $request->input('clientpaid'),
            "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
            "PaymentType" => $request->input('paymentType'),
            "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
            "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
            "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
            "Description" => $request->input('description'),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s'),
            "refundStatus" => 'On Going',
            "remainingStatus" => $remainingstatus,
            "transactionType" => $transactionType,
            "transactionfee" => $transactionfee,
            "amt_after_transactionfee" => $request->input('clientpaid') - $transactionfee,
            "qaperson" => $userid

        ]);

        return redirect('/client/project/payment/all');
    }



    function payment(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);

        $findproject = Project::where('id', $id)->get();
        $brand = Brand::get();
        $findclientofproject = Client::where('id', $findproject[0]->clientID)->get();
        $findclient = Client::get();
        // $pmdepartment = Department::where('brand', $findclientofproject[0]->brand)->where(function ($query) {
        //     $query->where('name', 'LIKE', '%Project manager')
        //         ->orWhere('name', 'LIKE', 'Project manager%')
        //         ->orWhere('name', 'LIKE', '%Project manager%');
        // })->get();
        // $pmemployee = Employee::whereIn('id', json_decode($pmdepartment[0]->users))->get();
        // $saledepartment = Department::where('brand', $findclientofproject[0]->brand)->where(function ($query) {
        //     $query->where('name', 'LIKE', '%sale')
        //         ->orWhere('name', 'LIKE', 'sale%')
        //         ->orWhere('name', 'LIKE', '%sale%');
        // })->get();
        // $saleemployee = Employee::whereIn('id', json_decode($saledepartment[0]->users))->get();
        $findemployee = Employee::get();
        $get_projectCount = Project::where('clientID', $findproject[0]->ClientName->id)->count();
        $allPayments = NewPaymentsClients::where('ClientID', $findproject[0]->ClientName->id)
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->get();
        $remainingpayments = NewPaymentsClients::where('ClientID', $findproject[0]->ClientName->id)
            ->where('ProjectID', $id)
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('remainingStatus', 'Remaining')
            ->get();
        $remainingpaymentcount = count($remainingpayments);
        return view('payment', [
            'allPayments' => $allPayments,
            'id' => $id,
            'brand' => $brand,
            'projectmanager' => $findproject,
            'findclientofproject' => $findclientofproject,
            'clients' => $findclient,
            'employee' => $findemployee,
            'pmemployee' => $findemployee,
            'saleemployee' => $findemployee,
            'remainingpayments' => $remainingpayments,
            'remainingpaymentcount' => $remainingpaymentcount,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }
    function clientPayment(Request $request)
    {
        $loginUser = $this->roleExits($request);

        if($loginUser[2] == 0){
            $userid = 0;
        }else{
            $qaPerson = $request->session()->get('AdminUser');
            $userid = $qaPerson[0]->id;
        }

        $paymentType = $request->input('paymentType');
        $paymentNature = $request->input('paymentNature');
        $findusername = DB::table('employees')->where('id', $request->input('saleperson'))->get();
        $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
        $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
        $brandID = $request->input('brand');
        $transactionfee = $request->input('clientpaid') * 0.03;

        if ($request->input('paymentNature') != "Remaining" && $request->input('paymentNature') != "FSRemaining") {
            // echo("is not remaining");
            // die();

            if ($remainingamt == 0) {
                $remainingstatus = "Not Remaining";
            } else {
                $remainingstatus = "Remaining";
            }

            if ($request->file('bankWireUpload') != null) {
                $bookwire = $request->file('bankWireUpload')->store('Payment');
            } else {
                $bookwire = "--";
            }

            $upsellCount = NewPaymentsClients::where('ClientID', $request->input('clientID'))->where('paymentNature', 'Upsell')->count();
            // $transactionType = $request->input('paymentNature');

            if ($request->input('paymentNature') == 'Upsell') {
                if ($upsellCount == 0) {
                    $transactionType = $request->input('paymentNature');
                } else {
                    $transactionType = $request->input('paymentNature') . "(" . $upsellCount . ")";
                }
            } else {
                $transactionType = $request->input('paymentNature');
            }


            if ($request->input('nextpaymentdate') != null) {

                $createpayment = NewPaymentsClients::insertGetId([
                    "BrandID" => $brandID,
                    "ClientID" => $request->input('clientID'),
                    "ProjectID" => $request->input('project'),
                    "ProjectManager" => $request->input('accountmanager'),
                    "paymentNature" => $request->input('paymentNature'),
                    "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform" => $request->input('platform'),
                    "Card_Brand" => $request->input('cardBrand'),
                    "Payment_Gateway" => $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID" => $request->input('transactionID'),
                    "paymentDate" => $request->input('paymentdate'),
                    "futureDate" => $request->input('nextpaymentdate'),
                    "SalesPerson" => $request->input('saleperson'),
                    "TotalAmount" => $request->input('totalamount'),
                    "Paid" => $request->input('clientpaid'),
                    "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType" => $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description" => $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus" => 'On Going',
                    "remainingStatus" => $remainingstatus,
                    "transactionType" => $transactionType,
                    "transactionfee" =>  $transactionfee,
                    "amt_after_transactionfee" => $request->input('clientpaid') -  $transactionfee,
                    "qaperson" => $userid

                ]);
            } elseif ($request->input('ChargingPlan') != null && $request->input('nextpaymentdate') == null) {

                $today = date('Y-m-d');
                if ($request->input('ChargingPlan') == "One Time Payment") {
                    $date = null;
                } elseif ($request->input('ChargingPlan') == "Monthly") {
                    $date = date('Y-m-d', strtotime('+1 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "2 Months") {
                    $date = date('Y-m-d', strtotime('+2 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "3 Months") {
                    $date = date('Y-m-d', strtotime('+3 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "4 Months") {
                    $date = date('Y-m-d', strtotime('+4 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "5 Months") {
                    $date = date('Y-m-d', strtotime('+5 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "6 Months") {
                    $date = date('Y-m-d', strtotime('+6 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "7 Months") {
                    $date = date('Y-m-d', strtotime('+7 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "8 Months") {
                    $date = date('Y-m-d', strtotime('+8 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "9 Months") {
                    $date = date('Y-m-d', strtotime('+9 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "10 Months") {
                    $date = date('Y-m-d', strtotime('+10 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "11 Months") {
                    $date = date('Y-m-d', strtotime('+11 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "12 Months") {
                    $date = date('Y-m-d', strtotime('+1 Year', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "2 Years") {
                    $date = date('Y-m-d', strtotime('+2 Year', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "3 Years") {
                    $date = date('Y-m-d', strtotime('+3 Year', strtotime($today)));
                }


                $createpayment = NewPaymentsClients::insertGetId([
                    "BrandID" => $brandID,
                    "ClientID" => $request->input('clientID'),
                    "ProjectID" => $request->input('project'),
                    "ProjectManager" => $request->input('accountmanager'),
                    "paymentNature" => $request->input('paymentNature'),
                    "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform" => $request->input('platform'),
                    "Card_Brand" => $request->input('cardBrand'),
                    "Payment_Gateway" => $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID" => $request->input('transactionID'),
                    "paymentDate" => $request->input('paymentdate'),
                    "futureDate" => $date,
                    "SalesPerson" => $request->input('saleperson'),
                    "TotalAmount" => $request->input('totalamount'),
                    "Paid" => $request->input('clientpaid'),
                    "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType" => $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description" => $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus" => 'On Going',
                    "remainingStatus" => $remainingstatus,
                    "transactionType" => $transactionType,
                    "transactionfee" =>  $transactionfee,
                    "amt_after_transactionfee" => $request->input('clientpaid') -  $transactionfee,
                    "qaperson" => $userid

                ]);
            } else {

                $createpayment = NewPaymentsClients::insertGetId([
                    "BrandID" => $brandID,
                    "ClientID" => $request->input('clientID'),
                    "ProjectID" => $request->input('project'),
                    "ProjectManager" => $request->input('accountmanager'),
                    "paymentNature" => $request->input('paymentNature'),
                    "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform" => $request->input('platform'),
                    "Card_Brand" => $request->input('cardBrand'),
                    "Payment_Gateway" => $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID" => $request->input('transactionID'),
                    "paymentDate" => $request->input('paymentdate'),
                    "futureDate" => $request->input('nextpaymentdate'),
                    "SalesPerson" => $request->input('saleperson'),
                    "TotalAmount" => $request->input('totalamount'),
                    "Paid" => $request->input('clientpaid'),
                    "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType" => $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description" => $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus" => 'On Going',
                    "remainingStatus" => $remainingstatus,
                    "transactionType" => $transactionType,
                    "transactionfee" =>  $transactionfee,
                    "amt_after_transactionfee" => $request->input('clientpaid') -  $transactionfee,
                    "qaperson" => $userid

                ]);
            }

            if ($request->input('nextpaymentdate') == null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment") {

                if ($request->input('paymentModes') == 'Renewal') {
                    $paymentNature = "Renewal Payment";
                } else {
                    $paymentNature = "Recurring Payment";
                }



                $interval = $request->input('ChargingPlan');
                $today = date('Y-m-d');

                for ($i = 1; $i <= 10; $i++) {
                    if ($interval == "One Time Payment") {
                        $datefinal = null;
                    } elseif ($interval == "Monthly") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) . ' month', strtotime($today)));
                    } elseif ($interval == "2 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' month', strtotime($today)));
                    } elseif ($interval == "3 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' month', strtotime($today)));
                    } elseif ($interval == "4 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                    } elseif ($interval == "5 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                    } elseif ($interval == "6 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                    } elseif ($interval == "7 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                    } elseif ($interval == "8 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                    } elseif ($interval == "9 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                    } elseif ($interval == "10 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                    } elseif ($interval == "11 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                    } elseif ($interval == "12 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                    } elseif ($interval == "2 Years") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                    } elseif ($interval == "3 Years") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                    }
                    // echo $datefinal . "<br>";



                    $futurePayment = NewPaymentsClients::create([
                        "BrandID" => $brandID,
                        "ClientID" => $request->input('clientID'),
                        "ProjectID" => $request->input('project'),
                        "ProjectManager" => $request->input('accountmanager'),
                        "paymentNature" =>  $paymentNature,
                        "ChargingPlan" => '--',
                        "ChargingMode" => '--',
                        "Platform" => '--',
                        "Card_Brand" => '--',
                        "Payment_Gateway" => '--',
                        "bankWireUpload" => '--',
                        "TransactionID" => '--',
                        // "paymentDate"=> $request->input('paymentdate'),
                        "futureDate" => $datefinal,
                        "SalesPerson" => $request->input('saleperson'),
                        "TotalAmount" => $request->input('totalamount'),
                        "Paid" => 0,
                        "RemainingAmount" => 0,
                        "PaymentType" => '--',
                        "numberOfSplits" => '--',
                        "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                        "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                        "Description" => '--',
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus" => 'Pending Payment',
                        "remainingStatus" => '--',
                        "transactionType" => $transactionType,
                        "transactionfee" =>  $transactionfee,
                        "amt_after_transactionfee" => $request->input('clientpaid') -  $transactionfee,
                        "qaperson" => $userid

                    ]);
                }
            } elseif ($request->input('nextpaymentdate') != null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment") {

                if ($request->input('paymentModes') == 'Renewal') {
                    $paymentNature = "Renewal Payment";
                } else {
                    $paymentNature = "Recurring Payment";
                }



                $interval = $request->input('ChargingPlan');
                $today = $request->input('nextpaymentdate');

                for ($i = 1; $i <= 10; $i++) {
                    if ($interval == "One Time Payment") {
                        $datefinal = null;
                    } elseif ($interval == "Monthly") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) . ' month', strtotime($today)));
                    } elseif ($interval == "2 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' month', strtotime($today)));
                    } elseif ($interval == "3 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' month', strtotime($today)));
                    } elseif ($interval == "4 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                    } elseif ($interval == "5 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                    } elseif ($interval == "6 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                    } elseif ($interval == "7 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                    } elseif ($interval == "8 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                    } elseif ($interval == "9 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                    } elseif ($interval == "10 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                    } elseif ($interval == "11 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                    } elseif ($interval == "12 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                    } elseif ($interval == "2 Years") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                    } elseif ($interval == "3 Years") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                    }
                    // echo $datefinal . "<br>";



                    $futurePayment = NewPaymentsClients::create([
                        "BrandID" => $brandID,
                        "ClientID" => $request->input('clientID'),
                        "ProjectID" => $request->input('project'),
                        "ProjectManager" => $request->input('accountmanager'),
                        "paymentNature" =>  $paymentNature,
                        "ChargingPlan" => '--',
                        "ChargingMode" => '--',
                        "Platform" => '--',
                        "Card_Brand" => '--',
                        "Payment_Gateway" => '--',
                        "bankWireUpload" => '--',
                        "TransactionID" => '--',
                        // "paymentDate"=> $request->input('paymentdate'),
                        "futureDate" => $datefinal,
                        "SalesPerson" => $request->input('saleperson'),
                        "TotalAmount" => $request->input('totalamount'),
                        "Paid" => 0,
                        "RemainingAmount" => 0,
                        "PaymentType" => '--',
                        "numberOfSplits" => '--',
                        "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                        "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                        "Description" => '--',
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus" => 'Pending Payment',
                        "remainingStatus" => '--',
                        "transactionType" => $transactionType,
                        "transactionfee" =>  $transactionfee,
                        "amt_after_transactionfee" => $request->input('clientpaid') -  $transactionfee,
                        "qaperson" => $userid

                    ]);
                }
            }


            if ($paymentType == "Split Payment") {
                $paymentDescription = $findusername[0]->name . " Charge Payment For Client " . $findclient[0]->name;
                $totalamount = $request->input('totalamount');
                $amountShare = $request->input('splitamount');
                $sharedProjectManager = $request->input('shareProjectManager');
                $c = [];
                $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

                $createMainEmployeePayment  = EmployeePayment::create([
                    "paymentID" => $createpayment,
                    "employeeID" => $request->input('saleperson'),
                    "paymentDescription" => $paymentDescription,
                    "amount" => $amount
                ]);



                foreach ($sharedProjectManager as $key => $value) {
                    $c[$key] = [$value, $amountShare[$key]];
                }

                foreach ($c as $SecondProjectManagers) {
                    if ($SecondProjectManagers[0] != 0) {
                        $createSharedPersonEmployeePayment  = EmployeePayment::create(
                            [
                                "paymentID" => $createpayment,
                                "employeeID" => $SecondProjectManagers[0],
                                "paymentDescription" => "Amount Share By " . $findusername[0]->name,
                                "amount" =>  $SecondProjectManagers[1]
                            ]
                        );
                    }
                }
            } else {

                $paymentDescription = $findusername[0]->name . " Charge Payment For Client " . $findclient[0]->name;
                $clientpaid = $request->input('clientpaid');



                $createEmployeePayment  = EmployeePayment::create(
                    [
                        "paymentID" => $createpayment,
                        "employeeID" => $request->input('saleperson'),
                        "paymentDescription" =>  $paymentDescription,
                        "amount" =>   $clientpaid
                    ]
                );
            }
        } elseif ($request->input('paymentNature') == "Remaining" && $request->input('paymentNature') != "FSRemaining") {
            // echo("is remaining");
            // die();

            $checkremaining = NewPaymentsClients::where('id', $request->input('remainingamountfor'))->get();

            if (isset($checkremaining[0]->remainingID) && $checkremaining[0]->remainingID != null) {

                $paymentType = $request->input('paymentType');
                $paymentNature = $request->input('paymentNature');
                $findusername = DB::table('employees')->where('id', $request->input('accountmanager'))->get();
                $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
                $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
                $gettingpayment = NewPaymentsClients::where('remainingID', $checkremaining[0]->remainingID)->sum("Paid");
                $checkingtotalremaining = $checkremaining[0]->TotalAmount - $gettingpayment - $request->input('clientpaid');

                // echo($checkingtotalremaining);
                // die();

                if ($checkingtotalremaining == 0) {
                    $remainingstatus = "Received Remaining";
                } else {
                    $remainingstatus = "Remaining";
                }

                if ($request->file('bankWireUpload') != null) {
                    $bookwire = $request->file('bankWireUpload')->store('Payment');
                } else {
                    $bookwire = "--";
                }

                $changeStatus = NewPaymentsClients::where('id', $request->input('remainingamountfor'))->update([
                    "remainingStatus"  => $remainingstatus
                ]);
                $transactionType = $request->input('paymentNature');


                // if( $request->input('nextpaymentdate') != null ){

                $createpayment = NewPaymentsClients::insertGetId([
                    "BrandID" => $brandID,
                    "ClientID" => $request->input('clientID'),
                    "ProjectID" => $request->input('project'),
                    "ProjectManager" => $request->input('accountmanager'),
                    "paymentNature" => $request->input('paymentNature'),
                    "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform" => $request->input('platform'),
                    "Card_Brand" => $request->input('cardBrand'),
                    "Payment_Gateway" => $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID" => $request->input('transactionID'),
                    "paymentDate" => $request->input('paymentdate'),
                    // "futureDate"=> $request->input('nextpaymentdate'),
                    "SalesPerson" => $request->input('saleperson'),
                    "TotalAmount" => $request->input('totalamount'),
                    "Paid" => $request->input('clientpaid'),
                    "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType" => $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description" => $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus" => 'On Going',
                    "remainingID" => $checkremaining[0]->remainingID,
                    "remainingStatus" =>  "Remaining Payment",
                    "transactionType" => $transactionType,
                    "transactionfee" =>  $transactionfee,
                    "amt_after_transactionfee" => $request->input('clientpaid') -  $transactionfee,
                    "qaperson" => $userid

                ]);


                if ($paymentType == "Split Payment") {

                    $paymentDescription = $findusername[0]->name . " Charge Remaining Payment For Client " . $findclient[0]->name;
                    $totalamount = $request->input('totalamount');
                    $amountShare = $request->input('splitamount');
                    $sharedProjectManager = $request->input('shareProjectManager');
                    $c = [];
                    $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

                    $createMainEmployeePayment  = EmployeePayment::create([
                        "paymentID" => $createpayment,
                        "employeeID" => $request->input('saleperson'),
                        "paymentDescription" => $paymentDescription,
                        "amount" => $amount
                    ]);



                    foreach ($sharedProjectManager as $key => $value) {
                        $c[$key] = [$value, $amountShare[$key]];
                    }

                    foreach ($c as $SecondProjectManagers) {
                        if ($SecondProjectManagers[0] != 0) {
                            $createSharedPersonEmployeePayment  = EmployeePayment::create(
                                [
                                    "paymentID" => $createpayment,
                                    "employeeID" => $SecondProjectManagers[0],
                                    "paymentDescription" => "Remaining(Payment) Amount Share By " . $findusername[0]->name,
                                    "amount" =>  $SecondProjectManagers[1]
                                ]
                            );
                        }
                    }
                } else {

                    $paymentDescription = $findusername[0]->name . " Charge Remaining Payment For Client " . $findclient[0]->name;
                    $clientpaid = $request->input('clientpaid');



                    $createEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $createpayment,
                            "employeeID" => $request->input('saleperson'),
                            "paymentDescription" =>  $paymentDescription,
                            "amount" =>   $clientpaid
                        ]
                    );
                }
            } else {
                $paymentType = $request->input('paymentType');
                $paymentNature = $request->input('paymentNature');
                $findusername = DB::table('employees')->where('id', $request->input('accountmanager'))->get();
                $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
                $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
                $gettingpayment = NewPaymentsClients::where('remainingID', $checkremaining[0]->remainingID)->sum("Paid");
                $checkingtotalremaining = $checkremaining[0]->TotalAmount - $gettingpayment;
                if ($checkingtotalremaining == 0) {
                    $remainingstatus = "Received Remaining";
                } else {
                    $remainingstatus = "Remaining";
                }

                if ($request->file('bankWireUpload') != null) {
                    $bookwire = $request->file('bankWireUpload')->store('Payment');
                } else {
                    $bookwire = "--";
                }

                $changeStatus = NewPaymentsClients::where('id', $request->input('remainingamountfor'))->update([
                    "remainingID"  => $request->input('remainingID'),
                    "remainingStatus"  => $remainingstatus
                ]);



                $transactionType = $request->input('paymentNature');


                // if( $request->input('nextpaymentdate') != null ){

                $createpayment = NewPaymentsClients::insertGetId([
                    "BrandID" => $brandID,
                    "ClientID" => $request->input('clientID'),
                    "ProjectID" => $request->input('project'),
                    "ProjectManager" => $request->input('accountmanager'),
                    "paymentNature" => $request->input('paymentNature'),
                    "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform" => $request->input('platform'),
                    "Card_Brand" => $request->input('cardBrand'),
                    "Payment_Gateway" => $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID" => $request->input('transactionID'),
                    "paymentDate" => $request->input('paymentdate'),
                    // "futureDate"=> $request->input('nextpaymentdate'),
                    "SalesPerson" => $request->input('saleperson'),
                    "TotalAmount" => $request->input('totalamount'),
                    "Paid" => $request->input('clientpaid'),
                    "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType" => $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description" => $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus" => 'On Going',
                    "remainingID" => $request->input('remainingID'),
                    "remainingStatus" => "Remaining Payment",
                    "transactionType" => $transactionType,
                    "transactionfee" =>  $transactionfee,
                    "amt_after_transactionfee" => $request->input('clientpaid') -  $transactionfee,
                    "qaperson" => $userid

                ]);


                if ($paymentType == "Split Payment") {

                    $paymentDescription = $findusername[0]->name . " Charge Remaining Payment For Client " . $findclient[0]->name;
                    $totalamount = $request->input('totalamount');
                    $amountShare = $request->input('splitamount');
                    $sharedProjectManager = $request->input('shareProjectManager');
                    $c = [];
                    $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

                    $createMainEmployeePayment  = EmployeePayment::create([
                        "paymentID" => $createpayment,
                        "employeeID" => $request->input('saleperson'),
                        "paymentDescription" => $paymentDescription,
                        "amount" => $amount
                    ]);



                    foreach ($sharedProjectManager as $key => $value) {
                        $c[$key] = [$value, $amountShare[$key]];
                    }

                    foreach ($c as $SecondProjectManagers) {
                        if ($SecondProjectManagers[0] != 0) {
                            $createSharedPersonEmployeePayment  = EmployeePayment::create(
                                [
                                    "paymentID" => $createpayment,
                                    "employeeID" => $SecondProjectManagers[0],
                                    "paymentDescription" => "Remaining(Payment) Amount Share By " . $findusername[0]->name,
                                    "amount" =>  $SecondProjectManagers[1]
                                ]
                            );
                        }
                    }
                } else {

                    $paymentDescription = $findusername[0]->name . " Charge Remaining Payment For Client " . $findclient[0]->name;
                    $clientpaid = $request->input('clientpaid');



                    $createEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $createpayment,
                            "employeeID" => $request->input('saleperson'),
                            "paymentDescription" =>  $paymentDescription,
                            "amount" =>   $clientpaid
                        ]
                    );
                }
            }
        } else {

            // echo("is  fsremaining");
            // die();
            $checkremaining = NewPaymentsClients::where('id', $request->input('remainingamountfor'))->get();

            if (isset($checkremaining[0]->remainingID) && $checkremaining[0]->remainingID != null) {

                $paymentType = $request->input('paymentType');
                $paymentNature = $request->input('paymentNature');
                $findusername = DB::table('employees')->where('id', $request->input('accountmanager'))->get();
                $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
                $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
                $gettingpayment = NewPaymentsClients::where('remainingID', $checkremaining[0]->remainingID)->sum("Paid");
                $checkingtotalremaining = $checkremaining[0]->TotalAmount - $gettingpayment - $request->input('clientpaid');

                // echo($checkingtotalremaining);
                // die();

                if ($checkingtotalremaining == 0) {
                    $remainingstatus = "Received Remaining";
                } else {
                    $remainingstatus = "Remaining";
                }

                if ($request->file('bankWireUpload') != null) {
                    $bookwire = $request->file('bankWireUpload')->store('Payment');
                } else {
                    $bookwire = "--";
                }

                $changeStatus = NewPaymentsClients::where('id', $request->input('remainingamountfor'))->update([
                    "remainingStatus"  => $remainingstatus
                ]);
                $transactionType = $request->input('paymentNature');


                // if( $request->input('nextpaymentdate') != null ){

                $createpayment = NewPaymentsClients::insertGetId([
                    "BrandID" => $brandID,
                    "ClientID" => $request->input('clientID'),
                    "ProjectID" => $request->input('project'),
                    "ProjectManager" => $request->input('accountmanager'),
                    "paymentNature" => $request->input('paymentNature'),
                    "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform" => $request->input('platform'),
                    "Card_Brand" => $request->input('cardBrand'),
                    "Payment_Gateway" => $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID" => $request->input('transactionID'),
                    "paymentDate" => $request->input('paymentdate'),
                    // "futureDate"=> $request->input('nextpaymentdate'),
                    "SalesPerson" => $request->input('saleperson'),
                    "TotalAmount" => $request->input('totalamount'),
                    "Paid" => $request->input('clientpaid'),
                    "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType" => $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description" => $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus" => 'On Going',
                    "remainingID" => $checkremaining[0]->remainingID,
                    "remainingStatus" =>  "Remaining Payment",
                    "transactionType" => "New Lead",
                    "transactionfee" =>  $transactionfee,
                    "amt_after_transactionfee" => $request->input('clientpaid') -  $transactionfee,
                    "qaperson" => $userid

                ]);


                if ($paymentType == "Split Payment") {

                    $paymentDescription = $findusername[0]->name . " Charge Remaining Payment For Client " . $findclient[0]->name;
                    $totalamount = $request->input('totalamount');
                    $amountShare = $request->input('splitamount');
                    $sharedProjectManager = $request->input('shareProjectManager');
                    $c = [];
                    $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

                    $createMainEmployeePayment  = EmployeePayment::create([
                        "paymentID" => $createpayment,
                        "employeeID" => $request->input('saleperson'),
                        "paymentDescription" => $paymentDescription,
                        "amount" => $amount
                    ]);



                    foreach ($sharedProjectManager as $key => $value) {
                        $c[$key] = [$value, $amountShare[$key]];
                    }

                    foreach ($c as $SecondProjectManagers) {
                        if ($SecondProjectManagers[0] != 0) {
                            $createSharedPersonEmployeePayment  = EmployeePayment::create(
                                [
                                    "paymentID" => $createpayment,
                                    "employeeID" => $SecondProjectManagers[0],
                                    "paymentDescription" => "Remaining(Payment) Amount Share By " . $findusername[0]->name,
                                    "amount" =>  $SecondProjectManagers[1]
                                ]
                            );
                        }
                    }
                } else {

                    $paymentDescription = $findusername[0]->name . " Charge Remaining Payment For Client " . $findclient[0]->name;
                    $clientpaid = $request->input('clientpaid');



                    $createEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $createpayment,
                            "employeeID" => $request->input('saleperson'),
                            "paymentDescription" =>  $paymentDescription,
                            "amount" =>   $clientpaid
                        ]
                    );
                }
            } else {
                $paymentType = $request->input('paymentType');
                $paymentNature = $request->input('paymentNature');
                $findusername = DB::table('employees')->where('id', $request->input('accountmanager'))->get();
                $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
                $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
                $gettingpayment = NewPaymentsClients::where('remainingID', $checkremaining[0]->remainingID)->sum("Paid");
                $checkingtotalremaining = $checkremaining[0]->TotalAmount - $gettingpayment;
                if ($checkingtotalremaining == 0) {
                    $remainingstatus = "Received Remaining";
                } else {
                    $remainingstatus = "Remaining";
                }

                if ($request->file('bankWireUpload') != null) {
                    $bookwire = $request->file('bankWireUpload')->store('Payment');
                } else {
                    $bookwire = "--";
                }

                $changeStatus = NewPaymentsClients::where('id', $request->input('remainingamountfor'))->update([
                    "remainingID"  => $request->input('remainingID'),
                    "remainingStatus"  => $remainingstatus
                ]);



                $transactionType = $request->input('paymentNature');


                // if( $request->input('nextpaymentdate') != null ){

                $createpayment = NewPaymentsClients::insertGetId([
                    "BrandID" => $brandID,
                    "ClientID" => $request->input('clientID'),
                    "ProjectID" => $request->input('project'),
                    "ProjectManager" => $request->input('accountmanager'),
                    "paymentNature" => $request->input('paymentNature'),
                    "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform" => $request->input('platform'),
                    "Card_Brand" => $request->input('cardBrand'),
                    "Payment_Gateway" => $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID" => $request->input('transactionID'),
                    "paymentDate" => $request->input('paymentdate'),
                    // "futureDate"=> $request->input('nextpaymentdate'),
                    "SalesPerson" => $request->input('saleperson'),
                    "TotalAmount" => $request->input('totalamount'),
                    "Paid" => $request->input('clientpaid'),
                    "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType" => $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description" => $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus" => 'On Going',
                    "remainingID" => $request->input('remainingID'),
                    "remainingStatus" => "Remaining Payment",
                    "transactionType" => "New Lead",
                    "transactionfee" =>  $transactionfee,
                    "amt_after_transactionfee" => $request->input('clientpaid') -  $transactionfee,
                    "qaperson" => $userid

                ]);


                if ($paymentType == "Split Payment") {

                    $paymentDescription = $findusername[0]->name . " Charge Remaining Payment For Client " . $findclient[0]->name;
                    $totalamount = $request->input('totalamount');
                    $amountShare = $request->input('splitamount');
                    $sharedProjectManager = $request->input('shareProjectManager');
                    $c = [];
                    $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

                    $createMainEmployeePayment  = EmployeePayment::create([
                        "paymentID" => $createpayment,
                        "employeeID" => $request->input('saleperson'),
                        "paymentDescription" => $paymentDescription,
                        "amount" => $amount
                    ]);



                    foreach ($sharedProjectManager as $key => $value) {
                        $c[$key] = [$value, $amountShare[$key]];
                    }

                    foreach ($c as $SecondProjectManagers) {
                        if ($SecondProjectManagers[0] != 0) {
                            $createSharedPersonEmployeePayment  = EmployeePayment::create(
                                [
                                    "paymentID" => $createpayment,
                                    "employeeID" => $SecondProjectManagers[0],
                                    "paymentDescription" => "Remaining(Payment) Amount Share By " . $findusername[0]->name,
                                    "amount" =>  $SecondProjectManagers[1]
                                ]
                            );
                        }
                    }
                } else {

                    $paymentDescription = $findusername[0]->name . " Charge Remaining Payment For Client " . $findclient[0]->name;
                    $clientpaid = $request->input('clientpaid');



                    $createEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $createpayment,
                            "employeeID" => $request->input('saleperson'),
                            "paymentDescription" =>  $paymentDescription,
                            "amount" =>   $clientpaid
                        ]
                    );
                }
            }
        }

        return redirect('/client/details/' . $request->input('clientID'));
    }



    function payment_Refund(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $project = Project::where('id', $id)->get();
        $client = Client::where('id', $project[0]->clientID)->get();
        $client_payment = NewPaymentsClients::where('ClientID', $project[0]->clientID)
            ->where('ProjectID', $id)
            ->where('refundStatus', '!=', 'Pending Payment')
            ->get();
        $pmdepartment = Department::where('brand', $client[0]->brand)->where(function ($query) {
            $query->where('name', 'LIKE', '%Project manager')
                ->orWhere('name', 'LIKE', 'Project manager%')
                ->orWhere('name', 'LIKE', '%Project manager%');
        })->get();
        $pmemployee = Employee::whereIn('id', json_decode($pmdepartment[0]->users))->get();
        $saledepartment = Department::where('brand', $client[0]->brand)->where(function ($query) {
            $query->where('name', 'LIKE', '%sale')
                ->orWhere('name', 'LIKE', 'sale%')
                ->orWhere('name', 'LIKE', '%sale%');
        })->get();
        $saleemployee = Employee::whereIn('id', json_decode($saledepartment[0]->users))->get();
        $employee  = Employee::get();
        return view('payment_Refund', [
            'project' => $project,
            'client_payment' => $client_payment,
            'pmdepartment' => $pmdepartment,
            'pmemployee' => $employee,
            'saledepartment' => $saledepartment,
            'saleemployee' => $employee,
            'employee' => $employee,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }
    public function fetchPaymentdata(Request $request)
    {
        $data['paymentdata'] = NewPaymentsClients::where("id", $request->payment_id)->get();

        $platform = $data['paymentdata'][0]->Platform;
        $cardbrand = $data['paymentdata'][0]->Card_Brand;
        $paymentgateway = $data['paymentdata'][0]->Payment_Gateway;
        $saleperson = $data['paymentdata'][0]->saleEmployeesName->name;
        $salepersonID = $data['paymentdata'][0]->saleEmployeesName->id;
        $projectmanager = $data['paymentdata'][0]->pmEmployeesName->name;
        $projectmanagerID = $data['paymentdata'][0]->pmEmployeesName->id;
        $totalamt = $data['paymentdata'][0]->TotalAmount;
        $clientpaid = $data['paymentdata'][0]->Paid;
        $paymenttype = $data['paymentdata'][0]->PaymentType;
        $numberofSplits = $data['paymentdata'][0]->numberOfSplits;
        $splitmanagers = json_decode($data['paymentdata'][0]->SplitProjectManager);
        $splitamounts = json_decode($data['paymentdata'][0]->ShareAmount);
        $description = $data['paymentdata'][0]->Description;

        $return_array = [
            "platform" => $platform,
            "cardbrand" => $cardbrand,
            "paymentgateway" => $paymentgateway,
            "saleperson" => $saleperson,
            "salepersonID" => $salepersonID,
            "projectmanager" => $projectmanager,
            "projectmanagerID" => $projectmanagerID,
            "totalamt" => $totalamt,
            "clientpaid" => $clientpaid,
            "paymenttype" => $paymenttype,
            "numberofSplits" => $numberofSplits,
            "splitmanagers" => $splitmanagers,
            "splitamounts" => $splitamounts,
            "description" => $description
        ];

        return response()->json($return_array);
    }
    function payment_Refund_Process(Request $request)
    {
        $referencepayment = NewPaymentsClients::where('id', $request->input('paymentreference'))->get();
        $originalpayment = NewPaymentsClients::where('id', $request->input('paymentreference'))->update([
            "refundID" => $request->input('refundID')
        ]);

        if ($request->file('bankWireUpload') != null) {
            $bookwire = $request->file('bankWireUpload')->store('Payment');
        } else {
            $bookwire = "--";
        }

        $originalrefund = NewPaymentsClients::insertGetId([
            "BrandID" => $request->input('brandID'),
            "ClientID" => $request->input('clientID'),
            "ProjectID" => $request->input('projectID'),
            "ProjectManager" => $request->input('saleperson'),
            "paymentNature" => $referencepayment[0]->paymentNature,
            "ChargingPlan" => $referencepayment[0]->ChargingPlan,
            "ChargingMode" => $referencepayment[0]->ChargingMode,
            "Platform" => $request->input('platform'),
            "Card_Brand" => $request->input('cardBrand'),
            "Payment_Gateway" => $request->input('paymentgateway'),
            "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
            "TransactionID" => $request->input('transactionID'),
            "paymentDate" => $request->input('paymentdate'),
            "SalesPerson" => $referencepayment[0]->SalesPerson,
            "TotalAmount" => $request->input('totalamount'),
            "Paid" => $request->input('clientpaid'),
            "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
            "PaymentType" => $referencepayment[0]->PaymentType,
            "numberOfSplits" => $referencepayment[0]->numberOfSplits,
            "SplitProjectManager" => $referencepayment[0]->SplitProjectManager,
            "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
            "Description" => $request->input('description'),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s'),
            "refundStatus" => 'Refund',
            "refundID" => $request->input('refundID'),
            "remainingStatus" => 0,
            "transactionType" =>  $referencepayment[0]->transactionType,
            "transactionfee" => $request->input('transactionfee'),
            "amt_after_transactionfee" => $request->input('clientpaid') + $request->input('transactionfee')

        ]);

        $payment_in_refund_table = RefundPayments::create([
            "BrandID" =>  $request->input('brandID'),
            "ClientID" =>  $request->input('clientID'),
            "ProjectID" => $request->input('projectID'),
            'ProjectManager' => $request->input('saleperson'),
            'PaymentID' => $originalrefund,
            'basicAmount' =>  $request->input('totalamount'),
            "refundAmount" => $request->input('clientpaid'),
            "refundtype" => $request->input('chargebacktype'),
            "refund_date" => $request->input('paymentdate'),
            "refundReason" =>  $request->input('description'),
            "clientpaid" =>   $referencepayment[0]->Paid,
            "paymentType" =>   $referencepayment[0]->PaymentType,
            "splitmanagers" =>   $referencepayment[0]->SplitProjectManager,
            "splitamounts" =>  $referencepayment[0]->ShareAmount,
            "splitRefunds" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
            "transactionfee" => $request->input('transactionfee'),
            "amt_after_transactionfee" => $request->input('clientpaid') + $request->input('transactionfee')


        ]);

        if ($referencepayment[0]->PaymentType == "Split Payment") {
            $paymentDescription = $request->input('saleperson') . " Refund Payment For Client " . $request->input('clientID');
            $totalamount = $request->input('totalamount');
            $amountShare = $request->input('splitamount');
            $sharedProjectManager = $request->input('shareProjectManager');
            $c = [];
            $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

            $createMainEmployeePayment  = EmployeePayment::create([
                "paymentID" => $originalrefund,
                "employeeID" => $request->input('saleperson'),
                "paymentDescription" => $paymentDescription,
                "amount" => $amount
            ]);



            foreach ($sharedProjectManager as $key => $value) {
                $c[$key] = [$value, $amountShare[$key]];
            }

            foreach ($c as $SecondProjectManagers) {
                if ($SecondProjectManagers[0] != 0) {
                    $createSharedPersonEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $originalrefund,
                            "employeeID" => $SecondProjectManagers[0],
                            "paymentDescription" => "refund Share By " . $request->input('saleperson'),
                            "amount" =>  $SecondProjectManagers[1]
                        ]
                    );
                }
            }
        } else {

            $paymentDescription = $request->input('saleperson') . " Refund Payment For Client " . $request->input('clientID');
            $clientpaid = $request->input('clientpaid');



            $createEmployeePayment  = EmployeePayment::create(
                [
                    "paymentID" => $originalrefund,
                    "employeeID" => $request->input('saleperson'),
                    "paymentDescription" =>  $paymentDescription,
                    "amount" =>   $clientpaid
                ]
            );
        }

        return redirect('/client/project/payment/all');
    }



    function payment_Dispute(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $client_payment = NewPaymentsClients::where('id', $id)->get();
        $related_payment = NewPaymentsClients::where('ClientID', $client_payment[0]->ClientID)->where('ProjectID', $client_payment[0]->ProjectID)->where('id', '!=', $id)->where('transactionType', $client_payment[0]->transactionType)->get();
        $remaining_payment = NewPaymentsClients::where('ClientID', $client_payment[0]->ClientID)->where('ProjectID', $client_payment[0]->ProjectID)->where('id', '!=', $id)->where('remainingID', $client_payment[0]->remainingID)->get();
        $employee  = Employee::get();
        $findemployee = Employee::get();
        return view('payment_Dispute', [
            'id' => $id,
            'client_payment' => $client_payment,
            'related_payment' => $related_payment,
            'remaining_payment' => $remaining_payment,
            'employee' => $employee,
            'pmemployee' => $findemployee,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }
    function payment_Dispute_Process(Request $request)
    {
        $referencepayment = NewPaymentsClients::where('id', $request->input('paymentID'))->get();

        $originalpayment = NewPaymentsClients::where('id', $request->input('paymentID'))->update([
            "ProjectManager" => $request->input('accountmanager'),
            "dispute" => "dispute",
            "disputeattack" => $request->input('disputedate'),
            "disputeattackamount" => $request->input('clientpaid'),
        ]);


        $payment_in_refund_table = Disputedpayments::create([
            "BrandID" =>  $request->input('brandID'),
            "ClientID" =>  $request->input('clientID'),
            "ProjectID" => $request->input('projectID'),
            "ProjectManager" => $request->input('accountmanager'),
            "PaymentID" => $request->input('paymentID'),
            "dispute_Date" => $request->input('disputedate'),
            "disputedAmount" => $request->input('clientpaid'),
            "disputeReason" => $request->input('description'),
            "disputefee" => $request->input('disputefee'),
            "amt_after_disputefee" => $request->input('clientpaid') + $request->input('disputefee'),

        ]);

        return redirect('/client/project/payment/all');
    }



    function all_disputes(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $client_payment = Disputedpayments::get();

        return view('all_disputes', [
            'clientPayments' => $client_payment,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }



    function payment_Dispute_lost(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $dispute = Disputedpayments::where('id', $id)->get();
        $projects = Project::get();
        $referencepayment = NewPaymentsClients::where('remainingStatus', '!=', 'Unlinked Payments')->get();
        $employee = Employee::get();
        return view('payment_Dispute_lost', [
            'dispute' => $dispute,
            'projects' => $projects,
            'referencepayment' => $referencepayment,
            'employee' => $employee,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }
    function payment_Dispute_Process_lost(Request $request)
    {
        $loginUser = $this->roleExits($request);

        if($loginUser[2] == 0){
            $userid = 0;
        }else{
            $qaPerson = $request->session()->get('AdminUser');
            $userid = $qaPerson[0]->id;
        }

        $referencepayment = NewPaymentsClients::where('id', $request->input('mainpayment'))->get();
        $disputetogetfee = Disputedpayments::where('id', $request->input('disputeID'))->get();
        $Disputedpayments = Disputedpayments::where('id', $request->input('disputeID'))->update([
            "disputeStatus" => "Lost",
        ]);

        $originalpayment = NewPaymentsClients::where('id', $request->input('mainpayment'))->update([
            "refundID" => $request->input('refundID')
        ]);

        if ($request->file('bankWireUpload') != null) {
            $bookwire = $request->file('bankWireUpload')->store('Payment');
        } else {
            $bookwire = "--";
        }

        $originalrefund = NewPaymentsClients::insertGetId([
            "BrandID" => $request->input('brandID'),
            "ClientID" => $request->input('clientID'),
            "ProjectID" => $request->input('projectID'),
            "ProjectManager" => $request->input('accountmanager'),
            "paymentNature" => $request->input('paymentNature'),
            "ChargingPlan" => $referencepayment[0]->ChargingPlan,
            "ChargingMode" => $referencepayment[0]->ChargingMode,
            "Platform" => $referencepayment[0]->Platform,
            "Card_Brand" => $referencepayment[0]->Card_Brand,
            "Payment_Gateway" => $referencepayment[0]->Payment_Gateway,
            "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
            "TransactionID" => $referencepayment[0]->TransactionID . "(Refund)",
            "paymentDate" => $request->input('paymentdate'),
            "SalesPerson" => $referencepayment[0]->SalesPerson,
            "TotalAmount" => $referencepayment[0]->TotalAmount,
            "Paid" => $referencepayment[0]->Paid,
            "RemainingAmount" => 0,
            "PaymentType" => $referencepayment[0]->PaymentType,
            "numberOfSplits" => $referencepayment[0]->numberOfSplits,
            "SplitProjectManager" => $referencepayment[0]->SplitProjectManager,
            "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('refundamount')),
            "Description" => $request->input('Description_of_issue'),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s'),
            "refundStatus" => 'Refund',
            "refundID" => $request->input('refundID'),
            "remainingStatus" => "Dispute Lost",
            "transactionType" =>  $referencepayment[0]->transactionType,
            "transactionfee" => $referencepayment[0]->transactionfee,
            "amt_after_transactionfee" => $referencepayment[0]->Paid,
            "disputefee" => $disputetogetfee[0]->disputefee,
            "dispute" => "dispute",
            "amt_after_disputefee" => $referencepayment[0]->Paid + $disputetogetfee[0]->disputefee,
            "qaperson" => $userid

        ]);

        $payment_in_refund_table = RefundPayments::create([
            "BrandID" =>  $request->input('brandID'),
            "ClientID" =>  $request->input('clientID'),
            "ProjectID" => $referencepayment[0]->ProjectID,
            'ProjectManager' => $request->input('accountmanager'),
            'PaymentID' => $originalrefund,
            'basicAmount' =>  $referencepayment[0]->TotalAmount,
            "refundAmount" => $request->input('chagebackAmt'),
            "refundtype" => $request->input('chargebacktype'),
            "refund_date" => $request->input('chagebackDate'),
            "refundReason" =>  $request->input('Description_of_issue'),
            "clientpaid" =>   $referencepayment[0]->Paid,
            "paymentType" =>   $referencepayment[0]->PaymentType,
            "splitmanagers" =>   $referencepayment[0]->SplitProjectManager,
            "splitamounts" =>  $referencepayment[0]->ShareAmount,
            "splitRefunds" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('refundamount')),

        ]);


        if ($referencepayment[0]->PaymentType == "Split Payment") {
            $paymentDescription = $request->input('saleperson') . " Refund Payment For Client " . $request->input('clientID');
            $totalamount = $request->input('totalamount');
            $amountShare = $request->input('splitamount');
            $sharedProjectManager = $request->input('shareProjectManager');
            $c = [];
            $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

            $createMainEmployeePayment  = EmployeePayment::create([
                "paymentID" => $originalrefund,
                "employeeID" => $request->input('saleperson'),
                "paymentDescription" => $paymentDescription,
                "amount" => $amount
            ]);



            foreach ($sharedProjectManager as $key => $value) {
                $c[$key] = [$value, $amountShare[$key]];
            }

            foreach ($c as $SecondProjectManagers) {
                if ($SecondProjectManagers[0] != 0) {
                    $createSharedPersonEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $originalrefund,
                            "employeeID" => $SecondProjectManagers[0],
                            "paymentDescription" => "Refund Share By " . $request->input('saleperson'),
                            "amount" =>  $SecondProjectManagers[1]
                        ]
                    );
                }
            }
        } else {

            $paymentDescription = $request->input('saleperson') . " Refund Payment For Client " . $request->input('clientID');
            $clientpaid = $request->input('chagebackAmt');



            $createEmployeePayment  = EmployeePayment::create(
                [
                    "paymentID" => $originalrefund,
                    "employeeID" => $request->input('saleperson'),
                    "paymentDescription" =>  $paymentDescription,
                    "amount" =>   $clientpaid
                ]
            );
        }


        return redirect('/client/project/payment/all');
    }



    function payment_Dispute_won(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $dispute = Disputedpayments::where('id', $id)->get();
        $projects = Project::get();
        $referencepayment = NewPaymentsClients::where('remainingStatus', '!=', 'Unlinked Payments')->get();
        $employee = Employee::get();
        return view('payment_Dispute_won', [
            'dispute' => $dispute,
            'projects' => $projects,
            'referencepayment' => $referencepayment,
            'employee' => $employee,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }
    function payment_Dispute_Process_won(Request $request)
    {
        $loginUser = $this->roleExits($request);

        if($loginUser[2] == 0){
            $userid = 0;
        }else{
            $qaPerson = $request->session()->get('AdminUser');
            $userid = $qaPerson[0]->id;
        }

        $referencepayment = NewPaymentsClients::where('id', $request->input('mainpayment'))->get();
        $Disputedpayments = Disputedpayments::where('id', $request->input('disputeID'))->update([
            "disputeStatus" => "Won"
        ]);

        if ($request->file('bankWireUpload') != null) {
            $bookwire = $request->file('bankWireUpload')->store('Payment');
        } else {
            $bookwire = "--";
        }


        $createpayment = NewPaymentsClients::insertGetId([
            "BrandID" => $referencepayment[0]->BrandID,
            "ClientID" => $referencepayment[0]->ClientID,
            "ProjectID" => $referencepayment[0]->ProjectID,
            "ProjectManager" => $referencepayment[0]->ProjectManager,
            "paymentNature" => $request->input('paymentNature'),
            "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
            "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
            "Platform" => $referencepayment[0]->Platform,
            "Card_Brand" => $referencepayment[0]->Card_Brand,
            "Payment_Gateway" => $referencepayment[0]->Payment_Gateway,
            "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
            "TransactionID" => $referencepayment[0]->TransactionID . "(Dispute Won)",
            "paymentDate" => $request->input('paymentdate'),
            "SalesPerson" => $referencepayment[0]->ProjectManager,
            "TotalAmount" => $referencepayment[0]->TotalAmount,
            "Paid" => $referencepayment[0]->Paid,
            "RemainingAmount" => 0,
            "PaymentType" => $referencepayment[0]->PaymentType,
            "numberOfSplits" => $referencepayment[0]->numberOfSplits,
            "SplitProjectManager" => $referencepayment[0]->SplitProjectManager,
            "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('newamount')),
            "Description" => $request->input('description'),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s'),
            "refundStatus" => 'On Going',
            "remainingStatus" => "Dispute Won",
            "transactionType" => $referencepayment[0]->transactionType,
            "transactionfee" => $referencepayment[0]->transactionfee,
            "amt_after_transactionfee" => $request->input('wonamount') - $referencepayment[0]->transactionfee,
            "qaperson" => $userid
            // "disputefee" => 0,
            // "amt_after_disputefee" => $request->input('wonamount') - $referencepayment[0]->transactionfee,
        ]);

        if ($referencepayment[0]->PaymentType == "Split Payment") {
            $paymentDescription = $request->input('saleperson') . " Charge Payment For Client " . $request->input('clientID');
            $totalamount = $request->input('wonamount');
            $amountShare = $request->input('newamount');
            $sharedProjectManager = $request->input('shareProjectManager');
            $c = [];
            $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

            $createMainEmployeePayment  = EmployeePayment::create([
                "paymentID" => $createpayment,
                "employeeID" => $referencepayment[0]->ProjectManager,
                "paymentDescription" => $paymentDescription,
                "amount" => $amount
            ]);



            foreach ($sharedProjectManager as $key => $value) {
                $c[$key] = [$value, $amountShare[$key]];
            }

            foreach ($c as $SecondProjectManagers) {
                if ($SecondProjectManagers[0] != 0) {
                    $createSharedPersonEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $createpayment,
                            "employeeID" => $SecondProjectManagers[0],
                            "paymentDescription" => "Amount Share By " . $request->input('saleperson'),
                            "amount" =>  $SecondProjectManagers[1]
                        ]
                    );
                }
            }
        } else {

            $paymentDescription = $request->input('saleperson') . " Charge Payment For Client " . $request->input('clientID');
            $clientpaid = $request->input('clientpaid');



            $createEmployeePayment  = EmployeePayment::create(
                [
                    "paymentID" => $createpayment,
                    "employeeID" => $referencepayment[0]->SalesPerson,
                    "paymentDescription" =>  $paymentDescription,
                    "amount" =>   $referencepayment[0]->TotalAmount
                ]
            );
        }

        return redirect('/client/project/payment/all');
    }



    function projectpayment_view_dispute($id, Request $request)
    {
        $loginUser = $this->roleExits($request);
        $dispute = Disputedpayments::where('id', $id)->get();
        // echo("<pre>");
        // print_r($dispute);
        // die();
        return view('disputeView', [
            'dispute' => $dispute,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }


    function payment_edit_amount(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $brand = Brand::get();
        $editPayment = NewPaymentsClients::where('id', $id)->get();
        $findclientofproject = Client::where('id', $editPayment[0]->ClientID)->get();
        // $pmdepartment = Department::where('brand', $findclientofproject[0]->brand)->where(function ($query) {
        //     $query->where('name', 'LIKE', '%Project manager')
        //         ->orWhere('name', 'LIKE', 'Project manager%')
        //         ->orWhere('name', 'LIKE', '%Project manager%');
        // })->get();
        // $pmemployee = Employee::whereIn('id', json_decode($pmdepartment[0]->users))->get();
        // $saledepartment = Department::where('brand', $findclientofproject[0]->brand)->where(function ($query) {
        //     $query->where('name', 'LIKE', '%sale')
        //         ->orWhere('name', 'LIKE', 'sale%')
        //         ->orWhere('name', 'LIKE', '%sale%');
        // })->get();
        // $saleemployee = Employee::whereIn('id', json_decode($saledepartment[0]->users))->get();
        if ($editPayment[0]->remainingStatus != 'Unlinked Payments') {
            $findclient = Client::get();
            $findemployee = Employee::get();
            $allPayments = NewPaymentsClients::where('ClientID', $editPayment[0]->ClientID)
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->get();

            return view('edit_payment', [
                'allPayments' => $allPayments,
                'editPayments' => $editPayment,
                'clients' => $findclient,
                'brand' => $brand,
                'employee' => $findemployee,
                'pmemployee' => $findemployee,
                'saleemployee' => $findemployee,
                'LoginUser' => $loginUser[1],
                'departmentAccess' => $loginUser[0],
                'superUser' => $loginUser[2]
            ]);
        } else {

            $findproject = Project::where('clientID', $editPayment[0]->ClientID)->get();
            $findclientofproject = Client::where('id', $editPayment[0]->ClientID)->get();
            $findclient = Client::get();
            $findemployee = Employee::get();
            $allPayments = NewPaymentsClients::where('ClientID', $editPayment[0]->ClientID)
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->get();
            $remainingpayments = NewPaymentsClients::where('ClientID', $findproject[0]->ClientName->id)
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('remainingStatus', 'Remaining')
                ->get();
            $remainingpaymentcount = count($remainingpayments);
            $referencepayment = NewPaymentsClients::where('ClientID', $editPayment[0]->ClientID)
                ->where('refundStatus', '!=', 'Pending Payment')
                ->where('remainingStatus', '!=', 'Unlinked Payments')
                ->get();


            return view('paymentFromunlinked', [
                'allPayments' => $allPayments,
                'editPayments' => $editPayment,
                'id' => $id,
                'brand' => $brand,
                'projectmanager' => $findproject,
                'findclientofproject' => $findclientofproject,
                'clients' => $findclient,
                'employee' => $findemployee,
                'pmemployee' => $findemployee,
                'saleemployee' => $findemployee,
                'remainingpayments' => $remainingpayments,
                'remainingpaymentcount' => $remainingpaymentcount,
                'referencepayment' => $referencepayment,
                'LoginUser' => $loginUser[1],
                'departmentAccess' => $loginUser[0],
                'superUser' => $loginUser[2]
            ]);
        }
    }
    function payment_edit_amount_process(Request $request, $id)
    {
        $paymentType = $request->input('paymentType');
        $paymentNature = $request->input('paymentNature');
        $allPayments = NewPaymentsClients::where('id', $id)->get();
        $findusername = DB::table('employees')->where('id', $request->input('accountmanager'))->get();
        $findclient = DB::table('clients')->where('id', $allPayments[0]->ClientID)->get();

        $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
        if ($remainingamt == 0) {
            $remainingstatus = "Not Remaining";
        } else {
            $remainingstatus = "Remaining";
        }

        $upsellCount = NewPaymentsClients::where('ClientID', $request->input('clientID'))->where('paymentNature', 'Upsell')->count();
        if ($request->input('paymentNature') == 'Upsell') {
            if ($upsellCount == 0) {
                $transactionType = $request->input('paymentNature');
            } else {
                $transactionType = $request->input('paymentNature') . "(" . $upsellCount . ")";
            }
        } else {
            $transactionType = $request->input('paymentNature');
        }

        if ($request->file('bankWireUpload') != null) {
            $bookwire = $request->file('bankWireUpload')->store('Payment');
        } else {
            $bookwire = "--";
        }

        if ($request->hasFile('bankWireUpload')) {
            if ($allPayments[0]->bankWireUpload != "--") {
                $path = storage_path('app/' . $allPayments[0]->bankWireUpload);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
        };

        if ($allPayments[0]->bankWireUpload == $request->input('paymentNature')) {
            if (($allPayments[0]->futureDate == $request->input('nextpaymentdate')) || $request->input('nextpaymentdate') == null) {
                $Payments = NewPaymentsClients::where('id', $id)
                    ->update([
                        "BrandID" => $request->input('brandID'),
                        "ProjectManager" => $request->input('accountmanager'),
                        "paymentNature" => $request->input('paymentNature'),
                        "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                        "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                        "Platform" => $request->input('platform'),
                        "Card_Brand" => $request->input('cardBrand'),
                        "Payment_Gateway" => $request->input('paymentgateway'),
                        "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                        "TransactionID" => $request->input('transactionID'),
                        "paymentDate" => $request->input('paymentdate'),
                        "SalesPerson" => $request->input('saleperson'),
                        "TotalAmount" => $request->input('totalamount'),
                        "Paid" => $request->input('clientpaid'),
                        "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                        "PaymentType" => $request->input('paymentType'),
                        "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                        "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                        "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                        "Description" => $request->input('description'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus" => 'On Going',
                        "remainingStatus" => $remainingstatus,
                        "transactionfee" => $request->input('transactionfee'),
                        "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')
                    ]);
            } else {

                $Payments = NewPaymentsClients::where('id', $id)
                    ->update([
                        "BrandID" => $request->input('brandID'),
                        "ProjectManager" => $request->input('accountmanager'),
                        "paymentNature" => $request->input('paymentNature'),
                        "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                        "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                        "Platform" => $request->input('platform'),
                        "Card_Brand" => $request->input('cardBrand'),
                        "Payment_Gateway" => $request->input('paymentgateway'),
                        "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                        "TransactionID" => $request->input('transactionID'),
                        "paymentDate" => $request->input('paymentdate'),
                        "futureDate" => $request->input('nextpaymentdate'),
                        "SalesPerson" => $request->input('saleperson'),
                        "TotalAmount" => $request->input('totalamount'),
                        "Paid" => $request->input('clientpaid'),
                        "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                        "PaymentType" => $request->input('paymentType'),
                        "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                        "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                        "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                        "Description" => $request->input('description'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus" => 'On Going',
                        "remainingStatus" => $remainingstatus,
                        "transactionfee" => $request->input('transactionfee'),
                        "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')
                    ]);
                $deletePendingpayments = NewPaymentsClients::where('transactionType', $allPayments[0]->transactionType)->where('paymentDate', null)->delete();

                if ($request->input('nextpaymentdate') != null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment") {
                    if ($request->input('paymentModes') == 'Renewal') {
                        $paymentNature = "Renewal Payment";
                    } else {
                        $paymentNature = "Recurring Payment";
                    }

                    $interval = $request->input('ChargingPlan');
                    $today = $request->input('nextpaymentdate');

                    for ($i = 1; $i <= 10; $i++) {
                        if ($interval == "One Time Payment") {
                            $datefinal = null;
                        } elseif ($interval == "Monthly") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) . ' month', strtotime($today)));
                        } elseif ($interval == "2 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' month', strtotime($today)));
                        } elseif ($interval == "3 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' month', strtotime($today)));
                        } elseif ($interval == "4 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                        } elseif ($interval == "5 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                        } elseif ($interval == "6 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                        } elseif ($interval == "7 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                        } elseif ($interval == "8 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                        } elseif ($interval == "9 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                        } elseif ($interval == "10 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                        } elseif ($interval == "11 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                        } elseif ($interval == "12 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                        } elseif ($interval == "2 Years") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                        } elseif ($interval == "3 Years") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                        }
                        // echo $datefinal . "<br>";



                        $futurePayment = NewPaymentsClients::create([
                            "BrandID" => $request->input('brandID'),
                            "ClientID" => $request->input('clientID'),
                            "ProjectID" => $request->input('project'),
                            "ProjectManager" => $request->input('accountmanager'),
                            "paymentNature" =>  $paymentNature,
                            "ChargingPlan" => '--',
                            "ChargingMode" => '--',
                            "Platform" => '--',
                            "Card_Brand" => '--',
                            "Payment_Gateway" => '--',
                            "bankWireUpload" => '--',
                            "TransactionID" => '--',
                            // "paymentDate"=> $request->input('paymentdate'),
                            "futureDate" => $datefinal,
                            "SalesPerson" => $request->input('saleperson'),
                            "TotalAmount" => $request->input('totalamount'),
                            "Paid" => 0,
                            "RemainingAmount" => 0,
                            "PaymentType" => '--',
                            "numberOfSplits" => '--',
                            "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                            "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                            "Description" => '--',
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'Pending Payment',
                            "remainingStatus" => '--',
                            "transactionType" => $allPayments[0]->transactionType,
                            "transactionfee" => $request->input('transactionfee'),
                            "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                        ]);
                    }
                }
            }
        } else {
            if ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "New Sale") {
                if ($allPayments[0]->paymentNature == "New Lead" || $allPayments[0]->paymentNature == "New Sale" || $allPayments[0]->paymentNature == "New Sale") {
                    $deletePendingpayments = NewPaymentsClients::where('transactionType', $allPayments[0]->transactionType)->where('paymentDate', null)->delete();
                    if ($request->input('nextpaymentdate') != null) {
                        $Payments = NewPaymentsClients::where('id', $id)
                            ->update([
                                "BrandID" => $request->input('brandID'),
                                "ProjectManager" => $request->input('accountmanager'),
                                "paymentNature" => $request->input('paymentNature'),
                                "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                                "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                                "Platform" => $request->input('platform'),
                                "Card_Brand" => $request->input('cardBrand'),
                                "Payment_Gateway" => $request->input('paymentgateway'),
                                "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                                "TransactionID" => $request->input('transactionID'),
                                "paymentDate" => $request->input('paymentdate'),
                                "futureDate" => $request->input('nextpaymentdate'),
                                "SalesPerson" => $request->input('saleperson'),
                                "TotalAmount" => $request->input('totalamount'),
                                "Paid" => $request->input('clientpaid'),
                                "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                                "PaymentType" => $request->input('paymentType'),
                                "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                                "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                                "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                                "Description" => $request->input('description'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                "remainingStatus" => $remainingstatus,
                                "transactionfee" => $request->input('transactionfee'),
                                "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')
                            ]);

                        if ($request->input('nextpaymentdate') == null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment") {
                            if ($request->input('paymentModes') == 'Renewal') {
                                $paymentNature = "Renewal Payment";
                            } else {
                                $paymentNature = "Recurring Payment";
                            }

                            $interval = $request->input('ChargingPlan');
                            $today = $request->input('nextpaymentdate');

                            for ($i = 1; $i <= 10; $i++) {
                                if ($interval == "One Time Payment") {
                                    $datefinal = null;
                                } elseif ($interval == "Monthly") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) . ' month', strtotime($today)));
                                } elseif ($interval == "2 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' month', strtotime($today)));
                                } elseif ($interval == "3 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' month', strtotime($today)));
                                } elseif ($interval == "4 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                                } elseif ($interval == "5 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                                } elseif ($interval == "6 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                                } elseif ($interval == "7 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                                } elseif ($interval == "8 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                                } elseif ($interval == "9 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                                } elseif ($interval == "10 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                                } elseif ($interval == "11 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                                } elseif ($interval == "12 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                                } elseif ($interval == "2 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                                } elseif ($interval == "3 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                                }
                                // echo $datefinal . "<br>";



                                $futurePayment = NewPaymentsClients::create([
                                    "BrandID" => $request->input('brandID'),
                                    "ClientID" => $request->input('clientID'),
                                    "ProjectID" => $request->input('project'),
                                    "ProjectManager" => $request->input('accountmanager'),
                                    "paymentNature" =>  $paymentNature,
                                    "ChargingPlan" => '--',
                                    "ChargingMode" => '--',
                                    "Platform" => '--',
                                    "Card_Brand" => '--',
                                    "Payment_Gateway" => '--',
                                    "bankWireUpload" => '--',
                                    "TransactionID" => '--',
                                    // "paymentDate"=> $request->input('paymentdate'),
                                    "futureDate" => $datefinal,
                                    "SalesPerson" => $request->input('saleperson'),
                                    "TotalAmount" => $request->input('totalamount'),
                                    "Paid" => 0,
                                    "RemainingAmount" => 0,
                                    "PaymentType" => '--',
                                    "numberOfSplits" => '--',
                                    "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                                    "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                                    "Description" => '--',
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus" => 'Pending Payment',
                                    "remainingStatus" => '--',
                                    "transactionType" => $allPayments[0]->transactionType,
                                    "transactionfee" => $request->input('transactionfee'),
                                    "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                                ]);
                            }
                        }
                    } else {
                        $today = date('Y-m-d');
                        if ($request->input('ChargingPlan') == "One Time Payment") {
                            $date = null;
                        } elseif ($request->input('ChargingPlan') == "Monthly") {
                            $date = date('Y-m-d', strtotime('+1 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "2 Months") {
                            $date = date('Y-m-d', strtotime('+2 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "3 Months") {
                            $date = date('Y-m-d', strtotime('+3 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "4 Months") {
                            $date = date('Y-m-d', strtotime('+4 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "5 Months") {
                            $date = date('Y-m-d', strtotime('+5 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "6 Months") {
                            $date = date('Y-m-d', strtotime('+6 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "7 Months") {
                            $date = date('Y-m-d', strtotime('+7 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "8 Months") {
                            $date = date('Y-m-d', strtotime('+8 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "9 Months") {
                            $date = date('Y-m-d', strtotime('+9 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "10 Months") {
                            $date = date('Y-m-d', strtotime('+10 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "11 Months") {
                            $date = date('Y-m-d', strtotime('+11 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "12 Months") {
                            $date = date('Y-m-d', strtotime('+1 Year', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "2 Years") {
                            $date = date('Y-m-d', strtotime('+2 Year', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "3 Years") {
                            $date = date('Y-m-d', strtotime('+3 Year', strtotime($today)));
                        }


                        $Payments = NewPaymentsClients::where('id', $id)
                            ->update([
                                "BrandID" => $request->input('brandID'),
                                "ClientID" => $request->input('clientID'),
                                "ProjectID" => $request->input('project'),
                                "ProjectManager" => $request->input('accountmanager'),
                                "paymentNature" => $request->input('paymentNature'),
                                "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                                "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                                "Platform" => $request->input('platform'),
                                "Card_Brand" => $request->input('cardBrand'),
                                "Payment_Gateway" => $request->input('paymentgateway'),
                                "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                                "TransactionID" => $request->input('transactionID'),
                                "paymentDate" => $request->input('paymentdate'),
                                "futureDate" => $date,
                                "SalesPerson" => $request->input('saleperson'),
                                "TotalAmount" => $request->input('totalamount'),
                                "Paid" => $request->input('clientpaid'),
                                "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                                "PaymentType" => $request->input('paymentType'),
                                "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                                "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                                "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                                "Description" => $request->input('description'),
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                "remainingStatus" => $remainingstatus,
                                "transactionType" => $transactionType,
                                "transactionfee" => $request->input('transactionfee'),
                                "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                            ]);

                        if ($request->input('nextpaymentdate') == null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment") {
                            if ($request->input('paymentModes') == 'Renewal') {
                                $paymentNature = "Renewal Payment";
                            } else {
                                $paymentNature = "Recurring Payment";
                            }

                            $interval = $request->input('ChargingPlan');
                            $today = date('Y-m-d');

                            for ($i = 1; $i <= 10; $i++) {
                                if ($interval == "One Time Payment") {
                                    $datefinal = null;
                                } elseif ($interval == "Monthly") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) . ' month', strtotime($today)));
                                } elseif ($interval == "2 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' month', strtotime($today)));
                                } elseif ($interval == "3 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' month', strtotime($today)));
                                } elseif ($interval == "4 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                                } elseif ($interval == "5 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                                } elseif ($interval == "6 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                                } elseif ($interval == "7 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                                } elseif ($interval == "8 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                                } elseif ($interval == "9 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                                } elseif ($interval == "10 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                                } elseif ($interval == "11 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                                } elseif ($interval == "12 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                                } elseif ($interval == "2 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                                } elseif ($interval == "3 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                                }
                                // echo $datefinal . "<br>";



                                $futurePayment = NewPaymentsClients::create([
                                    "BrandID" => $request->input('brandID'),
                                    "ClientID" => $request->input('clientID'),
                                    "ProjectID" => $request->input('project'),
                                    "ProjectManager" => $request->input('accountmanager'),
                                    "paymentNature" =>  $paymentNature,
                                    "ChargingPlan" => '--',
                                    "ChargingMode" => '--',
                                    "Platform" => '--',
                                    "Card_Brand" => '--',
                                    "Payment_Gateway" => '--',
                                    "bankWireUpload" => '--',
                                    "TransactionID" => '--',
                                    // "paymentDate"=> $request->input('paymentdate'),
                                    "futureDate" => $datefinal,
                                    "SalesPerson" => $request->input('saleperson'),
                                    "TotalAmount" => $request->input('totalamount'),
                                    "Paid" => 0,
                                    "RemainingAmount" => 0,
                                    "PaymentType" => '--',
                                    "numberOfSplits" => '--',
                                    "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                                    "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                                    "Description" => '--',
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus" => 'Pending Payment',
                                    "remainingStatus" => '--',
                                    "transactionType" => $allPayments[0]->transactionType,
                                    "transactionfee" => $request->input('transactionfee'),
                                    "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                                ]);
                            }
                        }
                    }
                } else {
                    if ($request->input('nextpaymentdate') != null) {
                        $Payments = NewPaymentsClients::where('id', $id)
                            ->update([
                                "BrandID" => $request->input('brandID'),
                                "ProjectManager" => $request->input('accountmanager'),
                                "paymentNature" => $request->input('paymentNature'),
                                "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                                "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                                "Platform" => $request->input('platform'),
                                "Card_Brand" => $request->input('cardBrand'),
                                "Payment_Gateway" => $request->input('paymentgateway'),
                                "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                                "TransactionID" => $request->input('transactionID'),
                                "paymentDate" => $request->input('paymentdate'),
                                "futureDate" => $request->input('nextpaymentdate'),
                                "SalesPerson" => $request->input('saleperson'),
                                "TotalAmount" => $request->input('totalamount'),
                                "Paid" => $request->input('clientpaid'),
                                "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                                "PaymentType" => $request->input('paymentType'),
                                "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                                "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                                "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                                "Description" => $request->input('description'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                "remainingStatus" => $remainingstatus,
                                "transactionfee" => $request->input('transactionfee'),
                                "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')
                            ]);

                        if ($request->input('nextpaymentdate') == null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment") {
                            if ($request->input('paymentModes') == 'Renewal') {
                                $paymentNature = "Renewal Payment";
                            } else {
                                $paymentNature = "Recurring Payment";
                            }

                            $interval = $request->input('ChargingPlan');
                            $today = $request->input('nextpaymentdate');

                            for ($i = 1; $i <= 10; $i++) {
                                if ($interval == "One Time Payment") {
                                    $datefinal = null;
                                } elseif ($interval == "Monthly") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) . ' month', strtotime($today)));
                                } elseif ($interval == "2 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' month', strtotime($today)));
                                } elseif ($interval == "3 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' month', strtotime($today)));
                                } elseif ($interval == "4 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                                } elseif ($interval == "5 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                                } elseif ($interval == "6 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                                } elseif ($interval == "7 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                                } elseif ($interval == "8 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                                } elseif ($interval == "9 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                                } elseif ($interval == "10 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                                } elseif ($interval == "11 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                                } elseif ($interval == "12 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                                } elseif ($interval == "2 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                                } elseif ($interval == "3 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                                }
                                // echo $datefinal . "<br>";



                                $futurePayment = NewPaymentsClients::create([
                                    "BrandID" => $request->input('brandID'),
                                    "ClientID" => $request->input('clientID'),
                                    "ProjectID" => $request->input('project'),
                                    "ProjectManager" => $request->input('accountmanager'),
                                    "paymentNature" =>  $paymentNature,
                                    "ChargingPlan" => '--',
                                    "ChargingMode" => '--',
                                    "Platform" => '--',
                                    "Card_Brand" => '--',
                                    "Payment_Gateway" => '--',
                                    "bankWireUpload" => '--',
                                    "TransactionID" => '--',
                                    // "paymentDate"=> $request->input('paymentdate'),
                                    "futureDate" => $datefinal,
                                    "SalesPerson" => $request->input('saleperson'),
                                    "TotalAmount" => $request->input('totalamount'),
                                    "Paid" => 0,
                                    "RemainingAmount" => 0,
                                    "PaymentType" => '--',
                                    "numberOfSplits" => '--',
                                    "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                                    "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                                    "Description" => '--',
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus" => 'Pending Payment',
                                    "remainingStatus" => '--',
                                    "transactionType" => $allPayments[0]->transactionType,
                                    "transactionfee" => $request->input('transactionfee'),
                                    "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                                ]);
                            }
                        }
                    } else {
                        $today = date('Y-m-d');
                        if ($request->input('ChargingPlan') == "One Time Payment") {
                            $date = null;
                        } elseif ($request->input('ChargingPlan') == "Monthly") {
                            $date = date('Y-m-d', strtotime('+1 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "2 Months") {
                            $date = date('Y-m-d', strtotime('+2 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "3 Months") {
                            $date = date('Y-m-d', strtotime('+3 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "4 Months") {
                            $date = date('Y-m-d', strtotime('+4 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "5 Months") {
                            $date = date('Y-m-d', strtotime('+5 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "6 Months") {
                            $date = date('Y-m-d', strtotime('+6 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "7 Months") {
                            $date = date('Y-m-d', strtotime('+7 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "8 Months") {
                            $date = date('Y-m-d', strtotime('+8 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "9 Months") {
                            $date = date('Y-m-d', strtotime('+9 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "10 Months") {
                            $date = date('Y-m-d', strtotime('+10 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "11 Months") {
                            $date = date('Y-m-d', strtotime('+11 month', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "12 Months") {
                            $date = date('Y-m-d', strtotime('+1 Year', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "2 Years") {
                            $date = date('Y-m-d', strtotime('+2 Year', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "3 Years") {
                            $date = date('Y-m-d', strtotime('+3 Year', strtotime($today)));
                        }


                        $Payments = NewPaymentsClients::where('id', $id)
                            ->update([
                                "BrandID" => $request->input('brandID'),
                                "ClientID" => $request->input('clientID'),
                                "ProjectID" => $request->input('project'),
                                "ProjectManager" => $request->input('accountmanager'),
                                "paymentNature" => $request->input('paymentNature'),
                                "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                                "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                                "Platform" => $request->input('platform'),
                                "Card_Brand" => $request->input('cardBrand'),
                                "Payment_Gateway" => $request->input('paymentgateway'),
                                "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                                "TransactionID" => $request->input('transactionID'),
                                "paymentDate" => $request->input('paymentdate'),
                                "futureDate" => $date,
                                "SalesPerson" => $request->input('saleperson'),
                                "TotalAmount" => $request->input('totalamount'),
                                "Paid" => $request->input('clientpaid'),
                                "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                                "PaymentType" => $request->input('paymentType'),
                                "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                                "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                                "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                                "Description" => $request->input('description'),
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                "remainingStatus" => $remainingstatus,
                                "transactionType" => $transactionType,
                                "transactionfee" => $request->input('transactionfee'),
                                "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                            ]);

                        if ($request->input('nextpaymentdate') == null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment") {
                            if ($request->input('paymentModes') == 'Renewal') {
                                $paymentNature = "Renewal Payment";
                            } else {
                                $paymentNature = "Recurring Payment";
                            }

                            $interval = $request->input('ChargingPlan');
                            $today = date('Y-m-d');

                            for ($i = 1; $i <= 10; $i++) {
                                if ($interval == "One Time Payment") {
                                    $datefinal = null;
                                } elseif ($interval == "Monthly") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) . ' month', strtotime($today)));
                                } elseif ($interval == "2 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' month', strtotime($today)));
                                } elseif ($interval == "3 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' month', strtotime($today)));
                                } elseif ($interval == "4 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                                } elseif ($interval == "5 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                                } elseif ($interval == "6 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                                } elseif ($interval == "7 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                                } elseif ($interval == "8 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                                } elseif ($interval == "9 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                                } elseif ($interval == "10 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                                } elseif ($interval == "11 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                                } elseif ($interval == "12 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                                } elseif ($interval == "2 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                                } elseif ($interval == "3 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                                }
                                // echo $datefinal . "<br>";



                                $futurePayment = NewPaymentsClients::create([
                                    "BrandID" => $request->input('brandID'),
                                    "ClientID" => $request->input('clientID'),
                                    "ProjectID" => $request->input('project'),
                                    "ProjectManager" => $request->input('accountmanager'),
                                    "paymentNature" =>  $paymentNature,
                                    "ChargingPlan" => '--',
                                    "ChargingMode" => '--',
                                    "Platform" => '--',
                                    "Card_Brand" => '--',
                                    "Payment_Gateway" => '--',
                                    "bankWireUpload" => '--',
                                    "TransactionID" => '--',
                                    // "paymentDate"=> $request->input('paymentdate'),
                                    "futureDate" => $datefinal,
                                    "SalesPerson" => $request->input('saleperson'),
                                    "TotalAmount" => $request->input('totalamount'),
                                    "Paid" => 0,
                                    "RemainingAmount" => 0,
                                    "PaymentType" => '--',
                                    "numberOfSplits" => '--',
                                    "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                                    "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                                    "Description" => '--',
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus" => 'Pending Payment',
                                    "remainingStatus" => '--',
                                    "transactionType" => $allPayments[0]->transactionType,
                                    "transactionfee" => $request->input('transactionfee'),
                                    "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                                ]);
                            }
                        }
                    }
                }
            } else {
                if ($allPayments[0]->paymentNature == "New Lead" || $allPayments[0]->paymentNature == "New Sale" || $allPayments[0]->paymentNature == "New Sale") {
                    $deletePendingpayments = NewPaymentsClients::where('transactionType', $allPayments[0]->transactionType)->where('paymentDate', null)->delete();
                    $Payments = NewPaymentsClients::where('id', $id)
                        ->update([
                            "BrandID" => $request->input('brandID'),
                            "ClientID" => $request->input('clientID'),
                            "ProjectID" => $request->input('project'),
                            "ProjectManager" => $request->input('accountmanager'),
                            "paymentNature" => $request->input('paymentNature'),
                            "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                            "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                            "Platform" => $request->input('platform'),
                            "Card_Brand" => $request->input('cardBrand'),
                            "Payment_Gateway" => $request->input('paymentgateway'),
                            "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                            "TransactionID" => $request->input('transactionID'),
                            "paymentDate" => $request->input('paymentdate'),
                            "futureDate" => null,
                            "SalesPerson" => $request->input('saleperson'),
                            "TotalAmount" => $request->input('totalamount'),
                            "Paid" => $request->input('clientpaid'),
                            "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                            "PaymentType" => $request->input('paymentType'),
                            "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                            "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                            "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                            "Description" => $request->input('description'),
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            "remainingStatus" => $remainingstatus,
                            "transactionType" => $transactionType,
                            "transactionfee" => $request->input('transactionfee'),
                            "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                        ]);
                } else {
                    $Payments = NewPaymentsClients::where('id', $id)
                        ->update([
                            "BrandID" => $request->input('brandID'),
                            "ClientID" => $request->input('clientID'),
                            "ProjectID" => $request->input('project'),
                            "ProjectManager" => $request->input('accountmanager'),
                            "paymentNature" => $request->input('paymentNature'),
                            "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                            "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                            "Platform" => $request->input('platform'),
                            "Card_Brand" => $request->input('cardBrand'),
                            "Payment_Gateway" => $request->input('paymentgateway'),
                            "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                            "TransactionID" => $request->input('transactionID'),
                            "paymentDate" => $request->input('paymentdate'),
                            "futureDate" => null,
                            "SalesPerson" => $request->input('saleperson'),
                            "TotalAmount" => $request->input('totalamount'),
                            "Paid" => $request->input('clientpaid'),
                            "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                            "PaymentType" => $request->input('paymentType'),
                            "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                            "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                            "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                            "Description" => $request->input('description'),
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            "remainingStatus" => $remainingstatus,
                            "transactionType" => $transactionType,
                            "transactionfee" => $request->input('transactionfee'),
                            "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                        ]);
                }
            }
        }


        if ($paymentType == "Split Payment") {

            $paymentDescription = $request->input('saleperson') . " Charge Payment For Client " . $request->input('clientID');
            $totalamount = $request->input('totalamount');
            $amountShare = $request->input('splitamount');
            $sharedProjectManager = $request->input('shareProjectManager');
            $c = [];
            $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

            $createMainEmployeePayment  = EmployeePayment::create([
                "paymentID" => $id,
                "employeeID" => $request->input('saleperson'),
                "paymentDescription" => $paymentDescription,
                "amount" => $amount
            ]);



            foreach ($sharedProjectManager as $key => $value) {
                $c[$key] = [$value, $amountShare[$key]];
            }

            foreach ($c as $SecondProjectManagers) {
                if ($SecondProjectManagers[0] != 0) {
                    $createSharedPersonEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $id,
                            "employeeID" => $SecondProjectManagers[0],
                            "paymentDescription" => "Amount Share By " . $request->input('saleperson'),
                            "amount" =>  $SecondProjectManagers[1]
                        ]
                    );
                }
            }
        } else {

            $paymentDescription = $request->input('saleperson') . " Charge Payment For Client " . $request->input('clientID');
            $clientpaid = $request->input('clientpaid');



            $createEmployeePayment  = EmployeePayment::create(
                [
                    "paymentID" => $id,
                    "employeeID" => $request->input('saleperson'),
                    "paymentDescription" =>  $paymentDescription,
                    "amount" =>   $clientpaid
                ]
            );
        }



        // return ('check');
        return redirect('/client/project/payment/all');
    }
    function clientPayment_Unlinked(Request $request, $id)
    {
        // $SecondProjectManager = $request->input('shareProjectManager');
        // echo("<pre>");
        // print_r($SecondProjectManager);
        // die();
        $checkforremaining = NewPaymentsClients::where('id', $id)->get();
        $paymentType = $request->input('paymentType');
        $paymentNature = $request->input('paymentNature');
        $findusername = DB::table('employees')->where('id', $request->input('accountmanager'))->get();
        $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
        $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
        $brandID = $request->input('brandID');

        if ($paymentNature != "Remaining") {
            if ($checkforremaining[0]->remainingID != null) {
                $remainingstatus = "Not Remaining";
            } elseif ($remainingamt == 0) {
                $remainingstatus = "Not Remaining";
            } else {
                $remainingstatus = "Remaining";
            }

            if ($request->file('bankWireUpload') != null) {
                $bookwire = $request->file('bankWireUpload')->store('Payment');
            } else {
                $bookwire = "--";
            }

            $upsellCount = NewPaymentsClients::where('ClientID', $request->input('clientID'))->where('paymentNature', 'Upsell')->count();
            // $transactionType = $request->input('paymentNature');

            if ($request->input('paymentNature') == 'Upsell') {
                if ($upsellCount == 0) {
                    $transactionType = $request->input('paymentNature');
                } else {
                    $transactionType = $request->input('paymentNature') . "(" . $upsellCount . ")";
                }
            } else {
                $transactionType = $request->input('paymentNature');
            }


            if ($request->input('nextpaymentdate') != null) {

                $createpayment = NewPaymentsClients::where('id', $id)->update([
                    "BrandID" => $brandID,
                    "ClientID" => $request->input('clientID'),
                    "ProjectID" => $request->input('project'),
                    "ProjectManager" => $request->input('accountmanager'),
                    "paymentNature" => $request->input('paymentNature'),
                    "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform" => $request->input('platform'),
                    "Card_Brand" => $request->input('cardBrand'),
                    "Payment_Gateway" => $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID" => $request->input('transactionID'),
                    "paymentDate" => $request->input('paymentdate'),
                    "futureDate" => $request->input('nextpaymentdate'),
                    "SalesPerson" => $request->input('saleperson'),
                    "TotalAmount" => $request->input('totalamount'),
                    "Paid" => $request->input('clientpaid'),
                    "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType" => $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description" => $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus" => 'On Going',
                    "remainingStatus" => $remainingstatus,
                    "transactionType" => $transactionType,
                    "transactionfee" => $request->input('transactionfee'),
                    "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                ]);
            } elseif ($request->input('ChargingPlan') != null && $request->input('nextpaymentdate') == null) {

                $today = date('Y-m-d');
                if ($request->input('ChargingPlan') == "One Time Payment") {
                    $date = null;
                } elseif ($request->input('ChargingPlan') == "Monthly") {
                    $date = date('Y-m-d', strtotime('+1 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "2 Months") {
                    $date = date('Y-m-d', strtotime('+2 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "3 Months") {
                    $date = date('Y-m-d', strtotime('+3 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "4 Months") {
                    $date = date('Y-m-d', strtotime('+4 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "5 Months") {
                    $date = date('Y-m-d', strtotime('+5 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "6 Months") {
                    $date = date('Y-m-d', strtotime('+6 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "7 Months") {
                    $date = date('Y-m-d', strtotime('+7 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "8 Months") {
                    $date = date('Y-m-d', strtotime('+8 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "9 Months") {
                    $date = date('Y-m-d', strtotime('+9 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "10 Months") {
                    $date = date('Y-m-d', strtotime('+10 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "11 Months") {
                    $date = date('Y-m-d', strtotime('+11 month', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "12 Months") {
                    $date = date('Y-m-d', strtotime('+1 Year', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "2 Years") {
                    $date = date('Y-m-d', strtotime('+2 Year', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "3 Years") {
                    $date = date('Y-m-d', strtotime('+3 Year', strtotime($today)));
                }


                $createpayment = NewPaymentsClients::where('id', $id)->update([
                    "BrandID" => $brandID,
                    "ClientID" => $request->input('clientID'),
                    "ProjectID" => $request->input('project'),
                    "ProjectManager" => $request->input('accountmanager'),
                    "paymentNature" => $request->input('paymentNature'),
                    "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform" => $request->input('platform'),
                    "Card_Brand" => $request->input('cardBrand'),
                    "Payment_Gateway" => $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID" => $request->input('transactionID'),
                    "paymentDate" => $request->input('paymentdate'),
                    "futureDate" => $date,
                    "SalesPerson" => $request->input('saleperson'),
                    "TotalAmount" => $request->input('totalamount'),
                    "Paid" => $request->input('clientpaid'),
                    "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType" => $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description" => $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus" => 'On Going',
                    "remainingStatus" => $remainingstatus,
                    "transactionType" => $transactionType,
                    "transactionfee" => $request->input('transactionfee'),
                    "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                ]);
            } else {

                $createpayment = NewPaymentsClients::where('id', $id)->update([
                    "BrandID" => $brandID,
                    "ClientID" => $request->input('clientID'),
                    "ProjectID" => $request->input('project'),
                    "ProjectManager" => $request->input('accountmanager'),
                    "paymentNature" => $request->input('paymentNature'),
                    "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform" => $request->input('platform'),
                    "Card_Brand" => $request->input('cardBrand'),
                    "Payment_Gateway" => $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID" => $request->input('transactionID'),
                    "paymentDate" => $request->input('paymentdate'),
                    "futureDate" => $request->input('nextpaymentdate'),
                    "SalesPerson" => $request->input('saleperson'),
                    "TotalAmount" => $request->input('totalamount'),
                    "Paid" => $request->input('clientpaid'),
                    "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType" => $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description" => $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus" => 'On Going',
                    "remainingStatus" => $remainingstatus,
                    "transactionType" => $transactionType,
                    "transactionfee" => $request->input('transactionfee'),
                    "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                ]);
            }

            if ($request->input('nextpaymentdate') == null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment") {

                if ($request->input('paymentModes') == 'Renewal') {
                    $paymentNature = "Renewal Payment";
                } else {
                    $paymentNature = "Recurring Payment";
                }



                $interval = $request->input('ChargingPlan');
                $today = date('Y-m-d');

                for ($i = 1; $i <= 10; $i++) {
                    if ($interval == "One Time Payment") {
                        $datefinal = null;
                    } elseif ($interval == "Monthly") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) . ' month', strtotime($today)));
                    } elseif ($interval == "2 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' month', strtotime($today)));
                    } elseif ($interval == "3 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' month', strtotime($today)));
                    } elseif ($interval == "4 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                    } elseif ($interval == "5 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                    } elseif ($interval == "6 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                    } elseif ($interval == "7 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                    } elseif ($interval == "8 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                    } elseif ($interval == "9 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                    } elseif ($interval == "10 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                    } elseif ($interval == "11 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                    } elseif ($interval == "12 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                    } elseif ($interval == "2 Years") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                    } elseif ($interval == "3 Years") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                    }
                    // echo $datefinal . "<br>";



                    $futurePayment = NewPaymentsClients::create([
                        "BrandID" => $brandID,
                        "ClientID" => $request->input('clientID'),
                        "ProjectID" => $request->input('project'),
                        "ProjectManager" => $request->input('accountmanager'),
                        "paymentNature" =>  $paymentNature,
                        "ChargingPlan" => '--',
                        "ChargingMode" => '--',
                        "Platform" => '--',
                        "Card_Brand" => '--',
                        "Payment_Gateway" => '--',
                        "bankWireUpload" => '--',
                        "TransactionID" => '--',
                        // "paymentDate"=> $request->input('paymentdate'),
                        "futureDate" => $datefinal,
                        "SalesPerson" => $request->input('saleperson'),
                        "TotalAmount" => $request->input('totalamount'),
                        "Paid" => 0,
                        "RemainingAmount" => 0,
                        "PaymentType" => '--',
                        "numberOfSplits" => '--',
                        "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                        "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                        "Description" => '--',
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus" => 'Pending Payment',
                        "remainingStatus" => '--',
                        "transactionType" => $transactionType,
                        "transactionfee" => $request->input('transactionfee'),
                        "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                    ]);
                }
            } elseif ($request->input('nextpaymentdate') != null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment") {

                if ($request->input('paymentModes') == 'Renewal') {
                    $paymentNature = "Renewal Payment";
                } else {
                    $paymentNature = "Recurring Payment";
                }



                $interval = $request->input('ChargingPlan');
                $today = $request->input('nextpaymentdate');

                for ($i = 1; $i <= 10; $i++) {
                    if ($interval == "One Time Payment") {
                        $datefinal = null;
                    } elseif ($interval == "Monthly") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) . ' month', strtotime($today)));
                    } elseif ($interval == "2 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' month', strtotime($today)));
                    } elseif ($interval == "3 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' month', strtotime($today)));
                    } elseif ($interval == "4 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                    } elseif ($interval == "5 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                    } elseif ($interval == "6 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                    } elseif ($interval == "7 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                    } elseif ($interval == "8 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                    } elseif ($interval == "9 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                    } elseif ($interval == "10 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                    } elseif ($interval == "11 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                    } elseif ($interval == "12 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                    } elseif ($interval == "2 Years") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                    } elseif ($interval == "3 Years") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                    }
                    // echo $datefinal . "<br>";



                    $futurePayment = NewPaymentsClients::create([
                        "BrandID" => $brandID,
                        "ClientID" => $request->input('clientID'),
                        "ProjectID" => $request->input('project'),
                        "ProjectManager" => $request->input('accountmanager'),
                        "paymentNature" =>  $paymentNature,
                        "ChargingPlan" => '--',
                        "ChargingMode" => '--',
                        "Platform" => '--',
                        "Card_Brand" => '--',
                        "Payment_Gateway" => '--',
                        "bankWireUpload" => '--',
                        "TransactionID" => '--',
                        // "paymentDate"=> $request->input('paymentdate'),
                        "futureDate" => $datefinal,
                        "SalesPerson" => $request->input('saleperson'),
                        "TotalAmount" => $request->input('totalamount'),
                        "Paid" => 0,
                        "RemainingAmount" => 0,
                        "PaymentType" => '--',
                        "numberOfSplits" => '--',
                        "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                        "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                        "Description" => '--',
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus" => 'Pending Payment',
                        "remainingStatus" => '--',
                        "transactionType" => $transactionType,
                        "transactionfee" => $request->input('transactionfee'),
                        "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                    ]);
                }
            }


            if ($paymentType == "Split Payment") {

                $paymentDescription = $request->input('saleperson') . " Charge Payment For Client " . $request->input('clientID');
                $totalamount = $request->input('totalamount');
                $amountShare = $request->input('splitamount');
                $sharedProjectManager = $request->input('shareProjectManager');
                $c = [];
                $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

                $createMainEmployeePayment  = EmployeePayment::create([
                    "paymentID" => $id,
                    "employeeID" => $request->input('saleperson'),
                    "paymentDescription" => $paymentDescription,
                    "amount" => $amount
                ]);



                foreach ($sharedProjectManager as $key => $value) {
                    $c[$key] = [$value, $amountShare[$key]];
                }

                foreach ($c as $SecondProjectManagers) {
                    if ($SecondProjectManagers[0] != 0) {
                        $createSharedPersonEmployeePayment  = EmployeePayment::create(
                            [
                                "paymentID" => $id,
                                "employeeID" => $SecondProjectManagers[0],
                                "paymentDescription" => "Amount Share By " . $request->input('saleperson'),
                                "amount" =>  $SecondProjectManagers[1]
                            ]
                        );
                    }
                }
            } else {

                $paymentDescription = $request->input('saleperson') . " Charge Payment For Client " . $request->input('clientID');
                $clientpaid = $request->input('clientpaid');



                $createEmployeePayment  = EmployeePayment::create(
                    [
                        "paymentID" => $id,
                        "employeeID" => $request->input('saleperson'),
                        "paymentDescription" =>  $paymentDescription,
                        "amount" =>   $clientpaid
                    ]
                );
            }
        } else {

            $checkremaining = NewPaymentsClients::where('id', $request->input('remainingamountfor'))->get();

            if (isset($checkremaining[0]->remainingID) && $checkremaining[0]->remainingID != null) {

                $paymentType = $request->input('paymentType');
                $paymentNature = $request->input('paymentNature');
                $findusername = DB::table('employees')->where('id', $request->input('accountmanager'))->get();
                $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
                $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
                $gettingpayment = NewPaymentsClients::where('remainingID', $checkremaining[0]->remainingID)->sum("Paid");
                $checkingtotalremaining = $checkremaining[0]->remaiTotalAmountningID - $gettingpayment - $request->input('clientpaid');

                if ($checkingtotalremaining == 0) {
                    $remainingstatus = "Received Remaining";
                } else {
                    $remainingstatus = "Remaining";
                }

                $changeStatus = NewPaymentsClients::where('id', $request->input('remainingamountfor'))->update([
                    "remainingStatus"  => $remainingstatus
                ]);

                if ($request->file('bankWireUpload') != null) {
                    $bookwire = $request->file('bankWireUpload')->store('Payment');
                } else {
                    $bookwire = "--";
                }

                $transactionType = $request->input('paymentNature');


                // if( $request->input('nextpaymentdate') != null ){

                $createpayment = NewPaymentsClients::where('id', $id)->update([
                    "BrandID" => $request->input('brandID'),
                    "ClientID" => $request->input('clientID'),
                    "ProjectID" => $request->input('project'),
                    "ProjectManager" => $request->input('accountmanager'),
                    "paymentNature" => $request->input('paymentNature'),
                    "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform" => $request->input('platform'),
                    "Card_Brand" => $request->input('cardBrand'),
                    "Payment_Gateway" => $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID" => $request->input('transactionID'),
                    "paymentDate" => $request->input('paymentdate'),
                    // "futureDate"=> $request->input('nextpaymentdate'),
                    "SalesPerson" => $request->input('saleperson'),
                    "TotalAmount" => $request->input('totalamount'),
                    "Paid" => $request->input('clientpaid'),
                    "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType" => $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description" => $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus" => 'On Going',
                    "remainingID" => $checkremaining[0]->remainingID,
                    "remainingStatus" =>  "Remaining Payment",
                    "transactionType" => $transactionType,
                    "transactionfee" => $request->input('transactionfee'),
                    "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                ]);


                if ($paymentType == "Split Payment") {

                    $paymentDescription = $findusername[0]->name . " Charge Remaining Payment For Client " . $findclient[0]->name;
                    $totalamount = $request->input('totalamount');
                    $amountShare = $request->input('splitamount');
                    $sharedProjectManager = $request->input('shareProjectManager');
                    $c = [];
                    $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

                    $createMainEmployeePayment  = EmployeePayment::create([
                        "paymentID" => $id,
                        "employeeID" => $request->input('saleperson'),
                        "paymentDescription" => $paymentDescription,
                        "amount" => $amount
                    ]);



                    foreach ($sharedProjectManager as $key => $value) {
                        $c[$key] = [$value, $amountShare[$key]];
                    }

                    foreach ($c as $SecondProjectManagers) {
                        if ($SecondProjectManagers[0] != 0) {
                            $createSharedPersonEmployeePayment  = EmployeePayment::create(
                                [
                                    "paymentID" => $id,
                                    "employeeID" => $SecondProjectManagers[0],
                                    "paymentDescription" => "Remaining(Payment) Amount Share By " . $findusername[0]->name,
                                    "amount" =>  $SecondProjectManagers[1]
                                ]
                            );
                        }
                    }
                } else {

                    $paymentDescription = $findusername[0]->name . " Charge Remaining Payment For Client " . $findclient[0]->name;
                    $clientpaid = $request->input('clientpaid');



                    $createEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $id,
                            "employeeID" => $request->input('saleperson'),
                            "paymentDescription" =>  $paymentDescription,
                            "amount" =>   $clientpaid
                        ]
                    );
                }
            } else {
                $paymentType = $request->input('paymentType');
                $paymentNature = $request->input('paymentNature');
                $findusername = DB::table('employees')->where('id', $request->input('accountmanager'))->get();
                $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
                $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
                $gettingpayment = NewPaymentsClients::where('remainingID', $checkremaining[0]->remainingID)->sum("Paid");
                $checkingtotalremaining = $checkremaining[0]->remaiTotalAmountningID - $gettingpayment;
                if ($checkingtotalremaining == 0) {
                    $remainingstatus = "Received Remaining";
                } else {
                    $remainingstatus = "Remaining";
                }

                if ($request->file('bankWireUpload') != null) {
                    $bookwire = $request->file('bankWireUpload')->store('Payment');
                } else {
                    $bookwire = "--";
                }

                $changeStatus = NewPaymentsClients::where('id', $request->input('remainingamountfor'))->update([
                    "remainingID"  => $request->input('remainingID'),
                    "remainingStatus"  => $remainingstatus
                ]);



                $transactionType = $request->input('paymentNature');


                // if( $request->input('nextpaymentdate') != null ){

                $createpayment = NewPaymentsClients::where('id', $id)->update([
                    "BrandID" => $request->input('brandID'),
                    "ClientID" => $request->input('clientID'),
                    "ProjectID" => $request->input('project'),
                    "ProjectManager" => $request->input('accountmanager'),
                    "paymentNature" => $request->input('paymentNature'),
                    "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform" => $request->input('platform'),
                    "Card_Brand" => $request->input('cardBrand'),
                    "Payment_Gateway" => $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID" => $request->input('transactionID'),
                    "paymentDate" => $request->input('paymentdate'),
                    // "futureDate"=> $request->input('nextpaymentdate'),
                    "SalesPerson" => $request->input('saleperson'),
                    "TotalAmount" => $request->input('totalamount'),
                    "Paid" => $request->input('clientpaid'),
                    "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType" => $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description" => $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus" => 'On Going',
                    "remainingID" => $request->input('remainingID'),
                    "remainingStatus" => "Remaining Payment",
                    "transactionType" => $transactionType,
                    "transactionfee" => $request->input('transactionfee'),
                    "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

                ]);


                if ($paymentType == "Split Payment") {

                    $paymentDescription = $findusername[0]->name . " Charge Remaining Payment For Client " . $findclient[0]->name;
                    $totalamount = $request->input('totalamount');
                    $amountShare = $request->input('splitamount');
                    $sharedProjectManager = $request->input('shareProjectManager');
                    $c = [];
                    $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

                    $createMainEmployeePayment  = EmployeePayment::create([
                        "paymentID" => $id,
                        "employeeID" => $request->input('saleperson'),
                        "paymentDescription" => $paymentDescription,
                        "amount" => $amount
                    ]);



                    foreach ($sharedProjectManager as $key => $value) {
                        $c[$key] = [$value, $amountShare[$key]];
                    }

                    foreach ($c as $SecondProjectManagers) {
                        if ($SecondProjectManagers[0] != 0) {
                            $createSharedPersonEmployeePayment  = EmployeePayment::create(
                                [
                                    "paymentID" => $id,
                                    "employeeID" => $SecondProjectManagers[0],
                                    "paymentDescription" => "Remaining(Payment) Amount Share By " . $findusername[0]->name,
                                    "amount" =>  $SecondProjectManagers[1]
                                ]
                            );
                        }
                    }
                } else {

                    $paymentDescription = $findusername[0]->name . " Charge Remaining Payment For Client " . $findclient[0]->name;
                    $clientpaid = $request->input('clientpaid');



                    $createEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $id,
                            "employeeID" => $request->input('saleperson'),
                            "paymentDescription" =>  $paymentDescription,
                            "amount" =>   $clientpaid
                        ]
                    );
                }
            }
        }





        // return redirect('/forms/payment/' . $request->input('project'));
        return redirect('/client/details/' . $request->input('clientID'));
    }


    function payment_Refund_stripePayment_Process(Request $request, $id)
    {
        $referencepayment = NewPaymentsClients::where('id', $request->input('paymentreference'))->get();
        if ($referencepayment[0]->dispute == null) {
            $originalpayment = NewPaymentsClients::where('id', $request->input('paymentreference'))->update([
                "refundID" => $request->input('refundID')
            ]);

            if ($request->file('bankWireUpload') != null) {
                $bookwire = $request->file('bankWireUpload')->store('Payment');
            } else {
                $bookwire = "--";
            }

            $originalrefund = NewPaymentsClients::insertGetId([
                "BrandID" => $request->input('brandID'),
                "ClientID" => $request->input('clientID'),
                "ProjectID" => $request->input('project'),
                "ProjectManager" => $request->input('accountmanager'),
                "paymentNature" => $referencepayment[0]->paymentNature,
                "ChargingPlan" => $referencepayment[0]->ChargingPlan,
                "ChargingMode" => $referencepayment[0]->ChargingMode,
                "Platform" => $request->input('platform'),
                "Card_Brand" => $request->input('cardBrand'),
                "Payment_Gateway" => $request->input('paymentgateway'),
                "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                "TransactionID" => $request->input('transactionID'),
                "paymentDate" => $request->input('paymentdate'),
                "SalesPerson" => $request->input('saleperson'),
                "TotalAmount" => $request->input('totalamount'),
                "Paid" => $request->input('clientpaid'),
                "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                "PaymentType" => $referencepayment[0]->PaymentType,
                "numberOfSplits" => $referencepayment[0]->numberOfSplits,
                "SplitProjectManager" => $referencepayment[0]->SplitProjectManager,
                "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                "Description" => $request->input('description'),
                'created_at' => date('y-m-d H:m:s'),
                'updated_at' => date('y-m-d H:m:s'),
                "refundStatus" => 'Refund',
                "refundID" => $request->input('refundID'),
                "remainingStatus" => 0,
                "transactionType" =>  $referencepayment[0]->transactionType,
                "transactionfee" => 0,
                "amt_after_transactionfee" => $request->input('clientpaid')

            ]);

            $payment_in_refund_table = RefundPayments::create([
                "BrandID" =>  $request->input('brandID'),
                "ClientID" =>  $request->input('clientID'),
                "ProjectID" => $request->input('project'),
                'ProjectManager' => $request->input('accountmanager'),
                'PaymentID' => $originalrefund,
                'basicAmount' =>  $request->input('totalamount'),
                "refundAmount" => $request->input('clientpaid'),
                "refundtype" => $request->input('chargebacktype'),
                "refund_date" => $request->input('paymentdate'),
                "refundReason" =>  $request->input('description'),
                "clientpaid" =>   $referencepayment[0]->Paid,
                "paymentType" =>   $referencepayment[0]->PaymentType,
                "splitmanagers" =>   $referencepayment[0]->SplitProjectManager,
                "splitamounts" =>  $referencepayment[0]->ShareAmount,
                "splitRefunds" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                "transactionfee" => $request->input('transactionfee'),
                "amt_after_transactionfee" => $request->input('clientpaid') + $request->input('transactionfee')


            ]);

            if ($referencepayment[0]->PaymentType == "Split Payment") {
                $paymentDescription = $request->input('saleperson') . " Refund Payment For Client " . $request->input('clientID');
                $totalamount = $request->input('totalamount');
                $amountShare = $request->input('splitamount');
                $sharedProjectManager = $request->input('shareProjectManager');
                $c = [];
                $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

                $createMainEmployeePayment  = EmployeePayment::create([
                    "paymentID" => $originalrefund,
                    "employeeID" => $request->input('saleperson'),
                    "paymentDescription" => $paymentDescription,
                    "amount" => $amount
                ]);



                foreach ($sharedProjectManager as $key => $value) {
                    $c[$key] = [$value, $amountShare[$key]];
                }

                foreach ($c as $SecondProjectManagers) {
                    if ($SecondProjectManagers[0] != 0) {
                        $createSharedPersonEmployeePayment  = EmployeePayment::create(
                            [
                                "paymentID" => $originalrefund,
                                "employeeID" => $SecondProjectManagers[0],
                                "paymentDescription" => "refund Share By " . $request->input('saleperson'),
                                "amount" =>  $SecondProjectManagers[1]
                            ]
                        );
                    }
                }
            } else {

                $paymentDescription = $request->input('saleperson') . " Refund Payment For Client " . $request->input('clientID');
                $clientpaid = $request->input('clientpaid');



                $createEmployeePayment  = EmployeePayment::create(
                    [
                        "paymentID" => $originalrefund,
                        "employeeID" => $request->input('accountmanager'),
                        "paymentDescription" =>  $paymentDescription,
                        "amount" =>   $clientpaid
                    ]
                );
            }
        } else {
            $referencepayment = NewPaymentsClients::where('id', $request->input('paymentreference'))->get();
            $disputetogetfee = Disputedpayments::where('PaymentID', $request->input('paymentreference'))->get();
            $Disputedpayments = Disputedpayments::where('PaymentID', $request->input('paymentreference'))->update([
                "disputeStatus" => "Lost",
            ]);

            $originalpayment = NewPaymentsClients::where('id', $request->input('paymentreference'))->update([
                "refundID" => $request->input('refundID')
            ]);

            if ($request->file('bankWireUpload') != null) {
                $bookwire = $request->file('bankWireUpload')->store('Payment');
            } else {
                $bookwire = "--";
            }

            $originalrefund = NewPaymentsClients::where('id', $request->input('paymentreference'))->update([
                "BrandID" => $request->input('brandID'),
                "ClientID" => $request->input('clientID'),
                "ProjectID" => $request->input('project'),
                "ProjectManager" => $request->input('accountmanager'),
                "paymentNature" => $referencepayment[0]->paymentNature,
                "ChargingPlan" => $referencepayment[0]->ChargingPlan,
                "ChargingMode" => $referencepayment[0]->ChargingMode,
                "Platform" => $referencepayment[0]->Platform,
                "Card_Brand" => $referencepayment[0]->Card_Brand,
                "Payment_Gateway" => $referencepayment[0]->Payment_Gateway,
                "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                "TransactionID" => $referencepayment[0]->TransactionID . "(Refund)",
                "paymentDate" => $request->input('paymentdate'),
                "SalesPerson" => $referencepayment[0]->SalesPerson,
                "TotalAmount" => $referencepayment[0]->TotalAmount,
                "Paid" => $referencepayment[0]->Paid,
                "RemainingAmount" => 0,
                "PaymentType" => $referencepayment[0]->PaymentType,
                "numberOfSplits" => $referencepayment[0]->numberOfSplits,
                "SplitProjectManager" => $referencepayment[0]->SplitProjectManager,
                "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('refundamount')),
                "Description" => $request->input('Description_of_issue'),
                'created_at' => date('y-m-d H:m:s'),
                'updated_at' => date('y-m-d H:m:s'),
                "refundStatus" => 'Refund',
                "refundID" => $request->input('refundID'),
                "remainingStatus" => "Dispute Lost",
                "transactionType" =>  $referencepayment[0]->transactionType,
                "transactionfee" => 0,
                "amt_after_transactionfee" => $referencepayment[0]->Paid,
                "disputefee" => $disputetogetfee[0]->disputefee,
                "amt_after_disputefee" => $referencepayment[0]->Paid + $disputetogetfee[0]->disputefee,

            ]);

            $payment_in_refund_table = RefundPayments::create([
                "BrandID" =>  $request->input('brandID'),
                "ClientID" =>  $request->input('clientID'),
                "ProjectID" => $request->input('project'),
                'ProjectManager' => $request->input('accountmanager'),
                'PaymentID' => $request->input('paymentreference'),
                'basicAmount' =>  $referencepayment[0]->TotalAmount,
                "refundAmount" => $request->input('chagebackAmt'),
                "refundtype" => $request->input('chargebacktype'),
                "refund_date" => $request->input('chagebackDate'),
                "refundReason" =>  $request->input('Description_of_issue'),
                "clientpaid" =>   $referencepayment[0]->Paid,
                "paymentType" =>   $referencepayment[0]->PaymentType,
                "splitmanagers" =>   $referencepayment[0]->SplitProjectManager,
                "splitamounts" =>  $referencepayment[0]->ShareAmount,
                "splitRefunds" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('refundamount')),

            ]);


            if ($referencepayment[0]->PaymentType == "Split Payment") {
                $paymentDescription = $request->input('saleperson') . " Refund Payment For Client " . $request->input('clientID');
                $totalamount = $request->input('totalamount');
                $amountShare = $request->input('splitamount');
                $sharedProjectManager = $request->input('shareProjectManager');
                $c = [];
                $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

                $createMainEmployeePayment  = EmployeePayment::create([
                    "paymentID" => $request->input('paymentreference'),
                    "employeeID" => $request->input('saleperson'),
                    "paymentDescription" => $paymentDescription,
                    "amount" => $amount
                ]);



                foreach ($sharedProjectManager as $key => $value) {
                    $c[$key] = [$value, $amountShare[$key]];
                }

                foreach ($c as $SecondProjectManagers) {
                    if ($SecondProjectManagers[0] != 0) {
                        $createSharedPersonEmployeePayment  = EmployeePayment::create(
                            [
                                "paymentID" => $request->input('paymentreference'),
                                "employeeID" => $SecondProjectManagers[0],
                                "paymentDescription" => "Refund Share By " . $request->input('saleperson'),
                                "amount" =>  $SecondProjectManagers[1]
                            ]
                        );
                    }
                }
            } else {

                $paymentDescription = $request->input('saleperson') . " Refund Payment For Client " . $request->input('clientID');
                $clientpaid = $request->input('chagebackAmt');



                $createEmployeePayment  = EmployeePayment::create(
                    [
                        "paymentID" => $request->input('paymentreference'),
                        "employeeID" => $request->input('saleperson'),
                        "paymentDescription" =>  $paymentDescription,
                        "amount" =>   $clientpaid
                    ]
                );
            }
        }

        return redirect('/client/project/payment/all');
    }

    function payment_remaining_amount(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $mainPayment = NewPaymentsClients::where('id', $id)->get();

        $findproject = Project::where('id', $mainPayment[0]->ProjectID)->get();
        $findclient = Client::get();
        $findemployee = Employee::get();
        $allPayments = NewPaymentsClients::where('ClientID', $findproject[0]->ClientName->id)
            ->where('refundStatus', '!=', 'Pending Payment')
            ->where('remainingStatus', '!=', 'Unlinked Payments')
            ->get();

        return view('remainingPayment', [
            'mainPayments' => $mainPayment,
            'allPayments' => $allPayments,
            'id' => $id,
            'projectmanager' => $findproject,
            'clients' => $findclient,
            'employee' => $findemployee,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }
    function payment_remaining_amount_process(Request $request, $id)
    {

        $changeStatus = NewPaymentsClients::where('id', $id)->update([
            "remainingID"  => $request->input('remainingID'),
            "remainingStatus"  => "Received Remaining"
        ]);

        $paymentType = $request->input('paymentType');
        $paymentNature = $request->input('paymentNature');
        $findusername = DB::table('employees')->where('id', $request->input('saleperson'))->get();
        $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
        $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
        if ($remainingamt == 0) {
            $remainingstatus = "Received Remaining";
        } else {
            $remainingstatus = "Remaining";
        }

        if ($request->file('bankWireUpload') != null) {
            $bookwire = $request->file('bankWireUpload')->store('Payment');
        } else {
            $bookwire = "--";
        }

        $transactionType = $request->input('paymentNature');


        // if( $request->input('nextpaymentdate') != null ){

        $createpayment = NewPaymentsClients::insertGetId([
            "BrandID" => $request->input('brandID'),
            "ClientID" => $request->input('clientID'),
            "ProjectID" => $request->input('project'),
            "ProjectManager" => $request->input('accountmanager'),
            "paymentNature" => $request->input('paymentNature'),
            "ChargingPlan" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
            "ChargingMode" => ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
            "Platform" => $request->input('platform'),
            "Card_Brand" => $request->input('cardBrand'),
            "Payment_Gateway" => $request->input('paymentgateway'),
            "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
            "TransactionID" => $request->input('transactionID'),
            "paymentDate" => $request->input('paymentdate'),
            // "futureDate"=> $request->input('nextpaymentdate'),
            "SalesPerson" => $request->input('saleperson'),
            "TotalAmount" => $request->input('totalamount'),
            "Paid" => $request->input('clientpaid'),
            "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
            "PaymentType" => $request->input('paymentType'),
            "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
            "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(['--']) : json_encode($request->input('shareProjectManager')),
            "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(['--']) : json_encode($request->input('splitamount')),
            "Description" => $request->input('description'),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s'),
            "refundStatus" => 'On Going',
            "remainingID" => $request->input('remainingID'),
            "remainingStatus" => $remainingstatus,
            "transactionType" => $transactionType,
            "transactionfee" => $request->input('transactionfee'),
            "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')

        ]);


        if ($paymentType == "Split Payment") {

            $paymentDescription = $findusername[0]->name . " Charge Remaining Payment For Client " . $findclient[0]->name;
            $totalamount = $request->input('totalamount');
            $amountShare = $request->input('splitamount');
            $sharedProjectManager = $request->input('shareProjectManager');
            $c = [];
            $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

            $createMainEmployeePayment  = EmployeePayment::create([
                "paymentID" => $createpayment,
                "employeeID" => $request->input('saleperson'),
                "paymentDescription" => $paymentDescription,
                "amount" => $amount
            ]);



            foreach ($sharedProjectManager as $key => $value) {
                $c[$key] = [$value, $amountShare[$key]];
            }

            foreach ($c as $SecondProjectManagers) {
                if ($SecondProjectManagers[0] != 0) {
                    $createSharedPersonEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $createpayment,
                            "employeeID" => $SecondProjectManagers[0],
                            "paymentDescription" => "Remaining(Payment) Amount Share By " . $findusername[0]->name,
                            "amount" =>  $SecondProjectManagers[1]
                        ]
                    );
                }
            }
        } else {

            $paymentDescription = $findusername[0]->name . " Charge Remaining Payment For Client " . $findclient[0]->name;
            $clientpaid = $request->input('clientpaid');



            $createEmployeePayment  = EmployeePayment::create(
                [
                    "paymentID" => $createpayment,
                    "employeeID" => $request->input('saleperson'),
                    "paymentDescription" =>  $paymentDescription,
                    "amount" =>   $clientpaid
                ]
            );
        }

        // return redirect('/client/details/' . $request->input('clientID'));
        return redirect('/client/project/payment/all');
    }



    function payment_pending_amount(Request $request, $id)
    {

        $loginUser = $this->roleExits($request);
        $mainPayment = NewPaymentsClients::where('id', $id)->get();
        $stripePayment = NewPaymentsClients::where('ClientID', $mainPayment[0]->ClientID)->where('remainingStatus', "Unlinked Payments")->get();

        $findproject = Project::where('id', $mainPayment[0]->ProjectID)->get();
        $findclient = Client::get();
        $findemployee = Employee::get();
        $allPayments = NewPaymentsClients::where('ClientID', $findproject[0]->ClientName->id)->get();

        return view('PendingPayment', [
            'mainPayments' => $mainPayment,
            'allPayments' => $allPayments,
            'id' => $id,
            'projectmanager' => $findproject,
            'clients' => $findclient,
            'employee' => $findemployee,
            'stripePayment' => $stripePayment,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }
    public function fetchstripeunlinkeddata(Request $request)
    {
        $data['paymentdata'] = NewPaymentsClients::where("id", $request->payment_id)->get();

        $cardbrand = $data['paymentdata'][0]->Card_Brand;
        $paymentgateway = $data['paymentdata'][0]->Payment_Gateway;
        $transactionID = $data['paymentdata'][0]->TransactionID;
        $paymentdate = $data['paymentdata'][0]->paymentDate;
        $clientpaid = $data['paymentdata'][0]->Paid;
        $description = $data['paymentdata'][0]->Description;
        $transactionfee = $data['paymentdata'][0]->transactionfee;

        $return_array = [
            "cardbrand" => $cardbrand,
            "paymentgateway" => $paymentgateway,
            "transactionID" => $transactionID,
            "paymentdate" => $paymentdate,
            "clientpaid" => $clientpaid,
            "description" => $description,
            "transactionfee" => $transactionfee
        ];

        return response()->json($return_array);
    }
    function payment_pending_amount_process(Request $request, $id)
    {

        $deleteexistingStripeUnlinked = NewPaymentsClients::where("TransactionID", $request->input('transactionID'))->delete();


        $paymentType = $request->input('paymentType');
        $paymentNature = $request->input('paymentNature');
        $findusername = DB::table('employees')->where('id', $request->input('accountmanager'))->get();
        $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
        $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
        if ($remainingamt == 0) {
            $remainingstatus = "Not Remaining";
        } else {
            $remainingstatus = "Remaining";
        }

        if ($request->file('bankWireUpload') != null) {
            $bookwire = $request->file('bankWireUpload')->store('Payment');
        } else {
            $bookwire = "--";
        }

        $transactionType = $request->input('paymentNature');


        if ($request->input('nextpaymentdate') != null) {

            $today = date('Y-m-d');
            if ($request->input('ChargingPlan') == "One Time Payment") {
                $date = null;
            } elseif ($request->input('ChargingPlan') == "Monthly") {
                $date = date('Y-m-d', strtotime('+1 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "2 Months") {
                $date = date('Y-m-d', strtotime('+2 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "3 Months") {
                $date = date('Y-m-d', strtotime('+3 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "4 Months") {
                $date = date('Y-m-d', strtotime('+4 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "5 Months") {
                $date = date('Y-m-d', strtotime('+5 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "6 Months") {
                $date = date('Y-m-d', strtotime('+6 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "7 Months") {
                $date = date('Y-m-d', strtotime('+7 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "8 Months") {
                $date = date('Y-m-d', strtotime('+8 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "9 Months") {
                $date = date('Y-m-d', strtotime('+9 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "10 Months") {
                $date = date('Y-m-d', strtotime('+10 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "11 Months") {
                $date = date('Y-m-d', strtotime('+11 month', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "12 Months") {
                $date = date('Y-m-d', strtotime('+1 Year', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "2 Years") {
                $date = date('Y-m-d', strtotime('+2 Year', strtotime($today)));
            } elseif ($request->input('ChargingPlan') == "3 Years") {
                $date = date('Y-m-d', strtotime('+3 Year', strtotime($today)));
            }

            $createpayment = NewPaymentsClients::iwhere('id', $id)->update([
                "ProjectManager" => $request->input('accountmanager'),
                "Platform" => $request->input('platform'),
                "Card_Brand" => $request->input('cardBrand'),
                "Payment_Gateway" => $request->input('paymentgateway'),
                "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                "TransactionID" => $request->input('transactionID'),
                "paymentDate" => $request->input('paymentdate'),
                "futureDate" => $request->input('nextpaymentdate'),
                "SalesPerson" => $request->input('saleperson'),
                "TotalAmount" => $request->input('totalamount'),
                "Paid" => $request->input('clientpaid'),
                "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                "PaymentType" => $request->input('paymentType'),
                "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(['--']) : json_encode($request->input('shareProjectManager')),
                "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(['--']) : json_encode($request->input('splitamount')),
                "Description" => $request->input('description'),
                'created_at' => date('y-m-d H:m:s'),
                'updated_at' => date('y-m-d H:m:s'),
                "refundStatus" => 'On Going',
                "remainingStatus" => $remainingstatus,
                "transactionfee" => $request->input('transactionfee'),
                "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')
                // "transactionType" => $transactionType

            ]);
        } else {

            $createpayment = NewPaymentsClients::where('id', $id)->update([
                "ProjectManager" => $request->input('accountmanager'),
                "Platform" => $request->input('platform'),
                "Card_Brand" => $request->input('cardBrand'),
                "Payment_Gateway" => $request->input('paymentgateway'),
                "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                "TransactionID" => $request->input('transactionID'),
                "paymentDate" => $request->input('paymentdate'),
                "SalesPerson" => $request->input('saleperson'),
                "TotalAmount" => $request->input('totalamount'),
                "Paid" => $request->input('clientpaid'),
                "RemainingAmount" => $request->input('totalamount') - $request->input('clientpaid'),
                "PaymentType" => $request->input('paymentType'),
                "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(['--']) : json_encode($request->input('shareProjectManager')),
                "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(['--']) : json_encode($request->input('splitamount')),
                "Description" => $request->input('description'),
                'created_at' => date('y-m-d H:m:s'),
                'updated_at' => date('y-m-d H:m:s'),
                "refundStatus" => 'On Going',
                "remainingStatus" => $remainingstatus,
                "transactionfee" => $request->input('transactionfee'),
                "amt_after_transactionfee" => $request->input('clientpaid') - $request->input('transactionfee')
                // "transactionType" => $transactionType

            ]);
        }

        if ($paymentType == "Split Payment") {

            $paymentDescription = $findusername[0]->name . " Charge Payment For Client " . $findclient[0]->name;
            $totalamount = $request->input('totalamount');
            $amountShare = $request->input('splitamount');
            $sharedProjectManager = $request->input('shareProjectManager');
            $c = [];
            $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

            $createMainEmployeePayment  = EmployeePayment::create([
                "paymentID" => $createpayment,
                "employeeID" => $request->input('accountmanager'),
                "paymentDescription" => $paymentDescription,
                "amount" => $amount
            ]);



            foreach ($sharedProjectManager as $key => $value) {
                $c[$key] = [$value, $amountShare[$key]];
            }

            foreach ($c as $SecondProjectManagers) {
                if ($SecondProjectManagers[0] != 0) {
                    $createSharedPersonEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $id,
                            "employeeID" => $SecondProjectManagers[0],
                            "paymentDescription" => "Amount Share By " . $findusername[0]->name,
                            "amount" =>  $SecondProjectManagers[1]
                        ]
                    );
                }
            }
        } else {

            $paymentDescription = $findusername[0]->name . " Charge Payment For Client " . $findclient[0]->name;
            $clientpaid = $request->input('clientpaid');



            $createEmployeePayment  = EmployeePayment::create(
                [
                    "paymentID" => $id,
                    "employeeID" => $request->input('accountmanager'),
                    "paymentDescription" =>  $paymentDescription,
                    "amount" =>   $clientpaid
                ]
            );
        }

        // $getTransactionstype = NewPaymentsClients::where('id', $id)->get();
        // $checkpendingTransactions = NewPaymentsClients::where('ClientID', $request->input('clientID'))->where('ProjectID', $request->input('project'))->where('refundStatus', "Pending Payment")->where('transactionType', $getTransactionstype[0]->transactionType)->count();
        // $clientPayment = NewPaymentsClients::where('id', 3)->first();

        // // Parse the dates using Carbon
        // $futureDate = Carbon::parse($clientPayment->futureDate);
        // $paymentDate = Carbon::parse($clientPayment->paymentDate);

        // // Calculate the difference
        // $difference = $futureDate->diffInDays($paymentDate);

        // if($futureDate > $paymentDate){
        //     $income = "Early";
        // }elseif($futureDate == $paymentDate){
        //     $income = "On Time";
        // }else{
        //     $income = "Delay";
        // }

        // // Output the difference
        // echo "The payment date is: " . $paymentDate;
        // echo("<br>");
        // echo "The future date is: " . $futureDate;
        // echo("<br>");
        // echo "The difference in days is: " . $difference;
        // echo("<br>");
        // echo "Delay/Early/OnTime: " . $income;
        // die();


        return redirect('/client/details/' . $request->input('clientID'));
    }



    function delete_payment(Request $request, $id)
    {

        $getpayment = DB::table('newpaymentsclients')->where('id', $id)->get();
        // echo("<pre>");
        // print_r($getpayment[0]->paymentNature);
        // die();

        if ($getpayment[0]->paymentNature == "New Lead" || $getpayment[0]->paymentNature == "New Sale" || $getpayment[0]->paymentNature == "Upsell") {

            $getRefundpayment = DB::table('refundtable')->where('PaymentID', $getpayment[0]->id)->delete();
            $getemployeepayment = DB::table('employeepayment')->where('paymentID', $getpayment[0]->id)->delete();
            $pendingpayments = DB::table('newpaymentsclients')->where('ClientID', $getpayment[0]->ClientID)->where('ProjectID', $getpayment[0]->ProjectID)->where('transactionType',  $getpayment[0]->transactionType)->where('refundStatus', 'Pending Payment')->delete();

            if ($getpayment[0]->remainingID != null) {
                $getpayments = DB::table('newpaymentsclients')->where('id', $id)->delete();
                $getpayments2 = DB::table('newpaymentsclients')->where('remainingID', $getpayment[0]->remainingID)->delete();
            } else {
                $getpayments = DB::table('newpaymentsclients')->where('id', $id)->delete();
            }
        } elseif ($getpayment[0]->paymentNature == "Remaining") {

            $getRefundpayment = DB::table('refundtable')->where('PaymentID', $getpayment[0]->id)->delete();
            $getemployeepayment = DB::table('employeepayment')->where('paymentID', $getpayment[0]->id)->delete();

            $getpayments = DB::table('newpaymentsclients')->where('id', $id)->delete();

            $client_payment = NewPaymentsClients::where('remainingID', $getpayment[0]->remainingID)->update([
                'remainingStatus' => "Remaining"
            ]);
        } else {

            $getRefundpayment = DB::table('refundtable')->where('PaymentID', $getpayment[0]->id)->delete();
            $getemployeepayment = DB::table('employeepayment')->where('paymentID', $getpayment[0]->id)->delete();

            $getpayments = DB::table('newpaymentsclients')->where('id', $id)->delete();
        }

        return redirect()->back();
    }



    function all_payments(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $client_payment = NewPaymentsClients::where('refundStatus', '!=', 'Pending Payment')->get();

        return view('allpayments', [
            'clientPayments' => $client_payment,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }
    function payment_view(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $client_payment = NewPaymentsClients::where('id', $id)->get();
        return view('payment_view', [
            'client_payment' => $client_payment,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }
    function payment_view1(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $client_payment = NewPaymentsClients::where('id', $id)->get();
        return view('payment_view1', [
            'client_payment' => $client_payment,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }


    function userreport(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $companies = Company::all();
        $brands = Brand::all();
        $departments = Department::all();
        $employees = Employee::all();
        $clients = Client::all();
        $projects = Project::all();


        return view('userreport', [
            'company' => $companies,
            'brand' => $brands,
            'department' => $departments,
            'employee' => $employees,
            'client' => $clients,
            'project' => $projects,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    // function clientPayment1(Request $request)
    // {

    //     $paymentType = $request->input('paymentType');
    //     $findusername = DB::table('employees')->where('id', $request->input('pmID'))->get();
    //     $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();


    //     if ($paymentType == "Split Payment") {
    //         $projectManager = $request->input('pmID');
    //         $amountShare = $request->input('splitamount');
    //         $SecondProjectManager = $request->input('shareProjectManager');
    //         $total =  $request->input('paidamount') - $amountShare;

    //         $createpayment = ClientPayment::insertGetId([
    //             "clientID"  => $request->input('clientID'),
    //             "projectID" => $request->input('project'),
    //             "paymentNature" => $request->input('paymentNature'),
    //             "clientPaid" => $request->input('paidamount'),
    //             "remainingPayment" => $request->input('remainingamount'),
    //             "paymentGateway" => $request->input('paymentgateway'),
    //             "paymentType" => $request->input('paymentType'),
    //             "ProjectManager" =>  $projectManager,
    //             "amountShare" => $amountShare,
    //         ]);

    //         $findusername = DB::table('employees')->where('id', $request->input('pmID'))->get();
    //         $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
    //         $paymentDescription = $findusername[0]->name . " Charge Payment For Client " . $findclient[0]->name;
    //         $createMainEmployeePayment  = EmployeePayment::create(
    //             [
    //                 "paymentID" => $createpayment,
    //                 "employeeID" => $request->input('pmID'),
    //                 "paymentDescription" => $findusername[0]->name . " Charge Payment For Client " . $findclient[0]->name,
    //                 "amount" =>     $total
    //             ],

    //         );

    //         $createSharedPersonEmployeePayment  = EmployeePayment::create(
    //             [
    //                 "paymentID" => $createpayment,
    //                 "employeeID" => $SecondProjectManager,
    //                 "paymentDescription" => "Amount Share By " . $findusername[0]->name,
    //                 "amount" =>  $amountShare
    //             ],
    //         );
    //     } else {
    //         $projectManager = $request->input('pmID');

    //         $total =  $request->input('paidamount');
    //         $createpayment = ClientPayment::insertGetId([
    //             "clientID"  => $request->input('clientID'),
    //             "projectID" => $request->input('project'),
    //             "paymentNature" => $request->input('paymentNature'),
    //             "clientPaid" => $request->input('paidamount'),
    //             "remainingPayment" => $request->input('remainingamount'),
    //             "paymentGateway" => $request->input('paymentgateway'),
    //             "paymentType" => $request->input('paymentType'),
    //             "ProjectManager" =>  $projectManager,
    //             "amountShare" => 0,
    //         ]);

    //         $createEmployeePayment  = EmployeePayment::create(
    //             [
    //                 "paymentID" => $createpayment,
    //                 "employeeID" => $request->input('pmID'),
    //                 "paymentDescription" => $findusername[0]->name . " Charge Payment For Client " . $findclient[0]->name,
    //                 "amount" =>  $total
    //             ]
    //         );
    //     }

    //     return "CHECK";
    // }

    function filledqaformIndv(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $qa_form = QAFORM::where('qaPerson', $loginUser[1][0]->id)->get();
        return view('filledqaform', [
            'qa_forms' => $qa_form,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function projectQaReport_view_without_backButton($id, Request $request)
    {
        $loginUser = $this->roleExits($request);
        $QA_FORM = QAFORM::where('id', $id)->get();
        $QA_META = QAFORM_METAS::where('formid', $QA_FORM[0]->qaformID)->get();
        $Proj_Prod = ProjectProduction::where('id', $QA_FORM[0]->ProjectProductionID)->get();
        return view('qa_form_view_without_backButton', [
            'qa_data' => $QA_FORM,
            'qa_meta' => $QA_META,
            'Proj_Prod' => $Proj_Prod,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function qaform(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brand = Brand::get();
        $department = Department::get();
        $employee = Employee::get();
        $project = Project::get();
        $client = Client::get();
        $qa_issues = QaIssues::get();
        $qarole = 0;
        return view('qaform', [
            'qarole' => $qarole,
            'brands' => $brand,
            'departments' => $department,
            'projects' => $project,
            'clients' => $client,
            'employees' => $employee,
            'qaissues' => $qa_issues,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function qaform_getproduction(Request $request)
    {
        $loginUser = $this->roleExits($request);
        return redirect('/forms/newqaform/' . $request->input('projectname'));
    }

    function qaform_prefilled_process(Request $request, $id)
    {
        $qaPerson = $request->session()->get('AdminUser');
        if ($request->input('status') == 'Not Started Yet') {
            $request->validate([
                'last_communication_with_client' => 'required',
                'Medium_of_communication' => 'required',
                'production_name' => 'required',
                'status' => 'required',
            ]);

            QAFORM::create([
                'clientID' => $request->input('clientID'),
                'projectID' => $request->input('projectID'),
                'projectmanagerID' => $request->input('projectmanagerID'),
                'brandID' => $request->input('brandID'),
                "qaformID" => $request->input('qaformID'),
                "ProjectProductionID" => $request->input('production_name'),
                "status" => $request->input('status'),
                "last_communication" =>   $request->input('last_communication_with_client'),
                "medium_of_communication" => json_encode($request->input('Medium_of_communication')),
                'client_satisfaction' => "--",
                'status_of_refund' => "--",
                'Refund_Requested' => "--",
                "Refund_Request_Attachment" => "--",
                "Refund_Request_summery" => "--",
                "qaPerson" => $qaPerson[0]->id,
            ]);
            return redirect()->back()->with('Success', "ADDED !");

            //return redirect('/forms/newqaform/' . $request->input('projectID'));
        } else {
            $request->validate([
                'last_communication_with_client' => 'required',
                'Medium_of_communication' => 'required',
                'production_name' => 'required',
                'status' => 'required',
                'issues' => 'required',
                'Description_of_issue' => 'required',
                'Refund_Request_summery' => 'required'
            ]);

            if ($request->file('Refund_Request_Attachment') != null) {

                $attachment = $request->file('Refund_Request_Attachment')->store('refundUpload');

                QAFORM::create([
                    'clientID' => $request->input('clientID'),
                    'projectID' => $request->input('projectID'),
                    'projectmanagerID' => $request->input('projectmanagerID'),
                    'brandID' => $request->input('brandID'),
                    "qaformID" => $request->input('qaformID'),
                    "ProjectProductionID" => $request->input('production_name'),
                    "status" => $request->input('status'),
                    "last_communication" =>   $request->input('last_communication_with_client'),
                    "medium_of_communication" => json_encode($request->input('Medium_of_communication')),
                    'client_satisfaction' => $request->input('client_satisfation'),
                    'status_of_refund' => $request->input('status_of_refund'),
                    'Refund_Requested' => $request->input('Refund_Requested'),
                    "Refund_Request_Attachment" => $attachment,
                    "Refund_Request_summery" => $request->input('Refund_Request_summery'),
                    "qaPerson" => $qaPerson[0]->id,
                ]);
            } else {

                QAFORM::create([
                    'clientID' => $request->input('clientID'),
                    'projectID' => $request->input('projectID'),
                    'projectmanagerID' => $request->input('projectmanagerID'),
                    'brandID' => $request->input('brandID'),
                    "qaformID" => $request->input('qaformID'),
                    "ProjectProductionID" => $request->input('production_name'),
                    "status" => $request->input('status'),
                    "last_communication" =>   $request->input('last_communication_with_client'),
                    "medium_of_communication" => json_encode($request->input('Medium_of_communication')),
                    'client_satisfaction' => $request->input('client_satisfation'),
                    'status_of_refund' => $request->input('status_of_refund'),
                    'Refund_Requested' => $request->input('Refund_Requested'),
                    "Refund_Request_Attachment" => "--",
                    "Refund_Request_summery" => $request->input('Refund_Request_summery'),
                    "qaPerson" => $qaPerson[0]->id,
                ]);
            }

            $production_id = $request->input('production_name');
            $production_data = ProjectProduction::where('id', $production_id)->get();

            if ($request->file('Evidence') != null) {

                $evidence = $request->file('Evidence')->store('uploads');


                $checkQA_META  = QAFORM_METAS::create([
                    'formid' =>  $request->input('qaformID'),
                    'departmant' => $production_data[0]->departmant,
                    'responsible_person' =>  $production_data[0]->responsible_person,
                    'status' => $request->input('status'),
                    "issues" => json_encode($request->input('issues')),
                    "Description_of_issue" => $request->input('Description_of_issue'),
                    "evidence" =>   $evidence
                ]);

                $qaform = QAFORM::where('qaformID', $request->input('qaformID'))->count();
                $qaform_meta = QAFORM_METAS::where('formid', $request->input('qaformID'))->count();

                if ($qaform > 0 && $qaform_meta > 0) {
                    return redirect()->back()->with('Success', "ADDED !");
                } else {
                    return redirect()->back()->with('Error', "META NOT ADDED");
                }
            } else {


                $checkQA_META  = QAFORM_METAS::create([
                    'formid' =>  $request->input('qaformID'),
                    'departmant' => $production_data[0]->departmant,
                    'responsible_person' => $production_data[0]->responsible_person,
                    'status' => $request->input('status'),
                    "issues" => json_encode($request->input('issues')),
                    "Description_of_issue" => $request->input('Description_of_issue'),
                    "evidence" => '--'
                ]);

                $qaform = QAFORM::where('qaformID', $request->input('qaformID'))->count();
                $qaform_meta = QAFORM_METAS::where('formid', $request->input('qaformID'))->count();

                if ($qaform > 0 && $qaform_meta > 0) {
                    return redirect()->back()->with('Success', "ADDED !");
                } elseif ($qaform > 0 && $qaform_meta == null) {
                    return redirect()->back()->with('Error', "META NOT ADDED");
                }
            }
        }
    }

    function new_qaform(Request $request, $ProjectID)
    {
        $loginUser = $this->roleExits($request);

        $allprojects = Project::where('id', $ProjectID)->get();
        $findclient = Client::where('id', $allprojects[0]->clientID)->get();
        $production = ProjectProduction::where('projectID', $allprojects[0]->productionID)->get();
        $recentClients = Client::where('id', '!=', $allprojects[0]->clientID)->limit(5)->get();
        $qa_issues = QaIssues::get();
        if (count($allprojects) > 0) {
            $findProject_Manager = Employee::where('id', $allprojects[0]->projectManager)->get();
        } else {
            $findProject_Manager = [];
        }
        return view('newqaform', [
            'client' => $findclient,
            'recentClients' => $recentClients,
            'projects' => $allprojects,
            'findProject_Manager' => $findProject_Manager,
            'productions' => $production,
            'qaissues' => $qa_issues,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function edit_new_qaform(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);

        $QA_FORM = QAFORM::where('id', $id)->get();
        $QA_META = QAFORM_METAS::where('formid', $QA_FORM[0]->qaformID)->get();
        $Proj_Prod = ProjectProduction::where('id', $QA_FORM[0]->ProjectProductionID)->get();
        $client = Client::where('id', $QA_FORM[0]->clientID)->get();
        $project = Project::where('id', $QA_FORM[0]->projectID)->get();
        $allproductions = projectProduction::where('projectID', $project[0]->productionID)->get();
        $recentClients = Client::where('id', '!=', $client[0]->id)->limit(5)->get();
        $allissues = QaIssues::get();
        return view('edit_newqaform', [
            'qa_data' => $QA_FORM,
            'qa_meta' => $QA_META,
            'Proj_Prod' => $Proj_Prod,
            'projects' => $project,
            'clients' => $client,
            'recentClients' => $recentClients,
            'productions' => $allproductions,
            'allissues' => $allissues,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function edit_new_qaform_process(Request $request, $id)
    {

        $qaform = QAFORM::where('id', $id)->get();
        $qaform_meta = QAFORM_METAS::where('formid', $qaform[0]->qaformID)->get();
        $qaPerson = $request->session()->get('AdminUser');

        $production_id = $request->input('production_name');
        $production_data = ProjectProduction::where('id', $production_id)->get();


        if ($qaform[0]->status == "Not Started Yet" && $request->input('status') != "Not Started Yet") {

            if ($request->input('Refund_Request_Attachment') == null) {

                QAFORM::where('id', $id)
                    ->update([
                        "ProjectProductionID" => $request->input('production_name'),
                        "status" => $request->input('status'),
                        "last_communication" =>   $request->input('last_communication_with_client'),
                        "medium_of_communication" => json_encode($request->input('Medium_of_communication')),
                        'client_satisfaction' => $request->input('client_satisfation'),
                        'status_of_refund' => $request->input('status_of_refund'),
                        'Refund_Requested' => $request->input('Refund_Requested'),
                        "Refund_Request_summery" => $request->input('Refund_Request_summery'),
                        "Refund_Request_Attachment" => "--",
                        "qaPerson" => $qaPerson[0]->id,
                    ]);
            } else {

                $attachment = $request->file('Refund_Request_Attachment')->store('refundUpload');

                QAFORM::where('id', $id)
                    ->update([
                        "ProjectProductionID" => $request->input('production_name'),
                        "status" => $request->input('status'),
                        "last_communication" =>   $request->input('last_communication_with_client'),
                        "medium_of_communication" => json_encode($request->input('Medium_of_communication')),
                        'client_satisfaction' => $request->input('client_satisfation'),
                        'status_of_refund' => $request->input('status_of_refund'),
                        'Refund_Requested' => $request->input('Refund_Requested'),
                        "Refund_Request_summery" => $request->input('Refund_Request_summery'),
                        "Refund_Request_Attachment" => $attachment,
                        "qaPerson" => $qaPerson[0]->id,
                    ]);
            };

            if ($request->input('Evidence') == null) {

                QAFORM_METAS::create([
                    'formid' =>  $qaform[0]->qaformID,
                    'departmant' => $production_data[0]->departmant,
                    'responsible_person' =>  $production_data[0]->responsible_person,
                    'status' => $request->input('status'),
                    "issues" => json_encode($request->input('issues')),
                    "Description_of_issue" => $request->input('Description_of_issue'),
                    "evidence" => "--",
                ]);

                return redirect('/client/project/qareport/' . $request->input('projectID'));
            } else {

                $evidence = $request->file('Evidence')->store('uploads');

                QAFORM_METAS::create([
                    'formid' =>  $qaform[0]->qaformID,
                    'departmant' => $production_data[0]->departmant,
                    'responsible_person' =>  $production_data[0]->responsible_person,
                    'status' => $request->input('status'),
                    "issues" => json_encode($request->input('issues')),
                    "Description_of_issue" => $request->input('Description_of_issue'),
                    "evidence" =>  $evidence
                ]);

                return redirect('/client/project/qareport/' . $request->input('projectID'));
            };
        } else {

            if ($request->hasFile('Refund_Request_Attachment')) {
                $path = storage_path('app/' . $qaform[0]->Refund_Request_Attachment);
                if (File::exists($path)) {

                    File::delete($path);
                    $attachment = $request->file('Refund_Request_Attachment')->store('refundUpload');
                    QAFORM::where('id', $id)
                        ->Update([
                            "Refund_Request_Attachment" => $attachment
                        ]);
                } else {
                    $attachment = $request->file('Refund_Request_Attachment')->store('refundUpload');
                    QAFORM::where('id', $id)
                        ->Update([
                            "Refund_Request_Attachment" => $attachment
                        ]);
                }
            };

            if ($request->hasFile('Evidence')) {
                $path_evid = storage_path('app/' . $qaform_meta[0]->evidence);
                if (File::exists($path_evid)) {
                    File::delete($path_evid);
                    $attachment_evid = $request->file('Evidence')->store('uploads');
                    QAFORM_METAS::where('id', $qaform_meta[0]->id)
                        ->Update([
                            "evidence" => $attachment_evid
                        ]);
                } else {
                    $attachment_evid = $request->file('Evidence')->store('uploads');
                    QAFORM_METAS::where('id', $qaform_meta[0]->id)
                        ->Update([
                            "evidence" => $attachment_evid
                        ]);
                }
            };




            if ($request->input('status') == 'Not Started Yet') {

                $delete_meta = DB::table('qaform_metas')->where('formid', $qaform[0]->qaformID)->delete();

                QAFORM::where('id', $id)
                    ->update([
                        "ProjectProductionID" => $request->input('production_name'),
                        "status" => $request->input('status'),
                        "last_communication" =>   $request->input('last_communication_with_client'),
                        "medium_of_communication" => json_encode($request->input('Medium_of_communication')),
                        'client_satisfaction' => "--",
                        'status_of_refund' => "--",
                        'Refund_Requested' => "--",
                        "Refund_Request_summery" => "--",
                        "Refund_Request_Attachment" => "--",
                        "qaPerson" => $qaPerson[0]->id,
                    ]);

                return redirect('/client/project/qareport/' . $request->input('projectID'));
            } else {

                if ($request->file('Refund_Request_Attachment') != null) {


                    QAFORM::where('id', $id)
                        ->update([
                            "ProjectProductionID" => $request->input('production_name'),
                            "status" => $request->input('status'),
                            "last_communication" =>   $request->input('last_communication_with_client'),
                            "medium_of_communication" => json_encode($request->input('Medium_of_communication')),
                            'client_satisfaction' => $request->input('client_satisfation'),
                            'status_of_refund' => $request->input('status_of_refund'),
                            'Refund_Requested' => $request->input('Refund_Requested'),
                            "Refund_Request_summery" => $request->input('Refund_Request_summery'),
                            "qaPerson" => $qaPerson[0]->id,
                        ]);
                } else {

                    QAFORM::where('id', $id)
                        ->update([
                            "ProjectProductionID" => $request->input('production_name'),
                            "status" => $request->input('status'),
                            "last_communication" =>   $request->input('last_communication_with_client'),
                            "medium_of_communication" => json_encode($request->input('Medium_of_communication')),
                            'client_satisfaction' => $request->input('client_satisfation'),
                            'status_of_refund' => $request->input('status_of_refund'),
                            'Refund_Requested' => $request->input('Refund_Requested'),
                            "Refund_Request_summery" => $request->input('Refund_Request_summery'),
                            "qaPerson" => $qaPerson[0]->id,
                        ]);
                }

                $production_id = $request->input('production_name');
                $production_data = ProjectProduction::where('id', $production_id)->get();

                if ($request->file('Evidence') != null) {




                    QAFORM_METAS::where('formid', $qaform[0]->qaformID)
                        ->update([
                            'departmant' => $production_data[0]->departmant,
                            'responsible_person' =>  $production_data[0]->responsible_person,
                            'status' => $request->input('status'),
                            "issues" => json_encode($request->input('issues')),
                            "Description_of_issue" => $request->input('Description_of_issue'),

                        ]);
                } else {


                    QAFORM_METAS::where('formid', $qaform[0]->qaformID)
                        ->update([
                            'departmant' => $production_data[0]->departmant,
                            'responsible_person' => $production_data[0]->responsible_person,
                            'status' => $request->input('status'),
                            "issues" => json_encode($request->input('issues')),
                            "Description_of_issue" => $request->input('Description_of_issue'),
                            "evidence" => '--'
                        ]);
                }

                return redirect('/client/project/qareport/' . $request->input('projectID'));
            }
        }
    }

    function new_qaform_delete(Request $request, $id)
    {
        $deleteqaform1 = DB::table('qaform')->where('id', $id)->get();
        $deleteqaformMetas = DB::table('qaform_metas')->where('formid', $deleteqaform1[0]->qaformID)->limit(1)->delete();
        $deleteqaform = DB::table('qaform')->where('id', $id)->delete();


        return redirect('/client/project/qareport/' . $deleteqaform1[0]->projectID);
    }

    function qaformclient(Request $request, $clientid)
    {
        $findBrand = Client::where('id', $clientid)->get();

        $bID  = $findBrand[0]->brand;
        $findBrandName = Brand::where('id', $bID)->get();
        echo $findBrandName[0]->name;
    }

    function projectQaReport(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $project = Project::where('id', $id)->get();
        $projectProduction = ProjectProduction::where('projectID', $project[0]->productionID)->get();
        $QA = QAFORM::where('projectID', $id)->get();
        return view('projectQA', [
            'projects' => $project,
            'productions' => $projectProduction,
            'qafroms' => $QA,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function projectQaReport_view($id, Request $request)
    {
        $loginUser = $this->roleExits($request);
        $QA_FORM = QAFORM::where('id', $id)->get();
        $QA_META = QAFORM_METAS::where('formid', $QA_FORM[0]->qaformID)->get();
        $Proj_Prod = ProjectProduction::where('id', $QA_FORM[0]->ProjectProductionID)->get();
        return view('qa_form_view', [
            'qa_data' => $QA_FORM,
            'qa_meta' => $QA_META,
            'Proj_Prod' => $Proj_Prod,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function qa_issues(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $department = Department::get();
        $qa_issues = QaIssues::get();
        return view('qa_issues', [
            'departments' => $department,
            "qa_issues" => $qa_issues,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function qa_issues_process(Request $request)
    {
        $qa_issues = QaIssues::create([
            "departmant" => $request->input("department"),
            "issues" => $request->input("issues"),

        ]);

        return redirect()->back()->with('Success', "Issue Added !");

        // return redirect('/settings/qa_issues');

    }

    function delete_qa_issues($id)
    {

        $deletedproduction = DB::table('qa_issues')->where('id', $id)->delete();

        return redirect('/settings/qa_issues');
    }

    function Production_services(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $department = Department::get();
        $statusDepartment = count($department);
        $ProductionServices = ProductionServices::get();
        return view('production_services', [
            'statusDepartment' => $statusDepartment,
            'departments' => $department,
            "ProductionServices" => $ProductionServices,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function Production_services_process(Request $request)
    {
        $ProductionServices = ProductionServices::create([
            "department" => $request->input("department"),
            "services" => $request->input("services"),

        ]);

        return redirect('/settings/Production/services');
    }

    function delete_Production_services($id)
    {

        $deletedproduction = DB::table('production_services')->where('id', $id)->delete();

        return redirect('/settings/Production/services');
    }

    function Assign_Client_to_qaperson(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $department = Department::get();
        $statusDepartment = count($department);
        $QaPersonClientAssigns = QaPersonClientAssign::get();
        $assignedclients = QaPersonClientAssign::select('client')->get();
        $user = Employee::get();
        // $clients = Client::whereNotIn('id', $assignedclients)->get();
        $clients = Client::get();

        return view('client_qaperson', [
            'statusDepartment' => $statusDepartment,
            'users' => $user,
            'clients' => $clients,
            'QaPersonClientAssigns' => $QaPersonClientAssigns,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function Assign_Client_to_qaperson_process(Request $request)
    {

        $qaperon_client = QaPersonClientAssign::create([
            "user" => $request->input('user'),
            "client" => $request->input('client'),

        ]);
        return redirect()->back()->with('Success', "Client Assigned Successfully !");
        // return redirect('/settings/user/client');
    }

    function Edit_Assign_Client_to_qaperson(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $department = Department::get();
        $QaPersonClientAssigns1 = QaPersonClientAssign::where('id', $id)->get();
        $QaPersonClientAssigns = QaPersonClientAssign::get();
        $user = Employee::get();
        $clients = Client::get();

        return view('edit_client_qaperson', [
            'users' => $user,
            'clients' => $clients,
            'QaPersonClientAssigns' => $QaPersonClientAssigns,
            'QaPersonClientAssigns1' => $QaPersonClientAssigns1,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function Edit_Assign_Client_to_qaperson_process(Request $request, $id)
    {

        $qaperon_client = QaPersonClientAssign::where('id', $id)
            ->update([
                "user" => $request->input('user'),

            ]);

        return redirect('/settings/user/client');
    }

    function delete_Assign_Client_to_qaperson($id)
    {

        $deletedproduction = DB::table('qaperson_client')->where('id', $id)->delete();

        return redirect('/settings/user/client');
    }

    function projectreport(Request $request, $id = null)
    {
        $loginUser = $this->roleExits($request);

        //left panel:
        $client = Client::get();
        $employee = Employee::get();
        $department = Department::get();
        $issue = QaIssues::get();
        $brand = Brand::get();

        //get:

        //BASE;
        $get_startdate = $request->input('startdate');
        $get_enddate = $request->input('enddate');
        //OPTIONAL;
        $get_brand = $request->input('brand');
        $get_projectmanager = $request->input('projectmanager');
        $get_client = $request->input('client');
        $get_Production = $request->input('Production');
        $get_employee = $request->input('employee');
        $get_status = $request->input('status');
        $get_remarks = $request->input('remarks');
        $get_expectedRefund = $request->input('expectedRefund');
        $get_issues = $request->input('issues');



        if ($get_startdate == null) {
            $role = 0;
            $result = 0;
            $get_brands = "--";
            $get_projectmanagers = "--";
            $get_clients = "--";
            $get_Productions = "--";
            $get_statuss = "--";
            $get_remarkss = "--";
            $get_expectedRefunds = "--";
            $get_issuess = "--";
        } else {

            $role = 1;
            $qaform = QAFORM::whereBetween('qaform.created_at', [$get_startdate, $get_enddate])->latest('qaform.created_at')->distinct('projectID');
            ($get_brand != 0)
                ? $qaform->where('brandID', $get_brand)
                : null;
            ($get_projectmanager != 0)
                ? $qaform->where('projectmanagerID', $get_projectmanager)
                : null;
            ($get_client != 0)
                ? $qaform->where('clientID', $get_client)
                : null;
            ($get_status != 0)
                ? $qaform->where('qaform.status', $get_status)
                : null;
            ($get_remarks != 0)
                ? $qaform->where('client_satisfaction', $get_remarks)
                : null;
            ($get_expectedRefund != 0)
                ? $qaform->where('status_of_refund', $get_expectedRefund)
                : null;
            ($get_Production != 0 || $get_employee != 0 || $get_issues != 0)
                ? $qaform->join('qaform_metas', 'qaform.qaformID', '=', 'qaform_metas.formid')
                : null;
            ($get_Production != 0)
                ? $qaform->where('qaform_metas.departmant', $get_Production)
                : null;
            ($get_issues != 0)
                ? $qaform->whereJsonContains('qaform_metas.issues', $get_issues)
                : null;
            ($get_Production != 0 || $get_employee != 0 || $get_issues != 0)
                ? $qaform->select('qaform.id as mainID', 'qaform.*', 'qaform_metas.*')
                : $qaform->select('qaform.id as mainID', 'qaform.*');

            $result = $qaform->get();



            if ($get_brand != 0) {
                $getbrands = Brand::where('id', $get_brand)->get();
                $get_brands = $getbrands[0]->name;
            } else {
                $get_brands = "--";
            }

            if ($get_projectmanager != 0) {
                $getprojectmanagers = Employee::where('id', $get_projectmanager)->get();
                $get_projectmanagers = $getprojectmanagers[0]->name;
            } else {
                $get_projectmanagers = "--";
            }

            if ($get_client != 0) {
                $getclients = Client::where('id', $get_client)->get();
                $get_clients = $getclients[0]->name;
            } else {
                $get_clients = "--";
            }

            if ($get_Production != 0) {
                $getProductions = Department::where('id', $get_Production)->get();
                $get_Productions = $getProductions[0]->name;
            } else {
                $get_Productions = "--";
            }

            if ($get_status != 0) {
                $get_statuss = $get_status;
            } else {
                $get_statuss = "--";
            }

            if ($get_remarks != 0) {
                $get_remarkss = $get_remarks;
            } else {
                $get_remarkss = "--";
            }

            if ($get_expectedRefund != 0) {
                $get_expectedRefunds = $get_expectedRefund;
            } else {
                $get_expectedRefunds = "--";
            }

            if ($get_issues != 0) {
                $get_issuess = $get_issues;
            } else {
                $get_issuess = "--";
            }


            // echo('<pre>');
            // echo($status_OnGoing);
            // die();

        }

        return view('report_home', [
            'clients' => $client,
            'employees' => $employee,
            'departments' => $department,
            'issues' => $issue,
            'brands' => $brand,
            'roles' => $role,
            'qaforms' => $result,
            'gets_brand' => $get_brands,
            'gets_projectmanager' => $get_projectmanagers,
            'gets_client' => $get_clients,
            'gets_Production' => $get_Productions,
            'gets_status' => $get_statuss,
            'gets_remarks' => $get_remarkss,
            'gets_expectedRefund' => $get_expectedRefunds,
            'gets_issues' => $get_issuess,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function newprojectreport(Request $request, $id = null)
    {
        $loginUser = $this->roleExits($request);

        //left panel:
        $client = Client::get();
        $employee = Employee::get();
        $department = Department::get();
        $issue = QaIssues::get();
        $brand = Brand::get();

        //get:

        //BASE;
        $get_startdate = $request->input('startdate');
        $get_enddate = $request->input('enddate');
        //OPTIONAL;
        $get_brand = $request->input('brand');
        $get_projectmanager = $request->input('projectmanager');
        $get_client = $request->input('client');
        $get_Production = $request->input('Production');
        $get_employee = $request->input('employee');
        $get_status = $request->input('status');
        $get_remarks = $request->input('remarks');
        $get_expectedRefund = $request->input('expectedRefund');
        $get_issues = $request->input('issues');



        if ($get_startdate == null) {
            $role = 0;
            $result = 0;
        } else {

            $role = 1;
            $qaform = QAFORM::whereBetween('qaform.created_at', [$get_startdate, $get_enddate])->latest('qaform.created_at')->distinct('projectID');
            ($get_brand != 0)
                ? $qaform->where('brandID', $get_brand)
                : null;
            ($get_projectmanager != 0)
                ? $qaform->where('projectmanagerID', $get_projectmanager)
                : null;
            ($get_client != 0)
                ? $qaform->where('clientID', $get_client)
                : null;
            ($get_status != 0)
                ? $qaform->where('qaform.status', $get_status)
                : null;
            ($get_remarks != 0)
                ? $qaform->where('client_satisfaction', $get_remarks)
                : null;
            ($get_expectedRefund != 0)
                ? $qaform->where('status_of_refund', $get_expectedRefund)
                : null;
            ($get_Production != 0 || $get_employee != 0 || $get_issues != 0)
                ? $qaform->join('qaform_metas', 'qaform.qaformID', '=', 'qaform_metas.formid')
                : null;
            ($get_Production != 0)
                ? $qaform->where('qaform_metas.departmant', $get_Production)
                : null;
            ($get_issues != 0)
                ? $qaform->whereJsonContains('qaform_metas.issues', $get_issues)
                : null;
            ($get_Production != 0 || $get_employee != 0 || $get_issues != 0)
                ? $qaform->select('qaform.id as mainID', 'qaform.*', 'qaform_metas.*')
                : $qaform->select('qaform.id as mainID', 'qaform.*');

            $result = $qaform->get();
        }

        return view('new_qaReport', [
            'clients' => $client,
            'employees' => $employee,
            'departments' => $department,
            'issues' => $issue,
            'brands' => $brand,
            'roles' => $role,
            'qaforms' => $result,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function revenuereport(Request $request, $id = null)
    {
        $loginUser = $this->roleExits($request);

        //left panel:
        $client = Client::get();
        $employee = Employee::get();
        $department = Department::get();
        $issue = QaIssues::get();
        $brand = Brand::get();

        //BASE;
        $get_startdate = $request->input('startdate');
        $get_enddate = $request->input('enddate');
        //OPTIONAL;
        $get_type = $request->input('type');
        $get_brand = $request->input('brand');
        $get_projectmanager = $request->input('projectmanager');
        $get_client = $request->input('client');
        if ($request->input('status') == 'Dispute') {
            $get_dispute = $request->input('status');
            $get_status = 0;
        } else {
            $get_status = $request->input('status');
            $get_dispute = 0;
        }
        $get_chargingMode = $request->input('chargingMode');
        $get_paymentNature = $request->input('paymentNature');

        if ($get_startdate == null) {
            $role = 0;
            $result = 0;
            $get_types = "--";
            $get_brands = "--";
            $get_projectmanagers = "--";
            $get_clients = "--";
            $get_statuss = "--";
            $get_chargingModes = "--";
            $get_paymentNatures = "--";
        } else {

            $role = 1;
            if ($get_type == "Received") {
                $payment = NewPaymentsClients::whereBetween('created_at', [$get_startdate, $get_enddate])->where('refundStatus', '!=', 'Pending Payment')->where('remainingStatus', '!=', 'Unlinked Payments');
                ($get_brand != 0)
                    ? $payment->where('BrandID', $get_brand)
                    : null;
                ($get_chargingMode != 0)
                    ? $payment->where('ChargingMode', $get_chargingMode)
                    : null;
                ($get_paymentNature != 0)
                    ? $payment->where('paymentNature', $get_paymentNature)
                    : null;
                ($get_projectmanager != 0)
                    ? $payment->where('SalesPerson', $get_projectmanager)
                    : null;
                ($get_client != 0)
                    ? $payment->where('ClientID', $get_client)
                    : null;
                ($get_status != 0)
                    ? $payment->where('refundStatus', $get_status)
                    : null;
                ($get_dispute != 0)
                    ? $payment->where('dispute', $get_dispute)
                    : null;

                $result = $payment->get();
            } elseif ($get_type == "Upcoming") {

                $payment = NewPaymentsClients::whereBetween('futureDate', [$get_startdate, $get_enddate])->where('paymentDate', null);
                ($get_brand != 0)
                    ? $payment->where('brandID', $get_brand)
                    : null;
                ($get_chargingMode != 0)
                    ? $payment->where('ChargingMode', $get_chargingMode)
                    : null;
                ($get_paymentNature != 0)
                    ? $payment->where('paymentNature', $get_paymentNature)
                    : null;
                ($get_projectmanager != 0)
                    ? $payment->where('SalesPerson', $get_projectmanager)
                    : null;
                ($get_client != 0)
                    ? $payment->where('clientID', $get_client)
                    : null;
                ($get_status != 0)
                    ? $payment->where('refundStatus', $get_status)
                    : null;
                ($get_dispute != 0)
                    ? $payment->where('dispute', $get_dispute)
                    : null;

                $result = $payment->get();
            } elseif ($get_type == "Missed") {

                $payment = NewPaymentsClients::whereBetween('futureDate', [$get_startdate, $get_enddate])->where('futureDate', '<', $get_enddate)->where('paymentDate', null);
                ($get_brand != 0)
                    ? $payment->where('brandID', $get_brand)
                    : null;
                ($get_chargingMode != 0)
                    ? $payment->where('ChargingMode', $get_chargingMode)
                    : null;
                ($get_paymentNature != 0)
                    ? $payment->where('paymentNature', $get_paymentNature)
                    : null;
                ($get_projectmanager != 0)
                    ? $payment->where('SalesPerson', $get_projectmanager)
                    : null;
                ($get_client != 0)
                    ? $payment->where('clientID', $get_client)
                    : null;
                ($get_status != 0)
                    ? $payment->where('refundStatus', $get_status)
                    : null;
                ($get_dispute != 0)
                    ? $payment->where('dispute', $get_dispute)
                    : null;

                $result = $payment->get();
            } else {
                $result = 0;
            }


            if ($get_type != 0) {
                $get_types = $get_type;
            } else {
                $get_types = "--";
            }

            if ($get_brand != 0) {
                $getbrands = Brand::where('id', $get_brand)->get();
                $get_brands = $getbrands[0]->name;
            } else {
                $get_brands = "--";
            }

            if ($get_chargingMode != 0) {
                $get_chargingModes = $get_chargingMode;
            } else {
                $get_chargingModes = "--";
            }

            if ($get_paymentNature != 0) {
                $get_paymentNatures = $get_paymentNature;
            } else {
                $get_paymentNatures = "--";
            }

            if ($get_projectmanager != 0) {
                $getprojectmanagers = Employee::where('id', $get_projectmanager)->get();
                $get_projectmanagers = $getprojectmanagers[0]->name;
            } else {
                $get_projectmanagers = "--";
            }

            if ($get_client != 0) {
                $getclients = Client::where('id', $get_client)->get();
                $get_clients = $getclients[0]->name;
            } else {
                $get_clients = "--";
            }

            if ($get_status != 0 || $get_dispute != 0) {
                if ($get_status != 0) {
                    $get_statuss = $get_status;
                } else {
                    $get_statuss = "Dispute";
                }
            } else {
                $get_statuss = "--";
            }


            // echo('<pre>');
            // echo($status_OnGoing);
            // die();

        }

        return view('revenue_Report', [
            'clients' => $client,
            'employees' => $employee,
            'departments' => $department,
            'issues' => $issue,
            'brands' => $brand,
            'get_chargingModes' => $get_chargingModes,
            'get_paymentNatures' => $get_paymentNatures,
            'roles' => $role,
            'qaforms' => $result,
            'get_types' => $get_types,
            'gets_brand' => $get_brands,
            'gets_projectmanager' => $get_projectmanagers,
            'gets_client' => $get_clients,
            'gets_status' => $get_statuss,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function new_revenuereport(Request $request, $id = null)
    {

        $loginUser = $this->roleExits($request);

        //left panel:
        $client = Client::get();
        $employee = Employee::get();
        $department = Department::get();
        $issue = QaIssues::get();
        $brand = Brand::get();

        //BASE;
        $get_startdate = $request->input('startdate');
        $get_enddate = $request->input('enddate');
        //OPTIONAL;
        $get_type = $request->input('type');
        $get_brand = $request->input('brand');
        $get_projectmanager = $request->input('projectmanager');
        $get_client = $request->input('client');
        if ($request->input('status') == 'Dispute') {
            $get_dispute = $request->input('status');
            $get_status = 0;
        } else {
            $get_status = $request->input('status');
            $get_dispute = 0;
        }
        $get_chargingMode = $request->input('chargingMode');
        $get_paymentNature = $request->input('paymentNature');

        if ($get_startdate == null) {
            $role = 0;
            $result = 0;
            $newtotalamt = 0;
            $newtotalamtpaid = 0;
        } else {


            $role = 1;
            if ($get_type == "Received") {

                // if($request->input('status') == 'Dispute'){
                //     $payment = NewPaymentsClients::whereBetween('disputeattack', [$get_startdate, $get_enddate])->where('refundStatus', '!=', 'Pending Payment')->where('remainingStatus', '!=', 'Unlinked Payments');
                // }else{
                //     $payment = NewPaymentsClients::whereBetween('paymentDate', [$get_startdate, $get_enddate])->where('refundStatus', '!=', 'Pending Payment')->where('remainingStatus', '!=', 'Unlinked Payments');
                // }

                $payment = NewPaymentsClients::whereBetween('paymentDate', [$get_startdate, $get_enddate])->where('refundStatus', '!=', 'Pending Payment')->where('remainingStatus', '!=', 'Unlinked Payments');
                ($get_brand != 0)
                    ? $payment->where('BrandID', $get_brand)
                    : null;
                ($get_chargingMode != 0)
                    ? $payment->where('ChargingMode', $get_chargingMode)
                    : null;
                ($get_paymentNature != 0)
                    ? $payment->where('paymentNature', $get_paymentNature)
                    : null;
                ($get_projectmanager != 0)
                    ? $payment->where('SalesPerson', $get_projectmanager)
                    : null;
                ($get_client != 0)
                    ? $payment->where('ClientID', $get_client)
                    : null;
                ($get_status != 0)
                    ? $payment->where('refundStatus', $get_status)
                    : null;
                ($get_dispute != 0)
                    ? $payment->where('dispute', $get_dispute)
                    : null;

                $result = $payment->get();

                $amt = NewPaymentsClients::whereBetween('paymentDate', [$get_startdate, $get_enddate])->where('refundStatus', '!=', 'Pending Payment')->where('remainingStatus', '!=', 'Unlinked Payments')->where('paymentNature', '!=', 'Remaining');
                ($get_brand != 0)
                    ? $amt->where('BrandID', $get_brand)
                    : null;
                ($get_chargingMode != 0)
                    ? $amt->where('ChargingMode', $get_chargingMode)
                    : null;
                ($get_paymentNature != 0 && $get_paymentNature != "Remaining")
                    ? $amt->where('paymentNature', $get_paymentNature)
                    : null;
                ($get_projectmanager != 0)
                    ? $amt->where('SalesPerson', $get_projectmanager)
                    : null;
                ($get_client != 0)
                    ? $amt->where('ClientID', $get_client)
                    : null;
                ($get_status != 0)
                    ? $amt->where('refundStatus', $get_status)
                    : null;
                ($get_dispute != 0)
                    ? $amt->where('dispute', $get_dispute)
                    : null;

                $newtotalamt = $amt->sum('TotalAmount');

                $amtpaid = NewPaymentsClients::whereBetween('paymentDate', [$get_startdate, $get_enddate])->where('refundStatus', '!=', 'Pending Payment')->where('remainingStatus', '!=', 'Unlinked Payments');
                ($get_brand != 0)
                    ? $amtpaid->where('BrandID', $get_brand)
                    : null;
                ($get_chargingMode != 0)
                    ? $amtpaid->where('ChargingMode', $get_chargingMode)
                    : null;
                ($get_paymentNature != 0 && $get_paymentNature != "Remaining")
                    ? $amtpaid->where('paymentNature', $get_paymentNature)
                    : null;
                ($get_projectmanager != 0)
                    ? $amtpaid->where('SalesPerson', $get_projectmanager)
                    : null;
                ($get_client != 0)
                    ? $amtpaid->where('ClientID', $get_client)
                    : null;
                ($get_status != 0)
                    ? $amtpaid->where('refundStatus', $get_status)
                    : null;
                ($get_dispute != 0)
                    ? $amtpaid->where('dispute', $get_dispute)
                    : null;

                // if($request->input('status') == 'Dispute'){
                //     $newtotalamtpaid = $amtpaid->sum('disputeattackamount');
                // }else{
                //     $newtotalamtpaid = $amtpaid->sum('Paid');
                // }
                $newtotalamtpaid = $amtpaid->sum('Paid');
            } elseif ($get_type == "Upcoming") {

                $payment = NewPaymentsClients::whereBetween('futureDate', [$get_startdate, $get_enddate]);
                ($get_brand != 0)
                    ? $payment->where('brandID', $get_brand)
                    : null;
                ($get_chargingMode != 0)
                    ? $payment->where('ChargingMode', $get_chargingMode)
                    : null;
                ($get_paymentNature != 0)
                    ? $payment->where('paymentNature', $get_paymentNature)
                    : null;
                ($get_projectmanager != 0)
                    ? $payment->where('SalesPerson', $get_projectmanager)
                    : null;
                ($get_client != 0)
                    ? $payment->where('clientID', $get_client)
                    : null;
                ($get_status != 0)
                    ? $payment->where('refundStatus', $get_status)
                    : null;
                ($get_dispute != 0)
                    ? $payment->where('dispute', $get_dispute)
                    : null;

                $result = $payment->get();

                $amt = NewPaymentsClients::whereBetween('futureDate', [$get_startdate, $get_enddate])->where('refundStatus', '!=', 'Pending Payment')->where('remainingStatus', '!=', 'Unlinked Payments')->where('paymentNature', '!=', 'Remaining');
                ($get_brand != 0)
                    ? $amt->where('BrandID', $get_brand)
                    : null;
                ($get_chargingMode != 0)
                    ? $amt->where('ChargingMode', $get_chargingMode)
                    : null;
                ($get_paymentNature != 0 && $get_paymentNature != "Remaining")
                    ? $amt->where('paymentNature', $get_paymentNature)
                    : null;
                ($get_projectmanager != 0)
                    ? $amt->where('SalesPerson', $get_projectmanager)
                    : null;
                ($get_client != 0)
                    ? $amt->where('ClientID', $get_client)
                    : null;
                ($get_status != 0)
                    ? $amt->where('refundStatus', $get_status)
                    : null;
                ($get_dispute != 0)
                    ? $amt->where('dispute', $get_dispute)
                    : null;

                $newtotalamt = $amt->sum('TotalAmount');

                $amtpaid = NewPaymentsClients::whereBetween('futureDate', [$get_startdate, $get_enddate])->where('refundStatus', '!=', 'Pending Payment')->where('remainingStatus', '!=', 'Unlinked Payments');
                ($get_brand != 0)
                    ? $amtpaid->where('BrandID', $get_brand)
                    : null;
                ($get_chargingMode != 0)
                    ? $amtpaid->where('ChargingMode', $get_chargingMode)
                    : null;
                ($get_paymentNature != 0 && $get_paymentNature != "Remaining")
                    ? $amtpaid->where('paymentNature', $get_paymentNature)
                    : null;
                ($get_projectmanager != 0)
                    ? $amtpaid->where('SalesPerson', $get_projectmanager)
                    : null;
                ($get_client != 0)
                    ? $amtpaid->where('ClientID', $get_client)
                    : null;
                ($get_status != 0)
                    ? $amtpaid->where('refundStatus', $get_status)
                    : null;
                ($get_dispute != 0)
                    ? $amtpaid->where('dispute', $get_dispute)
                    : null;

                $newtotalamtpaid = $amtpaid->sum('Paid');
            } elseif ($get_type == "Missed") {

                $payment = NewPaymentsClients::whereBetween('futureDate', [$get_startdate, $get_enddate])->where('futureDate', '<', $get_enddate)->where('paymentDate', null);
                ($get_brand != 0)
                    ? $payment->where('brandID', $get_brand)
                    : null;
                ($get_chargingMode != 0)
                    ? $payment->where('ChargingMode', $get_chargingMode)
                    : null;
                ($get_paymentNature != 0)
                    ? $payment->where('paymentNature', $get_paymentNature)
                    : null;
                ($get_projectmanager != 0)
                    ? $payment->where('SalesPerson', $get_projectmanager)
                    : null;
                ($get_client != 0)
                    ? $payment->where('clientID', $get_client)
                    : null;
                ($get_status != 0)
                    ? $payment->where('refundStatus', $get_status)
                    : null;
                ($get_dispute != 0)
                    ? $payment->where('dispute', $get_dispute)
                    : null;

                $result = $payment->get();

                // $totalamt = NewPaymentsClients::whereBetween('futureDate', [$get_startdate, $get_enddate])->where('futureDate', '<', $get_enddate)->where('paymentDate', null)->where('paymentNature','!=','Remaining')->sum('TotalAmount');
                // $totalpaid = NewPaymentsClients::whereBetween('futureDate', [$get_startdate, $get_enddate])->where('futureDate', '<', $get_enddate)->where('paymentDate', null)->sum('Paid');

                $amt = NewPaymentsClients::whereBetween('futureDate', [$get_startdate, $get_enddate])->where('refundStatus', '!=', 'Pending Payment')->where('remainingStatus', '!=', 'Unlinked Payments')->where('paymentNature', '!=', 'Remaining');
                ($get_brand != 0)
                    ? $amt->where('BrandID', $get_brand)
                    : null;
                ($get_chargingMode != 0)
                    ? $amt->where('ChargingMode', $get_chargingMode)
                    : null;
                ($get_paymentNature != 0 && $get_paymentNature != "Remaining")
                    ? $amt->where('paymentNature', $get_paymentNature)
                    : null;
                ($get_projectmanager != 0)
                    ? $amt->where('SalesPerson', $get_projectmanager)
                    : null;
                ($get_client != 0)
                    ? $amt->where('ClientID', $get_client)
                    : null;
                ($get_status != 0)
                    ? $amt->where('refundStatus', $get_status)
                    : null;
                ($get_dispute != 0)
                    ? $amt->where('dispute', $get_dispute)
                    : null;

                $newtotalamt = $amt->sum('TotalAmount');

                $amtpaid = NewPaymentsClients::whereBetween('futureDate', [$get_startdate, $get_enddate])->where('refundStatus', '!=', 'Pending Payment')->where('remainingStatus', '!=', 'Unlinked Payments');
                ($get_brand != 0)
                    ? $amtpaid->where('BrandID', $get_brand)
                    : null;
                ($get_chargingMode != 0)
                    ? $amtpaid->where('ChargingMode', $get_chargingMode)
                    : null;
                ($get_paymentNature != 0 && $get_paymentNature != "Remaining")
                    ? $amtpaid->where('paymentNature', $get_paymentNature)
                    : null;
                ($get_projectmanager != 0)
                    ? $amtpaid->where('SalesPerson', $get_projectmanager)
                    : null;
                ($get_client != 0)
                    ? $amtpaid->where('ClientID', $get_client)
                    : null;
                ($get_status != 0)
                    ? $amtpaid->where('refundStatus', $get_status)
                    : null;
                ($get_dispute != 0)
                    ? $amtpaid->where('dispute', $get_dispute)
                    : null;

                $newtotalamtpaid = $amtpaid->sum('Paid');
            } else {
                $result = 0;
                $newtotalamt = 0;
                $newtotalamtpaid = 0;
            }
        }

        return view('new_revenueReport', [
            'clients' => $client,
            'employees' => $employee,
            'departments' => $department,
            'issues' => $issue,
            'brands' => $brand,
            'roles' => $role,
            'qaforms' => $result,
            'newtotalamt' => $newtotalamt,
            'newtotalamtpaid' => $newtotalamtpaid,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function clientReport(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $client = Client::where('id', $id)->get();
        $project = Project::where('clientID', $id)->get();
        $projectcount = count($project);
        $qaform = QAFORM::where('clientID', $id)->get();
        $qaformcount = count($qaform);
        $qaformlast = QAFORM::where('clientID', $id)->whereMonth('created_at', now())->latest('created_at')->get();
        $clientpayments = NewPaymentsClients::where('ClientID', $id)->get();
        $clientpaymentscount = count($clientpayments);

        return view('clientReport', [
            'clients' => $client,
            'projects' => $project,
            'qaforms' => $qaform,
            'qaformlasts' => $qaformlast,
            'qaformcount' => $qaformcount,
            'projectcount' => $projectcount,
            'clientpayments' => $clientpayments,
            'clientpaymentscount' => $clientpaymentscount,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    public function fetchRecord(Request $request)
    {
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );
        $chargeID = $request['ID'];
        try {
            $details = $stripe->charges->retrieve($chargeID, []);
            $return_array = [
                "status" => 200,
                "message" => $details,
            ];
            http_response_code(200);
            $return_str = json_encode($return_array);
            return $return_str;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            $return_array = [
                "status" => $e->getHttpStatus(),
                "type" => $e->getError()->type,
                "code" => $e->getError()->code,
                "param" => $e->getError()->param,
                "message" => $e->getError()->message,
            ];
            $return_str = json_encode($return_array);
            http_response_code($e->getHttpStatus());
            return $return_str;
        }
    }

    function new_payments(Request $request)
    {

        $loginUser = $this->roleExits($request);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $details = $stripe->charges->all(['limit' => 50]);
        $allpayments = NewPaymentsClients::get();
        $allprojects = Project::get();

        $unlinkedpayments = [];

        // Iterate through each detail
        foreach ($details as $detail) {
            $matched = false;

            // Iterate through each payment
            foreach ($allpayments as $payment) {
                // Check if the IDs match
                if ($detail->id == $payment->TransactionID) {
                    $matched = true;
                    break; // No need to check further payments if matched
                }
            }

            // If the detail ID was not matched with any payment, add it to unlinkedpayments
            if (!$matched) {
                $unlinkedpayments[] = $detail;
            }
        }





        // print_r($unlinkedpayments);

        return view('newpayments_formStripe', [
            'allprojects' => $allprojects,
            'details' => $unlinkedpayments,
            'allpayments' => $unlinkedpayments,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function new_payments_process(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $transactionID = $request->input('transactionID');

        $findclient = Client::get();
        $findproject = Project::get();
        $findemployee = Employee::get();

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        $details = $stripe->charges->retrieve($transactionID, []);

        // echo("<pre>");
        // print_r($details['billing_details']['email']);
        // print_r($details);
        // die();



        return view('payment_transactionData', [
            'findproject' => $findproject,
            'projectmanager' => $findproject,
            'clients' => $findclient,
            'employee' => $findemployee,
            'details' => $details,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    public function fetchprojects(Request $request)
    {
        $data['projects'] = Project::where("clientID", $request->country_id)
            ->get(["name", "id"]);

        return response()->json($data);
    }

    public function fetchprojectdata(Request $request)
    {
        $data['projectdata'] = Project::where("id", $request->state_id)
            ->get();
        $projectmanagername = $data['projectdata'][0]->EmployeeName->name;
        $projectmanagerid = $data['projectdata'][0]->EmployeeName->id;
        $clientname = $data['projectdata'][0]->ClientName->frontsale->name;
        $clientid = $data['projectdata'][0]->ClientName->frontsale->id;

        $return_array = [
            "pmid" => $projectmanagerid,
            "pmname" => $projectmanagername,
            "clientid" => $clientid,
            "clientname" => $clientname,
        ];

        return response()->json($return_array);
    }

    public function ajax_username(Request $request)
    {
        $data['projectdata'] = Employee::where("id", $request->state_id)
            ->get();
        $projectmanagername = $data['projectdata'][0]->name;

        $return_array = [
            "pmname" => $projectmanagername,
        ];

        return response()->json($return_array);
    }

    function csv_stripepayments(Request $request)
    {
        $loginUser = $this->roleExits($request);
        return view('paymentUpload', [
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function csv_stripepayments_process(Request $request)
    {
        $data = Excel::toArray([], $request->file('stripepayments'));
        $stripepaymentsall = [];
        $newArray = array();
        foreach ($data as $extractData) {
            $headings = $extractData[0];
            $keycount = count($headings);
            $maincount = count($extractData);

            for ($j = 1; $j < $maincount; $j++) {
                $newarray = [];
                for ($i = 0; $i < $keycount; $i++) {
                    $newarray[$headings[$i]] = $extractData[$j][$i];
                }
                $checktransactionID = NewPaymentsClients::where('TransactionID', $newarray['id'])->count();
                if ($checktransactionID == 0) {
                    $sql_date = date("Y-m-d", strtotime($newarray['Created date (UTC)']));
                    $sql_date_dispute = date("Y-m-d", strtotime($newarray['Dispute Date (UTC)']));
                    if ($newarray['Status'] == 'Paid') {
                        if ($newarray['Dispute Status'] == null) {
                            $matchclientmeta = Clientmeta::wherejsoncontains('otheremail', ($newarray['Customer Email']))->get();
                            if ($matchclientmeta->isNotEmpty()) {
                                $findclient = Client::where('id', $matchclientmeta[0]->clientID)->get();
                                $count = count($findclient);
                                if ($count == 1) {
                                    $createClientPayment = NewPaymentsClients::create([
                                        "BrandID" => $findclient[0]->brand,
                                        "ClientID" => $findclient[0]->id,
                                        "ProjectID" => 0,
                                        "ProjectManager" => 0,
                                        "paymentNature" => "--",
                                        "ChargingPlan" => "--",
                                        "ChargingMode" => "--",
                                        "Platform" => "--",
                                        "Card_Brand" => $newarray['Card Brand'],
                                        "Payment_Gateway" => "Stripe",
                                        "bankWireUpload" =>  "--",
                                        "TransactionID" => $newarray['id'],
                                        "paymentDate" => $sql_date,
                                        "SalesPerson" => 0,
                                        "TotalAmount" => 0,
                                        "Paid" => $newarray['Converted Amount'],
                                        "RemainingAmount" => 0,
                                        "PaymentType" => "--",
                                        "numberOfSplits" => "--",
                                        "SplitProjectManager" => json_encode("--"),
                                        "ShareAmount" => json_encode("--"),
                                        "Description" => $newarray['Description'],
                                        'created_at' => date('y-m-d H:m:s'),
                                        'updated_at' => date('y-m-d H:m:s'),
                                        "refundStatus" => 'On Going',
                                        "remainingStatus" => "Unlinked Payments",
                                        "transactionType" => "--",
                                        "transactionfee" =>  $newarray['Fee'],
                                        "amt_after_transactionfee" => $newarray['Converted Amount'] - $newarray['Fee'],
                                        "notfoundemail" =>  $newarray['Customer Email'],
                                    ]);
                                } else {
                                    $checkinUnmatched = UnmatchedPayments::where('TransactionID', $newarray['id'])->count();
                                    if ($checkinUnmatched > 0) {
                                        continue;
                                    } else {
                                        // $stripepaymentsall[]=[$sepratedtoarray];
                                        $createClientUnmatchedPayment = UnmatchedPayments::create([
                                            "TransactionID" => $newarray['id'],
                                            "Clientemail" => $newarray['Customer Email'],
                                            "paymentDate" => $sql_date,
                                            "Paid" => $newarray['Converted Amount'],
                                            "Description" => $newarray['Description'],
                                            "cardBrand" => $newarray['Card Brand'],
                                            "stripePaymentstatus" => $newarray['Status'],
                                            "fee" =>  $newarray['Fee'],
                                            'created_at' => date('y-m-d H:m:s'),
                                            'updated_at' => date('y-m-d H:m:s'),

                                        ]);
                                    }
                                }
                            } else {
                                // continue;
                                $checkinUnmatched = UnmatchedPayments::where('TransactionID', $newarray['id'])->count();
                                if ($checkinUnmatched > 0) {
                                    continue;
                                } else {
                                    // $stripepaymentsall[]=[$sepratedtoarray];
                                    $createClientUnmatchedPayment = UnmatchedPayments::create([
                                        "TransactionID" => $newarray['id'],
                                        "Clientemail" => $newarray['Customer Email'],
                                        "paymentDate" => $sql_date,
                                        "Paid" => $newarray['Converted Amount'],
                                        "Description" => $newarray['Description'],
                                        "cardBrand" => $newarray['Card Brand'],
                                        "stripePaymentstatus" => $newarray['Status'],
                                        "fee" =>  $newarray['Fee'],
                                        'created_at' => date('y-m-d H:m:s'),
                                        'updated_at' => date('y-m-d H:m:s'),
                                    ]);
                                }
                            }
                        } else {
                            $matchclientmeta = Clientmeta::wherejsoncontains('otheremail', ($newarray['Customer Email']))->get();
                            if ($matchclientmeta->isNotEmpty()) {
                                $findclient = Client::where('email', $matchclientmeta[0]->clientID)->get();
                                $count = count($findclient);
                                if ($count == 1) {

                                    $checkstatus = NewPaymentsClients::where('TransactionID', $newarray['id'])->get();
                                    $checkcount = count($checkstatus);
                                    if ($checkcount == 1) {
                                        if ($checkstatus[0]->dispute == null) {
                                            continue;
                                        } else {
                                            $createClientPayment = NewPaymentsClients::where('TransactionID', $newarray['id'])->update([
                                                "dispute" => "dispute"
                                            ]);
                                            $disputePayment = NewPaymentsClients::where('TransactionID', $newarray['id'])->get();

                                            $payment_in_dispute_table = Disputedpayments::create([
                                                "BrandID" => $disputePayment[0]->BrandID,
                                                "ClientID" => $disputePayment[0]->ClientID,
                                                "ProjectID" => $disputePayment[0]->ProjectID,
                                                "ProjectManager" => $disputePayment[0]->ProjectManager,
                                                "PaymentID" => $disputePayment[0]->id,
                                                "dispute_Date" =>  $sql_date_dispute,
                                                "disputedAmount" =>  $newarray['Disputed Amount'],
                                                "disputeReason" => $newarray['Dispute Reason'],
                                            ]);
                                        }
                                    } else {
                                        continue;
                                    }
                                }
                            } else {
                                continue;
                            }
                        }
                    } elseif ($newarray['Status'] == 'Refunded') {
                        $matchclientmeta = Clientmeta::wherejsoncontains('otheremail', ($newarray['Customer Email']))->get();
                        if ($matchclientmeta->isNotEmpty()) {
                            $findclient = Client::where('email', $matchclientmeta[0]->clientID)->get();
                            $count = count($findclient);
                            if ($count == 1) {
                                $createClientPayment = NewPaymentsClients::create([
                                    "BrandID" => $findclient[0]->brand,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => 0,
                                    "ProjectManager" => 0,
                                    "paymentNature" => "--",
                                    "ChargingPlan" => "--",
                                    "ChargingMode" => "--",
                                    "Platform" => "--",
                                    "Card_Brand" => $newarray['Card Brand'],
                                    "Payment_Gateway" => "Stripe",
                                    "bankWireUpload" =>  "--",
                                    "TransactionID" => $newarray['id'],
                                    "paymentDate" => $sql_date,
                                    "SalesPerson" => 0,
                                    "TotalAmount" => 0,
                                    "Paid" => $newarray['Converted Amount'],
                                    "RemainingAmount" => 0,
                                    "PaymentType" => "--",
                                    "numberOfSplits" => "--",
                                    "SplitProjectManager" => json_encode("--"),
                                    "ShareAmount" => json_encode("--"),
                                    "Description" => $newarray['Description'],
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus" => 'Refund',
                                    "remainingStatus" => "Unlinked Payments",
                                    "transactionType" => "--",
                                    "transactionfee" => 0,
                                    "amt_after_transactionfee" => $newarray['Converted Amount'],
                                    "notfoundemail" =>  $newarray['Customer Email'],

                                ]);
                            } else {
                                $checkinUnmatched = UnmatchedPayments::where('TransactionID', $newarray['id'])->count();
                                if ($checkinUnmatched > 0) {
                                    continue;
                                } else {
                                    // $stripepaymentsall[]=[$sepratedtoarray];
                                    $createClientUnmatchedPayment = UnmatchedPayments::create([
                                        "TransactionID" => $newarray['id'],
                                        "Clientemail" => $newarray['Customer Email'],
                                        "paymentDate" => $sql_date,
                                        "Paid" => $newarray['Converted Amount'],
                                        "Description" => $newarray['Description'],
                                        "cardBrand" => $newarray['Card Brand'],
                                        "stripePaymentstatus" => $newarray['Status'],
                                        "fee" =>  $newarray['Fee'],
                                        'created_at' => date('y-m-d H:m:s'),
                                        'updated_at' => date('y-m-d H:m:s'),

                                    ]);
                                }
                            }
                        } else {
                            continue;
                        }
                    } elseif ($newarray['Status'] == 'Failed') {
                        continue;
                    }
                } else {
                    $sql_date = date("Y-m-d", strtotime($newarray['Created date (UTC)']));
                    $sql_date_dispute = date("Y-m-d", strtotime($newarray['Dispute Date (UTC)']));
                    if (isset($newarray['Dispute Status']) && $newarray['Dispute Status'] != null) {
                        $matchclientmeta = Clientmeta::wherejsoncontains('otheremail', $newarray['Customer Email'])->get();
                        if ($matchclientmeta->isNotEmpty()) {
                            $findclient = Client::where('id', $matchclientmeta[0]->clientID)->get();
                            $count = count($findclient);
                            if ($count != 0) {
                                $checkstatus = NewPaymentsClients::where('TransactionID', $newarray['id'])->get();
                                $checkcount = count($checkstatus);
                                if ($checkcount != 0) {
                                    if (isset($checkstatus[0]->dispute) && $checkstatus[0]->dispute != null) {
                                        continue;
                                    } else {
                                        $createClientPayment = NewPaymentsClients::where('TransactionID', $newarray['id'])->update([
                                            "dispute" => "dispute"
                                        ]);
                                        $disputePayment = NewPaymentsClients::where('TransactionID', $newarray['id'])->get();

                                        $payment_in_dispute_table = Disputedpayments::create([
                                            "BrandID" => $disputePayment[0]->BrandID,
                                            "ClientID" => $disputePayment[0]->ClientID,
                                            "ProjectID" => $disputePayment[0]->ProjectID,
                                            "ProjectManager" => $disputePayment[0]->ProjectManager,
                                            "PaymentID" => $disputePayment[0]->id,
                                            "dispute_Date" =>  $sql_date_dispute,
                                            "disputedAmount" =>  $newarray['Disputed Amount'],
                                            "disputeReason" => $newarray['Dispute Reason'],
                                        ]);
                                    }
                                } else {
                                    continue;
                                }
                            } else {
                                continue;
                            }
                        } else {
                        }
                    } else {
                        continue;
                    }
                }
            }
        }


        $getUnmatched = UnmatchedPayments::get();
        foreach ($getUnmatched as $getUnmatcheds) {
            $matchclientmeta = Clientmeta::wherejsoncontains('otheremail', ($getUnmatcheds->Clientemail))->get();
            $count = count($matchclientmeta);
            if ($count > 0) {
                $matchclient = Client::where('id', ($matchclientmeta[0]->clientID))->get();
                if ($getUnmatcheds->stripePaymentstatus == "Refunded") {
                    $createClientPayment = NewPaymentsClients::create([
                        "BrandID" => $matchclient[0]->brand,
                        "ClientID" => $matchclient[0]->id,
                        "ProjectID" => 0,
                        "ProjectManager" => 0,
                        "paymentNature" => "--",
                        "ChargingPlan" => "--",
                        "ChargingMode" => "--",
                        "Platform" => "--",
                        "Card_Brand" => $getUnmatcheds->cardBrand,
                        "Payment_Gateway" => "Stripe",
                        "bankWireUpload" =>  "--",
                        "TransactionID" => $getUnmatcheds->TransactionID,
                        "paymentDate" => $getUnmatcheds->paymentDate,
                        "SalesPerson" => 0,
                        "TotalAmount" => 0,
                        "Paid" => $getUnmatcheds->Paid,
                        "RemainingAmount" => 0,
                        "PaymentType" => "--",
                        "numberOfSplits" => "--",
                        "SplitProjectManager" => json_encode("--"),
                        "ShareAmount" => json_encode("--"),
                        "Description" => $getUnmatcheds->Description,
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus" => 'Refunded',
                        "remainingStatus" => "Unlinked Payments",
                        "transactionType" => "--",
                        "transactionfee" => 0,
                        "amt_after_transactionfee" => $getUnmatcheds->Paid,
                        "notfoundemail" =>  $newarray['Customer Email']

                    ]);
                } else {

                    $createClientPayment = NewPaymentsClients::create([
                        "BrandID" => $matchclient[0]->brand,
                        "ClientID" => $matchclient[0]->id,
                        "ProjectID" => 0,
                        "ProjectManager" => 0,
                        "paymentNature" => "--",
                        "ChargingPlan" => "--",
                        "ChargingMode" => "--",
                        "Platform" => "--",
                        "Card_Brand" => $getUnmatcheds->cardBrand,
                        "Payment_Gateway" => "Stripe",
                        "bankWireUpload" =>  "--",
                        "TransactionID" => $getUnmatcheds->TransactionID,
                        "paymentDate" => $getUnmatcheds->paymentDate,
                        "SalesPerson" => 0,
                        "TotalAmount" => 0,
                        "Paid" => $getUnmatcheds->Paid,
                        "RemainingAmount" => 0,
                        "PaymentType" => "--",
                        "numberOfSplits" => "--",
                        "SplitProjectManager" => json_encode("--"),
                        "ShareAmount" => json_encode("--"),
                        "Description" => $getUnmatcheds->Description,
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus" => 'On Going',
                        "remainingStatus" => "Unlinked Payments",
                        "transactionType" => "--",
                        "transactionfee" => $getUnmatcheds->fee,
                        "amt_after_transactionfee" => $getUnmatcheds->Paid - $getUnmatcheds->fee,
                        "notfoundemail" =>  $newarray['Customer Email']

                    ]);
                }
                $deleteUnmatched = UnmatchedPayments::where('Clientemail', $getUnmatcheds->Clientemail)->delete();
            } else {
                continue;
            }
        }

        // echo("<pre>");
        // print_r($data[0][1][0]);
        // die();

        return redirect('/payments/unmatched');
    }

    function csv_sheetpayments(Request $request)
    {
        $loginUser = $this->roleExits($request);
        return view('sheetpaymentUpload', [
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function csv_sheetpayments_process(Request $request)
    {
        ini_set('max_execution_time', 300);

        $a =  json_encode(["--"]);

        $data = Excel::toArray([], $request->file('sheetpayments'));
        $allinvoice = [];
        foreach ($data as $extractData) {
            $headings = $extractData[0];
            $keycount = count($headings);
            $maincount = count($extractData);

            for ($j = 1; $j < $maincount; $j++) {
                $newarray = [];
                for ($i = 0; $i < $keycount; $i++) {
                    $newarray[$headings[$i]] = $extractData[$j][$i];
                }
                $allinvoice[] = [$newarray];
            }
        }
        // strtolower("Hello@WORLD.");

        foreach ($allinvoice as $allinvoices) {
            $checktransactionID = NewPaymentsClients::where('TransactionID', $allinvoices[0]['Transaction ID'])->count();
            $mainemail =  strtolower($allinvoices[0]["Email"]);
            $ClientStatus = $allinvoices[0]["Status"];
            $sql_date = date("Y-m-d", strtotime($allinvoices[0]['Date']));
            if ($allinvoices[0]['Recurring/Renewal'] != "One Time") {
                $sql_futuredate = date("Y-m-d", strtotime($allinvoices[0]['Recurring/Renewal']));
            }
            $sql_date_dispute = date("Y-m-d", strtotime($allinvoices[0]['Refund/Dispute Date']));
            $matchclientmeta = Clientmeta::wherejsoncontains('otheremail', ($allinvoices[0]['Email']))->get();

            $sp = Employee::where('name', $allinvoices[0]['Sales Person'])->get();
            if (isset($sp[0]->id)) {
                $salesperson = $sp[0]->id;
            } else {
                $salesperson = 0;
            }

            $pm = Employee::where('name', $allinvoices[0]['Account Manager'])->get();
            if (isset($pm[0]->id)) {
                $projectmanager = $pm[0]->id;
            } else {
                $projectmanager = 0;
            }

            $remamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'];
            if ($remamt == 0) {
                $remainingStatus = "Not Remaining";
            } elseif ($remamt > 0) {
                $remainingStatus = "Remaining";
            }

            $findbrand = Brand::where('name', $allinvoices[0]['Brand'])->get();

            if ($allinvoices[0]['Package Plan'] == 'One Time') {
                $chargingplan = "One Time Payment";
                $chargingmode = "One Time Payment";
            } elseif ($allinvoices[0]['Package Plan'] == 'Recurring') {
                $chargingplan = "Monthly";
                $chargingmode = "Recurring";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal') {
                $chargingplan = "Monthly";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal2') {
                $chargingplan = "2 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal3') {
                $chargingplan = "3 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal4') {
                $chargingplan = "4 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal5') {
                $chargingplan = "5 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal6') {
                $chargingplan = "6 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal7') {
                $chargingplan = "7 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal8') {
                $chargingplan = "8 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal9') {
                $chargingplan = "9 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal10') {
                $chargingplan = "10 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal11') {
                $chargingplan = "11 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal12') {
                $chargingplan = "12 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal24') {
                $chargingplan = "2 Years";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal36') {
                $chargingplan = "3 Years";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Small Payment') {
                $chargingplan = "One Time Payment";
                $chargingmode = "One Time Payment";
            }

            if ($allinvoices[0]['Sales Mode'] == 'New Lead') {
                $paymentNature = "New Lead";
            } elseif ($allinvoices[0]['Sales Mode'] == 'New Sale') {
                $paymentNature = "New Sale";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Recurring') {
                $paymentNature = "Recurring Payment";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Renewal') {
                $paymentNature = "Renewal Payment";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Small Payment') {
                $paymentNature = "Small Paymente";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Up Sell') {
                $paymentNature = "Upsell";
            } elseif ($allinvoices[0]['Sales Mode'] == 'WON') {
                $paymentNature = "Dispute Won";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Remaining' || $allinvoices[0]['Sales Mode'] == 'FSRemaining') {
                $paymentNature = "Remaining";
            }

            $checktypeofremaining = $allinvoices[0]['Sales Mode'];



            if ($matchclientmeta->isNotEmpty()) {
                $findclient = Client::where('id', $matchclientmeta[0]->clientID)->get();
                $project = Project::where('clientID', $findclient[0]->id)->get();
                if (isset($project[0]->id)) {
                    $findproject = $project[0]->id;
                } else {
                    $findproject = 0;
                }
                $count = count($findclient);
                if ($count == 1) {

                    if ($paymentNature != "Dispute Won") {
                        if ($checktypeofremaining == 'FSRemaining') {
                            $createClientPayment = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                                "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                                "paymentDate" => $sql_date,
                                "futuredate" => ($allinvoices[0]['Recurring/Renewal'] == "One Time") ? null : $sql_futuredate, //to view this problem
                                "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "Full Payment",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                'refundID' => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $findclient[0]->id,
                                'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => "New Lead",
                                "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "Sheetdata" => "Invoicing Data",
                                "disputeattack" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $sql_date_dispute,
                                "disputeattackamount" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);
                        } else {
                            $createClientPayment = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                                "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                                "paymentDate" => $sql_date,
                                "futuredate" => ($allinvoices[0]['Recurring/Renewal'] == "One Time") ? null : $sql_futuredate, //to view this problem
                                "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "Full Payment",
                                "numberOfSplits" =>  "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                "refundID" => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $findclient[0]->id,
                                "remainingID" => ($remamt == 0) ? null : $findclient[0]->id,
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "Sheetdata" => "Invoicing Data",
                                "disputeattack" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $sql_date_dispute,
                                "disputeattackamount" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);
                        }
                    } else {
                        continue;
                        // echo ("<br>");
                        // echo ($allinvoices[0]['Transaction ID']);
                    }
                } else {
                    continue;
                }
            } else {

                if ($paymentNature != "Dispute Won") {
                    if ($checktypeofremaining == 'FSRemaining') {
                        $createClientPayment = NewPaymentsClients::insertGetId([
                            "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" =>  0,
                            "ProjectID" => 0,
                            "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                            "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                            "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                            "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                            "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                            "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                            "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                            "bankWireUpload" =>  "--",
                            "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                            "paymentDate" => $sql_date,
                            "futuredate" => ($allinvoices[0]['Recurring/Renewal'] == "One Time") ? null : $sql_futuredate, //to view this problem
                            "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                            "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                            "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                            "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                            "PaymentType" => "Full Payment",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => $a,
                            "ShareAmount" => $a,
                            "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            'refundID' => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $allinvoices[0]['Transaction ID'],
                            'remainingID' => ($remamt == 0) ? null : $allinvoices[0]['Transaction ID'],
                            "remainingStatus" => $remainingStatus,
                            "transactionType" => "New Lead",
                            "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                            "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                            "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                            "Sheetdata" => "Invoicing Data",
                            "disputeattack" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $sql_date_dispute,
                            "disputeattackamount" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                            "notfoundemail" => $allinvoices[0]['Email'],
                        ]);
                    } else {
                        $createClientPayment = NewPaymentsClients::insertGetId([
                            "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" =>  0,
                            "ProjectID" => 0,
                            "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                            "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                            "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                            "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                            "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                            "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                            "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                            "bankWireUpload" =>  "--",
                            "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                            "paymentDate" => $sql_date,
                            "futuredate" => ($allinvoices[0]['Recurring/Renewal'] == "One Time") ? null : $sql_futuredate, //to view this problem
                            "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                            "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                            "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                            "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                            "PaymentType" => "Full Payment",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => $a,
                            "ShareAmount" => $a,
                            "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            'refundID' => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $allinvoices[0]['Transaction ID'],
                            'remainingID' => ($remamt == 0) ? null : $allinvoices[0]['Transaction ID'],
                            "remainingStatus" => $remainingStatus,
                            "transactionType" => $paymentNature,
                            "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                            "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                            "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                            "Sheetdata" => "Invoicing Data",
                            "disputeattack" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $sql_date_dispute,
                            "disputeattackamount" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                            "notfoundemail" => $allinvoices[0]['Email'],
                        ]);
                    }
                }
            }
        }

        // for_refund:
        foreach ($allinvoice as $allinvoices) {
            $findbrand = Brand::where('name', $allinvoices[0]['Brand'])->get();
            $checktypeofremaining = $allinvoices[0]['Sales Mode'];
            $checktransactionIDget = NewPaymentsClients::where('TransactionID', $allinvoices[0]['Transaction ID'])->where('refundID', '!=', null)->get();
            $checktransactionID = NewPaymentsClients::where('TransactionID', $allinvoices[0]['Transaction ID'])->where('refundID', '!=', null)->count();
            if ($checktransactionID == 1) {
                $mainemail = $allinvoices[0]["Email"];
                $ClientStatus = $allinvoices[0]["Status"];
                $sql_date = date("Y-m-d", strtotime($allinvoices[0]['Date']));
                if ($allinvoices[0]['Recurring/Renewal'] != "One Time") {
                    $sql_futuredate = date("Y-m-d", strtotime($allinvoices[0]['Recurring/Renewal']));
                }
                $s1ql_date_dispute = date("Y-m-d", strtotime($allinvoices[0]['Refund/Dispute Date']));
                $matchclientmeta = Clientmeta::wherejsoncontains('otheremail', ($allinvoices[0]['Email']))->get();

                $sp = Employee::where('name', $allinvoices[0]['Sales Person'])->get();
                if (isset($sp[0]->id)) {
                    $salesperson = $sp[0]->id;
                } else {
                    $salesperson = 0;
                }

                $pm = Employee::where('name', $allinvoices[0]['Account Manager'])->get();
                if (isset($pm[0]->id)) {
                    $projectmanager = $pm[0]->id;
                } else {
                    $projectmanager = 0;
                }

                $remamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'];
                if ($remamt == 0) {
                    $remainingStatus = "Not Remaining";
                } elseif ($remamt > 0) {
                    $remainingStatus = "Remaining";
                }

                if ($allinvoices[0]['Package Plan'] == 'One Time') {
                    $chargingplan = "One Time Payment";
                    $chargingmode = "One Time Payment";
                } elseif ($allinvoices[0]['Package Plan'] == 'Recurring') {
                    $chargingplan = "Monthly";
                    $chargingmode = "Recurring";
                } elseif ($allinvoices[0]['Package Plan'] == 'Renewal') {
                    $chargingplan = "Monthly";
                    $chargingmode = "Renewal";
                } elseif ($allinvoices[0]['Package Plan'] == 'Renewal2') {
                    $chargingplan = "2 Months";
                    $chargingmode = "Renewal";
                } elseif ($allinvoices[0]['Package Plan'] == 'Renewal3') {
                    $chargingplan = "3 Months";
                    $chargingmode = "Renewal";
                } elseif ($allinvoices[0]['Package Plan'] == 'Renewal4') {
                    $chargingplan = "4 Months";
                    $chargingmode = "Renewal";
                } elseif ($allinvoices[0]['Package Plan'] == 'Renewal5') {
                    $chargingplan = "5 Months";
                    $chargingmode = "Renewal";
                } elseif ($allinvoices[0]['Package Plan'] == 'Renewal6') {
                    $chargingplan = "6 Months";
                    $chargingmode = "Renewal";
                } elseif ($allinvoices[0]['Package Plan'] == 'Renewal7') {
                    $chargingplan = "7 Months";
                    $chargingmode = "Renewal";
                } elseif ($allinvoices[0]['Package Plan'] == 'Renewal8') {
                    $chargingplan = "8 Months";
                    $chargingmode = "Renewal";
                } elseif ($allinvoices[0]['Package Plan'] == 'Renewal9') {
                    $chargingplan = "9 Months";
                    $chargingmode = "Renewal";
                } elseif ($allinvoices[0]['Package Plan'] == 'Renewal10') {
                    $chargingplan = "10 Months";
                    $chargingmode = "Renewal";
                } elseif ($allinvoices[0]['Package Plan'] == 'Renewal11') {
                    $chargingplan = "11 Months";
                    $chargingmode = "Renewal";
                } elseif ($allinvoices[0]['Package Plan'] == 'Renewal12') {
                    $chargingplan = "12 Months";
                    $chargingmode = "Renewal";
                } elseif ($allinvoices[0]['Package Plan'] == 'Renewal24') {
                    $chargingplan = "2 Years";
                    $chargingmode = "Renewal";
                } elseif ($allinvoices[0]['Package Plan'] == 'Renewal36') {
                    $chargingplan = "3 Years";
                    $chargingmode = "Renewal";
                } elseif ($allinvoices[0]['Package Plan'] == 'Small Payment') {
                    $chargingplan = "One Time Payment";
                    $chargingmode = "One Time Payment";
                }


                if ($allinvoices[0]['Sales Mode'] == 'New Lead') {
                    $paymentNature = "New Lead";
                } elseif ($allinvoices[0]['Sales Mode'] == 'New Sale') {
                    $paymentNature = "New Sale";
                } elseif ($allinvoices[0]['Sales Mode'] == 'FSRemaining' || $allinvoices[0]['Sales Mode'] == 'Remaining') {
                    $paymentNature = "New Sale";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Recurring') {
                    $paymentNature = "Recurring Payment";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Renewal') {
                    $paymentNature = "Renewal Payment";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Small Payment') {
                    $paymentNature = "Small Paymente";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Up Sell') {
                    $paymentNature = "Upsell";
                } elseif ($allinvoices[0]['Sales Mode'] == 'WON') {
                    $paymentNature = "Dispute Won";
                }

                if ($matchclientmeta->isNotEmpty()) {
                    $findclient = Client::where('id', $matchclientmeta[0]->clientID)->get();
                    $project = Project::where('clientID', $findclient[0]->id)->get();
                    if (isset($project[0]->id)) {
                        $findproject = $project[0]->id;
                    } else {
                        $findproject = 0;
                    }
                    $count = count($findclient);
                    if ($count == 1) {

                        if ($paymentNature != "Dispute Won") {
                            if ($checktransactionIDget[0]->dispute == null) {
                                //simple refund
                                $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                    "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                    "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                    "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                    "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                    "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                                    "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                                    "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                    "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                    "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                    "bankWireUpload" =>  "--",
                                    "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Refund)",
                                    "paymentDate" => $s1ql_date_dispute, //to view this problem
                                    "futuredate" => ($allinvoices[0]['Recurring/Renewal'] == "One Time") ? null : $sql_futuredate, //to view this problem
                                    "SalesPerson" => $salesperson,
                                    "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                    "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                    "PaymentType" => "--",
                                    "numberOfSplits" => "--",
                                    "SplitProjectManager" => json_encode("--"),
                                    "ShareAmount" => json_encode("--"),
                                    "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus" => 'Refund',
                                    'refundID' =>  $findclient[0]->id,
                                    'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                    "remainingStatus" => $remainingStatus,
                                    "transactionType" => $paymentNature,
                                    "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                                    "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                    "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                    "Sheetdata" => "Invoicing Data"
                                ]);

                                $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                                if ($refundamt == 0) {
                                    $refundtype = 'Refund';
                                } else {
                                    $refundtype = 'Partial Refund';
                                }

                                $refund = RefundPayments::create([
                                    "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "PaymentID" => $createClientPaymentrefund,
                                    "basicAmount" => $allinvoices[0]['Total Amount'],
                                    "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "refundtype" => $refundtype,
                                    "refund_date" => $s1ql_date_dispute,
                                    "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                    "paymentType" => "Full payment",
                                    "splitmanagers" => json_encode("--"),
                                    "splitamounts" => json_encode("--"),
                                    "splitRefunds" => json_encode("--"),
                                    "transactionfee" => 0,
                                    "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                                ]);
                            } else {
                                //refund due to chargeback lost
                                $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                    "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "paymentNature" => $paymentNature,
                                    "ChargingPlan" => $chargingplan,
                                    "ChargingMode" => $chargingmode,
                                    "Platform" => $allinvoices[0]['Platform'],
                                    "Card_Brand" => $allinvoices[0]['Card Brand'],
                                    "Payment_Gateway" => $allinvoices[0]['Payment Gateway'],
                                    "bankWireUpload" =>  "--",
                                    "TransactionID" => $allinvoices[0]['Transaction ID'] . "(Refund)",
                                    "paymentDate" => $s1ql_date_dispute, //to view this problem
                                    "SalesPerson" => $salesperson,
                                    "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                    "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                    "PaymentType" => "--",
                                    "numberOfSplits" => "--",
                                    "SplitProjectManager" => json_encode("--"),
                                    "ShareAmount" => json_encode("--"),
                                    "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus" => 'Refund',
                                    'refundID' =>  $findclient[0]->id,
                                    'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                    "remainingStatus" => $remainingStatus,
                                    "transactionType" => $paymentNature,
                                    "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                                    "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                    "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                    "disputefee" =>  15,
                                    "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "Sheetdata" => "Invoicing Data"
                                ]);

                                $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                                if ($refundamt == 0) {
                                    $refundtype = 'Refund';
                                } else {
                                    $refundtype = 'Partial Refund';
                                }

                                $refund = RefundPayments::create([
                                    "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "PaymentID" => $createClientPaymentrefund,
                                    "basicAmount" => $allinvoices[0]['Total Amount'],
                                    "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "refundtype" => $refundtype,
                                    "refund_date" => $s1ql_date_dispute,
                                    "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                    "paymentType" => "Full payment",
                                    "splitmanagers" => json_encode("--"),
                                    "splitamounts" => json_encode("--"),
                                    "splitRefunds" => json_encode("--"),
                                    "transactionfee" => 0,
                                    "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                                ]);

                                $lostdispute = Disputedpayments::create([
                                    "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "PaymentID" => $createClientPaymentrefund,
                                    "dispute_Date" => $s1ql_date_dispute,
                                    "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    "disputeStatus" => "Lost",
                                    "disputefee"  => 15,
                                    "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],

                                ]);
                            }
                        } else {
                            //chargeback won

                            $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                                "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Won)",
                                "paymentDate" => $s1ql_date_dispute, //to view this problem
                                "SalesPerson" => $salesperson,
                                "TotalAmount" => $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "--",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => json_encode("--"),
                                "ShareAmount" => json_encode("--"),
                                "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                'refundID' =>  $findclient[0]->id,
                                'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "disputefee" =>  15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "Sheetdata" => "Invoicing Data"
                            ]);

                            $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                            if ($refundamt == 0) {
                                $refundtype = 'Refund';
                            } else {
                                $refundtype = 'Partial Refund';
                            }


                            $lostdispute = Disputedpayments::create([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => $findclient[0]->id,
                                "ProjectID" => $findproject,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "dispute_Date" => $s1ql_date_dispute,
                                "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "disputeStatus" => "Won",
                                "disputefee"  => 15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount']

                            ]);
                        }
                    }
                } else {
                    if ($paymentNature != "Dispute Won") {
                        if ($checktransactionIDget[0]->dispute == null) {
                            //simple refund
                            $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                                "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Refund)",
                                "paymentDate" => $s1ql_date_dispute, //to view this problem
                                "futuredate" => ($allinvoices[0]['Recurring/Renewal'] == "One Time") ? null : $sql_futuredate, //to view this problem
                                "SalesPerson" => $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "--",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'Refund',
                                'refundID' =>   $allinvoices[0]['Transaction ID'],
                                'remainingID' => ($remamt == 0) ? null :  $allinvoices[0]['Transaction ID'],
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "Sheetdata" => "Invoicing Data",
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);

                            $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                            if ($refundamt == 0) {
                                $refundtype = 'Refund';
                            } else {
                                $refundtype = 'Partial Refund';
                            }

                            $refund = RefundPayments::create([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => $findproject,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "basicAmount" => $allinvoices[0]['Total Amount'],
                                "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "refundtype" => $refundtype,
                                "refund_date" => $s1ql_date_dispute,
                                "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                "paymentType" => "Full payment",
                                "splitmanagers" => json_encode("--"),
                                "splitamounts" => json_encode("--"),
                                "splitRefunds" => json_encode("--"),
                                "transactionfee" => 0,
                                "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                            ]);
                        } else {
                            //refund due to chargeback lost
                            $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => $findproject,
                                "ProjectManager" => $projectmanager,
                                "paymentNature" => $paymentNature,
                                "ChargingPlan" => $chargingplan,
                                "ChargingMode" => $chargingmode,
                                "Platform" => $allinvoices[0]['Platform'],
                                "Card_Brand" => $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => $allinvoices[0]['Transaction ID'] . "(Refund)",
                                "paymentDate" => $s1ql_date_dispute, //to view this problems
                                "SalesPerson" => $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "--",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'Refund',
                                'refundID' =>  $findclient[0]->id,
                                'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "disputefee" =>  15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "Sheetdata" => "Invoicing Data",
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);

                            $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                            if ($refundamt == 0) {
                                $refundtype = 'Refund';
                            } else {
                                $refundtype = 'Partial Refund';
                            }

                            $refund = RefundPayments::create([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => $findproject,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "basicAmount" => $allinvoices[0]['Total Amount'],
                                "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "refundtype" => $refundtype,
                                "refund_date" => $s1ql_date_dispute,
                                "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                "paymentType" => "Full payment",
                                "splitmanagers" => json_encode("--"),
                                "splitamounts" => json_encode("--"),
                                "splitRefunds" => json_encode("--"),
                                "transactionfee" => 0,
                                "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                            ]);

                            $lostdispute = Disputedpayments::create([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => $findproject,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "dispute_Date" => $s1ql_date_dispute,
                                "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "disputeStatus" => "Lost",
                                "disputefee"  => 15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],

                            ]);
                        }
                    } else {
                        //chargeback won

                        $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                            "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" => 0,
                            "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                            "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                            "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                            "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                            "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                            "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                            "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                            "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                            "bankWireUpload" =>  "--",
                            "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Won)",
                            "paymentDate" => $sql_date, //to view this problem
                            "futuredate" => ($allinvoices[0]['Recurring/Renewal'] == "One Time") ? null : $sql_futuredate, //to view this problem
                            "SalesPerson" => $salesperson,
                            "TotalAmount" => $allinvoices[0]['Total Amount'],
                            "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                            "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                            "PaymentType" => "--",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => $a,
                            "ShareAmount" => $a,
                            "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            'refundID' =>  $allinvoices[0]['Transaction ID'],
                            'remainingID' => ($remamt == 0) ? null : $allinvoices[0]['Transaction ID'],
                            "remainingStatus" => $remainingStatus,
                            "transactionType" => $paymentNature,
                            "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                            "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                            "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                            "disputefee" =>  15,
                            "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                            "Sheetdata" => "Invoicing Data",
                            "disputeattack"  => $s1ql_date_dispute, //date
                            "disputeattackamount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                            "notfoundemail" => $allinvoices[0]['Email'],
                        ]);

                        $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                        if ($refundamt == 0) {
                            $refundtype = 'Refund';
                        } else {
                            $refundtype = 'Partial Refund';
                        }

                        $lostdispute = Disputedpayments::create([
                            "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" => 0,
                            "ProjectID" => 0,
                            "ProjectManager" => $projectmanager,
                            "PaymentID" => $createClientPaymentrefund,
                            "dispute_Date" => $sql_date,
                            "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                            "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                            "disputeStatus" => "Won",
                            "disputefee"  => 15,
                            "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount']

                        ]);
                    }
                }
            }
        }

        return redirect('/client/project/payment/all');
    }

    function csv_sheetpaymentsBook(Request $request)
    {
        $loginUser = $this->roleExits($request);
        return view('sheetpaymentUploadbook', [
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function csv_sheetpayments_processBook(Request $request)
    {
        ini_set('max_execution_time', 300);

        $a =  json_encode(["--"]);

        $data = Excel::toArray([], $request->file('booksheetpayments'));
        $allinvoice = [];
        foreach ($data as $extractData) {
            $headings = $extractData[0];
            $keycount = count($headings);
            $maincount = count($extractData);

            for ($j = 1; $j < $maincount; $j++) {
                $newarray = [];
                for ($i = 0; $i < $keycount; $i++) {
                    $newarray[$headings[$i]] = $extractData[$j][$i];
                }
                $allinvoice[] = [$newarray];
            }
        }

        foreach ($allinvoice as $allinvoices) {
            $checktransactionID = NewPaymentsClients::where('TransactionID', $allinvoices[0]['Transaction ID'])->count();
            $mainemail =  strtolower($allinvoices[0]["Email"]);
            $sql_date = date("Y-m-d", strtotime($allinvoices[0]['Date']));
            $sql_date_dispute = date("Y-m-d", strtotime($allinvoices[0]['Refund/Dispute Date']));
            $matchclientmeta = Clientmeta::wherejsoncontains('otheremail', ($allinvoices[0]['Email']))->get();

            $sp = Employee::where('name', $allinvoices[0]['Sales Person'])->get();
            if (isset($sp[0]->id)) {
                $salesperson = $sp[0]->id;
            } else {
                $salesperson = 0;
            }

            $pm = Employee::where('name', $allinvoices[0]['Account Manager'])->get();
            if (isset($pm[0]->id)) {
                $projectmanager = $pm[0]->id;
            } else {
                $projectmanager = 0;
            }

            $remamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'];
            if ($remamt == 0) {
                $remainingStatus = "Not Remaining";
            } elseif ($remamt > 0) {
                $remainingStatus = "Remaining";
            }

            $findbrand = Brand::where('name', $allinvoices[0]['Brand'])->get();

            if ($allinvoices[0]['Sales Mode'] == 'New Lead') {
                $paymentNature = "New Lead";
            } elseif ($allinvoices[0]['Sales Mode'] == 'New Sale') {
                $paymentNature = "New Sale";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Recurring') {
                $paymentNature = "Recurring Payment";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Renewal') {
                $paymentNature = "Renewal Payment";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Small Payment') {
                $paymentNature = "Small Paymente";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Up Sell') {
                $paymentNature = "Upsell";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Remaining' || $allinvoices[0]['Sales Mode'] == 'FSRemaining') {
                $paymentNature = "Remaining";
            }

            $checktypeofremaining = $allinvoices[0]['Sales Mode'];



            if ($matchclientmeta->isNotEmpty()) {
                $findclient = Client::where('id', $matchclientmeta[0]->clientID)->get();
                $project = Project::where('clientID', $findclient[0]->id)->get();
                if (isset($project[0]->id)) {
                    $findproject = $project[0]->id;
                } else {
                    $findproject = 0;
                }
                $count = count($findclient);
                if ($count == 1) {

                    if ($allinvoices[0]['Balance Amount'] != "WON") {
                        if ($checktypeofremaining == 'FSRemaining') {
                            $createClientPayment = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" =>  '--',
                                "ChargingMode" =>  '--',
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                                "paymentDate" => $sql_date,
                                "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "Full Payment",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                'refundID' => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $findclient[0]->id,
                                'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => "New Lead",
                                "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "Sheetdata" => "Invoicing Data",
                                "disputeattack" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $sql_date_dispute,
                                "disputeattackamount" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);
                        } else {
                            $createClientPayment = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" =>  '--',
                                "ChargingMode" =>  '--',
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                                "paymentDate" => $sql_date,
                                "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "Full Payment",
                                "numberOfSplits" =>  "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                "refundID" => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $findclient[0]->id,
                                "remainingID" => ($remamt == 0) ? null : $findclient[0]->id,
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "Sheetdata" => "Invoicing Data",
                                "disputeattack" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $sql_date_dispute,
                                "disputeattackamount" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);
                        }
                    } else {
                        continue;
                        // echo ("<br>");
                        // echo ($allinvoices[0]['Transaction ID']);
                    }
                } else {
                    continue;
                }
            } else {
                //to store in payments table with status not found client

                if ($allinvoices[0]['Balance Amount'] != "WON") {
                    if ($checktypeofremaining == 'FSRemaining') {
                        $createClientPayment = NewPaymentsClients::insertGetId([
                            "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" =>  0,
                            "ProjectID" => 0,
                            "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                            "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                            "ChargingPlan" =>  '--',
                            "ChargingMode" =>  '--',
                            "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                            "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                            "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                            "bankWireUpload" =>  "--",
                            "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                            "paymentDate" => $sql_date,
                            "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                            "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                            "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                            "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                            "PaymentType" => "Full Payment",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => $a,
                            "ShareAmount" => $a,
                            "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            'refundID' => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $allinvoices[0]['Transaction ID'],
                            'remainingID' => ($remamt == 0) ? null : $allinvoices[0]['Transaction ID'],
                            "remainingStatus" => $remainingStatus,
                            "transactionType" => "New Lead",
                            "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                            "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                            "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                            "Sheetdata" => "Invoicing Data",
                            "disputeattack" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $sql_date_dispute,
                            "disputeattackamount" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                            "notfoundemail" => $allinvoices[0]['Email'],
                        ]);
                    } else {
                        $createClientPayment = NewPaymentsClients::insertGetId([
                            "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" =>  0,
                            "ProjectID" => 0,
                            "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                            "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                            "ChargingPlan" =>  '--',
                            "ChargingMode" =>  '--',
                            "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                            "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                            "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                            "bankWireUpload" =>  "--",
                            "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                            "paymentDate" => $sql_date,
                            "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                            "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                            "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                            "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                            "PaymentType" => "Full Payment",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => $a,
                            "ShareAmount" => $a,
                            "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            'refundID' => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $allinvoices[0]['Transaction ID'],
                            'remainingID' => ($remamt == 0) ? null : $allinvoices[0]['Transaction ID'],
                            "remainingStatus" => $remainingStatus,
                            "transactionType" => $paymentNature,
                            "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                            "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                            "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                            "Sheetdata" => "Invoicing Data",
                            "disputeattack" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $sql_date_dispute,
                            "disputeattackamount" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                            "notfoundemail" => $allinvoices[0]['Email'],
                        ]);
                    }
                }
            }
        }

        // for_refund:
        foreach ($allinvoice as $allinvoices) {
            $findbrand = Brand::where('name', $allinvoices[0]['Brand'])->get();
            $checktypeofremaining = $allinvoices[0]['Sales Mode'];
            $checktransactionIDget = NewPaymentsClients::where('TransactionID', $allinvoices[0]['Transaction ID'])->where('refundID', '!=', null)->get();
            $checktransactionID = NewPaymentsClients::where('TransactionID', $allinvoices[0]['Transaction ID'])->where('refundID', '!=', null)->count();
            if ($checktransactionID == 1) {
                $mainemail = $allinvoices[0]["Email"];
                $sql_date = date("Y-m-d", strtotime($allinvoices[0]['Date']));
                $s1ql_date_dispute = date("Y-m-d", strtotime($allinvoices[0]['Refund/Dispute Date']));
                $matchclientmeta = Clientmeta::wherejsoncontains('otheremail', ($allinvoices[0]['Email']))->get();

                $sp = Employee::where('name', $allinvoices[0]['Sales Person'])->get();
                if (isset($sp[0]->id)) {
                    $salesperson = $sp[0]->id;
                } else {
                    $salesperson = 0;
                }

                $pm = Employee::where('name', $allinvoices[0]['Account Manager'])->get();
                if (isset($pm[0]->id)) {
                    $projectmanager = $pm[0]->id;
                } else {
                    $projectmanager = 0;
                }

                $remamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'];
                if ($remamt == 0) {
                    $remainingStatus = "Not Remaining";
                } elseif ($remamt > 0) {
                    $remainingStatus = "Remaining";
                }


                if ($allinvoices[0]['Sales Mode'] == 'New Lead') {
                    $paymentNature = "New Lead";
                } elseif ($allinvoices[0]['Sales Mode'] == 'New Sale') {
                    $paymentNature = "New Sale";
                } elseif ($allinvoices[0]['Sales Mode'] == 'FSRemaining' || $allinvoices[0]['Sales Mode'] == 'Remaining') {
                    $paymentNature = "New Sale";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Recurring') {
                    $paymentNature = "Recurring Payment";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Renewal') {
                    $paymentNature = "Renewal Payment";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Small Payment') {
                    $paymentNature = "Small Paymente";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Up Sell') {
                    $paymentNature = "Upsell";
                } elseif ($allinvoices[0]['Sales Mode'] == 'WON') {
                    $paymentNature = "Dispute Won";
                }

                if ($matchclientmeta->isNotEmpty()) {
                    $findclient = Client::where('id', $matchclientmeta[0]->clientID)->get();
                    $project = Project::where('clientID', $findclient[0]->id)->get();
                    if (isset($project[0]->id)) {
                        $findproject = $project[0]->id;
                    } else {
                        $findproject = 0;
                    }
                    $count = count($findclient);
                    if ($count == 1) {

                        if ($allinvoices[0]['Balance Amount'] != "WON") {
                            if ($checktransactionIDget[0]->dispute == null) {
                                //simple refund
                                $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                    "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                    "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                    "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                    "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                    "ChargingPlan" =>  '--',
                                    "ChargingMode" =>  '--',
                                    "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                    "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                    "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                    "bankWireUpload" =>  "--",
                                    "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Refund)",
                                    "paymentDate" => $s1ql_date_dispute, //to view this problem
                                    "SalesPerson" => $salesperson,
                                    "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                    "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                    "PaymentType" => "--",
                                    "numberOfSplits" => "--",
                                    "SplitProjectManager" => json_encode("--"),
                                    "ShareAmount" => json_encode("--"),
                                    "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus" => 'Refund',
                                    'refundID' =>  $findclient[0]->id,
                                    'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                    "remainingStatus" => $remainingStatus,
                                    "transactionType" => $paymentNature,
                                    "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                    "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                    "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                    "Sheetdata" => "Invoicing Data"
                                ]);

                                $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                                if ($refundamt == 0) {
                                    $refundtype = 'Refund';
                                } else {
                                    $refundtype = 'Partial Refund';
                                }

                                $refund = RefundPayments::create([
                                    "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "PaymentID" => $createClientPaymentrefund,
                                    "basicAmount" => $allinvoices[0]['Total Amount'],
                                    "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "refundtype" => $refundtype,
                                    "refund_date" => $s1ql_date_dispute,
                                    "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                    "paymentType" => "Full payment",
                                    "splitmanagers" => json_encode("--"),
                                    "splitamounts" => json_encode("--"),
                                    "splitRefunds" => json_encode("--"),
                                    "transactionfee" => 0,
                                    "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                                ]);
                            } else {
                                //refund due to chargeback lost
                                $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                    "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "paymentNature" => $paymentNature,
                                    "ChargingPlan" =>  '--',
                                    "ChargingMode" =>  '--',
                                    "Platform" => $allinvoices[0]['Platform'],
                                    "Card_Brand" => $allinvoices[0]['Card Brand'],
                                    "Payment_Gateway" => $allinvoices[0]['Payment Gateway'],
                                    "bankWireUpload" =>  "--",
                                    "TransactionID" => $allinvoices[0]['Transaction ID'] . "(Refund)",
                                    "paymentDate" => $s1ql_date_dispute, //to view this problem
                                    "SalesPerson" => $salesperson,
                                    "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                    "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                    "PaymentType" => "--",
                                    "numberOfSplits" => "--",
                                    "SplitProjectManager" => json_encode("--"),
                                    "ShareAmount" => json_encode("--"),
                                    "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus" => 'Refund',
                                    'refundID' =>  $findclient[0]->id,
                                    'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                    "remainingStatus" => $remainingStatus,
                                    "transactionType" => $paymentNature,
                                    "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                    "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                    "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                    "disputefee" =>  15,
                                    "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "Sheetdata" => "Invoicing Data"
                                ]);

                                $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                                if ($refundamt == 0) {
                                    $refundtype = 'Refund';
                                } else {
                                    $refundtype = 'Partial Refund';
                                }

                                $refund = RefundPayments::create([
                                    "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "PaymentID" => $createClientPaymentrefund,
                                    "basicAmount" => $allinvoices[0]['Total Amount'],
                                    "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "refundtype" => $refundtype,
                                    "refund_date" => $s1ql_date_dispute,
                                    "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                    "paymentType" => "Full payment",
                                    "splitmanagers" => json_encode("--"),
                                    "splitamounts" => json_encode("--"),
                                    "splitRefunds" => json_encode("--"),
                                    "transactionfee" => 0,
                                    "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                                ]);

                                $lostdispute = Disputedpayments::create([
                                    "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "PaymentID" => $createClientPaymentrefund,
                                    "dispute_Date" => $s1ql_date_dispute,
                                    "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    "disputeStatus" => "Lost",
                                    "disputefee"  => 15,
                                    "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],

                                ]);
                            }
                        } else {
                            //chargeback won

                            $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" =>  '--',
                                "ChargingMode" =>  '--',
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Won)",
                                "paymentDate" => $s1ql_date_dispute, //to view this problem
                                "SalesPerson" => $salesperson,
                                "TotalAmount" => $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "--",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => json_encode("--"),
                                "ShareAmount" => json_encode("--"),
                                "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                'refundID' =>  $findclient[0]->id,
                                'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "disputefee" =>  15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "Sheetdata" => "Invoicing Data"
                            ]);

                            $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                            if ($refundamt == 0) {
                                $refundtype = 'Refund';
                            } else {
                                $refundtype = 'Partial Refund';
                            }


                            $lostdispute = Disputedpayments::create([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => $findclient[0]->id,
                                "ProjectID" => $findproject,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "dispute_Date" => $s1ql_date_dispute,
                                "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "disputeStatus" => "Won",
                                "disputefee"  => 15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount']

                            ]);
                        }
                    }
                } else {
                    if ($allinvoices[0]['Balance Amount'] != "WON") {
                        if ($checktransactionIDget[0]->dispute == null) {
                            //simple refund
                            $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" =>  '--',
                                "ChargingMode" =>  '--',
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Refund)",
                                "paymentDate" => $s1ql_date_dispute, //to view this problem
                                "SalesPerson" => $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "--",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'Refund',
                                'refundID' =>   $allinvoices[0]['Transaction ID'],
                                'remainingID' => ($remamt == 0) ? null :  $allinvoices[0]['Transaction ID'],
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "Sheetdata" => "Invoicing Data",
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);

                            $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                            if ($refundamt == 0) {
                                $refundtype = 'Refund';
                            } else {
                                $refundtype = 'Partial Refund';
                            }

                            $refund = RefundPayments::create([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "basicAmount" => $allinvoices[0]['Total Amount'],
                                "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "refundtype" => $refundtype,
                                "refund_date" => $s1ql_date_dispute,
                                "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                "paymentType" => "Full payment",
                                "splitmanagers" => json_encode("--"),
                                "splitamounts" => json_encode("--"),
                                "splitRefunds" => json_encode("--"),
                                "transactionfee" => 0,
                                "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                            ]);
                        } else {
                            //refund due to chargeback lost
                            $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => $projectmanager,
                                "paymentNature" => $paymentNature,
                                "ChargingPlan" =>  '--',
                                "ChargingMode" =>  '--',
                                "Platform" => $allinvoices[0]['Platform'],
                                "Card_Brand" => $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => $allinvoices[0]['Transaction ID'] . "(Refund)",
                                "paymentDate" => $s1ql_date_dispute, //to view this problems
                                "SalesPerson" => $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "--",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'Refund',
                                'refundID' =>   $allinvoices[0]['Transaction ID'],
                                'remainingID' => ($remamt == 0) ? null :  $allinvoices[0]['Transaction ID'],
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "disputefee" =>  15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "Sheetdata" => "Invoicing Data",
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);

                            $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                            if ($refundamt == 0) {
                                $refundtype = 'Refund';
                            } else {
                                $refundtype = 'Partial Refund';
                            }

                            $refund = RefundPayments::create([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "basicAmount" => $allinvoices[0]['Total Amount'],
                                "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "refundtype" => $refundtype,
                                "refund_date" => $s1ql_date_dispute,
                                "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                "paymentType" => "Full payment",
                                "splitmanagers" => json_encode("--"),
                                "splitamounts" => json_encode("--"),
                                "splitRefunds" => json_encode("--"),
                                "transactionfee" => 0,
                                "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                            ]);

                            $lostdispute = Disputedpayments::create([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "dispute_Date" => $s1ql_date_dispute,
                                "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "disputeStatus" => "Lost",
                                "disputefee"  => 15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],

                            ]);
                        }
                    } else {
                        //chargeback won

                        $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                            "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" => 0,
                            "ProjectID" => 0,
                            "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                            "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                            "ChargingPlan" =>  '--',
                            "ChargingMode" =>  '--',
                            "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                            "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                            "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                            "bankWireUpload" =>  "--",
                            "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Won)",
                            "paymentDate" => $sql_date, //to view this problem
                            "SalesPerson" => $salesperson,
                            "TotalAmount" => $allinvoices[0]['Total Amount'],
                            "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                            "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                            "PaymentType" => "--",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => $a,
                            "ShareAmount" => $a,
                            "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            'refundID' =>  $allinvoices[0]['Transaction ID'],
                            'remainingID' => ($remamt == 0) ? null : $allinvoices[0]['Transaction ID'],
                            "remainingStatus" => $remainingStatus,
                            "transactionType" => $paymentNature,
                            "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                            "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                            "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                            "disputefee" =>  15,
                            "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                            "Sheetdata" => "Invoicing Data",
                            "disputeattack"  => $s1ql_date_dispute, //date
                            "disputeattackamount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                            "notfoundemail" => $allinvoices[0]['Email'],
                        ]);

                        $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                        if ($refundamt == 0) {
                            $refundtype = 'Refund';
                        } else {
                            $refundtype = 'Partial Refund';
                        }

                        $lostdispute = Disputedpayments::create([
                            "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" => 0,
                            "ProjectID" => 0,
                            "ProjectManager" => $projectmanager,
                            "PaymentID" => $createClientPaymentrefund,
                            "dispute_Date" => $sql_date,
                            "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                            "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                            "disputeStatus" => "Won",
                            "disputefee"  => 15,
                            "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount']

                        ]);
                    }
                }
            }
        }

        return redirect('/client/project/payment/all');
    }

    function csv_sheetpaymentsbitswits(Request $request)
    {
        $loginUser = $this->roleExits($request);
        return view('sheetpaymentUploadbitswits', [
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function csv_sheetpayments_processbitswits(Request $request)
    {
        ini_set('max_execution_time', 300);

        $a =  json_encode(["--"]);

        $data = Excel::toArray([], $request->file('bitswitsheetpayments'));
        $allinvoice = [];
        foreach ($data as $extractData) {
            $headings = $extractData[0];
            $keycount = count($headings);
            $maincount = count($extractData);

            for ($j = 1; $j < $maincount; $j++) {
                $newarray = [];
                for ($i = 0; $i < $keycount; $i++) {
                    $newarray[$headings[$i]] = $extractData[$j][$i];
                }
                $allinvoice[] = [$newarray];
            }
        }

        // echo("<pre>");
        // print_r($allinvoice);
        foreach ($allinvoice as $allinvoices) {
            $checktransactionID = NewPaymentsClients::where('TransactionID', $allinvoices[0]['Transaction ID'])->count();
            $mainemail =  strtolower($allinvoices[0]["Email"]);
            $sql_date = date("Y-m-d", strtotime($allinvoices[0]['Date']));
            if ($allinvoices[0]['Package Plan'] != "One Time" || $allinvoices[0]['Package Plan'] != null) {
                $sql_futuredate = date("Y-m-d", strtotime($allinvoices[0]['Recurring/Renewal']));
            }
            $matchclientmeta = Clientmeta::wherejsoncontains('otheremail', ($allinvoices[0]['Email']))->get();

            $sp = Employee::where('name', $allinvoices[0]['Sales Person'])->get();
            if (isset($sp[0]->id)) {
                $salesperson = $sp[0]->id;
            } else {
                $salesperson = 0;
            }

            $pm = Employee::where('name', $allinvoices[0]['Account Manager'])->get();
            if (isset($pm[0]->id)) {
                $projectmanager = $pm[0]->id;
            } else {
                $projectmanager = 0;
            }

            $remamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'];
            if ($remamt == 0) {
                $remainingStatus = "Not Remaining";
            } elseif ($remamt > 0) {
                $remainingStatus = "Remaining";
            }

            $findbrand = Brand::where('name', $allinvoices[0]['Brand'])->get();

            if ($allinvoices[0]['Package Plan'] == 'One Time') {
                $chargingplan = "One Time Payment";
                $chargingmode = "One Time Payment";
            } elseif ($allinvoices[0]['Package Plan'] == 'Recurring') {
                $chargingplan = "Monthly";
                $chargingmode = "Recurring";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal') {
                $chargingplan = "Monthly";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal2') {
                $chargingplan = "2 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal3') {
                $chargingplan = "3 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal4') {
                $chargingplan = "4 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal5') {
                $chargingplan = "5 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal6') {
                $chargingplan = "6 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal7') {
                $chargingplan = "7 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal8') {
                $chargingplan = "8 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal9') {
                $chargingplan = "9 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal10') {
                $chargingplan = "10 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal11') {
                $chargingplan = "11 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal12') {
                $chargingplan = "12 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal24') {
                $chargingplan = "2 Years";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal36') {
                $chargingplan = "3 Years";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Small Payment') {
                $chargingplan = "One Time Payment";
                $chargingmode = "One Time Payment";
            }

            if ($allinvoices[0]['Sales Mode'] == 'New Lead') {
                $paymentNature = "New Lead";
            } elseif ($allinvoices[0]['Sales Mode'] == 'New Sale') {
                $paymentNature = "New Sale";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Recurring') {
                $paymentNature = "Recurring Payment";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Renewal') {
                $paymentNature = "Renewal Payment";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Small Payment') {
                $paymentNature = "Small Paymente";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Up Sell') {
                $paymentNature = "Upsell";
            } elseif ($allinvoices[0]['Sales Mode'] == 'WON') {
                $paymentNature = "Dispute Won";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Remaining' || $allinvoices[0]['Sales Mode'] == 'FSRemaining') {
                $paymentNature = "Remaining";
            }

            $checktypeofremaining = $allinvoices[0]['Sales Mode'];



            if ($matchclientmeta->isNotEmpty()) {
                $findclient = Client::where('id', $matchclientmeta[0]->clientID)->get();
                $project = Project::where('clientID', $findclient[0]->id)->get();
                if (isset($project[0]->id)) {
                    $findproject = $project[0]->id;
                } else {
                    $findproject = 0;
                }
                $count = count($findclient);
                if ($count == 1) {

                    if ($paymentNature != "Dispute Won") {
                        if ($checktypeofremaining == 'FSRemaining') {
                            $createClientPayment = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                                "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => "--",
                                "Payment_Gateway" => "--",
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                                "paymentDate" => $sql_date,
                                "futuredate" => ($allinvoices[0]['Package Plan'] == "One Time" || $allinvoices[0]['Package Plan'] == null) ? null : $sql_futuredate, //to view this problem
                                "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "Full Payment",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                // 'refundID' => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $findclient[0]->id,
                                'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => "New Lead",
                                // "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "Sheetdata" => "Invoicing Data",
                                // "disputeattack" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $sql_date_dispute,
                                // "disputeattackamount" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);
                        } else {
                            $createClientPayment = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                                "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => "--",
                                "Payment_Gateway" => "--",
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                                "paymentDate" => $sql_date,
                                "futuredate" => ($allinvoices[0]['Package Plan'] == "One Time" || $allinvoices[0]['Package Plan'] == null) ? null : $sql_futuredate, //to view this problem
                                "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "Full Payment",
                                "numberOfSplits" =>  "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                // "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                // "refundID" => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $findclient[0]->id,
                                "remainingID" => ($remamt == 0) ? null : $findclient[0]->id,
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                // "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "Sheetdata" => "Invoicing Data",
                                // "disputeattack" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $sql_date_dispute,
                                // "disputeattackamount" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);
                        }
                    } else {
                        continue;
                        // echo ("<br>");
                        // echo ($allinvoices[0]['Transaction ID']);
                    }
                } else {
                    continue;
                }
            } else {

                if ($paymentNature != "Dispute Won") {
                    if ($checktypeofremaining == 'FSRemaining') {
                        $createClientPayment = NewPaymentsClients::insertGetId([
                            "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" =>  0,
                            "ProjectID" => 0,
                            "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                            "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                            "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                            "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                            "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                            "Card_Brand" => "--",
                            "Payment_Gateway" => "--",
                            "bankWireUpload" =>  "--",
                            "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                            "paymentDate" => $sql_date,
                            "futuredate" => ($allinvoices[0]['Package Plan'] == "One Time" || $allinvoices[0]['Package Plan'] == null) ? null : $sql_futuredate, //to view this problem
                            "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                            "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                            "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                            "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                            "PaymentType" => "Full Payment",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => $a,
                            "ShareAmount" => $a,
                            "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            // 'refundID' => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $allinvoices[0]['Transaction ID'],
                            'remainingID' => ($remamt == 0) ? null : $allinvoices[0]['Transaction ID'],
                            "remainingStatus" => $remainingStatus,
                            "transactionType" => "New Lead",
                            // "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                            "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                            "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                            "Sheetdata" => "Invoicing Data",
                            // "disputeattack" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $sql_date_dispute,
                            // "disputeattackamount" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                            "notfoundemail" => $allinvoices[0]['Email'],
                        ]);
                    } else {
                        $createClientPayment = NewPaymentsClients::insertGetId([
                            "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" =>  0,
                            "ProjectID" => 0,
                            "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                            "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                            "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                            "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                            "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                            "Card_Brand" => "--",
                            "Payment_Gateway" => "--",
                            "bankWireUpload" =>  "--",
                            "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                            "paymentDate" => $sql_date,
                            "futuredate" => ($allinvoices[0]['Package Plan'] == "One Time" || $allinvoices[0]['Package Plan'] == null) ? null : $sql_futuredate, //to view this problem
                            "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                            "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                            "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                            "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                            "PaymentType" => "Full Payment",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => $a,
                            "ShareAmount" => $a,
                            "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            // 'refundID' => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $allinvoices[0]['Transaction ID'],
                            'remainingID' => ($remamt == 0) ? null : $allinvoices[0]['Transaction ID'],
                            "remainingStatus" => $remainingStatus,
                            "transactionType" => $paymentNature,
                            // "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                            "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                            "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                            "Sheetdata" => "Invoicing Data",
                            // "disputeattack" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $sql_date_dispute,
                            // "disputeattackamount" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                            "notfoundemail" => $allinvoices[0]['Email'],
                        ]);
                    }
                }
            }
        }

        return redirect('/client/project/payment/all');
    }

    function csv_sheetpaymentsClientFirstSMM(Request $request)
    {
        $loginUser = $this->roleExits($request);
        return view('sheetpaymentUploadClieckfirstSMM', [
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function csv_sheetpayments_processClientFirstSMM(Request $request)
    {
        ini_set('max_execution_time', 300);

        $a =  json_encode(["--"]);

        $data = Excel::toArray([], $request->file('clicksheetpayments'));
        $allinvoice = [];
        foreach ($data as $extractData) {
            $headings = $extractData[0];
            $keycount = count($headings);
            $maincount = count($extractData);

            for ($j = 1; $j < $maincount; $j++) {
                $newarray = [];
                for ($i = 0; $i < $keycount; $i++) {
                    $newarray[$headings[$i]] = $extractData[$j][$i];
                }
                $allinvoice[] = [$newarray];
            }
        }

        // echo ("<pre>");
        // print_r($allinvoice);
        // die();
        foreach ($allinvoice as $allinvoices) {
            $checktransactionID = NewPaymentsClients::where('TransactionID', $allinvoices[0]['Transaction ID'])->count();
            $mainemail =  strtolower($allinvoices[0]["Email"]);
            $sql_date = date("Y-m-d", strtotime($allinvoices[0]['Date']));
            if ($allinvoices[0]['Package Plan'] != "One Time" || $allinvoices[0]['Package Plan'] != null) {
                $sql_futuredate = date("Y-m-d", strtotime($allinvoices[0]['Recurring/Renewal']));
            }

            if (isset($allinvoices[0]['Refund/Dispute Date']) && $allinvoices[0]['Refund/Dispute Date'] != null) {
                $sql_date_dispute = date("Y-m-d", strtotime($allinvoices[0]['Refund/Dispute Date']));
            }
            $matchclientmeta = Clientmeta::wherejsoncontains('otheremail', ($allinvoices[0]['Email']))->get();

            $sp = Employee::where('name', $allinvoices[0]['Sales Person'])->get();
            if (isset($sp[0]->id)) {
                $salesperson = $sp[0]->id;
            } else {
                $salesperson = 0;
            }

            $pm = Employee::where('name', $allinvoices[0]['Account Manager'])->get();
            if (isset($pm[0]->id)) {
                $projectmanager = $pm[0]->id;
            } else {
                $projectmanager = 0;
            }

            $remamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'];
            if ($remamt == 0) {
                $remainingStatus = "Not Remaining";
            } elseif ($remamt > 0) {
                $remainingStatus = "Remaining";
            }

            $findbrand = Brand::where('name', $allinvoices[0]['Brand'])->get();

            if ($allinvoices[0]['Package Plan'] == 'One Time') {
                $chargingplan = "One Time Payment";
                $chargingmode = "One Time Payment";
            } elseif ($allinvoices[0]['Package Plan'] == 'Recurring') {
                $chargingplan = "Monthly";
                $chargingmode = "Recurring";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal') {
                $chargingplan = "Monthly";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal2') {
                $chargingplan = "2 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal3') {
                $chargingplan = "3 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal4') {
                $chargingplan = "4 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal5') {
                $chargingplan = "5 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal6') {
                $chargingplan = "6 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal7') {
                $chargingplan = "7 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal8') {
                $chargingplan = "8 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal9') {
                $chargingplan = "9 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal10') {
                $chargingplan = "10 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal11') {
                $chargingplan = "11 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal12') {
                $chargingplan = "12 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal24') {
                $chargingplan = "2 Years";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal36') {
                $chargingplan = "3 Years";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Small Payment') {
                $chargingplan = "One Time Payment";
                $chargingmode = "One Time Payment";
            }

            if ($allinvoices[0]['Sales Mode'] == 'New Lead') {
                $paymentNature = "New Lead";
            } elseif ($allinvoices[0]['Sales Mode'] == 'New Sale') {
                $paymentNature = "New Sale";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Recurring') {
                $paymentNature = "Recurring Payment";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Renewal') {
                $paymentNature = "Renewal Payment";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Small Payment') {
                $paymentNature = "Small Paymente";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Up Sell') {
                $paymentNature = "Upsell";
            } elseif ($allinvoices[0]['Sales Mode'] == 'WON') {
                $paymentNature = "Dispute Won";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Remaining' || $allinvoices[0]['Sales Mode'] == 'FSRemaining') {
                $paymentNature = "Remaining";
            }

            $checktypeofremaining = $allinvoices[0]['Sales Mode'];



            if ($matchclientmeta->isNotEmpty()) {
                $findclient = Client::where('id', $matchclientmeta[0]->clientID)->get();
                $project = Project::where('clientID', $findclient[0]->id)->get();
                if (isset($project[0]->id)) {
                    $findproject = $project[0]->id;
                } else {
                    $findproject = 0;
                }
                $count = count($findclient);
                if ($count == 1) {

                    if ($allinvoices[0]['Balance Amount'] != "WON") {
                        if ($checktypeofremaining == 'FSRemaining') {
                            $createClientPayment = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                                "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => "--",
                                "Payment_Gateway" => "--",
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                                "paymentDate" => $sql_date,
                                "futuredate" => ($allinvoices[0]['Package Plan'] == "One Time" || $allinvoices[0]['Package Plan'] == null) ? null : $sql_futuredate, //to view this problem
                                "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "Full Payment",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                'refundID' => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $findclient[0]->id,
                                'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => "New Lead",
                                "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "Sheetdata" => "Invoicing Data",
                                "disputeattack" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $sql_date_dispute,
                                "disputeattackamount" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);
                        } else {
                            $createClientPayment = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                                "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => "--",
                                "Payment_Gateway" => "--",
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                                "paymentDate" => $sql_date,
                                "futuredate" => ($allinvoices[0]['Package Plan'] == "One Time" || $allinvoices[0]['Package Plan'] == null) ? null : $sql_futuredate, //to view this problem
                                "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "Full Payment",
                                "numberOfSplits" =>  "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                "refundID" => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $findclient[0]->id,
                                "remainingID" => ($remamt == 0) ? null : $findclient[0]->id,
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "Sheetdata" => "Invoicing Data",
                                "disputeattack" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $sql_date_dispute,
                                "disputeattackamount" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);
                        }
                    } else {
                        continue;
                    }
                } else {
                    continue;
                }
            } else {

                if ($allinvoices[0]['Balance Amount'] != "WON") {
                    if ($checktypeofremaining == 'FSRemaining') {
                        $createClientPayment = NewPaymentsClients::insertGetId([
                            "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" =>  0,
                            "ProjectID" => 0,
                            "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                            "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                            "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                            "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                            "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                            "Card_Brand" => "--",
                            "Payment_Gateway" => "--",
                            "bankWireUpload" =>  "--",
                            "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                            "paymentDate" => $sql_date,
                            "futuredate" => ($allinvoices[0]['Package Plan'] == "One Time" || $allinvoices[0]['Package Plan'] == null) ? null : $sql_futuredate, //to view this problem
                            "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                            "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                            "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                            "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                            "PaymentType" => "Full Payment",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => $a,
                            "ShareAmount" => $a,
                            "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            'refundID' => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $allinvoices[0]['Transaction ID'],
                            'remainingID' => ($remamt == 0) ? null : $allinvoices[0]['Transaction ID'],
                            "remainingStatus" => $remainingStatus,
                            "transactionType" => "New Lead",
                            "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                            "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                            "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                            "Sheetdata" => "Invoicing Data",
                            "disputeattack" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $sql_date_dispute,
                            "disputeattackamount" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                            "notfoundemail" => $allinvoices[0]['Email'],
                        ]);
                    } else {
                        $createClientPayment = NewPaymentsClients::insertGetId([
                            "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" =>  0,
                            "ProjectID" => 0,
                            "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                            "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                            "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                            "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                            "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                            "Card_Brand" => "--",
                            "Payment_Gateway" => "--",
                            "bankWireUpload" =>  "--",
                            "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                            "paymentDate" => $sql_date,
                            "futuredate" => ($allinvoices[0]['Package Plan'] == "One Time" || $allinvoices[0]['Package Plan'] == null) ? null : $sql_futuredate, //to view this problem
                            "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                            "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                            "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                            "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                            "PaymentType" => "Full Payment",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => $a,
                            "ShareAmount" => $a,
                            "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            'refundID' => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $allinvoices[0]['Transaction ID'],
                            'remainingID' => ($remamt == 0) ? null : $allinvoices[0]['Transaction ID'],
                            "remainingStatus" => $remainingStatus,
                            "transactionType" => $paymentNature,
                            "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                            "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                            "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                            "Sheetdata" => "Invoicing Data",
                            "disputeattack" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $sql_date_dispute,
                            "disputeattackamount" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                            "notfoundemail" => $allinvoices[0]['Email'],
                        ]);
                    }
                }
            }
        }

        // for_refund:
        foreach ($allinvoice as $allinvoices) {
            $findbrand = Brand::where('name', $allinvoices[0]['Brand'])->get();
            $checktypeofremaining = $allinvoices[0]['Sales Mode'];
            $checktransactionIDget = NewPaymentsClients::where('TransactionID', $allinvoices[0]['Transaction ID'])->where('refundID', '!=', null)->get();
            $checktransactionID = NewPaymentsClients::where('TransactionID', $allinvoices[0]['Transaction ID'])->where('refundID', '!=', null)->count();
            if ($checktransactionID == 1) {
                $mainemail = $allinvoices[0]["Email"];
                $sql_date = date("Y-m-d", strtotime($allinvoices[0]['Date']));

                if (isset($allinvoices[0]['Refund/Dispute Date']) && $allinvoices[0]['Refund/Dispute Date'] != null) {
                    $s1ql_date_dispute = date("Y-m-d", strtotime($allinvoices[0]['Refund/Dispute Date']));
                }

                $matchclientmeta = Clientmeta::wherejsoncontains('otheremail', ($allinvoices[0]['Email']))->get();

                $sp = Employee::where('name', $allinvoices[0]['Sales Person'])->get();
                if (isset($sp[0]->id)) {
                    $salesperson = $sp[0]->id;
                } else {
                    $salesperson = 0;
                }

                $pm = Employee::where('name', $allinvoices[0]['Account Manager'])->get();
                if (isset($pm[0]->id)) {
                    $projectmanager = $pm[0]->id;
                } else {
                    $projectmanager = 0;
                }

                $remamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'];
                if ($remamt == 0) {
                    $remainingStatus = "Not Remaining";
                } elseif ($remamt > 0) {
                    $remainingStatus = "Remaining";
                }


                if ($allinvoices[0]['Sales Mode'] == 'New Lead') {
                    $paymentNature = "New Lead";
                } elseif ($allinvoices[0]['Sales Mode'] == 'New Sale') {
                    $paymentNature = "New Sale";
                } elseif ($allinvoices[0]['Sales Mode'] == 'FSRemaining' || $allinvoices[0]['Sales Mode'] == 'Remaining') {
                    $paymentNature = "New Sale";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Recurring') {
                    $paymentNature = "Recurring Payment";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Renewal') {
                    $paymentNature = "Renewal Payment";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Small Payment') {
                    $paymentNature = "Small Paymente";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Up Sell') {
                    $paymentNature = "Upsell";
                } elseif ($allinvoices[0]['Sales Mode'] == 'WON') {
                    $paymentNature = "Dispute Won";
                }

                if ($matchclientmeta->isNotEmpty()) {
                    $findclient = Client::where('id', $matchclientmeta[0]->clientID)->get();
                    $project = Project::where('clientID', $findclient[0]->id)->get();
                    if (isset($project[0]->id)) {
                        $findproject = $project[0]->id;
                    } else {
                        $findproject = 0;
                    }
                    $count = count($findclient);
                    if ($count == 1) {

                        if ($allinvoices[0]['Balance Amount'] != "WON") {
                            if ($checktransactionIDget[0]->dispute == null) {
                                //simple refund
                                $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                    "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                    "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                    "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                    "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                    "ChargingPlan" =>  '--',
                                    "ChargingMode" =>  '--',
                                    "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                    "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                    "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                    "bankWireUpload" =>  "--",
                                    "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Refund)",
                                    "paymentDate" => $s1ql_date_dispute, //to view this problem
                                    "SalesPerson" => $salesperson,
                                    "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                    "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                    "PaymentType" => "--",
                                    "numberOfSplits" => "--",
                                    "SplitProjectManager" => json_encode("--"),
                                    "ShareAmount" => json_encode("--"),
                                    "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus" => 'Refund',
                                    'refundID' =>  $findclient[0]->id,
                                    'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                    "remainingStatus" => $remainingStatus,
                                    "transactionType" => $paymentNature,
                                    "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                    "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                    "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                    "Sheetdata" => "Invoicing Data"
                                ]);

                                $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                                if ($refundamt == 0) {
                                    $refundtype = 'Refund';
                                } else {
                                    $refundtype = 'Partial Refund';
                                }

                                $refund = RefundPayments::create([
                                    "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "PaymentID" => $createClientPaymentrefund,
                                    "basicAmount" => $allinvoices[0]['Total Amount'],
                                    "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "refundtype" => $refundtype,
                                    "refund_date" => $s1ql_date_dispute,
                                    "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                    "paymentType" => "Full payment",
                                    "splitmanagers" => json_encode("--"),
                                    "splitamounts" => json_encode("--"),
                                    "splitRefunds" => json_encode("--"),
                                    "transactionfee" => 0,
                                    "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                                ]);
                            } else {
                                //refund due to chargeback lost
                                $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                    "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "paymentNature" => $paymentNature,
                                    "ChargingPlan" =>  '--',
                                    "ChargingMode" =>  '--',
                                    "Platform" => $allinvoices[0]['Platform'],
                                    "Card_Brand" => $allinvoices[0]['Card Brand'],
                                    "Payment_Gateway" => $allinvoices[0]['Payment Gateway'],
                                    "bankWireUpload" =>  "--",
                                    "TransactionID" => $allinvoices[0]['Transaction ID'] . "(Refund)",
                                    "paymentDate" => $s1ql_date_dispute, //to view this problem
                                    "SalesPerson" => $salesperson,
                                    "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                    "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                    "PaymentType" => "--",
                                    "numberOfSplits" => "--",
                                    "SplitProjectManager" => json_encode("--"),
                                    "ShareAmount" => json_encode("--"),
                                    "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus" => 'Refund',
                                    'refundID' =>  $findclient[0]->id,
                                    'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                    "remainingStatus" => $remainingStatus,
                                    "transactionType" => $paymentNature,
                                    "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                    "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                    "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                    "disputefee" =>  15,
                                    "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "Sheetdata" => "Invoicing Data"
                                ]);

                                $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                                if ($refundamt == 0) {
                                    $refundtype = 'Refund';
                                } else {
                                    $refundtype = 'Partial Refund';
                                }

                                $refund = RefundPayments::create([
                                    "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "PaymentID" => $createClientPaymentrefund,
                                    "basicAmount" => $allinvoices[0]['Total Amount'],
                                    "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "refundtype" => $refundtype,
                                    "refund_date" => $s1ql_date_dispute,
                                    "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                    "paymentType" => "Full payment",
                                    "splitmanagers" => json_encode("--"),
                                    "splitamounts" => json_encode("--"),
                                    "splitRefunds" => json_encode("--"),
                                    "transactionfee" => 0,
                                    "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                                ]);

                                $lostdispute = Disputedpayments::create([
                                    "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "PaymentID" => $createClientPaymentrefund,
                                    "dispute_Date" => $s1ql_date_dispute,
                                    "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    "disputeStatus" => "Lost",
                                    "disputefee"  => 15,
                                    "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],

                                ]);
                            }
                        } else {
                            //chargeback won

                            $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" =>  '--',
                                "ChargingMode" =>  '--',
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Won)",
                                "paymentDate" => $s1ql_date_dispute, //to view this problem
                                "SalesPerson" => $salesperson,
                                "TotalAmount" => $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "--",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => json_encode("--"),
                                "ShareAmount" => json_encode("--"),
                                "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                'refundID' =>  $findclient[0]->id,
                                'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "disputefee" =>  15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "Sheetdata" => "Invoicing Data"
                            ]);

                            $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                            if ($refundamt == 0) {
                                $refundtype = 'Refund';
                            } else {
                                $refundtype = 'Partial Refund';
                            }


                            $lostdispute = Disputedpayments::create([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => $findclient[0]->id,
                                "ProjectID" => $findproject,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "dispute_Date" => $s1ql_date_dispute,
                                "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "disputeStatus" => "Won",
                                "disputefee"  => 15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount']

                            ]);
                        }
                    }
                } else {
                    if ($allinvoices[0]['Balance Amount'] != "WON") {
                        if ($checktransactionIDget[0]->dispute == null) {
                            //simple refund
                            $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" =>  '--',
                                "ChargingMode" =>  '--',
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Refund)",
                                "paymentDate" => $s1ql_date_dispute, //to view this problem
                                "SalesPerson" => $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "--",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'Refund',
                                'refundID' =>   $allinvoices[0]['Transaction ID'],
                                'remainingID' => ($remamt == 0) ? null :  $allinvoices[0]['Transaction ID'],
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "Sheetdata" => "Invoicing Data",
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);

                            $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                            if ($refundamt == 0) {
                                $refundtype = 'Refund';
                            } else {
                                $refundtype = 'Partial Refund';
                            }

                            $refund = RefundPayments::create([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "basicAmount" => $allinvoices[0]['Total Amount'],
                                "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "refundtype" => $refundtype,
                                "refund_date" => $s1ql_date_dispute,
                                "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                "paymentType" => "Full payment",
                                "splitmanagers" => json_encode("--"),
                                "splitamounts" => json_encode("--"),
                                "splitRefunds" => json_encode("--"),
                                "transactionfee" => 0,
                                "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                            ]);
                        } else {
                            //refund due to chargeback lost
                            $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => $projectmanager,
                                "paymentNature" => $paymentNature,
                                "ChargingPlan" =>  '--',
                                "ChargingMode" =>  '--',
                                "Platform" => $allinvoices[0]['Platform'],
                                "Card_Brand" => $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => $allinvoices[0]['Transaction ID'] . "(Refund)",
                                "paymentDate" => $s1ql_date_dispute, //to view this problems
                                "SalesPerson" => $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "--",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'Refund',
                                'refundID' =>   $allinvoices[0]['Transaction ID'],
                                'remainingID' => ($remamt == 0) ? null :  $allinvoices[0]['Transaction ID'],
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "disputefee" =>  15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "Sheetdata" => "Invoicing Data",
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);

                            $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                            if ($refundamt == 0) {
                                $refundtype = 'Refund';
                            } else {
                                $refundtype = 'Partial Refund';
                            }

                            $refund = RefundPayments::create([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "basicAmount" => $allinvoices[0]['Total Amount'],
                                "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "refundtype" => $refundtype,
                                "refund_date" => $s1ql_date_dispute,
                                "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                "paymentType" => "Full payment",
                                "splitmanagers" => json_encode("--"),
                                "splitamounts" => json_encode("--"),
                                "splitRefunds" => json_encode("--"),
                                "transactionfee" => 0,
                                "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                            ]);

                            $lostdispute = Disputedpayments::create([
                                "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "dispute_Date" => $s1ql_date_dispute,
                                "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "disputeStatus" => "Lost",
                                "disputefee"  => 15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],

                            ]);
                        }
                    } else {
                        //chargeback won

                        $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                            "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" => 0,
                            "ProjectID" => 0,
                            "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                            "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                            "ChargingPlan" =>  '--',
                            "ChargingMode" =>  '--',
                            "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                            "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                            "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                            "bankWireUpload" =>  "--",
                            "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Won)",
                            "paymentDate" => $sql_date, //to view this problem
                            "SalesPerson" => $salesperson,
                            "TotalAmount" => $allinvoices[0]['Total Amount'],
                            "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                            "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                            "PaymentType" => "--",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => $a,
                            "ShareAmount" => $a,
                            "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            'refundID' =>  $allinvoices[0]['Transaction ID'],
                            'remainingID' => ($remamt == 0) ? null : $allinvoices[0]['Transaction ID'],
                            "remainingStatus" => $remainingStatus,
                            "transactionType" => $paymentNature,
                            "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                            "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                            "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                            "disputefee" =>  15,
                            "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                            "Sheetdata" => "Invoicing Data",
                            "disputeattack"  => $s1ql_date_dispute, //date
                            "disputeattackamount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                            "notfoundemail" => $allinvoices[0]['Email'],
                        ]);

                        $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                        if ($refundamt == 0) {
                            $refundtype = 'Refund';
                        } else {
                            $refundtype = 'Partial Refund';
                        }

                        $lostdispute = Disputedpayments::create([
                            "BrandID" => ($findbrand == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" => 0,
                            "ProjectID" => 0,
                            "ProjectManager" => $projectmanager,
                            "PaymentID" => $createClientPaymentrefund,
                            "dispute_Date" => $sql_date,
                            "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                            "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                            "disputeStatus" => "Won",
                            "disputefee"  => 15,
                            "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount']

                        ]);
                    }
                }
            }
        }

        return redirect('/client/project/payment/all');
    }

    function csv_sheetpaymentscreative(Request $request)
    {
        $loginUser = $this->roleExits($request);
        return view('sheetpaymentUploadCreative', [
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function csv_sheetpayments_processcreative(Request $request)
    {
        ini_set('max_execution_time', 300);

        $a =  json_encode(["--"]);

        $data = Excel::toArray([], $request->file('creativesheetpayments'));
        $allinvoice = [];
        foreach ($data as $extractData) {
            $headings = $extractData[0];
            $keycount = count($headings);
            $maincount = count($extractData);

            for ($j = 1; $j < $maincount; $j++) {
                $newarray = [];
                for ($i = 0; $i < $keycount; $i++) {
                    $newarray[$headings[$i]] = $extractData[$j][$i];
                }
                $allinvoice[] = [$newarray];
            }
        }

        foreach ($allinvoice as $allinvoices) {
            $checktransactionID = NewPaymentsClients::where('TransactionID', $allinvoices[0]['Transaction ID'])->count();
            $mainemail =  strtolower($allinvoices[0]["Email"]);
            $sql_date = date("Y-m-d", strtotime($allinvoices[0]['Date']));
            if ($allinvoices[0]['Package Plan'] != "One Time" || $allinvoices[0]['Package Plan'] != null) {
                $sql_futuredate = date("Y-m-d", strtotime($allinvoices[0]['Recurring/Renewal']));
            }

            if (isset($allinvoices[0]['Refund/Dispute Date']) && $allinvoices[0]['Refund/Dispute Date'] != null) {
                $sql_date_dispute = date("Y-m-d", strtotime($allinvoices[0]['Refund/Dispute Date']));
            }
            $matchclientmeta = Clientmeta::wherejsoncontains('otheremail', ($allinvoices[0]['Email']))->get();

            $sp = Employee::where('name', $allinvoices[0]['Sales Person'])->get();
            if (isset($sp[0]->id)) {
                $salesperson = $sp[0]->id;
            } else {
                $salesperson = 0;
            }

            $pm = Employee::where('name', $allinvoices[0]['Account Manager'])->get();
            if (isset($pm[0]->id)) {
                $projectmanager = $pm[0]->id;
            } else {
                $projectmanager = 0;
            }

            $remamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'];
            if ($remamt == 0) {
                $remainingStatus = "Not Remaining";
            } elseif ($remamt > 0) {
                $remainingStatus = "Remaining";
            }

            $findbrand = Brand::where('name', $allinvoices[0]['Brand'])->get();

            if ($allinvoices[0]['Package Plan'] == 'One Time') {
                $chargingplan = "One Time Payment";
                $chargingmode = "One Time Payment";
            } elseif ($allinvoices[0]['Package Plan'] == 'Recurring') {
                $chargingplan = "Monthly";
                $chargingmode = "Recurring";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal') {
                $chargingplan = "Monthly";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal2') {
                $chargingplan = "2 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal3') {
                $chargingplan = "3 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal4') {
                $chargingplan = "4 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal5') {
                $chargingplan = "5 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal6') {
                $chargingplan = "6 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal7') {
                $chargingplan = "7 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal8') {
                $chargingplan = "8 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal9') {
                $chargingplan = "9 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal10') {
                $chargingplan = "10 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal11') {
                $chargingplan = "11 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal12') {
                $chargingplan = "12 Months";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal24') {
                $chargingplan = "2 Years";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Renewal36') {
                $chargingplan = "3 Years";
                $chargingmode = "Renewal";
            } elseif ($allinvoices[0]['Package Plan'] == 'Small Payment') {
                $chargingplan = "One Time Payment";
                $chargingmode = "One Time Payment";
            }

            if ($allinvoices[0]['Sales Mode'] == 'New Lead') {
                $paymentNature = "New Lead";
            } elseif ($allinvoices[0]['Sales Mode'] == 'New Sale') {
                $paymentNature = "New Sale";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Recurring') {
                $paymentNature = "Recurring Payment";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Renewal') {
                $paymentNature = "Renewal Payment";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Small Payment') {
                $paymentNature = "Small Paymente";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Up Sell') {
                $paymentNature = "Upsell";
            } elseif ($allinvoices[0]['Sales Mode'] == 'WON') {
                $paymentNature = "Dispute Won";
            } elseif ($allinvoices[0]['Sales Mode'] == 'Remaining' || $allinvoices[0]['Sales Mode'] == 'FSRemaining') {
                $paymentNature = "Remaining";
            }

            $checktypeofremaining = $allinvoices[0]['Sales Mode'];



            if ($matchclientmeta->isNotEmpty()) {
                $findclient = Client::where('id', $matchclientmeta[0]->clientID)->get();
                $project = Project::where('clientID', $findclient[0]->id)->get();
                if (isset($project[0]->id)) {
                    $findproject = $project[0]->id;
                } else {
                    $findproject = 0;
                }
                $count = count($findclient);
                if ($count == 1) {

                    if ($allinvoices[0]['Balance Amount'] != "WON") {
                        if ($checktypeofremaining == 'FSRemaining') {
                            $createClientPayment = NewPaymentsClients::insertGetId([
                                "BrandID" => (!isset($findbrand[0]->id)) ? 0 :  $findbrand[0]->id,
                                "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                                "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => "--",
                                "Payment_Gateway" => "--",
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                                "paymentDate" => $sql_date,
                                "futuredate" => ($allinvoices[0]['Package Plan'] == "One Time" || $allinvoices[0]['Package Plan'] == null) ? null : $sql_futuredate, //to view this problem
                                "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "Full Payment",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                'refundID' => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $findclient[0]->id,
                                'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => "New Lead",
                                "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "Sheetdata" => "Invoicing Data",
                                "disputeattack" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $sql_date_dispute,
                                "disputeattackamount" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);
                        } else {
                            $createClientPayment = NewPaymentsClients::insertGetId([
                                "BrandID" => (!isset($findbrand[0]->id)) ? 0 :  $findbrand[0]->id,
                                "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                                "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => "--",
                                "Payment_Gateway" => "--",
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                                "paymentDate" => $sql_date,
                                "futuredate" => ($allinvoices[0]['Package Plan'] == "One Time" || $allinvoices[0]['Package Plan'] == null) ? null : $sql_futuredate, //to view this problem
                                "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "Full Payment",
                                "numberOfSplits" =>  "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                "refundID" => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $findclient[0]->id,
                                "remainingID" => ($remamt == 0) ? null : $findclient[0]->id,
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Status'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "Sheetdata" => "Invoicing Data",
                                "disputeattack" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $sql_date_dispute,
                                "disputeattackamount" => ($allinvoices[0]['Status'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);
                        }
                    } else {
                        continue;
                    }
                } else {
                    continue;
                }
            } else {

                if ($allinvoices[0]['Balance Amount'] != "WON") {
                    if ($checktypeofremaining == 'FSRemaining') {
                        $createClientPayment = NewPaymentsClients::insertGetId([
                            "BrandID" => (!isset($findbrand[0]->id)) ? 0 :  $findbrand[0]->id,
                            "ClientID" =>  0,
                            "ProjectID" => 0,
                            "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                            "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                            "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                            "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                            "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                            "Card_Brand" => "--",
                            "Payment_Gateway" => "--",
                            "bankWireUpload" =>  "--",
                            "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                            "paymentDate" => $sql_date,
                            "futuredate" => ($allinvoices[0]['Package Plan'] == "One Time" || $allinvoices[0]['Package Plan'] == null) ? null : $sql_futuredate, //to view this problem
                            "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                            "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                            "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                            "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                            "PaymentType" => "Full Payment",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => $a,
                            "ShareAmount" => $a,
                            "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            'refundID' => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $allinvoices[0]['Transaction ID'],
                            'remainingID' => ($remamt == 0) ? null : $allinvoices[0]['Transaction ID'],
                            "remainingStatus" => $remainingStatus,
                            "transactionType" => "New Lead",
                            "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                            "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                            "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                            "Sheetdata" => "Invoicing Data",
                            "disputeattack" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $sql_date_dispute,
                            "disputeattackamount" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                            "notfoundemail" => $allinvoices[0]['Email'],
                        ]);
                    } else {
                        $createClientPayment = NewPaymentsClients::insertGetId([
                            "BrandID" => (!isset($findbrand[0]->id)) ? 0 :  $findbrand[0]->id,
                            "ClientID" =>  0,
                            "ProjectID" => 0,
                            "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                            "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                            "ChargingPlan" => ($chargingplan == null) ? 0 :  $chargingplan,
                            "ChargingMode" => ($chargingmode == null) ? 0 :   $chargingmode,
                            "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                            "Card_Brand" => "--",
                            "Payment_Gateway" => "--",
                            "bankWireUpload" =>  "--",
                            "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'],
                            "paymentDate" => $sql_date,
                            "futuredate" => ($allinvoices[0]['Package Plan'] == "One Time" || $allinvoices[0]['Package Plan'] == null) ? null : $sql_futuredate, //to view this problem
                            "SalesPerson" => ($salesperson == null) ? 0 :  $salesperson,
                            "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                            "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :  $allinvoices[0]['Paid'],
                            "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                            "PaymentType" => "Full Payment",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => $a,
                            "ShareAmount" => $a,
                            "Description" => ($allinvoices[0]['Description'] == null) ? 0 :   $allinvoices[0]['Description'],
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            'refundID' => ($allinvoices[0]['Refund/Dispute Date'] == null) ? null :  $allinvoices[0]['Transaction ID'],
                            'remainingID' => ($remamt == 0) ? null : $allinvoices[0]['Transaction ID'],
                            "remainingStatus" => $remainingStatus,
                            "transactionType" => $paymentNature,
                            "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                            "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                            "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                            "Sheetdata" => "Invoicing Data",
                            "disputeattack" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $sql_date_dispute,
                            "disputeattackamount" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : $allinvoices[0]['Refund/Dispute Amount'],
                            "notfoundemail" => $allinvoices[0]['Email'],
                        ]);
                    }
                }
            }
        }

        // for_refund:
        foreach ($allinvoice as $allinvoices) {
            $findbrand = Brand::where('name', $allinvoices[0]['Brand'])->get();
            $checktypeofremaining = $allinvoices[0]['Sales Mode'];
            $checktransactionIDget = NewPaymentsClients::where('TransactionID', $allinvoices[0]['Transaction ID'])->where('refundID', '!=', null)->get();
            $checktransactionID = NewPaymentsClients::where('TransactionID', $allinvoices[0]['Transaction ID'])->where('refundID', '!=', null)->count();
            if ($checktransactionID == 1) {
                $mainemail = $allinvoices[0]["Email"];
                $sql_date = date("Y-m-d", strtotime($allinvoices[0]['Date']));

                if (isset($allinvoices[0]['Refund/Dispute Date']) && $allinvoices[0]['Refund/Dispute Date'] != null) {
                    $s1ql_date_dispute = date("Y-m-d", strtotime($allinvoices[0]['Refund/Dispute Date']));
                }

                $matchclientmeta = Clientmeta::wherejsoncontains('otheremail', ($allinvoices[0]['Email']))->get();

                $sp = Employee::where('name', $allinvoices[0]['Sales Person'])->get();
                if (isset($sp[0]->id)) {
                    $salesperson = $sp[0]->id;
                } else {
                    $salesperson = 0;
                }

                $pm = Employee::where('name', $allinvoices[0]['Account Manager'])->get();
                if (isset($pm[0]->id)) {
                    $projectmanager = $pm[0]->id;
                } else {
                    $projectmanager = 0;
                }

                $remamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'];
                if ($remamt == 0) {
                    $remainingStatus = "Not Remaining";
                } elseif ($remamt > 0) {
                    $remainingStatus = "Remaining";
                }


                if ($allinvoices[0]['Sales Mode'] == 'New Lead') {
                    $paymentNature = "New Lead";
                } elseif ($allinvoices[0]['Sales Mode'] == 'New Sale') {
                    $paymentNature = "New Sale";
                } elseif ($allinvoices[0]['Sales Mode'] == 'FSRemaining' || $allinvoices[0]['Sales Mode'] == 'Remaining') {
                    $paymentNature = "New Sale";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Recurring') {
                    $paymentNature = "Recurring Payment";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Renewal') {
                    $paymentNature = "Renewal Payment";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Small Payment') {
                    $paymentNature = "Small Paymente";
                } elseif ($allinvoices[0]['Sales Mode'] == 'Up Sell') {
                    $paymentNature = "Upsell";
                } elseif ($allinvoices[0]['Sales Mode'] == 'WON') {
                    $paymentNature = "Dispute Won";
                }

                if ($matchclientmeta->isNotEmpty()) {
                    $findclient = Client::where('id', $matchclientmeta[0]->clientID)->get();
                    $project = Project::where('clientID', $findclient[0]->id)->get();
                    if (isset($project[0]->id)) {
                        $findproject = $project[0]->id;
                    } else {
                        $findproject = 0;
                    }
                    $count = count($findclient);
                    if ($count == 1) {

                        if ($allinvoices[0]['Balance Amount'] != "WON") {
                            if ($checktransactionIDget[0]->dispute == null) {
                                //simple refund
                                $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                    "BrandID" => (!isset($findbrand[0]->id) && $findbrand[0]->id == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                    "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                    "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                    "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                    "ChargingPlan" =>  '--',
                                    "ChargingMode" =>  '--',
                                    "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                    "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                    "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                    "bankWireUpload" =>  "--",
                                    "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Refund)",
                                    "paymentDate" => $s1ql_date_dispute, //to view this problem
                                    "SalesPerson" => $salesperson,
                                    "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                    "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                    "PaymentType" => "--",
                                    "numberOfSplits" => "--",
                                    "SplitProjectManager" => json_encode("--"),
                                    "ShareAmount" => json_encode("--"),
                                    "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus" => 'Refund',
                                    'refundID' =>  $findclient[0]->id,
                                    'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                    "remainingStatus" => $remainingStatus,
                                    "transactionType" => $paymentNature,
                                    "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                    "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                    "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                    "Sheetdata" => "Invoicing Data"
                                ]);

                                $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                                if ($refundamt == 0) {
                                    $refundtype = 'Refund';
                                } else {
                                    $refundtype = 'Partial Refund';
                                }

                                $refund = RefundPayments::create([
                                    "BrandID" => (!isset($findbrand[0]->id) && $findbrand[0]->id == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "PaymentID" => $createClientPaymentrefund,
                                    "basicAmount" => $allinvoices[0]['Total Amount'],
                                    "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "refundtype" => $refundtype,
                                    "refund_date" => $s1ql_date_dispute,
                                    "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                    "paymentType" => "Full payment",
                                    "splitmanagers" => json_encode("--"),
                                    "splitamounts" => json_encode("--"),
                                    "splitRefunds" => json_encode("--"),
                                    "transactionfee" => 0,
                                    "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                                ]);
                            } else {
                                //refund due to chargeback lost
                                $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                    "BrandID" => (!isset($findbrand[0]->id) && $findbrand[0]->id == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "paymentNature" => $paymentNature,
                                    "ChargingPlan" =>  '--',
                                    "ChargingMode" =>  '--',
                                    "Platform" => $allinvoices[0]['Platform'],
                                    "Card_Brand" => $allinvoices[0]['Card Brand'],
                                    "Payment_Gateway" => $allinvoices[0]['Payment Gateway'],
                                    "bankWireUpload" =>  "--",
                                    "TransactionID" => $allinvoices[0]['Transaction ID'] . "(Refund)",
                                    "paymentDate" => $s1ql_date_dispute, //to view this problem
                                    "SalesPerson" => $salesperson,
                                    "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                    "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                    "PaymentType" => "--",
                                    "numberOfSplits" => "--",
                                    "SplitProjectManager" => json_encode("--"),
                                    "ShareAmount" => json_encode("--"),
                                    "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus" => 'Refund',
                                    'refundID' =>  $findclient[0]->id,
                                    'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                    "remainingStatus" => $remainingStatus,
                                    "transactionType" => $paymentNature,
                                    "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                    "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                    "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                    "disputefee" =>  15,
                                    "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "Sheetdata" => "Invoicing Data"
                                ]);

                                $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                                if ($refundamt == 0) {
                                    $refundtype = 'Refund';
                                } else {
                                    $refundtype = 'Partial Refund';
                                }

                                $refund = RefundPayments::create([
                                    "BrandID" => (!isset($findbrand[0]->id) && $findbrand[0]->id == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "PaymentID" => $createClientPaymentrefund,
                                    "basicAmount" => $allinvoices[0]['Total Amount'],
                                    "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "refundtype" => $refundtype,
                                    "refund_date" => $s1ql_date_dispute,
                                    "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                    "paymentType" => "Full payment",
                                    "splitmanagers" => json_encode("--"),
                                    "splitamounts" => json_encode("--"),
                                    "splitRefunds" => json_encode("--"),
                                    "transactionfee" => 0,
                                    "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                                ]);

                                $lostdispute = Disputedpayments::create([
                                    "BrandID" => (!isset($findbrand[0]->id) && $findbrand[0]->id == null) ? 0 :  $findbrand[0]->id,
                                    "ClientID" => $findclient[0]->id,
                                    "ProjectID" => $findproject,
                                    "ProjectManager" => $projectmanager,
                                    "PaymentID" => $createClientPaymentrefund,
                                    "dispute_Date" => $s1ql_date_dispute,
                                    "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                    "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                    "disputeStatus" => "Lost",
                                    "disputefee"  => 15,
                                    "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],

                                ]);
                            }
                        } else {
                            //chargeback won

                            $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                "BrandID" => (!isset($findbrand[0]->id) && $findbrand[0]->id == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => ($findclient[0]->id == null) ? 0 :   $findclient[0]->id,
                                "ProjectID" => ($findproject == null) ? 0 :   $findproject,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" =>  '--',
                                "ChargingMode" =>  '--',
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Won)",
                                "paymentDate" => $s1ql_date_dispute, //to view this problem
                                "SalesPerson" => $salesperson,
                                "TotalAmount" => $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "--",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => json_encode("--"),
                                "ShareAmount" => json_encode("--"),
                                "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'On Going',
                                'refundID' =>  $findclient[0]->id,
                                'remainingID' => ($remamt == 0) ? null : $findclient[0]->id,
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "disputefee" =>  15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "Sheetdata" => "Invoicing Data"
                            ]);

                            $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                            if ($refundamt == 0) {
                                $refundtype = 'Refund';
                            } else {
                                $refundtype = 'Partial Refund';
                            }


                            $lostdispute = Disputedpayments::create([
                                "BrandID" => (!isset($findbrand[0]->id) && $findbrand[0]->id == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => $findclient[0]->id,
                                "ProjectID" => $findproject,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "dispute_Date" => $s1ql_date_dispute,
                                "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "disputeStatus" => "Won",
                                "disputefee"  => 15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount']

                            ]);
                        }
                    }
                } else {
                    if ($allinvoices[0]['Balance Amount'] != "WON") {
                        if ($checktransactionIDget[0]->dispute == null) {
                            //simple refund
                            $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                "BrandID" => (!isset($findbrand[0]->id) && $findbrand[0]->id == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                                "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                                "ChargingPlan" =>  '--',
                                "ChargingMode" =>  '--',
                                "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                                "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Refund)",
                                "paymentDate" => $s1ql_date_dispute, //to view this problem
                                "SalesPerson" => $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "--",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'Refund',
                                'refundID' =>   $allinvoices[0]['Transaction ID'],
                                'remainingID' => ($remamt == 0) ? null :  $allinvoices[0]['Transaction ID'],
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "Sheetdata" => "Invoicing Data",
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);

                            $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                            if ($refundamt == 0) {
                                $refundtype = 'Refund';
                            } else {
                                $refundtype = 'Partial Refund';
                            }

                            $refund = RefundPayments::create([
                                "BrandID" => (!isset($findbrand[0]->id) && $findbrand[0]->id == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "basicAmount" => $allinvoices[0]['Total Amount'],
                                "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "refundtype" => $refundtype,
                                "refund_date" => $s1ql_date_dispute,
                                "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                "paymentType" => "Full payment",
                                "splitmanagers" => json_encode("--"),
                                "splitamounts" => json_encode("--"),
                                "splitRefunds" => json_encode("--"),
                                "transactionfee" => 0,
                                "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                            ]);
                        } else {
                            //refund due to chargeback lost
                            $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                                "BrandID" => (!isset($findbrand[0]->id) && $findbrand[0]->id == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => $projectmanager,
                                "paymentNature" => $paymentNature,
                                "ChargingPlan" =>  '--',
                                "ChargingMode" =>  '--',
                                "Platform" => $allinvoices[0]['Platform'],
                                "Card_Brand" => $allinvoices[0]['Card Brand'],
                                "Payment_Gateway" => $allinvoices[0]['Payment Gateway'],
                                "bankWireUpload" =>  "--",
                                "TransactionID" => $allinvoices[0]['Transaction ID'] . "(Refund)",
                                "paymentDate" => $s1ql_date_dispute, //to view this problems
                                "SalesPerson" => $salesperson,
                                "TotalAmount" => ($allinvoices[0]['Total Amount'] == null) ? 0 :  $allinvoices[0]['Total Amount'],
                                "Paid" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                                "PaymentType" => "--",
                                "numberOfSplits" => "--",
                                "SplitProjectManager" => $a,
                                "ShareAmount" => $a,
                                "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                'created_at' => date('y-m-d H:m:s'),
                                'updated_at' => date('y-m-d H:m:s'),
                                "refundStatus" => 'Refund',
                                'refundID' =>   $allinvoices[0]['Transaction ID'],
                                'remainingID' => ($remamt == 0) ? null :  $allinvoices[0]['Transaction ID'],
                                "remainingStatus" => $remainingStatus,
                                "transactionType" => $paymentNature,
                                "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                                "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                                "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                                "disputefee" =>  15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "Sheetdata" => "Invoicing Data",
                                "notfoundemail" => $allinvoices[0]['Email'],
                            ]);

                            $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                            if ($refundamt == 0) {
                                $refundtype = 'Refund';
                            } else {
                                $refundtype = 'Partial Refund';
                            }

                            $refund = RefundPayments::create([
                                "BrandID" => (!isset($findbrand[0]->id) && $findbrand[0]->id == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "basicAmount" => $allinvoices[0]['Total Amount'],
                                "refundAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "refundtype" => $refundtype,
                                "refund_date" => $s1ql_date_dispute,
                                "refundReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "clientpaid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                                "paymentType" => "Full payment",
                                "splitmanagers" => json_encode("--"),
                                "splitamounts" => json_encode("--"),
                                "splitRefunds" => json_encode("--"),
                                "transactionfee" => 0,
                                "amt_after_transactionfee" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],

                            ]);

                            $lostdispute = Disputedpayments::create([
                                "BrandID" => (!isset($findbrand[0]->id) && $findbrand[0]->id == null) ? 0 :  $findbrand[0]->id,
                                "ClientID" => 0,
                                "ProjectID" => 0,
                                "ProjectManager" => $projectmanager,
                                "PaymentID" => $createClientPaymentrefund,
                                "dispute_Date" => $s1ql_date_dispute,
                                "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                                "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                                "disputeStatus" => "Lost",
                                "disputefee"  => 15,
                                "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],

                            ]);
                        }
                    } else {
                        //chargeback won

                        $createClientPaymentrefund = NewPaymentsClients::insertGetId([
                            "BrandID" => (!isset($findbrand[0]->id) && $findbrand[0]->id == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" => 0,
                            "ProjectID" => 0,
                            "ProjectManager" => ($projectmanager == null) ? 0 :  $projectmanager,
                            "paymentNature" => ($paymentNature == null) ? 0 :  $paymentNature,
                            "ChargingPlan" =>  '--',
                            "ChargingMode" =>  '--',
                            "Platform" => ($allinvoices[0]['Platform'] == null) ? 0 :  $allinvoices[0]['Platform'],
                            "Card_Brand" => ($allinvoices[0]['Card Brand'] == null) ? 0 :  $allinvoices[0]['Card Brand'],
                            "Payment_Gateway" => ($allinvoices[0]['Payment Gateway'] == null) ? 0 :  $allinvoices[0]['Payment Gateway'],
                            "bankWireUpload" =>  "--",
                            "TransactionID" => ($allinvoices[0]['Transaction ID'] == null) ? 0 :  $allinvoices[0]['Transaction ID'] . "(Won)",
                            "paymentDate" => $sql_date, //to view this problem
                            "SalesPerson" => $salesperson,
                            "TotalAmount" => $allinvoices[0]['Total Amount'],
                            "Paid" => ($allinvoices[0]['Paid'] == null) ? 0 :   $allinvoices[0]['Paid'],
                            "RemainingAmount" => $allinvoices[0]['Total Amount'] - $allinvoices[0]['Paid'],
                            "PaymentType" => "--",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => $a,
                            "ShareAmount" => $a,
                            "Description" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus" => 'On Going',
                            'refundID' =>  $allinvoices[0]['Transaction ID'],
                            'remainingID' => ($remamt == 0) ? null : $allinvoices[0]['Transaction ID'],
                            "remainingStatus" => $remainingStatus,
                            "transactionType" => $paymentNature,
                            "dispute" => ($allinvoices[0]['Balance Amount'] != "Chargeback") ? null : "dispute",
                            "transactionfee" => $allinvoices[0]['Paid'] * 0.03, //check
                            "amt_after_transactionfee" => $allinvoices[0]['Paid'] - ($allinvoices[0]['Paid'] * 0.03), //check
                            "disputefee" =>  15,
                            "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                            "Sheetdata" => "Invoicing Data",
                            "disputeattack"  => $s1ql_date_dispute, //date
                            "disputeattackamount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                            "notfoundemail" => $allinvoices[0]['Email'],
                        ]);

                        $refundamt = $allinvoices[0]['Total Amount'] - $allinvoices[0]['Refund/Dispute Amount'];
                        if ($refundamt == 0) {
                            $refundtype = 'Refund';
                        } else {
                            $refundtype = 'Partial Refund';
                        }

                        $lostdispute = Disputedpayments::create([
                            "BrandID" => (!isset($findbrand[0]->id) && $findbrand[0]->id == null) ? 0 :  $findbrand[0]->id,
                            "ClientID" => 0,
                            "ProjectID" => 0,
                            "ProjectManager" => $projectmanager,
                            "PaymentID" => $createClientPaymentrefund,
                            "dispute_Date" => $sql_date,
                            "disputedAmount" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount'],
                            "disputeReason" => ($allinvoices[0]['Refund/Dispute Reason'] == null) ? "0" :   $allinvoices[0]['Refund/Dispute Reason'],
                            "disputeStatus" => "Won",
                            "disputefee"  => 15,
                            "amt_after_disputefee" => ($allinvoices[0]['Refund/Dispute Amount'] == null) ? 0 :  $allinvoices[0]['Refund/Dispute Amount']

                        ]);
                    }
                }
            }
        }

        return redirect('/client/project/payment/all');
    }


    function notfoundclient(Request $request)
    {

        $loginUser = $this->roleExits($request);
        $notfoundclients = Payments::get();
        return view('sheetsNotfoundClient', [
            'notfoundclients' => $notfoundclients,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function createteam(Request $request)
    {

        $loginUser = $this->roleExits($request);
        $employees = Employee::get();
        $brand = Brand::get();
        return view('createTeam', [
            'employees' => $employees,
            'brands' => $brand,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    public function ajax_sales(Request $request)
    {
        $data['projectdata'] = Employee::where("id", $request->state_id)->get();
        $projectmanagername = $data['projectdata'][0]->name;

        $return_array = [
            "pmname" => $projectmanagername,
        ];

        return response()->json($return_array);
    }

    function createteam_process(Request $request)
    {
        $results  = explode(",", $request->input('Employeesdd'));

        $department = Salesteam::insertGetId([
            "teamLead" => $request->input('teamlead'),
            "members" => json_encode($results),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s'),
        ]);
        return redirect()->back()->with("Success", "Team Created !");
    }

    function salesteam_view(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $salesteam = Salesteam::get();

        return view('allSalesTeam', [
            "salesteams" => $salesteam,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function editsalesteam(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $companydata = db::table("salesteam")
            ->where('id', $id)
            ->get();
        $employees = Employee::get();
        $brand = Brand::get();
        return view('editsalesteam', [
            "companydata" => $companydata,
            'employees' => $employees,
            'brands' => $brand,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function editsalesteamprocess(Request $request, $id)
    {
        $results  = $request->input('users');

        $department = Salesteam::where('id', $id)->Update([
            "teamLead" => $request->input('teamlead'),
            "members" => json_encode($results),
            'updated_at' => date('y-m-d H:m:s'),
        ]);
        return redirect('/sales/teams');
    }

    function deleteSalesteam(Request $request, $id)
    {

        $companydeleted = DB::table('salesteam')->where('id', $id)->delete();

        return redirect('/sales/teams');
    }


    function unmatchedPayments(Request $request)
    {
        $getUnmatched = UnmatchedPayments::get();
        foreach ($getUnmatched as $getUnmatcheds) {
            $matchclientmeta = Clientmeta::wherejsoncontains('otheremail', ($getUnmatcheds->Clientemail))->get();
            $count = count($matchclientmeta);
            if ($count > 0) {
                $matchclient = Client::where('id', ($matchclientmeta[0]->clientID))->get();
                if ($getUnmatcheds->stripePaymentstatus == "Refunded") {
                    $createClientPayment = NewPaymentsClients::create([
                        "BrandID" => $matchclient[0]->brand,
                        "ClientID" => $matchclient[0]->id,
                        "ProjectID" => 0,
                        "ProjectManager" => 0,
                        "paymentNature" => "--",
                        "ChargingPlan" => "--",
                        "ChargingMode" => "--",
                        "Platform" => "--",
                        "Card_Brand" => $getUnmatcheds->cardBrand,
                        "Payment_Gateway" => "Stripe",
                        "bankWireUpload" =>  "--",
                        "TransactionID" => $getUnmatcheds->TransactionID,
                        "paymentDate" => $getUnmatcheds->paymentDate,
                        "SalesPerson" => 0,
                        "TotalAmount" => 0,
                        "Paid" => $getUnmatcheds->Paid,
                        "RemainingAmount" => 0,
                        "PaymentType" => "--",
                        "numberOfSplits" => "--",
                        "SplitProjectManager" => json_encode("--"),
                        "ShareAmount" => json_encode("--"),
                        "Description" => $getUnmatcheds->Description,
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus" => 'Refunded',
                        "remainingStatus" => "Unlinked Payments",
                        "transactionType" => "--",
                        "notfoundemail" =>  $getUnmatcheds->Clientemail,

                    ]);
                } else {

                    $createClientPayment = NewPaymentsClients::create([
                        "BrandID" => $matchclient[0]->brand,
                        "ClientID" => $matchclient[0]->id,
                        "ProjectID" => 0,
                        "ProjectManager" => 0,
                        "paymentNature" => "--",
                        "ChargingPlan" => "--",
                        "ChargingMode" => "--",
                        "Platform" => "--",
                        "Card_Brand" => $getUnmatcheds->cardBrand,
                        "Payment_Gateway" => "Stripe",
                        "bankWireUpload" =>  "--",
                        "TransactionID" => $getUnmatcheds->TransactionID,
                        "paymentDate" => $getUnmatcheds->paymentDate,
                        "SalesPerson" => 0,
                        "TotalAmount" => 0,
                        "Paid" => $getUnmatcheds->Paid,
                        "RemainingAmount" => 0,
                        "PaymentType" => "--",
                        "numberOfSplits" => "--",
                        "SplitProjectManager" => json_encode("--"),
                        "ShareAmount" => json_encode("--"),
                        "Description" => $getUnmatcheds->Description,
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus" => 'On Going',
                        "remainingStatus" => "Unlinked Payments",
                        "transactionType" => "--",
                        "notfoundemail" =>  $getUnmatcheds->Clientemail,

                    ]);
                }

                $deleteUnmatched = UnmatchedPayments::where('Clientemail', $getUnmatcheds->Clientemail)->delete();
            } else {
                continue;
            }
        }


        $loginUser = $this->roleExits($request);
        $newgetUnmatched = UnmatchedPayments::get();
        return view('clientUnmatchedPayments', [
            'getUnmatched' => $newgetUnmatched,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function unmatchedPaymentsSheet(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $client_payment = NewPaymentsClients::where('refundStatus', '!=', 'Pending Payment')
            ->where('ClientID', 0)
            ->where('refundStatus', '!=', 'Refund')
            ->get();

        return view('unmatchedpaymentsheet', [
            'clientPayments' => $client_payment,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function NewEmailLinkCLient(Request $request, $id)
    {
        $clients = Client::get();
        $loginUser = $this->roleExits($request);

        return view('clientlinkNewEmail', [
            'newemail' => $id,
            'clients' => $clients,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function NewEmailLinkCLientprocess(Request $request)
    {
        $clientID = $request->input('client');
        $client = Client::where('id', $clientID)->get();
        $clientmetas = Clientmeta::where('clientID', $clientID)->get();
        $email = $request->input('email');
        if ($clientmetas[0]->otheremail == null) {
            $toArray = [$client[0]->email, $email];
            $addnewemailInClient = ClientMeta::where('clientID', $clientID)->update([
                'otheremail' => json_encode($toArray)
            ]);
        } else {
            $otheremails = json_decode($clientmetas[0]->otheremail);
            array_push($otheremails, $email);
            $addnewemailInClient = ClientMeta::where('clientID', $clientID)->update([
                'otheremail' => json_encode($otheremails)
            ]);
        }
        // print_r($otheremails);

        // die();
        // return redirect('/payments/unmatched');
        return redirect('/client/project/payment/all');
    }

    // function NewEmail_unlinkededit(Request $request, $id)
    // {
    //     $loginUser = $this->roleExits($request);
    //     $editPayment = NewPaymentsClients::where('id', $id)->get();
    //     $findclient = Client::get();
    //     $findemployee = Employee::get();
    //     $brand = Brand::get();
    //     $allPayments = NewPaymentsClients::where('ClientID', $editPayment[0]->ClientID)
    //             ->where('refundStatus', '!=', 'Pending Payment')
    //             ->where('remainingStatus', '!=', 'Unlinked Payments')
    //             ->get();

    //         return view('edit_payment_unlikedsheet', [
    //             'allPayments' => $allPayments,
    //             'editPayments' => $editPayment,
    //             'clients' => $findclient,
    //             'employee' => $findemployee,
    //             'pmemployee' => $findemployee,
    //             'saleemployee' => $findemployee,
    //             'brand' => $brand,
    //             'LoginUser' => $loginUser[1],
    //             'departmentAccess' => $loginUser[0],
    //             'superUser' => $loginUser[2]
    //         ]);
    // }


    function pushEmailtometa(Request $request)
    {
        ini_set('max_execution_time', 300);

        $allclients = Client::get();
        foreach ($allclients as $allclient) {
            $clientmeta = ClientMeta::where('clientID', $allclient->id)->get();

            if (isset($clientmeta[0]->otheremail) && $clientmeta[0]->otheremail != null) {
                continue;
            } else {
                $toArray = [$allclient->email];
                $addnewemailInClient = ClientMeta::where('clientID', $allclient->id)->update([
                    'otheremail' => json_encode($toArray)
                ]);
            }
        }


        $getUnmatched = NewPaymentsClients::where('ClientID', 0)->get();

        foreach ($getUnmatched as $unmatched) {

            $matchclientmetas = Clientmeta::whereJsonContains('otheremail', $unmatched->notfoundemail)->count();
            $matchclientmeta = Clientmeta::whereJsonContains('otheremail', $unmatched->notfoundemail)->get();
            if ($matchclientmetas > 0) {
                $findprojects = Project::where('clientID', $matchclientmeta[0]->clientID)->count();
                if ($findprojects > 0) {
                    $findproject = Project::where('clientID', $matchclientmeta[0]->clientID)->get();
                    $projectmanager = $findproject[0]->projectManager;
                    $projectid = $findproject[0]->id;
                } else {
                    $projectid = 0;
                    $projectmanager = 0;
                }
                NewPaymentsClients::where('id', $unmatched->id)->update([
                    'ClientID' => $matchclientmeta[0]->clientID,
                    'ProjectID' => $projectid,
                    'ProjectManager' => $projectmanager
                ]);
            } else {
                continue;
            }
        }



        $getUnmatched1 = NewPaymentsClients::where('ClientID', '!=', 0)->where('ProjectID', 0)->get();

        foreach ($getUnmatched1 as $unmatched1) {

            $matchclientmetas1 = Project::where('clientID', $unmatched1->ClientID)->count();
            $matchclientmeta1 = Project::where('clientID', $unmatched1->ClientID)->get();
            if ($matchclientmetas1 > 0) {
                $projectid1 = $matchclientmeta1[0]->id;
                $projectmanager1 = $matchclientmeta1[0]->projectManager;
            } else {
                $projectid1 = 0;
                $projectmanager1 = 0;
            }
            NewPaymentsClients::where('id', $unmatched1->id)->update([
                'ProjectID' => $projectid1,
                'ProjectManager' => $projectmanager1
            ]);
        }

        $agentrole = AgentTarget::where('salesrole', '!=', null)->get();
        foreach ($agentrole as $agentroles) {
            $agentroleupdate = AgentTarget::where('AgentID', $agentroles->AgentID)->Update([
                'salesrole' => $agentroles->salesrole,
            ]);
        }

        return redirect('/client/project/payment/all');
    }

    function csv_ppc(Request $request)
    {
        $loginUser = $this->roleExits($request);
        return view('ppc_upload', [
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function csv_ppc_process(Request $request)
    {
        $data = Excel::toArray([], $request->file('ppcpayments'));
        foreach ($data as $extractData) {
            $headings = $extractData[2];
            $keycount = count($headings);
            $maincount = count($extractData);

            for ($j = 3; $j < $maincount; $j++) {
                $newarray = [];
                for ($i = 0; $i < $keycount; $i++) {
                    $newarray[$headings[$i]] = $extractData[$j][$i];
                }

                if ($newarray["Campaign"] != null) {
                    $createClientPayment = PPC::create([
                        "Campaign_status" => $newarray["Campaign status"],
                        "Campaign" => $newarray["Campaign"],
                        "Budget" => (int)$newarray["Budget"],
                        "Budget_type" => $newarray["Budget type"],
                        "Optimization_score" => $newarray["Optimization score"],
                        "Account" => $newarray["Account"],
                        "Campaign_type" => $newarray["Campaign type"],
                        "Interactions" => $newarray["Interactions"],
                        "Cost" => (int)$newarray["Cost"],
                        "Impr" => (int)$newarray["Impr."],
                        "Bid_strategy_type" => $newarray["Bid strategy type"],
                        "CampaignID" => $newarray["Campaign ID"],
                        "Clicks" => (int)$newarray["Clicks"]
                    ]);
                } else {
                    continue;
                }
            }


            // die();
        }

        echo ("done");
    }

    function csv_leads(Request $request)
    {
        $loginUser = $this->roleExits($request);
        return view('leads_upload', [
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function csv_leads_process(Request $request)
    {
        $data = Excel::toArray([], $request->file('leadspayments'));
        foreach ($data as $extractData) {
            $headings = $extractData[0];
            $keycount = count($headings);
            $maincount = count($extractData);

            for ($j = 3; $j < $maincount; $j++) {
                $newarray = [];
                for ($i = 0; $i < $keycount; $i++) {
                    $newarray[$headings[$i]] = $extractData[$j][$i];
                }

                $sql_date = date("Y-m-d", strtotime($newarray['Date']));


                $createClientPayment = Leads::create([
                    "Brand" => $newarray["Brand"],
                    "Date" =>  $sql_date,
                    "LeadSource" => $newarray["Lead Source"],
                    "LeadType" => $newarray["Lead Type"],
                    "ClientName" => $newarray["Name of client"],
                    "phone" => $newarray["Contact Number"],
                    "Email" => $newarray["Email Address"],
                    "Service" => $newarray["Service"],
                    "Attempt_1_agent" => $newarray["Attempt 1 Agent"],
                    "Attempt_2_agent" => $newarray["Attempt 2 Agent"],
                    "comments" => $newarray["Comments"],
                    "Amount" =>  (int)$newarray["Amount"],
                    "keywords" => $newarray["Keyword"],
                    "status" => $newarray["Status"],
                    "GCLID" => $newarray["GCLID"],
                    "Locations" => $newarray["Location"],
                    "MonthofConversion" => $newarray["Month of Conversion"]
                ]);
            }
        }

        return redirect('/viewleads');
    }

    function viewleads(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $allleads = Leads::get();
        return view('allleads', [
            'allleads' => $allleads,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function originalroles(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brands = Brand::get();
        $employees = Employee::get();
        return view('originalRoles', [
            'brand' => $brands,
            'employees' => $employees,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function originalrolesProcess(Request $request)
    {
        $name = $request->input('name');
        $brand = $request->input('brand');
        $front = $request->input('front');
        $Support = $request->input('Support');

        $addbrandtarget = BrandSalesRole::create([
            "Name" => $request->input('name'),
            "Brand" => $request->input('brand'),
            "Front" => json_encode($front),
            "Support" => json_encode($Support),
            "created_at" => date('y-m-d H:m:s'),
            "updated_at" => date('y-m-d H:m:s')
        ]);

        return redirect('/sales/originalroles/view');
    }

    function originalrolesedit(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $brands = Brand::get();
        $employees = Employee::get();
        $allleads = BrandSalesRole::where('id', $id)->get();
        return view('originalRolesEdit', [
            'brand' => $brands,
            'employees' => $employees,
            'allleads' => $allleads,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function originalrolesProcessedit(Request $request, $id)
    {
        $name = $request->input('name');
        $brand = $request->input('brand');
        $front = $request->input('front');
        $Support = $request->input('Support');

        $addbrandtarget = BrandSalesRole::where('id', $id)->Update([
            "Name" => $request->input('name'),
            "Brand" => $request->input('brand'),
            "Front" => json_encode($front),
            "Support" => json_encode($Support),
            "updated_at" => date('y-m-d H:m:s')
        ]);

        return redirect('/sales/originalroles/view');
    }

    function originalrolesProcess_View(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $allleads = BrandSalesRole::get();
        return view('BrandSalesRole', [
            'allleads' => $allleads,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function originalrolesdelete(Request $request, $id)
    {
        $companydeleted = DB::table('brand_sales_roles')->where('id', $id)->delete();

        return redirect('/sales/originalroles/view');
    }
}
