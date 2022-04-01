<?php

namespace App\Http\Controllers;

use App\Promotions;
use App\Cart;
use Illuminate\Http\Request;

/**
 * Handles all interactions with the promotions table
 */
class PromotionsController extends Controller
{
    // Use a promotion
    public function store(Request $request)
    {
        // Looks at the session to see if a promotion is being used
        if (session()->get('promotion') == null) {
            // Gets the promotion code
            $promotion = Promotions::where('code', $request->promoCode)->first();
            
            // Checks if the code used is assigned to the user
            if (!$promotion || $promotion->user_id != auth()->user()->user_id) {
                // Redirect with errors
                return redirect()->route("checkout.summary")->withErrors('Invalid Promotion Code! Try again.');
            }

            // Goes through the cart and gets the promotion item details
            $items = session()->get('cart')->items;
            $name = $promotion->menu->name;

            // Tries to get index of item 
            $isIndex = array_search($promotion->menu_id, array_keys($items));

            // Checks if the item exists in the cart
            if ($isIndex !== false) {

                // Creates the session with the promotion details
                session()->put('promotion', [
                    'item' => $promotion->menu_id,
                    'code' => $promotion->code,
                    'item_discount' => number_format($promotion->discount(session()->get('cart')->items[$promotion->menu_id]['price']), 2),
                ]);

                // Updates the cart and adds the promo
                $oldCart = session()->get('cart');
                $oldCart->totalSum -= session()->get('promotion')['item_discount'];
                $oldCart->addPromo();

                //dd($items[$promotion->menu_id]['price']);
                return redirect()->route("checkout.summary")->with('success', 'Successfully added promotion!');
            } 
            // Promotion item not in cart
            else {
                return redirect()->route("checkout.summary")->withErrors('Dont have ' . $name . ' in your cart!');
            }
        }
        // Promotion already being used 
        else {
            return redirect()->route("checkout.summary")->withErrors('Promotion already in effect!');
        }
    }

    /**
     *  Removes the promotion from the cart
     */
    public function destroy()
    {
        // Removes the pomotion from the cart
        $oldCart = session()->get('cart');
        $oldCart->totalSum += session()->get('promotion')['item_discount'];
        $oldCart->addPromo();

        // Session forgets that there was a promotion
        session()->forget('promotion');
        return redirect()->route("checkout.summary")->with('success', 'Successfully removed promotion!');
    }
}
