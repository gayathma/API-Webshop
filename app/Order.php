<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	
    protected $fillable = [
    	'customer_id', 'payed'
    ];

    public function customer()
	{
    	return $this->belongsTo(Customer::class, 'customer_id');
	}

	public function products()
	{
	    return $this->belongsToMany('App\Product', 'order_products')
	    	->withPivot('quantity', 'price')
    		->withTimestamps();
	}
}
