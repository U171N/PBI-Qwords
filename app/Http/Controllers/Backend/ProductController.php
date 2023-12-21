<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Http\Request;
use Image;
use Carbon\Carbon;

class ProductController extends Controller
{

    /*Bagian User Admin */

    //function untuk menampikan semua data product
    public function AllProductAdmin()
    {
        $products = Products::latest()->get();
        return view('admin.product.product_all', compact('products'));
    }

    //function untuk menampilkan halaman tambah data product baru
    public function AddProductAdmin()
    {
        //get data product
        $products =Products::latest()->get();
        // Get all categories from the database
        $categories = Categories::all();

        return view('admin.product.product_add', compact('categories','products'));
    }

    //endpoint untuk tambah data product baru
    public function ProductStoreAdmin(Request $request)
    {
        $newProduct = new Products();
        $newProduct->product_id = Products::generateCustomeId();

        //  $newCategory = new Categories();
        // $newCategory->category_id = Categories::generateCustomId();
        // Get the product ID to use in image names
        $product_id = $newProduct->product_id;

        // Generate image 1
        $image1 = $request->file('image1');
        $name_gen1 = $product_id . '_img1.' . date('YmdHis') . '.' .$image1->getClientOriginalExtension();
        Image::make($image1)->resize(120, 120)->save('upload/product/' . $name_gen1);
        $save_url1 = 'upload/product/' . $name_gen1;

        // Generate image 2
        $image2 = $request->file('image2');
        $name_gen2 = $product_id . '_img2.' . date('YmdHis') . '.' .$image2->getClientOriginalExtension();
        Image::make($image2)->resize(120, 120)->save('upload/product/' . $name_gen2);
        $save_url2 = 'upload/product/' . $name_gen2;

        // Generate image 3
        $image3 = $request->file('image3');
        $name_gen3 = $product_id . '_img3.' . date('YmdHis') . '.' .$image3->getClientOriginalExtension();
        Image::make($image3)->resize(120, 120)->save('upload/product/' . $name_gen3);
        $save_url3 = 'upload/product/' . $name_gen3;

        $formattedSellingPrice = number_format((float) $request->selling_price, 2, '.', '');

        $category = Categories::where('category_id', $request->category)->first();

        Products::insert([
            'product_id' => $newProduct->product_id,
            'category_id' => $category->category_id,
            'name' => $request->product_name,
            'description' => $request->description,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,
            'product_weight'=>$request->product_weight,
            'image1' => $name_gen1,
            'image2' => $name_gen2,
            'image3' => $name_gen3,
            'price' => $formattedSellingPrice,
            'amount' => $request->product_qty,
            'discount_price' => $request->discount_price,
            'product_slug' => strtolower(str_replace(' ', '-',$request->product_name)),
            'created_at'=>Carbon::now()
        ]);

        $notification = array(
            'message' => 'Product berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('produk.admin')->with($notification);
    }

    //function untuk menampilkan halaman Edit Product
    public function EditProductAdmin($product_id){
        $product=Products::findorFail($product_id);
          //get data product
          $products =Products::latest()->get();
          // Get all categories from the database
          $categories = Categories::all();

        return view('admin.product.product_edit', compact('product', 'categories'));
    }


    //endpoint untuk update data product
    public function UpdateProductAdmin(Request $request){
        $existingProduct = Products::find($request->product_id);
        $category = Categories::where('category_id', $request->category)->first();

        //update data lain
        $existingProduct->category_id =  $category->category_id;
        $existingProduct->name = $request->product_name;
        $existingProduct->description = $request->description;
        $existingProduct->product_size = $request->product_size;
        $existingProduct->product_color = $request->product_color;
        $existingProduct->product_weight = $request->product_weight;
        $existingProduct->price = number_format((float)$request->selling_price, 2,'.','');
        $existingProduct->amount =$request->product_qty;
        $existingProduct->discount_price =$request->discount_price;
        $existingProduct->product_slug = strtolower(str_replace(' ', '-',$request->product_name));
        $existingProduct->updated_at=Carbon::now();

        //update data image
        if($request->hasFile('image1')){
            $image1 = $request->file('image1');
            $nama_gen1=$existingProduct->product_id . '_img1'. date('YmdHis') . '.' .$image1->getClientOriginalExtension();
            Image::make($image1)->resize(120,120)->save('upload/product/' . $nama_gen1);
            $existingProduct->image1 = $nama_gen1;
        }

        if($request->hasFile('image2')){
            $image2 = $request->file('image2');
            $nama_gen2=$existingProduct->product_id . '_img2'.date('YmdHis') . '.' .$image2->getClientOriginalExtension();
            Image::make($image2)->resize(120,120)->save('upload/product/'.$nama_gen2);
            $existingProduct->image2 = $nama_gen2;
        }

        if($request->hasFile('image3')){
            $image3 = $request->file('image3');
            $nama_gen3=$existingProduct->product_id . '_img3'.date('YmdHis') . '.' .$image3->getClientOriginalExtension();
            Image::make($image3)->resize(120,120)->save('upload/product/'.$nama_gen3);
            $existingProduct->image3 = $nama_gen3;
        }

        //save data ketika selesai update
        $existingProduct->save();

        $notification = array(
            'message'=>'Produk berhasil diupdate',
            'alert-type'=>'success',
        );

        return redirect()->route('produk.admin')->with($notification);
    }

    //endpoint untuk hapus data product
    public function DeleteProductAdmin($product_id){
        $product =Products::findOrFail($product_id);
        Products::findOrFail($product_id)->delete();

        $notification =array(
            'message' =>'Data produk berhasil dihapus',
            'alert-type' =>'success',
        );

        return redirect()->back()->with($notification);
    }

    /*Bagian User Staff */
    //function untuk menampikan semua data product
    public function AllProduct()
    {
        $products = Products::latest()->get();
        return view('staff.product.product_all', compact('products'));
    }

    //function untuk menampilkan halaman tambah data product baru
    public function AddProduct()
    {
        //get data product
        $products =Products::latest()->get();
        // Get all categories from the database
        $categories = Categories::all();

        return view('staff.product.product_add', compact('categories','products'));
    }

    //endpoint untuk tambah data product baru
    public function ProductStore(Request $request)
    {
        $newProduct = new Products();
        $newProduct->product_id = Products::generateCustomeId();

        // Get the product ID to use in image names
        $product_id = $newProduct->product_id;

        // Generate image 1
        $image1 = $request->file('image1');
        $name_gen1 = $product_id . '_img1.' . date('YmdHis') . '.' .$image1->getClientOriginalExtension();
        Image::make($image1)->resize(120, 120)->save('upload/product/' . $name_gen1);
        $save_url1 = 'upload/product/' . $name_gen1;

        // Generate image 2
        $image2 = $request->file('image2');
        $name_gen2 = $product_id . '_img2.' . date('YmdHis') . '.' .$image2->getClientOriginalExtension();
        Image::make($image2)->resize(120, 120)->save('upload/product/' . $name_gen2);
        $save_url2 = 'upload/product/' . $name_gen2;

        // Generate image 3
        $image3 = $request->file('image3');
        $name_gen3 = $product_id . '_img3.' . date('YmdHis') . '.' .$image3->getClientOriginalExtension();
        Image::make($image3)->resize(120, 120)->save('upload/product/' . $name_gen3);
        $save_url3 = 'upload/product/' . $name_gen3;

        $formattedSellingPrice = number_format((float) $request->selling_price, 2, '.', '');

        $category = Categories::where('category_id', $request->category)->first();

        Products::insert([
            'product_id' => $newProduct->product_id,
            'category_id' => $category->category_id,
            'name' => $request->product_name,
            'description' => $request->description,
            'product_size' => $request->product_size,
            'product_color' => $request->product_color,
            'product_weight'=>$request->product_weight,
            'image1' => $name_gen1,
            'image2' => $name_gen2,
            'image3' => $name_gen3,
            'price' => $formattedSellingPrice,
            'amount' => $request->product_qty,
            'discount_price' => $request->discount_price,
            'product_slug' => strtolower(str_replace(' ', '-',$request->product_name)),
            'created_at'=>Carbon::now()
        ]);

        $notification = array(
            'message' => 'Product berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('all.produk')->with($notification);
    }

    //function untuk menampilkan halaman Edit Product
    public function EditProduct($product_id){
        $product=Products::findorFail($product_id);
          //get data product
          $products =Products::latest()->get();
          // Get all categories from the database
          $categories = Categories::all();

        return view('staff.product.product_edit', compact('product', 'categories'));
    }


    //endpoint untuk update data product
    public function UpdateProduct(Request $request){
        $existingProduct = Products::find($request->product_id);
        $category = Categories::where('category_id', $request->category)->first();

        //update data lain
        $existingProduct->category_id =  $category->category_id;
        $existingProduct->name = $request->product_name;
        $existingProduct->description = $request->description;
        $existingProduct->product_size = $request->product_size;
        $existingProduct->product_color = $request->product_color;
        $existingProduct->product_weight = $request->product_weight;
        $existingProduct->price = number_format((float)$request->selling_price, 2,'.','');
        $existingProduct->amount =$request->product_qty;
        $existingProduct->discount_price =$request->discount_price;
        $existingProduct->product_slug = strtolower(str_replace(' ', '-',$request->product_name));
        $existingProduct->updated_at=Carbon::now();

        //update data image
        if($request->hasFile('image1')){
            $image1 = $request->file('image1');
            $nama_gen1=$existingProduct->product_id . '_img1'. date('YmdHis') . '.' .$image1->getClientOriginalExtension();
            Image::make($image1)->resize(120,120)->save('upload/product/' . $nama_gen1);
            $existingProduct->image1 = $nama_gen1;
        }

        if($request->hasFile('image2')){
            $image2 = $request->file('image2');
            $nama_gen2=$existingProduct->product_id . '_img2'.date('YmdHis') . '.' .$image2->getClientOriginalExtension();
            Image::make($image2)->resize(120,120)->save('upload/product/'.$nama_gen2);
            $existingProduct->image2 = $nama_gen2;
        }

        if($request->hasFile('image3')){
            $image3 = $request->file('image3');
            $nama_gen3=$existingProduct->product_id . '_img3'.date('YmdHis') . '.' .$image3->getClientOriginalExtension();
            Image::make($image3)->resize(120,120)->save('upload/product/'.$nama_gen3);
            $existingProduct->image3 = $nama_gen3;
        }

        //save data ketika selesai update
        $existingProduct->save();

        $notification = array(
            'message'=>'Produk berhasil diupdate',
            'alert-type'=>'success',
        );

        return redirect()->route('all.produk')->with($notification);
    }

    //endpoint untuk hapus data product
    public function DeleteProduct($product_id){
        $product =Products::findOrFail($product_id);
        Products::findOrFail($product_id)->delete();

        $notification =array(
            'message' =>'Data produk berhasil dihapus',
            'alert-type' =>'success',
        );

        return redirect()->back()->with($notification);
    }
}
