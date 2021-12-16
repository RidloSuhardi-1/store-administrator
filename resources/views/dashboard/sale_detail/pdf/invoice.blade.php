<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <title>Faktur Penjualan | {{ $sales->invoice_no }}</title>

  </head>
  <body>

    <div class="container-fluid mt-5">

        <h2>Faktur Penjualan</h2>

        <table class="table table-sm table-borderless">
            <tbody>
                <tr scope="col">
                    <td>Tanggal Order</td>
                    <td>: {{ $sales->created_at }}</td>
                </tr>
                <tr scope="col">
                    <td>Nomor Order</td>
                    <td>: <strong>{{ $sales->invoice_no }}</strong></td>
                </tr>
            </tbody>
        </table>

        <hr class="my-2">
        <table class="table table-sm table-borderless">
            <tbody>
                <tr scope="col">
                    <td style="width: 150px;">Dijual Kepada</td>
                    <td>: {{ $sales->customer->name }}</td>
                </tr>
                <tr scope="col">
                    <td style="width: 150px">Alamat</td>
                    <td>: Jl Cengkareng Barat No. 7</td>
                </tr>
                <tr scope="col">
                    <td style="width: 30%">Jumlah Pembelian</td>
                    <td>: {{ $sales->amount }}</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-bordered">
            <thead class="thead-light">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Kuantitas</th>
                <th scope="col">Unit</th>
                <th scope="col">Harga Satuan (Rp)</th>
                <th scope="col">Jumlah (Rp)</th>
              </tr>
            </thead>
                <tbody>
                    @php ($total = 0)

                    @if ($sale_details->isNotEmpty())
                        @foreach ($sale_details as $sd)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $sd->product[0]->name }}</td>
                                <td>{{ $sd->amount }}</td>
                                <td>{{ $sd->product[0]->unit }}</td>
                                <td>{{ number_format($sd->product[0]->buy_price, 2, ',', '.') }}</td>
                                <td>{{ number_format($sd->product[0]->buy_price * $sd->amount, 2, ',', '.') }}</td>
                            </tr>
                            @php ($total += ($sd->product[0]->buy_price * $sd->amount))
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                    @endif
                    <tr>
                        <th colspan="4" scope="row">Keterangan : </th>
                        <td>Jumlah Total</td>
                        <td>{{ number_format($total, 2, ',', '.') }}</td>
                    </tr>
                </tbody>
          </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
  </body>
</html>
