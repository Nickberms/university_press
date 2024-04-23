<?php
namespace App\Http\Controllers;

use App\Models\IM;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopSaleController extends Controller
{
    public function index()
    {
        $authors = Author::orderBy(DB::raw('COALESCE(updated_at, created_at)'), 'desc')->get();
        $categories = Category::orderBy(DB::raw('COALESCE(updated_at, created_at)'), 'desc')->get();
        $data = [
            'authors' => $authors,
            'categories' => $categories,
        ];
        if (request()->ajax()) {
            return response()->json($data);
        } else {
            return view('sales_management.top_sales');
        }
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
    }
    public function show(IM $im)
    {
    }
    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
    }
    public function destroy($id)
    {
    }
}