@extends('layouts.app')

@section('content')
<div class="main-content">
    <div class="container">
        <div class="banner-header banner-lbook3">
            <img src="{{asset('frontend/images/banner-catalog1.jpg')}}" alt="Banner-header">
            <div class="text">
                <h3>Checkout</h3>
                <p><a href="{{ route('home') }}" title="Home">Home</a><i class="fa fa-caret-right"></i>My Profil</p>
            </div>
        </div>
    </div>
   
    <div class="container container-ver2">
        <div id="modal"></div>
        <div class="hoz-tab-container space-padding-tb-30">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                </div>
            @endif
            @if ($message = Session::get('gagal'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button> 
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <ul class="tabs">
                <li class="item" rel="dashboard">Profil</li>
                <li class="item" rel="orders">Orders</li>
            </ul>
            <div class="tab-container">
                <div id="dashboard" class="tab-content">
                    <div class="text">
                        <div class="box border">
                            <h3>Update Profil</h3>
                        </div>
                        <form class="form-horizontal validasi" method="POST" action="{{ route('myaccount.editprofil') }}">
                            @csrf
                            <div class="group box space-20">
                                <label class="control-label" for="inputemailres">Email Adress *</label>
                                <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{Auth::user()->email}}" type="email" placeholder="Silahkan Masukan Email yang valid." id="email" parsley-trigger="change" required>
                                @error('email')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="group box space-20">
                                <label class="control-label" for="inputemailres">No Wa/No Hp *</label>
                                <input class="form-control @error('nohp') is-invalid @enderror" name="nohp" value="{{Auth::user()->nohp}}" type="number" placeholder="Silahkan Masukan No HP/WA." id="nohp" parsley-trigger="change" required>
                                @error('nohp')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="group box space-20">
                                <label class="control-label" for="inputemailres">Nama *</label>
                                <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{Auth::user()->name}}" type="text" placeholder="Silahkan Masukan Nama Lengkap Anda." id="name" parsley-trigger="change" required>
                                @error('name')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="group box space-20">
                                <label class="control-label" for="inputemailres">Alamat *</label>
                                <input class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{Auth::user()->alamat}}" type="text" placeholder="Silahkan Masukan Alamat Lengkap Anda." id="alamat" parsley-trigger="change" required>
                                @error('alamat')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="group box space-20">
                                <label class="control-label" for="inputemailres">Kode Pos *</label>
                                <input class="form-control @error('kodepos') is-invalid @enderror" name="kodepos" value="{{Auth::user()->kodepos}}" type="text" placeholder="Silahkan Masukan Kode Pos Alamat Anda." id="kodepos" parsley-trigger="change" required>
                                @error('kodepos')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- <div class="group box space-20">
                                <label class="control-label" for="inputemailres">Password *</label>
                                <input class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" type="password" placeholder="Silahkan Masukan Password." id="password" parsley-trigger="change" required>
                                @error('password')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="group box space-20">
                                <label class="control-label" for="inputemailres">Re-enter Password *</label>
                                <input class="form-control" name="password_confirmation" type="password" placeholder="Silahkan Ulangi Password yang anda isikan.." id="password-confirm" parsley-trigger="change" required>
                            </div> --}}
                            <button type="submit" class="link-v1 rt">Update Profil</button>
                        </form>
                    </div>
                </div>
                <div id="orders" class="tab-content">
                    <div class="box border">
                        <h3>Orders</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order Id</th>
                                        <th>Tgl Pesan</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order as $item)
                                        <tr>
                                            <td>{{$item->id}}</td>
                                            <td>{{$item->created_at}}</td>
                                            <td>
                                                @if ($item->status == 0)
                                                    Menunggu Konfirmasi 
                                                @elseif($item->status == 1)
                                                    Transaksi dalam proses
                                                @elseif($item->status == 2)
                                                    Transaksi Selesai
                                                @else
                                                    Transaksi Di Tolak
                                                @endif
                                            </td>
                                            <td>Rp.{{number_format($item->total, 0, ',', '.')}} </td>
                                            <td><a href="javascript:void(0);" class="view" data-id="{{$item->id}}">View</a> | <a target="_blank" href="http://wa.me/6281241938647" class="view">Complaint</a></td>
                                        </tr>    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col">
                                <ul class="pagination float-right">
                                    {{ $order->links() }}
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- End cat-box-container -->
</div>
@endsection
@section('scriptjs')
<script src="{{asset('frontend/js/js/account.js')}}"></script>
@endsection