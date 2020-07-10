@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col border">
            <input type="hidden" id="user_id" value="{{ auth()->user()->id }}">
            <input type="text" value="{{ auth()->user()->nama }}" disabled>
        </div>
        <div class="col border">
            <div class="input-group mb-3">
                <input type="hidden" id="form-kode" name="form-kode">
                <input type="text" id="form-nama" name="form-nama" class="form-control" aria-describedby="button-addon2">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" id="button-addon2" data-toggle="modal" data-target="#modalListItem">Cari</button>
                </div>
            </div>
            <input type="text" id="form-jumlah" name="form-jumlah" class="form-control" placeholder="Jumlah">
            <button type="button" id="addCart" class="btn btn-primary">Add Cart</button>
            <button type="button" id="bayar" class="btn btn-primary">Bayar</button>
        </div>
        <div class="col border total_harga">
        </div>
    </div>
    <div class="list-barang">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">User</th>
                <th scope="col">Kode</th>
                <th scope="col">Nama Item</th>
                <th scope="col">Harga</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Total</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody id="listCart">
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="modalListItem" aria-labelledby="labelListItem">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="labelListItem">List Item</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="list-barang">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Kode</th>
                            <th scope="col">Nama Item</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody> 
                                @if (count($list_menu) > 0)
                                    @foreach ($list_menu as $item)
                                        <tr>
                                            <th scope="row">{{$item->kode}}</th>
                                            <td>{{$item->nama}}</td>
                                            <button type="submit"></button>
                                            <td>{{$item->harga}}</td>
                                            <td><button type="button" class="btn btn-primary btn-select" id="select" data-kode="<?= $item->kode; ?>" data-nama="<?= $item->nama; ?>" data-dismiss="modal">Select</button></td>
                                        </tr>
                                    @endforeach
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="{{asset('js/app.js')}}"></script>

    <script>
        $(document).ready(function() {

            $('.btn-select').on('click', function(){
                var value_kode = $(this).data('kode');
                var value_nama = $(this).data('nama');
                $('#form-nama').val(value_nama);
                $('#form-kode').val(value_kode);
                $('#modalListItem').modal('hide');
            });

            $('#addCart').on('click', function(){
                var markup = "";
                value_kode = $('#form-kode').val();
                value_jumlah = $('#form-jumlah').val();
                var total_harga = 0;

                $.ajax({
                    url: '/transaksi/addtocart',
                    method: 'GET',
                    data: {
                        kode: value_kode,
                        jumlah: value_jumlah,
                    },
                    success: function(data){
                        $.each(data, function(index, value){
                            console.log(data);
                            markup += "<tr> <th scope='row'>user</th> <td>"+ data[index].kode +"</td> <td>"+ data[index].nama +"</td> <td>"+ data[index].harga +"</td> <td>"+ data[index].jumlah +"</td> <td>"+ data[index].jumlah * data[index].harga +"</td> <td><button kode='" + data[index].kode + "' class='btn btn-warning delete' >Hapus</button></td></tr>";
                            total_harga += data[index].harga * data[index].jumlah;
                        });

                        console.log(total_harga);

                        tableBody = $('#listCart');
                        tag_total_harga = $('div .total_harga');
                        tableBody.html(markup);
                        tag_total_harga.html("<h1 id='tag_total_harga' value='"+ total_harga +"'>"+ total_harga +"</h1>");
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
                
            });

            $(document).on('click', '.delete', function(){
                var markup = "";
                var value_kode = $(this).attr('kode');
                var total_harga = 0;

                if(confirm("Yakin menghapus item ?")) {
                    
                    $.ajax({
                        url: '/transaksi/removefromcart',
                        method: 'GET',
                        data: {
                            kode: value_kode
                        },
                        success: function(data){
                            $.each(data, function(index, value){
                                markup += "<tr> <th scope='row'>user</th> <td>"+ data[index].kode +"</td> <td>"+ data[index].nama +"</td> <td>"+ data[index].harga +"</td> <td>"+ data[index].jumlah +"</td> <td>"+ data[index].jumlah * data[index].harga +"</td> <td><button kode='" + data[index].kode + "' class='btn btn-warning delete' >Hapus</button></td></tr>";
                                total_harga += data[index].harga * data[index].jumlah;
                            });

                            tableBody = $('#listCart');
                            tag_total_harga = $('div .total_harga');
                            tableBody.html(markup);
                            tag_total_harga.html("<h1 id='tag_total_harga' value='"+ total_harga +"'>"+ total_harga +"</h1>");
                        }
                    });
                }
            });

            $('#bayar').on('click', function(){
                var value_total_harga = $('#tag_total_harga').attr('value');
                var value_user_id = $('#user_id').val();

                console.log('total harga belanja');
                console.log(value_total_harga);
                $.ajax({
                    url: '/transaksi/bayar',
                    method: 'GET',
                    data: {
                        user_id: value_user_id,
                        total_harga: value_total_harga,
                    },
                    success: function(data){
                        console.log('mari bayar');
                        console.log(data);
                        tableBody = $('#listCart');
                        tag_total_harga = $('div .total_harga');
                        tableBody.html("");
                        tag_total_harga.html("<h1 id='tag_total_harga' value='0'>0</h1>");
                        alert("Berhasil melakukan pembayaran");
                    }
                });
            });

        });

    </script>

@endsection