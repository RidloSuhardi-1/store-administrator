<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <title>Faktur Pembelian | {{ $purchases->created_at }}</title>

  </head>
  <body>

    <div class="container-fluid mt-5">

        <div class="row">
            <div class="col">
                <h2>Faktur Pembelian</h2>
            </div>
            <div class="col">
                <table class="table table-sm table-borderless">
                    <tbody>
                        <tr scope="col">
                            <td>Tanggal Order</td>
                            <td>: {{ $purchases->created_at }}</td>
                        </tr>
                        <tr scope="col">
                            <td>Nomor Order</td>
                            <td>: </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr class="my-2">
        <table class="table table-sm table-borderless">
            <tbody>
                <tr scope="col">
                    <td style="width: 150px;">Dijual Kepada</td>
                    <td>: Toko Sembako ELNino</td>
                </tr>
                <tr scope="col">
                    <td style="width: 150px">Alamat</td>
                    <td>: Jl Cengkareng Barat No. 7</td>
                </tr>
                <tr scope="col">
                    <td style="width: 30%">Dikirim Kepada</td>
                    <td>: Toko Sembako ELNino</td>
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

                    @if ($purchase_details->isNotEmpty())
                        @foreach ($purchase_details as $pd)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $pd->product[0]->name }}</td>
                                <td>{{ $pd->amount }}</td>
                                <td>{{ $pd->product[0]->unit }}</td>
                                <td>{{ number_format($pd->product[0]->buy_price, 2, ',', '.') }}</td>
                                <td>{{ number_format($pd->product[0]->buy_price * $pd->amount, 2, ',', '.') }}</td>
                            </tr>
                            @php ($total += ($pd->product[0]->buy_price * $pd->amount))
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
