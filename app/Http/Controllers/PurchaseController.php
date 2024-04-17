<?php
namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\IM;
use App\Models\Batch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('im', 'batch')
            ->orderByDesc('date_sold')
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
        $ims->transform(function ($im) {
            $im->batches->each(function ($batch) {
                $batch->quantity_sold = $batch->purchases->sum('quantity');
                unset ($batch->purchases);
            });
            return $im;
        });
        if (request()->ajax()) {
            return response()->json($ims);
        }
    }
    // public function store(Request $request)
    // {
    //     try {
    //         function formatInput(string $input): string
    //         {
    //             $input = preg_replace('/\s+/', ' ', trim($input));
    //             return $input;
    //         }
    //         $request['customer_name'] = formatInput($request['customer_name']);
    //         $request['or_number'] = formatInput($request['or_number']);
    //         $purchase = new Purchase([
    //             'customer_name' => $request->input('customer_name'),
    //             'or_number' => $request->input('or_number'),
    //             'im_id' => $request->input('instructional_material'),
    //             'batch_id' => $request->input('im_batch'),
    //             'quantity' => $request->input('quantity'),
    //             'date_sold' => $request->input('date_sold'),
    //         ]);
    //         $batch = $purchase->batch;
    //         if ($batch) {
    //             $batch->load('purchases');
    //             $batch->quantity_sold = $batch->purchases->sum('quantity');
    //             $availableStocks = $batch->quantity_produced - $batch->quantity_sold;
    //             if ($availableStocks <= 0) {
    //                 return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
    //             }
    //         }
    //         $purchase->save();
    //         $userId = auth()->id();
    //         $user = User::findOrFail($userId);
    //         if ($user) {
    //             $currentOrNumber = (int) $user->or_pattern;
    //             $nextOrNumber = $currentOrNumber + 1;
    //             $user->update(['or_pattern' => str_pad($nextOrNumber, strlen($user->or_pattern), '0', STR_PAD_LEFT)]);
    //         }
    //         $batchId = $purchase->batch_id;
    //         $batch = Batch::findOrFail($batchId);
    //         $batch->touch();
    //         return response()->json(['success' => 'The purchase has been successfully recorded!'], 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
    //     }
    // }

    public function store(Request $request)
    {
        try {
            $purchasedItems = $request->input('purchased_items');
            foreach ($purchasedItems as $purchasedItem) {
                $purchase = new Purchase([
                    'customer_name' => $purchasedItem['customer_name'],
                    'or_number' => $purchasedItem['or_number'],
                    'im_id' => $purchasedItem['im_id'],
                    'batch_id' => $purchasedItem['batch_id'],
                    'date_sold' => $purchasedItem['date_sold'],
                    'quantity' => $purchasedItem['quantity'],
                ]);
                $purchase->save();
            }
            return response()->json(['success' => 'The purchase has been successfully recorded!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}