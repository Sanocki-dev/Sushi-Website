<?php

namespace App\Http\Controllers;

use App\Suppliers;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    public function index()
    {   
        $suppliers = Suppliers::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function store()
    {
        $this->validate(request(), [
            'name',
    		'phone',
            'email',
            'website',
            'address',
            'comments',
            ]);
            
        $supplier = Suppliers::create(request(['name', 'phone', 'email', 'website', 'address', 'comments']));
        // dd($supplier);
        
    	return redirect('suppliers');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $supplier = Suppliers::find($id);

        if ($supplier->delete()) {
            session()->flash('success', "Supplier has been removed.");
          }
    
          return redirect('/suppliers');

    }
}
