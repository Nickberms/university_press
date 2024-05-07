<?php
namespace App\Http\Controllers;

use App\Models\AdjustmentLog;
use App\Models\Im;
use Illuminate\Http\Request;

class AdjustmentLogController extends Controller
{
    public function index()
    {
        $adjustment_logs = AdjustmentLog::with('im', 'batch')
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->get();
        if (request()->ajax()) {
            return response()->json($adjustment_logs);
        } else {
            return view('inventory_records.adjustment_logs', compact('adjustment_logs'));
        }
    }
    public function create()
    {
        $ims = Im::with('batches')
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->get();
        $ims->transform(function ($im) {
            $im->batches->each(function ($batch) {
                $batch->quantity_sold = $batch->purchases->sum('quantity');
                $batch->quantity_deducted = $batch->adjustment_logs->sum('quantity_deducted');
                $batch->total_quantity_deducted = $batch->quantity_sold + $batch->quantity_deducted;
                unset ($batch->adjustment_logs);
            });
            return $im;
        });
        if (request()->ajax()) {
            return response()->json($ims);
        }
    }
    public function store(Request $request)
    {
        try {
            function formatInput(string $input): string
            {
                $input = preg_replace('/\s+/', ' ', trim($input));
                return $input;
            }
            $request['adjustment_cause'] = formatInput($request['adjustment_cause']);
            $quantityDeducted = $request->input('quantity_deducted');
            $adjustment_log = new AdjustmentLog([
                'adjustment_cause' => $request->input('adjustment_cause'),
                'im_id' => $request->input('im_id'),
                'batch_id' => $request->input('batch_id'),
                'date_adjusted' => $request->input('date_adjusted'),
                'quantity_deducted' => $request->input('quantity_deducted'),
            ]);
            $batch = $adjustment_log->batch;
            if ($batch) {
                $batch->load('purchases');
                $batch->load('adjustment_logs');
                $batch->quantity_sold = $batch->purchases->sum('quantity');
                $batch->quantity_deducted = $batch->adjustment_logs->sum('quantity_deducted');
                $batch->total_quantity_deducted = $batch->quantity_sold + $batch->quantity_deducted;
                $availableStocks = $batch->quantity_produced - $batch->total_quantity_deducted;
                if ($quantityDeducted > $availableStocks) {
                    return response()->json(['error' => 'The quantity being deducted is greater than the available stocks of the selected item!'], 422);
                } else {
                    $adjustment_log->save();
                    return response()->json(['success' => 'The adjustment log has been successfully recorded!'], 200);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        }
    }
}