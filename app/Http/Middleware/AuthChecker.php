<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Department;
use App\Models\RoutesRoles;

class AuthChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if($request->session()->has('AdminUser')) {
            // $loginUser = $request->session()->get('AdminUser');

            // $array = json_decode(json_encode($loginUser), true);
            // if (array_key_exists("userRole", $array)) {
            //     $userID = $loginUser->id;
            //     $departmentAccess = "Hidden";
            //     $routeArray = "Hidden";
            // } else {
            //     $userID = $loginUser[0]->id;
            //     $departmentAccess = Department::whereJsonContains('users', "$userID")->get();
            //     $getroutes = RoutesRoles::select("Route")->whereJsonContains('Role',$departmentAccess[0]->access)->get();
            //     $routeArray = $getroutes->pluck('Route')->toArray();
            // }

            // if ($routeArray !== "Hidden") {
            //     $currentUrl = request()->path();

            //     $patternMatched = false;

            //     foreach ($routeArray as $routePattern) {
            //         // Convert the dynamic route pattern to a regex pattern
            //         $regexPattern = str_replace(['{id}'], ['\d+'], $routePattern);
            //         $regexPattern = "#^" . $regexPattern . "$#";

            //         // Check if the current URL matches the regex pattern
            //         if (preg_match($regexPattern, $currentUrl)) {
            //             $patternMatched = true;
            //             break;
            //         }
            //     }

            //     if (!$patternMatched) {
            //         return redirect('/unauthorized');
            //     }
            // }
            return $next($request);
        }
        return redirect('/')->with('loginError',"Please Login To Continue");
    }
}
