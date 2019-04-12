<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['job_title', 'email', 'first_name', 'last_name', 'registered_since', 'phone'];
}
