<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$general->site_name}} - {{@$title}}</title>
    @php
      $fav_icon = $general->favicon ?  $general->favicon : "site_favicon.png"
    @endphp
    <link rel="shortcut icon" href="{{showImage(filePath()['site_logo']['path'].'/'.$fav_icon)}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/dimbox.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/default.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/media.css')}}">
    <link rel="stylesheet" href="{{asset('assets/global/css/font_bootstrap-icons.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/color.php') }}?primary_color={{$general->primary_color}}&secondary_color={{$general->secondary_color}}">
</head>
<body>

@include('frontend.partials.header')
<main>
    @yield('content')
</main>
@include('frontend.partials.footer')

<script src="{{asset('assets/global/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/global/js/all.min.js')}}"></script>
<script src="{{asset('assets/global/js/toastr.js')}}"></script>
<script src="{{asset('assets/frontend/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{asset('assets/frontend/js/gsap.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/SplitText.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/slick.min.js')}}"></script>

<script src="{{asset('assets/frontend/js/ScrollTrigger.min.js')}}"></script>

<script src="{{asset('assets/frontend/js/dimbox.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/script.js')}}"></script>
</body>

</html>
