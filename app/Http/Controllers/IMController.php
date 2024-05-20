<?php
namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\College;
use App\Models\Department;
use App\Models\Im;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImController extends Controller
{
    public function index(Request $request)
    {
        $selectedAuthor = $request->input('select_author');
        $selectedCategory = $request->input('select_category');
        $selectedCollege = $request->input('select_college');
        $selectedDepartment = $request->input('select_department');
        $query = Im::with('authors', 'category', 'college', 'department');
        if (!empty($selectedAuthor)) {
            $query->whereHas('authors', function ($q) use ($selectedAuthor) {
                $q->where('author_id', $selectedAuthor);
            });
        }
        if (!empty($selectedCategory)) {
            $query->where('category_id', $selectedCategory);
        }
        if (!empty($selectedCollege)) {
            $query->where('college_id', $selectedCollege);
        }
        if (!empty($selectedDepartment)) {
            $query->where('department_id', $selectedDepartment);
        }
        $ims = $query->select(
            'ims.id',
            'ims.code',
            'ims.title',
            'ims.category_id',
            'ims.college_id',
            'ims.department_id',
            'ims.publisher',
            'ims.edition',
            'ims.isbn',
            'ims.description',
            DB::raw('COALESCE(SUM(purchases.quantity), 0) as unit_sold')
        )
            ->leftJoin('purchases', 'ims.id', '=', 'purchases.im_id')
            ->groupBy('ims.id', 'ims.code', 'ims.title', 'ims.category_id', 'ims.college_id', 'ims.department_id', 'ims.publisher', 'ims.edition', 'ims.isbn', 'ims.description')
            ->orderByDesc('ims.updated_at')
            ->orderByDesc('ims.created_at')
            ->get();
        if ($request->ajax()) {
            return response()->json($ims);
        } else {
            return view('inventory_records.manage_masterlist', compact('ims'));
        }
    }
    public function create()
    {
        $authors = Author::orderBy('first_name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        $colleges = College::orderBy('name', 'asc')->get();
        $departments = Department::orderBy('name', 'asc')->get();
        $data = [
            'authors' => $authors,
            'categories' => $categories,
            'colleges' => $colleges,
            'departments' => $departments,
        ];
        if (request()->ajax()) {
            return response()->json($data);
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
            $request['title'] = formatInput($request['title']);
            $request['publisher'] = $request->input('publisher') ? formatInput($request->input('publisher')) : null;
            $request['edition'] = $request->input('edition') ? formatInput($request->input('edition')) : null;
            $request['isbn'] = $request->input('isbn') ? formatInput($request->input('isbn')) : null;
            $request['description'] = $request->input('description') ? formatInput($request->input('description')) : null;
            $tempCode = Str::uuid()->toString();
            $im = new Im([
                'code' => $tempCode,
                'title' => $request->input('title'),
                'category_id' => $request->input('category_id'),
                'college_id' => $request->input('college_id'),
                'department_id' => $request->input('department_id'),
                'publisher' => $request->input('publisher'),
                'edition' => $request->input('edition'),
                'isbn' => $request->input('isbn'),
                'description' => $request->input('description'),
            ]);
            $authors = $request->input('authors', []);
            if (count($authors) > 0) {
                $existingAuthors = Author::whereIn('id', $authors)->count();
                if ($existingAuthors !== count($authors)) {
                    return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
                }
            }
            try {
                $im->save();
                $college = $im->college;
                $department = $im->department;
                $finalCode = '';
                if ($college && $department) {
                    $finalCode = $college->code . $department->code . $im->id;
                } elseif ($college) {
                    $finalCode = $college->code . $im->id;
                } elseif ($department) {
                    $finalCode = $department->code . $im->id;
                } else {
                    $finalCode = 'IMCD' . $im->id;
                }
                $im->code = $finalCode;
                $im->save();
                $im->authors()->attach($authors);
                return response()->json(['success' => 'The instructional material has been successfully added!'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        }
    }
    public function show($id)
    {
        try {
            $im = Im::with([
                'authors',
                'batches' => function ($query) {
                    $query->select(
                        'batches.id',
                        'batches.im_id',
                        'batches.name',
                        'batches.production_date',
                        'batches.production_cost',
                        'batches.price',
                        'batches.quantity_produced',
                        DB::raw('(SELECT COALESCE(SUM(quantity), 0) FROM purchases WHERE batch_id = batches.id) as quantity_sold'),
                        DB::raw('(SELECT COALESCE(SUM(quantity_deducted), 0) FROM adjustment_logs WHERE batch_id = batches.id) as quantity_deducted')
                    )
                        ->groupBy('batches.id', 'batches.im_id', 'batches.name', 'batches.production_date', 'batches.production_cost', 'batches.price', 'batches.quantity_produced')
                        ->orderByDesc('batches.updated_at')
                        ->orderByDesc('batches.created_at');
                },
                'purchases' => function ($query) {
                    $query->with('im', 'batch')
                        ->orderByDesc('date_sold')
                        ->orderByDesc('created_at');
                }
            ])->findOrFail($id);
            return response()->json($im);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        }
    }
    public function edit($id)
    {
        try {
            $im = Im::findOrFail($id);
            $im->load('authors');
            return response()->json($im);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $im = Im::findOrFail($id);
            function formatInput(string $input): string
            {
                $input = preg_replace('/\s+/', ' ', trim($input));
                return $input;
            }
            $request['title'] = formatInput($request['title']);
            $request['publisher'] = $request->input('publisher') ? formatInput($request->input('publisher')) : null;
            $request['edition'] = $request->input('edition') ? formatInput($request->input('edition')) : null;
            $request['isbn'] = $request->input('isbn') ? formatInput($request->input('isbn')) : null;
            $request['description'] = $request->input('description') ? formatInput($request->input('description')) : null;
            $authors = $request->input('authors', []);
            if (count($authors) > 0) {
                $existingAuthors = Author::whereIn('id', $authors)->count();
                if ($existingAuthors !== count($authors)) {
                    return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
                }
            }
            try {
                $im->update([
                    'title' => $request->input('title'),
                    'category_id' => $request->input('category_id'),
                    'college_id' => $request->input('college_id'),
                    'department_id' => $request->input('department_id'),
                    'publisher' => $request->input('publisher'),
                    'edition' => $request->input('edition'),
                    'isbn' => $request->input('isbn'),
                    'description' => $request->input('description'),
                ]);
                $college = $im->college;
                $department = $im->department;
                $finalCode = '';
                if ($college && $department) {
                    $finalCode = $college->code . $department->code . $im->id;
                } elseif ($college) {
                    $finalCode = $college->code . $im->id;
                } elseif ($department) {
                    $finalCode = $department->code . $im->id;
                } else {
                    $finalCode = 'IMCD' . $im->id;
                }
                $im->code = $finalCode;
                $im->save();
                $im->touch();
                $im->authors()->sync($authors);
                return response()->json(['success' => 'The instructional material has been successfully updated!'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        }
    }
    public function destroy($id)
    {
        try {
            $im = Im::findOrFail($id);
            if ($im->batches()->exists()) {
                return response()->json(['error' => 'This instructional material holds other records and cannot be deleted!'], 422);
            }
            try {
                $im->authors()->detach();
                $im->delete();
                return response()->json(['success' => 'The instructional material has been successfully deleted!'], 200);
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json(['error' => 'This instructional material holds other records and cannot be deleted!'], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        }
    }
}