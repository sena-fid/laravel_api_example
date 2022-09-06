<?php

namespace App\Models\Offers;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferProduct extends Model
{
    protected $table = 'offer_products';
    protected $fillable = [
        'offer_id',
        'product_id',
        'offer_price',
        'offer_quantity',
        'unit',
        'offer_total',
        'offer_tax',
        'offer_discount',
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function offerProduct()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

}
