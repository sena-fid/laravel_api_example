<?php

namespace App\Models\Offers;

use App\Models\Companies\Company;
use App\Models\Settings\Status;
use App\Models\Settings\SystemSetting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'offers';
    protected $fillable = [
        'offer_status',
        'bid_result',
        'offer_type',
        'company_id',
        'user_id',
        'offer_no',
        'title',
        'offer_date',
        'validity_date',
        'curency',
        'currency_rate',
        'custom_rate',
        'terms_of_payment',
        'delivery_time',
        'cover_letter',
        'condition',
        'offer_terms',
        'note',
        'product_attrs',
        'total_tax',
        'tax_value',
        'total_discount',
        'offer_price',
        'offer_subtotal',
        'offer_total',
        'offer_template',
        'bidder',
        'bidder_title',
        'bidder_phone',
        'bidder_email',
    ];



    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }


    public function curency()
    {
        return $this->hasOne(SystemSetting::class, 'id', 'curency');
    }


    public function coverLetter()
    {
        return $this->hasOne(SystemSetting::class, 'id', 'cover_letter');
    }


    public function offerCondition()
    {
        return $this->hasOne(SystemSetting::class, 'id', 'condition');
    }


    public function offerStatus()
    {
        return $this->hasOne(Status::class, 'id', 'offer_status');
    }


    public function offerProducts()
    {
        return $this->hasMany(OfferProduct::class);
    }



}
