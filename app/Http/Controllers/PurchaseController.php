<?php
namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\IM;
use App\Models\Batch;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        try {
            function formatInput(string $input): string
            {
                $input = preg_replace('/\s+/', ' ', trim($input));
                return $input;
            }
            $purchasedItems = $request->input('purchased_items');
            foreach ($purchasedItems as $purchasedItem) {
                $batch = Batch::find($purchasedItem['batch_id']);
                if (!$batch) {
                    return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
                } else {
                    $batch->load('purchases');
                    $batch->quantity_sold = $batch->purchases->sum('quantity');
                    $availableStocks = $batch->quantity_produced - $batch->quantity_sold;
                    if ($purchasedItem['quantity'] > $availableStocks) {
                        return response()->json(['error' => 'The quantity being purchased is greater than the available stocks of at least one of the items!'], 422);
                    } else {
                        $customerName = formatInput($purchasedItem['customer_name']);
                        $orNumber = formatInput($purchasedItem['or_number']);
                        $purchase = new Purchase([
                            'customer_name' => $customerName,
                            'or_number' => $orNumber,
                            'im_id' => $purchasedItem['im_id'],
                            'batch_id' => $purchasedItem['batch_id'],
                            'date_sold' => $purchasedItem['date_sold'],
                            'quantity' => $purchasedItem['quantity'],
                        ]);
                        $purchase->save();
                    }
                }
            }
            return response()->json(['success' => 'The purchase has been successfully recorded!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        }
    }
}