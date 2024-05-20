<?php
namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\College;
use App\Models\Department;

class FilterController extends Controller
{
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
}