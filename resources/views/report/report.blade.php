@extends('layouts.app')

@section('content')

<div class="m-3">
    <h3>Rekap Laporan Penjualan</h3>

    

    <form method="POST" action="/getMasterReport">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control" name="dates" id="dates"/>     
        </div>
        <div class="form-group">
            <select id="kategori" class="form-control" name="kategori">
                <option selected value="all">All</option>
                <option value="makanan">Makanan</option>
                <option value="minuman">Minuman</option>
                <option value="snack">Snack</option>
            </select>
        </div>
        <input id="startDate" type="hidden" name="startDate">
        <input id="endDate" type="hidden" name="endDate">
        <button type="submit" id="getReport" class="btn btn-primary">Lihat</button>
    </form>
    
  <br>
  <br> 

</div> 

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="{{asset('js/app.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    

<script>
    $('input[name="dates"]').daterangepicker({
        opens: 'left'
      }, function(start, end, label) {
         $('#startDate').val(start.format('YYYY-MM-DD'));
         $('#endDate').val(end.format('YYYY-MM-DD'));
      });
</script>

<script>
    $('#masterReport').DataTable();
</script>

@endsection