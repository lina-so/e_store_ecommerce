<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdcutAttribute extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'value_id',
        'price',
        'sku',
        'stock',
        'status'
    ];
}
