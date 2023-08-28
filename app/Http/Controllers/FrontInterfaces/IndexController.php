<?php

namespace App\Http\Controllers\FrontInterfaces;

use App\Http\Controllers\Controller;
use App\Models\Section;

class IndexController extends Controller
{
    public function index(){

        return view('front.index');
    }
}
