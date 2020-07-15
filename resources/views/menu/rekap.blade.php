@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col">
        <div class="alert alert-primary" role="alert">
            Makanan : {{$data['makanan']}}
        </div>
    </div>
    <div class="col">
        <div class="alert alert-primary" role="alert">
            Makanan : {{$data['minuman']}}
        </div>
    </div>
    <div class="col">
        <div class="alert alert-primary" role="alert">
            Makanan : {{$data['snack']}}
        </div>
    </div>
</div>

<h3>Rekap Laporan Penjualan</h3>
<div class="row">
    <div class="col">
        <select class="form-control" id="report_type">
            <option value="jam">Jam</option>
            <option value="harian">Harian</option>
            <option value="mingguan">Mingguan</option>
            <option value="bulanan">Bulanan</option>
         </select>
    </div>
    <div class="col">
        <button type="button" id="generate">Generate</button>
    </div>
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
      <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        <td>Otto</td>
      </tr>
    </tbody>
  </table>

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