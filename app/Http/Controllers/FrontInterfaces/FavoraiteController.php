<?php

namespace App\Http\Controllers\FrontInterfaces;


use App\Models\User;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Favoraite;
use App\Services\FavoraiteService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FavoraiteController extends Controller
{
    public function __construct(private FavoraiteService $favoriteService)
    {

    }


    /*************************************************************************************************/

    public function index()
    {
        //
    }


    /*************************************************************************************************/

    public function create()
    {

    }


    /*************************************************************************************************/

   public function store($id, $customerId)
    {
        $referer = request()->headers->get('referer');
        if ($referer === route('e-store'). '/') {
            $model = new Product();
        } else {
            $model = new Vendor();
        }

        $this->favoriteService->favoraite($model ,$id, $customerId);
        return redirect()->back();
    }


    /*************************************************************************************************/

    public function show(Favoraite $favoraite)
    {
        //
    }


    /*************************************************************************************************/

    public function edit(Favoraite $favoraite)
    {
        //
    }

    /*************************************************************************************************/

    public function update(UpdateFavoraiteRequest $request, Favoraite $favoraite)
    {
        //
    }


    /*************************************************************************************************/

    public function destroy(Favoraite $favoraite)
    {
        //
    }
}
