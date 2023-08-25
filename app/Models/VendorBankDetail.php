<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBankDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'account_name',
        'account_number',
        'bank_name'
    ];
}
