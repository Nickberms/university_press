<?php
namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\IM;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::id()) {
            $countBatches = Batch::count();
            $countIms = IM::count();
            $countAuthors = Author::count();
            $countCategories = Category::count();
            $accountType = Auth()->user()->account_type;
            if ($accountType == 'Admin' || $accountType == 'Super Admin') {
                return view('admin_dashboard.admin_home', compact('countBatches', 'countIms', 'countAuthors', 'countCategories'));
            } else if ($accountType == 'Employee') {
                return view('employee_dashboard.employee_home', compact('countBatches', 'countIms', 'countAuthors', 'countCategories'));
            } else {
                return redirect()->back();
            }
        }
    }
}