<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'brand_id',
        'admin_type',
        'vendor_id',
        'product_name',
        'product_discount',
        'product_image',
        'description',
        'is_featured',
        'status'];

    public function section(){

        return $this->belongsTo(Section::class);
    }

    public function category(){

        return $this->belongsTo(Category::class)->select('id', 'category_name');
    }
    public function values(){

        return $this->belongsToMany(Value::class, 'product_value');
    }

    public function attributes(){

        return $this->hasMany(ProdcutAttribute::class);
    }

    public function images(){

        return $this->hasMany(ProductImage::class);
    }
}

