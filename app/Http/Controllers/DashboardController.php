<?php
namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\IM;
use App\Models\Author;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::id()) {
            $currentDate = Carbon::today();
            $batches = Batch::with('im', 'purchases', 'adjustment_logs')
                ->select(
                    'batches.id',
                    'batches.im_id',
                    'batches.name',
                    'batches.production_date',
                    'batches.production_cost',
                    'batches.price',
                    'batches.quantity_produced',
                    DB::raw('(SELECT COALESCE(SUM(quantity), 0) FROM purchases WHERE batch_id = batches.id AND DATE(date_sold) = "' . $currentDate->toDateString() . '") as quantity_sold_today'),
                    DB::raw('(SELECT COALESCE(SUM(quantity_deducted), 0) FROM adjustment_logs WHERE batch_id = batches.id AND DATE(date_adjusted) = "' . $currentDate->toDateString() . '") as quantity_deducted_today'),
                    DB::raw('(SELECT COALESCE(SUM(quantity), 0) FROM purchases WHERE batch_id = batches.id) as quantity_sold'),
                    DB::raw('(SELECT COALESCE(SUM(quantity_deducted), 0) FROM adjustment_logs WHERE batch_id = batches.id) as quantity_deducted')
                )
                ->havingRaw('(quantity_sold_today > 0 OR quantity_deducted_today > 0)')
                ->orderByDesc('batches.updated_at')
                ->orderByDesc('batches.created_at')
                ->get();
            $countBatches = Batch::count();
            $countIms = IM::count();
            $countAuthors = Author::count();
            $countCategories = Category::count();
            $accountType = Auth()->user()->account_type;
            if ($request->ajax()) {
                return response()->json($batches);
            } else if ($accountType == 'Admin' || $accountType == 'Super Admin') {
                return view('admin_dashboard.admin_home', compact('countBatches', 'countIms', 'countAuthors', 'countCategories'));
            } else if ($accountType == 'Employee') {
                return view('employee_dashboard.employee_home', compact('countBatches', 'countIms', 'countAuthors', 'countCategories'));
            } else {
                return redirect()->back();
            }
        }
    }
}