<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Customer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Let's truncate our existing records to start from scratch.
        Product::truncate();
        Customer::truncate();
        
        $this->call(ProductsTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
    }
}
