<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /*Bagian Admin */
    //function untuk menampilkan semua data category
    public function AllCategoryAdmin(){
        //mengambil semua data kategori
        $categories = Categories::latest()->get();
        return view('admin.category.category_all',compact('categories'));
    }

    //function untuk menampilkan halaman tambah category product
    public function AddCategoryAdmin(){
        return view('admin.category.category_add');
    }
    //endpoint untuk membuat category
    public function CategoryStoreAdmin(Request $request){
        $newCategory = new Categories();
        $newCategory->category_id = Categories::generateCustomId();

        Categories::insert([
            'category_id'=>$newCategory->category_id,
            'name' =>$request->category,
            'category_slug' => strtolower(str_replace(' ', '-',$request->category)),
            'created_at'=>Carbon::now()
        ]);

        $notification =array(
            'message' => 'Category Berhasil ditambahkan',
            'alert-type'=>'info'
        );

        return redirect()->route('category.admin')->with($notification);
    }

    //function untuk menampillkan halaman edit data kategori
    public function EditCategoryAdmin($categori_id){
        $kategori=Categories::findOrFail($categori_id);
        return view('admin.category.category_edit',compact('kategori'));
    }

    //endpoint untuk update data kategori
    public function UpdateCategoryAdmin(Request $request){
        $categori_id = $request->category_id;
        Categories::findOrFail($categori_id)->update([
            'name' => $request->category,
            'category_slug' => strtolower(str_replace(' ', '-',$request->category)),
            'updated_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Data Kategori berhasil di Update',
            'alert-type' => 'success',
        );
        return redirect()->route('category.admin')->with($notification);
    }

    //endpoint untuk hapus data kategori produk
    public function DeleteCategoryAdmin($categori_id){
        $kategori =Categories::findOrFail($categori_id);
        Categories::findOrFail($categori_id)->delete();

        $notification = array(
            'message'=>'Data kategori berhasil dihapus',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notification);
    }

    /*Bagian Staff */

    //function untuk menampilkan semua data category
    public function AllCategory(){
        //mengambil semua data kategori
        $categories = Categories::latest()->get();
        return view('staff.category.category_all',compact('categories'));
    }

    //function untuk menampilkan halaman tambah category product
    public function AddCategory(){
        return view('staff.category.category_add');
    }
    //endpoint untuk membuat category
    public function CategoryStore(Request $request){
        $newCategory = new Categories();
        $newCategory->category_id = Categories::generateCustomId();

        Categories::insert([
            'category_id'=>$newCategory->category_id,
            'name' =>$request->category,
            'category_slug' => strtolower(str_replace(' ', '-',$request->category)),
            'created_at'=>Carbon::now()
        ]);

        $notification =array(
            'message' => 'Category Berhasil ditambahkan',
            'alert-type'=>'info'
        );

        return redirect()->route('all.category')->with($notification);
    }

    //function untuk menampillkan halaman edit data kategori
    public function EditCategory($categori_id){
        $kategori=Categories::findOrFail($categori_id);
        return view('staff.category.category_edit',compact('kategori'));
    }

    //endpoint untuk update data kategori
    public function UpdateCategory(Request $request){
        $categori_id = $request->category_id;
        Categories::findOrFail($categori_id)->update([
            'name' => $request->category,
            'category_slug' => strtolower(str_replace(' ', '-',$request->category)),
            'updated_at' => Carbon::now()
        ]);

        $notification = array(
            'message' => 'Data Kategori berhasil di Update',
            'alert-type' => 'success',
        );
        return redirect()->route('all.category')->with($notification);
    }

    //endpoint untuk hapus data kategori produk
    public function DeleteCategory($categori_id){
        $kategori =Categories::findOrFail($categori_id);
        Categories::findOrFail($categori_id)->delete();

        $notification = array(
            'message'=>'Data kategori berhasil dihapus',
            'alert-type'=>'success'
        );
        return redirect()->back()->with($notification);
    }
}
