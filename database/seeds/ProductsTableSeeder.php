<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use League\Csv\Statement;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

	  	$file = public_path().'/csv/products.csv';
        $reader = Reader::createFromPath($file);
        //skip the header
        $records = (new Statement())->offset(1)->process($reader);
        
        $count = 0;
       	foreach ($records->getRecords() as $record) {

        	// return false if there is no data
    		if (empty($record)) continue;

	        Product::create([
	            'product_name' => $record[1],
	            'price' => $record[2]
	        ]);
	        $count++;
	    }
	    //log the final stats
	    Log::info(count($records). ' out of '.$count.' product data sets imported.');
    }
}
