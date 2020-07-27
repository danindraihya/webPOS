@extends('layouts.app')

@section('content')
    <div class="mt-3">
        <div class="container">
             <div class="mt-2">
                 <div class="row">
                     <div class="col-9">
                        <form action="{{route('menu-cari')}}" method="GET">
                            <div class="input-group">
                                <input type="text" name="barang" id="barang" class="form-control mr-2" type="search" placeholder="Search"> 
                                <span class="input-group-btn">
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </span> 
                            </div>
                        </form>
                     </div>
                     <div class="col-3">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambahItem">
                            + Tambah Item
                        </button>
                     </div>
                 </div>                  
                    
                    <!-- Modal -->
                    <div class="modal fade" id="modalTambahItem" tabindex="-1" role="dialog" aria-labelledby="labelTambahItem" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="labelTambahItem">Tambah Item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                {!! Form::open(['action' => 'MenuController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
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
                                    <div class="form-group">
                                        {{Form::file('gambar')}}
                                    </div>
                            </div>
                            <div class="modal-footer">
                                    {{Form::submit('Tambah', ['class' => 'btn btn-primary'])}}
                                {!! Form::close() !!}
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                        </div>
                    </div> 
            </div>

            <!-- Modal EDIT -->
            <div class="modal fade" id="modalEditItem" tabindex="-1" role="dialog" aria-labelledby="labelEditItem" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="labelEditItem">Tambah Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        {!! Form::open(['action' => 'MenuController@update', 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                            {{Form::hidden('kode', '', ['class' => 'form-kode'])}}
                            <div class="form-group">
                                {{Form::label('nama', 'Nama')}}
                                {{Form::text('nama', '', ['class' => ['form-control', 'form-nama']])}}            
                            </div>
                            <div class="form-group">
                                {{Form::label('kategori', 'Kategori')}}
                                {{Form::select('kategori', ['minuman' => 'Minuman', 'makanan' => 'Makanan', 'snack' => 'Snack'], 'minuman', ['class' => ['form-control', 'form-kategori']])}}            
                            </div>
                            <div class="form-group">
                                {{Form::label('harga', 'Harga')}}
                                {{Form::text('harga', '', ['class' => ['form-control', 'form-harga']])}}            
                            </div>
                            <div class="form-group">
                                {{Form::file('gambar')}}
                            </div>
                    </div>
                    <div class="modal-footer">
                            {{Form::submit('Simpan', ['class' => 'btn btn-warning'])}}
                        {!! Form::close() !!}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </div>
            </div> 

            <!-- Modal DELETE -->
            <div class="modal fade" id="modalDeleteItem" tabindex="-1" role="dialog" aria-labelledby="labelDeleteItem" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="labelDeleteItem">Tambah Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin menghapus item tersebut ?
                    </div>
                    <div class="modal-footer">
                        {!! Form::open(['action' => 'MenuController@destroy', 'method' => 'DELETE']) !!}
                            {{Form::hidden('kode', '', ['class' => 'form-kode'])}}
                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                        {!! Form::close() !!}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
                </div>
            </div> 

            <div class="mt-3 d-inline-block border">
                    <a href="/menu" class="ml-1 mr-2">All</a>
                    <a href="/cari?kategori=makanan" class="mr-2">Makanan</a>
                    <a href="/cari?kategori=minuman" class="mr-2">Minuman</a>
                    <a href="/cari?kategori=snack" class="mr-2">Snack</a>
            </div>
            <div class="row mt-5">
                @if (count($list_menu) > 0)
                    @foreach ($list_menu as $produk)
                        <div class="col-md-4 mt-2">
                            <div class="card" style="width: 18rem;">
                                <img src="/storage/gambar/{{$produk->gambar}}" class="card-img-top" height="220">
                                <div class="card-body">
                                <h5 class="card-title">{{$produk->nama}}</h5>
                                <p class="card-text">Harga&emsp; : {{$produk->harga}} <br> Kategori&nbsp;: {{$produk->kategori}} </p>
                                <a href="#" class="btn btn-warning btn-edit" data-kode="<?= $produk->kode;?>" data-nama="<?= $produk->nama;?>" data-harga="<?= $produk->harga;?>" data-kategori="<?= $produk->kategori;?>">Edit</a>
                                <a class="btn btn-danger btn-hapus" data-kode="<?= $produk->kode;?>">Hapus</a>
                                </div>
                            </div>
                        </div>  
                    @endforeach
                @endif
            </div>    
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    

    <script type="text/javascript">
        $(document).ready(function(){
            console.log('hello');
            $('.btn-edit').on('click', function(){
                // get data from button edit
                var value_kode = $(this).data('kode');
                var value_nama = $(this).data('nama');
                var value_harga = $(this).data('harga');
                var value_kategori = $(this).data('kategori');
                // Set data to Form Edit
                $('.form-kode').val(value_kode);
                $('.form-nama').val(value_nama);
                $('.form-harga').val(value_harga);
                $('.form-kategori').val(value_kategori).trigger('change');
                // Call Modal Edit
                $('#modalEditItem').modal('show');
            });

            $('.btn-hapus').on('click', function(){
            var value_kode = $(this).data('kode');
            $('.form-kode').val(value_kode);
            // Call Modal Edit
            $('#modalDeleteItem').modal('show');
            });

        });
    </script>
    
@endsection