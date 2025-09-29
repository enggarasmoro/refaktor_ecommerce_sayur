<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Pesanan Masuk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="alert alert-danger alert-block" style="display: none;>
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
            <div class="modal-body p-4">
                <h4>Edit Invoice order</h4>
                <form id="form2">
                    @csrf
                    <input type="hidden" name="id" id="id" value="{{$order->id}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php $value = (isset($order->nama))?$order->nama:""; ?>
                                <label class="required font-weight-bold text-dark text-2">Nama</label>
                                <input type="text" id="nama" name="nama" class="form-control" value="{{ $value }}" parsley-trigger="change" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php $value = (isset($order->email))?$order->email:""; ?>
                                <label class="required font-weight-bold text-dark text-2">Email</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ $value }}" parsley-trigger="change" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php $value = (isset($order->nohp))?$order->nohp:""; ?>
                                <label class="required font-weight-bold text-dark text-2">No Hp</label>
                                <input type="text" id="nohp" name="nohp" class="form-control" value="{{ $value }}" parsley-trigger="change" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php $value = (isset($order->kota))?$order->kota:""; ?>
                                <label class="required font-weight-bold text-dark text-2">Kota</label>
                                <select class="produk form-control" id="kota" name="kota" style="width: 100%;" parsley-trigger="change" required>
                                    @foreach ($kota as $kota)
                                        @if ($kota->id == $value)
                                            <option value="{{$kota->id}}" selected>{{$kota->nama}}</option>
                                        @else
                                            <option value="{{$kota->id}}">{{$kota->nama}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php $value = (isset($order->kodepos))?$order->kodepos:""; ?>
                                <label class="required font-weight-bold text-dark text-2">Kode Pos</label>
                                <input type="text" id="kodepos" name="kodepos" class="form-control" value="{{ $value }}" parsley-trigger="change" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php $value = (isset($order->alamat))?$order->alamat:""; ?>
                                <label class="required font-weight-bold text-dark text-2">Alamat</label>
                                <input type="text" id="alamat" name="alamat" class="form-control" value="{{ $value }}" parsley-trigger="change" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php $value = (isset($order->tgl_kirim))?$order->tgl_kirim:""; ?>
                                <label class="required font-weight-bold text-dark text-2">Tanggal Kirim</label>
                                <input type="text" id="tgl_kirim" name="tgl_kirim" class="form-control datepicker" value="{{ $value }}" parsley-trigger="change" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php $value = (isset($order->jamkirim))?$order->jamkirim:""; ?>
                                <label class="required font-weight-bold text-dark text-2">Jam Kirim</label>
                                <select class="produk form-control" id="jamkirim" name="jamkirim" style="width: 100%;" parsley-trigger="change" required>
                                    @foreach ($jamkirim as $jamkirim)
                                        @if ($jamkirim->id == $value)
                                            <option value="{{$jamkirim->id}}" selected>{{$jamkirim->pengiriman}}</option>
                                        @else
                                            <option value="{{$jamkirim->id}}">{{$jamkirim->pengiriman}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?php $value = (isset($order->id_bank))?$order->id_bank:""; ?>
                                <label class="required font-weight-bold text-dark text-2">Metode Pembayaran</label>
                                <select class="produk form-control" id="id_bank" name="id_bank" style="width: 100%;" parsley-trigger="change" required>
                                    <option value="COD" {{($order->id_bank == "COD")?"selected":""}}>Cash On Delivery</option>
                                    @foreach ($bank as $bank)
                                        @if ($bank->id == $value)
                                            <option value="{{$bank->id}}" selected>{{$bank->nama}}</option>
                                        @else
                                            <option value="{{$bank->id}}">{{$bank->nama}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info waves-effect waves-light">Edit Invoice Order</button>
                </form>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="bg-primary">
                            <tr>
                                <th>
                                    Produk
                                </th>
                                <th>
                                    Qty
                                </th>
                                <th>
                                    Harga
                                </th>
                                <th>
                                    Total Harga
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        @php
                            $total = 0;
                            if (isset($order) && $order->nominal != null){
                                $kupon = $order->nominal;
                            }else{
                                $kupon = 0;
                            }             
                        @endphp
                        @foreach ($order_detail as $value)
                            <tr>
                                <td>
                                    {{$value->namaproduk}}
                                </td>
                                <td>
                                    <input type="hidden" name="id" value="{{$value->id}}">
                                    <input type="hidden" name="idcart" value="{{$order->id}}">
                                    <input type="hidden" name="id_produk" value="{{$value->id_produk}}">
                                    <input type="number" min="1"  id="qty{{$value->id}}" name="qty" class="form-control"  value="{{ $value->qty }}" parsley-trigger="change" required>
                                </td>
                                <td>
                                    {{$value->harga}}
                                </td>
                                <td>
                                    {{$value->total}}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-info waves-effect waves-light" id="edit" onclick="edit('{{$value->id}}','{{$order->id}}','{{$value->id_produk}}')">Edit</button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light" id="remove" onclick="remove('{{$value->id}}','{{$order->id}}','{{$value->id_produk}}')">Remove</button>
                                </td>
                            </tr>
                            @php
                                $total += $value->total;
                            @endphp
                        @endforeach
                    </table>
                </div>
                <h4>Tambah Produk</h4>
                <form id="form" class="parsley-produk">
                    @csrf
                    <input type="hidden" name="id" id="id" value="{{$order->id}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="required font-weight-bold text-dark text-2">Produk</label>
                                <select class="produk form-control" id="id_produk" name="id_produk" style="width: 100%;" parsley-trigger="change" required>
                                    @foreach ($produk as $produk)
                                        <option value="{{$produk->id}}">{{$produk->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="required font-weight-bold text-dark text-2">Qty</label>
                                <input type="number" min="1"  id="qty" name="qty" class="form-control" parsley-trigger="change" required>
                            </div>
                        </div>
                    </div><br>
                    <button type="submit" class="btn btn-info waves-effect waves-light">Add Produk</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var base_url = window.location.origin;
    $("#myModal").modal('show');
    $(".produk").select2();

    function edit(id,idcart,idproduk) {
        var qty = $('#qty'+id).val();
        var url="{{route('order.editqty')}}";
        $.ajax({
            url: url,
            type: "POST",
            data: {id:id,idproduk:idproduk,qty:qty,idcart:idcart},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                // data = JSON.parse(c);
                if (data.errorsvalidation) {
                    $('.alert-danger').html('');
                    $.each(data.errorsvalidation, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                    });
                }else if(data.success){
                    $("#myModal").modal("hide");
                    $('#modal').load(base_url+"/adminpanel/order/showmodaledit/" + idcart);
                } else {
                    $('.alert-danger').html('');
                    $('.alert-danger').show();
                    $('.alert-danger').append('<strong><li>'+data.errors+'</li></strong>');
                }
                
            },
            error: function(c, e, d) {
                $("#myModal").modal("hide");
                Swal.fire("Error", "Gagal Memproses Data", "error")
            }
        });
        return !1
    }

    function remove(id,idcart,idproduk) {
        var url="{{route('order.remove')}}";
        $.ajax({
            url: url,
            type: "POST",
            data: {id:id,idcart:idcart},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                // data = JSON.parse(c);
                if (data.errorsvalidation) {
                    $('.alert-danger').html('');
                    $.each(data.errorsvalidation, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                    });
                }else if(data.success){
                    $("#myModal").modal("hide");
                    $('#modal').load(base_url+"/adminpanel/order/showmodaledit/" + idcart);
                } else {
                    $('.alert-danger').html('');
                    $('.alert-danger').show();
                    $('.alert-danger').append('<strong><li>'+data.errors+'</li></strong>');
                }
                
            },
            error: function(c, e, d) {
                $("#myModal").modal("hide");
                Swal.fire("Error", "Gagal Memproses Data", "error")
            }
        });
        return !1
    }

    $("#form").on("submit", (function(b) {
        b.preventDefault();
        var url = "{{route('order.addproduk')}}";
        var idcart = $('#id').val();
        $.ajax({
            url: url,
            type: "POST",
            data: new FormData(this),
            contentType: !1,
            cache: !1,
            processData: !1,
            success: function(data) {
                // data = JSON.parse(c);
                if (data.errorsvalidation) {
                    $('.alert-danger').html('');
                    $.each(data.errorsvalidation, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                    });
                }else if(data.success){
                    $("#myModal").modal("hide");
                    $('#modal').load(base_url+"/adminpanel/order/showmodaledit/" + idcart);
                } else {
                    $('.alert-danger').html('');
                    $('.alert-danger').show();
                    $('.alert-danger').append('<strong><li>'+data.errors+'</li></strong>');
                }
            },
            error: function(c, e, d) {
                $("#myModal").modal("hide");
                Swal.fire("Error", "Gagal Memproses Data", "error")
            }
        });
        return !1
    }));

    $(".datepicker").datepicker({
         format: 'yyyy-mm-dd',
         autoclose: true,
         startDate: "+1d"
    });

    $("#form2").on("submit", (function(b) {
        b.preventDefault();
        var url = "{{route('order.editorder')}}";
        var idcart = $('#id').val();
        $.ajax({
            url: url,
            type: "POST",
            data: new FormData(this),
            contentType: !1,
            cache: !1,
            processData: !1,
            success: function(data) {
                // data = JSON.parse(c);
                if (data.errorsvalidation) {
                    $('.alert-danger').html('');
                    $.each(data.errorsvalidation, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                    });
                }else if(data.success){
                    $("#myModal").modal("hide");
                    $('#modal').load(base_url+"/adminpanel/order/showmodaledit/" + idcart);
                } else {
                    $('.alert-danger').html('');
                    $('.alert-danger').show();
                    $('.alert-danger').append('<strong><li>'+data.errors+'</li></strong>');
                }
            },
            error: function(c, e, d) {
                $("#myModal").modal("hide");
                Swal.fire("Error", "Gagal Memproses Data", "error")
            }
        });
        return !1
    }));
</script>