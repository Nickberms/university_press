<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::id()) {
            $accountType = Auth()->user()->account_type;
            if ($accountType == 'Admin' || $accountType == 'Super Admin') {
                return view('admin_dashboard.admin_home');
            } else if ($accountType == 'Employee') {
                return view('employee_dashboard.employee_home');
            } else {
                return redirect()->back();
            }
        }
    }
}