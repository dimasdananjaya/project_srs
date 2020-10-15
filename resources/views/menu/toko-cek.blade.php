@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3><b>Cek Toko</b></h3>
        </div><!--card-header-->
        <div class="card-body">
            <table id="tabel-cek-toko" class="table table-stripped table-bordered">
                <thead>
                    <th>Tanggal</th>
                    <th>Total Penjualan</th>
                    <th>Pokok</th>
                    <th>Untung</th>
                    <th>Tunai</th>
                    <th>Transfer</th>
                    <th>Bon</th>
                </thead>
                <tbody>
                    @for($i = 0; $i < count($tanggal); $i++) 
                        <tr>
                            <td>{{$tanggal[$i]}}</td>
                            @php
                                $cekToko=DB::select(DB::raw(" 
                                select tanggal, sum(total_akhir) as total_penjualan, 
                                sum(total_harga_pokok) as pokok from penjualan
                                where id_toko = $idToko
                                and tanggal = '$tanggal[$i]'"));

                                $cash=DB::select(DB::raw(" 
                                select sum(total_akhir) as cash from penjualan
                                where jenis_pembayaran='cash'
                                and id_toko = $idToko
                                and tanggal = '$tanggal[$i]'"));

                                $transfer=DB::select(DB::raw(" 
                                select sum(total_akhir) as transfer from penjualan
                                where jenis_pembayaran='transfer'
                                and id_toko = $idToko
                                and tanggal = '$tanggal[$i]'"));

                                $bon=DB::select(DB::raw(" 
                                select sum(jumlah_pembayaran) as total_bayar_bon from pembayaran_bon                                               
                                where id_toko = $idToko
                                and tanggal = '$tanggal[$i]'"));                                
                            @endphp

                            @foreach ($cekToko as $ct)
                                @php
                                    $x=$ct->total_penjualan;
                                    $y=$ct->pokok;
                                    
                                    $untung=$x-$y;

                                @endphp
                                    <td> Rp. {{ number_format($ct->total_penjualan, 2, ',', '.') }}</td>
                                    <td> Rp. {{ number_format($ct->pokok, 2, ',', '.') }}</td>
                                    <td> Rp. {{ number_format($untung, 2, ',', '.') }}</td> 
                                @foreach ($cash as $cash)
                                    <td> Rp. {{ number_format($cash->cash, 2, ',', '.') }}</td>
                                @endforeach

                                @foreach ($transfer as $transfer)
                                    <td> Rp. {{ number_format($transfer->transfer, 2, ',', '.') }}</td>
                                @endforeach

                                @foreach ($bon as $bon)
                                    <td> Rp. {{ number_format($bon->total_bayar_bon, 2, ',', '.') }}</td>
                                @endforeach

                            @endforeach 
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div><!--card-body-->
    </div><!--card-->
@endsection