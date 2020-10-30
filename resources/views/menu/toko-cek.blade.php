@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3><b>Cek Toko : @foreach ($dataToko as $dt) {{$dt->nama_toko}} @endforeach</b></h3>
        </div><!--card-header-->

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="rekap-tab" data-toggle="tab" href="#rekap" role="tab" aria-controls="rekap" aria-selected="true">Rekap</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="barang-terjual-tab" data-toggle="tab" href="#barang-terjual" role="tab" aria-controls="barang-terjual" aria-selected="false">Barang Terjual</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pembayaran-bon-tab" data-toggle="tab" href="#pembayaran-bon" role="tab" aria-controls="pembayaran-bon" aria-selected="false">Pembayaran Bon</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="rekap" role="tabpanel" aria-labelledby="rekap-tab">
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
                            <th>Total Bayar Bon</th>
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
                                        select sum(total_akhir) as total_bon from penjualan                                                
                                        where jenis_pembayaran='bon' 
                                        and id_toko = $idToko
                                        and tanggal = '$tanggal[$i]'"));     
                                        
                                        $bayarBon=DB::select(DB::raw(" 
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
                                            <td> Rp. {{ number_format($bon->total_bon, 2, ',', '.') }}</td>
                                        @endforeach
        
                                        @foreach ($bayarBon as $bb)
                                            <td> Rp. {{ number_format($bb->total_bayar_bon, 2, ',', '.') }}</td>
                                        @endforeach
        
                                    @endforeach 
                                </tr>
                            @endfor
                        </tbody>
                    </table>
        
                     <table class="table table-lg table-striped mt-4 table-bordered">
                        <thead>
                            <th>Total Penjualan</th>
                            <th>Total Pokok</th>
                            <th>Total Keuntungan</th>
                            <th>Total Cash</th>
                            <th>Total Transfer</th>
                            <th>Total Bon</th>
                            <th>Total Bayar Bon</th>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($totalPenjualanDanPokok as $tpdp)
                                    <td><b> Rp. {{ number_format($tpdp->total_penjualan, 2, ',', '.') }} </b></td>
                                    <td><b> Rp. {{ number_format($tpdp->pokok, 2, ',', '.') }} </b></td>
                                    @php
                                     $x=$tpdp->total_penjualan;
                                     $y=$tpdp->pokok;
                                    
                                     $untung=$x-$y;
                                    @endphp
                                    <td><b> Rp. {{ number_format($untung, 2, ',', '.') }}<b></td>
                                @endforeach
        
                                @foreach ($totalPenjualanCash as $tpc)
                                    <td><b> Rp. {{ number_format($tpc->total_penjualan_cash, 2, ',', '.') }}</b></td>
                                @endforeach
                                @foreach ($totalPenjualanTransfer as $tpt)
                                    <td><b> Rp. {{ number_format($tpt->total_penjualan_transfer, 2, ',', '.') }}</b></td>
                                @endforeach
                                @foreach ($totalPenjualanBon as $tpb)
                                    <td><b>Rp. {{ number_format($tpb->total_penjualan_bon, 2, ',', '.') }}</b></td>
                                @endforeach
                                @foreach ($totalBayarBon as $tbb)
                                    <td><b>Rp. {{ number_format($tbb->total_bayar_bon, 2, ',', '.') }}</b></td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>  
        
                </div><!--card-body-->
            </div><!--tab rekap-->
            <div class="tab-pane fade" id="barang-terjual" role="tabpanel" aria-labelledby="barang-terjual-tab">
                ...
            </div><!--penjualan-barang tab-->
            <div class="tab-pane fade" id="pembayaran-bon" role="tabpanel" aria-labelledby="pembayaran-bon-tab">
                ...
            </div><!--pembayaran-bon tab-->
        </div><!--tabs-->
    </div><!--card-->
</div><!--container-fluid-->
@endsection