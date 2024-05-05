<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addform(){
        return view('add_category');
    }
    public function create(Request $request){
        Category::create([
            'categoryName' => $request->categoryName
        ]);
        return redirect('/');
    }
}
