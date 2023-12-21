<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LaporanPenjualan;
use App\Http\Controllers\Controller;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RiwayatPenjualanController extends Controller
{
    //menampilkan laporan penjualan
    public function HasilPenjualan(){
        $orders = Orders::with(['orderItems.product','user'])->get();
        return view('admin.penjualan.hasil_penjualan',compact('orders'));
    }


    //endpoint untuk menampilkan hasil penjualan pada user staff
    public function HasilPenjualanStaff(){
        $orders = Orders::with(['orderItems.product','user'])->get();
        return view('staff.hasil_penjualan',compact('orders'));
    }

    //endpoint untuk eksport data ke excel
    public function exportSales(){
        $orders = Orders::with(['orderItems.product','user'])->get();
        $export= new LaporanPenjualan($orders);
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        return Excel::download($export,'penjualan-'.$currentYear.'-'. $currentMonth . '.xlsx');
    }
}
