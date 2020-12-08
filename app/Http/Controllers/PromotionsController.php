<?php

namespace App\Http\Controllers;

use App\Promotions;
use App\Cart;
use Illuminate\Http\Request;

class PromotionsController extends Controller
{
    public function store(Request $request)
    {
        $promotion = Promotions::where('code', $request->promoCode)->first();
        if (!$promotion || $promotion->user_id != auth()->user()->user_id) {
            return redirect()->route("checkout.summary")->withErrors('Invalid Promotion Code! Try again.');
        }

        $items = session()->get('cart')->items;
        $name = $promotion->menu->name;
        $isIndex = array_search($promotion->menu_id, array_keys($items));
        
        if ($isIndex !== false) {
            session()->put('promotion', [
                'item' => $promotion->menu_id,
                'code' => $promotion->code,
                'item_discount' => number_format($promotion->discount(session()->get('cart')->items[$promotion->menu_id]['price']), 2),
            ]);
            return redirect()->route("checkout.summary")->with('success', 'Successfully added promotion!');
        } else {
            return redirect()->route("checkout.summary")->withErrors('Dont have ' . $name . ' in your cart!');
        }
    }

    public function destroy()
    {
            session()->forget('promotion');
            return redirect()->route("checkout.summary")->with('success', 'Successfully removed promotion!');

    }
}
