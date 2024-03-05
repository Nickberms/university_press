<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Auth; 

class DashboardController extends Controller
{
    public function index()
    {

        if(Auth::id())
        {
            $usertype=Auth()->user()->usertype;

            if($usertype=='user')
            {
                return view('home');
            }

            else if($usertype== 'admin')
            {
                return view('admin_dashboard.adminhome');
            }

            else
            {
                return redirect()->back();
            }
        }
    }
}
