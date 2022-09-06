<?php

namespace App\Http\Controllers\Offers;

use App\Http\Controllers\Controller;
use App\Models\Offers\OfferProduct;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OfferProductController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'offer_id' => ['integer', Rule::exists('offers', 'id')],
            'product_id' => ['integer', Rule::exists('products', 'id')],
            'offer_price' => ['string'],
            'offer_quantity' => ['string'],
            'unit' => ['string'],
            'offer_total' => ['string'],
            'offer_tax' => ['integer', 'nullable'],
            'offer_discount' => ['string', 'nullable'],
        ]);

        $offer_product = OfferProduct::create($data);

        return redirect()->route('offer.edit', $offer_product->offer->id);

    }

    public function edit(OfferProduct $offerProduct)
    {
        //
    }

    public function update(Request $request, OfferProduct $offerProduct)
    {
        //
    }

    public function destroy(OfferProduct $offerProduct)
    {
        try {

            $result = $offerProduct->delete();

            if ($result) {
                return redirect('/offer')->with('deleteSuccess', 'Silme Başarılı!');
            }
            return redirect()->back()->with('deleteError', 'Bir Hata Oluştu!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('deleteError', 'Bir Hata Oluştu!');
        }
    }
}
