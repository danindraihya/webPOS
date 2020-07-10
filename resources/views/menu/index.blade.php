@extends('layouts.base')

@section('isi')
    <div class="mt-5">
        <div class="container">
            <div class="kategori mx-auto">
                <a href="">a</a>
                <a href="">b</a>
                <a href="">c</a>
                <a href="">d</a>
            </div>
            <form action="{{route('menu-cari')}}" method="GET">
                <input type="text" name="barang" id="barang">
                <button type="submit">Cari</button>
            </form>
            @if (count($list_menu) > 0)
                @foreach ($list_menu as $item)
                    <div class="row">
                        <div class="col">
                            <a href="/menu/{{$item->kode}}">{{$item->nama}}</a>
                        </div>
                        <div class="col">
                            {{$item->harga}}
                        </div>
                    </div>        
                @endforeach
            @endif
            
        </div>
    </div>
    
    
@endsection