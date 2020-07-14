<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Menu;
use Illuminate\Support\Facades\DB;
use PDF;

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
        
        return view('transaksi.index')->with('list_menu', $menu);
    }

    public function cari(Request $request)
    {
        return view('transaksi.index');
    }

    public function hasil(Request $request)
    {
        $hasil = DB::table('menu')
            ->where('nama', 'like', '%'.$request->input('nama').'%')->get();

        dd($hasil);
        
    }

    public function cariItem(Request $request)
    {
        if($request->input('nama_item')){
            $menu = Menu::where('nama', 'like' , '%'.$request->input('nama_item').'%')->get();
        } else {
            $menu = Menu::all();
        }

        return redirect()->back()->with('list_menu', $menu);
    }

    public function addToCart(Request $request)
    {
        $menu = Menu::find($request->kode);

        $cart = session()->get('cart');

        if(!$cart) {
            $cart = [
                $request->kode => [
                    "kode" => $menu->kode,
                    "nama" => $menu->nama,
                    "harga" => $menu->harga,
                    "jumlah" => $request->jumlah
                ]
            ];

            session()->put('cart', $cart);
            // dd('from controller');
            return session()->get('cart');

        } elseif(isset($cart[$request->kode])) {
 
            $cart[$request->kode]['jumlah'] = $request->jumlah;
 
            session()->put('cart', $cart);
            // dd('from controller2');
 
            return session()->get('cart');
 
        } else {
            $cart[$request->kode] = [
                "kode" => $menu->kode,
                "nama" => $menu->nama,
                "harga" => $menu->harga,
                "jumlah" => $request->jumlah
            ];
     
            session()->put('cart', $cart);
            
            return session()->get('cart');
        }

    }


    public function removeFromCart(Request $request)
    {
        if($request->kode) {
            
            $cart = session()->get('cart');

            if(isset($cart[$request->kode])) {
                
                unset($cart[$request->kode]);

                session()->put('cart', $cart);
            }
        }

        return session()->get('cart');
    }

    public function bayar(Request $request)
    {
        $transaksi = new Transaksi();

        $transaksi->user_id = $request->user_id;
        $transaksi->total_harga = $request->total_harga;
        $transaksi->save();

        $carts = session()->get('cart');
        
        foreach($carts as $cart) {
            $transaksi->menu()->attach($cart['kode'], ['harga' => $cart['harga'] * $cart['jumlah'], 'jumlah' => $cart['jumlah']]);
        }

        session()->forget('cart');

        return $transaksi->id;
    }

    public function cetak(Request $request)
    {   
        $barang = DB::table('detail_transaksi')
                    ->where('transaksi_id', $request['transaksi_id'])
                    ->get();
        
        foreach($barang as $item) {
            $menu = Menu::find($item->menu_kode);
            $item->menu_kode = $menu->nama;
        }

        $pdf = PDF::loadView('transaksi.cetak', ['barang' => $barang, 'total_harga' => $request['total_harga'], 'cash' => $request['cash'], 'kembali' => $request['kembali']])->setPaper('a4', 'landscape');

        return $pdf->stream("cetak.pdf");
    }
}
