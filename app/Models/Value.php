<?php

namespace App\Models;

use App\Models\Option;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Value extends Model
{
    use HasFactory;

    public function option(){

        return $this->belongsTo(Option::class)->select(['id', 'name']);
    }

    public function products(){
        
        return $this->belongsToMany(Product::class, 'product_value');
    }
}
