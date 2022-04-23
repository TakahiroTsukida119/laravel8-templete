<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="height: 100%">

<head>
    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Base Stylesheets --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link rel="stylesheet" href="{{ asset('css/backend/app.css') }}">
</head>

<body class="sidebar-mini fixed" style="height: 100%">
<div id="app" class="wrapper">
    @yield('content')
</div>
{{-- Base Scripts --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset('js/backend/app.js') }}"></script>

<script>
    @if(session('alert_success'))
    toastr.success('{{ session('alert_success') }}')
    @endif
    @if(session('alert_error'))
    toastr.error('{{ session('alert_error') }}')
    @endif
    @if(session('alert_info'))
    toastr.info('{{ session('alert_info') }}')
    @endif
    @if(session('alert_warning'))
    toastr.warning('{{ session('alert_warning') }}')
    @endif
</script>
</body>

</html>
