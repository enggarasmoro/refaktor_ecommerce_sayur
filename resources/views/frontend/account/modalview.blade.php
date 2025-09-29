<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Pesanan Masuk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <h4>Detail Pesanan Masuk</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Nomor Pesanan</td>
                                <td>{{$order->id}}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Order</td>
                                <td>{{$order->created_at}}</td>
                            </tr>
                            <tr>
                                <td>Jam Kirim</td>
                                <td>{{$order->pengiriman}}</td>
                            </tr>
                            <tr>
                                <td>Nama Pemesan</td>
                                <td>{{$order->nama}}</td>
                            </tr>
                            <tr>
                                <td>No Hp Pemesan</td>
                                <td>{{$order->nohp}}</td>
                            </tr>
                            <tr>
                                <td>Email Pemesan</td>
                                <td>{{$order->email}}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>{{"Kota ".$order->namakota." Kodepos ".$order->kodepos}}</td>
                            </tr>
                            <tr>
                                <td>Alamat Lengkap</td>
                                <td>{{$order->alamat}}</td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>{{($order->note != null)?$order->note:"-"}}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    @if ($order->status == "0")
                                        On Hold
                                    @elseif($order->status == "1")
                                        Proses
                                    @elseif($order->status == "2")
                                        Complete
                                    @else
                                        Cancel
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Kuppon</td>
                                <td>{{($order->namakupon != null)?$order->namakupon:"-"}}</td>
                            </tr>
                            <tr>
                                <td>Potongan Kupon</td>
                                <td>{{($order->nominal != null)?$order->nominal:"-"}}</td>
                            </tr>
                            <tr>
                                <td>Payment Method</td>
                                <td>{{($order->id_bank == "COD")?"Cash On Delivery":"Transfer Bank"}}</td>
                            </tr>
                            @if ($order->id_bank != "COD")
                                <tr>
                                    <td>Nama Bank</td>
                                    <td>{{$order->namabank}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>Total Bayar</td>
                                <td>{{"Rp.".number_format($order->total, 0)}}</td>
                            </tr>
                          </tbody>
                    </table>
                </div>

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
                                    {{$value->qty}}
                                </td>
                                <td>
                                    {{$value->harga}}
                                </td>
                                <td>
                                    {{$value->total}}
                                </td>
                            </tr>
                            @php
                                $total += $value->total;
                            @endphp
                        @endforeach
                        <tr>
                            <td colspan="3">Subtotal</td>
                            <td><?php echo "Rp " . number_format($total); ?></td>
                        </tr>
                        @if ($order->id_bank != "COD")
                            <tr>
                                <td colspan="3">Kode Unik</td>
                                <td><?php echo "Rp " . number_format($order->kode_unik); ?></td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="3">Ongkos Kirim</td>
                            <td><?php echo "Rp " . number_format($order->ongkir); ?></td>
                        </tr>
                        <?php if ($order->nominal != null) { ?>
                            <tr>
                                <td colspan="3">Diskon</td>
                                <td> <?php echo "- Rp " . number_format($order->nominal); ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="3"></td>
                            <td> <?php echo "Rp " . number_format($order->total); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="link-v1 rt" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#myModal").modal('show');

    $('#print').on('click', function(e) {
        window.open("{{route('order.showinvoice',$order->id)}}");
    });
</script>