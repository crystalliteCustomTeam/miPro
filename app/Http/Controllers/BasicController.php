<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Brand;
use App\Models\Employee;
use App\Models\Department;


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
                print_r($findStaff);
                return ;
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

    function setupdepartments(Request $request){
        $employees = Employee::whereNotIn('position', ['Owner','Admin','VP','Brand Owner','President'])->get();

        return view('department',['employees'=>$employees]);
    }


    function setupdepartmentsProcess(Request $request){
        $departmentName = $request->input('name');
        $search_Department = Department::where('name','like',"%$departmentName%")->get();

        if(count($search_Department) < 0){
            return redirect()->back()->with("Error","Department Already Found !");
        }else{


            $department = Department::create([
                "name" => $departmentName,
                "manager" => $request->input('manager'),
                "users" => json_encode($request->input('selection')),
            ]);
            return redirect()->back()->with("Success","Department Created !");

        }


    }


    function departmentlist(){
        $departments = Department::get();

        return view('departmentlist',["departments" => $departments]);
    }


    function createuser(Request $request){
        $brands  = Brand::all();

        return view('users',["Brands" => $brands]);
    }

    function userlist(Request $request){
        $employees  = Employee::get();

        return view('userlists',["Employees" => $employees]);
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

    function kyc(Request $request){
        return view('kyc');
    }

    function qaform(Request $request){
        return view('qaform');
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
}



