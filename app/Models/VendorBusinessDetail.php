<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBusinessDetail extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'vendor_id',
        'shop_name',
        'shop_address',
        'shop_city',
        'shop_country',
        'shop_mobile',
        'shop_email'
    ];
}
