<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Category;
use App\ImageDetail;

class PageController extends Controller
{
    public function index()
    {
        $products = Product::where('deleted_at', null)->get();
    	return view('user.pages.home', compact('products'));
    }

    public function editProfile()
    {
    	return view('user.pages.profile');
    }

    public function updateProfile(Request $request, $id)
    {
    	$data = $request->all();
    	$user = User::findOrFail($id);
    	$user->update($data);
    	return redirect()->back();
    }

    public function productType($id)
    {
        $parent_id = Category::findOrFail($id);
        $category = Category::where('parent_id', $id)->get();
        $products = Product::where('deleted_at', null)->where('cate_parent', $id)->get();
        return view('user.pages.product_type', compact('parent_id', 'category', 'products'));
    }

    public function productDetail($id)
    {
        $product = Product::findOrFail($id);
        $image_detail = ImageDetail::where('product_id', $id)->get();
        $relate_product = Product::where('deleted_at', null)->where('category_id', $product->category_id);
        $relate_product = $relate_product->where('id', '<>', $id)->get();
        return view('user.pages.product_detail', compact('product', 'image_detail', 'relate_product'));
    }

}
