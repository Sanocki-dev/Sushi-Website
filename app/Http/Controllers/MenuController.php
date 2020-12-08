<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Stats;
use App\Invoices;
use App\OrderedItems;
use App\MenuSection;
use App\MenuItems;
use App\Cart;
use App\User;
use Session;
use App\Promotions;
use App\CreditInfo;

class MenuController extends Controller
{
  public function index()
  {
    return view('menu.index');
  }

  public function menu()
  {
    $menu = MenuItems::all();
    $sections = MenuSection::all();
    return view('menu.menu', compact('menu','sections'));
  }

  public function orderMenu()
  {
    $menuIDS = MenuItems::all();
    $sectionIDS = MenuSection::all();
    if (!Session::has('cart')) {
      return view('menu.orderMenu', compact('menuIDS', 'sectionIDS'));
    }
    $oldCart = Session::get('cart');
    $cart = new Cart($oldCart);
    // dd($cart);
    return view('menu.orderMenu', ['items' => $cart->items, 'totalPrice' => $cart->totalPrice], compact('menuIDS', 'sectionIDS'));
  }

  public function addToCart(Request $request, $id)
  {
    $item = MenuItems::find($id);
    $oldCart = Session::has('cart') ? Session::get('cart') : null;
    $cart = new Cart($oldCart);
    $cart->add($item, $item->menu_id);

    $request->session()->put('cart', $cart);

    $sectionIDS = MenuSection::all();
    $menuIDS = MenuItems::all();

    return redirect()->route('menu.orderMenu', compact('menuIDS', 'sectionIDS'));
  }

  public function orderStatus()
  {
    $orders = Invoices::where('user_id', auth()->user()->user_id)->get()->sortBy('pickup_date')->reverse();
    return view('menu/orderStatus', compact('orders'));
  }

  public function removeFromOrder(Request $request)
  {
    $item = MenuItems::find($request->id);
    $promo = Session::has('promotion') ? Session::get('promotion') : null;
    $oldCart = Session::has('cart') ? Session::get('cart') : null;
    $cart = new Cart($oldCart);
    $cart->delete($item, $item->menu_id);

    $request->session()->put('cart', $cart);
    if ($promo != null)
    {
      if (!array_key_exists($promo['item'], $cart->items)) {
        session()->forget('promotion');
      }
    }
    return redirect()->route("menu.orderMenu")->with('success', 'Successfully removed item!');
  }
  
  public function removeFromCart(Request $request)
  {
    $item = MenuItems::find($request->id);
    $promo = Session::has('promotion') ? Session::get('promotion') : null;
    $oldCart = Session::has('cart') ? Session::get('cart') : null;
    $cart = new Cart($oldCart);
    $cart->delete($item, $item->menu_id);

    $request->session()->put('cart', $cart);
    if ($promo != null)
    {
    if (!array_key_exists($promo['item'], $cart->items)) {
      session()->forget('promotion');
    }}

    return redirect()->route("checkout.summary")->with('success', 'Successfully removed item!');
  }

  public function orderSummary()
  {
    if (!Session::has('cart')) {
      $menuIDS = MenuItems::all();
      $sectionIDS = MenuSection::all();
      return view('menu.orderMenu', compact('menuIDS', 'sectionIDS'));
    }

    $user = auth()->user()->user_id;
    $promos = Promotions::where('user_id', $user)->get();
    $credit = CreditInfo::where('user_id', $user)->get();
    $oldCart = Session::get('cart');
    $cart = new Cart($oldCart);

    return view('menu.orderSummary', ['items' => $cart->items, 'totalPrice' => $cart->totalPrice], compact('credit', 'promos'));
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
    $user = auth()->user()->user_id;

    $credit = CreditInfo::where('user_id', $user)->first();
    // dd(request('saveCard'));
    if (request('saveCard') == 1) {
      if ($credit == null) {
        $card = new CreditInfo;
        $card->user_id = $user;
        $card->pay_id = request('paymentMethod');
        $card->name = request('cc-name');
        $card->number = request('cc-number');
        $card->exp_Date = \Carbon\Carbon::parse(request('cc-expiration'))->endOfMonth()->toDateString();
        $card->save();
      } else {
        $credit->pay_id = request('paymentMethod');
        $credit->name = request('cc-name');
        $credit->number = request('cc-number');
        $credit->exp_Date = \Carbon\Carbon::parse(request('cc-expiration'))->endOfMonth()->toDateString();
        $credit->save();
      }
    }

    $oldCart = Session::get('cart');
    $cart = new Cart($oldCart);
    $total = number_format($cart->totalPrice, 2);

    $invoice = new Invoices;
    $invoice->pay_id = request('paymentMethod');
    $invoice->user_id = $user;
    $invoice->status = 'R';
    $invoice->pickup_date = \Carbon\Carbon::parse(request('date'))->toDateString();
    $invoice->pickup_time = \Carbon\Carbon::parse(request('time'))->toTimeString();
    $invoice->amount = $total;

    $invoice->save();

    $invoice = Invoices::select('invoice_id')->orderBy('invoice_id', 'desc')->first()->invoice_id;

    foreach ($cart->items as $item) {
      $order = new OrderedItems;
      $order->invoice_id = $invoice;
      $order->menu_id = $item['item']->menu_id;
      $order->quantity = $item['qty'];
      $order->save();
    }

    session()->flash('success', "Your order has been placed!");
    session()->put('cart', null);
    return redirect()->route('home');
  }

