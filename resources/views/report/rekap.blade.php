@extends('layouts.app')

@section('content')
	<h3 class="ml-3">{{$data['tanggal']}}</h3>

    <div class="m-3" style="width: 70%;height: 200px">
        <canvas id="myChart"></canvas>
	</div>
	
    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <script>
        var makanan = "<?= $data['makanan'] ?>";
        var minuman = "<?= $data['minuman'] ?>";
        var snack = "<?= $data['snack'] ?>";
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: ["makanan", "minuman", "snack"],
				datasets: [{
					label: 'Rekap Laporan Penjualan',
					data: [makanan, minuman, snack],
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
@endsection