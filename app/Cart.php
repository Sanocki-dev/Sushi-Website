<?php
// This file is for the customers order 

namespace App;

// Customers cart will show items their quantity and totals for pricing
class Cart{
    public $items = null;
    public $totalQty = 0;
    public $totalSum = 0;
    public $totalTax = 0;
    public $totalDue = 0;

    // Paramaterized constructor for creating a new cart using the using the old cart
    public function __construct($oldCart)
    {
        // Checks if there is an old cart to use
        if ($oldCart) 
        {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalSum = $oldCart->totalSum;
            $this->totalTax = $oldCart->totalTax;
            $this->totalDue = $oldCart->totalDue;
        }
    }

    // Adds items to cart using the id
    public function add($item , $id)
    {
        // Creates an array for the new item to be added
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];

        // Checks if there is an item to add
        if ($this->items)
        {
            // Checks the array to see if item exists in list
            if (array_key_exists($id, $this->items))
            {
                // Adds the specific item to the array instead of the default
                $storedItem = $this->items[$id];
            }
        }
        
        // Increases the totals
        $storedItem['qty']++;
        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty++;
        $this->totalSum += $item->price;
        $this->totalTax = $this->totalSum * 0.13;
        $this->totalDue = $this->totalSum * 1.13;
    }
    
    // Adds promotion codes to the totals 
    public function addPromo()
    {
        $this->totalTax = $this->totalSum * 0.13;
        $this->totalDue = $this->totalSum * 1.13;
    }

    // Deletes items from cart using the item and its id
    public function delete($item, $id)
    {
        // Creates an array for the new item to be added
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];

        // Checks if there is an item to add
        if ($this->items)
        {
            if (array_key_exists($id, $this->items))
            {
                // Adds the specific item to the array instead of the default
                $storedItem = $this->items[$id];
            }
        }
        
        // Decreases the totals for the item being removed
        $storedItem['qty']--;
        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty--;
        $this->totalSum -= $item->price;
        $this->totalTax = $this->totalSum * 0.13;
        $this->totalDue = $this->totalSum * 1.13;

        // If the items quantity is no more 
        if ($storedItem['qty'] <= 0)
        {
            // Remove the item from the list
            unset($this->items[$id]);
        }
    }
}