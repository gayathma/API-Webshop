<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use League\Csv\Statement;
use App\Customer;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
	  	$file = public_path().'/csv/customers.csv';
        $reader = Reader::createFromPath($file);
        //skip the header
        $records = (new Statement())->offset(1)->process($reader);
        
        $count = 0;
       	foreach ($records->getRecords() as $record) {

        	// return false if there is no data
    		if (empty($record)) continue;

    		$name = explode(' ', $record[3]);
	        Customer::create([
	            'job_title' => $record[1],
	            'email' => $record[2],
	            'first_name' => $name[0],
	            'last_name' => $name[1],
	            'registered_since' => date('Y-m-d H:i:s', strtotime($record[4])),
	            'phone' => $record[5]
	        ]);
	        $count++;
	    }
	    //log the final stats
	    Log::info(count($records). ' out of '.$count.' customer data sets imported.');
    }
}
