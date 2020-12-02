<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\tbl_invoice;
use App\OrderedItems;
use App\MenuSection;
use App\MenuItems;
use App\PaymentType;
use Hamcrest\Core\HasToString;

class MenuController extends Controller
{
    public function index()
    {
    	return view('menu.index');
    } 

   	public function menu()
   	{
   		return view('menu.menu');
   	}

   	public function orderMenu()
   	{

      $menuIDS = MenuItems::all();

      $sectionIDS = MenuSection::all();

   		return view('menu.orderMenu', compact('menuIDS', 'sectionIDS'));
     }
     
     public function orderSummary()
     {
        $menu_items = MenuItems::all();
        $input = request()->all();
        $ordered = $input['amount'];  
        return view('menu.orderSummary',compact('ordered', 'menu_items'));
     }

   	public function history()
   	{

      $user = auth()->user()->id;
      $history = OrderedItems::all();
      $menu = MenuItems::all();
      $invoices = tbl_invoice::where('id', $user)->get();

   		return view('menu.history', compact('invoices', 'history', 'menu'));
   	}

    public function show()
    {
      return view('menu.orderHistory');
    }

    public function account()
    {
      return view('menu.account');
    }

    public function store()
    {
      $this->validate(request(), [

        'email' => 'required|email',

        'password' => 'required'

      ]);

      auth()->user()->update(request(['email', 'password', 'name', 'phone', 'promotions']));

      return redirect()->home();
    }

    public function orderItems()
    {
      tbl_invoice::create([
        'pay_ID' => request('payment_type'), 
        'id' => auth()->id(), 
        'date' => request('date'), 
        'time' => request('time'),
        'amount' => request('pay'),
        ]);

        $menu_items = request('menu_id');
        $amount = request('amount');
        $invoice = tbl_invoice::select('invoice_ID')->orderBy('invoice_ID', 'desc')->first();
        $invoice = substr($invoice,14);
        $invoice = substr($invoice,-10,2);

        for ($i = 0;$i< count($menu_items);$i++){
            $order = new OrderedItems;
            $order->invoice_ID = $invoice;
            $order->menu_ID = $menu_items[$i];
            $order->quantity = $amount[$i];
            $order->save();
        }
      return view('menu.index');
    }

    public function editMenu()
    {
      $menu_item = MenuItems::all()->sortBy('section_ID');;
      $sections = MenuSection::all();
      return view('menu.editMenu', compact('menu_item', 'sections'));
    }

    public function editMenuItem($id)
    {
      $menu_item = MenuItems::find($id);
      $sections = MenuSection::all();
      return view('menu.editMenuItem', compact('menu_item', 'sections'));
    }

    public function addItem()
    {
      MenuItems::create([
        'section_ID' => request('section'),
        'name' => request('name'), 
        'price' => request('price'),
        ]);

          session()->flash('success', "Item has been added to the menu.");

        return redirect('/editMenu');
    }

    public function deleteItem($id)
    {
      $menu_item = MenuItems::find($id);

      if ($menu_item->delete())
      {
        session()->flash('success', "$menu_item->name has been removed from the menu.");
      }
      
        return redirect('/editMenu');
    }

    public function saveEdit($id)
    {
      $this->validate(request(),[
        'name' => 'required|max:255',
        'price' => 'required'
      ]);

      $menu_item = MenuItems::find($id);

      $menu_item->section_ID = request('section');
      $menu_item->name = request('name');
      $menu_item->price = request('price');
        
      if ($menu_item->save())
      {
        session()->flash('success','Item Successfully updated');
      }
      
        return redirect('/editMenu');
    }

    public function currentOrders()
    {
      return view('menu.currentOrders');
    }

    public function salesReport()
    {
      return view('menu.salesReport');
    }

    public function orderPayment()
    {
      return view('menu.orderPayment');
    }
}
