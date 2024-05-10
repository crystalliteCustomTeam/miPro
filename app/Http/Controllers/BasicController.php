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
            'otheremail'=> json_encode($firstemail),
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
            'otheremail'=> json_encode($firstemail),
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
        if($depart > 0){
            $loginUser = $this->roleExits($request);
            if ($loginUser[2] == 0) {
                $brand = Brand::get();
                $eachbranddata = [];
                foreach($brand as $brands){
                    $brandName = Brand::where("id", $brands->id)->get();
                    $brandclient = Client::where('brand',$brands->id)->count();
                    $brandrefund_Month = QAFORM::where('brandID',$brands->id)->whereMonth('created_at', now())->where('status', 'Refund')->Distinct('projectID')->latest('created_at')->count();
                    $branddispute_Month = QAFORM::where('brandID',$brands->id)->whereMonth('created_at', now())->where('status', 'Dispute')->Distinct('projectID')->latest('created_at')->count();
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
                $status_OnGoing = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status','On Going')->count();
                $status_Dispute = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status','Dispute')->count();
                $status_Refund = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status','Refund')->count();
                $status_NotStartedYet = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status','Not Started Yet')->count();
                $remark_ExtremelySatisfied = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('client_satisfaction','Extremely Satisfied')->count();
                $remark_SomewhatSatisfied = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('client_satisfaction','Somewhat Satisfied')->count();
                $remark_NeitherSatisfiednorDissatisfied = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('client_satisfaction','Neither Satisfied nor Dissatisfied')->count();
                $remark_SomewhatDissatisfied = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('client_satisfaction','Somewhat Dissatisfied')->count();
                $remark_ExtremelyDissatisfied = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('client_satisfaction','Extremely Dissatisfied')->count();
                $ExpectedRefundDispute_GoingGood = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status_of_refund','Going Good')->count();
                $ExpectedRefundDispute_Low = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status_of_refund','Low')->count();
                $ExpectedRefundDispute_Moderate = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status_of_refund','Moderate')->count();
                $ExpectedRefundDispute_High = QAFORM::whereMonth('created_at', now())->latest('qaform.created_at')->distinct('projectID')->where('status_of_refund','High')->count();
                //renewal,recurring,dispute,refund
                $Renewal_Month = NewPaymentsClients::whereYear('futureDate', now())
                                ->whereMonth('futureDate', now())
                                ->where('paymentNature', 'Renewal Payment')
                                ->where('refundStatus','Pending Payment')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->get();
                $Renewal_Month_count = NewPaymentsClients::whereYear('futureDate', now())
                                ->whereMonth('futureDate', now())
                                ->where('paymentNature', 'Renewal Payment')
                                ->where('refundStatus','Pending Payment')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->distinct('ClientID')->count();
                $Renewal_Month_sum = NewPaymentsClients::whereYear('futureDate', now())
                                ->whereMonth('futureDate', now())
                                ->where('paymentNature', 'Renewal Payment')
                                ->where('refundStatus','Pending Payment')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->SUM('TotalAmount');

                $Recurring_Month = NewPaymentsClients::whereYear('futureDate', now())
                                ->whereMonth('futureDate', now())
                                ->where('paymentNature', 'Recurring Payment')
                                ->where('refundStatus','Pending Payment')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->get();
                $Recurring_Month_count = NewPaymentsClients::whereYear('futureDate', now())
                                ->whereMonth('futureDate', now())
                                ->where('paymentNature', 'Recurring Payment')
                                ->where('refundStatus','Pending Payment')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->distinct('ClientID')
                                ->count();
                $Recurring_Month_sum = NewPaymentsClients::whereYear('futureDate', now())
                                ->whereMonth('futureDate', now())
                                ->where('paymentNature', 'Recurring Payment')
                                ->where('refundStatus','Pending Payment')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->SUM('TotalAmount');

                $Refund_Month = NewPaymentsClients::whereYear('paymentDate', now())
                                ->whereMonth('paymentDate', now())
                                ->where('refundStatus', 'Refund')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->get();
                $Refund_count = NewPaymentsClients::whereYear('paymentDate', now())
                                ->whereMonth('paymentDate', now())
                                ->where('refundStatus', 'Refund')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->distinct('ClientID')
                                ->count();
                $Refund_sum = NewPaymentsClients::whereYear('paymentDate', now())
                                ->whereMonth('paymentDate', now())
                                ->where('refundStatus', 'Refund')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->SUM('TotalAmount');
                $Dispute_Month = NewPaymentsClients::whereYear('paymentDate', now())
                                ->whereMonth('paymentDate', now())
                                ->where('dispute', 'Dispute')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->get();
                $Dispute_count = NewPaymentsClients::whereYear('paymentDate', now())
                                ->whereMonth('paymentDate', now())
                                ->where('dispute', 'Dispute')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->distinct('ClientID')
                                ->count();
                $Dispute_sum = NewPaymentsClients::whereYear('paymentDate', now())
                                ->whereMonth('paymentDate', now())
                                ->where('dispute', 'Dispute')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->SUM('TotalAmount');

                $eachbrand_RevenueStatus = [];
                foreach($brand as $brands){
                        $brandName = Brand::where("id", $brands->id)->get();
                        $brand_renewal = NewPaymentsClients::where('BrandID',$brands->id)->whereYear('futureDate', now())->whereMonth('futureDate', now())
                                ->where('paymentNature', 'Renewal Payment')
                                ->where('refundStatus','Pending Payment')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->SUM('TotalAmount');
                        $brandrefund_recurring = NewPaymentsClients::where('BrandID',$brands->id)->whereYear('futureDate', now())->whereMonth('futureDate', now())
                                ->where('paymentNature', 'Recurring Payment')
                                ->where('refundStatus','Pending Payment')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->SUM('TotalAmount');
                        $branddispute_refund = NewPaymentsClients::where('BrandID',$brands->id)->whereMonth('created_at', now())->whereYear('futureDate', now())->whereMonth('futureDate', now())
                                ->where('refundStatus', 'Refund')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->SUM('TotalAmount');
                        $branddispute_dispute = NewPaymentsClients::where('BrandID',$brands->id)->whereMonth('created_at', now())->whereYear('futureDate', now())->whereMonth('futureDate', now())
                                ->where('dispute', 'Dispute')
                                ->where('remainingStatus','!=','Unlinked Payments')
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
                    'status_OnGoing' =>$status_OnGoing,
                    'status_Dispute' =>$status_Dispute,
                    'status_Refund' =>$status_Refund,
                    'status_NotStartedYet' =>$status_NotStartedYet,
                    'remark_ExtremelySatisfied' =>$remark_ExtremelySatisfied,
                    'remark_SomewhatSatisfied' =>$remark_SomewhatSatisfied,
                    'remark_NeitherSatisfiednorDissatisfied' =>$remark_NeitherSatisfiednorDissatisfied,
                    'remark_SomewhatDissatisfied' =>$remark_SomewhatDissatisfied,
                    'remark_ExtremelyDissatisfied' =>$remark_ExtremelyDissatisfied,
                    'ExpectedRefundDispute_GoingGood' =>$ExpectedRefundDispute_GoingGood,
                    'ExpectedRefundDispute_Low' =>$ExpectedRefundDispute_Low,
                    'ExpectedRefundDispute_Moderate' =>$ExpectedRefundDispute_Moderate,
                    'ExpectedRefundDispute_High' =>$ExpectedRefundDispute_High,
                    //renewal,recurring,upsell
                    'Renewal_Months' =>$Renewal_Month,
                    'Renewal_Month_counts' =>$Renewal_Month_count,
                    'Renewal_Month_sums' =>$Renewal_Month_sum,
                    'Recurring_Months' =>$Recurring_Month,
                    'Recurring_Month_counts' =>$Recurring_Month_count,
                    'Recurring_Month_sums' =>$Recurring_Month_sum,
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
                $last5qaform = QAFORM::where('qaPerson', $loginUser[1][0]->id)->where(function($query)
                {
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

        }else{
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
        return view('setupcompany', ['LoginUser' => $loginUser[1], 'departmentAccess' => $loginUser[0], 'superUser' => $loginUser[2]]);
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

        return view("editcompany", ["companydata" => $companydata, 'LoginUser' => $loginUser[1], 'departmentAccess' => $loginUser[0], 'superUser' => $loginUser[2]]);
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
            'superUser' => $loginUser[2]]);
    }

    function brandlist(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brands = Brand::with('brandOwnerName')->get();
        return View('brandlist', [
            "companies" => $brands,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]]);
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
            'superUser' => $loginUser[2]]);
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
            'superUser' => $loginUser[2]]);
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
            'superUser' => $loginUser[2]]);
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
            'superUser' => $loginUser[2]]);
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

    function selectdepartusers(Request $request , $id){
        $loginUser = $this->roleExits($request);
        $employees = Employee::whereNotIn('position', ['Owner', 'Admin', 'VP', 'Brand Owner', ''])->get();
        $department = Department::where('id', $id)->get();
        return view('departmentUsers', [
            'employees' => $employees,
            'department' => $department,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]]);

    }

    function addusersIndepart(Request $request , $id){

        $results  = explode(",", $request->input('Employeesdd'));

        $department = Department::where('id',$id)->update([
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
              'superUser' => $loginUser[2]]);
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
            'superUser' => $loginUser[2]]);
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
            'superUser' => $loginUser[2]]);
    }

    function createuser(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $brands  = Brand::all();

        return view('users', ["Brands" => $brands, 'LoginUser' => $loginUser[1], 'departmentAccess' => $loginUser[0], 'superUser' => $loginUser[2]]);
    }

    function edituser(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $employee = Employee::where('id', $id)->get();

        return view("edituser", ["employee" => $employee, 'LoginUser' => $loginUser[1], 'departmentAccess' => $loginUser[0], 'superUser' => $loginUser[2]]);
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
                'otheremail'=> json_encode($firstemail),
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
                'otheremail'=> json_encode($firstemail),
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
                'otheremail'=> json_encode($firstemail),
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
                'otheremail'=> json_encode($firstemail),
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

                array_unshift($clientMeta[$LOOPCOUNTONE],$insertclient);

                array_push($clientMeta[$LOOPCOUNTONE],json_encode($clientMetaTiresWithArray[$LOOPCOUNTONE]));
                array_push($clientMeta[$LOOPCOUNTONE],"200");

                $LOOPCOUNTONE++;
            }
        }
        foreach ($clientMeta as $clientMetas) {

            if(array_key_exists(8,$clientMetas)){

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


            }else{
                continue;
            }
        }

        //return redirect('all/clients');
        $loginUser = $this->roleExits($request);

        if( $loginUser[2] == 0 ){
            return redirect('all/clients');
        }else{
            return redirect('/assigned/clients');
        }
    }

    function csv_project(Request $request){
        $loginUser = $this->roleExits($request);
        return view('projectUpload',[
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
           if(isset($getclientEmail_pushID)){
               foreach($getclientEmail_pushID as $value){
                     $productionID =  substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz-:,"),0,6);
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
           }
           else{
               echo $projects[0]."</br>";
           }



                //  echo $LOOPCOUNTONE."<br>";

                array_unshift($production[$LOOPCOUNTONE],$insertproject);

                $LOOPCOUNTONE++;
        }




        foreach ($production as $productions) {
            $project = Project::where('id',$productions[0])->get();


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

        if( $loginUser[2] == 0 ){
            return redirect('all/clients');
        }else{
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
                'otheremail'=> json_encode($firstemail),
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
                'otheremail'=> json_encode($firstemail),
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
                'otheremail'=> json_encode($firstemail),
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
                'otheremail'=> json_encode($firstemail),
                'updated_at' => date('y-m-d H:m:s')
            ]);
        }

        $loginUser = $this->roleExits($request);

        if( $loginUser[2] == 0 ){
            return redirect('all/clients');
        }else{
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

        $domain =$request->input('domain');

        return redirect('/clientmetaupdate/'. $id .'/'. $domain);

    }

    function editClientmeta(Request $request, $id, $domain)
    {
        $loginUser = $this->roleExits($request);
        $clientid = $id;
        $domains = $domain;
        $productionservice = ProductionServices::get();
        return view('client_meta_editcreation',[
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
                'updated_at' => date('y-m-d H:m:s')
            ]);
        }

        $loginUser = $this->roleExits($request);

        if( $loginUser[2] == 0){
            return redirect('all/clients');
        }else{
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
            'superUser' => $loginUser[2]]);
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
        return view('project', ['user_id' => $user_id, 'clients' => $findclient, 'employee' => $employee, 'LoginUser' => $loginUser[1], 'departmentAccess' => $loginUser[0], 'superUser' => $loginUser[2]]);
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
            'superUser' => $loginUser[2]]);
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
            'superUser' => $loginUser[2]]);
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
        'superUser' => $loginUser[2]]);
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

        return view('projectproductionUsers', ['projects' => $project, 'productions' => $projectProduction, 'prjectid' => $id, 'LoginUser' => $loginUser[1], 'departmentAccess' => $loginUser[0], 'superUser' => $loginUser[2]]);
    }

    function editproject(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $findproject = Project::Where('id', $id)->get();
        $findclient = Client::get();
        $employee = Employee::get();
        return view('editproject', ['clients' => $findclient, 'employee' => $employee, 'projects' => $findproject, 'LoginUser' => $loginUser[1], 'departmentAccess' => $loginUser[0], 'superUser' => $loginUser[2]]);
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

    function deleteproject(Request $request, $id){
        $project = Project::where('id',$id)->get();
        $projectProduction = ProjectProduction::where('projectID',$project[0]->productionID)->get();

        $deleteproduction = DB::table('project_productions')->where('projectID',$project[0]->productionID)->delete();
        $deleteProject = DB::table('projects')->where('id',$id)->delete();


        return redirect('/client/details/' . $project[0]->clientID);
    }

    function Edit_Project_production(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $projectProduction = ProjectProduction::where('id', $id)->get();
        $department = Department::get();
        $employee = Employee::get();
        $productionservices = ProductionServices::get();

        return view('edit_project_production', ['projectProductions' => $projectProduction, 'departments' => $department, 'employees' => $employee, 'productionservices' => $productionservices, 'LoginUser' => $loginUser[1], 'departmentAccess' => $loginUser[0], 'superUser' => $loginUser[2]]);
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
        $clientPayments = NewPaymentsClients::where('ClientID',$clientID)
                            ->where('refundStatus','!=','Pending Payment')
                            ->where('remainingStatus','!=','Unlinked Payments')
                            ->get();

        $qaAssignee = QaPersonClientAssign::where('client',$clientID)->get();
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
                ->where('remainingStatus','!=','Unlinked Payments')
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
                                ->where('refundStatus','!=' ,'Pending Payment')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->get();

        foreach($checkingpayments as $checkingpayment){

            $RefundPayments = RefundPayments::where('PaymentID',$checkingpayment->id)->get();
            $checkingpayment->refund_with_payments = $RefundPayments ;

        }

        $clienttotal = NewPaymentsClients::where('ClientID', $clientID)
                                ->where('refundStatus','!=','Pending Payment')
                                ->where('paymentNature','!=','Remaining')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->where('dispute',null)
                                ->SUM('TotalAmount');
        $clientrefundcount = NewPaymentsClients::where('ClientID', $clientID)
                                ->where('refundStatus','!=','On Going')
                                ->where('refundStatus','!=','Pending Payment')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->where('dispute',null)
                                ->count();
        $clientPaid = NewPaymentsClients::where('ClientID', $clientID)
                                ->where('refundStatus','On Going')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->where('dispute',null)
                                ->SUM('Paid');
        $clienttotalwithoutRefund = NewPaymentsClients::where('ClientID', $clientID)
                                ->where('refundStatus','On Going')
                                ->where('paymentNature','!=','Remaining')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->where('dispute',null)
                                ->SUM('TotalAmount');
        $clientpaidwithoutRefund = NewPaymentsClients::where('ClientID', $clientID)
                                ->where('refundStatus','On Going')
                                ->where('remainingStatus','!=','Unlinked Payments')
                                ->where('dispute',null)
                                ->SUM('Paid');
        $clientRemaining = $clienttotalwithoutRefund - $clientpaidwithoutRefund ;
        $unlinkedpayment = NewPaymentsClients::where('ClientID', $clientID)
                                ->where('remainingStatus','Unlinked Payments')
                                ->where('dispute',null)
                                ->count();

        $disputepayment = Disputedpayments::where('ClientID', $clientID)
                                ->get();

        return view('clientDetail', [
            'client' => $findclient,
            'qaAssignee' => $qaAssignee,
            'recentClients' => $recentClients,
            'clientPayments' => $clientPayments,
            'uniquepaymentarray' => $uniquepaymentarray,
            'cashflows' => $checkingpayments,
            'projects' => $allprojects,
            'findProject_Manager' => $findProject_Manager,
            'clienttotal' => $clienttotal,
            'clientPaid' => $clientPaid,
            'clientRemaining' => $clientRemaining,
            'clienttotalwithoutRefund' => $clienttotalwithoutRefund,
            'clientrefundcount' => $clientrefundcount,
            'disputepayment' => $disputepayment,
            'unlinkedpayment' => $unlinkedpayment,
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
    function addPaymentProcess(Request $request){
        $loginUser = $this->roleExits($request);
        $paymenttype = $request->input('payment_type');
        if($paymenttype == 0){
            return redirect('/forms/payment/' . $request->input('projectname'));
        }else{
            return redirect('/client/project/payment/Refund/' . $request->input('projectname'));
        }
    }



    function payment(Request $request, $id)
    {
        // $interval = "3 Months";
        // $today = date('Y-m-d');

        // for ($i = 0; $i <= 10; $i++) {
        //     if ($interval == "One Time Payment") {
        //         $datefinal = null;
        //     } elseif ($interval == "Monthly") {
        //         $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) . ' month', strtotime($today)));
        //     } elseif ($interval == "2 Months") {
        //         $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' month', strtotime($today)));
        //     } elseif ($interval == "3 Months") {
        //         $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' month', strtotime($today)));
        //     }
        //     echo $datefinal . "<br>";
        // }

        // echo("<pre>");
        // print_r($a[0]);
        // echo(gettype($a[0]));
        //  die();
        $loginUser = $this->roleExits($request);

        $findproject = Project::where('id', $id)->get();
        $findclientofproject = Client::where('id', $findproject[0]->clientID)->get();
        $findclient = Client::get();
        $pmdepartment = Department::where('brand',$findclientofproject[0]->brand)->where(function($query)
                {
                    $query->where('name', 'LIKE', '%Project manager')
                    ->orWhere('name', 'LIKE', 'Project manager%')
                    ->orWhere('name', 'LIKE', '%Project manager%');
                })->get();
        $pmemployee = Employee::whereIn('id',json_decode($pmdepartment[0]->users))->get();
        $saledepartment = Department::where('brand',$findclientofproject[0]->brand)->where(function($query)
                {
                    $query->where('name', 'LIKE', '%sale')
                    ->orWhere('name', 'LIKE', 'sale%')
                    ->orWhere('name', 'LIKE', '%sale%');
                })->get();
        $saleemployee = Employee::whereIn('id',json_decode($saledepartment[0]->users))->get();
        $findemployee = Employee::get();
        $get_projectCount = Project::where('clientID', $findproject[0]->ClientName->id)->count();
        $allPayments = NewPaymentsClients::where('ClientID', $findproject[0]->ClientName->id)
                            ->where('refundStatus','!=','Pending Payment')
                            ->where('remainingStatus','!=','Unlinked Payments')
                            ->get();
        $remainingpayments = NewPaymentsClients::where('ClientID', $findproject[0]->ClientName->id)
                            ->where('ProjectID',$id)
                            ->where('refundStatus','!=','Pending Payment')
                            ->where('remainingStatus','Remaining')
                            ->get();
        $remainingpaymentcount = count($remainingpayments);
        return view('payment', [
            'allPayments' => $allPayments,
            'id' => $id,
            'projectmanager' => $findproject,
            'findclientofproject' => $findclientofproject,
            'clients' => $findclient,
            'employee' => $findemployee,
            'pmemployee' => $pmemployee,
            'saleemployee' => $saleemployee,
            'remainingpayments' => $remainingpayments,
            'remainingpaymentcount' => $remainingpaymentcount,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]]);
    }
    function clientPayment(Request $request)
    {
        // $SecondProjectManager = $request->input('shareProjectManager');
        // echo("<pre>");
        // print_r($SecondProjectManager);
        // die();

        $paymentType = $request->input('paymentType');
        $paymentNature = $request->input('paymentNature');
        $findusername = DB::table('employees')->where('id', $request->input('saleperson'))->get();
        $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
        $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
        $brandID = $findclient[0]->brand;

        if($request->input('paymentNature') != "Remaining"){

            if($remainingamt == 0){
                $remainingstatus = "Not Remaining";
            }else{
                $remainingstatus = "Remaining";
            }

            if($request->file('bankWireUpload') != null ){
                $bookwire = $request->file('bankWireUpload')->store('Payment');
            }else{
                $bookwire ="--";
            }

            $upsellCount = NewPaymentsClients::where('ClientID',$request->input('clientID'))->where('paymentNature','Upsell')->count();
            // $transactionType = $request->input('paymentNature');

            if($request->input('paymentNature') == 'Upsell'){
                if($upsellCount == 0){
                    $transactionType = $request->input('paymentNature');
                }else{
                    $transactionType = $request->input('paymentNature')."(".$upsellCount.")";
                }
            }else{
                $transactionType = $request->input('paymentNature');
            }


                if( $request->input('nextpaymentdate') != null ){

                    $createpayment = NewPaymentsClients::insertGetId([
                        "BrandID" => $brandID,
                        "ClientID"=> $request->input('clientID'),
                        "ProjectID"=> $request->input('project'),
                        "ProjectManager"=> $request->input('accountmanager'),
                        "paymentNature"=> $request->input('paymentNature'),
                        "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                        "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                        "Platform"=> $request->input('platform'),
                        "Card_Brand"=> $request->input('cardBrand'),
                        "Payment_Gateway"=> $request->input('paymentgateway'),
                        "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                        "TransactionID"=> $request->input('transactionID'),
                        "paymentDate"=> $request->input('paymentdate'),
                        "futureDate"=> $request->input('nextpaymentdate'),
                        "SalesPerson"=> $request->input('saleperson'),
                        "TotalAmount"=> $request->input('totalamount'),
                        "Paid"=> $request->input('clientpaid'),
                        "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                        "PaymentType"=> $request->input('paymentType'),
                        "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                        "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                        "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                        "Description"=> $request->input('description'),
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus"=> 'On Going',
                        "remainingStatus"=> $remainingstatus,
                        "transactionType" => $transactionType

                    ]);

                }elseif( $request->input('ChargingPlan') != null && $request->input('nextpaymentdate') == null){

                    $today = date('Y-m-d');
                    if ($request->input('ChargingPlan') == "One Time Payment") {
                        $date = null ;
                    } elseif ($request->input('ChargingPlan') == "Monthly") {
                        $date = date('Y-m-d', strtotime('+1 month', strtotime($today)));
                    }elseif ($request->input('ChargingPlan') == "2 Months") {
                        $date = date('Y-m-d', strtotime('+2 month', strtotime($today)));
                    }elseif ($request->input('ChargingPlan') == "3 Months") {
                        $date = date('Y-m-d', strtotime('+3 month', strtotime($today)));
                    }elseif ($request->input('ChargingPlan') == "4 Months") {
                        $date = date('Y-m-d', strtotime('+4 month', strtotime($today)));
                    }elseif ($request->input('ChargingPlan') == "5 Months") {
                        $date = date('Y-m-d', strtotime('+5 month', strtotime($today)));
                    }elseif ($request->input('ChargingPlan') == "6 Months") {
                        $date = date('Y-m-d', strtotime('+6 month', strtotime($today)));
                    }elseif ($request->input('ChargingPlan') == "7 Months") {
                        $date = date('Y-m-d', strtotime('+7 month', strtotime($today)));
                    }elseif ($request->input('ChargingPlan') == "8 Months") {
                        $date = date('Y-m-d', strtotime('+8 month', strtotime($today)));
                    }elseif ($request->input('ChargingPlan') == "9 Months") {
                        $date = date('Y-m-d', strtotime('+9 month', strtotime($today)));
                    }elseif ($request->input('ChargingPlan') == "10 Months") {
                        $date = date('Y-m-d', strtotime('+10 month', strtotime($today)));
                    }elseif ($request->input('ChargingPlan') == "11 Months") {
                        $date = date('Y-m-d', strtotime('+11 month', strtotime($today)));
                    }elseif ($request->input('ChargingPlan') == "12 Months") {
                        $date = date('Y-m-d', strtotime('+1 Year', strtotime($today)));
                    }elseif ($request->input('ChargingPlan') == "2 Years") {
                        $date = date('Y-m-d', strtotime('+2 Year', strtotime($today)));
                    } elseif ($request->input('ChargingPlan') == "3 Years") {
                        $date = date('Y-m-d', strtotime('+3 Year', strtotime($today)));
                    }


                    $createpayment = NewPaymentsClients::insertGetId([
                        "BrandID" => $brandID,
                        "ClientID"=> $request->input('clientID'),
                        "ProjectID"=> $request->input('project'),
                        "ProjectManager"=> $request->input('accountmanager'),
                        "paymentNature"=> $request->input('paymentNature'),
                        "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                        "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                        "Platform"=> $request->input('platform'),
                        "Card_Brand"=> $request->input('cardBrand'),
                        "Payment_Gateway"=> $request->input('paymentgateway'),
                        "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                        "TransactionID"=> $request->input('transactionID'),
                        "paymentDate"=> $request->input('paymentdate'),
                        "futureDate"=> $date,
                        "SalesPerson"=> $request->input('saleperson'),
                        "TotalAmount"=> $request->input('totalamount'),
                        "Paid"=> $request->input('clientpaid'),
                        "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                        "PaymentType"=> $request->input('paymentType'),
                        "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                        "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                        "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                        "Description"=> $request->input('description'),
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus"=> 'On Going',
                        "remainingStatus"=> $remainingstatus,
                        "transactionType" => $transactionType

                    ]);

                }else{

                    $createpayment = NewPaymentsClients::insertGetId([
                        "BrandID" => $brandID,
                        "ClientID"=> $request->input('clientID'),
                        "ProjectID"=> $request->input('project'),
                        "ProjectManager"=> $request->input('accountmanager'),
                        "paymentNature"=> $request->input('paymentNature'),
                        "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                        "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                        "Platform"=> $request->input('platform'),
                        "Card_Brand"=> $request->input('cardBrand'),
                        "Payment_Gateway"=> $request->input('paymentgateway'),
                        "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                        "TransactionID"=> $request->input('transactionID'),
                        "paymentDate"=> $request->input('paymentdate'),
                        "futureDate"=> $request->input('nextpaymentdate'),
                        "SalesPerson"=> $request->input('saleperson'),
                        "TotalAmount"=> $request->input('totalamount'),
                        "Paid"=> $request->input('clientpaid'),
                        "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                        "PaymentType"=> $request->input('paymentType'),
                        "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                        "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                        "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                        "Description"=> $request->input('description'),
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus"=> 'On Going',
                        "remainingStatus"=> $remainingstatus,
                        "transactionType" => $transactionType

                    ]);

                }

                if( $request->input('nextpaymentdate') == null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment"){

                    if( $request->input('paymentModes') == 'Renewal' ){
                        $paymentNature = "Renewal Payment";
                    }else{
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
                        }
                        elseif ($interval == "4 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                        }elseif ($interval == "5 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                        }elseif ($interval == "6 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                        }elseif ($interval == "7 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                        }elseif ($interval == "8 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                        }elseif ($interval == "9 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                        }elseif ($interval == "10 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                        }elseif ($interval == "11 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                        }elseif ($interval == "12 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                        }elseif ($interval == "2 Years") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                        } elseif ($interval == "3 Years") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                        }
                        // echo $datefinal . "<br>";



                        $futurePayment = NewPaymentsClients::create([
                            "BrandID" => $brandID,
                            "ClientID"=> $request->input('clientID'),
                            "ProjectID"=> $request->input('project'),
                            "ProjectManager"=> $request->input('accountmanager'),
                            "paymentNature"=>  $paymentNature,
                            "ChargingPlan"=> '--',
                            "ChargingMode"=> '--',
                            "Platform"=> '--',
                            "Card_Brand"=> '--',
                            "Payment_Gateway"=> '--',
                            "bankWireUpload" => '--',
                            "TransactionID"=> '--',
                            // "paymentDate"=> $request->input('paymentdate'),
                            "futureDate"=> $datefinal,
                            "SalesPerson"=> $request->input('saleperson'),
                            "TotalAmount"=> $request->input('totalamount'),
                            "Paid"=> 0,
                            "RemainingAmount" => 0,
                            "PaymentType"=> '--',
                            "numberOfSplits" => '--',
                            "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                            "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                            "Description"=> '--',
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus"=> 'Pending Payment',
                            "remainingStatus"=> '--',
                            "transactionType" => $transactionType

                        ]);
                    }

                }elseif( $request->input('nextpaymentdate') != null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment"){

                    if( $request->input('paymentModes') == 'Renewal' ){
                        $paymentNature = "Renewal Payment";
                    }else{
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
                        }
                        elseif ($interval == "4 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                        }elseif ($interval == "5 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                        }elseif ($interval == "6 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                        }elseif ($interval == "7 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                        }elseif ($interval == "8 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                        }elseif ($interval == "9 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                        }elseif ($interval == "10 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                        }elseif ($interval == "11 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                        }elseif ($interval == "12 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                        }elseif ($interval == "2 Years") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                        } elseif ($interval == "3 Years") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                        }
                        // echo $datefinal . "<br>";



                        $futurePayment = NewPaymentsClients::create([
                            "BrandID" => $brandID,
                            "ClientID"=> $request->input('clientID'),
                            "ProjectID"=> $request->input('project'),
                            "ProjectManager"=> $request->input('accountmanager'),
                            "paymentNature"=>  $paymentNature,
                            "ChargingPlan"=> '--',
                            "ChargingMode"=> '--',
                            "Platform"=> '--',
                            "Card_Brand"=> '--',
                            "Payment_Gateway"=> '--',
                            "bankWireUpload" => '--',
                            "TransactionID"=> '--',
                            // "paymentDate"=> $request->input('paymentdate'),
                            "futureDate"=> $datefinal,
                            "SalesPerson"=> $request->input('saleperson'),
                            "TotalAmount"=> $request->input('totalamount'),
                            "Paid"=> 0,
                            "RemainingAmount" => 0,
                            "PaymentType"=> '--',
                            "numberOfSplits" => '--',
                            "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                            "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                            "Description"=> '--',
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus"=> 'Pending Payment',
                            "remainingStatus"=> '--',
                            "transactionType" => $transactionType

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
                        "paymentDescription" => $paymentDescription ,
                        "amount" => $amount
                    ]);



                foreach ($sharedProjectManager as $key => $value) {
                    $c[$key] = [$value, $amountShare[$key]];
                }

                foreach($c as $SecondProjectManagers){
                    if($SecondProjectManagers[0] != 0){
                        $createSharedPersonEmployeePayment  = EmployeePayment::create(
                            [
                                "paymentID" => $createpayment,
                                "employeeID" => $SecondProjectManagers[0],
                                "paymentDescription" => "Amount Share By " . $findusername[0]->name,
                                "amount" =>  $SecondProjectManagers[1]
                            ]);
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

        }else{

            $changeStatus = NewPaymentsClients::where('id',$request->input('remainingamountfor'))->update([
                "remainingID"  => $request->input('remainingID'),
                "remainingStatus"  => "Received Remaining"
            ]);

            $paymentType = $request->input('paymentType');
            $paymentNature = $request->input('paymentNature');
            $findusername = DB::table('employees')->where('id', $request->input('accountmanager'))->get();
            $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
            $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
            if($remainingamt == 0){
                $remainingstatus = "Received Remaining";
            }else{
                $remainingstatus = "Remaining";
            }

            if($request->file('bankWireUpload') != null ){
                $bookwire = $request->file('bankWireUpload')->store('Payment');
            }else{
                $bookwire ="--";
            }

            $transactionType = $request->input('paymentNature');


                // if( $request->input('nextpaymentdate') != null ){

                    $createpayment = NewPaymentsClients::insertGetId([
                        "BrandID" => $request->input('brandID'),
                        "ClientID"=> $request->input('clientID'),
                        "ProjectID"=> $request->input('project'),
                        "ProjectManager"=> $request->input('accountmanager'),
                        "paymentNature"=> $request->input('paymentNature'),
                        "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                        "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                        "Platform"=> $request->input('platform'),
                        "Card_Brand"=> $request->input('cardBrand'),
                        "Payment_Gateway"=> $request->input('paymentgateway'),
                        "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                        "TransactionID"=> $request->input('transactionID'),
                        "paymentDate"=> $request->input('paymentdate'),
                        // "futureDate"=> $request->input('nextpaymentdate'),
                        "SalesPerson"=> $request->input('saleperson'),
                        "TotalAmount"=> $request->input('totalamount'),
                        "Paid"=> $request->input('clientpaid'),
                        "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                        "PaymentType"=> $request->input('paymentType'),
                        "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                        "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                        "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                        "Description"=> $request->input('description'),
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus"=> 'On Going',
                        "remainingID" => $request->input('remainingID'),
                        "remainingStatus"=> $remainingstatus,
                        "transactionType" => $transactionType

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
                        "paymentDescription" => $paymentDescription ,
                        "amount" => $amount
                    ]);



                foreach ($sharedProjectManager as $key => $value) {
                    $c[$key] = [$value, $amountShare[$key]];
                }

                foreach($c as $SecondProjectManagers){
                    if($SecondProjectManagers[0] != 0){
                        $createSharedPersonEmployeePayment  = EmployeePayment::create(
                            [
                                "paymentID" => $createpayment,
                                "employeeID" => $SecondProjectManagers[0],
                                "paymentDescription" => "Remaining(Payment) Amount Share By " . $findusername[0]->name,
                                "amount" =>  $SecondProjectManagers[1]
                            ]);
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

            // return redirect('/forms/payment/' . $request->input('project'));
            return redirect('/client/details/' . $request->input('clientID'));
    }



    function payment_Refund(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $project = Project::where('id',$id)->get();
        $client = Client::where('id',$project[0]->clientID)->get();
        $client_payment = NewPaymentsClients::where('ClientID', $project[0]->clientID)
                        ->where('ProjectID', $id)
                        ->where('refundStatus','!=','Pending Payment')
                        ->get();
        $pmdepartment = Department::where('brand',$client[0]->brand)->where(function($query)
                        {
                            $query->where('name', 'LIKE', '%Project manager')
                            ->orWhere('name', 'LIKE', 'Project manager%')
                            ->orWhere('name', 'LIKE', '%Project manager%');
                        })->get();
        $pmemployee = Employee::whereIn('id',json_decode($pmdepartment[0]->users))->get();
        $saledepartment = Department::where('brand',$client[0]->brand)->where(function($query)
                        {
                            $query->where('name', 'LIKE', '%sale')
                            ->orWhere('name', 'LIKE', 'sale%')
                            ->orWhere('name', 'LIKE', '%sale%');
                        })->get();
        $saleemployee = Employee::whereIn('id',json_decode($saledepartment[0]->users))->get();
        $employee  = Employee::get();
        return view('payment_Refund', [
            'project' => $project,
            'client_payment' => $client_payment,
            'pmdepartment' => $pmdepartment,
            'pmemployee' => $pmemployee,
            'saledepartment' => $saledepartment,
            'saleemployee' => $saleemployee,
            'employee' => $employee ,
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
    function payment_Refund_Process(Request $request){
        $referencepayment = NewPaymentsClients::where('id', $request->input('paymentreference'))->get();
        $originalpayment = NewPaymentsClients::where('id', $request->input('paymentreference'))->update([
            "refundID" => $request->input('refundID')
        ]);

        if($request->file('bankWireUpload') != null ){
            $bookwire = $request->file('bankWireUpload')->store('Payment');
        }else{
            $bookwire ="--";
        }

        $originalrefund = NewPaymentsClients::insertGetId([
            "BrandID" => $request->input('brandID'),
            "ClientID"=> $request->input('clientID'),
            "ProjectID"=> $request->input('projectID'),
            "ProjectManager"=> $request->input('accountmanager'),
            "paymentNature"=> $referencepayment[0]->paymentNature,
            "ChargingPlan"=> $referencepayment[0]->ChargingPlan,
            "ChargingMode"=> $referencepayment[0]->ChargingMode,
            "Platform"=> $request->input('platform'),
            "Card_Brand"=> $request->input('cardBrand'),
            "Payment_Gateway"=> $request->input('paymentgateway'),
            "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
            "TransactionID"=> $request->input('transactionID'),
            "paymentDate"=> $request->input('paymentdate'),
            "SalesPerson"=> $request->input('saleperson'),
            "TotalAmount"=> $request->input('totalamount'),
            "Paid"=> $request->input('clientpaid'),
            "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
            "PaymentType"=> $referencepayment[0]->PaymentType,
            "numberOfSplits" => $referencepayment[0]->numberOfSplits,
            "SplitProjectManager" => $referencepayment[0]->SplitProjectManager,
            "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
            "Description"=> $request->input('description'),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s'),
            "refundStatus"=> 'Refund',
            "refundID" => $request->input('refundID'),
            "remainingStatus"=> 0,
            "transactionType" =>  $referencepayment[0]->transactionType

        ]);

        $payment_in_refund_table = RefundPayments::create([
            "BrandID" =>  $request->input('brandID'),
            "ClientID" =>  $request->input('clientID'),
            "ProjectID"=> $request->input('projectID'),
            'ProjectManager' => $request->input('accountmanager'),
            'PaymentID' => $originalrefund,
            'basicAmount' =>  $request->input('totalamount'),
            "refundAmount"=> $request->input('clientpaid'),
            "refundtype" => $request->input('chargebacktype'),
            "refund_date"=> $request->input('paymentdate'),
            "refundReason" =>  $request->input('description'),
            "clientpaid" =>   $referencepayment[0]->Paid,
            "paymentType" =>   $referencepayment[0]->PaymentType,
            "splitmanagers" =>   $referencepayment[0]->SplitProjectManager,
            "splitamounts" =>  $referencepayment[0]->ShareAmount,
            "splitRefunds" =>   ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),

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
                    "paymentDescription" => $paymentDescription ,
                    "amount" => $amount
                ]);



            foreach ($sharedProjectManager as $key => $value) {
                $c[$key] = [$value, $amountShare[$key]];
            }

            foreach($c as $SecondProjectManagers){
                if($SecondProjectManagers[0] != 0){
                    $createSharedPersonEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $originalrefund,
                            "employeeID" => $SecondProjectManagers[0],
                            "paymentDescription" => "refund Share By " . $request->input('saleperson'),
                            "amount" =>  $SecondProjectManagers[1]
                        ]);
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

        return redirect('/client/project/payment/all');

    }



    function payment_Dispute(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $client_payment = NewPaymentsClients::where('id', $id)->get();
        $related_payment = NewPaymentsClients::where('ClientID', $client_payment[0]->ClientID)->where('ProjectID', $client_payment[0]->ProjectID)->where('id','!=',$id)->where('transactionType', $client_payment[0]->transactionType)->get();
        $remaining_payment = NewPaymentsClients::where('ClientID', $client_payment[0]->ClientID)->where('ProjectID', $client_payment[0]->ProjectID)->where('id','!=',$id)->where('remainingID', $client_payment[0]->remainingID)->get();
        $employee  = Employee::get();
        return view('payment_Dispute', [
            'id' => $id,
            'client_payment' => $client_payment,
            'related_payment' => $related_payment,
            'remaining_payment' => $remaining_payment,
            'employee' => $employee,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);

    }
    function payment_Dispute_Process(Request $request){
        $referencepayment = NewPaymentsClients::where('id', $request->input('paymentID'))->get();

        $originalpayment = NewPaymentsClients::where('id', $request->input('paymentID'))->update([
            "dispute" => "dispute"
        ]);


        $payment_in_refund_table = Disputedpayments::create([
            "BrandID" =>  $request->input('brandID'),
            "ClientID" =>  $request->input('clientID'),
            "ProjectID"=> $request->input('projectID'),
            "ProjectManager" => $request->input('projectmanager'),
            "PaymentID" => $request->input('paymentID'),
            "dispute_Date" => $request->input('disputedate'),
            "disputedAmount" => $request->input('clientpaid'),
            "disputeReason" => $request->input('description'),

        ]);

        return redirect('/client/project/payment/all');
    }



    function all_disputes(Request $request){
        $loginUser = $this->roleExits($request);
        $client_payment = Disputedpayments::get();

        return view('all_disputes', [
            'clientPayments' => $client_payment,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }



    function payment_Dispute_lost(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $dispute = Disputedpayments::where('id',$id)->get();
        $projects = Project::get();
        $referencepayment = NewPaymentsClients::where('remainingStatus','!=','Unlinked Payments')->get();
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
    function payment_Dispute_Process_lost(Request $request){
        $referencepayment = NewPaymentsClients::where('id', $request->input('mainpayment'))->get();
        $Disputedpayments = Disputedpayments::where('id', $request->input('disputeID'))->update([
            "disputeStatus" => "Lost"
        ]);

        $originalpayment = NewPaymentsClients::where('id', $request->input('mainpayment'))->update([
            "refundID" => $request->input('refundID')
        ]);

        if($request->file('bankWireUpload') != null ){
            $bookwire = $request->file('bankWireUpload')->store('Payment');
        }else{
            $bookwire ="--";
        }

        $originalrefund = NewPaymentsClients::insertGetId([
            "BrandID" => $request->input('brandID'),
            "ClientID"=> $request->input('clientID'),
            "ProjectID"=> $request->input('projectID'),
            "ProjectManager"=> $request->input('accountmanager'),
            "paymentNature"=> $request->input('paymentNature'),
            "ChargingPlan"=> $referencepayment[0]->ChargingPlan,
            "ChargingMode"=> $referencepayment[0]->ChargingMode,
            "Platform"=> $referencepayment[0]->Platform,
            "Card_Brand"=> $referencepayment[0]->Card_Brand,
            "Payment_Gateway"=> $referencepayment[0]->Payment_Gateway,
            "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
            "TransactionID"=> $referencepayment[0]->TransactionID."(Refund)",
            "paymentDate"=> $request->input('paymentdate'),
            "SalesPerson"=> $referencepayment[0]->SalesPerson,
            "TotalAmount"=> $referencepayment[0]->TotalAmount,
            "Paid"=> $referencepayment[0]->Paid,
            "RemainingAmount" =>0,
            "PaymentType"=> $referencepayment[0]->PaymentType,
            "numberOfSplits" => $referencepayment[0]->numberOfSplits,
            "SplitProjectManager" => $referencepayment[0]->SplitProjectManager,
            "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('refundamount')),
            "Description"=> $request->input('Description_of_issue'),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s'),
            "refundStatus"=> 'Refund',
            "refundID" => $request->input('refundID'),
            "remainingStatus"=> "Dispute Lost",
            "transactionType" =>  $referencepayment[0]->transactionType

        ]);

        $payment_in_refund_table = RefundPayments::create([
            "BrandID" =>  $request->input('brandID'),
            "ClientID" =>  $request->input('clientID'),
            "ProjectID"=> $request->input('projectID'),
            'ProjectManager' => $request->input('accountmanager'),
            'PaymentID' => $originalrefund,
            'basicAmount' =>  $referencepayment[0]->TotalAmount,
            "refundAmount"=> $request->input('chagebackAmt'),
            "refundtype" => $request->input('chargebacktype'),
            "refund_date"=> $request->input('chagebackDate'),
            "refundReason" =>  $request->input('Description_of_issue'),
            "clientpaid" =>   $referencepayment[0]->Paid,
            "paymentType" =>   $referencepayment[0]->PaymentType,
            "splitmanagers" =>   $referencepayment[0]->SplitProjectManager,
            "splitamounts" =>  $referencepayment[0]->ShareAmount,
            "splitRefunds" =>   ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('refundamount')),

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
                    "paymentDescription" => $paymentDescription ,
                    "amount" => $amount
                ]);



            foreach ($sharedProjectManager as $key => $value) {
                $c[$key] = [$value, $amountShare[$key]];
            }

            foreach($c as $SecondProjectManagers){
                if($SecondProjectManagers[0] != 0){
                    $createSharedPersonEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $originalrefund,
                            "employeeID" => $SecondProjectManagers[0],
                            "paymentDescription" => "Refund Share By " . $request->input('saleperson'),
                            "amount" =>  $SecondProjectManagers[1]
                        ]);
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



    function payment_Dispute_won(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $dispute = Disputedpayments::where('id',$id)->get();
        $projects = Project::get();
        $referencepayment = NewPaymentsClients::where('remainingStatus','!=','Unlinked Payments')->get();
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
    function payment_Dispute_Process_won(Request $request){
        $referencepayment = NewPaymentsClients::where('id', $request->input('mainpayment'))->get();
        $Disputedpayments = Disputedpayments::where('id', $request->input('disputeID'))->update([
            "disputeStatus" => "Won"
        ]);

        if($request->file('bankWireUpload') != null ){
            $bookwire = $request->file('bankWireUpload')->store('Payment');
        }else{
            $bookwire ="--";
        }


        $createpayment = NewPaymentsClients::insertGetId([
            "BrandID" => $referencepayment[0]->BrandID,
            "ClientID"=> $referencepayment[0]->ClientID,
            "ProjectID"=> $referencepayment[0]->ProjectID,
            "ProjectManager"=> $referencepayment[0]->ProjectManager,
            "paymentNature"=> $request->input('paymentNature'),
            "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
            "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
            "Platform"=> $referencepayment[0]->Platform,
            "Card_Brand"=> $referencepayment[0]->Card_Brand,
            "Payment_Gateway"=> $referencepayment[0]->Payment_Gateway,
            "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
            "TransactionID"=> $referencepayment[0]->TransactionID."(Dispute Won)",
            "paymentDate"=> $request->input('paymentdate'),
            "SalesPerson"=> $referencepayment[0]->SalesPerson,
            "TotalAmount"=> $referencepayment[0]->TotalAmount,
            "Paid"=> $referencepayment[0]->Paid,
            "RemainingAmount" => 0,
            "PaymentType"=> $referencepayment[0]->PaymentType,
            "numberOfSplits" => $referencepayment[0]->numberOfSplits,
            "SplitProjectManager" => $referencepayment[0]->SplitProjectManager,
            "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('newamount')),
            "Description"=> $request->input('description'),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s'),
            "refundStatus"=> 'On Going',
            "remainingStatus"=> "Dispute Won",
            "transactionType" => $referencepayment[0]->transactionType,
        ]);

        if ($referencepayment[0]->PaymentType == "Split Payment") {
            $paymentDescription = $request->input('saleperson') . " Charge Payment For Client " . $request->input('clientID');
            $totalamount = $request->input('totalamount');
            $amountShare = $request->input('splitamount');
            $sharedProjectManager = $request->input('shareProjectManager');
            $c = [];
            $amount = $totalamount - $amountShare[0] - $amountShare[1] - $amountShare[2] - $amountShare[3];

            $createMainEmployeePayment  = EmployeePayment::create([
                    "paymentID" => $createpayment,
                    "employeeID" => $request->input('saleperson'),
                    "paymentDescription" => $paymentDescription ,
                    "amount" => $amount
                ]);



            foreach ($sharedProjectManager as $key => $value) {
                $c[$key] = [$value, $amountShare[$key]];
            }

            foreach($c as $SecondProjectManagers){
                if($SecondProjectManagers[0] != 0){
                    $createSharedPersonEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $createpayment,
                            "employeeID" => $SecondProjectManagers[0],
                            "paymentDescription" => "Amount Share By " . $request->input('saleperson'),
                            "amount" =>  $SecondProjectManagers[1]
                        ]);
                }
            }

        } else {

            $paymentDescription = $request->input('saleperson') . " Charge Payment For Client " . $request->input('clientID');
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

        return redirect('/client/project/payment/all');

    }



    function projectpayment_view_dispute($id, Request $request)
    {
        $loginUser = $this->roleExits($request);
        $dispute = Disputedpayments::where('id',$id)->get();
        // echo("<pre>");
        // print_r($dispute);
        // die();
        return view('disputeView', [
            'dispute' => $dispute,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]]);
    }


    function payment_edit_amount(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $editPayment = NewPaymentsClients::where('id', $id)->get();
        $findclientofproject = Client::where('id', $editPayment[0]->ClientID)->get();
        $pmdepartment = Department::where('brand',$findclientofproject[0]->brand)->where(function($query)
                            {
                                $query->where('name', 'LIKE', '%Project manager')
                                ->orWhere('name', 'LIKE', 'Project manager%')
                                ->orWhere('name', 'LIKE', '%Project manager%');
                            })->get();
        $pmemployee = Employee::whereIn('id',json_decode($pmdepartment[0]->users))->get();
        $saledepartment = Department::where('brand',$findclientofproject[0]->brand)->where(function($query)
                            {
                                $query->where('name', 'LIKE', '%sale')
                                ->orWhere('name', 'LIKE', 'sale%')
                                ->orWhere('name', 'LIKE', '%sale%');
                            })->get();
        $saleemployee = Employee::whereIn('id',json_decode($saledepartment[0]->users))->get();
        if($editPayment[0]->remainingStatus != 'Unlinked Payments'){
            $findclient = Client::get();
            $findemployee = Employee::get();
            $allPayments = NewPaymentsClients::where('ClientID', $editPayment[0]->ClientID)
                            ->where('refundStatus','!=','Pending Payment')
                            ->where('remainingStatus','!=','Unlinked Payments')
                            ->get();

            return view('edit_payment', [
                'allPayments' => $allPayments,
                'editPayments' => $editPayment,
                'clients' => $findclient,
                'employee' => $findemployee,
                'pmemployee' => $pmemployee,
                'saleemployee' => $saleemployee,
                'LoginUser' => $loginUser[1],
                'departmentAccess' => $loginUser[0],
                'superUser' => $loginUser[2]]);

        }else{

            $findproject = Project::where('clientID', $editPayment[0]->ClientID)->get();
            $findclientofproject = Client::where('id', $editPayment[0]->ClientID)->get();
            $findclient = Client::get();
            $findemployee = Employee::get();
            $allPayments = NewPaymentsClients::where('ClientID', $editPayment[0]->ClientID)
                            ->where('refundStatus','!=','Pending Payment')
                            ->where('remainingStatus','!=','Unlinked Payments')
                            ->get();
            $remainingpayments = NewPaymentsClients::where('ClientID', $findproject[0]->ClientName->id)
                            ->where('refundStatus','!=','Pending Payment')
                            ->where('remainingStatus','Remaining')
                            ->get();
            $remainingpaymentcount = count($remainingpayments);
            $referencepayment = NewPaymentsClients::where('ClientID', $editPayment[0]->ClientID)
                            ->where('refundStatus','!=','Pending Payment')
                            ->where('remainingStatus','!=','Unlinked Payments')
                            ->get();


            return view('paymentFromunlinked', [
                'allPayments' => $allPayments,
                'editPayments' => $editPayment,
                'id' => $id,
                'projectmanager' => $findproject,
                'findclientofproject' => $findclientofproject,
                'clients' => $findclient,
                'employee' => $findemployee,
                'pmemployee' => $pmemployee,
                'saleemployee' => $saleemployee,
                'remainingpayments' => $remainingpayments,
                'remainingpaymentcount' => $remainingpaymentcount,
                'referencepayment' => $referencepayment,
                'LoginUser' => $loginUser[1],
                'departmentAccess' => $loginUser[0],
                'superUser' => $loginUser[2]]);

            }

    }
    function payment_edit_amount_process(Request $request, $id){
        $paymentType = $request->input('paymentType');
        $paymentNature = $request->input('paymentNature');
        $allPayments = NewPaymentsClients::where('id', $id)->get();
        $findusername = DB::table('employees')->where('id', $request->input('accountmanager'))->get();
        $findclient = DB::table('clients')->where('id', $allPayments[0]->ClientID)->get();

        $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
        if($remainingamt == 0){
            $remainingstatus = "Not Remaining";
        }else{
            $remainingstatus = "Remaining";
        }

        $upsellCount = NewPaymentsClients::where('ClientID',$request->input('clientID'))->where('paymentNature','Upsell')->count();
        if($request->input('paymentNature') == 'Upsell'){
            if($upsellCount == 0){
                $transactionType = $request->input('paymentNature');
            }else{
                $transactionType = $request->input('paymentNature')."(".$upsellCount.")";
            }
        }else{
            $transactionType = $request->input('paymentNature');
        }

        if($request->file('bankWireUpload') != null ){
            $bookwire = $request->file('bankWireUpload')->store('Payment');
        }else{
            $bookwire ="--";
        }

        if ($request->hasFile('bankWireUpload')) {
            if($allPayments[0]->bankWireUpload != "--"){
                $path = storage_path('app/' . $allPayments[0]->bankWireUpload);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
        };

        if($allPayments[0]->bankWireUpload == $request->input('paymentNature')){
            if(($allPayments[0]->futureDate == $request->input('nextpaymentdate')) || $request->input('nextpaymentdate') == null){
                $Payments = NewPaymentsClients::where('id', $id)
                ->update([
                    "ProjectManager"=> $request->input('accountmanager'),
                    "paymentNature"=> $request->input('paymentNature'),
                    "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform"=> $request->input('platform'),
                    "Card_Brand"=> $request->input('cardBrand'),
                    "Payment_Gateway"=> $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID"=> $request->input('transactionID'),
                    "paymentDate"=> $request->input('paymentdate'),
                    "SalesPerson"=> $request->input('saleperson'),
                    "TotalAmount"=> $request->input('totalamount'),
                    "Paid"=> $request->input('clientpaid'),
                    "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType"=> $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description"=> $request->input('description'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus"=> 'On Going',
                    "remainingStatus"=> $remainingstatus
                ]);

            }else{

                $Payments = NewPaymentsClients::where('id', $id)
                ->update([
                    "ProjectManager"=> $request->input('accountmanager'),
                    "paymentNature"=> $request->input('paymentNature'),
                    "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform"=> $request->input('platform'),
                    "Card_Brand"=> $request->input('cardBrand'),
                    "Payment_Gateway"=> $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID"=> $request->input('transactionID'),
                    "paymentDate"=> $request->input('paymentdate'),
                    "futureDate"=> $request->input('nextpaymentdate'),
                    "SalesPerson"=> $request->input('saleperson'),
                    "TotalAmount"=> $request->input('totalamount'),
                    "Paid"=> $request->input('clientpaid'),
                    "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType"=> $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description"=> $request->input('description'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus"=> 'On Going',
                    "remainingStatus"=> $remainingstatus
                ]);
                $deletePendingpayments = NewPaymentsClients::where('transactionType', $allPayments[0]->transactionType)->where('paymentDate', null)->delete();

                if($request->input('nextpaymentdate') != null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment"){
                    if( $request->input('paymentModes') == 'Renewal' ){
                        $paymentNature = "Renewal Payment";
                    }else{
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
                        }
                        elseif ($interval == "4 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                        }elseif ($interval == "5 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                        }elseif ($interval == "6 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                        }elseif ($interval == "7 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                        }elseif ($interval == "8 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                        }elseif ($interval == "9 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                        }elseif ($interval == "10 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                        }elseif ($interval == "11 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                        }elseif ($interval == "12 Months") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                        }elseif ($interval == "2 Years") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                        } elseif ($interval == "3 Years") {
                            $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                        }
                        // echo $datefinal . "<br>";



                        $futurePayment = NewPaymentsClients::create([
                            "BrandID" => $request->input('brandID'),
                            "ClientID"=> $request->input('clientID'),
                            "ProjectID"=> $request->input('project'),
                            "ProjectManager"=> $request->input('accountmanager'),
                            "paymentNature"=>  $paymentNature,
                            "ChargingPlan"=> '--',
                            "ChargingMode"=> '--',
                            "Platform"=> '--',
                            "Card_Brand"=> '--',
                            "Payment_Gateway"=> '--',
                            "bankWireUpload" => '--',
                            "TransactionID"=> '--',
                            // "paymentDate"=> $request->input('paymentdate'),
                            "futureDate"=> $datefinal,
                            "SalesPerson"=> $request->input('saleperson'),
                            "TotalAmount"=> $request->input('totalamount'),
                            "Paid"=> 0,
                            "RemainingAmount" => 0,
                            "PaymentType"=> '--',
                            "numberOfSplits" => '--',
                            "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                            "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                            "Description"=> '--',
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus"=> 'Pending Payment',
                            "remainingStatus"=> '--',
                            "transactionType" => $allPayments[0]->transactionType

                        ]);
                    }


                }
            }

        }else{
            if($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "New Sale"){
                if($allPayments[0]->paymentNature == "New Lead" || $allPayments[0]->paymentNature == "New Sale" || $allPayments[0]->paymentNature == "New Sale"){
                    $deletePendingpayments = NewPaymentsClients::where('transactionType', $allPayments[0]->transactionType)->where('paymentDate', null)->delete();
                    if($request->input('nextpaymentdate') != null){
                        $Payments = NewPaymentsClients::where('id', $id)
                        ->update([
                            "ProjectManager"=> $request->input('accountmanager'),
                            "paymentNature"=> $request->input('paymentNature'),
                            "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                            "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                            "Platform"=> $request->input('platform'),
                            "Card_Brand"=> $request->input('cardBrand'),
                            "Payment_Gateway"=> $request->input('paymentgateway'),
                            "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                            "TransactionID"=> $request->input('transactionID'),
                            "paymentDate"=> $request->input('paymentdate'),
                            "futureDate"=> $request->input('nextpaymentdate'),
                            "SalesPerson"=> $request->input('saleperson'),
                            "TotalAmount"=> $request->input('totalamount'),
                            "Paid"=> $request->input('clientpaid'),
                            "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                            "PaymentType"=> $request->input('paymentType'),
                            "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                            "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                            "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                            "Description"=> $request->input('description'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus"=> 'On Going',
                            "remainingStatus"=> $remainingstatus
                        ]);

                        if($request->input('nextpaymentdate') == null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment"){
                            if( $request->input('paymentModes') == 'Renewal' ){
                                $paymentNature = "Renewal Payment";
                            }else{
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
                                }
                                elseif ($interval == "4 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                                }elseif ($interval == "5 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                                }elseif ($interval == "6 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                                }elseif ($interval == "7 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                                }elseif ($interval == "8 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                                }elseif ($interval == "9 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                                }elseif ($interval == "10 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                                }elseif ($interval == "11 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                                }elseif ($interval == "12 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                                }elseif ($interval == "2 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                                } elseif ($interval == "3 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                                }
                                // echo $datefinal . "<br>";



                                $futurePayment = NewPaymentsClients::create([
                                    "BrandID" => $request->input('brandID'),
                                    "ClientID"=> $request->input('clientID'),
                                    "ProjectID"=> $request->input('project'),
                                    "ProjectManager"=> $request->input('accountmanager'),
                                    "paymentNature"=>  $paymentNature,
                                    "ChargingPlan"=> '--',
                                    "ChargingMode"=> '--',
                                    "Platform"=> '--',
                                    "Card_Brand"=> '--',
                                    "Payment_Gateway"=> '--',
                                    "bankWireUpload" => '--',
                                    "TransactionID"=> '--',
                                    // "paymentDate"=> $request->input('paymentdate'),
                                    "futureDate"=> $datefinal,
                                    "SalesPerson"=> $request->input('saleperson'),
                                    "TotalAmount"=> $request->input('totalamount'),
                                    "Paid"=> 0,
                                    "RemainingAmount" => 0,
                                    "PaymentType"=> '--',
                                    "numberOfSplits" => '--',
                                    "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                                    "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                                    "Description"=> '--',
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus"=> 'Pending Payment',
                                    "remainingStatus"=> '--',
                                    "transactionType" => $allPayments[0]->transactionType

                                ]);
                            }

                        }


                    }else{
                        $today = date('Y-m-d');
                        if ($request->input('ChargingPlan') == "One Time Payment") {
                            $date = null ;
                        } elseif ($request->input('ChargingPlan') == "Monthly") {
                            $date = date('Y-m-d', strtotime('+1 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "2 Months") {
                            $date = date('Y-m-d', strtotime('+2 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "3 Months") {
                            $date = date('Y-m-d', strtotime('+3 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "4 Months") {
                            $date = date('Y-m-d', strtotime('+4 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "5 Months") {
                            $date = date('Y-m-d', strtotime('+5 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "6 Months") {
                            $date = date('Y-m-d', strtotime('+6 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "7 Months") {
                            $date = date('Y-m-d', strtotime('+7 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "8 Months") {
                            $date = date('Y-m-d', strtotime('+8 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "9 Months") {
                            $date = date('Y-m-d', strtotime('+9 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "10 Months") {
                            $date = date('Y-m-d', strtotime('+10 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "11 Months") {
                            $date = date('Y-m-d', strtotime('+11 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "12 Months") {
                            $date = date('Y-m-d', strtotime('+1 Year', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "2 Years") {
                            $date = date('Y-m-d', strtotime('+2 Year', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "3 Years") {
                            $date = date('Y-m-d', strtotime('+3 Year', strtotime($today)));
                        }


                        $Payments = NewPaymentsClients::where('id', $id)
                        ->update([
                            "BrandID" => $request->input('brandID'),
                            "ClientID"=> $request->input('clientID'),
                            "ProjectID"=> $request->input('project'),
                            "ProjectManager"=> $request->input('accountmanager'),
                            "paymentNature"=> $request->input('paymentNature'),
                            "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                            "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                            "Platform"=> $request->input('platform'),
                            "Card_Brand"=> $request->input('cardBrand'),
                            "Payment_Gateway"=> $request->input('paymentgateway'),
                            "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                            "TransactionID"=> $request->input('transactionID'),
                            "paymentDate"=> $request->input('paymentdate'),
                            "futureDate"=> $date,
                            "SalesPerson"=> $request->input('saleperson'),
                            "TotalAmount"=> $request->input('totalamount'),
                            "Paid"=> $request->input('clientpaid'),
                            "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                            "PaymentType"=> $request->input('paymentType'),
                            "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                            "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                            "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                            "Description"=> $request->input('description'),
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus"=> 'On Going',
                            "remainingStatus"=> $remainingstatus,
                            "transactionType" => $transactionType

                        ]);

                        if($request->input('nextpaymentdate') == null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment"){
                            if( $request->input('paymentModes') == 'Renewal' ){
                                $paymentNature = "Renewal Payment";
                            }else{
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
                                }
                                elseif ($interval == "4 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                                }elseif ($interval == "5 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                                }elseif ($interval == "6 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                                }elseif ($interval == "7 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                                }elseif ($interval == "8 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                                }elseif ($interval == "9 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                                }elseif ($interval == "10 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                                }elseif ($interval == "11 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                                }elseif ($interval == "12 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                                }elseif ($interval == "2 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                                } elseif ($interval == "3 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                                }
                                // echo $datefinal . "<br>";



                                $futurePayment = NewPaymentsClients::create([
                                    "BrandID" => $request->input('brandID'),
                                    "ClientID"=> $request->input('clientID'),
                                    "ProjectID"=> $request->input('project'),
                                    "ProjectManager"=> $request->input('accountmanager'),
                                    "paymentNature"=>  $paymentNature,
                                    "ChargingPlan"=> '--',
                                    "ChargingMode"=> '--',
                                    "Platform"=> '--',
                                    "Card_Brand"=> '--',
                                    "Payment_Gateway"=> '--',
                                    "bankWireUpload" => '--',
                                    "TransactionID"=> '--',
                                    // "paymentDate"=> $request->input('paymentdate'),
                                    "futureDate"=> $datefinal,
                                    "SalesPerson"=> $request->input('saleperson'),
                                    "TotalAmount"=> $request->input('totalamount'),
                                    "Paid"=> 0,
                                    "RemainingAmount" => 0,
                                    "PaymentType"=> '--',
                                    "numberOfSplits" => '--',
                                    "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                                    "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                                    "Description"=> '--',
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus"=> 'Pending Payment',
                                    "remainingStatus"=> '--',
                                    "transactionType" => $allPayments[0]->transactionType

                                ]);
                            }


                        }


                    }

                }else{
                    if($request->input('nextpaymentdate') != null){
                        $Payments = NewPaymentsClients::where('id', $id)
                        ->update([
                            "ProjectManager"=> $request->input('accountmanager'),
                            "paymentNature"=> $request->input('paymentNature'),
                            "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                            "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                            "Platform"=> $request->input('platform'),
                            "Card_Brand"=> $request->input('cardBrand'),
                            "Payment_Gateway"=> $request->input('paymentgateway'),
                            "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                            "TransactionID"=> $request->input('transactionID'),
                            "paymentDate"=> $request->input('paymentdate'),
                            "futureDate"=> $request->input('nextpaymentdate'),
                            "SalesPerson"=> $request->input('saleperson'),
                            "TotalAmount"=> $request->input('totalamount'),
                            "Paid"=> $request->input('clientpaid'),
                            "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                            "PaymentType"=> $request->input('paymentType'),
                            "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                            "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                            "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                            "Description"=> $request->input('description'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus"=> 'On Going',
                            "remainingStatus"=> $remainingstatus
                        ]);

                        if($request->input('nextpaymentdate') == null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment"){
                            if( $request->input('paymentModes') == 'Renewal' ){
                                $paymentNature = "Renewal Payment";
                            }else{
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
                                }
                                elseif ($interval == "4 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                                }elseif ($interval == "5 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                                }elseif ($interval == "6 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                                }elseif ($interval == "7 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                                }elseif ($interval == "8 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                                }elseif ($interval == "9 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                                }elseif ($interval == "10 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                                }elseif ($interval == "11 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                                }elseif ($interval == "12 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                                }elseif ($interval == "2 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                                } elseif ($interval == "3 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                                }
                                // echo $datefinal . "<br>";



                                $futurePayment = NewPaymentsClients::create([
                                    "BrandID" => $request->input('brandID'),
                                    "ClientID"=> $request->input('clientID'),
                                    "ProjectID"=> $request->input('project'),
                                    "ProjectManager"=> $request->input('accountmanager'),
                                    "paymentNature"=>  $paymentNature,
                                    "ChargingPlan"=> '--',
                                    "ChargingMode"=> '--',
                                    "Platform"=> '--',
                                    "Card_Brand"=> '--',
                                    "Payment_Gateway"=> '--',
                                    "bankWireUpload" => '--',
                                    "TransactionID"=> '--',
                                    // "paymentDate"=> $request->input('paymentdate'),
                                    "futureDate"=> $datefinal,
                                    "SalesPerson"=> $request->input('saleperson'),
                                    "TotalAmount"=> $request->input('totalamount'),
                                    "Paid"=> 0,
                                    "RemainingAmount" => 0,
                                    "PaymentType"=> '--',
                                    "numberOfSplits" => '--',
                                    "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                                    "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                                    "Description"=> '--',
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus"=> 'Pending Payment',
                                    "remainingStatus"=> '--',
                                    "transactionType" => $allPayments[0]->transactionType

                                ]);
                            }

                        }


                    }else{
                        $today = date('Y-m-d');
                        if ($request->input('ChargingPlan') == "One Time Payment") {
                            $date = null ;
                        } elseif ($request->input('ChargingPlan') == "Monthly") {
                            $date = date('Y-m-d', strtotime('+1 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "2 Months") {
                            $date = date('Y-m-d', strtotime('+2 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "3 Months") {
                            $date = date('Y-m-d', strtotime('+3 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "4 Months") {
                            $date = date('Y-m-d', strtotime('+4 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "5 Months") {
                            $date = date('Y-m-d', strtotime('+5 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "6 Months") {
                            $date = date('Y-m-d', strtotime('+6 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "7 Months") {
                            $date = date('Y-m-d', strtotime('+7 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "8 Months") {
                            $date = date('Y-m-d', strtotime('+8 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "9 Months") {
                            $date = date('Y-m-d', strtotime('+9 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "10 Months") {
                            $date = date('Y-m-d', strtotime('+10 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "11 Months") {
                            $date = date('Y-m-d', strtotime('+11 month', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "12 Months") {
                            $date = date('Y-m-d', strtotime('+1 Year', strtotime($today)));
                        }elseif ($request->input('ChargingPlan') == "2 Years") {
                            $date = date('Y-m-d', strtotime('+2 Year', strtotime($today)));
                        } elseif ($request->input('ChargingPlan') == "3 Years") {
                            $date = date('Y-m-d', strtotime('+3 Year', strtotime($today)));
                        }


                        $Payments = NewPaymentsClients::where('id', $id)
                        ->update([
                            "BrandID" => $request->input('brandID'),
                            "ClientID"=> $request->input('clientID'),
                            "ProjectID"=> $request->input('project'),
                            "ProjectManager"=> $request->input('accountmanager'),
                            "paymentNature"=> $request->input('paymentNature'),
                            "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                            "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                            "Platform"=> $request->input('platform'),
                            "Card_Brand"=> $request->input('cardBrand'),
                            "Payment_Gateway"=> $request->input('paymentgateway'),
                            "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                            "TransactionID"=> $request->input('transactionID'),
                            "paymentDate"=> $request->input('paymentdate'),
                            "futureDate"=> $date,
                            "SalesPerson"=> $request->input('saleperson'),
                            "TotalAmount"=> $request->input('totalamount'),
                            "Paid"=> $request->input('clientpaid'),
                            "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                            "PaymentType"=> $request->input('paymentType'),
                            "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                            "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                            "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                            "Description"=> $request->input('description'),
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus"=> 'On Going',
                            "remainingStatus"=> $remainingstatus,
                            "transactionType" => $transactionType

                        ]);

                        if($request->input('nextpaymentdate') == null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment"){
                            if( $request->input('paymentModes') == 'Renewal' ){
                                $paymentNature = "Renewal Payment";
                            }else{
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
                                }
                                elseif ($interval == "4 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                                }elseif ($interval == "5 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                                }elseif ($interval == "6 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                                }elseif ($interval == "7 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                                }elseif ($interval == "8 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                                }elseif ($interval == "9 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                                }elseif ($interval == "10 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                                }elseif ($interval == "11 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                                }elseif ($interval == "12 Months") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                                }elseif ($interval == "2 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                                } elseif ($interval == "3 Years") {
                                    $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                                }
                                // echo $datefinal . "<br>";



                                $futurePayment = NewPaymentsClients::create([
                                    "BrandID" => $request->input('brandID'),
                                    "ClientID"=> $request->input('clientID'),
                                    "ProjectID"=> $request->input('project'),
                                    "ProjectManager"=> $request->input('accountmanager'),
                                    "paymentNature"=>  $paymentNature,
                                    "ChargingPlan"=> '--',
                                    "ChargingMode"=> '--',
                                    "Platform"=> '--',
                                    "Card_Brand"=> '--',
                                    "Payment_Gateway"=> '--',
                                    "bankWireUpload" => '--',
                                    "TransactionID"=> '--',
                                    // "paymentDate"=> $request->input('paymentdate'),
                                    "futureDate"=> $datefinal,
                                    "SalesPerson"=> $request->input('saleperson'),
                                    "TotalAmount"=> $request->input('totalamount'),
                                    "Paid"=> 0,
                                    "RemainingAmount" => 0,
                                    "PaymentType"=> '--',
                                    "numberOfSplits" => '--',
                                    "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                                    "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                                    "Description"=> '--',
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus"=> 'Pending Payment',
                                    "remainingStatus"=> '--',
                                    "transactionType" => $allPayments[0]->transactionType

                                ]);
                            }


                        }


                    }

                }

            }else{
                if($allPayments[0]->paymentNature == "New Lead" || $allPayments[0]->paymentNature == "New Sale" || $allPayments[0]->paymentNature == "New Sale"){
                    $deletePendingpayments = NewPaymentsClients::where('transactionType', $allPayments[0]->transactionType)->where('paymentDate', null)->delete();
                    $Payments = NewPaymentsClients::where('id', $id)
                    ->update([
                        "BrandID" => $request->input('brandID'),
                        "ClientID"=> $request->input('clientID'),
                        "ProjectID"=> $request->input('project'),
                        "ProjectManager"=> $request->input('accountmanager'),
                        "paymentNature"=> $request->input('paymentNature'),
                        "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                        "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                        "Platform"=> $request->input('platform'),
                        "Card_Brand"=> $request->input('cardBrand'),
                        "Payment_Gateway"=> $request->input('paymentgateway'),
                        "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                        "TransactionID"=> $request->input('transactionID'),
                        "paymentDate"=> $request->input('paymentdate'),
                        "futureDate"=> null,
                        "SalesPerson"=> $request->input('saleperson'),
                        "TotalAmount"=> $request->input('totalamount'),
                        "Paid"=> $request->input('clientpaid'),
                        "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                        "PaymentType"=> $request->input('paymentType'),
                        "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                        "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                        "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                        "Description"=> $request->input('description'),
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus"=> 'On Going',
                        "remainingStatus"=> $remainingstatus,
                        "transactionType" => $transactionType

                    ]);

                }else{
                    $Payments = NewPaymentsClients::where('id', $id)
                    ->update([
                        "BrandID" => $request->input('brandID'),
                        "ClientID"=> $request->input('clientID'),
                        "ProjectID"=> $request->input('project'),
                        "ProjectManager"=> $request->input('accountmanager'),
                        "paymentNature"=> $request->input('paymentNature'),
                        "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                        "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                        "Platform"=> $request->input('platform'),
                        "Card_Brand"=> $request->input('cardBrand'),
                        "Payment_Gateway"=> $request->input('paymentgateway'),
                        "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                        "TransactionID"=> $request->input('transactionID'),
                        "paymentDate"=> $request->input('paymentdate'),
                        "futureDate"=> null,
                        "SalesPerson"=> $request->input('saleperson'),
                        "TotalAmount"=> $request->input('totalamount'),
                        "Paid"=> $request->input('clientpaid'),
                        "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                        "PaymentType"=> $request->input('paymentType'),
                        "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                        "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                        "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                        "Description"=> $request->input('description'),
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus"=> 'On Going',
                        "remainingStatus"=> $remainingstatus,
                        "transactionType" => $transactionType

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
                    "paymentDescription" => $paymentDescription ,
                    "amount" => $amount
                ]);



            foreach ($sharedProjectManager as $key => $value) {
                $c[$key] = [$value, $amountShare[$key]];
            }

            foreach($c as $SecondProjectManagers){
                if($SecondProjectManagers[0] != 0){
                    $createSharedPersonEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $id,
                            "employeeID" => $SecondProjectManagers[0],
                            "paymentDescription" => "Amount Share By " . $request->input('saleperson'),
                            "amount" =>  $SecondProjectManagers[1]
                        ]);
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
        $checkforremaining = NewPaymentsClients::where('id',$id)->get();
        $paymentType = $request->input('paymentType');
        $paymentNature = $request->input('paymentNature');
        $findusername = DB::table('employees')->where('id', $request->input('accountmanager'))->get();
        $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
        $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
        $brandID = $findclient[0]->brand;
        if($checkforremaining[0]->remainingID != null ){
            $remainingstatus = "Not Remaining";
        }elseif($remainingamt == 0){
            $remainingstatus = "Not Remaining";
        }else{
            $remainingstatus = "Remaining";
        }

        if($request->file('bankWireUpload') != null ){
            $bookwire = $request->file('bankWireUpload')->store('Payment');
        }else{
            $bookwire ="--";
        }

        $upsellCount = NewPaymentsClients::where('ClientID',$request->input('clientID'))->where('paymentNature','Upsell')->count();
        // $transactionType = $request->input('paymentNature');

        if($request->input('paymentNature') == 'Upsell'){
            if($upsellCount == 0){
                $transactionType = $request->input('paymentNature');
            }else{
                $transactionType = $request->input('paymentNature')."(".$upsellCount.")";
            }
        }else{
            $transactionType = $request->input('paymentNature');
        }


            if( $request->input('nextpaymentdate') != null ){

                $createpayment = NewPaymentsClients::where('id',$id)->update([
                    "BrandID" => $brandID,
                    "ClientID"=> $request->input('clientID'),
                    "ProjectID"=> $request->input('project'),
                    "ProjectManager"=> $request->input('accountmanager'),
                    "paymentNature"=> $request->input('paymentNature'),
                    "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform"=> $request->input('platform'),
                    "Card_Brand"=> $request->input('cardBrand'),
                    "Payment_Gateway"=> $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID"=> $request->input('transactionID'),
                    "paymentDate"=> $request->input('paymentdate'),
                    "futureDate"=> $request->input('nextpaymentdate'),
                    "SalesPerson"=> $request->input('saleperson'),
                    "TotalAmount"=> $request->input('totalamount'),
                    "Paid"=> $request->input('clientpaid'),
                    "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType"=> $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description"=> $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus"=> 'On Going',
                    "remainingStatus"=> $remainingstatus,
                    "transactionType" => $transactionType

                ]);

            }elseif( $request->input('ChargingPlan') != null && $request->input('nextpaymentdate') == null){

                $today = date('Y-m-d');
                if ($request->input('ChargingPlan') == "One Time Payment") {
                    $date = null ;
                } elseif ($request->input('ChargingPlan') == "Monthly") {
                    $date = date('Y-m-d', strtotime('+1 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "2 Months") {
                    $date = date('Y-m-d', strtotime('+2 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "3 Months") {
                    $date = date('Y-m-d', strtotime('+3 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "4 Months") {
                    $date = date('Y-m-d', strtotime('+4 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "5 Months") {
                    $date = date('Y-m-d', strtotime('+5 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "6 Months") {
                    $date = date('Y-m-d', strtotime('+6 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "7 Months") {
                    $date = date('Y-m-d', strtotime('+7 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "8 Months") {
                    $date = date('Y-m-d', strtotime('+8 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "9 Months") {
                    $date = date('Y-m-d', strtotime('+9 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "10 Months") {
                    $date = date('Y-m-d', strtotime('+10 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "11 Months") {
                    $date = date('Y-m-d', strtotime('+11 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "12 Months") {
                    $date = date('Y-m-d', strtotime('+1 Year', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "2 Years") {
                    $date = date('Y-m-d', strtotime('+2 Year', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "3 Years") {
                    $date = date('Y-m-d', strtotime('+3 Year', strtotime($today)));
                }


                $createpayment = NewPaymentsClients::where('id',$id)->update([
                    "BrandID" => $brandID,
                    "ClientID"=> $request->input('clientID'),
                    "ProjectID"=> $request->input('project'),
                    "ProjectManager"=> $request->input('accountmanager'),
                    "paymentNature"=> $request->input('paymentNature'),
                    "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform"=> $request->input('platform'),
                    "Card_Brand"=> $request->input('cardBrand'),
                    "Payment_Gateway"=> $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID"=> $request->input('transactionID'),
                    "paymentDate"=> $request->input('paymentdate'),
                    "futureDate"=> $date,
                    "SalesPerson"=> $request->input('saleperson'),
                    "TotalAmount"=> $request->input('totalamount'),
                    "Paid"=> $request->input('clientpaid'),
                    "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType"=> $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description"=> $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus"=> 'On Going',
                    "remainingStatus"=> $remainingstatus,
                    "transactionType" => $transactionType

                ]);

            }else{

                $createpayment = NewPaymentsClients::where('id',$id)->update([
                    "BrandID" => $brandID,
                    "ClientID"=> $request->input('clientID'),
                    "ProjectID"=> $request->input('project'),
                    "ProjectManager"=> $request->input('accountmanager'),
                    "paymentNature"=> $request->input('paymentNature'),
                    "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform"=> $request->input('platform'),
                    "Card_Brand"=> $request->input('cardBrand'),
                    "Payment_Gateway"=> $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID"=> $request->input('transactionID'),
                    "paymentDate"=> $request->input('paymentdate'),
                    "futureDate"=> $request->input('nextpaymentdate'),
                    "SalesPerson"=> $request->input('saleperson'),
                    "TotalAmount"=> $request->input('totalamount'),
                    "Paid"=> $request->input('clientpaid'),
                    "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType"=> $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(["-", "-", "-", "-"]) : json_encode($request->input('splitamount')),
                    "Description"=> $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus"=> 'On Going',
                    "remainingStatus"=> $remainingstatus,
                    "transactionType" => $transactionType

                ]);

            }

            if( $request->input('nextpaymentdate') == null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment"){

                if( $request->input('paymentModes') == 'Renewal' ){
                    $paymentNature = "Renewal Payment";
                }else{
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
                    }
                    elseif ($interval == "4 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                    }elseif ($interval == "5 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                    }elseif ($interval == "6 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                    }elseif ($interval == "7 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                    }elseif ($interval == "8 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                    }elseif ($interval == "9 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                    }elseif ($interval == "10 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                    }elseif ($interval == "11 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                    }elseif ($interval == "12 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                    }elseif ($interval == "2 Years") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                    } elseif ($interval == "3 Years") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                    }
                    // echo $datefinal . "<br>";



                    $futurePayment = NewPaymentsClients::create([
                        "BrandID" => $brandID,
                        "ClientID"=> $request->input('clientID'),
                        "ProjectID"=> $request->input('project'),
                        "ProjectManager"=> $request->input('accountmanager'),
                        "paymentNature"=>  $paymentNature,
                        "ChargingPlan"=> '--',
                        "ChargingMode"=> '--',
                        "Platform"=> '--',
                        "Card_Brand"=> '--',
                        "Payment_Gateway"=> '--',
                        "bankWireUpload" => '--',
                        "TransactionID"=> '--',
                        // "paymentDate"=> $request->input('paymentdate'),
                        "futureDate"=> $datefinal,
                        "SalesPerson"=> $request->input('saleperson'),
                        "TotalAmount"=> $request->input('totalamount'),
                        "Paid"=> 0,
                        "RemainingAmount" => 0,
                        "PaymentType"=> '--',
                        "numberOfSplits" => '--',
                        "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                        "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                        "Description"=> '--',
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus"=> 'Pending Payment',
                        "remainingStatus"=> '--',
                        "transactionType" => $transactionType

                    ]);
                }

            }elseif( $request->input('nextpaymentdate') != null && $request->input('ChargingPlan') != null && $request->input('ChargingPlan') != "One Time Payment" && $request->input('paymentModes') != "One Time Payment"){

                if( $request->input('paymentModes') == 'Renewal' ){
                    $paymentNature = "Renewal Payment";
                }else{
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
                    }
                    elseif ($interval == "4 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 4 . ' month', strtotime($today)));
                    }elseif ($interval == "5 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 5 . ' month', strtotime($today)));
                    }elseif ($interval == "6 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 6 . ' month', strtotime($today)));
                    }elseif ($interval == "7 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 7 . ' month', strtotime($today)));
                    }elseif ($interval == "8 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 8 . ' month', strtotime($today)));
                    }elseif ($interval == "9 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 9 . ' month', strtotime($today)));
                    }elseif ($interval == "10 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 10 . ' month', strtotime($today)));
                    }elseif ($interval == "11 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 11 . ' month', strtotime($today)));
                    }elseif ($interval == "12 Months") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 12 . ' month', strtotime($today)));
                    }elseif ($interval == "2 Years") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 2 . ' Year', strtotime($today)));
                    } elseif ($interval == "3 Years") {
                        $datefinal = date('Y-m-d', strtotime('+' . ($i + 1) * 3 . ' Year', strtotime($today)));
                    }
                    // echo $datefinal . "<br>";



                    $futurePayment = NewPaymentsClients::create([
                        "BrandID" => $brandID,
                        "ClientID"=> $request->input('clientID'),
                        "ProjectID"=> $request->input('project'),
                        "ProjectManager"=> $request->input('accountmanager'),
                        "paymentNature"=>  $paymentNature,
                        "ChargingPlan"=> '--',
                        "ChargingMode"=> '--',
                        "Platform"=> '--',
                        "Card_Brand"=> '--',
                        "Payment_Gateway"=> '--',
                        "bankWireUpload" => '--',
                        "TransactionID"=> '--',
                        // "paymentDate"=> $request->input('paymentdate'),
                        "futureDate"=> $datefinal,
                        "SalesPerson"=> $request->input('saleperson'),
                        "TotalAmount"=> $request->input('totalamount'),
                        "Paid"=> 0,
                        "RemainingAmount" => 0,
                        "PaymentType"=> '--',
                        "numberOfSplits" => '--',
                        "SplitProjectManager" => json_encode(["-", "-", "-", "-"]),
                        "ShareAmount" => json_encode(["-", "-", "-", "-"]),
                        "Description"=> '--',
                        'created_at' => date('y-m-d H:m:s'),
                        'updated_at' => date('y-m-d H:m:s'),
                        "refundStatus"=> 'Pending Payment',
                        "remainingStatus"=> '--',
                        "transactionType" => $transactionType

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
                    "paymentDescription" => $paymentDescription ,
                    "amount" => $amount
                ]);



            foreach ($sharedProjectManager as $key => $value) {
                $c[$key] = [$value, $amountShare[$key]];
            }

            foreach($c as $SecondProjectManagers){
                if($SecondProjectManagers[0] != 0){
                    $createSharedPersonEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $id,
                            "employeeID" => $SecondProjectManagers[0],
                            "paymentDescription" => "Amount Share By " . $request->input('saleperson'),
                            "amount" =>  $SecondProjectManagers[1]
                        ]);
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


        // return redirect('/forms/payment/' . $request->input('project'));
         return redirect('/client/details/' . $request->input('clientID'));
    }



    // function payment_Refund_Dispute(Request $request, $id){
    //     $loginUser = $this->roleExits($request);
    //     $client_payment = NewPaymentsClients::where('id', $id)->get();
    //     $employee_payment = Employeepayment::where('paymentID', $id)->get();
    //     return view('payment_Refund_Dispute', [
    //         'client_payment' => $client_payment,
    //         'employee_payment' => $employee_payment,
    //         'LoginUser' => $loginUser[1],
    //         'departmentAccess' => $loginUser[0],
    //         'superUser' => $loginUser[2]
    //     ]);

    // }

    // function payment_Refund_Dispute_Process(Request $request, $id){
    //     $addrefunds = NewPaymentsClients::where('id', $id)->get();
    //     $referencepayment = NewPaymentsClients::where('id', $request->input('paymentreference'))->get();
    //     $remainingamt = $request->input('totalamount') - $request->input('clientpaid');

    //     if($remainingamt == 0){
    //         $remainingstatus = "Not Remaining";
    //     }else{
    //         $remainingstatus = "Remaining";
    //     }

    //     $addrefundpayment = NewPaymentsClients::where('id',$id)
    //                         ->update([
    //                             "ProjectID"=> $referencepayment[0]->paymentNature,
    //                             "ProjectManager"=> $request->input('accountmanager'),
    //                             "paymentNature"=> $referencepayment[0]->paymentNature,
    //                             "ChargingPlan"=>  $referencepayment[0]->ChargingPlan,
    //                             "ChargingMode"=>  $referencepayment[0]->ChargingMode,
    //                             "Platform"=> $request->input('platform'),
    //                             "Card_Brand"=> $request->input('cardBrand'),
    //                             "Payment_Gateway"=> $request->input('paymentgateway'),
    //                             "bankWireUpload" => '--',
    //                             "TransactionID"=> $request->input('transactionID'),
    //                             "paymentDate"=> $request->input('paymentdate'),
    //                             "SalesPerson"=> $request->input('saleperson'),
    //                             "TotalAmount"=> $request->input('totalamount'),
    //                             "Paid"=> $request->input('clientpaid'),
    //                             "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
    //                             "PaymentType"=>  $referencepayment[0]->PaymentType,
    //                             "numberOfSplits" => $referencepayment[0]->numberOfSplits,
    //                             "SplitProjectManager" =>  $referencepayment[0]->SplitProjectManager,
    //                             "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode([null, null, null, null]) : json_encode($request->input('splitamount')),
    //                             "Description"=> $request->input('description'),
    //                             'updated_at' => date('y-m-d H:m:s'),
    //                             'refundStatus' => $request->input('chargebacktype'),
    //                             'refundID' => $request->input('refundID'),
    //                             "remainingStatus"=> $remainingstatus,
    //                             "transactionType" => $referencepayment[0]->transactionType,
    //                         ]);

    //     $addrefundInrefundTable = RefundPayments::create([
    //                             "BrandID" => $referencepayment[0]->BrandID,
    //                             "ClientID" => $referencepayment[0]->ClientID,
    //                             "ProjectID"=> $referencepayment[0]->ProjectID,
    //                             "ProjectManager" =>$request->input('accountmanager'),
    //                             "PaymentID" => $id,
    //                             "refundAmount" => $request->input('chagebackAmt'),
    //                             "refundtype" => $request->input('chargebacktype'),
    //                             "refund_date" => $request->input('chagebackDate'),
    //                             "refundReason" => $request->input('Description_of_issue'),

    //                         ]);


    //     if(($addrefunds[0]->paymentNature == "New Lead" || $addrefunds[0]->paymentNature == "New Sale" || $addrefunds[0]->paymentNature == "Upsell") && $addrefunds[0]->ChargingPlan != "One Time Payment"){

    //                             $addrefund = NewPaymentsClients::where('ClientID', $referencepayment[0]->id )
    //                                         ->where('ProjectID', $referencepayment[0]->ProjectID )
    //                                         ->where('transactionType', $referencepayment[0]->transactionType)
    //                                         ->where('refundStatus', "Pending Payment")
    //                                         ->delete();
    //     }

    //     return redirect('/client/project/payment/all');

    // }



    function payment_remaining_amount(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $mainPayment = NewPaymentsClients::where('id', $id)->get();

        $findproject = Project::where('id', $mainPayment[0]->ProjectID)->get();
        $findclient = Client::get();
        $findemployee = Employee::get();
        $allPayments = NewPaymentsClients::where('ClientID', $findproject[0]->ClientName->id)
                                ->where('refundStatus','!=','Pending Payment')
                                ->where('remainingStatus','!=','Unlinked Payments')
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
            'superUser' => $loginUser[2]]);
    }
    function payment_remaining_amount_process(Request $request, $id){

        $changeStatus = NewPaymentsClients::where('id',$id)->update([
            "remainingID"  => $request->input('remainingID'),
            "remainingStatus"  => "Received Remaining"
        ]);

        $paymentType = $request->input('paymentType');
        $paymentNature = $request->input('paymentNature');
        $findusername = DB::table('employees')->where('id', $request->input('saleperson'))->get();
        $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
        $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
        if($remainingamt == 0){
            $remainingstatus = "Received Remaining";
        }else{
            $remainingstatus = "Remaining";
        }

        if($request->file('bankWireUpload') != null ){
            $bookwire = $request->file('bankWireUpload')->store('Payment');
        }else{
            $bookwire ="--";
        }

        $transactionType = $request->input('paymentNature');


            // if( $request->input('nextpaymentdate') != null ){

                $createpayment = NewPaymentsClients::insertGetId([
                    "BrandID" => $request->input('brandID'),
                    "ClientID"=> $request->input('clientID'),
                    "ProjectID"=> $request->input('project'),
                    "ProjectManager"=> $request->input('accountmanager'),
                    "paymentNature"=> $request->input('paymentNature'),
                    "ChargingPlan"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('ChargingPlan') : '--',
                    "ChargingMode"=> ($request->input('paymentNature') == "New Lead" || $request->input('paymentNature') == "New Sale" || $request->input('paymentNature') == "Upsell") ? $request->input('paymentModes') : '--',
                    "Platform"=> $request->input('platform'),
                    "Card_Brand"=> $request->input('cardBrand'),
                    "Payment_Gateway"=> $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID"=> $request->input('transactionID'),
                    "paymentDate"=> $request->input('paymentdate'),
                    // "futureDate"=> $request->input('nextpaymentdate'),
                    "SalesPerson"=> $request->input('saleperson'),
                    "TotalAmount"=> $request->input('totalamount'),
                    "Paid"=> $request->input('clientpaid'),
                    "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType"=> $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(['--']) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(['--']) : json_encode($request->input('splitamount')),
                    "Description"=> $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus"=> 'On Going',
                    "remainingID" => $request->input('remainingID'),
                    "remainingStatus"=> $remainingstatus,
                    "transactionType" => $transactionType

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
                    "paymentDescription" => $paymentDescription ,
                    "amount" => $amount
                ]);



            foreach ($sharedProjectManager as $key => $value) {
                $c[$key] = [$value, $amountShare[$key]];
            }

            foreach($c as $SecondProjectManagers){
                if($SecondProjectManagers[0] != 0){
                    $createSharedPersonEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $createpayment,
                            "employeeID" => $SecondProjectManagers[0],
                            "paymentDescription" => "Remaining(Payment) Amount Share By " . $findusername[0]->name,
                            "amount" =>  $SecondProjectManagers[1]
                        ]);
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



    function payment_pending_amount(Request $request, $id){

        $loginUser = $this->roleExits($request);
        $mainPayment = NewPaymentsClients::where('id', $id)->get();
        $stripePayment = NewPaymentsClients::where('ClientID', $mainPayment[0]->ClientID)->where('remainingStatus',"Unlinked Payments")->get();

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
            'superUser' => $loginUser[2]]);

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

        $return_array = [
            "cardbrand" => $cardbrand,
            "paymentgateway" => $paymentgateway,
            "transactionID" => $transactionID,
            "paymentdate" => $paymentdate,
            "clientpaid" => $clientpaid,
            "description" => $description
        ];

        $deleteexistingStripeUnlinked = NewPaymentsClients::where("TransactionID", $transactionID)->delete();

        return response()->json($return_array);
    }
    function payment_pending_amount_process(Request $request, $id){
        $paymentType = $request->input('paymentType');
        $paymentNature = $request->input('paymentNature');
        $findusername = DB::table('employees')->where('id', $request->input('accountmanager'))->get();
        $findclient = DB::table('clients')->where('id', $request->input('clientID'))->get();
        $remainingamt = $request->input('totalamount') - $request->input('clientpaid');
        if($remainingamt == 0){
            $remainingstatus = "Not Remaining";
        }else{
            $remainingstatus = "Remaining";
        }

        if($request->file('bankWireUpload') != null ){
            $bookwire = $request->file('bankWireUpload')->store('Payment');
        }else{
            $bookwire ="--";
        }

        $transactionType = $request->input('paymentNature');


            if( $request->input('nextpaymentdate') != null ){

                $today = date('Y-m-d');
                if ($request->input('ChargingPlan') == "One Time Payment") {
                    $date = null ;
                } elseif ($request->input('ChargingPlan') == "Monthly") {
                    $date = date('Y-m-d', strtotime('+1 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "2 Months") {
                    $date = date('Y-m-d', strtotime('+2 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "3 Months") {
                    $date = date('Y-m-d', strtotime('+3 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "4 Months") {
                    $date = date('Y-m-d', strtotime('+4 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "5 Months") {
                    $date = date('Y-m-d', strtotime('+5 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "6 Months") {
                    $date = date('Y-m-d', strtotime('+6 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "7 Months") {
                    $date = date('Y-m-d', strtotime('+7 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "8 Months") {
                    $date = date('Y-m-d', strtotime('+8 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "9 Months") {
                    $date = date('Y-m-d', strtotime('+9 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "10 Months") {
                    $date = date('Y-m-d', strtotime('+10 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "11 Months") {
                    $date = date('Y-m-d', strtotime('+11 month', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "12 Months") {
                    $date = date('Y-m-d', strtotime('+1 Year', strtotime($today)));
                }elseif ($request->input('ChargingPlan') == "2 Years") {
                    $date = date('Y-m-d', strtotime('+2 Year', strtotime($today)));
                } elseif ($request->input('ChargingPlan') == "3 Years") {
                    $date = date('Y-m-d', strtotime('+3 Year', strtotime($today)));
                }

                $createpayment = NewPaymentsClients::iwhere('id',$id)->update([
                    "ProjectManager"=> $request->input('accountmanager'),
                     "Platform"=> $request->input('platform'),
                    "Card_Brand"=> $request->input('cardBrand'),
                    "Payment_Gateway"=> $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID"=> $request->input('transactionID'),
                    "paymentDate"=> $request->input('paymentdate'),
                    "futureDate"=> $request->input('nextpaymentdate'),
                    "SalesPerson"=> $request->input('saleperson'),
                    "TotalAmount"=> $request->input('totalamount'),
                    "Paid"=> $request->input('clientpaid'),
                    "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType"=> $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(['--']) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(['--']) : json_encode($request->input('splitamount')),
                    "Description"=> $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus"=> 'On Going',
                    "remainingStatus"=> $remainingstatus,
                    // "transactionType" => $transactionType

                ]);

            }else{

                $createpayment = NewPaymentsClients::where('id',$id)->update([
                    "ProjectManager"=> $request->input('accountmanager'),
                    "Platform"=> $request->input('platform'),
                    "Card_Brand"=> $request->input('cardBrand'),
                    "Payment_Gateway"=> $request->input('paymentgateway'),
                    "bankWireUpload" => ($request->input('paymentgateway') == "Stripe") ? '--' : $bookwire,
                    "TransactionID"=> $request->input('transactionID'),
                    "paymentDate"=> $request->input('paymentdate'),
                    "SalesPerson"=> $request->input('saleperson'),
                    "TotalAmount"=> $request->input('totalamount'),
                    "Paid"=> $request->input('clientpaid'),
                    "RemainingAmount" =>$request->input('totalamount') - $request->input('clientpaid'),
                    "PaymentType"=> $request->input('paymentType'),
                    "numberOfSplits" => ($request->input('paymentType') == "Full Payment") ? '--' : $request->input('numOfSplit'),
                    "SplitProjectManager" => ($request->input('paymentType') == "Full Payment") ? json_encode(['--']) : json_encode($request->input('shareProjectManager')),
                    "ShareAmount" => ($request->input('paymentType') == "Full Payment") ? json_encode(['--']) : json_encode($request->input('splitamount')),
                    "Description"=> $request->input('description'),
                    'created_at' => date('y-m-d H:m:s'),
                    'updated_at' => date('y-m-d H:m:s'),
                    "refundStatus"=> 'On Going',
                    "remainingStatus"=> $remainingstatus,
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
                    "paymentDescription" => $paymentDescription ,
                    "amount" => $amount
                ]);



            foreach ($sharedProjectManager as $key => $value) {
                $c[$key] = [$value, $amountShare[$key]];
            }

            foreach($c as $SecondProjectManagers){
                if($SecondProjectManagers[0] != 0){
                    $createSharedPersonEmployeePayment  = EmployeePayment::create(
                        [
                            "paymentID" => $id,
                            "employeeID" => $SecondProjectManagers[0],
                            "paymentDescription" => "Amount Share By " . $findusername[0]->name,
                            "amount" =>  $SecondProjectManagers[1]
                        ]);
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



    function delete_payment(Request $request, $id){

        $getpayment = DB::table('newpaymentsclients')->where('id', $id)->get();
        // echo("<pre>");
        // print_r($getpayment[0]->paymentNature);
        // die();

        if($getpayment[0]->paymentNature == "New Lead" || $getpayment[0]->paymentNature == "New Sale" || $getpayment[0]->paymentNature == "Upsell"){

            $getRefundpayment = DB::table('refundtable')->where('PaymentID', $getpayment[0]->id)->delete();
            $getemployeepayment = DB::table('employeepayment')->where('paymentID', $getpayment[0]->id)->delete();
            $pendingpayments = DB::table('newpaymentsclients')->where('ClientID', $getpayment[0]->ClientID )->where('ProjectID', $getpayment[0]->ProjectID )->where('transactionType',  $getpayment[0]->transactionType)->where('refundStatus', 'Pending Payment')->delete();

            if($getpayment[0]->remainingID != null){
                $getpayments = DB::table('newpaymentsclients')->where('id', $id)->delete();
                $getpayments2 = DB::table('newpaymentsclients')->where('remainingID',$getpayment[0]->remainingID)->delete();

            }else{
                $getpayments = DB::table('newpaymentsclients')->where('id', $id)->delete();

            }


        }elseif($getpayment[0]->paymentNature == "Remaining"){

            $getRefundpayment = DB::table('refundtable')->where('PaymentID', $getpayment[0]->id)->delete();
            $getemployeepayment = DB::table('employeepayment')->where('paymentID', $getpayment[0]->id)->delete();

            $getpayments = DB::table('newpaymentsclients')->where('id', $id)->delete();

            $client_payment = NewPaymentsClients::where('remainingID',$getpayment[0]->remainingID)->update([
                    'remainingStatus' => "Remaining"
            ]);

        }else{

            $getRefundpayment = DB::table('refundtable')->where('PaymentID', $getpayment[0]->id)->delete();
            $getemployeepayment = DB::table('employeepayment')->where('paymentID', $getpayment[0]->id)->delete();

            $getpayments = DB::table('newpaymentsclients')->where('id', $id)->delete();

        }

        return redirect()->back();
    }



    function all_payments(Request $request){

        $loginUser = $this->roleExits($request);
        $client_payment = NewPaymentsClients::where('refundStatus','!=','Pending Payment')->get();

        return view('allpayments', [
            'clientPayments' => $client_payment,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);

    }
    function payment_view(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $client_payment = NewPaymentsClients::where('id', $id)->get();
        return view('payment_view', [
            'client_payment' => $client_payment,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);

    }
    function payment_view1(Request $request, $id){
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


        return view('userreport', ['company' => $companies, 'brand' => $brands, 'department' => $departments, 'employee' => $employees, 'client' => $clients, 'project' => $projects, 'LoginUser' => $loginUser[1], 'departmentAccess' => $loginUser[0], 'superUser' => $loginUser[2]]);
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

    function filledqaformIndv(Request $request){
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
        return view('qa_form_view_without_backButton', ['qa_data' => $QA_FORM, 'qa_meta' => $QA_META, 'Proj_Prod' => $Proj_Prod, 'LoginUser' => $loginUser[1], 'departmentAccess' => $loginUser[0], 'superUser' => $loginUser[2]]);
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

                $qaform = QAFORM::where('qaformID',$request->input('qaformID'))->count();
                $qaform_meta = QAFORM_METAS::where('formid',$request->input('qaformID'))->count();

                if($qaform > 0 && $qaform_meta >0 ){
                    return redirect()->back()->with('Success', "ADDED !");

                }else{
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

                $qaform = QAFORM::where('qaformID',$request->input('qaformID'))->count();
                $qaform_meta = QAFORM_METAS::where('formid',$request->input('qaformID'))->count();

                if($qaform > 0 && $qaform_meta >0 ){
                    return redirect()->back()->with('Success', "ADDED !");

                }elseif($qaform > 0 && $qaform_meta == null){
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
            'superUser' => $loginUser[2]]);
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

    // function qaform_direct_process(Request $request)
    // {
    //     $project = Project::where('id', $request->input('projectname'))->get();
    //     $qaPerson = $request->session()->get('AdminUser');
    //     QAFORM::create([
    //         'clientID' => $project[0]->ClientName->id,
    //         'projectID' => $request->input('projectname'),
    //         'projectmanagerID' => $project[0]->EmployeeName->id,
    //         'brandID' => $project[0]->ClientName->projectbrand->id,
    //         "qaformID" => $request->input('qaformID'),
    //         "status" => $request->input('status'),
    //         "last_communication" =>   $request->input('last_communication_with_client'),
    //         "medium_of_communication" => json_encode($request->input('Medium_of_communication')),
    //         "qaPerson" => $qaPerson[0]->id,
    //     ]);

    //     return redirect('/forms/qaform/qa_meta/' . $request->input('qaformID'));
    // }

    // function qaform_prefilled(Request $request, $id)
    // {
    //     $loginUser = $this->roleExits($request);
    //     $project = Project::where('id', $id)->get();
    //     $production = ProjectProduction::where('projectID', $project[0]->productionID)->get();
    //     $brand = Brand::get();
    //     $department = Department::get();
    //     $employee = Employee::get();
    //     $qa_issues = QaIssues::get();

    //     return view('combined_qaform', ['brands' => $brand, 'departments' => $department, 'projects' => $project, 'employees' => $employee, 'productions' => $production, 'qaissues' => $qa_issues, 'LoginUser' => $loginUser[1], 'departmentAccess' => $loginUser[0], 'superUser' => $loginUser[2]]);
    // }



    function new_qaform_delete(Request $request, $id)
    {
        $deleteqaform1 = DB::table('qaform')->where('id', $id)->get();
        $deleteqaformMetas = DB::table('qaform_metas')->where('formid', $deleteqaform1[0]->qaformID)->limit(1)->delete();
        $deleteqaform = DB::table('qaform')->where('id', $id)->delete();


        return redirect('/client/project/qareport/'.$deleteqaform1[0]->projectID);

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
            'superUser' => $loginUser[2]]);
    }

    function projectQaReport_view($id, Request $request)
    {
        $loginUser = $this->roleExits($request);
        $QA_FORM = QAFORM::where('id', $id)->get();
        $QA_META = QAFORM_METAS::where('formid', $QA_FORM[0]->qaformID)->get();
        $Proj_Prod = ProjectProduction::where('id', $QA_FORM[0]->ProjectProductionID)->get();
        return view('qa_form_view', ['qa_data' => $QA_FORM, 'qa_meta' => $QA_META, 'Proj_Prod' => $Proj_Prod, 'LoginUser' => $loginUser[1], 'departmentAccess' => $loginUser[0], 'superUser' => $loginUser[2]]);
    }

    function qa_issues(Request $request)
    {
        $loginUser = $this->roleExits($request);
        $department = Department::get();
        $qa_issues = QaIssues::get();
        return view('qa_issues', ['departments' => $department, "qa_issues" => $qa_issues, 'LoginUser' => $loginUser[1], 'departmentAccess' => $loginUser[0], 'superUser' => $loginUser[2]]);
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
        $clients = Client::whereNotIn('id', $assignedclients)->get();

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
            ? $qaform->select('qaform.id as mainID','qaform.*','qaform_metas.*')
            : $qaform->select('qaform.id as mainID','qaform.*');

            $result = $qaform->get();



            if($get_brand != 0){
                $getbrands = Brand::where('id',$get_brand)->get();
                $get_brands = $getbrands[0]->name;
            }else{
                $get_brands = "--";
            }

            if($get_projectmanager != 0){
                $getprojectmanagers = Employee::where('id',$get_projectmanager)->get();
                $get_projectmanagers = $getprojectmanagers[0]->name;
            }else{
                $get_projectmanagers = "--";
            }

            if($get_client != 0){
                $getclients = Client::where('id',$get_client)->get();
                $get_clients = $getclients[0]->name;
            }else{
                $get_clients = "--";
            }

            if($get_Production != 0){
                $getProductions = Department::where('id',$get_Production)->get();
                $get_Productions = $getProductions[0]->name;
            }else{
                $get_Productions = "--";
            }

            if($get_status != 0){
                $get_statuss = $get_status;
            }else{
                $get_statuss = "--";
            }

            if($get_remarks != 0){
                $get_remarkss = $get_remarks;
            }else{
                $get_remarkss = "--";
            }

            if($get_expectedRefund != 0){
                $get_expectedRefunds = $get_expectedRefund;
            }else{
                $get_expectedRefunds = "--";
            }

            if($get_issues != 0){
                $get_issuess = $get_issues;
            }else{
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
            'gets_brand' =>$get_brands,
            'gets_projectmanager' =>$get_projectmanagers,
            'gets_client' =>$get_clients,
            'gets_Production' =>$get_Productions,
            'gets_status' =>$get_statuss,
            'gets_remarks' =>$get_remarkss,
            'gets_expectedRefund' =>$get_expectedRefunds,
            'gets_issues' =>$get_issuess,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);
    }

    function revenuereport(Request $request, $id = null){
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
         if($request->input('status') == 'Dispute'){
            $get_dispute = $request->input('status');
            $get_status = 0;
         }else{
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
            if($get_type == "Received"){
                $payment = NewPaymentsClients::whereBetween('created_at', [$get_startdate, $get_enddate])->where('refundStatus','!=','Pending Payment')->where('remainingStatus','!=','Unlinked Payments');
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

            }elseif($get_type == "Upcoming"){

                $payment = NewPaymentsClients::whereBetween('futureDate', [$get_startdate, $get_enddate])->where('paymentDate',null);
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

            }else{
                $result = 0;
            }


            if($get_type != 0){
                $get_types = $get_type;
            }else{
                $get_types = "--";
            }

            if($get_brand != 0){
                $getbrands = Brand::where('id',$get_brand)->get();
                $get_brands = $getbrands[0]->name;
            }else{
                $get_brands = "--";
            }

            if($get_chargingMode != 0){
                $get_chargingModes = $get_chargingMode;
            }else{
                $get_chargingModes = "--";
            }

            if($get_paymentNature != 0){
                $get_paymentNatures = $get_paymentNature;
            }else{
                $get_paymentNatures = "--";
            }

            if($get_projectmanager != 0){
                $getprojectmanagers = Employee::where('id',$get_projectmanager)->get();
                $get_projectmanagers = $getprojectmanagers[0]->name;
            }else{
                $get_projectmanagers = "--";
            }

            if($get_client != 0){
                $getclients = Client::where('id',$get_client)->get();
                $get_clients = $getclients[0]->name;
            }else{
                $get_clients = "--";
            }

            if($get_status != 0 || $get_dispute != 0){
                if($get_status != 0){
                    $get_statuss = $get_status;
                }else{
                    $get_statuss = "Dispute";
                }
            }else{
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
            'get_types' =>$get_types,
            'gets_brand' =>$get_brands,
            'gets_projectmanager' =>$get_projectmanagers,
            'gets_client' =>$get_clients,
            'gets_status' =>$get_statuss,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);

    }

    function clientReport(Request $request, $id)
    {
        $loginUser = $this->roleExits($request);
        $client = Client::where('id',$id)->get();
        $project = Project::where('clientID',$id)->get();
        $projectcount = count($project);
        $qaform = QAFORM::where('clientID',$id)->get();
        $qaformcount = count($qaform);
        $qaformlast = QAFORM::where('clientID',$id)->whereMonth('created_at', now())->latest('created_at')->get();
        $clientpayments = NewPaymentsClients::where('ClientID',$id)->get();
        $clientpaymentscount = count($clientpayments);

        return view('clientReport',[
            'clients'=> $client,
            'projects'=> $project,
            'qaforms'=> $qaform,
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

    public function fetchRecord(Request $request){
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );
        $chargeID = $request['ID'];
        try{
            $details = $stripe->charges->retrieve($chargeID, []);
            $return_array = [
                "status" => 200,
                "message" => $details,
            ];
            http_response_code(200);
            $return_str = json_encode($return_array);
            return $return_str;
        }
        catch(\Stripe\Exception\ApiErrorException $e) {
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

    function new_payments(Request $request){

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

        return view('newpayments_formStripe',[
            'allprojects'=> $allprojects,
            'details'=> $unlinkedpayments,
            'allpayments'=> $unlinkedpayments,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]
        ]);


    }

    function new_payments_process(Request $request){
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
            'superUser' => $loginUser[2]]);
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

    public function ajax_username(Request $request){
        $data['projectdata'] = Employee::where("id", $request->state_id)
                                    ->get();
        $projectmanagername = $data['projectdata'][0]->name;

        $return_array = [
            "pmname" => $projectmanagername,
        ];

        return response()->json($return_array);

    }

    function csv_stripepayments(Request $request){
        $loginUser = $this->roleExits($request);
        return view('paymentUpload',[
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
            foreach ($extractData as $sepratedtoarray) {
                $checktransactionID = NewPaymentsClients::where('TransactionID',$sepratedtoarray[0])->count();
                if($checktransactionID == 0){
                    if($sepratedtoarray != $extractData[0]){
                        if($sepratedtoarray[16] == 'Paid'){
                            if( $sepratedtoarray[53] == null ){
                                $matchclientmeta = Clientmeta::wherejsoncontains('otheremail',($sepratedtoarray[40]))->get();
                                if ($matchclientmeta->isNotEmpty()){
                                    $findclient = Client::where('email',$matchclientmeta[0]->clientID)->get();
                                    $count = count($findclient);
                                    if( $count == 1){
                                        $createClientPayment = NewPaymentsClients::create([
                                            "BrandID" => $findclient[0]->brand,
                                            "ClientID"=> $findclient[0]->id,
                                            "ProjectID"=> 0,
                                            "ProjectManager"=> 0,
                                            "paymentNature"=> "--",
                                            "ChargingPlan"=> "--",
                                            "ChargingMode"=> "--",
                                            "Platform"=> "--",
                                            "Card_Brand"=> $sepratedtoarray[29],
                                            "Payment_Gateway"=> "Stripe",
                                            "bankWireUpload" =>  "--",
                                            "TransactionID"=>$sepratedtoarray[0],
                                            "paymentDate"=>$sepratedtoarray[1],
                                            "SalesPerson"=> 0,
                                            "TotalAmount"=> 0,
                                            "Paid"=> $sepratedtoarray[6],
                                            "RemainingAmount" =>0,
                                            "PaymentType"=> "--",
                                            "numberOfSplits" => "--",
                                            "SplitProjectManager" => json_encode("--"),
                                            "ShareAmount" => json_encode("--"),
                                            "Description"=> $sepratedtoarray[9],
                                            'created_at' => date('y-m-d H:m:s'),
                                            'updated_at' => date('y-m-d H:m:s'),
                                            "refundStatus"=> 'On Going',
                                            "remainingStatus"=> "Unlinked Payments",
                                            "transactionType" => "--"

                                        ]);
                                    }else{
                                        $checkinUnmatched = UnmatchedPayments::where('TransactionID',$sepratedtoarray[0])->count();
                                        if($checkinUnmatched > 0){
                                            continue;
                                        }else{
                                            // $stripepaymentsall[]=[$sepratedtoarray];
                                            $createClientUnmatchedPayment = UnmatchedPayments::create([
                                                "TransactionID" => $sepratedtoarray[0],
                                                "Clientemail"=> $sepratedtoarray[40],
                                                "paymentDate"=> $sepratedtoarray[1],
                                                "Paid"=> $sepratedtoarray[6],
                                                "Description"=> $sepratedtoarray[9],
                                                "cardBrand"=> $sepratedtoarray[29],
                                                "stripePaymentstatus"=> $sepratedtoarray[16],
                                                'created_at' => date('y-m-d H:m:s'),
                                                'updated_at' => date('y-m-d H:m:s'),

                                            ]);

                                        }
                                    }

                                }else{
                                    // continue;
                                    $checkinUnmatched = UnmatchedPayments::where('TransactionID',$sepratedtoarray[0])->count();
                                    if($checkinUnmatched > 0){
                                        continue;
                                    }else{
                                        // $stripepaymentsall[]=[$sepratedtoarray];
                                        $createClientUnmatchedPayment = UnmatchedPayments::create([
                                            "TransactionID" => $sepratedtoarray[0],
                                            "Clientemail"=> $sepratedtoarray[40],
                                            "paymentDate"=> $sepratedtoarray[1],
                                            "Paid"=> $sepratedtoarray[6],
                                            "Description"=> $sepratedtoarray[9],
                                            "cardBrand"=> $sepratedtoarray[29],
                                            "stripePaymentstatus"=> $sepratedtoarray[16],
                                            'created_at' => date('y-m-d H:m:s'),
                                            'updated_at' => date('y-m-d H:m:s'),

                                        ]);

                                    }
                                }

                            }else{
                                $matchclientmeta = Clientmeta::wherejsoncontains('otheremail',($sepratedtoarray[40]))->get();
                                if ($matchclientmeta->isNotEmpty()){
                                    $findclient = Client::where('email',$matchclientmeta[0]->clientID)->get();
                                    $count = count($findclient);
                                    if( $count == 1){

                                        $checkstatus = NewPaymentsClients::where('TransactionID',$sepratedtoarray[0])->get();
                                        $checkcount = count($checkstatus);
                                        if($checkcount == 1){
                                            if($checkstatus[0]->dispute == null){
                                                continue;
                                            }else{
                                                $createClientPayment = NewPaymentsClients::where('TransactionID',$sepratedtoarray[0])->update([
                                                    "dispute" => "dispute"
                                                ]);
                                                $disputePayment = NewPaymentsClients::where('TransactionID',$sepratedtoarray[0])->get();

                                                $payment_in_dispute_table = Disputedpayments::create([
                                                    "BrandID" => $disputePayment[0]->BrandID,
                                                    "ClientID" => $disputePayment[0]->ClientID,
                                                    "ProjectID"=> $disputePayment[0]->ProjectID,
                                                    "ProjectManager" => $disputePayment[0]->ProjectManager,
                                                    "PaymentID" => $disputePayment[0]->id,
                                                    "dispute_Date" =>  $sepratedtoarray[50],
                                                    "disputedAmount" =>  $sepratedtoarray[49],
                                                    "disputeReason" => $sepratedtoarray[52]
                                                ]);
                                            }

                                        }else{
                                            continue;
                                        }

                                    }

                                }else{
                                    continue;
                                }

                            }

                        }elseif($sepratedtoarray[16] == 'Refunded'){
                            $matchclientmeta = Clientmeta::wherejsoncontains('otheremail',($sepratedtoarray[40]))->get();
                            if ($matchclientmeta->isNotEmpty()){
                                $findclient = Client::where('email',$matchclientmeta[0]->clientID)->get();
                            $count = count($findclient);
                            if( $count == 1){
                                $createClientPayment = NewPaymentsClients::create([
                                    "BrandID" => $findclient[0]->brand,
                                    "ClientID"=> $findclient[0]->id,
                                    "ProjectID"=> 0,
                                    "ProjectManager"=> 0,
                                    "paymentNature"=> "--",
                                    "ChargingPlan"=> "--",
                                    "ChargingMode"=> "--",
                                    "Platform"=> "--",
                                    "Card_Brand"=> $sepratedtoarray[29],
                                    "Payment_Gateway"=> "Stripe",
                                    "bankWireUpload" =>  "--",
                                    "TransactionID"=>$sepratedtoarray[0],
                                    "paymentDate"=>$sepratedtoarray[1],
                                    "SalesPerson"=> 0,
                                    "TotalAmount"=> 0,
                                    "Paid"=> $sepratedtoarray[6],
                                    "RemainingAmount" =>0,
                                    "PaymentType"=> "--",
                                    "numberOfSplits" => "--",
                                    "SplitProjectManager" => json_encode("--"),
                                    "ShareAmount" => json_encode("--"),
                                    "Description"=> $sepratedtoarray[9],
                                    'created_at' => date('y-m-d H:m:s'),
                                    'updated_at' => date('y-m-d H:m:s'),
                                    "refundStatus"=> 'Refund',
                                    "remainingStatus"=> "Unlinked Payments",
                                    "transactionType" => "--"

                                ]);
                            }else{
                                $checkinUnmatched = UnmatchedPayments::where('TransactionID',$sepratedtoarray[0])->count();
                                if($checkinUnmatched > 0){
                                    continue;
                                }else{
                                    // $stripepaymentsall[]=[$sepratedtoarray];
                                    $createClientUnmatchedPayment = UnmatchedPayments::create([
                                        "TransactionID" => $sepratedtoarray[0],
                                        "Clientemail"=> $sepratedtoarray[40],
                                        "paymentDate"=> $sepratedtoarray[1],
                                        "Paid"=> $sepratedtoarray[6],
                                        "Description"=> $sepratedtoarray[9],
                                        "cardBrand"=> $sepratedtoarray[29],
                                        "stripePaymentstatus"=> $sepratedtoarray[16],
                                        'created_at' => date('y-m-d H:m:s'),
                                        'updated_at' => date('y-m-d H:m:s'),

                                    ]);

                                }
                            }

                            }else{
                                continue;
                            }

                        }elseif($sepratedtoarray[16] == 'Failed'){
                            continue;
                        }

                    }else{
                        continue;
                    }

                }else{
                    if($sepratedtoarray != $extractData[0]){
                        if(isset($sepratedtoarray[53]) && $sepratedtoarray[53] != null){
                            $matchclientmeta = Clientmeta::wherejsoncontains('otheremail',$sepratedtoarray[40])->get();
                            if ($matchclientmeta->isNotEmpty()){
                                $findclient = Client::where('id',$matchclientmeta[0]->clientID)->get();
                                $count = count($findclient);
                                if( $count != 0){
                                    $checkstatus = NewPaymentsClients::where('TransactionID',$sepratedtoarray[0])->get();
                                    $checkcount = count($checkstatus);
                                    if($checkcount != 0){
                                        if(isset($checkstatus[0]->dispute) && $checkstatus[0]->dispute != null){
                                            continue;
                                        }else{
                                            $createClientPayment = NewPaymentsClients::where('TransactionID',$sepratedtoarray[0])->update([
                                                "dispute" => "dispute"
                                            ]);
                                            $disputePayment = NewPaymentsClients::where('TransactionID',$sepratedtoarray[0])->get();

                                            $payment_in_dispute_table = Disputedpayments::create([
                                                "BrandID" => $disputePayment[0]->BrandID,
                                                "ClientID" => $disputePayment[0]->ClientID,
                                                "ProjectID"=> $disputePayment[0]->ProjectID,
                                                "ProjectManager" => $disputePayment[0]->ProjectManager,
                                                "PaymentID" => $disputePayment[0]->id,
                                                "dispute_Date" =>  $sepratedtoarray[50],
                                                "disputedAmount" =>  $sepratedtoarray[49],
                                                "disputeReason" => $sepratedtoarray[52]
                                            ]);
                                        }

                                    }else{
                                        continue;
                                    }

                                }else{
                                    continue;
                                }

                            }else{

                            }


                        }else{
                            continue;
                        }

                    }else{
                        continue;
                    }
                }

            };
    };


        $getUnmatched = UnmatchedPayments::get();
        foreach($getUnmatched as $getUnmatcheds){
                $matchclientmeta = Clientmeta::wherejsoncontains('otheremail',($getUnmatcheds->Clientemail))->get();
                $count = count($matchclientmeta);
                if($count > 0){
                    $matchclient = Client::where('id',($matchclientmeta[0]->clientID))->get();
                    if($getUnmatcheds->stripePaymentstatus == "Refunded"){
                        $createClientPayment = NewPaymentsClients::create([
                            "BrandID" => $matchclient[0]->brand,
                            "ClientID"=> $matchclient[0]->id,
                            "ProjectID"=> 0,
                            "ProjectManager"=> 0,
                            "paymentNature"=> "--",
                            "ChargingPlan"=> "--",
                            "ChargingMode"=> "--",
                            "Platform"=> "--",
                            "Card_Brand"=> $getUnmatcheds->cardBrand,
                            "Payment_Gateway"=> "Stripe",
                            "bankWireUpload" =>  "--",
                            "TransactionID"=> $getUnmatcheds->TransactionID,
                            "paymentDate"=> $getUnmatcheds->paymentDate,
                            "SalesPerson"=> 0,
                            "TotalAmount"=> 0,
                            "Paid"=> $getUnmatcheds->Paid,
                            "RemainingAmount" =>0,
                            "PaymentType"=> "--",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => json_encode("--"),
                            "ShareAmount" => json_encode("--"),
                            "Description"=> $getUnmatcheds->Description,
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus"=> 'Refunded',
                            "remainingStatus"=> "Unlinked Payments",
                            "transactionType" => "--"

                        ]);

                    }else{

                        $createClientPayment = NewPaymentsClients::create([
                            "BrandID" => $matchclient[0]->brand,
                            "ClientID"=> $matchclient[0]->id,
                            "ProjectID"=> 0,
                            "ProjectManager"=> 0,
                            "paymentNature"=> "--",
                            "ChargingPlan"=> "--",
                            "ChargingMode"=> "--",
                            "Platform"=> "--",
                            "Card_Brand"=> $getUnmatcheds->cardBrand,
                            "Payment_Gateway"=> "Stripe",
                            "bankWireUpload" =>  "--",
                            "TransactionID"=> $getUnmatcheds->TransactionID,
                            "paymentDate"=> $getUnmatcheds->paymentDate,
                            "SalesPerson"=> 0,
                            "TotalAmount"=> 0,
                            "Paid"=> $getUnmatcheds->Paid,
                            "RemainingAmount" =>0,
                            "PaymentType"=> "--",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => json_encode("--"),
                            "ShareAmount" => json_encode("--"),
                            "Description"=> $getUnmatcheds->Description,
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus"=> 'On Going',
                            "remainingStatus"=> "Unlinked Payments",
                            "transactionType" => "--"

                        ]);
                    }
                    $deleteUnmatched = UnmatchedPayments::where('Clientemail',$getUnmatcheds->Clientemail)->delete();

            }else{
                continue;
            }
        }

        // echo("<pre>");
        // print_r($data[0][1][0]);
        // die();

        return redirect('/payments/unmatched');

    }

    function unmatchedPayments(Request $request){
        $getUnmatched = UnmatchedPayments::get();
        foreach($getUnmatched as $getUnmatcheds){
                $matchclientmeta = Clientmeta::wherejsoncontains('otheremail',($getUnmatcheds->Clientemail))->get();
                $count = count($matchclientmeta);
                if($count > 0){
                    $matchclient = Client::where('id',($matchclientmeta[0]->clientID))->get();
                    if($getUnmatcheds->stripePaymentstatus == "Refunded"){
                        $createClientPayment = NewPaymentsClients::create([
                            "BrandID" => $matchclient[0]->brand,
                            "ClientID"=> $matchclient[0]->id,
                            "ProjectID"=> 0,
                            "ProjectManager"=> 0,
                            "paymentNature"=> "--",
                            "ChargingPlan"=> "--",
                            "ChargingMode"=> "--",
                            "Platform"=> "--",
                            "Card_Brand"=> $getUnmatcheds->cardBrand,
                            "Payment_Gateway"=> "Stripe",
                            "bankWireUpload" =>  "--",
                            "TransactionID"=> $getUnmatcheds->TransactionID,
                            "paymentDate"=> $getUnmatcheds->paymentDate,
                            "SalesPerson"=> 0,
                            "TotalAmount"=> 0,
                            "Paid"=> $getUnmatcheds->Paid,
                            "RemainingAmount" =>0,
                            "PaymentType"=> "--",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => json_encode("--"),
                            "ShareAmount" => json_encode("--"),
                            "Description"=> $getUnmatcheds->Description,
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus"=> 'Refunded',
                            "remainingStatus"=> "Unlinked Payments",
                            "transactionType" => "--"

                        ]);

                    }else{

                        $createClientPayment = NewPaymentsClients::create([
                            "BrandID" => $matchclient[0]->brand,
                            "ClientID"=> $matchclient[0]->id,
                            "ProjectID"=> 0,
                            "ProjectManager"=> 0,
                            "paymentNature"=> "--",
                            "ChargingPlan"=> "--",
                            "ChargingMode"=> "--",
                            "Platform"=> "--",
                            "Card_Brand"=> $getUnmatcheds->cardBrand,
                            "Payment_Gateway"=> "Stripe",
                            "bankWireUpload" =>  "--",
                            "TransactionID"=> $getUnmatcheds->TransactionID,
                            "paymentDate"=> $getUnmatcheds->paymentDate,
                            "SalesPerson"=> 0,
                            "TotalAmount"=> 0,
                            "Paid"=> $getUnmatcheds->Paid,
                            "RemainingAmount" =>0,
                            "PaymentType"=> "--",
                            "numberOfSplits" => "--",
                            "SplitProjectManager" => json_encode("--"),
                            "ShareAmount" => json_encode("--"),
                            "Description"=> $getUnmatcheds->Description,
                            'created_at' => date('y-m-d H:m:s'),
                            'updated_at' => date('y-m-d H:m:s'),
                            "refundStatus"=> 'On Going',
                            "remainingStatus"=> "Unlinked Payments",
                            "transactionType" => "--"

                        ]);
                    }

                    $deleteUnmatched = UnmatchedPayments::where('Clientemail',$getUnmatcheds->Clientemail)->delete();

                }else{
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

    function NewEmailLinkCLient(Request $request, $id){
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

    function NewEmailLinkCLientprocess(Request $request){
        $clientID = $request->input('client');
        $client = Client::where('id', $clientID )->get();
        $clientmetas = Clientmeta::where('clientID', $clientID )->get();
        $email = $request->input('email');
        if( $clientmetas[0]->otheremail == null){
            $toArray = [$client[0]->email , $email ];
            $addnewemailInClient = ClientMeta::where('clientID',$clientID)->update([
                'otheremail' => json_encode($toArray)
            ]);
        }else{
            $otheremails = json_decode( $clientmetas[0]->otheremail);
            array_push($otheremails,$email);
            $addnewemailInClient = ClientMeta::where('clientID',$clientID)->update([
                'otheremail' => json_encode($otheremails)
            ]);
        }
        // print_r($otheremails);

        // die();

        return redirect('/payments/unmatched');
    }

    function pushEmailtometa(Request $request)
    {
        $allclients = Client::get();
        foreach ($allclients as $allclient) {
            $clientmeta = ClientMeta::where('clientID', $allclient->id)->get();

            if ( isset($clientmeta[0]->otheremail) && $clientmeta[0]->otheremail != null) {
                continue;
            } else {
                $toArray = [$allclient->email];
                $addnewemailInClient = ClientMeta::where('clientID', $allclient->id)->update([
                    'otheremail' => json_encode($toArray)
                ]);
            }
        }

        return redirect('/payments/unmatched');
    }

}
