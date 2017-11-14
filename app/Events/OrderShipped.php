<?php

namespace App\Events;

class OrderShipped
{
    public $orderId;

    /**
     * Create a new event instance.
     *
     * @param $orderId
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }
}
