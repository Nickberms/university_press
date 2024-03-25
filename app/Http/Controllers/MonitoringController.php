<?php
namespace App\Http\Controllers;

use App\Models\Batch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month');
        if (!empty ($month)) {
            $startDate = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
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
            foreach ($batches as $batch) {
                $dailySales = [];
                $batchPurchases = $batch->purchases()
                    ->whereBetween('date_sold', [$startDate, $endDate])
                    ->get();
                foreach ($batchPurchases as $purchase) {
                    $day = Carbon::createFromFormat('Y-m-d', $purchase->date_sold)->day;
                    $dailySales[$day] = ($dailySales[$day] ?? 0) + $purchase->quantity;
                }
                $batch->daily_sales = $dailySales;
            }
            if ($request->ajax()) {
                return response()->json($batches);
            } else {
                return view('sales_management.daily_monitoring', compact('batches'));
            }
        } else {
            return view('sales_management.daily_monitoring');
        }
    }
}