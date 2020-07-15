<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaksi;
use App\Menu;
use App\Http\Resources\Transaksi as TransaksiResource;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = Menu::all();

        return TransaksiResource::collection($menu);
    }

    public function cariItem(Request $request)
    {
        if($request->input('nama_item')){
            $menu = Menu::where('nama', 'like' , '%'.$request->input('nama_item').'%')->get();
        } else {
            $menu = Menu::all();
        }

        return TransaksiResource::collection($menu);
    }

    public function bayar(Request $request)
    {
        $transaksi = new Transaksi();

        $transaksi->user_id = $request['user_id'];
        $transaksi->total_harga = $request['total_harga'];
        $transaksi->save();
        
        foreach($request['carts'] as $cart) {
            $transaksi->menu()->attach($cart['kode'], ['harga' => $cart['harga'] * $cart['jumlah'], 'jumlah' => $cart['jumlah']]);
        }

        return response()->json([
            'status' => 200,
            'messages' => 'Berhasil melakukan pembayaran'
        ]);
    }

    public function rekapLaporanPenjualan(Request $request)
    {
        $makanan = 0;
        $minuman = 0;
        $snack = 0;

        $date = $request->date;

        $rekap = DB::table('detail_transaksi')
                    ->whereDate('created_at', $date)
                    ->get();

        foreach($rekap as $item) {
            $menu = Menu::find($item->menu_kode);
            if($menu->kategori == 'makanan') {
                $makanan++;
            } elseif($menu->kategori == 'minuman') {
                $minuman++;
            } else {
                $snack++;
            }
        }

        $data = array(
            'makanan' => $makanan,
            'minuman' => $minuman,
            'snack' => $snack
        );

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function masterReport(Request $request)
    {

        $dataMakanan = array();
        $dataJumlah = array();

        if($request['report_type'] == 'jam') {
            $date = Carbon::now()->toDateString();
            $time1 = Carbon::now()->toTimeString();
            $time2 = strtotime($time1) - 60*60;
            $time2 = date('H:i:s', $time2);

            $report = DB::table('detail_transaksi')
                        ->whereBetween('created_at', [$date.$time2, $date.$time1])
                        ->get();

            foreach($report as $item) {
                $menu = Menu::find($item->menu_kode);
                $item->menu_kode = $menu->nama;
            }

            foreach($report as $item) {
                if(!in_array($item->menu_kode, $dataMakanan)) {
                    // $dataMakanan[$item->menu_kode] = $item->menu_kode;
                    array_push($dataMakanan, $item->menu_kode);
                    $dataJumlah[$item->menu_kode] = $item->jumlah;
                } else {
                    $dataJumlah[$item->menu_kode] += $item->jumlah;
                }
            }



        } elseif($request['report_type'] == 'harian') {
            // $time = Carbon::now()->toTimeString();
            // $date1 = Carbon::today()->toDateString();
            // $date2 = Carbon::yesterday()->toDateString();

            // $report = DB::table('detail_transaksi')
            //             ->whereBetween('created_at', [$date2.$time, $date1.$time])
            //             ->get();

            $time = Carbon::now()->toDateString();
            $report = DB::table('detail_transaksi')
                        ->whereDate('created_at', $time)
                        ->get();

            foreach($report as $item) {
                $menu = Menu::find($item->menu_kode);
                $item->menu_kode = $menu->nama;
            }

            foreach($report as $item) {
                if(!in_array($item->menu_kode, $dataMakanan)) {
                    // $dataMakanan[$item->menu_kode] = $item->menu_kode;
                    array_push($dataMakanan, $item->menu_kode);
                    $dataJumlah[$item->menu_kode] = $item->jumlah;
                } else {
                    $dataJumlah[$item->menu_kode] += $item->jumlah;
                }
            }


        } elseif($request['report_type'] == 'mingguan') {
            $report = DB::table('detail_transaksi')
                        ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                        ->get();

            foreach($report as $item) {
                $menu = Menu::find($item->menu_kode);
                $item->menu_kode = $menu->nama;
            }

            foreach($report as $item) {
                if(!in_array($item->menu_kode, $dataMakanan)) {
                    // $dataMakanan[$item->menu_kode] = $item->menu_kode;
                    array_push($dataMakanan, $item->menu_kode);
                    $dataJumlah[$item->menu_kode] = $item->jumlah;
                } else {
                    $dataJumlah[$item->menu_kode] += $item->jumlah;
                }
            }


        } else {

            $report = DB::table('detail_transaksi')
                        ->whereMonth('created_at', Carbon::now()->format('m'))
                        ->get();
            
            foreach($report as $item) {
                $menu = Menu::find($item->menu_kode);
                $item->menu_kode = $menu->nama;
            }

            foreach($report as $item) {
                if(!in_array($item->menu_kode, $dataMakanan)) {
                    // $dataMakanan[$item->menu_kode] = $item->menu_kode;
                    array_push($dataMakanan, $item->menu_kode);
                    $dataJumlah[$item->menu_kode] = $item->jumlah;
                } else {
                    $dataJumlah[$item->menu_kode] += $item->jumlah;
                }
            }

        }

        $data = array(
            'dataMakanan' => $dataMakanan,
            'dataJumlah' => $dataJumlah
        );

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);

    }

}
