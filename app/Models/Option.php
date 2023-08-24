<?php

namespace App\Models;

use App\Models\Value;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    public function values(){

        return $this->hasMany(Value::class);
    }

    public function categories(){
        
        return $this->belongsToMany(Category::class, 'category_option');
    }
}
