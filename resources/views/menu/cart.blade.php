@extends('layouts.main')

@section('content')
@foreach ($data['carts'] as $row)
    <div class="row">
        <div class="col">
            {{$row['nama']}}
        </div>
    </div>
@endforeach

{{$data['subtotal']}}
<a href="/addToCart">Update Cart</a>
@endsection