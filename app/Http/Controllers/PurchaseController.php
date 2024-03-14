<?php
namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\IM;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('im', 'batch')
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->get();
        if (request()->ajax()) {
            return response()->json($purchases);
        } else {
            return view('sales_management.purchase_history', compact('purchases'));
        }
    }
    public function create()
    {
        $ims = IM::with('batches')
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->get();
        if (request()->ajax()) {
            return response()->json($ims);
        }
    }
    public function store(Request $request)
    {
        function formatInput(string $input): string
        {
            $input = preg_replace('/\s+/', ' ', trim($input));
            return $input;
        }
        $request['customer_name'] = formatInput($request['customer_name']);
        $dateSold = Carbon::now()->toDateString();
        $purchase = new Purchase([
            'customer_name' => $request->input('customer_name'),
            'im_id' => $request->input('instructional_material'),
            'batch_id' => $request->input('im_batch'),
            'quantity' => $request->input('quantity'),
            'date_sold' => $dateSold,
        ]);
        $purchase->save();
        $batch = $purchase->batch;
        if ($batch) {
            $batch->available_stocks -= $purchase->quantity;
            $batch->save();
        }
        return response()->json(['success' => 'The purchase has been successfully recorded!'], 200);
    }
}