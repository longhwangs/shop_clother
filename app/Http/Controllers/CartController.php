<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;
use App\Product;
use App\Order;
use App\OrderDetail;
use Session;
use App\Cart;

class CartController extends Controller
{
    public function getaddCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // ------ Cách 1: Dùng bumbummen99 ------

        if ($request->qty) {
            $qty = $request->qty;
        } else {
            $qty = 1;
        }

        \Cart::add([
            'id' => $id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $product->price,
            'weight' => 550,
            'options' => [
                'image' => $product->image,
            ],
        ]);

        // ------ Cách 2 : Dùng Session --------

        // $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // $cart = new Cart($oldCart);
        // $cart->add($product, $product->id);

        // $request->session()->put('cart', $cart);
        // dd($request->session()->get('cart'));

        return redirect()->back();
    }

    public function deleteCart($id)
    {
        //dd(\Cart::content());
        \Cart::remove($id);
        return redirect()->back();
    }

    public function listCart()
    {
        $cart = \Cart::content();
        return view('user.pages.list_cart', compact('cart'));
    }

    public function updateCart(Request $request)
    {
        \Cart::update($request->rowId, $request->qty);
    }

    public function checkout()
    {
        $cart = \Cart::content();
        $total = \Cart::total();
        return view('user.pages.checkout', compact('cart', 'total'));
    }

    public function postCheckout(CheckoutRequest $request)
    {
        $data['infor'] = $request->all();
        $order = Order::create($data['infor']);

        foreach (\Cart::content() as $key => $cart) {
            $order_detail = OrderDetail::create([
                'quantity' => $cart->qty,
                'price' => $cart->price,
                'order_id' => $order->id,
                'product_id' => $cart->id,
            ]);
        }

        $email = $request->email;
        $name = $request->name;
        $data['cart'] = \Cart::content();
        $data['total'] = \Cart::total();
        \Mail::send('mail.send_mail', $data, function($message) use ($email, $name) {
            $message->from('longjinhofc@gmail.com', 'Ngọc Long');
            $message->to($email, $name);
            $message->subject('Xác nhận đơn mua hàng');
        });

        \Cart::destroy();
        return redirect()->back()->with(['type_message' => 'success', 'flash_message' => 'Bạn đã đặt hàng thành công']);
    }
}
