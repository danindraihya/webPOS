<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Image;

class MenuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(auth()->user()->role == 'admin') {

            $list_menu = Menu::all();
            return view('menu/admin/index')->with('list_menu', $list_menu);
        
        } else {

            $menu = Menu::all();
        
            return view('transaksi.index')->with('list_menu', $menu);

        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'kategori' => 'required',
            'harga' => 'required',
            'gambar' => 'image|nullable|max:2048'
        ]);

        if($request->hasFile('gambar')){
            // $image = $request->file('gambar');
            $filenameWithExt = $request->file('gambar')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('gambar')->getClientOriginalExtension();
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // $img = Image::make($image->path());
            // $img->resize(750, 530, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save(public_path('/storage/gambar/'.$filenameToStore));

            $path = $request->file('gambar')->storeAs('public/gambar', $filenameToStore);
        } else {
            $filenameToStore = 'noimage.jpg';
        }

        $menu = new Menu;

        $menu->nama = $request->input('nama');
        $menu->kategori = $request->input('kategori');
        $menu->harga = $request->input('harga');
        $menu->gambar = $filenameToStore;
        $menu->save();

        return redirect('/menu')->with('success', 'Berhasil input menu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = Menu::where('kode', $id)->get()->first();

        return view('menu.show')->with('menu', $menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'kategori' => 'required',
            'harga' => 'required',
            'gambar' => 'image|nullable|max:2048'
        ]);

        if($request->hasFile('gambar')){
            // $image = $request->file('gambar');
            $filenameWithExt = $request->file('gambar')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('gambar')->getClientOriginalExtension();
            // $img = Image::make($image->path());
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // $img->resize(750, 530, function ($constraint) {
            //     $constraint->aspectRatio();
            // })->save('public/gambar/'.$filenameToStore);
            $path = $request->file('gambar')->storeAs('public/gambar', $filenameToStore);
        }

        $menu = Menu::find($request->input('kode'));
        $menu->nama = $request->input('nama');
        $menu->kategori = $request->input('kategori');
        $menu->harga = $request->input('harga');
        if($request->hasFile('gambar')) {
            if($menu->gambar != 'noimage.jpg') {
                Storage::delete('pulbic/gambar/'.$menu->gambar);
            }
            $menu->gambar = $filenameToStore;
        }
        $menu->save();

        return redirect('/menu')->with('success', 'Berhasil edit menu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $menu = Menu::find($request->input('kode'));

        if($menu->gambar != 'noimage.jpg') {
            Storage::delete('pulbic/gambar/'.$menu->gambar);
        }
        
        $menu->delete();

        return redirect('/menu')->with('success', 'Berhasil menghapus item');
    }

    public function cariBarang(Request $request)
    {
        if($request->input('kategori')){
            $menu = Menu::where('kategori', $request->input('kategori'))->get();
        } else {
            $menu = Menu::where('nama', 'like' , '%'.$request->input('barang').'%')->get();
        }

        return view('menu.admin.cari')->with('list_menu', $menu);
    }
}
