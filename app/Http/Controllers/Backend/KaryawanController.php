<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\NewKaryawan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    //endpoint untuk menampilkan halaman data karyawan
    public function AllKaryawan(){
        $karyawan =User::where('role','staff')->get();
        return view('admin.staff.staff_all',compact('karyawan'));
    }

    //endpoint untuk menampilkan halaman data kustomaer
    public function AllCustomer(){
        $customer = User::where('role','customer')->get();
        return view('admin.customer_all',compact('customer'));
    }

    //endpoint untuk menampikan halaman tambah data karyawan
    public function AddKaryawan(){
        return view('admin.staff.tambah_staff');
    }

    //endpoint untuk melakukan aksi tambah data karyawan
    public function StoreKaryawan(Request $request){
        $password = Str::random(8);
        $hashedPassword = Hash::make($password);
        User::insert([
            'name' =>$request->name,
            'username' =>$request->name,
            'address' =>$request->address,
            'phone' =>$request->phone,
            'email' =>$request->email,
            'role' =>'staff',
            'password' =>$hashedPassword,
            'created_at' =>Carbon::now()
        ]);
        // Set SMTP gmail
        Mail::to($request->email)->send(new NewKaryawan($password));

        $notification = array(
            'message' => 'Data Karyawan Baru berhasil ditambahkan',
            'alert-type' =>'info'
        );

        return redirect()->route('staff.all')->with($notification);
    }

    //endpoint untuk menampilkan halaman edit data karyawan
    public function EditKaryawan($id){
        $karyawan = User::findOrFail($id);
        return view('admin.staff.staff_edit',compact('karyawan'));
    }

    //endpoint untuk melakukan aksi edit data karyawan


    public function UpdateKaryawan(Request $request){
        $karyawan_id = $request->id;
        $password = Str::random(8);
        User::findOrFail($karyawan_id)->update([
            'name' =>$request->name,
            'username' =>$request->name,
            'address' =>$request->address,
            'phone' =>$request->phone,
            'email' =>$request->email,
            'role' =>'staff',
            'password' =>$password,
            'updated_at' =>Carbon::now()
        ]);

        $notification =array(
            'message' => 'Data Karyawan Berhasil di Update',
            'alert-type' => 'success',
        );

        return redirect()->back('staff.all')->with($notification);
    }

    //endpoint untuk melakukan aksi hapus data karyawan
    public function DeleteKaryawan($id){
        $karyawan = User::findOrFail($id);
        User::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Data Karyawan Berhasil di Hapus',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }
}
