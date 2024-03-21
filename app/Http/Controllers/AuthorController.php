<?php
namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::orderBy(DB::raw('COALESCE(updated_at, created_at)'), 'desc')->get();
        if (request()->ajax()) {
            return response()->json($authors);
        } else {
            return view('instructional_materials.manage_authors', compact('authors'));
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
        $request['first_name'] = formatInput($request['first_name']);
        $request['middle_name'] = $request->input('middle_name') ? formatInput($request->input('middle_name')) : null;
        $request['last_name'] = formatInput($request['last_name']);
        $author = new Author([
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
        ]);
        $author->save();
        return response()->json(['success' => 'The author has been successfully added!'], 200);
    }
    public function show(Author $author)
    {
    }
    public function edit($id)
    {
        try {
            $author = Author::findOrFail($id);
            return response()->json($author);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $author = Author::findOrFail($id);
            function formatInput(string $input): string
            {
                $input = preg_replace('/\s+/', ' ', trim($input));
                return $input;
            }
            $request['first_name'] = formatInput($request['first_name']);
            $request['middle_name'] = $request->input('middle_name') ? formatInput($request->input('middle_name')) : null;
            $request['last_name'] = formatInput($request['last_name']);
            $author->update([
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
            ]);
            return response()->json(['success' => 'The author has been successfully updated!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        }
    }
    public function destroy($id)
    {
        try {
            $author = Author::findOrFail($id);
            $author->delete();
            return response()->json(['success' => 'The author has been successfully deleted!'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'This author holds other records and cannot be deleted!'], 422);
        }
    }
}