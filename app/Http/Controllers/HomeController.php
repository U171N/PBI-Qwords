<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\ProductReview;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    //menampilkan halaman home website
    public function Home(){
        $products =Products::latest()->get();
        $skip_category_0 = Categories::skip(0)->first();

        if($skip_category_0){
          $skip_product_0 =Products::where('category_id',$skip_category_0->category_id)->orderBy('product_id','DESC')->limit(5)->get();
        }else{
          $skip_product_0 = collect();
        }

        $skip_category_2 =Categories::skip(2)->first();
        if($skip_category_2){
          $skip_product_2 = Products::where('category_id',$skip_category_2->category_id)->orderBy('product_id','DESC')->limit(5)->get();
        }else{
          $skip_product_2 = collect();
        }

        $skip_category_7 =Categories::skip(7)->first();
        if($skip_category_7){
          $skip_product_7 = Products::where('category_id',$skip_category_7->category_id)->orderBy('product_id','DESC')->limit(5)->get();
        }else{
          $skip_product_7 = collect();
        }
        $reviews = ProductReview::all();


        // $categories = Categories::latest()->get();
        return view('frontend/index',compact('skip_category_0','skip_product_0','skip_category_2','skip_product_2','skip_category_7','skip_product_7','products','reviews'));
    }


    //endpoint untuk data pada halaman Shop
    public function ShopPage() {
      $productsQuery = Products::query();

      if (!empty($_GET['category'])) {
          $slugs = explode(',', $_GET['category']);
          $catIds = Categories::select('category_id')->whereIn('category_slug', $slugs)->pluck('category_id')->toArray();
          $productsQuery = $productsQuery->whereIn('category_id', $catIds);
      }

      // Price Range
      if (!empty($_GET['price'])) {
          $price = explode('-', $_GET['price']);
          $productsQuery = $productsQuery->whereBetween('price', $price);
      }

      $products = $productsQuery->get();

      $categories = Categories::orderBy('name', 'ASC')->get();
      $newProduct = Products::orderBy('product_id', 'DESC')->limit(3)->get();

      return view('frontend.home.shop_page', compact('products', 'categories', 'newProduct'));
  }


  //endpoint untuk filter data pada halaman Shop Page
  public function ShopFilter(Request $request){

    $data = $request->all();

    /// Filter For Category

    $catUrl = "";
    if (!empty($data['category'])) {
        foreach($data['category'] as $category){
            if (empty($catUrl)) {
                $catUrl .= '&category='.$category;
            }else{
                $catUrl .= ','.$category;
            }
        }
    }






    /// Filter For Price Range

    $priceRangeUrl = "";
    if (!empty($data['price_range'])) {
       $priceRangeUrl .= '&price='.$data['price_range'];
    }

    return redirect()->route('shop.page',$catUrl.$priceRangeUrl);

}

    //menampilkan halaman registrasi customer
    public function CustomerRegistrasi(){
      return view('auth.register');
    }
    //menampilkan halaman login customer
    public function CustomerLogin(){
      return view('auth/login');
    }

    //menampilkan data kategori pada halaman home/beranda
    public function CategoriProduct(Request $request,$id,$slug){
      $product =Products::latest()->get();
    $products = Products::where('category_id',$id)->orderBy('product_id','DESC')->get();
    $categories = Categories::orderBy('name','ASC')->get();
    $breadcat = Categories::where('category_id',$id)->first();
    $newProduct = Products::orderBy('product_id','DESC')->limit(3)->get();
      return view('frontend/home/products',compact('products','categories','breadcat','newProduct'));
    }

    //endpoint detail product
    public function ProductsDetails($id,$slug){
      $product = Products::findOrFail($id);
      $cat_id = $product->category_id;
      $relatedProduct = Products::where('category_id',$cat_id)->where('product_id','!=',$id)->orderBy('product_id','DESC')->limit(4)->get();

      $color = $product->product_color;
        $product_color = explode(',', $color);

        $size = $product->product_size;
        $product_size = explode(',', $size);

        //endpoint untuk menghitung review product
        $reviews = DB::table('product_reviews')
        ->select('rating', DB::raw('COUNT(*) as count'))
        ->where('product_id', $id)
        ->groupBy('rating')
        ->get();

    $totalReviews = $reviews->sum('count');

    $ratingDistribution = $reviews->mapWithKeys(function ($item, $_) use ($totalReviews) {
      $percentage = ($item->count / $totalReviews) * 100;
      return [$item->rating => $percentage];
  });


  $averageRating = $ratingDistribution->sum(function ($value) {
    return $value;
});



      return view('frontend.home.product_details',compact('product','relatedProduct','product_color','product_size','ratingDistribution','averageRating'));
    }

    //endpoint untuk mengaktifkan fitur search dihalaman home
    public function ProductSearch(Request $request){
      $request->validate(['search' =>'required']);

      $item = $request->search;
      $categories = Categories::orderBy('name','ASC')->get();
      $products = Products::where('name','LIKE',"%$item%")->get();
      $newProduct = Products::orderBy('product_id','DESC')->limit(3)->get();
      return view('frontend.home.search',compact('products','item','categories','newProduct'));

    }

    //endpoint untuk search product
    public function SearchProduct(Request $request){
      $request->validate(['search'=>"required"]);

      $item = $request->search;
      $products = Products::where('name','LIKE',"%$item%")->select('name','product_slug','price','product_id')->limit(6)->get();

      return view('frontend.home.search_product',compact('products'));
    }
}
