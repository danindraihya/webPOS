@extends('layouts.main')

@section('content')
    {!! Form::open(['action' => 'MenuController@store', 'method' => 'POST']) !!}
        <div class="form-group">
            {{Form::label('nama', 'Nama')}}
            {{Form::text('nama', '', ['class' => 'form-control'])}}            
        </div>
        <div class="form-group">
            {{Form::label('kategori', 'Kategori')}}
            {{Form::select('kategori', ['minuman' => 'Minuman', 'makanan' => 'Makanan', 'snack' => 'Snack'], 'minuman', ['class' => 'form-control'])}}            
        </div>
        <div class="form-group">
            {{Form::label('harga', 'Harga')}}
            {{Form::text('harga', '', ['class' => 'form-control'])}}            
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection