<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    //menampilkan halaman dashboard untuk user customer yang sudah login
    public function CustomerDashboard(){
        $id = Auth::user()->id;
        $userData = User::find($id);
        return view('index',compact('userData'));
    }

    //menampilkan halaman untuk update profile customer
    public function updateCustomer(){
        $id = Auth::user()->id;
        $userData = User::find($id);
        return view('frontend.userdashboard.account_details',compact('userData'));
    }
    //endpoint update profile user Customer
    public function CustomerProfileStore(Request $request){
        $id = Auth::user()->id;
        $data =User::find($id);
        $data->name=$request->name;
        $data->username =$request->username;
        $data->email =$request->email;
        $data->phone= $request->phone;
        $data->address = $request->address;

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/customer_images'.$data->photo));
            $extension = $file->getClientOriginalExtension();
            $filename =$id . '-' . Str::slug($request->name,'-').'-'.date('YmdHis').'.'.$extension;
            $file->move(public_path('upload/customer_images/'),$filename);
            $data['photo'] = $filename;
        }
        $data->save();

        $notification = array(
            'message' =>'Profile telah di Update',
            'alert-type'=>'success',
        );

        return redirect()->back()->with($notification);
    }

    //menampilkan halaman update password customer
    public function CustomerUpdatePassword(){
        return view('frontend.userdashboard.user_change_password');
    }
    //endpoint user customer update password
    public function UserUpdatePassword(Request $request){
        $request->validate([
            'old_password'=>'required',
            'new_password'=>'required|confirmed',
        ]);

        //mencocokan password yang lama
        if(!Hash::check($request->old_password,auth::user()->password)){
            return back()->with('error', 'password yang lama tidak sama');
        }

        //update password baru
        User::whereId(auth()->user()->id)->update([
            'password'=>Hash::make($request->new_password)
        ]);

        return back()->with('status', 'password berhasil diubah');
    }

    //endpoint user customer logout
    public function UserLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification= array(
            'message'=>'User berhasil logout',
            'alert-type'=>'success',
        );

        return redirect('/login')->with($notification);
    }
}
