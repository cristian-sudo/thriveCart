<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryRule extends Model
{
    protected $fillable = ['threshold', 'cost'];
}
