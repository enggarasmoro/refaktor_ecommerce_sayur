<html>
	<head>
		<title>Paksayur | Invoice Order</title>
		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{asset('backoffice/vendor/bootstrap/css/bootstrap.css')}}" />
		<link rel="stylesheet" id="css-main" href="{{asset('bo/css/oneui.min.css')}}">
	</head>
	<body>
		 <!-- Main Container -->
		 <main id="main-container">
			<!-- Page Content -->
			<div class="content content-boxed">
				<!-- Invoice -->
				<div class="block">
					<div class="block-header">
						<h3 class="block-title">{{$order->id}}</h3>
					</div>
					<div class="block-content">
						<div class="p-sm-4 p-xl-7">
							<!-- Invoice Info -->
							<div class="row mb-4">
								<!-- Company Info -->
								<div class="col-6 font-size-sm">
									<p class="h3">Paksayur.com</p>
									<address>
										Pagesangan Regency A20<br>
										Jambangan,Surabaya<br>
										paksayursub@gmail.com<br>
										Tanggal Kirim : {{$order->tgl_kirim}}<br>
										Pengiriman : {{$order->pengiriman}}<br>
										Metode Pembayaran : {{($order->id_bank == "COD")?"COD":"Transfer ".$order->namabank}}<br>
										Catatan : {{($order->note == null)?"-":$order->note}}<br>
										Pengemasan : {{$order->package}}
									</address>
								</div>
								<!-- END Company Info -->

								<!-- Client Info -->
								<div class="col-6 text-right font-size-sm">
									<p class="h3">Pembeli</p>
									<address>
									    {{$order->nama}}<br>
										{{$order->alamat}}<br>
										{{$order->namakota}},{{$order->kodepos}}<br>
										{{$order->nohp}}<br>
										{{$order->email}}
									</address>
								</div>
								<!-- END Client Info -->
							</div>
							<!-- END Invoice Info -->

							<!-- Table -->
							<div class="table-responsive push">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th class="text-center" style="width: 60px;"></th>
											<th>Produk</th>
											<th class="text-center" style="width: 90px;">Qty</th>
											<th class="text-right" style="width: 120px;">Harga</th>
											<th class="text-right" style="width: 120px;">Total</th>
										</tr>
									</thead>
									<tbody>
										@php
											$total = 0;
											$no = 1;
											if (isset($order) && $order->nominal != null){
												$kupon = $order->nominal;
											}else{
												$kupon = 0;
											}             
										@endphp
										@foreach ($order_detail as $value)
											<tr>
												<td class="text-center">{{$no}}</td>
												<td>
													<p class="font-w600 mb-1">{{$value->namaproduk}}</p>
												</td>
												<td class="text-center">
													{{$value->qty}}
												</td>
												<td class="text-right"><?php echo "Rp " . number_format($value->harga); ?></td>
												<td class="text-right"><?php echo "Rp " . number_format($value->total); ?></td>
											</tr>
											@php
												$total += $value->total;
												$no++;
											@endphp
										@endforeach
										<tr>
											<td colspan="4" class="font-w600 text-right">Subtotal</td>
											<td class="text-right"><?php echo "Rp " . number_format($total); ?></td>
										</tr>
										@if ($order->id_bank != "COD")
											<tr>
												<td colspan="4" class="font-w600 text-right">Kode Unik</td>
												<td class="text-right"><?php echo "Rp " . number_format($order->kode_unik); ?></td>
											</tr>
										@endif
										<tr>
											<td colspan="4" class="font-w600 text-right">Ongkos Kirim</td>
											<td class="text-right"><?php echo "Rp " . number_format($order->ongkir); ?></td>
										</tr>
										<?php if ($order->harga_package != 0) { ?>
											<tr>
												<td colspan="4" class="font-w700 text-right bg-body-light">Biaya Pengemasan</td>
												<td class="font-w700 text-right bg-body-light"><?php echo "Rp " . number_format($order->harga_package); ?></td>
											</tr>
										<?php } ?>
										<?php if ($order->nominal != null) { ?>
											<tr>
												<td colspan="4" class="font-w700 text-right bg-body-light">Diskon</td>
												<td class="font-w700 text-right bg-body-light"><?php echo "- Rp " . number_format($order->nominal); ?></td>
											</tr>
										<?php } ?>
										<tr>
											<td colspan="4" class="font-w700 text-right bg-body-light">Total</td>
											<td class="font-w700 text-right bg-body-light"><?php echo "Rp " . number_format($order->total); ?></td>
										</tr>
									</tbody>
								</table>
							</div>
							<!-- END Table -->

							<!-- Footer -->
							<p class="font-size-sm text-muted text-center py-3 my-3 border-top">
								Thank you very much for doing business with us. We look forward to working with you again!
							</p>
							<!-- END Footer -->
						</div>
					</div>
				</div>
				<!-- END Invoice -->
			</div>
			<!-- END Page Content -->
		</main>
		<!-- END Main Container -->

		<script>
			window.print();
		</script>
	</body>
</html>