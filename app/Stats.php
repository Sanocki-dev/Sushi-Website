<?php
namespace App;

// This is used to create percentages of customer orders 
class Stats{
    public $item_id = null;
    public $times_ordered = 0;
    public $total_orders = 0;

    // Constructor that creates the default item and times ordered
    public function __construct()
    {
        $this->item_id = null;
        $this->times_ordered = 0;
    }

    // Goes through the items being added to get the percentage
    public function add($id)
    {
        // Creates a new array of an item 
        $storedItem = ['timesOrdered' => 0, 'item' => $id, 'percent' => 0];

        // Checks if the item is not null
        if ($this->item_id)
        {
            // Checks if the item exists in the array 
            if (array_key_exists($id, $this->item_id))
            {
                // Adds the previous items information to the array
                $storedItem = $this->item_id[$id];
            }
        }
        
        // Increases the quantity 
        $storedItem['timesOrdered']++;
        $storedItem['percent']++;
        $this->item_id[$id] = $storedItem;
    }
}