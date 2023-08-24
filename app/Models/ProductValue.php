<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductValue extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'value_id'];
    protected $table = 'product_value';
}
