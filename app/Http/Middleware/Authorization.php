<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Department;
use App\Models\RoutesRoles;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if ($request->isMethod('get')) {
        //     $loginUser = $request->session()->get('AdminUser');
        //     $array = json_decode(json_encode($loginUser), true);
        //     if (array_key_exists("userRole", $array)) {
        //         $superUser = $loginUser->userRole;
        //         $userID = $loginUser->id;
        //         $departmentAccess = "Hidden";
        //         $routeArray = "Hidden";
        //     } else {
        //         $superUser = 1;
        //         $userID = $loginUser[0]->id;
        //         $departmentAccess = Department::whereJsonContains('users', "$userID")->get();
        //         $getroutes = RoutesRoles::select("Route")->whereJsonContains('Role', $departmentAccess[0]->access)->get();
        //         $routeArray = $getroutes->pluck('Route')->toArray();
        //     }



        //     if ($routeArray !== "Hidden") {
        //         $all_permitted_route = $routeArray;
        //         // $currentUrl = request()->path();
        //         $currentUrl = $request->path();

        //         $patternMatched = false;

        //         foreach ($all_permitted_route as $routePattern) {
        //             // Convert the dynamic route pattern to a regex pattern
        //             $regexPattern = str_replace(['{id}'], ['\d+'], $routePattern);
        //             $regexPattern = "#^" . $regexPattern . "$#";

        //             // Check if the current URL matches the regex pattern
        //             if (preg_match($regexPattern, $currentUrl)) {
        //                 $patternMatched = true;
        //                 break;
        //             }
        //         }

        //         if (!$patternMatched) {
        //             return redirect('/unauthorized');
        //         } else {
        //             return $next($request);
        //         }
        //     }
        // }
        return $next($request);

    }
}
