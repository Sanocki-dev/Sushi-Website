<?php

namespace App\Http\Controllers;

use App\Ingredients;
use Illuminate\Http\Request;
use App\SupplierItems;
use App\Suppliers;

/**
 * Controller that handles all information and operations for Ingredients
 */
class IngredientsController extends Controller
{
    /**
     * Default for ingredients controller will show all ingredients sorted by name
     */
    public function index()
    {
        // Gets all supplierItems and ingredients  sorts them by name   
        $ingredients = SupplierItems::all();
        $suppliers = Suppliers::all()->sortBy('name');
        $allIngredients = Ingredients::all()->sortBy('name');

        return view("ingredients.index",compact('ingredients','suppliers','allIngredients'));
    }

    /**
     * Storing a new ingredient in the database
     */
    public function Store()
    {
        // Creates the new item using request from form
        SupplierItems::create([
            'supplier_id' => request('suppliers'),
            'ingredient_id' => request('ingredients'),
            'price' => request('Price'),
            'details' => request('Details'),
          ]);
      
        // Successful add message and return to main page
        session()->flash('success', "Item has been added to the menu.");
        return back();
    }

    /**
     * Delete an ingredient from the database
     */
    public function delete(Request $request)
    {
        // Deletes the item using the form request
        SupplierItems::where([['supplier_id', $request->supplier_id],['ingredient_id', $request->ingredient_id]])->delete(); 
        
        // Successful add message and return to main page
        session()->flash('success', "Ingredient has been removed.");
        return back();
    }

    // Creates a many to many relationship between Ingredients and supplier
    public function supplier()
    {
    	return $this->hasMany('App\Suppliers', 'supplier_id');
    }
}
