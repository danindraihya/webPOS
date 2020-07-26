<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Menu;

class ReportController extends Controller
{
    //

    public function rekapLaporanPenjualan()
    {
        $makanan = 0;
        $minuman = 0;
        $snack = 0;

        $date = Carbon::today()->toDateString();

        $rekap = DB::table('detail_transaksi')
                    ->whereDate('created_at', $date)
                    ->get();
        
        foreach($rekap as $item) {
            $menu = Menu::find($item->menu_kode);
            if($menu->kategori == 'makanan') {
                $makanan += $item->jumlah;
            } elseif($menu->kategori == 'minuman') {
                $minuman += $item->jumlah;
            } else {
                $snack += $item->jumlah;
            }
        }

        $data = array(
            'tanggal' => date("F jS, Y", strtotime("now")),
            'makanan' => $makanan,
            'minuman' => $minuman,
            'snack' => $snack
        );

        return view('report.rekap')->with('data', $data);
    }

    public function masterReportJam()
    {
        $dataMakanan = array();
        $dataJumlah = array();

        $date = Carbon::now()->toDateString();
        $time1 = Carbon::now()->toTimeString();
        $time2 = strtotime($time1) - 60*60;
        $time2 = date('H:i:s', $time2);

        $report = DB::table('detail_transaksi')
                    ->whereBetween('created_at', [$date." ".$time2, $date." ".$time1])
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
            
        $data = array(
            'dataMakanan' => $dataMakanan,
            'dataJumlah' => $dataJumlah
        );

        return view('report.masterReport')->with('data', $data);

    }

    public function masterReportHarian()
    {
        $dataMakanan = array();
        $dataJumlah = array();

        $time = Carbon::now()->toDateString();
        $report = DB::table('detail_transaksi')
                    ->whereDate('created_at', $time)
                    ->get();

        var_dump($time); die;
        
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

        $data = array(
            'dataMakanan' => $dataMakanan,
            'dataJumlah' => $dataJumlah
        );

        return view('report.masterReport')->with('data', $data);

    }

    public function masterReportMingguan()
    {
        $dataMakanan = array();
        $dataJumlah = array();

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

        $data = array(
            'dataMakanan' => $dataMakanan,
            'dataJumlah' => $dataJumlah
        );

        return view('report.masterReport')->with('data', $data);

    }

    public function masterReportBulanan()
    {
        $dataMakanan = array();
        $dataJumlah = array();

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

        $data = array(
            'dataMakanan' => $dataMakanan,
            'dataJumlah' => $dataJumlah
        );

        return view('report.masterReport')->with('data', $data);

    }

    public function blankMasterReport()
    {
        return view('report.masterReport');
    }

    public function getMasterReport(Request $request)
    {
        $dataMakanan = array();
        $dataJumlah = array();

        $start = $request['startDate'];
        $end = $request['endDate'];
        $time = Carbon::now()->toTimeString();

        $report = DB::table('detail_transaksi')
                    ->whereBetween('created_at', [$start.' '.$time, $end.' '.$time])
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

        $data = array(
            'dataMakanan' => $dataMakanan,
            'dataJumlah' => $dataJumlah
        );

        return $data;
    }
}
