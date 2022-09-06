<?php

namespace App\Http\Controllers\Offers;

use App\Http\Controllers\Controller;
use App\Models\Brands\Brand;
use App\Models\Categories\Category;
use App\Models\Companies\Company;
use App\Models\Companies\CompanyOfficial;
use App\Models\Offers\Offer;
use App\Models\Offers\OfferProduct;
use App\Models\Products\Product;
use App\Models\Settings\SystemSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Settings;

class OfferController extends Controller
{
    public function index(){

        $companies = Company::all();
        $offers = Offer::paginate(20);
        return view('offers.index', [
            'offers' => $offers,
            'companies' => $companies,
        ]);
    }


    public function store(Request $request){

        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'company_id' => 'required',
            'offer_no' => 'required|unique:offers',
        ]);

        try {

            if (!empty($request->company_title)) {
                $companyCreate = Company::create([
                    'title' => $request->company_title,
                ]);

                $request->company_id = $companyCreate->id;
            }

            $today = Carbon::today();
            $rand = rand(1000000,9999999);

            $offer = new Offer();
            $offer->fill([
                'title' => $request->title,
                'company_id' => $request->company_id,
                'offer_status' => 1,
                'offer_type' => 1,
                'offer_price' => 0,
                'offer_total' => 0,
                'offer_no' => $rand,
                'offer_date' => $today,
            ])->save();

            return redirect()->route('offer.edit', $offer->id);
        } catch (\Throwable $th) {

            dd($th->getMessage());
            return redirect()->back()->with('storeError', 'Bir Hata Oluştu!');
        }

    }


    public function create($id){
        $categories = Category::all();
        $brands = Brand::all();
        $products = Product::all();
        $offer = Offer::with('company')->where('id', $id)->first();
        $company = Company::first();
        $curency = SystemSetting::where('type', 'para_birimi')->get();
        $coverLetter = SystemSetting::where('type', 'onyazi_icerigi')->get();
        $condition = SystemSetting::where('type', 'genel_sart')->get();
        return view('offers.create', [
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products,
            'offer' => $offer,
            'company' => $company,
            'curency' => $curency,
            'coverLetter' => $coverLetter,
            'condition' => $condition,
        ]);
    }

    public function edit(Offer $offer) {
        $categories = Category::all();
        $brands = Brand::all();
        $products = Product::all();
        $company = Company::first();
        $curency = SystemSetting::where('type', 'para_birimi')->get();
        $coverLetter = SystemSetting::where('type', 'onyazi_icerigi')->get();
        $condition = SystemSetting::where('type', 'genel_sart')->get();
        return view('offers.edit', compact(
            'offer', 'curency', 'categories',
            'brands', 'products', 'company', 'coverLetter', 'condition'));
    }


    public function update(Request $request, Offer $offer)
    {

        $companyUpdate = Company::where('id', $offer->company_id)->first();

        if (!empty($request->sector)) {

            $companyUpdate->fill([
                'sector' => $request->sector ?? null,
                'address' => $request->address ?? null,
                'city' => $request->city ?? null,
                'distric' => $request->distric ?? null,
                'email' => $request->email ?? null,
                'url' => $request->url ?? null,
                'phone' => $request->phone ?? null,
                'gsm' => $request->gsm ?? null,
            ]);

            $companyUpdate->save();
        }

        try {
            $offer->update([
                'validity_date' => $request->validity_date ?? null,
                'user_id' => $request->user_id ?? null,
                'curency' => $request->curency ?? null,
                'currency_rate' => $request->currency_rate ?? null,
                'custom_rate' => $request->custom_rate ?? null,
                'terms_of_payment' => $request->terms_of_payment ?? null,
                'delivery_time' => $request->delivery_time ?? null,
                'cover_letter' => $request->cover_letter ?? null,
                'condition' => $request->condition ?? null,
                'offer_terms' => $request->offer_terms ?? null,
                'note' => $request->note ?? null,
                // 'product_attrs' => $request->product_attrs ?? null,
                // 'total_tax' => $request->total_tax ?? null,
                // 'tax_value' => $request->tax_value ?? null,
                'total_discount' => $request->total_discount ?? null,
                'offer_price' => $request->offer_price ?? null,
                // 'offer_subtotal' => $request->offer_subtotal ?? null,
                'offer_total' => $request->offer_total ?? null,
                'offer_template' => $request->offer_template ?? null,
                'bidder' => $request->bidder ?? null,
                'bidder_title' => $request->bidder_title ?? null,
                'bidder_phone' => $request->bidder_phone ?? null,
                'bidder_email' => $request->bidder_email ?? null,

            ]);

        if ( !empty($request->bidder && $request->bidder_title) ) {

            $company_id = $offer->company_id;

            CompanyOfficial::create([

                'company_id' => $company_id,
                'title' => $request->bidder ?? null,
                'task' => $request->bidder_title ?? null,
                'phone' => $request->bidder_phone ?? null,
                'email' => $request->bidder ?? null,
            ]);
        }

            return redirect()->back()->with('success', 'Düzenleme Başarılı!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Bir Hata Oluştu!');
        }
    }

    public function addForm(Request $request){

        $offerProduct = new OfferProduct();
        $offerProduct->fill([
            'offer_id' => $request->offer_id,
            'product_id' => $request->product_id,
            'offer_price' => $request->offer_price ?? null,
            'offer_quantity' => $request->offer_quantity ?? null,
            'unit' => $request->unit ?? null,
            'offer_total' => $request->offer_total ?? null,
            'offer_tax' => $request->offer_tax ?? null,
            'offer_discount' => $request->offer_discount ?? null,

        ])->save();

        return response()->json(['success'=>'oldu!']);

    }

    public function headerSearch(Request $request)
    {
        $companies = Company::all();

        $title = $request->title;

        $searchData = Offer::query();

            if (isset($title) && !empty($title)) {
                $searchData->where('title', 'LIKE', "%{$title}%");
            }

        $searchData = $searchData->paginate(20);

        return view('offers.search', compact('title', 'searchData', 'companies'));
    }

    public function seriNoSearch(Request $request)
    {

        $seri_no = Product::get('seri_no');

        $members = Product::where('seri_no', $request->seri_no)->with('category')->with('brand')->first();

        return response()->json($members);

    }

    public function barcodeNoSearch(Request $request)
    {
        $barcode_no = Product::get('barcode_no');

        $members = Product::where('barcode_no', $request->barcode_no)->with('category')->with('brand')->first();

        return response()->json($members);

    }




}
