<?php

namespace App\Http\Controllers;

use App\Suppliers;
use Illuminate\Http\Request;
use App\SupplierItems;

/**
 * Controller that handles Supplier interations
 */
class SuppliersController extends Controller
{
    /**
     * Returns a view with all the suppliers listed
     */
    public function index()
    {   
        $suppliers = Suppliers::all();
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Creates a new supplier to add to the Database
     */
    public function store()
    {
        // Validation for creating a new supplier
        $this->validate(request(), [
            'name' => 'required|unique:tbl_suppliers,name',
    		'phone',
            'email',
            'website',
            'address',
            'comments',
            ]);
            
        // Adds supplier to the database
        Suppliers::create(request(['name', 'phone', 'email', 'website', 'address', 'comments']));
        
        // Success message and redirect
        session()->flash('success',"Supplier added to list!");
    	return redirect('suppliers');
    }

    /**
     * Deletes a supplier from the database
     */
    public function delete(Request $request)
    {
        // Uses the supplier id to find the supplier to delete
        $id = $request->id;
        $supplier = Suppliers::find($id);
        
        // Tries to delete the supplier 
        if ($supplier->delete()) {
            SupplierItems::where('supplier_id','=',$supplier->supplier_id)->delete();
            session()->flash('success', "Supplier has been removed.");
          }
    
        return redirect('/suppliers');
    }

    /**
     * Find a specific supplier to show their items
     */
    public function find($id)
    {
        // Uses the id to find the supplier and their items
        $supplier = Suppliers::find($id);
        $supplierItems = $supplier->supplierItems;
        return view("suppliers.find", compact('supplier', 'supplierItems'));
    }
}
