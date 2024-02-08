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
use App\Models\Project;
use App\Models\ClientPayment;
use App\Models\EmployeePayment;


class BasicController extends Controller
{
    function login(){
        return view('login');
    }

    function register(){
        return view('register');
    }

    function dashboard(){
        return view('dashboard');
    }




    function loginProcessStaff(Request $request)
    {
        $email = $request->input('userName');

        $staffPassword = $request->input('userPassword');

        $findStaff = Employee::where('email',$email)->get();

        if(count($findStaff) > 0){
            $checkHash = Hash::check($staffPassword, $findStaff[0]->password);
            if($checkHash){
                $request->session()->put('Staffuser',$findStaff);
                return redirect('/employee/dashboard');
            }else{
                return redirect()->back()->with('Error',"Password Not Match !");
            }
        }else{
            return redirect()->back()->with('Error','Email Not Found Please Contact Your Department Head');
        }
    }





    function stafflogin(){
        return view('stafflogin');
    }

    function staffdashboard(Request $request){
        $loginUser = $request->session()->get('Staffuser');
        $userID = $loginUser[0]->id;
        $departmentAccess = Department::whereJsonContains('users', "$userID" )->get();

        return view('staffdashboard',['LoginUser' => $loginUser,'departmentAccess' => $departmentAccess]);
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

    function loginProcess(Request $request){
        $userName = $request->input('userName');
        $userPassword = $request->input('userPassword');

        $finduser = DB::table('adminuser')->where('userName',$userName)->first();
        if($finduser){
            $checkHash = Hash::check($userPassword, $finduser->userPassword);
            if($checkHash){
                $request->session()->put('AdminUser',$finduser);
                return redirect('/dashboard');
            }
        }
        return redirect()->back()->with('loginError','Please Check Username & Password !');

    }

    function setupcompany(Request $request){
        return view('setupcompany');
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
        $companydata = db::table("companies")
         ->where('id', $id)
        ->get();

        return view("editcompany" ,["companydata"=>$companydata]);

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
        return View('companies',["companies"=>$companies]);
    }

    function brandlist(Request $request){
        $brands = Brand::with('brandOwnerName')->get();
        return View('brandlist',["companies"=>$brands]);
    }

    function setupbrand(Request $request,$companyID){
        $employees = Employee::whereIn('position', ['Owner','Admin','VP','Brand Owner','President'])->get();

        return View('brands',["CID" => $companyID,'employees'=>$employees]);
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
        $employees = Employee::whereIn('position', ['Owner','Admin','VP','Brand Owner','President'])->get();
        $branddata = Brand::where('id', $companyID)->get();

        return view("editbrand" ,["branddata"=>$branddata,'employees'=>$employees]);

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
        $employees = Employee::whereNotIn('position', ['Owner','Admin','VP','Brand Owner',''])->get();
        $brand = Brand::all();
        return view('department',['employees'=>$employees,'brands'=>$brand]);
    }


    function setupdepartmentsProcess(Request $request){
        $departmentName = $request->input('name');
        $search_Department = Department::where('name','like',"%$departmentName%")->get();

        if(count($search_Department) < 0){
            return redirect()->back()->with("Error","Department Already Found !");
        }else{

           $results  = explode(",",$request->input('Employeesdata'));

            $department = Department::create([
                "name" => $departmentName,
                "manager" => $request->input('manager'),
                "users" => json_encode($results),
            ]);
            return redirect()->back()->with("Success","Department Created !");

        }


    }


    function departmentlist(){
        $departments = Department::get();

        return view('departmentlist',["departments" => $departments]);
    }

    function editdepartment(Request $request, $id){
        $brand = Brand::all();
        $employees = Employee::whereNotIn('position', ['Owner','Admin','VP','Brand Owner',''])->get();
        $departdata = Department::where('id', $id)->get();

        return view("editdepartment" ,["departdata"=>$departdata , "employees" => $employees , "brands" => $brand]);

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
        $brand = Brand::all();
        $employees = Employee::whereNotIn('position', ['Owner','Admin','VP','Brand Owner',''])->get();
        $departdata = Department::where('id', $id)->get();
        return view("departmentuser" ,["departdata"=>$departdata , "employees" => $employees , "brands" => $brand]);

    }


    function createuser(Request $request){
        $brands  = Brand::all();

        return view('users',["Brands" => $brands]);
    }

    function edituser(Request $request, $id){
        $employee = Employee::where('id', $id)->get();

        return view("edituser" ,["employee"=>$employee]);

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
        $employees  = Employee::get();

        return view('userlists',["Employees" => $employees]);
    }

    function userprofile(Request $request, $id){
        $employee = Employee::where('id', $id)->get();
       // $client = Client::where('projectManager', $id)->get();
        $project = Project::where('projectManager', $id)->get();
        $department = Department::whereJsonContains('users', "$id" )->get();
        if(count($project) > 0){
            $find_client = Client::where('id',$project[0]->clientID)->get();
        }
        else {
            $find_client = [];
        }

        return view("userprofile" ,["employee"=>$employee, "department"=>$department  , "project"=>$project  , "find_client"=>$find_client]);


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
        $brand = Brand::all();
        $projectManager = Employee::get();
        $department = Department::get();

        return view('seo_kyc',['Brands'=>$brand,'ProjectManagers'=>$projectManager ,'departments'=>$department]);
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

    function book(Request $request){
        $brand = Brand::all();
        $projectManager = Employee::get();
        $department = Department::get();

        return view('book_kyc',['Brands'=>$brand,'ProjectManagers'=>$projectManager ,'departments'=>$department]);
    }

    function website(Request $request){
        $brand = Brand::all();
        $projectManager = Employee::get();
        $department = Department::get();

        return view('website_kyc',['Brands'=>$brand,'ProjectManagers'=>$projectManager ,'departments'=>$department]);
    }

    function cld(Request $request){
        $brand = Brand::all();
        $projectManager = Employee::get();
        $department = Department::get();

        return view('cld_kyc',['Brands'=>$brand,'ProjectManagers'=>$projectManager ,'departments'=>$department]);
    }

    function clientProject(){
        $findclient = Client::get();
        $employee = Employee::get();
        return view('project',['clients'=>$findclient,'employee' => $employee]);
    }

    function clientProjectProcess(Request $request){
        Project::create([
            'clientID' => $request->input('client'),
            'projectManager' => $request->input('pm'),
            'productionID' => $request->input('production'),
            'name' => $request->input('name'),
            "domainOrwebsite" => $request->input('website'),
            "basecampUrl" => $request->input('basecampurl'),
            "projectDescription" =>  $request->input('openingcomments')
        ]);

        return redirect('/client/details/'.$request->input('client'));
    }

    function clientProject_prefilled(Request $request, $id){
        $findclient = Client::Where('id',$id)->get();
        $employee = Employee::get();
        return view('project',['clients'=>$findclient,'employee' => $employee]);
    }

    function editproject(Request $request, $id){
        $findproject = Project::Where('id',$id)->get();
        $findclient = Client::get();
        $employee = Employee::get();
        return view('editproject',['clients'=>$findclient,'employee' => $employee ,'projects' => $findproject]);
    }

    function editProjectProcess(Request $request, $id){
        $editproject = Project::where('id', $id)
        ->update([
            'clientID' => $request->input('client'),
            'projectManager' => $request->input('pm'),
            'productionID' => $request->input('production'),
            'name' => $request->input('name'),
            "domainOrwebsite" => $request->input('website'),
            "basecampUrl" => $request->input('basecampurl'),
            "projectDescription" =>  $request->input('openingcomments')
        ]);

        return redirect('/client/details/'.$request->input('client'));

    }

    function getclientDetails(Request $request , $clientID){
        $findclient = Client::where('id',$clientID)->get();
        $allprojects = Project::where('clientID',$clientID)->get();
        $recentClients = Client::where('id','!=',$clientID)->limit(5)->get();
        if(count($allprojects) > 0){
            $findProject_Manager = Employee::where('id',$allprojects[0]->projectManager)->get();
        }
        else {
            $findProject_Manager = [];
        }
        return view('clientDetail',['client'=>$findclient,'recentClients'=>$recentClients,'projects'=>$allprojects,'findProject_Manager'=>$findProject_Manager]);
    }

    function allclients(Request $request){
        $findclient = Client::get();
        return view('allclients',['clients'=>$findclient]);
    }

    function payment(Request $request, $id){

        $findproject = Project::where('id',$id)->get();
        $findclient = Client::get();
        $findemployee = Employee::get();
        $get_projectCount = Project::where('clientID',$findproject[0]->ClientName->id)->count();

        if($get_projectCount <= 1){
            $amount = true;
        }
        else{
            $amount = false;
        }

        return view('payment',['id'=>$id ,'projectmanager'=>$findproject ,'clients'=>$findclient,'employee'=>$findemployee,'AmountCheck'=>$amount]);
    }


    function userreport(Request $request){
        $companies = Company::all();
        $brands = Brand::all();
        $departments = Department::all();
        $employees = Employee::all();
        $clients = Client::all();
        $projects = Project::all();


        return view('userreport', ['company'=> $companies,'brand'=>$brands,'department'=>$departments,'employee'=>$employees,'client'=>$clients,'project'=>$projects]);
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
        $brand = Brand::get();
        $department = Department::get();
        $employee = Employee::get();
        $project = Project::get();
        return view('qaform' , ['brands'=>$brand , 'departments'=>$department , 'projects'=>$project , 'employees'=>$employee]);
    }

    function qaform_prefilled(Request $request , $id ){
        $project = Project::where('id',$id)->get();
        $brand = Brand::get();
        $department = Department::get();
        $employee = Employee::get();

        return view('qaformprefilled' , ['brands'=>$brand , 'departments'=>$department , 'projects'=>$project , 'employees'=>$employee]);
    }

    function renewalrecurring(Request $request){
        return view('renewalrecurring');
    }

    function revenueloss(Request $request){
        return view('revenueloss');
    }

    function paymentconfirmation(Request $request){
        return view('paymentconfirmation');
    }

    function seo_qaform(){
        return view('seo_qaform');
    }

    function book_qaform(){
        return view('book_qaform');
    }

    function website_qaform(){
        return view('website_qaform');
    }

    function cld_qaform(){
        return view('cld_qaform');
    }
}



