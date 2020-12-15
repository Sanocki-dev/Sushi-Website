<?php

namespace App\Http\Controllers;

use App\Ingredients;
use Illuminate\Http\Request;
use App\SupplierItems;
use App\Suppliers;

class IngredientsController extends Controller
{
    public function index()
    {
        $ingredients = SupplierItems::all();
        $suppliers = Suppliers::all()->sortBy('name');
        $allIngredients = Ingredients::all()->sortBy('name');
        return view("ingredients.index",compact('ingredients','suppliers','allIngredients'));
    }

    public function Store()
    {
        SupplierItems::create([
            'supplier_id' => request('suppliers'),
            'ingredient_id' => request('ingredients'),
            'price' => request('Price'),
            'details' => request('Details'),
          ]);
      
        session()->flash('success', "Item has been added to the menu.");
        return back();
    }

    public function delete(Request $request)
    {
        $delete = SupplierItems::where([['supplier_id', $request->supplier_id],['ingredient_id', $request->ingredient_id]])->delete(); 
            session()->flash('success', "Ingredient has been removed.");
            return back();
    }

    public function supplier()
    {
    	return $this->hasMany('App\Suppliers', 'supplier_id');
    }
}
