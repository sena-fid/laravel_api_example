<?php

namespace App\Http\Controllers;
use App\Models\Offers\Offer;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){

        $offers = Offer::all();

        $data = [
            "offers" => $offers,
        ];
        return response($data, );
    }
}
