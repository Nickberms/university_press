<?php
namespace App\Http\Controllers;

use App\Models\IM;
use App\Models\Author;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopSaleController extends Controller
{
    public function index(Request $request)
    {
        $dateRange = $request->input('date_range');
        $selectedAuthor = $request->input('select_author');
        $selectedCategory = $request->input('select_category');
        $selectedCollege = $request->input('select_college');
        $selectedPublisher = $request->input('select_publisher');
        $query = IM::with('authors', 'category')
            ->leftJoin('purchases', 'ims.id', '=', 'purchases.im_id');
        if (!empty($dateRange)) {
            [$startDate, $endDate] = explode(' - ', $dateRange);
            $startDate = Carbon::createFromFormat('m/d/Y', $startDate)->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', $endDate)->endOfDay();
            $query->whereBetween('purchases.date_sold', [$startDate, $endDate]);
        }
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
        $ims = $query->select('ims.*', DB::raw('COALESCE(SUM(purchases.quantity), 0) as quantity_sold'))
            ->orderBy('quantity_sold', 'desc')
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->groupBy('ims.id')
            ->get();
        if ($request->ajax()) {
            return response()->json($ims);
        } else {
            return view('sales_management.top_sales', compact('ims'));
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
}