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

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClientImport;

use function GuzzleHttp\json_decode;

class BasicController extends Controller
{
    function login(){
        return view('login');
    }

    function register(){
        return view('register');
    }

    function get_email(){
        return view("get_email");
    }

    function get_email_process(Request $request){
        $email = $request->input('email');
        $match_email = Employee::where('email',$email)->count();
        if($match_email > 0){
                $request->session()->put('GuestUser',$match_email);
                return redirect('/seo_kyc_form');
        }else{
<<<<<<< HEAD
                return redirect()->back()->with('Error',"Email Not Found!");
=======
                return redirect()->back()->with('Error',"Email Not Found!!");
>>>>>>> a27088e3c2dcf37ff1c6cc6fae1e27273bb9784e
        }


    }

<<<<<<< HEAD
        function seo_kyc_form(){
=======
    function seo_kyc_form(){
>>>>>>> a27088e3c2dcf37ff1c6cc6fae1e27273bb9784e
        $brand = Brand::all();
        $projectManager = Employee::get();
        $department = Department::get();
        $productionservices = ProductionServices::get();

        return view('seo_kyc_form',[
            'Brands'=>$brand,
            'ProjectManagers'=>$projectManager ,
            'departments'=>$department ,
            'productionservices'=>$productionservices ]);
    }

    function seo_kyc_form_process(Request $request){

        $findclient = Client::where('email',$request->input('email'))->get();
        if(count($findclient) > 0){
            return redirect()->back()->with('Error','Client Email Found Please Used New Email');
        }

        $createClient = Client::insertGetId([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
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
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s')
        ]);


        return redirect('/kyclogout');

    }

    function roleExits($request){
        $loginUser = $request->session()->get('AdminUser');
        $array = json_decode(json_encode($loginUser), true);
        if(array_key_exists("userRole",$array)){
            $superUser = $loginUser->userRole;
            $userID = $loginUser->id;
        }else{
            $superUser = 1;
            $userID = $loginUser[0]->id;

        }


        $departmentAccess = Department::whereJsonContains('users', "$userID" )->get();
        return [$departmentAccess,$loginUser,$superUser];

    }

    function dashboard(Request $request){
            $loginUser = $this->roleExits($request);
            if($loginUser[2] == 0){
                $idInQadepart = Department::where('name', 'LIKE', 'Q%') ->get();
                $qapersons = json_decode($idInQadepart[0]->users);
                $eachPersonqaform = [];
                foreach($qapersons as $users){
                    $personName = Employee::where("id",$users)->get();
                    $qapersonsclients = QaPersonClientAssign::where("user",$users)->count();
                    $today_count = QAFORM::where('qaPerson',$users)->whereDate('created_at', '=', now()->toDateString())->count();
                    $currentMonth_disputedClients = QAFORM::where('qaPerson',$users)->whereMonth('created_at', now())->where('status' ,'Dispute')->Distinct('projectID')->latest('created_at')->count();
                    $currentMonth_refundClients = QAFORM::where('qaPerson',$users)->whereMonth('created_at', now())->where('status' ,'Refund')->Distinct('projectID')->latest('created_at')->count();
                    $eachPersonqaform[] = [$personName, $qapersonsclients,$today_count, $currentMonth_disputedClients, $currentMonth_refundClients];
                }
                $last5qaform = QAFORM::where('client_satisfaction','Extremely Dissatisfied')->orwhere('status_of_refund','High')->latest('id')->limit(5)->get();
                $last5qaformstatus = Count($last5qaform);
                $totalClient = Client::count();
                $totalrefund =  QAFORM::where('Refund_Requested' ,'Yes')->Distinct('projectID')->latest('created_at')->count();
                $totaldispute =  QAFORM::where('status' ,'Dispute')->Distinct('projectID')->latest('created_at')->count();

                return view('dashboard',[
                    'eachPersonqaform' => $eachPersonqaform,
                    'last5qaform' => $last5qaform,
                    'last5qaformstatus' => $last5qaformstatus,
                    'totalClient' => $totalClient,
                    'totalrefund' => $totalrefund,
                    'totaldispute' => $totaldispute,
                    'LoginUser' => $loginUser[1],
                    'departmentAccess' => $loginUser[0],
                    'superUser' => $loginUser[2]]);



            }else{
                $total_client = QaPersonClientAssign::where("user",$loginUser[1][0]->id)->get();
                $client_status = Count($total_client);
                $today_count = QAFORM::where('qaPerson',$loginUser[1][0]->id)->whereDate('created_at', '=', now()->toDateString())->count();
                $week_count = QAFORM::where('qaPerson',$loginUser[1][0]->id)->whereBetween('created_at',[Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                $month_count = QAFORM::where('qaPerson',$loginUser[1][0]->id)->whereMonth('created_at', now())->count();
                $currentMonth_lowRiskClients = QAFORM::where('qaPerson',$loginUser[1][0]->id)->whereMonth('created_at', now())->where('status_of_refund' , 'Low')->Distinct('projectID')->latest('created_at')->count();
                $currentMonth_mediumRiskClients = QAFORM::where('qaPerson',$loginUser[1][0]->id)->whereMonth('created_at', now())->where('status_of_refund' , 'Moderate')->Distinct('projectID')->latest('created_at')->count();
                $currentMonth_highRiskClients = QAFORM::where('qaPerson',$loginUser[1][0]->id)->whereMonth('created_at', now())->where('status_of_refund' , 'High')->Distinct('projectID')->latest('created_at')->count();
                $currentMonth_ongoingClients = QAFORM::where('qaPerson',$loginUser[1][0]->id)->whereMonth('created_at', now())->where('status' , 'On Going')->Distinct('projectID')->latest('created_at')->count();
                $currentMonth_disputedClients = QAFORM::where('qaPerson',$loginUser[1][0]->id)->whereMonth('created_at', now())->where('status' ,'Dispute')->Distinct('projectID')->latest('created_at')->count();
                $currentMonth_refundClients = QAFORM::where('qaPerson',$loginUser[1][0]->id)->whereMonth('created_at', now())->where('status' ,'Refund')->Distinct('projectID')->latest('created_at')->count();
                $Total_disputedClients = QAFORM::where('qaPerson',$loginUser[1][0]->id)->where('status' ,'Dispute')->Distinct('projectID')->latest('created_at')->count();
                $Total_refundClients = QAFORM::where('qaPerson',$loginUser[1][0]->id)->where('status' ,'Refund')->Distinct('projectID')->latest('created_at')->count();
                $last5qaform = QAFORM::where('qaPerson',$loginUser[1][0]->id)->where('client_satisfaction','Extremely Dissatisfied')->orwhere('status_of_refund','High')->latest('id')->limit(5)->get();
                $last5qaformstatus = Count($last5qaform);
                return view('dashboard',[
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
                    'superUser' => $loginUser[2]]);

             }



    }

    function registration(Request $request){
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
            "userToken"     => $hashPassword ."-". date('His'),
            "userLastLogin" => date('d-m-Y H:i:s'),
            "userStatus"    => "Created"
        ]);

        if($AdminUser){
            return "USER CREATED !!";
        }
        else{
            return "SOME ERROR ";
        }

    }

    function logout(Request $request){
        $request->session()->forget(['AdminUser']);
        $request->session()->flush();
        return redirect('/');
    }

    function kyclogout(Request $request){
        $request->session()->forget(['GuestUser']);
        $request->session()->flush();
        return redirect('/auth');
    }

    function loginProcess(Request $request){
        $userName = $request->input('userName');
        $userPassword = $request->input('userPassword');

        if($userName == "harrythedev"){
            $finduser = DB::table('adminuser')->where('userName',$userName)->first();

            if($finduser){
                $checkHash = Hash::check($userPassword, $finduser->userPassword);
                if($checkHash){
                    $request->session()->put('AdminUser',$finduser);
                    return redirect('/dashboard');
                }else{
                    return redirect()->back()->with('Error',"Admin Password Not Match !");
                }
            }else{
                return redirect()->back()->with('loginError','Please Check Username & Password !');
            }

        }else{
            $email = $request->input('userName');
            $staffPassword = $request->input('userPassword');
            $findStaff = Employee::where('email',$email)->get();

            if(count($findStaff) > 0){

                $checkHash = Hash::check($staffPassword, $findStaff[0]->password);
                if($checkHash){

                   $request->session()->put('AdminUser',$findStaff);
                   $loginUser = $request->session()->get('AdminUser');

                    return redirect('/dashboard');
                }else{
                    return redirect()->back()->with('Error',"Password Not Match !");
                }
            }else{
                return redirect()->back()->with('Error','Email Not Found Please Contact Your Department Head');
            }

        }

    }

    function setupcompany(Request $request){
        $loginUser = $this->roleExits($request);
        return view('setupcompany',['LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function setupcompanyprocess(Request $request){
        $companyName = $request->input('name');
        $companyEmail = $request->input('email');
        $findCompany = Company::where('name',$companyName)->where('email',$companyEmail)->count();
        if($findCompany > 0){
            return redirect()->back()->with('Error',"Company Already Exists");
        }
        else{
            $insertCompany = Company::create([
                "name"      =>  $companyName,
                "website"   =>  $request->input("website"),
                "tel"       =>  $request->input("tel"),
                "email"     =>  $request->input("email"),
                "address"   =>  $request->input("address"),
                "status"    =>  "Active"
            ]);
            return redirect()->back()->with('Success',"Company Added !");
        }
    }

    function editcompany(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $companydata = db::table("companies")
         ->where('id', $id)
        ->get();

        return view("editcompany" ,["companydata"=>$companydata , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);

    }

    function editcompanyprocess(Request $request, $id){
            $companyname = $request['name'];
            $companyemail = $request['email'];
            $companyaddress = $request['address'];
            $companywebsite = $request['website'] ;
            $companytel = $request['tel'];

            $updatecompany = db::table('companies')
            ->where('id', $id)
            ->update(
                [
                    'name' => $companyname ,
                    'website' => $companywebsite ,
                    'tel' => $companytel ,
                    'email' => $companyemail ,
                    'address' => $companyaddress
                ]);
                return redirect('/companies');
    }

    function deletecompany(Request $request, $id){

            $branddeleted = DB::table('brands')->where('companyID', $id)->delete();
            $companydeleted = DB::table('companies')->where('id', $id)->delete();

            return redirect('/companies');

    }


    function companies(Request $request){
        $companies = Company::all();
        $loginUser = $this->roleExits($request);
        return View('companies',["companies"=>$companies,'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function brandlist(Request $request){
        $loginUser = $this->roleExits($request);
        $brands = Brand::with('brandOwnerName')->get();
        return View('brandlist',["companies"=>$brands , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function setupbrand(Request $request,$companyID){
        $loginUser = $this->roleExits($request);
        $employees = Employee::whereIn('position', ['Owner','Admin','VP','Brand Owner','President'])->get();

        return View('brands',["CID" => $companyID,'employees'=>$employees , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function setupbrandprocess(Request $request){
        $ID = $request->input('companyID');
        $companyName = $request->input('name');
        $companyEmail = $request->input('email');
        $findCompany = Brand::where('name',$companyName)->where('email',$companyEmail)->count();
        if($findCompany > 0){
            return redirect()->back()->with('Error',"Brand Already Exists");
        }
        else{
            $insertCompany = Brand::create([
                "companyID" => $ID,
                "name"      =>  $companyName,
                "website"   =>  $request->input("website"),
                "tel"       =>  $request->input("tel"),
                "email"     =>  $request->input("email"),
                "brandOwner"=>  $request->input('brandOwner'),
                "address"   =>  $request->input("address"),
                "status"    =>  "Active"
            ]);
            return redirect()->back()->with('Success',"Brand Added !");
        }
    }

    function editbrand(Request $request, $companyID){
        $loginUser = $this->roleExits($request);
        $employees = Employee::whereIn('position', ['Owner','Admin','VP','Brand Owner','President'])->get();
        $branddata = Brand::where('id', $companyID)->get();

        return view("editbrand" ,["branddata"=>$branddata,'employees'=>$employees , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);

    }

    function editbrandprocess(Request $request, $id){

        $brandname = $request['name'];
        $brandemail = $request['email'];
        $brandaddress = $request['address'];
        $brandwebsite = $request['website'] ;
        $brandtel = $request['tel'];
        $brandOwner = $request['brandOwner'];

        $editbrand = Brand::where('id', $id)
            ->update(
            [
                'name' => $brandname ,
                'website' => $brandwebsite ,
                'tel' => $brandtel ,
                'email' => $brandemail ,
                'brandOwner' => $brandOwner ,
                'address' => $brandaddress
            ]);
            return redirect('/brandlist');
    }

    function deletebrand(Request $request, $id){

        $branddeleted = DB::table('brands')->where('id', $id)->delete();
        //$companydeleted = DB::table('companies')->where('id', $id)->delete();

        return redirect('/brandlist');

    }

    function setupdepartments(Request $request){
        $loginUser = $this->roleExits($request);
        $employees = Employee::whereNotIn('position', ['Owner','Admin','VP','Brand Owner',''])->get();
        $brand = Brand::all();
        return view('department',['employees'=>$employees,'brands'=>$brand , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function setupdepartments_withBrand(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $employees = Employee::whereNotIn('position', ['Owner','Admin','VP','Brand Owner',''])->get();
        $brand = Brand::where('id',$id)->get();
        return view('department',['employees'=>$employees,'brands'=>$brand , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }


    function setupdepartmentsProcess(Request $request){
        $departmentName = $request->input('name');
        $search_Department = Department::where('name','like',"%$departmentName%")->get();

        if(count($search_Department) > 0){
            return redirect()->back()->with("Error","Department Already Found !");
        }else{

           $results  = explode(",",$request->input('Employeesdata'));

            $department = Department::create([
                "name" => $departmentName,
                "manager" => $request->input('manager'),
                "users" => json_encode($results),
                "brand" => $request->input('brand'),
                "access" => $request->input('access'),
            ]);
            return redirect()->back()->with("Success","Department Created !");

        }


    }


    function departmentlist(Request $request){
        $loginUser = $this->roleExits($request);
        $departments = Department::get();

        return view('departmentlist',["departments" => $departments , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function editdepartment(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $brand = Brand::all();
        $employees = Employee::whereNotIn('position', ['Owner','Admin','VP','Brand Owner',''])->get();
        $departdata = Department::where('id', $id)->get();

        return view("editdepartment" ,["departdata"=>$departdata , "employees" => $employees , "brands" => $brand , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);

    }

    function editdepartmentprocess(Request $request, $id){
        $departname = $request['name'];
        $departmanager= $request['manager'];
        $departbrand = $request['brand'];
        $departaccess = $request['access'] ;
        $departselectedEmployees  = explode(",",$request->input('Employeesdata'));


        $editdepart = Department::where('id', $id)
            ->update(
            [
                'name' => $departname ,
                'manager' => $departmanager ,
                'users' => json_encode($departselectedEmployees) ,
                'brand' => $departbrand ,
                'access' => $departaccess
            ]);
            return redirect('/departmentlist');

    }

    function deletedepartment(Request $request, $id){

        $branddeleted = DB::table('departments')->where('id', $id)->delete();
        //$companydeleted = DB::table('companies')->where('id', $id)->delete();

        return redirect('/departmentlist');

    }

    function departmentusers(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $brand = Brand::all();
        $employees = Employee::whereNotIn('position', ['Owner','Admin','VP','Brand Owner',''])->get();
        $departdata = Department::where('id', $id)->get();
        return view("departmentuser" ,["departdata"=>$departdata , "employees" => $employees , "brands" => $brand , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);

    }


    function createuser(Request $request){
        $loginUser = $this->roleExits($request);
        $brands  = Brand::all();

        return view('users',["Brands" => $brands , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function edituser(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $employee = Employee::where('id', $id)->get();

        return view("edituser" ,["employee"=>$employee , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);

    }

    function edituserprocess(Request $request, $id){

        $username = $request['name'];
        $useremail = $request['email'];
        $userextention = $request['extension'];
        $userposition = $request['position'] ;

        $editbrand = Employee::where('id', $id)
            ->update(
            [
                'name' => $username ,
                'email' => $useremail ,
                'extension' => $userextention ,
                'position' => $userposition
            ]);
            return redirect('/userlist');
    }

    function deleteuser(Request $request, $id){

        $branddeleted = DB::table('employees')->where('id', $id)->delete();
        //$companydeleted = DB::table('companies')->where('id', $id)->delete();

        return redirect('/userlist');

    }

    function userlist(Request $request){
        $loginUser = $this->roleExits($request);
        $employees  = Employee::get();

        return view('userlists',[
            "Employees" => $employees ,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]]);
    }

    function userprofile(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $employee = Employee::where('id', $id)->get();

        $project = Project::where('projectManager', $id)->get();

        $department = Department::whereJsonContains('users', $id )->get();
     if( str_starts_with( $department[0]->name , 'Q') || str_starts_with( $department[0]->name , 'q')){
        $qa_client = QaPersonClientAssign::where("user",$id)->get();
        $qa_client_status = Count($qa_client);


        $es_count = QAFORM::where('qaPerson',$id)->where('client_satisfaction','Extremely Satisfied')->count();
        $ss_count = QAFORM::where('qaPerson',$id)->where('client_satisfaction','Somewhat Satisfied')->count();
        $nsnd_count = QAFORM::where('qaPerson',$id)->where('client_satisfaction','Neither Satisfied nor Dissatisfied')->count();
        $sd_count = QAFORM::where('qaPerson',$id)->where('client_satisfaction','Somewhat Dissatisfied')->count();
        $ed_count = QAFORM::where('qaPerson',$id)->where('client_satisfaction','Extremely Dissatisfied')->count();
        $dispute_count = QAFORM::where('qaPerson',$id)->where('status','Dispute')->count();
        $refund_count = QAFORM::where('qaPerson',$id)->where('status','Refund')->count();
        $ongoing_count = QAFORM::where('qaPerson',$id)->where('status','On Going')->count();
        $nsy_count = QAFORM::where('qaPerson',$id)->where('status','Not Started Yet')->count();
        $today_count = QAFORM::where('qaPerson',$id)->whereDate('created_at', '=', now()->toDateString())->count();
        $exp_refund = QAFORM::where('qaPerson',$id)->where('status_of_refund','High')->count();


        return view("qaUserprofile", [
            'es'=>$es_count ,
            'ss'=>$ss_count ,
            'nsnd'=>$nsnd_count ,
            'sd'=>$sd_count ,
            'ed'=>$ed_count ,
            'disp'=>$dispute_count,
            'refd'=>$refund_count ,
            'ongo'=>$ongoing_count ,
            'nsy'=>$nsy_count ,
            'tc'=>$today_count  ,
            'expref'=>$exp_refund,
            "qa_client_status"=> $qa_client_status,
            "qa_client"=> $qa_client,
            "employee"=>$employee,
            "department"=>$department,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]]);

    }else{
            if(count($project) > 0){
                $find_client = Client::where('id',$project[0]->clientID)->get();
            }
            else {
                $find_client = [];
            }

            return view("userprofile" ,[
                "employee"=>$employee,
                "department"=>$department,
                "project"=>$project,
                "find_client"=>$find_client,
                'LoginUser' => $loginUser[1],
                'departmentAccess' => $loginUser[0],
                'superUser' => $loginUser[2] ]);
           }

    }

    function createuserprocess(Request $request){
        $email = $request->input('email');
        $checkuserExists = Employee::where('email', $email)->count();
        if($checkuserExists > 0){
            return redirect()->back()->with("Error","USER ALREADY EXISTS !");
        }


        $createEmployee = Employee::create([
            "name" => $request->input("name"),
            "email" => $request->input("email"),
            "extension" => $request->input("extension"),

            "password" => Hash::make($request->input("password")),
            "position" => $request->input('position'),
            'status' => "Account Created"
        ]);

        if($createEmployee){
            return redirect()->back()->with("Success","USER Created !");
        }else{
            return redirect()->back()->with("Error","Error While Creating A User Please Contact To Developer");
        }
    }

    function seo(Request $request){
        $loginUser = $this->roleExits($request);
        $brand = Brand::all();
        $projectManager = Employee::get();
        $department = Department::get();
        $productionservices = ProductionServices::get();

        return view('seo_kyc',[
            'Brands'=>$brand,
            'ProjectManagers'=>$projectManager ,
            'departments'=>$department ,
            'productionservices'=>$productionservices ,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]]);
    }

    function kycclientprocess(Request $request){

        $findclient = Client::where('email',$request->input('email'))->get();
        if(count($findclient) > 0){
            return redirect()->back()->with('Error','Client Email Found Please Used New Email');
        }
        $createClient = Client::insertGetId([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'brand' => $request->input('brand'),
            'frontSeler' => $request->input('saleperson'),
            'website' => $request->input('website'),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s')
        ]);


        if ($request->input('serviceType') == 'seo' ){


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
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s')
        ]);
    }elseif ($request->input('serviceType') == 'book'){


        $BOOK_ARRAY =[
            "PRODUCT" => $request->input('product'),
            "MENU_SCRIPT"=> $request->input('menuscript'),
            "BOOK_GENRE"=> $request->input('bookgenre'),
            "COVER_DESIGN"=> $request->input('coverdesign'),
            "TOTAL_NUMBER_OF_PAGES"=> $request->input('totalnumberofpages'),
            "PUBLISHING_PLATFORM"=> $request->input('publishingplatform'),
            "ISBN_OFFERED"=> $request->input('isbn_offered'),
            "LEAD_PLATFORM"=> $request->input('leadplatform'),
            "ANY_COMMITMENT"=> $request->input('anycommitment')
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
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s')
        ]);

    }elseif ($request->input('serviceType') == 'website'){

        $WEBSITE_ARRAY = [
            "OTHER_SERVICES"=> $request->input('otherservices'),
            "LEAD_PLATFORM"=> $request->input('leadplatform'),
            "ANY_COMMITMENT"=> $request->input('anycommitment')

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
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s')
        ]);

    }else {

        $CLD_ARRAY = [
            "OTHER_SERVICES"=> $request->input('otherservices'),
            "LEAD_PLATFORM"=> $request->input('leadplatform'),
            "ANY_COMMITMENT"=> $request->input('anycommitment')
        ];

        $clientmeta = DB::table('clientmetas')->insert([
            'clientID' => $createClient,
            'service' => $request->input('serviceType'),
            'packageName' =>json_encode( $request->input('package')),
            'amountPaid' =>  $request->input('projectamount'),
            'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
            'nextPayment' =>  $request->input('nextamount'),
            'paymentRecuring' => $request->input('ChargingPlan'),
            'orderDetails' => json_encode($CLD_ARRAY),
            'created_at' => date('y-m-d H:m:s'),
            'updated_at' => date('y-m-d H:m:s')
        ]);

    }

        return redirect('all/clients');

    }

    function csv_client(Request $request){
        $loginUser = $this->roleExits($request);
        $brand = Brand::get();
        $employee = Employee::get();
        return view('client_CSV',[
        'brands' => $brand,
        'employees' => $employee,
        'LoginUser' => $loginUser[1],
        'departmentAccess' => $loginUser[0],
        'superUser' => $loginUser[2]
    ]);
    }

    public function importExcel(Request $request){
        $data = Excel::toArray([], $request->file('file'));

        echo "<pre>";
        $client = [];
        $clientMeta = [];
        $clientMetaTire = [];
        $newArray = array();
        foreach($data as $extractData){
            foreach($extractData as $sepratedtoarray ){
                //  print_r($sepratedtoarray);
                for($i = 0 ; $i < 6 ; $i++){
                    $newarray = $sepratedtoarray[$i];
                    array_push($newArray, $newarray);
                    if (($i + 1) % 6 == 0) {
                        array_push($client, $newArray);
                        $newArray = array(); // reset $newArray
                    }
                }
                for($i = 6 ; $i < 12 ; $i++){
                    $newarray = $sepratedtoarray[$i];
                    array_push($newArray, $newarray);
                    if (($i + 1) % 12 == 0) {
                        array_push($clientMeta, $newArray);
                        $newArray = array(); // reset $newArray
                    }
                }

                if($sepratedtoarray[6] == "seo"){

                    for($i = 12 ; $i < 18 ; $i++){
                        $newarray = $sepratedtoarray[$i];
                        array_push($newArray, $newarray);
                        if (($i + 1) % 18 == 0) {
                            array_push($clientMetaTire, $newArray);
                            $newArray = array(); // reset $newArray
                        }
                    }

                }elseif($sepratedtoarray[6] == "book"){

                    for($i = 12 ; $i < 21 ; $i++){
                        $newarray = $sepratedtoarray[$i];
                        array_push($newArray, $newarray);
                        if (($i + 1) % 21 == 0) {
                            array_push($clientMetaTire, $newArray);
                            $newArray = array(); // reset $newArray
                        }
                    }

                }else{

                    for($i = 12 ; $i < 15 ; $i++){
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

        $clientMetaTiresWithArray =[];

        $LOOPCOUNTONE = 0;
            foreach($clientMeta as $clientMetas){

                array_unshift($clientMetaTire[$LOOPCOUNTONE],$clientMetas[0]);

            $LOOPCOUNTONE++;

            }



        $LOOPCOUNTONE = 0;


            foreach($clientMetaTire as $clientMetaTires){

                if( $clientMetaTires[0] == "seo" ){

                    $clientMetaTiresWithArray[] = [
                        "KEYWORD_COUNT" => $clientMetaTires[1],
                        "TARGET_MARKET" => explode(",",$clientMetaTires[2]),
                        "OTHER_SERVICE" => explode(",",$clientMetaTires[3]),
                        "LEAD_PLATFORM" => $clientMetaTires[4],
                        "Payment_Nature" => $clientMetaTires[5],
                        "ANY_COMMITMENT" => $clientMetaTires[6]

                    ];

                }elseif( $clientMetaTires[0] == "book" ){

                    $clientMetaTiresWithArray[] = [
                        "PRODUCT" => explode(",",$clientMetaTires[1]),
                        "MENU_SCRIPT"=> $clientMetaTires[2],
                        "BOOK_GENRE"=> $clientMetaTires[3],
                        "COVER_DESIGN"=> $clientMetaTires[4],
                        "TOTAL_NUMBER_OF_PAGES"=> $clientMetaTires[5],
                        "PUBLISHING_PLATFORM"=> $clientMetaTires[6],
                        "ISBN_OFFERED"=> $clientMetaTires[7],
                        "LEAD_PLATFORM"=> $clientMetaTires[8],
                        "ANY_COMMITMENT"=> $clientMetaTires[9]

                    ];

                }else{

                    $clientMetaTiresWithArray[] = [
                        "OTHER_SERVICES"=>explode(",",$clientMetaTires[1]),
                        "LEAD_PLATFORM"=> $clientMetaTires[2],
                        "ANY_COMMITMENT"=> $clientMetaTires[3]

                    ];

                }

            };

            foreach($client as $clients){


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
            // print_r($clientMeta[$LOOPCOUNTONE]);
        $LOOPCOUNTONE++;

        }

        foreach($clientMeta as $clientMetas){

            $ClientMetaData = ClientMeta::Create([
                'clientID' => $clientMetas[0],
                'service' => $clientMetas[1],
                'packageName' => $clientMetas[2],
                'amountPaid' =>  $clientMetas[3],
                'remainingAmount' => $clientMetas[4],
                'nextPayment' =>  $clientMetas[5],
                'paymentRecuring' => $clientMetas[6],
                'orderDetails' => $clientMetas[7],
                'created_at' => date('y-m-d H:m:s'),
                'updated_at' => date('y-m-d H:m:s')

            ]);

        }

        return redirect('all/clients');

    }

    function editClient(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $brand = Brand::all();
        $projectManager = Employee::get();
        $department = Department::get();
        $productionservices = ProductionServices::get();
        $Client = Client::where('id',$id)->get();
        $ClientMeta = ClientMeta::where('clientID',$id)->get();

        return view('editClient',[
            'clients'=>$Client,
            'clientmetas'=>$ClientMeta,
            'Brands'=>$brand,
            'ProjectManagers'=>$projectManager ,
            'departments'=>$department ,
            'productionservices'=>$productionservices ,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);

    }

    function editClientProcess(Request $request, $id){

        $createClient = Client::where('id',$id)
        ->Update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'brand' => $request->input('brand'),
            'frontSeler' => $request->input('saleperson'),
            'website' => $request->input('website'),
            'updated_at' => date('y-m-d H:m:s')
        ]);

        $ClientMeta = ClientMeta::where('clientID',$id)->get();
        if ($ClientMeta[0]->service == 'seo' ){


        $SEO_ARRAY = [
            "KEYWORD_COUNT" => $request->input('KeywordCount'),
            "TARGET_MARKET" => $request->input('TargetMarket'),
            "OTHER_SERVICE" => $request->input('OtherServices'),
            "LEAD_PLATFORM" => $request->input('leadplatform'),
            "Payment_Nature" => $request->input('paymentnature'),
            "ANY_COMMITMENT" => $request->input('anycommitment')
        ];
        $clientmeta = DB::table('clientmetas')->where('clientID',$id)->update([
            'packageName' => $request->input('package'),
            'amountPaid' =>  $request->input('projectamount'),
            'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
            'nextPayment' =>  $request->input('nextamount'),
            'paymentRecuring' => $request->input('ChargingPlan'),
            'orderDetails' => json_encode($SEO_ARRAY),
            'updated_at' => date('y-m-d H:m:s')
        ]);
    }elseif ($ClientMeta[0]->service == 'book'){


        $BOOK_ARRAY =[
            "PRODUCT" => $request->input('product'),
            "MENU_SCRIPT"=> $request->input('menuscript'),
            "BOOK_GENRE"=> $request->input('bookgenre'),
            "COVER_DESIGN"=> $request->input('coverdesign'),
            "TOTAL_NUMBER_OF_PAGES"=> $request->input('totalnumberofpages'),
            "PUBLISHING_PLATFORM"=> $request->input('publishingplatform'),
            "ISBN_OFFERED"=> $request->input('isbn_offered'),
            "LEAD_PLATFORM"=> $request->input('leadplatform'),
            "ANY_COMMITMENT"=> $request->input('anycommitment')
        ];
        $clientmeta = DB::table('clientmetas')->where('clientID',$id)->update([
            'packageName' => $request->input('package'),
            'amountPaid' =>  $request->input('projectamount'),
            'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
            'nextPayment' =>  $request->input('nextamount'),
            'paymentRecuring' => $request->input('ChargingPlan'),
            'orderDetails' => json_encode($BOOK_ARRAY),
            'updated_at' => date('y-m-d H:m:s')
        ]);

    }elseif ($ClientMeta[0]->service == 'website'){

        $WEBSITE_ARRAY = [
            "OTHER_SERVICES"=> $request->input('otherservices'),
            "LEAD_PLATFORM"=> $request->input('leadplatform'),
            "ANY_COMMITMENT"=> $request->input('anycommitment')

        ];

        $clientmeta = DB::table('clientmetas')->where('clientID',$id)->update([
            'packageName' => json_encode($request->input('package')),
            'amountPaid' =>  $request->input('projectamount'),
            'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
            'nextPayment' =>  $request->input('nextamount'),
            'paymentRecuring' => $request->input('ChargingPlan'),
            'orderDetails' => json_encode($WEBSITE_ARRAY),
            'updated_at' => date('y-m-d H:m:s')
        ]);

    }else {

        $CLD_ARRAY = [
            "OTHER_SERVICES"=> $request->input('otherservices'),
            "LEAD_PLATFORM"=> $request->input('leadplatform'),
            "ANY_COMMITMENT"=> $request->input('anycommitment')
        ];

        $clientmeta = DB::table('clientmetas')->where('clientID',$id)->update([
            'packageName' =>json_encode( $request->input('package')),
            'amountPaid' =>  $request->input('projectamount'),
            'remainingAmount' => $request->input('projectamount') - $request->input('paidamount'),
            'nextPayment' =>  $request->input('nextamount'),
            'paymentRecuring' => $request->input('ChargingPlan'),
            'orderDetails' => json_encode($CLD_ARRAY),
            'updated_at' => date('y-m-d H:m:s')
        ]);

    }

        return redirect('all/clients');

    }

    function book(Request $request){
        $loginUser = $this->roleExits($request);
        $brand = Brand::all();
        $projectManager = Employee::get();
        $department = Department::get();
        $productionservices = ProductionServices::get();

        return view('book_kyc',[
            'Brands'=>$brand,
            'ProjectManagers'=>$projectManager ,
            'departments'=>$department ,
            'productionservices'=>$productionservices ,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]]);
    }

    function website(Request $request){
        $loginUser = $this->roleExits($request);
        $brand = Brand::all();
        $projectManager = Employee::get();
        $department = Department::get();
        $productionservices = ProductionServices::get();

        return view('website_kyc',['Brands'=>$brand,'ProjectManagers'=>$projectManager ,'departments'=>$department , 'productionservices'=>$productionservices , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function cld(Request $request){
        $loginUser = $this->roleExits($request);
        $brand = Brand::all();
        $projectManager = Employee::get();
        $department = Department::get();
        $productionservices = ProductionServices::get();

        return view('cld_kyc',
        ['Brands'=>$brand,
        'ProjectManagers'=>$projectManager,
        'departments'=>$department,
        'productionservices'=>$productionservices,
        'LoginUser' => $loginUser[1],
        'departmentAccess' => $loginUser[0],
        'superUser' => $loginUser[2]]);
    }

    function clientProject(Request $request){
        $loginUser = $this->roleExits($request);
        $findclient = Client::get();
        $employee = Employee::get();
        $user_id = 2;
        return view('project',['user_id'=>$user_id,'clients'=>$findclient,'employee' => $employee , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function assgnedclientProject(Request $request){
        $loginUser = $this->roleExits($request);
        $findclient = QaPersonClientAssign::where('user', $loginUser[1][0]->id)->get();
        $employee = Employee::get();
        $user_id = 1;
        return view('project',['user_id'=>$user_id,'clients'=>$findclient,'employee' => $employee , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }



    function clientProjectProcess(Request $request){
        Project::create([
            'clientID' => $request->input('client'),
            'projectManager' => $request->input('pm'),
            'productionID' => $request->input('productionID'),
            'name' => $request->input('name'),
            "domainOrwebsite" => $request->input('website'),
            "basecampUrl" => $request->input('basecampurl'),
            "projectDescription" =>  $request->input('openingcomments')
        ]);

        return redirect('/client/project/productions/'.$request->input('productionID'));
    }

    function clientProject_prefilled(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $findclient = Client::Where('id',$id)->get();
        $employee = Employee::get();
        $user_id = 2;
        return view('project',['user_id'=>$user_id,'clients'=>$findclient,'employee' => $employee , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function Project_production(Request $request, string $id){
        $loginUser = $this->roleExits($request);
        $production = ProjectProduction::where('projectID',$id)->get();
        $productionservices = ProductionServices::get();

        $project = Project::where('productionID',$id)->get();
        $department = Department::get();
        $departstatus = Count( $department);
        $employee = Employee::get();

        return view('projectProduction' , ['departstatus'=>$departstatus,'departments'=>$department,'employees'=>$employee, 'project_id'=>$project, 'productions'=>$production, 'projects'=>$project, 'productionservices'=>$productionservices , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function Project_ProductionProcess(Request $request, $id){

        ProjectProduction::create([
            'clientID' =>  $request->input('clientname'),
            'projectID' =>  $request->input('projectid'),
            'departmant' => $request->input('department'),
            'responsible_person' => $request->input('production'),
            "services" => json_encode($request->input('services')),
            "anycomment" => $request->input('Description'),
        ]);

        return redirect('/client/project/productions/'.$request->input('projectid'));

    }

    function ProjectProduction_users(Request $request, string $id){
        $loginUser = $this->roleExits($request);
        $project = Project::where('productionID',$id)->get();
        $projectProduction = ProjectProduction::where('projectID',$id)->get();

        return view('projectproductionUsers' ,['projects'=>$project, 'productions'=>$projectProduction, 'prjectid'=>$id , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);

    }

    function editproject(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $findproject = Project::Where('id',$id)->get();
        $findclient = Client::get();
        $employee = Employee::get();
        return view('editproject',['clients'=>$findclient,'employee' => $employee ,'projects' => $findproject , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function editProjectProcess(Request $request, $id){
        $editproject = Project::where('id', $id)
        ->update([
            'clientID' => $request->input('client'),
            'projectManager' => $request->input('pm'),
            'name' => $request->input('name'),
            "domainOrwebsite" => $request->input('website'),
            "basecampUrl" => $request->input('basecampurl'),
            "projectDescription" =>  $request->input('openingcomments')
        ]);

        return redirect('/client/details/'.$request->input('client'));

    }

    function Edit_Project_production(Request $request, $id){
        $loginUser = $this->roleExits($request);
        $projectProduction = ProjectProduction::where('id', $id)->get();
        $department = Department::get();
        $employee = Employee::get();
        $productionservices = ProductionServices::get();

        return view('edit_project_production',['projectProductions'=>$projectProduction, 'departments'=>$department,'employees'=>$employee, 'productionservices'=>$productionservices , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);

    }

    function Edit_Project_production_Process(Request $request, $id){
        $projectid = ProjectProduction::where('id', $id)->get();
        $projectproduction = ProjectProduction::where('id', $id)
        ->update([
            'departmant' => $request->input('department'),
            'responsible_person' => $request->input('production'),
            'services' => json_encode($request->input('services')),
            'anycomment' => $request->input('Description'),
        ]);


        return redirect('/client/project/productions/users/'. $projectid[0]->projectID);

    }

    function deleteproduction($id){
        $production_id =ProjectProduction::where('id', $id)->get();
        $deletedproduction = DB::table('project_productions')->where('id', $id)->delete();

        //$companydeleted = DB::table('companies')->where('id', $id)->delete();

        return redirect('/client/project/productions/users/'. $production_id[0]->projectID);

    }

    function getclientDetails(Request $request , $clientID){
        $loginUser = $this->roleExits($request);
        $findclient = Client::where('id',$clientID)->get();
        $allprojects = Project::where('clientID',$clientID)->get();
        $recentClients = Client::where('id','!=',$clientID)->limit(5)->get();
        if(count($allprojects) > 0){
            $findProject_Manager = Employee::where('id',$allprojects[0]->projectManager)->get();
        }
        else {
            $findProject_Manager = [];
        }
        return view('clientDetail',['client'=>$findclient,'recentClients'=>$recentClients,'projects'=>$allprojects,'findProject_Manager'=>$findProject_Manager , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function allclients(Request $request){
        $loginUser = $this->roleExits($request);
        $findclient = Client::get();
        $user_id = 0;
        return view('allclients',[
            'user_id'=>$user_id,
            'clients'=>$findclient,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]]);
    }

    function assignedclients(Request $request){
        $loginUser = $this->roleExits($request);
        $findclient = QaPersonClientAssign::where('user', $loginUser[1][0]->id)->get();
        $user_id = 1;
        return view('allclients',[
            'user_id'=>$user_id,
            'clients'=>$findclient ,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]]);
    }

    function payment(Request $request, $id){
        $loginUser = $this->roleExits($request);

        $findproject = Project::where('id',$id)->get();
        $findclient = Client::get();
        $findemployee = Employee::get();
        $get_projectCount = Project::where('clientID',$findproject[0]->ClientName->id)->count();
        $allPayments = ClientPayment::where('clientID',$findproject[0]->ClientName->id)->get();

        if($get_projectCount <= 1){
            $amount = true;
        }
        else{
            $amount = false;
        }

        return view('payment',['allPayments'=>$allPayments, 'id'=>$id ,'projectmanager'=>$findproject ,'clients'=>$findclient,'employee'=>$findemployee,'AmountCheck'=>$amount , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }


    function userreport(Request $request){
        $loginUser = $this->roleExits($request);
        $companies = Company::all();
        $brands = Brand::all();
        $departments = Department::all();
        $employees = Employee::all();
        $clients = Client::all();
        $projects = Project::all();


        return view('userreport', ['company'=> $companies,'brand'=>$brands,'department'=>$departments,'employee'=>$employees,'client'=>$clients,'project'=>$projects , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }



    function clientPayment(Request $request){

        $paymentType = $request->input('paymentType');
        $findusername = DB::table('employees')->where('id',$request->input('pmID'))->get();
        $findclient = DB::table('clients')->where('id',$request->input('clientID'))->get();


        if($paymentType == "Split Payment"){
            $projectManager = $request->input('pmID');
            $amountShare = $request->input('splitamount');
            $SecondProjectManager = $request->input('shareProjectManager');
            $total =  $request->input('paidamount') - $amountShare;

            $createpayment = ClientPayment::insertGetId([
                "clientID"  => $request->input('clientID'),
                "projectID" => $request->input('project'),
                "paymentNature" => $request->input('paymentNature'),
                "clientPaid" => $request->input('paidamount'),
                "remainingPayment" => $request->input('remainingamount'),
                "paymentGateway" => $request->input('paymentgateway'),
                "paymentType" => $request->input('paymentType'),
                "ProjectManager" =>  $projectManager,
                "amountShare" => $amountShare,
            ]);

            $findusername = DB::table('employees')->where('id',$request->input('pmID'))->get();
            $findclient = DB::table('clients')->where('id',$request->input('clientID'))->get();
            $paymentDescription = $findusername[0]->name ." Charge Payment For Client ".$findclient[0]->name ;
            $createMainEmployeePayment  = EmployeePayment::create(
            [
                "paymentID" => $createpayment,
                "employeeID" => $request->input('pmID'),
                "paymentDescription" => $findusername[0]->name ." Charge Payment For Client ".$findclient[0]->name,
                "amount" =>     $total
            ],

        );

            $createSharedPersonEmployeePayment  = EmployeePayment::create(
                [
                    "paymentID" => $createpayment,
                    "employeeID" => $SecondProjectManager,
                    "paymentDescription" => "Amount Share By ".$findusername[0]->name ,
                    "amount" =>  $amountShare
                ],
            );

        }else{
            $projectManager = $request->input('pmID');

            $total =  $request->input('paidamount') ;
            $createpayment = ClientPayment::insertGetId([
                "clientID"  => $request->input('clientID'),
                "projectID" => $request->input('project'),
                "paymentNature" => $request->input('paymentNature'),
                "clientPaid" => $request->input('paidamount'),
                "remainingPayment" => $request->input('remainingamount'),
                "paymentGateway" => $request->input('paymentgateway'),
                "paymentType" => $request->input('paymentType'),
                "ProjectManager" =>  $projectManager,
                "amountShare" => 0,
            ]);

            $createEmployeePayment  = EmployeePayment::create(
                [
                    "paymentID" => $createpayment,
                    "employeeID" => $request->input('pmID'),
                    "paymentDescription" => $findusername[0]->name ." Charge Payment For Client ".$findclient[0]->name,
                    "amount" =>  $total
                ]
            );
        }

        return "CHECK";

    }

    function qaform(Request $request){
        $loginUser = $this->roleExits($request);
        $brand = Brand::get();
        $department = Department::get();
        $employee = Employee::get();
        $project = Project::get();
        $client = Client::get();
        $qa_issues = QaIssues::get();
        return view('qaform' , ['brands'=>$brand , 'departments'=>$department , 'projects'=>$project ,'clients'=>$client, 'employees'=>$employee, 'qaissues'=>$qa_issues , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function qaformEmp(Request $request){
        $loginUser = $this->roleExits($request);
        $brand = Brand::get();
        $department = Department::get();
        $employee = Employee::get();
        $project = Project::get();
        $client = Client::get();
        $qa_issues = QaIssues::get();
        return view('qaform' , ['brands'=>$brand , 'departments'=>$department , 'projects'=>$project ,'clients'=>$client, 'employees'=>$employee, 'qaissues'=>$qa_issues ,'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2] ]);
    }

    function qaform_getproduction(Request $request){
        $loginUser = $this->roleExits($request);
        $ProjectID = $request->input('projectname');

        $allprojects = Project::where('id',$ProjectID)
        ->get();
        $findclient = Client::where('id',$allprojects[0]->clientID)->get();
        $production = ProjectProduction::where('projectID', $allprojects[0]->productionID)->get();
        $recentClients = Client::where('id','!=',$allprojects[0]->clientID)->limit(5)->get();
        $qa_issues = QaIssues::get();
        if(count($allprojects) > 0){
            $findProject_Manager = Employee::where('id',$allprojects[0]->projectManager)->get();
        }
        else {
            $findProject_Manager = [];
        }
        return view('newqaform',['client'=>$findclient,'recentClients'=>$recentClients,'projects'=>$allprojects,'findProject_Manager'=>$findProject_Manager , 'productions'=>$production , 'qaissues'=>$qa_issues , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function qaform_direct_process(Request $request ){
        $project = Project::where('id',$request->input('projectname'))->get();
        $qaPerson = $request->session()->get('AdminUser');
        QAFORM::create([
            'clientID' => $project[0]->ClientName->id,
            'projectID' => $request->input('projectname'),
            'projectmanagerID' => $project[0]->EmployeeName->id,
            'brandID' => $project[0]->ClientName->projectbrand->id,
            "qaformID" => $request->input('qaformID'),
            "status" => $request->input('status'),
            "last_communication" =>   $request->input('last_communication_with_client'),
            "medium_of_communication" => json_encode($request->input('Medium_of_communication')),
            "qaPerson" => $qaPerson[0]->id,
        ]);

        return redirect('/forms/qaform/qa_meta/'.$request->input('qaformID'));

    }

    function new_qaform(Request $request , $ProjectID){
        $loginUser = $this->roleExits($request);

        $allprojects = Project::where('id',$ProjectID)->get();
        $findclient = Client::where('id',$allprojects[0]->clientID)->get();
        $production = ProjectProduction::where('projectID', $allprojects[0]->productionID)->get();
        $recentClients = Client::where('id','!=',$allprojects[0]->clientID)->limit(5)->get();
        $qa_issues = QaIssues::get();
        if(count($allprojects) > 0){
            $findProject_Manager = Employee::where('id',$allprojects[0]->projectManager)->get();
        }
        else {
            $findProject_Manager = [];
        }
        return view('newqaform',['client'=>$findclient,'recentClients'=>$recentClients,'projects'=>$allprojects,'findProject_Manager'=>$findProject_Manager , 'productions'=>$production , 'qaissues'=>$qa_issues , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function edit_new_qaform(Request $request , $id){
        $loginUser = $this->roleExits($request);

        $QA_FORM = QAFORM::where('id',$id)->get();
        $QA_META = QAFORM_METAS::where('formid',$QA_FORM[0]->qaformID)->get();
        $Proj_Prod = ProjectProduction::where('id',$QA_FORM[0]->ProjectProductionID)->get();
        $client = Client::where('id',$QA_FORM[0]->clientID)->get();
        $project = Project::where('id',$QA_FORM[0]->projectID)->get();
        $allproductions = projectProduction::where('projectID',$project[0]->productionID)->get();
        $recentClients = Client::where('id','!=',$client[0]->id)->limit(5)->get();
        $allissues = QaIssues::get();
        return view('edit_newqaform',['qa_data'=>$QA_FORM,'qa_meta'=>$QA_META, 'Proj_Prod'=>$Proj_Prod, 'projects'=>$project, 'clients'=>$client ,'recentClients'=>$recentClients, 'productions'=>$allproductions, 'allissues'=>$allissues , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);

    }

    function edit_new_qaform_process(Request $request , $id){

        $qaform = QAFORM::where('id',$id)->get();
        $qaform_meta = QAFORM_METAS::where('formid',$qaform[0]->qaformID)->get();
        $qaPerson = $request->session()->get('AdminUser');

        $production_id = $request->input('production_name');
        $production_data = ProjectProduction::where('id', $production_id)->get();


        if($qaform[0]->status == "Not Started Yet" && $request->input('status') != "Not Started Yet" ){

            if( $request->input('Refund_Request_Attachment') == null){

                QAFORM::where('id',$id)
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

            }else{

                $attachment = $request->file('Refund_Request_Attachment')->store('refundUpload');

                QAFORM::where('id',$id)
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

            if( $request->input('Evidence') == null ){

                QAFORM_METAS::create([
                    'formid' =>  $qaform[0]->qaformID,
                    'departmant' => $production_data[0]->departmant,
                    'responsible_person' =>  $production_data[0]->responsible_person,
                    'status' => $request->input('status'),
                    "issues" => json_encode($request->input('issues')),
                    "Description_of_issue" => $request->input('Description_of_issue'),
                    "evidence" => "--",
                ]);

                return redirect('/client/project/qareport/'.$request->input('projectID'));

            }else{

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

                return redirect('/client/project/qareport/'.$request->input('projectID'));

            };


        }else{

            if($request->hasFile('Refund_Request_Attachment'))
            {
                $path = storage_path('app/'.$qaform[0]->Refund_Request_Attachment);
                if(File::exists($path)){

                    File::delete($path);
                    $attachment = $request->file('Refund_Request_Attachment')->store('refundUpload');
                    QAFORM::where('id',$id)
                            ->Update([
                                "Refund_Request_Attachment" => $attachment
                            ]);
                }else{
                $attachment = $request->file('Refund_Request_Attachment')->store('refundUpload');
                    QAFORM::where('id',$id)
                            ->Update([
                                "Refund_Request_Attachment" => $attachment
                            ]);
                }
            };

            if($request->hasFile('Evidence'))
            {
                $path_evid = storage_path('app/'.$qaform_meta[0]->evidence);
                if(File::exists($path_evid))
                {
                    File::delete($path_evid);
                    $attachment_evid = $request->file('Evidence')->store('uploads');
                    QAFORM_METAS::where('id',$qaform_meta[0]->id)
                            ->Update([
                                "evidence" => $attachment_evid
                            ]);
                }else{
                    $attachment_evid = $request->file('Evidence')->store('uploads');
                        QAFORM_METAS::where('id',$qaform_meta[0]->id)
                                ->Update([
                                    "evidence" => $attachment_evid
                                ]);

                }
            };




            if($request->input('status') == 'Not Started Yet'){

                $delete_meta = DB::table('qaform_metas')->where('formid', $qaform[0]->qaformID)->delete();

                QAFORM::where('id',$id)
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

                return redirect('/client/project/qareport/'.$request->input('projectID'));

            }else{

                if($request->file('Refund_Request_Attachment') != null){


                    QAFORM::where('id',$id)
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

                }else {

                    QAFORM::where('id',$id)
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

                if($request->file('Evidence') != null){




                    QAFORM_METAS::where('formid',$qaform[0]->qaformID)
                    ->update([
                        'departmant' => $production_data[0]->departmant,
                        'responsible_person' =>  $production_data[0]->responsible_person,
                        'status' => $request->input('status'),
                        "issues" => json_encode($request->input('issues')),
                        "Description_of_issue" => $request->input('Description_of_issue'),

                    ]);

                }else{


                    QAFORM_METAS::where('formid',$qaform[0]->qaformID)
                    ->update([
                    'departmant' => $production_data[0]->departmant,
                    'responsible_person' => $production_data[0]->responsible_person,
                    'status' => $request->input('status'),
                    "issues" => json_encode($request->input('issues')),
                    "Description_of_issue" => $request->input('Description_of_issue'),
                    "evidence" => '--'
                ]);

                }

                return redirect('/client/project/qareport/'.$request->input('projectID'));

        }

        }





    }

    function qaform_prefilled(Request $request , $id ){
        $loginUser = $this->roleExits($request);
        $project = Project::where('id',$id)->get();
        $production = ProjectProduction::where('projectID', $project[0]->productionID)->get();
        $brand = Brand::get();
        $department = Department::get();
        $employee = Employee::get();
        $qa_issues = QaIssues::get();

        return view('combined_qaform' , ['brands'=>$brand , 'departments'=>$department , 'projects'=>$project , 'employees'=>$employee , 'productions'=>$production, 'qaissues'=>$qa_issues , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function qaform_prefilled_process(Request $request , $id ){
        $qaPerson = $request->session()->get('AdminUser');
        if($request->input('status') == 'Not Started Yet'){

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

            return redirect('/forms/newqaform/'.$request->input('projectID'));

        }else{

            if($request->file('Refund_Request_Attachment') != null){

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

            }else {

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

            if($request->file('Evidence') != null){

                $evidence = $request->file('Evidence')->store('uploads');


                QAFORM_METAS::create([
                    'formid' =>  $request->input('qaformID'),
                    'departmant' => $production_data[0]->departmant,
                    'responsible_person' =>  $production_data[0]->responsible_person,
                    'status' => $request->input('status'),
                    "issues" => json_encode($request->input('issues')),
                    "Description_of_issue" => $request->input('Description_of_issue'),
                    "evidence" =>   $evidence
                ]);

            }else{


            QAFORM_METAS::create([
                'formid' =>  $request->input('qaformID'),
                'departmant' => $production_data[0]->departmant,
                'responsible_person' => $production_data[0]->responsible_person,
                'status' => $request->input('status'),
                "issues" => json_encode($request->input('issues')),
                "Description_of_issue" => $request->input('Description_of_issue'),
                "evidence" => '--'
            ]);

            }

            return redirect('/forms/newqaform/'.$request->input('projectID'));

        }

    }

    function qaformclient(Request $request , $clientid){
        $findBrand = Client::where('id',$clientid)->get();

        $bID  = $findBrand[0]->brand;
        $findBrandName = Brand::where('id',$bID)->get();
        echo $findBrandName[0]->name;
    }

    function qaformdata(Request $request){
        return ;
    }

    // function renewalrecurring(Request $request){
    //     return view('renewalrecurring');
    // }

    // function revenueloss(Request $request){
    //     return view('revenueloss');
    // }

    // function paymentconfirmation(Request $request){
    //     return view('paymentconfirmation');
    // }

    function projectQaReport(Request $request ,$id  ){
        $loginUser = $this->roleExits($request);
        $project = Project::where('id',$id)->get();
        $projectProduction = ProjectProduction::where('projectID',$project[0]->productionID)->get();
        $QA = QAFORM::where('projectID',$id )->get();
         return view('projectQA',['projects'=>$project, 'productions'=>$projectProduction , 'qafroms'=>$QA , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function projectQaReport_view($id ,Request $request){
        $loginUser = $this->roleExits($request);
        $QA_FORM = QAFORM::where('id',$id)->get();
        $QA_META = QAFORM_METAS::where('formid',$QA_FORM[0]->qaformID)->get();
        $Proj_Prod = ProjectProduction::where('id',$QA_FORM[0]->ProjectProductionID)->get();
        return view('qa_form_view',['qa_data'=>$QA_FORM,'qa_meta'=>$QA_META, 'Proj_Prod'=>$Proj_Prod ,'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function qa_issues(Request $request){
        $loginUser = $this->roleExits($request);
        $department = Department::get();
        $qa_issues=QaIssues::get();
        return view('qa_issues',['departments'=>$department, "qa_issues"=>$qa_issues , 'LoginUser' => $loginUser[1],'departmentAccess' => $loginUser[0],'superUser' => $loginUser[2]]);
    }

    function qa_issues_process(Request $request){
        $qa_issues =QaIssues::create([
            "departmant" => $request->input("department"),
            "issues" => $request->input("issues"),

        ]);

        return redirect()->back()->with('Success',"Issue Added !");

        // return redirect('/settings/qa_issues');

    }

    function delete_qa_issues($id){

        $deletedproduction = DB::table('qa_issues')->where('id', $id)->delete();

        return redirect('/settings/qa_issues');

    }

    function Production_services(Request $request){
        $loginUser = $this->roleExits($request);
        $department = Department::get();
        $statusDepartment = count($department);
        $ProductionServices=ProductionServices::get();
        return view('production_services',[
            'statusDepartment'=>$statusDepartment,
            'departments'=>$department,
            "ProductionServices"=>$ProductionServices ,
            'LoginUser' => $loginUser[1],
            'departmentAccess' => $loginUser[0],
            'superUser' => $loginUser[2]]);
    }

    function Production_services_process(Request $request){
        $ProductionServices =ProductionServices::create([
            "department" => $request->input("department"),
            "services" => $request->input("services"),

        ]);

        return redirect('/settings/Production/services');

    }

    function delete_Production_services($id){

        $deletedproduction = DB::table('production_services')->where('id', $id)->delete();

        return redirect('/settings/Production/services');

    }

    function Assign_Client_to_qaperson(Request $request){
        $loginUser = $this->roleExits($request);
        $department = Department::get();
        $statusDepartment = count($department);
        $QaPersonClientAssigns =QaPersonClientAssign::get();
        $assignedclients =QaPersonClientAssign::select('client')->get();
        $user = Employee::get();
        $clients = Client::whereNotIn('id', $assignedclients)->get();

            return view('client_qaperson', [
                'statusDepartment' => $statusDepartment,
                'users'=>$user,
                'clients'=>$clients,
                'QaPersonClientAssigns'=>$QaPersonClientAssigns,
                'LoginUser' => $loginUser[1],
                'departmentAccess' => $loginUser[0],
                'superUser' => $loginUser[2]]);

    }

    function Assign_Client_to_qaperson_process(Request $request){

        $qaperon_client = QaPersonClientAssign::create([
            "user" => $request->input('user'),
            "client" => $request->input('client'),

        ]);
        return redirect()->back()->with('Success',"Client Assigned Successfully !");
        // return redirect('/settings/user/client');
    }

    function Edit_Assign_Client_to_qaperson(Request $request , $id){
        $loginUser = $this->roleExits($request);
        $department = Department::get();
        $QaPersonClientAssigns1 =QaPersonClientAssign::where('id',$id)->get();
        $QaPersonClientAssigns =QaPersonClientAssign::get();
        $user = Employee::get();
        $clients = Client::get();

            return view('edit_client_qaperson', [
                'users'=>$user,
                'clients'=>$clients,
                'QaPersonClientAssigns'=>$QaPersonClientAssigns,
                'QaPersonClientAssigns1'=>$QaPersonClientAssigns1,
                'LoginUser' => $loginUser[1],
                'departmentAccess' => $loginUser[0],
                'superUser' => $loginUser[2]]);

    }

    function Edit_Assign_Client_to_qaperson_process(Request $request, $id){

        $qaperon_client = QaPersonClientAssign::where('id',$id)
        ->update([
            "user" => $request->input('user'),

        ]);

        return redirect('/settings/user/client');
    }

    function delete_Assign_Client_to_qaperson($id){

    $deletedproduction = DB::table('qaperson_client')->where('id', $id)->delete();

    return redirect('/settings/user/client');

    }

    function projectreport(Request $request, $id){
        $employee = Employee::get();
        $issue = QaIssues::get();


        //BASE QUERY
        $get_startdate = ( $_GET['startdate'] != 0 ) ? $_GET['startdate'] : "";
        $get_enddate = ( $_GET['enddate'] != 0 ) ? $_GET['enddate'] : "";

        //OPTIONAL
        $get_Production = $_GET['Production']  ;
        $get_employee = $_GET['employee'];
        $get_issues = $_GET['issues'];


        $qaformlast = "QAFORM::where('projectID',$id)->whereBetween('created_at',[$get_startdate,$get_enddate])";

        $qaformlast .= "->latest('id')->limit(10)->get()";

        if($get_Production != 0 && $get_employee == 0  && $get_issues == 0){
            $qaformlast .=  "->where('ProjectProductionID',$get_Production)";
        }elseif($get_Production == 0 && $get_employee != 0  && $get_issues == 0){

        }elseif($get_Production == 0 && $get_employee == 0  && $get_issues != 0){

        }elseif($get_Production != 0 && $get_employee != 0  && $get_issues == 0){

        }elseif($get_Production == 0 && $get_employee != 0  && $get_issues != 0){

        }elseif($get_Production != 0 && $get_employee == 0  && $get_issues != 0){

        }elseif($get_Production != 0 && $get_employee != 0  && $get_issues != 0){

        }else{

        }





        // $qaformlast = str_replace('"', '', $qaformlast);
        // eval($qaformlast);

        // print_r($qaformlast);
        //  die();

        $project = Project::where('id', $id)->get();
        $ProjectProduction = ProjectProduction::where('projectID', $project[0]->productionID)->get();
        $client = Client::where('id', $project[0]->clientID)->get();
        $clientmeta = ClientMeta::where('id', $client[0]->clientID);
        $qaformlast = QAFORM::where('projectID',$project[0]->id)
                    ->latest('id')->limit(1)->get();

        return view('report_home', ['projects'=>$project, 'projectproductions'=>$ProjectProduction, 'clients'=>$client, 'clientmetas'=>$clientmeta,  'qaformlast'=>$qaformlast , 'employees'=>$employee, 'issues'=>$issue]);


        // $qaformlast = QAFORM::where('projectID',$project[0]->id)
        //             ->latest('id')->limit(1)->get();


        }
}
