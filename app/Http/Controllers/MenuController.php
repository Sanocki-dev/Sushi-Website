<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Invoices;
use App\OrderedItems;
use App\MenuSection;
use App\MenuItems;
use App\Cart;
use Session;
use App\PaymentType;
use App\CreditInfo;

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

  public function addToCart(Request $request, $id)
  {
    $item = MenuItems::find($id);
    $oldCart = Session::has('cart') ? Session::get('cart') : null;
    $cart = new Cart($oldCart);
    $cart->add($item, $item->menu_ID);

    $request->session()->put('cart', $cart);

    $sectionIDS = MenuSection::all();
    $menuIDS = MenuItems::all();

    return redirect()->route('menu.orderMenu', compact('menuIDS', 'sectionIDS'));
  }

  public function orderSummary()
  {
    if (!Session::has('cart')) {
      return view('menu.orderSummary');
    }
    $user = auth()->user()->id;
    $credit = CreditInfo::where('user_id',$user)->get();

    $oldCart = Session::get('cart');
    $cart = new Cart($oldCart);
    return view('menu.orderSummary', ['items' => $cart->items, 'totalPrice' => $cart->totalPrice], compact('credit'));
  }

  public function getCheckout()
  {
    if (!Session::has('cart')) {
      return view('menu.orderSummary');
    }
    $oldCart = Session::get('cart');
    $cart = new Cart($oldCart);
    $total = $cart->totalPrice;
    return view('menu.checkout', compact('total'));
  }

  public function postCheckout()
  {
    if (!Session::has('cart')) {
      return view('menu.orderSummary');
    }
    $user = auth()->user()->id;

    $credit = CreditInfo::where('user_id',$user)->first();
    
    if (request('saveCard') == 1)
    {
      if ($credit == null)
      {
        CreditInfo::create([
          'user_id' => $user,
          'pay_id' => request('paymentMethod'),
          'name' => request('cc-name'),
          'number' => request('cc-number'),
          'exp_Date' => \Carbon\Carbon::parse(request('cc-expiration'))->endOfMonth()->toDateString()
          ]);
        }
        else
        {
          // dd($credit->paymentType->first()->pay_id);
          $credit->pay_id = request('paymentMethod');
          $credit->name = request('cc-name');
          $credit->number = request('cc-number');
          $credit->exp_Date = \Carbon\Carbon::parse(request('cc-expiration'))->endOfMonth()->toDateString();

          $credit->save();
        }
    }

    $oldCart = Session::get('cart');
    $cart = new Cart($oldCart);
    $total = $cart->totalPrice;

    Invoices::create([
      'pay_ID' => request('paymentMethod'),
      'user_id' => auth()->id(),
      'date' => request('date'),
      'time' => request('time'),
      'amount' => number_format($total,2),
    ]);

    session()->put('cart', null);
    return redirect()->route('home');
  }

  public function history()
  {

    $user = auth()->user()->id;
    $history = OrderedItems::all();
    $menu = MenuItems::all();
    $invoices = Invoices::where('id', $user)->get();

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
    Invoices::create([
      'pay_ID' => request('payment_type'),
      'id' => auth()->id(),
      'date' => request('date'),
      'time' => request('time'),
      'amount' => request('pay'),
    ]);

    $menu_items = request('menu_id');
    $amount = request('amount');
    $invoice = Invoices::select('invoice_ID')->orderBy('invoice_ID', 'desc')->first();
    $invoice = substr($invoice, 14);
    $invoice = substr($invoice, -10, 2);

    for ($i = 0; $i < count($menu_items); $i++) {
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

    if ($menu_item->delete()) {
      session()->flash('success', "$menu_item->name has been removed from the menu.");
    }

    return redirect('/editMenu');
  }

  public function saveEdit($id)
  {
    $this->validate(request(), [
      'name' => 'required|max:255',
      'price' => 'required'
    ]);

    $menu_item = MenuItems::find($id);

    $menu_item->section_ID = request('section');
    $menu_item->name = request('name');
    $menu_item->price = request('price');

    if ($menu_item->save()) {
      session()->flash('success', 'Item Successfully updated');
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
