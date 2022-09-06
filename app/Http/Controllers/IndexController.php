<?php

namespace App\Http\Controllers;
use App\Models\Offers\Offer;
use App\Models\Brands\Brand;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){

        $offers = Offer::where('user_id', 1)->get();
        $brands =  Brand::where('title', 'Manav')->get();

        $data = [
            "offers" => $offers,
            "brands" => $brands,
        ];
        return response($data);
    }
}
