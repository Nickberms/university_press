<?php
namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\Im;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImController extends Controller
{
    public function index(Request $request)
    {
        $selectedAuthor = $request->input('select_author');
        $selectedCategory = $request->input('select_category');
        $selectedCollege = $request->input('select_college');
        $selectedPublisher = $request->input('select_publisher');
        $query = Im::with('authors', 'category');
        if (!empty($selectedAuthor)) {
            $query->whereHas('authors', function ($q) use ($selectedAuthor) {
                $q->where('author_id', $selectedAuthor);
            });
        }
        if (!empty($selectedCategory)) {
            $query->where('category_id', $selectedCategory);
        }
        if (!empty($selectedCollege)) {
            $query->where('college', $selectedCollege);
        }
        if (!empty($selectedPublisher)) {
            $query->where('publisher', $selectedPublisher);
        }
        $ims = $query->select(
            'ims.id',
            'ims.code',
            'ims.title',
            'ims.category_id',
            'ims.college',
            'ims.publisher',
            'ims.edition',
            'ims.isbn',
            'ims.description',
            DB::raw('COALESCE(SUM(purchases.quantity), 0) as unit_sold')
        )
            ->leftJoin('purchases', 'ims.id', '=', 'purchases.im_id')
            ->groupBy('ims.id', 'ims.code', 'ims.title', 'ims.category_id', 'ims.college', 'ims.publisher', 'ims.edition', 'ims.isbn', 'ims.description')
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
        $authors = Author::orderBy(DB::raw('COALESCE(updated_at, created_at)'), 'desc')->get();
        $categories = Category::orderBy(DB::raw('COALESCE(updated_at, created_at)'), 'desc')->get();
        $data = [
            'authors' => $authors,
            'categories' => $categories,
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
            $request['code'] = formatInput($request['code']);
            $request['title'] = formatInput($request['title']);
            $request['college'] = $request->input('college') ? formatInput($request->input('college')) : null;
            $request['publisher'] = $request->input('publisher') ? formatInput($request->input('publisher')) : null;
            $request['edition'] = $request->input('edition') ? formatInput($request->input('edition')) : null;
            $request['isbn'] = $request->input('isbn') ? formatInput($request->input('isbn')) : null;
            $request['description'] = $request->input('description') ? formatInput($request->input('description')) : null;
            $im = new Im([
                'code' => $request->input('code'),
                'title' => $request->input('title'),
                'category_id' => $request->input('category_id'),
                'college' => $request->input('college'),
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
                $im->authors()->attach($authors);
                return response()->json(['success' => 'The instructional material has been successfully added!'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An internal error was detected, please try refreshing the page!'], 422);
        }
    }
    public function show(Im $im)
    {
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
            $request['code'] = formatInput($request['code']);
            $request['title'] = formatInput($request['title']);
            $request['college'] = $request->input('college') ? formatInput($request->input('college')) : null;
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
                    'code' => $request->input('code'),
                    'title' => $request->input('title'),
                    'category_id' => $request->input('category_id'),
                    'college' => $request->input('college'),
                    'publisher' => $request->input('publisher'),
                    'edition' => $request->input('edition'),
                    'isbn' => $request->input('isbn'),
                    'description' => $request->input('description'),
                ]);
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