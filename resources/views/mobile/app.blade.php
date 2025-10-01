<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Paksayur Mobile</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script>
      // Blade build marker injected BEFORE React bundle evaluates
      window.MOBILE_BLADE_BUILD = '{{ now()->format('Ymd-His') }}';
      console.log('MOBILE_BLADE_BUILD', window.MOBILE_BLADE_BUILD);
      console.log('[MOBILE FLAG]', 'MOBILE_APP_VERSION={{ env('MOBILE_APP_VERSION','legacy') }}');
    </script>
</head>
<body class="mobile-body">
    <div id="root"></div>
    <script src="{{ mix('js/app.js') }}" defer></script>
</body>
</html>
