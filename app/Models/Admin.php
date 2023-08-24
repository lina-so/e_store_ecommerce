<?php

namespace App\Models;

use App\Models\Vendor;
use App\Models\VendorBankDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Admin extends Model implements Authenticatable
{
    use HasFactory, AuthenticableTrait;

    protected $guard = 'admin';

    public function vendorPersonal(){

        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function vendorBusiness(){
        
        return $this->belongsTo(VendorBusinessDetail::class, 'vendor_id');
    }

    public function vendorBank(){
        
        return $this->belongsTo(VendorBankDetail::class, 'vendor_id');
    }
}
