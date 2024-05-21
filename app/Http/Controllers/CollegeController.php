<?php
namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollegeController extends Controller
{
    public function index()
    {
        $colleges = College::orderBy(DB::raw('COALESCE(updated_at, created_at)'), 'desc')->get();
        if (request()->ajax()) {
            return response()->json($colleges);
        } else {
            return view('inventory_records.manage_colleges', compact('colleges'));
        }
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        try {
            function formatInput(string $input): string
            {
                $input = preg_replace('/\s+/', ' ', trim($input));
                return $input;
            }
            $request['code'] = formatInput($request['code']);
            $request['name'] = formatInput($request['name']);
            $college = new College([
                'code' => $request->input('code'),
                'name' => $request->input('name'),
            ]);
            $college->save();
            return response()->json(['success' => 'The college has been successfully added!'], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(['error' => 'The code has already been taken!'], 422);
            } else {
                return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
            }
        }
    }
    public function show(College $college)
    {
    }
    public function edit($id)
    {
        try {
            $college = College::findOrFail($id);
            return response()->json($college);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $college = College::findOrFail($id);
            function formatInput(string $input): string
            {
                $input = preg_replace('/\s+/', ' ', trim($input));
                return $input;
            }
            $request['code'] = formatInput($request['code']);
            $request['name'] = formatInput($request['name']);
            $college->update([
                'code' => $request->input('code'),
                'name' => $request->input('name'),
            ]);
            return response()->json(['success' => 'The college has been successfully updated!'], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(['error' => 'The code has already been taken!'], 422);
            } else {
                return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        }
    }
    public function destroy($id)
    {
        try {
            $college = College::findOrFail($id);
            $college->delete();
            return response()->json(['success' => 'The college has been successfully deleted!'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'This college holds other records and cannot be deleted!'], 422);
        }
    }
}