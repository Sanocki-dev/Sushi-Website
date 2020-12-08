<?php
namespace App;

class Stats{
    public $item_id = null;
    public $times_ordered = 0;
    public $total_orders = 0;

    public function __construct()
    {
        $this->item_id = null;
        $this->times_ordered = 0;
    }

    public function add($id)
    {
        $storedItem = ['timesOrdered' => 0, 'item' => $id, 'percent' => 0];
        if ($this->item_id)
        {
            if (array_key_exists($id, $this->item_id))
            {
                $storedItem = $this->item_id[$id];
            }
        }
        $storedItem['timesOrdered']++;
        $storedItem['percent']++;
        $this->item_id[$id] = $storedItem;
    }
}