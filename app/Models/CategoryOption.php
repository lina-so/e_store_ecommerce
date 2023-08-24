<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryOption extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'option_id'];
    protected $table = 'category_option';
}
