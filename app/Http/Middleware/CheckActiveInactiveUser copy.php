<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckActiveInactiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // if (auth()->user()->user_status == 'Inactive') {
        //     return redirect('error-inactive');
        // }
        // else if(auth()->user()->user_status == 'Pendding'){
        //     // return redirect('error-pendding');
        //     return redirect()->route('welcome')->with('danger','YOure Account Is Pending Admin Approval !!!');
        // }
        return $next($request);
        // ['Super Admin','Insurance Company','Hospital','Radiology Center','Medical Center','Lab','Doctor','Patient','Pharmacy','SEO Admin','Gym','Life Coach']
    }
}
