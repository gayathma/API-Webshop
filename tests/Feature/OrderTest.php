<?php

namespace Tests\Feature;

use App\Order;
use App\User;
use App\Customer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{

    public function testsOrderIsCreatedCorrectly()
    {
        $headers = $this->getHeaders();

        $order = [
            'customer_id' => 1
        ];

        $this->json('POST', '/api/orders', $order, $headers)
            ->assertStatus(200);
    }

    public function testsOrdersAreListedCorrectly()
    {
        $headers = $this->getHeaders();

        $this->json('GET', '/api/orders', [], $headers)
            ->assertStatus(200);
    }

    public function testsOrdeIsListedCorrectly()
    {
        $headers = $this->getHeaders();

        $this->json('GET', '/api/orders/1', [], $headers)
            ->assertStatus(200);
    }

    public function testsOrderProductIsAttachedCorrectly()
    {
        $headers = $this->getHeaders();

        $data = [
            'product_id' => 57
        ];

        $this->json('POST', '/api/orders/1/add', $data, $headers)
            ->assertStatus(200);
    }

    public function testsOrderIsUpdatedCorrectly()
    {
        $headers = $this->getHeaders();

        $data = [
            'customer_id' => 2,
            'payed' => 'n'
        ];

        $this->json('PUT', '/api/orders/1', $data, $headers)
            ->assertStatus(200);
    }

    public function testsOrderIsDeletedCorrectly()
    {
        $headers = $this->getHeaders();

        $this->json('DELETE', '/api/orders/1', [], $headers)
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
