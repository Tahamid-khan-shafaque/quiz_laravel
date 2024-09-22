<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use Stripe;
use Session;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    public function index()
    {
        $user = User::where('usertype', 'user')->get()->count();
        $product = Product::all()->count();
        $order = Order::all()->count();
        $delivered = Order::where('status', 'Delivered')->get()->count();
        return view('admin.index', compact('user', 'product', 'order', 'delivered'));
    }

    public function home()
    {
        $product = Product::all();
        if (Auth::id()) { #if there is any user logged in
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }

        return view('home.index', compact('product', 'count'));
    }

    public function login_home()
    {
        $product = Product::all();
        if (Auth::id()) { #if there is any user logged in
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }
        return view('home.index', compact('product', 'count'));
    }
    public function product_details($id)
    {
        $product = Product::find($id);
        if (Auth::id()) {#if there is any user logged in
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->count();
        } else {
            $count = '';
        }
        return view('home.product_details', compact('product', 'count'));

    }

    public function add_cart($id)
    {
        $product_id = $id;
        $user = Auth::user();
        $user_id = $user->id;

        $data = new Cart();
        $data->user_id = $user_id;
        $data->product_id = $product_id;
        $data->save();
        toastr()->timeOut(5000)->closeButton()->addSuccess('Product Added Successfully');
        return redirect()->back();

    }


    public function mycart()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $count = Cart::where('user_id', $userid)->get()->count();
            $cart = Cart::where('user_id', $userid)->get();
        } else {
            $count = '';
        }
        return view('home.mycart', compact('count', 'cart'));
    }

    public function confirm_order(Request $request)
    {
        $name = $request->input('name');
        $order = new Order();
        $address = $request->address;
        $phone = $request->phone;
        $userid = Auth::user()->id;
        $cart = Cart::where('user_id', $userid)->get();
        foreach ($cart as $cart) {
            $order = new Order;
            $order->name = $name;
            $order->rec_address = $address;
            $order->phone = $phone;
            $order->user_id = $userid;
            $order->product_id = $cart->product_id;
            $order->save();
        }
        $cart_remove = Cart::where('user_id', $userid)->get();
        foreach ($cart_remove as $remove) {
            $data = Cart::find($remove->id);
            $data->delete();

        }
        toastr()->timeOut(5000)->closeButton()->addSuccess('Order Placed Successfully');
        return redirect()->back();
    }
    public function store(Request $request)
    {
        return view('home.create_product');
    }
    public function upload(Request $request)
    {
        $data = new Product;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->category = $request->category;
        $data->quantity = $request->quantity;
        $image = $request->image;
        if ($image) {
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('productimage', $imagename);
            $data->image = $imagename;
        }

        $data->save();

        return response()->json(['message' => 'Data uploaded successfully']);
    }
    public function stripe($value)
    {
        return view('home.stripe', compact('value'));
    }
    public function stripePost(Request $request, $value)
    {

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create([

            "amount" => $value * 100,

            "currency" => "usd",

            "source" => $request->stripeToken,

            "description" => "Test payment from Tahamid"

        ]);

        $name = Auth::user()->name;
        $address = Auth::user()->address;
        $phone = Auth::user()->phone;
        $userid = Auth::user()->id;
        $cart = Cart::where('user_id', $userid)->get();
        foreach ($cart as $cart) {
            $order = new Order;
            $order->name = $name;
            $order->rec_address = $address;
            $order->phone = $phone;
            $order->user_id = $userid;
            $order->payment_status = "Paid";
            $order->product_id = $cart->product_id;
            $order->save();
        }
        #order places successfully
        #delete cart data
        $cart_remove = Cart::where('user_id', $userid)->get();
        foreach ($cart_remove as $remove) {
            $data = Cart::find($remove->id);
            $data->delete();

        }
        #redirect to mycart
        toastr()->timeOut(5000)->closeButton()->addSuccess('Order Placed Successfully');
        return redirect('mycart');
    }
    public function remove($id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem) {
            $cartItem->delete();
            toastr()->timeOut(5000)->closeButton()->addSuccess('Cart Removed Successfully');
            return redirect()->route('mycart')->with('refresh', true);
        } else {
            toastr()->timeOut(5000)->closeButton()->addSuccess('Cart Removed Successfully');
            return redirect()->route('mycart')->with('refresh', true);
        }
    }
}
