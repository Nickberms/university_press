<?php
namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\IM;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with('im', 'purchases')
            ->leftJoin('purchases', 'purchases.batch_id', '=', 'batches.id')
            ->select(
                'batches.*',
                DB::raw('SUM(purchases.quantity) as quantity_sold')
            )
            ->groupBy('batches.id')
            ->orderByDesc('batches.updated_at')
            ->orderByDesc('batches.created_at')
            ->get();
        if (request()->ajax()) {
            return response()->json($batches);
        } else {
            return view('instructional_materials.manage_batches', compact('batches'));
        }
    }
    public function create()
    {
        $ims = IM::orderBy(DB::raw('COALESCE(updated_at, created_at)'), 'desc')->get();
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
        $request['name'] = formatInput($request['name']);
        $batch = new Batch([
            'im_id' => $request->input('instructional_material'),
            'name' => $request->input('name'),
            'production_date' => $request->input('production_date'),
            'production_cost' => $request->input('production_cost'),
            'price' => $request->input('price'),
            'quantity_produced' => $request->input('quantity_produced'),
        ]);
        $batch->save();
        return response()->json(['success' => 'The batch has been successfully added!'], 200);
    }
    public function show(batch $batch)
    {
    }
    public function edit($id)
    {
        $batch = Batch::findOrFail($id);
        return response()->json($batch);
    }
    public function update(Request $request, $id)
    {
        $batch = Batch::findOrFail($id);
        function formatInput(string $input): string
        {
            $input = preg_replace('/\s+/', ' ', trim($input));
            return $input;
        }
        $request['name'] = formatInput($request['name']);
        $quantitySold = Purchase::where('batch_id', $batch->id)->sum('quantity');
        if ($quantitySold > 0) {
            return response()->json(['error' => 'This batch holds other records and cannot be updated!'], 422);
        }
        $batch->update([
            'im_id' => $request->input('instructional_material'),
            'name' => $request->input('name'),
            'production_date' => $request->input('production_date'),
            'production_cost' => $request->input('production_cost'),
            'price' => $request->input('price'),
            'quantity_produced' => $request->input('quantity_produced'),
        ]);
        return response()->json(['success' => 'The batch has been successfully updated!'], 200);
    }
    public function destroy($id)
    {
        try {
            $batch = Batch::findOrFail($id);
            $batch->delete();
            return response()->json(['success' => 'The batch has been successfully deleted!'], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'This batch holds other records and cannot be deleted!'], 422);
        }
    }
}