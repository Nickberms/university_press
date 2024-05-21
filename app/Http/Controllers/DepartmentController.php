<?php
namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy(DB::raw('COALESCE(updated_at, created_at)'), 'desc')->get();
        if (request()->ajax()) {
            return response()->json($departments);
        } else {
            return view('inventory_records.manage_departments', compact('departments'));
        }
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        function formatInput(string $input): string
        {
            $input = preg_replace('/\s+/', ' ', trim($input));
            return $input;
        }
        $request['code'] = formatInput($request['code']);
        $request['name'] = formatInput($request['name']);
        $department = new Department([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
        ]);
        $department->save();
        return response()->json(['success' => 'The department has been successfully added!'], 200);
    }
    public function show(Department $department)
    {
    }
    public function edit($id)
    {
        try {
            $department = Department::findOrFail($id);
            return response()->json($department);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $department = Department::findOrFail($id);
            function formatInput(string $input): string
            {
                $input = preg_replace('/\s+/', ' ', trim($input));
                return $input;
            }
            $request['code'] = formatInput($request['code']);
            $request['name'] = formatInput($request['name']);
            $department->update([
                'code' => $request->input('code'),
                'name' => $request->input('name'),
            ]);
            return response()->json(['success' => 'The department has been successfully updated!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        }
    }
    public function destroy($id)
    {
        try {
            $department = Department::findOrFail($id);
            $department->delete();
            return response()->json(['success' => 'The department has been successfully deleted!'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'This department holds other records and cannot be deleted!'], 422);
        }
    }
}