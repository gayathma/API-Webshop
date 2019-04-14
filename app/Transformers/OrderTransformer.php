<?php

namespace App\Transformers;

class OrderTransformer extends Transformer
{

    /**
    * Transform the order
    *
    * @param $order
    * @return Array 
    */
    public function transform($order)
    {
        return [

            'id' => $order['id'],
            'customer_id' => $order['customer_id'],
            'payed' => $order['payed'],
            'products' => $order->products->map(function ($product) {
                    return [
                        'product_id' => $product->id,
                        'product_name' => $product->product_name,
                        'quantity' => $product->pivot->quantity,
                        'price' => number_format($product->pivot->price, 2)
                    ];
                }),
            'amount' => number_format($order->products->sum('pivot.price'), 2),
            'created_date' => date('Y-m-d H:i:s', strtotime($order['created_at'])),
            'updated_date' => date('Y-m-d H:i:s', strtotime($order['updated_at']))
        ];

    }
}