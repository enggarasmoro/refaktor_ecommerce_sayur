@extends('layouts.app')

@section('content')
<div class="container">
    <div class="banner-header banner-lbook3 space-30">
        <img src="{{asset('frontend/images/banner-catalog1.jpg')}}" alt="Banner-header">
        <div class="text">
            <h3>Register</h3>
            <p><a href="{{ route('home') }}" title="Login">Home</a><i class="fa fa-caret-right"></i>Register</p>
        </div>
    </div>
</div>
<!-- End banner -->
<div class="container container-ver2">
    <div class="page-login box space-50">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="register box space-50">
                    <h3>Create A New Account</h3>
                    <form class="form-horizontal validasi" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="group box space-20">
                            <label class="control-label" for="inputemailres">Email Adress *</label>
                            <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" type="email" placeholder="Silahkan Masukan Email yang valid." id="email" parsley-trigger="change" required>
                            @error('email')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="group box space-20">
                            <label class="control-label" for="inputemailres">No Wa/No Hp *</label>
                            <input class="form-control @error('nohp') is-invalid @enderror" name="nohp" value="{{ old('nohp') }}" type="number" placeholder="Silahkan Masukan No HP/WA." id="nohp" parsley-trigger="change" required>
                            @error('nohp')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="group box space-20">
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
                        </div>
                        <button type="submit" class="link-v1 rt">Sign Up</button>
                    </form>
                </div>
            </div>
            <!-- End col-md-6 -->
        </div>
    </div>
</div>
@endsection