@extends('layouts.app')

@section('content')
<section id="store-dashboard">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
            <h4>Dashboard Toko : <b> @foreach ($dataToko as $dt) {{$dt->nama_toko}} @endforeach</b></h4>
            </div><!--card-header-->
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="home" aria-selected="true">Sales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#bon" role="tab" aria-controls="profile" aria-selected="false">Bon</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#items-sold" role="tab" aria-controls="contact" aria-selected="false">Items Sold</a>
                </li>
                </ul>
                <div class="tab-content mt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="sales" role="tabpanel" aria-labelledby="home-tab">
                        <!-- Modal -->
                        <div class="modal fade" id="add-orders-modal" tabindex="-1" role="dialog"  aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Order</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('barang.store') }}"  method="POST">
                                            @csrf
                                            <label>Nama Pemesan :</label>
                                            {{ Form::text('nama_pembeli','',['class' => 'form-control form-group'])}}
                                            <label>Kontak Pemesan :</label>
                                            {{ Form::text('kontak_pembeli','',['class' => 'form-control form-group'])}}
                                            <label>Alamat Pengiriman :</label>
                                            {{ Form::text('alamat_pengiriman','',['class' => 'form-control form-group'])}}
                                            {{Form::hidden('id_user', Auth::user()->id_user) }}
                                            {{Form::hidden('status', 'pending') }}
                                            {{-- ... customer name and email fields --}}
                                        
                                            <div class="card">
                                                <div class="card-header">
                                                    Products
                                                </div>
                                        
                                                <div class="card-body">
                                                    <table class="table" id="products_table">
                                                        <thead>
                                                            <tr>
                                                                <th>Items</th>
                                                                <th>Quantity</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr id="product0">
                                                                <td>
                                                                    <select name="products[]" class="form-control form-group">
                                                                        <option value="">-- choose product --</option>
                                                                        @foreach ($dataBarang as $db)
                                                                            <option value="{{ $db->id_barang }}">
                                                                                {{ $db->nama_barang }} (${{ number_format($product->price, 2) }})
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="quantities[]" class="form-control" />
                                                                </td>
                                                            </tr>
                                                            <tr id="product1"></tr>
                                                        </tbody>
                                                    </table>
                                        
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button id="add_row" class="btn btn-success pull-left">+ Add Row</button>
                                                            <button id='delete_row' class="pull-right btn btn-danger">- Delete Row</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label>Total Price :</label>
                                            {{ Form::number('total_price','',['class' => 'form-control form-group'])}}
                                            <div>
                                                <input class="btn btn-primary btn-block" type="submit">
                                            </div>
                                        </form>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div><!--end modal body-->
                                </div><!-- end modal content-->
                            </div><!--end modal dialog-->
                        </div><!--end modal-->
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Position</th>
                                    <th>Office</th>
                                    <th>Age</th>
                                    <th>Start date</th>
                                    <th>Salary</th>
                                    <th>Extn.</th>
                                    <th>E-mail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Tiger</td>
                                    <td>Nixon</td>
                                    <td>System Architect</td>
                                    <td>Edinburgh</td>
                                    <td>61</td>
                                    <td>2011/04/25</td>
                                    <td>$320,800</td>
                                    <td>5421</td>
                                    <td>t.nixon@datatables.net</td>
                                </tr>
                                <tr>
                                    <td>Garrett</td>
                                    <td>Winters</td>
                                    <td>Accountant</td>
                                    <td>Tokyo</td>
                                    <td>63</td>
                                    <td>2011/07/25</td>
                                    <td>$170,750</td>
                                    <td>8422</td>
                                    <td>g.winters@datatables.net</td>
                                </tr>
                                <tr>
                                    <td>Ashton</td>
                                    <td>Cox</td>
                                    <td>Junior Technical Author</td>
                                    <td>San Francisco</td>
                                    <td>66</td>
                                    <td>2009/01/12</td>
                                    <td>$86,000</td>
                                    <td>1562</td>
                                    <td>a.cox@datatables.net</td>
                                </tr>
                                <tr>
                                    <td>Cedric</td>
                                    <td>Kelly</td>
                                    <td>Senior Javascript Developer</td>
                                    <td>Edinburgh</td>
                                    <td>22</td>
                                    <td>2012/03/29</td>
                                    <td>$433,060</td>
                                    <td>6224</td>
                                    <td>c.kelly@datatables.net</td>
                                </tr>
                                <tr>
                                    <td>Airi</td>
                                    <td>Satou</td>
                                    <td>Accountant</td>
                                    <td>Tokyo</td>
                                    <td>33</td>
                                    <td>2008/11/28</td>
                                    <td>$162,700</td>
                                    <td>5407</td>
                                    <td>a.satou@datatables.net</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="bon" role="tabpanel" aria-labelledby="profile-tab">

                    </div>
                    <div class="tab-pane fade" id="items-sold" role="tabpanel" aria-labelledby="contact-tab">

                    </div>
                </div><!--tab content-->
            </div><!--card-body-->
        </div><!--card-->
    </div><!--container-->
</section>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );

    $(document).ready(function(){
            let row_number = 1;
            $("#add_row").click(function(e){
            e.preventDefault();
            let new_row_number = row_number - 1;
            $('#product' + row_number).html($('#product' + new_row_number).html()).find('td:first-child');
            $('#products_table').append('<tr id="product' + (row_number + 1) + '"></tr>');
            row_number++;
            });

            $("#delete_row").click(function(e){
            e.preventDefault();
            if(row_number > 1){
                $("#product" + (row_number - 1)).html('');
                row_number--;
            }
            });
        });
</script>

@endsection