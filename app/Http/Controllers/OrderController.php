<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Transformers\OrderTransformer;
use Illuminate\Http\Request;
use Omnipay\Omnipay;
use App\Order;
use App\Product;
use App\Customer;

class OrderController extends BaseController
{
	/**
     *
     * @var \App\Transformers\OrderTransformer
     */
	protected $orderTransformer;

	function __construct(OrderTransformer $orderTransformer)
	{
		$this->orderTransformer = $orderTransformer;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate(10);

        return $this->sendResponse($this->orderTransformer->transformCollection($orders->all()),
         	'Orders retrieved successfully.');
    }

	/**
     * Display the specified resource.
     *
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        if (!$order) {
            return $this->sendError('Order not found.');
        }

        return $this->sendResponse($this->orderTransformer->transform($order),
        	'Order retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	if (!$request->get('customer_id')) {
            return $this->sendError('Customer is required');
        }

        $customer = Customer::find($request->get('customer_id'));

        if (!$customer) {
            return $this->sendError('Customer not found.');
        }

        $order = Order::create($request->all());

        return $this->sendResponse($this->orderTransformer->transform($order),
        	'Order created successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
    	if (!$request->get('customer_id')) {
            return $this->sendError('Customer is required');
        }

        $customer = Customer::find($request->get('customer_id'));

        if (!$customer) {
            return $this->sendError('Customer not found.');
        }

        $order->update($request->all());

        return $this->sendResponse($this->orderTransformer->transform($order),
        	'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function delete(Order $order)
    {
    	if (!$order) {
            return $this->sendError('Order not found.');
        }

        $order->delete();

        return $this->sendResponse($this->orderTransformer->transform($order),
        	'Order deleted successfully.');
    }

    /**
     * Attach product to an order
     *
 	 * @param  \Illuminate\Http\Request  $request
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function attachProduct(Request $request, Order $order)
    {
        if (!$order) {
            return $this->sendError('Order not found.');

        } else if ($order->payed === 'y') {
            return $this->sendError('Cannot add more products as the order is already payed.');

        }else if (!$request->get('product_id')) {
            return $this->sendError('Product not found.');

        }

        $product = Product::find($request->get('product_id'));

        if (!$product) {
            return $this->sendError('Product not found.');
        }

        $hasProduct = $order->products()->where('product_id', $product->id)->first();
        //If the product is already exist for this order just update the quantity and the price

        if ($hasProduct) {
        	$quantity = $hasProduct->pivot->quantity;
        	$price = $hasProduct->pivot->price;
        	
        	$order->products()->updateExistingPivot($product, [
        			'quantity' => $quantity + 1,
        			'price' => $price + $product->price,
        		]);

        } else {
        	$order->products()->attach($product, [
				'price' => $product->price
			]);
        }
		
        return $this->sendResponse($this->orderTransformer->transform($order),
        	'Product attached successfully.');
    }

    /**
     * Make the payment to an existing order
     *
 	 * @param  \Illuminate\Http\Request  $request
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function payOrder(Request $request, Order $order)
    {
        if (!$order) {
            return $this->sendError('Order not found.');

        } else if ($order->payed === 'y') {
            return $this->sendError('This order is already payed.');

        }

		$gateway = Omnipay::create('\App\Omnipay\SuperPay\Gateway');
		$gateway->setEmail($order->customer->email);
		$gateway->setOrder($order->id);
		$gateway->setValue(number_format($order->products->sum('pivot.price'), 2));

		$response = $gateway->purchase()->send();
		if (!$response->isSuccessful()) {
			return $this->sendError('Insufficient Funds');
		}

		//if payment is success update the order as payed
		$order->update([
				'payed' => 'y'
			]);

        return $this->sendResponse($response,
        	'Payment successful.');
    }
}
