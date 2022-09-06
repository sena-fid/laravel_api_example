<?php

namespace App\Http\Controllers\Brands;

use App\Http\Controllers\Controller;
use App\Models\Brands\Brand;
use App\Models\Products\Product;
use App\Models\Categories\Category;
use App\Models\Settings\SystemSetting;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    public function index(){

        $brands = Brand::orderBy('created_at')->paginate(20);

        return view('brands.index', [
            'brands' => $brands,
        ]);
    }


    public function brandProducts(Brand $brand){

        $priceType = SystemSetting::where('type', 'para_birimi')->get();
        $categories = Category::all();
        $brands = Brand::all();
        $brandProducts = Product::where('category_id', $brand->id)->get();   
        return view('products.brandProduct', [
            'brandProducts' => $brandProducts,
            'categories' => $categories,
            'priceType' => $priceType,
            'brands' => $brands,
        ]);

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        try {

            $brand = new Brand();
            $brand->fill([
                'title' => $request->title,
            ])->save();

            return redirect()->back()->with('storeSuccess', 'Ekleme Başarılı!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('storeError', 'Bir Hata Oluştu!');
        }
    }


    public function update(Request $request)
    {
        try {
            $brand = Brand::find($request->id);
            $brand->title = $request->title;
            $brand->save();

            return redirect()->back()->with('success', 'Düzenleme Başarılı!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Bir Hata Oluştu!');
        }
    }


    public function destroy(Brand $brand)
    {
        try {

            $result = $brand->delete();

            if ($result) {
                return redirect('/brand')->with('deleteSuccess', 'Silme Başarılı!');
            }
            return redirect()->back()->with('deleteError', 'Bir Hata Oluştu!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('deleteError', 'Bir Hata Oluştu!');
        }
    }

    public function search_form(Request $request)
    {
        if ($request->ajax()) {
            $payload = '';
            $category = Category::where('id', $request->search)->first();

            if ($category) {
                $payload .= '<option value="0">'.$category.'</option>';
                // foreach ($category->brands as $brand) {
                // }
            }
            return response()->json($payload);
        }
    }

}
