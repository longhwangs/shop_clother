<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\File;
use App\User;
use App\Product;
use App\Category;
use App\ImageDetail;
use App\ProductSuggest;

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

    public function getSuggest()
    {
        $cate_parent = Category::where('parent_id', '==', config('view.cate_parent'))->get();
        $category_id = Category::where('parent_id', '<>', config('view.cate_parent'))->get();
        return view('user.pages.suggest', compact('cate_parent', 'category_id'));
    }

    public function postSuggest(Request $request)
    {
        $product_suggest = ProductSuggest::create([
            'name' => $request->name,
            'status' => $request->status,
            'description' => $request->description,
            'price' => $request->price,
            'cate_parent' => $request->cate_parent,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'image' => $request->file('image')->getClientOriginalName(),
        ]);
        $request->file('image')->move(public_path('upload/suggest/'), $request->file('image')->getClientOriginalName());

        return redirect()->back()->with(['type_message' => 'success', 'flash_message' => 'Thanks for your offer']);
    }

    public function postRate(Request $request)
    {
        $product = Product::find($request->id);
        $rating = new \willvincent\Rateable\Rating;
        $rating->rating = $request->rate;
        $rating->user_id = auth()->user()->id;
        $product->ratings()->save($rating);

        return redirect()->back();
    }

}
