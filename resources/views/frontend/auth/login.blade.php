@extends('layouts.app')

@section('content')
<div class="container">
    <div class="banner-header banner-lbook3 space-30">
        <img src="{{asset('frontend/images/banner-catalog1.jpg')}}" alt="Banner-header">
        <div class="text">
            <h3>Login</h3>
            <p><a href="{{ route('home') }}" title="Login">Home</a><i class="fa fa-caret-right"></i>Login</p>
        </div>
    </div>
</div>
<!-- End banner -->
<div class="container container-ver2">
    <div class="page-login box space-50">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="register box space-50">
                    <h3>Login Account</h3>
                    <form class="form-horizontal validasi" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="group box space-20">
                            <label class="control-label" for="inputemail">Email / No Hp *</label>
                            <input id="email" type="text" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email/No Hp" parsley-trigger="change" required>
                            @error('email')
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="group box">
                            <label class="control-label" for="inputemail">PASSWORD *</label>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" placeholder="Password" parsley-trigger="change" required>
                            @error('password')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="remember">
                            <div class="col">
                                <p>Belum Punya Akun? <a href="{{ route('register') }}">Click here to Register.</a></p>
                            </div>
                        </div>           
                        <button type="submit" class="link-v1 rt">LOGIN NOW</button>
                    </form>
                    <!-- End form -->
                </div>
            </div>
            <!-- End col-md-6 -->
        </div>
    </div>
</div>
@endsection