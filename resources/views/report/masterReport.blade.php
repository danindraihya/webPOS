@extends('layouts.app')

@section('content')

<div class="m-3">
    <h3>Rekap Laporan Penjualan</h3>
    <div class="mt-3 d-inline-block border">
        <a href="/report/jam" class="ml-1 mr-2">Jam</a>
        <a href="/report/harian" class="mr-2">Harian</a>
        <a href="/report/mingguan" class="mr-2">Mingguan</a>
        <a href="/report/bulanan" class="mr-2">Bulanan</a>
    </div>
    <br>
    <br>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Item</th>
            <th scope="col">Jumlah</th>
          </tr>
        </thead>
        <tbody id="rekap">
            @php
                $count = 1;
            @endphp
            @foreach ($data['dataMakanan'] as $item)
                <tr>
                    <th scope="row">@php echo $count; $count++;
                    @endphp</th>
                    <td>{{$item}}</td>
                    <td>{{$data['dataJumlah'][$item]}}</td>
                </tr>
            @endforeach
        </tbody>
      </table>
</div>


  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="{{asset('js/app.js')}}"></script>

  <script type="text/javascript">

    $('#generate').on('click', function(){
      var value_report_type = $('#report_type').val();
      var markup = "";
        $.ajax({
          url: '/masterReport',
          method: 'GET',
          data: {
            report_type : value_report_type
          },
          success: function(data){

            $.each(data['dataMakanan'], function(index, value){
              // console.log(data['dataMakanan'][index]);
              // console.log(data['dataJumlah'][temp]);
              let temp = data['dataMakanan'][index];
              markup += "<tr> <th scope='row'>1</th> <td>"+ data['dataMakanan'][index] +"</td> <td>"+ data['dataJumlah'][temp] +"</td>";
            });

            tableBody = $('#rekap');
            tableBody.html(markup);
          }
        });
    });

  </script>
@endsection