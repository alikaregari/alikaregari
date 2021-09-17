<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public $call;
    public function __construct()
    {
        $this->call=collect([]);
    }
    public function index(){
        //return Cart::all();
        $cart=Cart::all();
        return view('products.cart',compact('cart'));
    }
    public function AddToCart(Product $product)
    {
        if (Cart::has($product)):
             Cart::updateChecking($product,1);
            else:
             Cart::put(['quantity'=>1,'price'=>$product->price],$product);
        endif;
        return redirect('cart');
    }
    public function quantityChange(Request $request){
        $data=$request->validate([
            'quantity'=>'required',
            'id'=>'required',
            'btn'=>'required'
            //'cart'=>'required'
        ]);
        if ($data['btn']==true):
            $data['quantity']=$data['quantity']+1;
        endif;
        unset($data['btn']);
        return $data;
        if (Cart::has($data['id'])):
            Cart::update($data['id'],[
                'quantity'=>$data['quantity']
            ]);
            return response(['status'=>'success']);
            else:
            return response(['status'=>'error',404]);
            endif;
    }
}
