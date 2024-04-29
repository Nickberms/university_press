<?php
namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class FilterController extends Controller
{
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
}