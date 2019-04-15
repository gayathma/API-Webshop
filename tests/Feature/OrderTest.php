<?php

namespace Tests\Feature;

use App\Order;
use App\User;
use App\Customer;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{

    public function testsOrderIsCreatedCorrectly()
    {
        $headers = $this->getHeaders();

        $customer = factory(Customer::class)->create();

        $order = [
            'customer_id' => $customer->id
        ];

        $this->json('POST', '/api/orders', $order, $headers)
            ->assertStatus(200);
    }

    public function testsOrdersAreListedCorrectly()
    {
        $headers = $this->getHeaders();

        $order = factory(Order::class)->create();

        $this->json('GET', '/api/orders', [], $headers)
            ->assertStatus(200);
    }

    public function testsOrdeIsListedCorrectly()
    {
        $headers = $this->getHeaders();

         $order = factory(Order::class)->create();

        $this->json('GET', '/api/orders/'.$order->id, [], $headers)
            ->assertStatus(200);
    }

    public function testsOrderProductIsAttachedCorrectly()
    {
        $headers = $this->getHeaders();

        $order = factory(Order::class)->create();
        $product = factory(Product::class)->create();

        $data = [
            'product_id' => $product->id
        ];

        $this->json('POST', '/api/orders/'. $order->id .'/add', $data, $headers)
            ->assertStatus(200);
    }

    public function testsOrderIsUpdatedCorrectly()
    {
        $headers = $this->getHeaders();

        $order = factory(Order::class)->create();
        $customer = factory(Customer::class)->create();

        $data = [
            'customer_id' => $customer->id,
            'payed' => 'n'
        ];

        $this->json('PUT', '/api/orders/'.$order->id, $data, $headers)
            ->assertStatus(200);
    }

    public function testsOrderIsDeletedCorrectly()
    {
        $headers = $this->getHeaders();

        $order = factory(Order::class)->create();

        $this->json('DELETE', '/api/orders/'.$order->id, [], $headers)
            ->assertStatus(200);
    }

    private function getHeaders()
    {

        $user = factory('App\User')->create();
        $token = $user->createToken('Personal Access Token')->accessToken;
        return [
            'Authorization' => "Bearer $token"
        ];

    }
}
