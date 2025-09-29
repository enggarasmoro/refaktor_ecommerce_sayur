<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Paksayur &amp; Login</title>

        <meta name="description" content="Paksayur &amp; Login">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <!-- Open Graph Meta -->
        <meta property="og:title" content="Paksayur &amp; Login">
        <meta property="og:site_name" content="paksayur">
        <meta property="og:description" content="Paksayur &amp; Login">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="{{asset('frontend/images/icon/favicon.png')}}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{asset('frontend/images/icon/cropped-transp-color.png')}}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('frontend/images/icon/cropped-transp-color.png')}}">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Fonts and OneUI framework -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">
        <link rel="stylesheet" id="css-main" href="{{asset('bo/css/oneui.min.css')}}">

        <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
        <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/amethyst.min.css"> -->
        <!-- END Stylesheets -->
    </head>
    <body>
        <!-- Page Container -->
        <div id="page-container">

            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                <div class="hero-static d-flex align-items-center">
                    <div class="w-100">
                        <!-- Sign In Section -->
                        <div class="bg-white">
                            <div class="content content-full">
                                <div class="row justify-content-center">
                                    <div class="col-md-8 col-lg-6 col-xl-4 py-4">
										<!-- Header -->
										@if (session('success'))
											<div class="alert alert-success">{{ session('success') }}</div>
										@endif

										@if (session('error'))
											<div class="alert alert-danger">{{ session('error') }}</div>
										@endif
                                        <div class="text-center">
                                            <p class="mb-2">
                                                <i class="fa fa-2x fa-circle-notch text-primary"></i>
                                            </p>
                                            <h1 class="h4 mb-1">
                                                Sign In
                                            </h1>
                                            <h2 class="h6 font-w400 text-muted mb-3">
                                               Paksayur.com
                                            </h2>
                                        </div>
                                        <!-- END Header -->

                                        <!-- Sign In Form -->
                                        <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js) -->
										<!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
										<form class="js-validation-signin" action="{{ route('bo.signin') }}" method="post">
											@csrf
                                            <div class="py-3">
                                                <div class="form-group">
													<input type="text" class="form-control form-control-lg form-control-alt @error('username') is-invalid @enderror" id="username" name="username" placeholder="Username">
													@error('username')
														<span class="invalid-feedback" role="alert">
															<strong>{{ $message }}</strong>
														</span>
													@enderror
                                                </div>
                                                <div class="form-group">
													<input type="password" class="form-control form-control-lg form-control-alt @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
													<span class="input-group-append">
														@error('password')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</span>
                                                </div>
                                            </div>
                                            <div class="form-group row justify-content-center mb-0">
                                                <div class="col-md-6 col-xl-5">
                                                    <button type="submit" class="btn btn-block btn-primary">
                                                        <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Sign In
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- END Sign In Form -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Sign In Section -->

                        <!-- Footer -->
                        <div class="font-size-sm text-center text-muted py-3">
                            <strong>Ruteksa.com</strong> &copy; <span data-toggle="year-copy"></span>
                        </div>
                        <!-- END Footer -->
                    </div>
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->

        <script src="{{asset('bo/js/oneui.core.min.js')}}"></script>
        <script src="{{asset('bo/js/oneui.app.min.js')}}"></script>

        <!-- Page JS Plugins -->
        <script src="{{asset('bo/js/plugins/jquery-validation/jquery.validate.min.js')}}"></script>

        <!-- Page JS Code -->
        <script src="{{asset('bo/js/pages/op_auth_signin.min.js')}}"></script>
    </body>
</html>