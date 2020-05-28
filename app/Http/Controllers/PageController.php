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
        $products = Product::where('deleted_at', null)->orderBy('created_at', 'DESC')->paginate(4);
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

    public function liveSearch(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = Product::where('name', 'LIKE', '%'.$query.'%')->orWhere('price', $query)->get();
            $output = "<ul id='show_result' class='dropdown-menu' style='display:block !important; position: relative !important; width: 245px; left: 20px; padding: 0 5px;' ><div class='row'>";

            if (empty($data->toArray())) {
                $output .= "Not Found.";
            } else {
                foreach($data as $row) {
                    $output .= '
                    <div class="col-sm-4">
                    <img style="height: 50px; width: 50px; margin:5px 0" src="upload/'.$row->image.'" alt="">
                    </div>
                    <div class="col-sm-8">
                    <li value="'.$row->id.'"><a href="'. route("product-detail", $row->id) .'">'.$row->name.' - '.$row->price.' VND</a></li>
                    </div>
                    ';
                }
            }
            $output .= "</div></ul>";
            echo $output;
        }

        if ($request->get('query') == '') {
            $output = '<ul id="show_result" class="dropdown-menu">';
            echo $output;
        }
    }
    
    public function load_data(Request $request) {
        if ($request->ajax()) {
            $data = Product::orderBy('created_at', 'DESC')->where('deleted_at', null)->paginate(4);
            $output = '<div id="load-data" class="row isotope-grid">';
            
            if (!empty($data)) {
                foreach($data as $row) {
                    $output .= '
                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item '.$row->cate_parent.'">
                        <div class="block2">
                            <div class="block2-pic hov-img0">
                                <a href="'. route("product-detail", $row->id) .'">
                                    <img src="upload/'.$row->image.'" alt="IMG-PRODUCT" height="350px">
                                </a>   
                            </div>
                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l ">
                                    <a href="'. route("product-detail", $row->id) .'" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    <h5>'.$row->name.'</h5>
                                    </a>
                                    <span class="stext-105 cl3">
                                    '.number_format($row->price).' VNĐ
                                    </span>
                                </div>
                                <div class="block2-txt-child2 flex-r p-t-3">
                                    <div id="add_to_cart" class="cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                                        <button class="btn btn-primary" data-id="'.$row->id.'"><i class="zmdi zmdi-shopping-cart"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                }
            }
            $output .= '</div>';
            echo $output;
        }
    }

}
