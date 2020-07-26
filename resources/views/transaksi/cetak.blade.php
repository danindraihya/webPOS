<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=], initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Document</title>
</head>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">Item</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Harga Total</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($barang as $item)
                <tr>
                <th scope="row">{{$item->menu_kode}}</th>
                    <td>{{$item->jumlah}}</td>
                    <td>{{$item->harga}}</td>
                </tr>
            @endforeach
        
        </tbody>
    </table>
    <table>
    
    <br>
    <h6>Kembali : {{$kembali}}</h6>
    <br>
    <h6>Cash : {{$cash}}</h6>
    <br>
    <h6>Total Harga : {{$total_harga}}</h6>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>