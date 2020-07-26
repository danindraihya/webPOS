@extends('layouts.app')

@section('content')

  <div class="m-3">
      <h3>Rekap Laporan Penjualan</h3>

      <input type="text" name="dates" id="dates" value="" />
    <button id="getReport">Lihat</button>
    <br>
    <br>
    
    <div class="daterange">

    </div>
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
          </tbody>
        </table>
  </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="{{asset('js/app.js')}}"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

  <script>
    var value_start_date;
    var value_end_date;
    var value_show_start_date;
    var value_show_end_date;

    $('input[name="dates"]').daterangepicker({
        opens: 'left'
      }, function(start, end, label) {
        value_start_date = start.format('YYYY-MM-DD');
        value_end_date = end.format('YYYY-MM-DD');
        value_show_start_date = start.format('MMMM D, YYYY');
        value_show_end_date = end.format('MMMM D, YYYY')
      });

    $('#getReport').on('click', function(){
      console.log(value_start_date);
      var markup = "";
      $.ajax({
        url: '/getMasterReport',
        method: 'GET',
        data: {
          startDate : value_start_date,
          endDate : value_end_date
        },
        success: function(data){
          console.log(data);
          
          $.each(data['dataMakanan'], function(index, value){
              // console.log(data['dataMakanan'][index]);
              // console.log(data['dataJumlah'][temp]);
              let temp = data['dataMakanan'][index];
              markup += "<tr> <th scope='row'>1</th> <td>"+ data['dataMakanan'][index] +"</td> <td>"+ data['dataJumlah'][temp] +"</td>";
            });
            daterange = $('.daterange');
            tableBody = $('#rekap');
            daterange.html("<h3>From : "+value_show_start_date +"</h3><br><h3>To : "+value_show_end_date+"</h3>");
            tableBody.html(markup);
        }
      });
    });
  </script>

  <script type="text/javascript">

    $('#generate').on('click', function(){
      var value_report_type = $('#report_type').val();
      var markup = "";
        $.ajax({
          url: '/getMasterReport',
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