<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaksi;
use App\Menu;
use App\Http\Resources\Transaksi as TransaksiResource;

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

}
