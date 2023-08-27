<?php

namespace App\Services;


use App\Models\Product;
use App\Models\Customer;
use App\Models\Favoraite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FavoraiteService
{
    public function favoraite($model,$productId,$customerId)
    {
        // dd( $model);
        $wish = Favoraite::where('favoritable_id',$productId)->where('customer_id',$customerId)->first();

        if(isset($wish))
        {
            Session::flash('message','product already exists in wishList');
            $is_favoraite = 1;
            return redirect()->route('e-store',compact('is_favoraite'));
        }
        else
        {
            $customer_id = Auth::id();
            $product = $model::findOrFail($productId);
            $product->favoritable()->create([
                'favoritable_id' => $productId,
                'favoritable_type' => get_class($model),
                'customer_id' => $customerId,
            ]);
        }


    }

}