  public function history()
  {
    $user = auth()->user()->user_id;
    $history = OrderedItems::all();
    $menu = MenuItems::all();
    $invoices = Invoices::where('user_id', $user)->get();

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

    $user = auth()->user()->user_id;
    $update = User::where('user_id', $user)->first();
    $update->name = request('name');
    $update->phone = request('phone');
    $update->promotions = request('promotions');
    $update->save();

    $credit = CreditInfo::where('user_id', $user)->first();
    // dd(request('saveCard'));
    if (request('saveCard') == 1) {
      if ($credit == null) {
        $card = new CreditInfo;
        $card->user_id = $user;
        $card->pay_id = request('paymentMethod');
        $card->name = request('cc-name');
        $card->number = request('cc-number');
        $card->exp_Date = \Carbon\Carbon::parse(request('cc-expiration'))->endOfMonth()->toDateString();
        $card->save();
      } else {
        $credit->pay_id = request('paymentMethod');
        $credit->name = request('cc-name');
        $credit->number = request('cc-number');
        $credit->exp_Date = \Carbon\Carbon::parse(request('cc-expiration'))->endOfMonth()->toDateString();
        $credit->save();
      }
    }

    return redirect()->home();
  }

  public function orderItems()
  {
    Invoices::create([
      'pay_id' => request('payment_type'),
      'id' => auth()->id(),
      'pickup_date' => request('date'),
      'pickup_time' => request('time'),
      'amount' => request('pay'),
    ]);

    $menu_items = request('menu_id');
    $amount = request('amount');
    $invoice = Invoices::select('invoice_id')->orderBy('invoice_id', 'desc')->first();
    $invoice = substr($invoice, 14);
    $invoice = substr($invoice, -10, 2);

    for ($i = 0; $i < count($menu_items); $i++) {
      $order = new OrderedItems;
      $order->invoice_id = $invoice;
      $order->menu_id = $menu_items[$i];
      $order->quantity = $amount[$i];
      $order->save();
    }


    return view('menu.index');
  }

  public function editMenu()
  {
    $menu_item = MenuItems::all()->sortBy('section_id');
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
      'section_id' => request('section'),
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

    $menu_item->section_id = request('section');
    $menu_item->name = request('name');
    $menu_item->price = request('price');

    if ($menu_item->save()) {
      session()->flash('success', 'Item Successfully updated');
    }

    return redirect('/editMenu');
  }

  public function currentOrders()
  {
    $invoices = Invoices::all();
    $orders = OrderedItems::all();

    return view('menu.currentOrders', compact('invoices', 'orders'));
  }

  public function currentOrder($id)
  {
    $invoices = Invoices::find($id);
    if ($invoices->status != 'C')
      $invoices->status = 'O';
    $invoices->save();
    $menu = MenuItems::all();
    $orders = OrderedItems::where('invoice_id', $id)->get();
    $customerStats = new Stats();
    $customer = Invoices::where('user_id', $invoices->user_id)->get();

    $percent = 0;
    $invoiceCount = count($customer);

    foreach ($customer as $order) {
      $items = $order->orderedItems;
      foreach ($items as $item) {
        $customerStats->add($item->menu_id);
        $percent = $customerStats->item_id[$item->menu_id]['timesOrdered'] / $invoiceCount;
        $customerStats->item_id[$item->menu_id]['percent'] = $percent;
      }
      $customerStats->times_ordered++;
    }

    $customerStats = $customerStats->item_id;
    $customerStats = collect($customerStats)->sortBy('percent')->reverse()->toArray();
    // dd($invoices);
    return view('menu.currentOrder', compact('invoices', 'orders', 'customerStats', 'menu'));
  }

  public function finishOrder($id)
  {
    $invoice = Invoices::find($id);
    $invoice->status = 'C';
    $invoice->save();
    if (request('startdate') != null && request('enddate') != null && request('Discount') != null && request('promos') != null) {
      $itemPromos = request('promos');
      foreach ($itemPromos as $item) {
        $promo = new Promotions;
        $promo->user_id = $invoice->user_id;
        $promo->menu_id = $item;
        $promo->start_date = request('startdate');
        $promo->end_date = request('enddate');
        $promo->discount = request('Discount');
        $promo->code = str_random(5);
        $promo->save();
      }
    }


    $invoices = Invoices::all();
    $orders = OrderedItems::all();
    return redirect()->route('currentOrders', compact('invoices', 'orders'));
  }

  public function salesReport()
  {
    $invoices = Invoices::where('status', 'C')->get();
    $orders = OrderedItems::all();
    return view('menu.salesReport', compact('invoices', 'orders'));
  }

  public function orderPayment()
  {
    return view('menu.orderPayment');
  }
}
