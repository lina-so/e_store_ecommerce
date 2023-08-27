<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favoraite extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function favoritable()
    {
        return $this->morphTo('favoritable');
    }
}
