<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('backend.product.index', ['products' => $products]);
    }
    public function create()
    {
        return view('backend.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required | max:10',
            'price' => 'required | numeric | min:0 | not_in:0',
            'image' => 'image | mimes:jpg,png,bmp,webp',
            'description' => 'max:20'
        ],[
            'title.required' => 'Sir Please Give A Title',
            'title.max' => 'Title must be less than 10 character'
        ]);

        $image = $request->image;
        $product = new Product();

        $product->title         = $request->title;
        $product->description   = $request->description;
        $product->price         = $request->price;
        if ($image) {
            $product->image         = $image->getClientOriginalName();
        }

        $product->save();
        return back()->with('notification', 'Product Added Successfully!');
    }

    public function edit(int $id)
    {
        $product = Product::where('id',$id)->first();
        return view('backend.product.edit',['product'=>$product]);
    }

    public function destroy(int $id)
    {
        $product = Product::find($id);
        $product->delete();
        return back()->with('notification', 'Product Deleted Successfully!');
    }


}
