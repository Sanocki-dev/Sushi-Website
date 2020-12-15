<?php
namespace App;

class Cart{
    public $items = null;
    public $totalQty = 0;
    public $totalSum = 0;
    public $totalTax = 0;
    public $totalDue = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) 
        {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalSum = $oldCart->totalSum;
            $this->totalTax = $oldCart->totalTax;
            $this->totalDue = $oldCart->totalDue;
        }
    }

    public function add($item , $id)
    {
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
        if ($this->items)
        {
            if (array_key_exists($id, $this->items))
            {
                $storedItem = $this->items[$id];
            }
        }
        
        $storedItem['qty']++;
        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty++;
        $this->totalSum += $item->price;
        $this->totalTax = $this->totalSum * 0.13;
        $this->totalDue = $this->totalSum * 1.13;
    }
    
    public function addPromo($item, $id, $promo)
    {

    }

    public function delete($item, $id)
    {
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
        if ($this->items)
        {
            if (array_key_exists($id, $this->items))
            {
                $storedItem = $this->items[$id];
            }
        }
        
        $storedItem['qty']--;
        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty--;
        $this->totalSum -= $item->price;
        $this->totalTax = $this->totalSum * 0.13;
        $this->totalDue = $this->totalSum * 1.13;

        if ($storedItem['qty'] <= 0)
        {
            unset($this->items[$id]);
        }
    }
}