<?php
namespace App\Http\Controllers;

use App\Models\Batch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateRange = $request->input('date_range');
        if (!empty ($dateRange)) {
            [$startDate, $endDate] = explode(' - ', $dateRange);
            $startDate = Carbon::createFromFormat('m/d/Y', $startDate)->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', $endDate)->endOfDay();
            $previousDay = clone $startDate;
            $previousDay->subDay();
            $batches = Batch::with('im', 'purchases')
                ->join('purchases', 'batches.id', '=', 'purchases.batch_id')
                ->select(
                    'batches.id',
                    'batches.im_id',
                    'batches.name',
                    'batches.production_date',
                    'batches.production_cost',
                    'batches.price',
                    'batches.quantity_produced',
                    DB::raw('SUM(CASE WHEN purchases.date_sold < "' . $startDate . '" THEN purchases.quantity ELSE 0 END) as sold_quantity_before'),
                    DB::raw('SUM(CASE WHEN purchases.date_sold BETWEEN "' . $startDate . '" AND "' . $endDate . '" THEN purchases.quantity ELSE 0 END) as sold_quantity_within')
                )
                ->groupBy('batches.id', 'batches.im_id', 'batches.name', 'batches.production_date', 'batches.production_cost', 'batches.price', 'batches.quantity_produced')
                ->orderByDesc('batches.updated_at')
                ->orderByDesc('batches.created_at')
                ->get();
            if ($request->ajax()) {
                return response()->json($batches);
            } else {
                return view('sales_management.generate_reports', compact('batches'));
            }
        } else {
            return view('sales_management.generate_reports');
        }
    }
}