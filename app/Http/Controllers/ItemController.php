<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function addform(){
        return view('add_item')->with('categories', Category::all());
    }

    public function create(request $request){
        $request->validate([
            'itempic' => 'mimes:jpg, jpeg, png'
        ]);

        $path = $request->file('itempic');

        $item = Item::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
            'image_path' => $path
        ]);

        if($request->hasFile('itempic')){
            $fileName = $item->id . $path->getClientOriginalName();
            $path->storeAs('public/itemimage/images', $fileName);
            $item->image_path = 'itemimage/images/' . $fileName;
            $item->save();
        }
        $cat_ids = $request->input('cat_ids');
        $currentCategoryIds = $item->Category()->pluck('categories.id')->toArray();;

        foreach ($cat_ids as $cat_id) {
            if (!in_array($cat_id, $currentCategoryIds)){
                $item->Category()->attach($cat_id);
            }
        }
        return redirect('/');
    }

    public function editform($id){
        $item = Item::findOrFail($id);
        return view('update_item')->with('item', $item)->with('categories', Category::all());
    }

    public function edit($id, Request $request){
        $item = Item::findOrFail($id);
        Storage::delete('/public/itemimage/images' . $item->image_path);
        $path = $request->file('itempic');

        $request->validate([
            'itempic' => 'mimes:jpg, jpeg, png'
        ]);

        $item->update([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
            'image' => $path
        ]);

        if($request->hasFile('itempic')){
            $fileName = $item->id . $path->getClientOriginalName();
            $path->storeAs('public/itemimage/images', $fileName);
            $item->image_path = 'itemimage/images/' . $fileName;
            $item->save();
        }

        return redirect('/');
    }

    public function deleteItem(Request $request, $id){

        Item::destroy($id);

        return redirect('/');
    }
}
