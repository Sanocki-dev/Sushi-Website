<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Stripe;
use DB;
use Stripe\StripeClient;
use App\Stats;
use App\Invoices;
use App\OrderedItems;
use App\MenuSection;
use App\MenuItems;
use App\Cart;
use App\User;
use App\Promotions;
use App\Order;
use App\CreditInfo;
use Cartalyst\Stripe\Api\Orders;
use Exception;
use Session;

class MenuController extends Controller
{
  
	public function change()
  {
  $user = auth()->user();
  
  if ($user->userType == 'A')
  $user->userType = 'C';
  else
  $user->userType = 'A';
  
  $user->save();
    return redirect()->home();
}


  public function index()
  {
    // $menu = MenuItems::all();
    // dd($menu[0]->menuIngredients->ingredients);
    return view('menu.index');
  }

  public function menu()
  {
    $menu = MenuItems::all();
    $sections = MenuSection::all();
    return view('menu.menu', compact('menu', 'sections'));
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
    return view('menu.orderMenu', ['items' => $cart->items, 'totalSum' => $cart->totalSum], compact('menuIDS', 'sectionIDS'));
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
    if ($promo != null) {
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
    if ($promo != null) {
      if (!array_key_exists($promo['item'], $cart->items)) {
        session()->forget('promotion');
      }
    }

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
    $oldCart = Session::get('cart');
    $cart = new Cart($oldCart);

    return view('menu.orderSummary', ['items' => $cart->items, 'totalDue' => $cart->totalDue, 'totalTax' => $cart->totalTax,], compact('promos'));
  }

  public function getCheckout()
  {
    if (!Session::has('cart')) {
      return view('menu.orderSummary');
    }
    $oldCart = Session::get('cart');
    $cart = new Cart($oldCart);

    $total = $cart->totalSum;
    return view('menu.checkout', compact('total'));
  }

  public function postCheckout(Request $request)
  {
    $promo = 0;

    if (session()->has('promotion')) {
      $promo = session()->get('promotion')['item_discount'];
    }

    try {
      $user = auth()->user();
      $oldCart = Session::get('cart');
      $cart = new Cart($oldCart);
      $total = number_format($cart->totalDue - $promo, 2);

      $charge = Stripe::charges()->create([
        'amount' => $total,
        'currency' => 'CAD',
        'source' => $request->stripeToken,
        'description' => 'Order',
        'receipt_email' => $user->email,
      ]);
    } catch (Exception $ex) {
      return back()->with('errors', $ex->getMessage());
    }

    $oldCart = Session::get('cart');
    $cart = new Cart($oldCart);

    // Create order
    $order = new Order;
    $order->pickup_date = \Carbon\Carbon::parse(request('date'))->toDateString();
    $order->pickup_time = \Carbon\Carbon::parse(request('time'))->toTimeString();
    $order->status = 'R';
    $order->save();

    // Create ordered items 
    foreach ($cart->items as $item) {
      $ordered = new OrderedItems;
      $ordered->order_id = $order->order_id;
      $ordered->menu_id = $item['item']->menu_id;
      $ordered->quantity = $item['qty'];
      $ordered->save();
    }

    // Create invoice for order
    $invoice = new Invoices;
    $invoice->user_id = $user->user_id;
    $invoice->order_id = $order->order_id;
    $invoice->amount = $total;
    $invoice->save();

    session()->put('cart', null);
    // Successful purchase
    return redirect()->route("order.status")->with('success', 'Your order has been placed!');
  }

  public function history()
  {
    $user = auth()->user()->user_id;
    $invoices = Invoices::where('user_id', $user)->get();
    // dd($invoices[0]->invoiceOrder->orderItems[0]->menuItem);
    return view('menu.history', compact('invoices'));
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
    $update->save();

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
    $orders = Order::where('status', '<>', 'C')->get()->sortBy('pickup_date');
    $ordered = OrderedItems::all();
    $invoices = Invoices::all();
    // dd($orders[0]->orderInvoice);

    return view('menu.currentOrders', compact('orders', 'ordered', 'invoices'));
  }

  public function currentOrder($id)
  {
    $currentOrder = Order::find($id);
    if ($currentOrder->status != 'C')
      $currentOrder->status = 'O';
    $currentOrder->save();

    $menu = MenuItems::all();
    $orders = OrderedItems::where('order_id', $id)->get();

    $customerStats = new Stats();
    $customer = Invoices::where('user_id', $currentOrder->orderInvoice->user_id)->get();
    
    $percent = 0;
    
    $invoiceCount = count($customer);
    
    foreach ($customer as $order) {
      $items = $order->invoiceOrder->orderItems;
      foreach ($items as $item) {
        $customerStats->add($item->menu_id);
        $percent = $customerStats->item_id[$item->menu_id]['timesOrdered'] / $invoiceCount;
        $customerStats->item_id[$item->menu_id]['percent'] = $percent;
      }
      $customerStats->times_ordered++;
    }

    $customerStats = $customerStats->item_id;
    $customerStats = collect($customerStats)->sortBy('percent')->reverse()->toArray();
    return view('menu.currentOrder', compact('currentOrder', 'orders', 'customerStats', 'menu'));
  }

  public function finishOrder($id)
  {
    $order = Order::find($id);
    if ($order->status != 'P')
    $order->status = 'C';
    $order->save();
    // dd($order->status);

    if (request('startdate') != null && request('enddate') != null && request('Discount') != null && request('promos') != null) {
      $itemPromos = request('promos');
      foreach ($itemPromos as $item) {
        $promo = new Promotions;
        $promo->user_id = $order->orderInvoice->user_id;
        $promo->menu_id = $item;
        $promo->start_date = request('startdate');
        $promo->end_date = request('enddate');
        $promo->discount = request('Discount');
        // $promo->code = str_random(5);
        $promo->save();
      }
    }
    
    $invoices = Invoices::all();
    $orders = OrderedItems::all();
  
    return redirect()->route('currentOrders', compact('invoices', 'orders'));
  }

  public function completeTransaction($id)
  {
    $order = Order::find($id);
    $order->status = 'P';
    $order->orderInvoice->paid = 1;
    $order->save();
    
    return redirect()->back();
  }

 public function pickup()
 {
  $orders = Order::where('status', '=', 'C')->get()->sortBy('pickup_time');
  $ordered = OrderedItems::all();
  $invoices = Invoices::all();
  return view('menu.pickup', compact('orders', 'ordered', 'invoices'));
 }

  public function salesReport()
  {
    $orders = Order::all();
    $items = MenuItems::all();

    return view('reports.salesReport', compact('orders', 'items'));
  }

  public function menuReport()
  {
    $orders = Order::all();
    $items = MenuItems::all();

    $byMonths = DB::table('tbl_orders')
            ->join('tbl_ordered_items', 'tbl_orders.order_id', '=', 'tbl_ordered_items.order_id')
            ->join('tbl_menu_items', 'tbl_menu_items.menu_id', '=', 'tbl_ordered_items.menu_id')
            ->select('tbl_orders.pickup_date','tbl_ordered_items.menu_id','tbl_menu_items.name', DB::raw('COUNT(tbl_ordered_items.menu_id) count'))
            ->groupBy(DB::raw('YEAR(tbl_orders.pickup_date), MONTH(tbl_orders.pickup_date), tbl_ordered_items.menu_id'))
            ->get();

    return view('reports.menuItemReport', compact('orders', 'items', 'byMonths'));
  }

  public function ingredientReport(Type $var = null)
  {
    $orders = Order::all();
    $items = MenuItems::all();

    $byMonths = DB::table('tbl_orders')
          ->join('tbl_ordered_items', 'tbl_orders.order_id', '=', 'tbl_ordered_items.order_id')
          ->join('tbl_menu_items', 'tbl_menu_items.menu_id', '=', 'tbl_ordered_items.menu_id')
          ->select('tbl_orders.pickup_date','tbl_ordered_items.menu_id','tbl_menu_items.name', DB::raw('COUNT(tbl_ordered_items.menu_id) count'))
          ->groupBy(DB::raw('YEAR(tbl_orders.pickup_date), MONTH(tbl_orders.pickup_date), tbl_ordered_items.menu_id'))
          ->get();

          return view('reports.ingredientReport', compact('orders', 'items', 'byMonths'));
  }

  public function orderPayment()
  {
    return view('menu.orderPayment');
  }
}
