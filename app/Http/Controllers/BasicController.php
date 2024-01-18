<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Brand;
use App\Models\Employee;


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

    function companies(Request $request){
        $companies = Company::all();
        return View('companies',["companies"=>$companies]);
    }

    function brandlist(Request $request){
        $brands = Brand::all();
        return View('brandlist',["companies"=>$brands]);
    }

    function setupbrand(Request $request,$companyID){
        return View('brands',["CID" => $companyID]);
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
                "address"   =>  $request->input("address"),
                "status"    =>  "Active"
            ]);
            return redirect()->back()->with('Success',"Brand Added !");
        }
    }

    function setupdepartments(Request $request,$brandID){
        return view('department',["CID" => $brandID]);
    }

    function createuser(Request $request){
        $brands  = Brand::all();
        return view('users',["Brands" => $brands]);
    }

    function userlist(Request $request){
        $employees  = Employee::all();
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
            "brand" => $request->input("selectBrand"),
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



