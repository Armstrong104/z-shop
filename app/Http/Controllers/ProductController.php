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
        $image = $request->image;
        $product = new Product();
        $product->title         = $request->title;
        $product->description   = $request->description;
        $product->price         = $request->price;
        $product->image         = $image->getClientOriginalName();
        $product->save();
        return back()->with('notification', 'Product Added Successfully!');
    }

    public function destroy(int $id)
    {
        $product = Product::find($id);
        $product->delete();
        return back()->with('notification', 'Product Deleted Successfully!');
    }
}
