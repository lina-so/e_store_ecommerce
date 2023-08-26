<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'value_id',
        'price',
        'stock',
        'sku',
        'status'
    ];
    
    public function values(){

        return $this->hasMany(Value::class);
    }
}
