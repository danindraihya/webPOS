@extends('layouts.main')

@section('content')
    <form action="{{route('mycarts')}}" method="POST">
        @csrf
        <div class="product_count">
        <label for="jumlah">Quantity:</label>
        <input type="text" name="jumlah" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
        
        <!-- BUAT INPUTAN HIDDEN YANG BERISI ID PRODUK -->
        <input type="hidden" name="kode" value="{{$menu->kode}}" class="form-control">
        
        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
        class="increase items-count" type="button">
            <i class="lnr lnr-chevron-up"></i>
        </button>
        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
        class="reduced items-count" type="button">
            <i class="lnr lnr-chevron-down"></i>
        </button>
        </div>
        <div class="card_area">
        
        <button type="submit">Add To Cart</button>
        <a href="/listcart">My Cart</a>
        </div>
    </form>
@endsection