<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    public function updateform($id){
        $item = Item::find($id);
        return view('update_category', ['categories' => Category::all(),'item' => $item]);
    }

    public function updatecategory(Request $request, $id){
        $item = Item::with('Category')->find($id);
        $cat_ids = $request->input('cat_ids');
        $currentCategoryIds = $item->Category()->pluck('categories.id')->toArray();;

        foreach ($cat_ids as $cat_id) {
            if (!in_array($cat_id, $currentCategoryIds)){
                $item->Category()->attach($cat_id);
            }
        }
        return redirect('/');
    }
}
