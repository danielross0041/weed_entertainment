

<?php $logo = App\Models\logo::where('is_active',1)->orderBy('id','desc')->first(); ?>
@if($logo)
@php $path = $logo->image; @endphp
@else
@php $path = "web/images/logo.png"; @endphp
@endif

<link rel="icon" type="image/x-icon" href="{{asset($path)}}">

<link href="{{asset('web/css/custom.css')}}" rel="stylesheet" type="text/css" />






<link rel="stylesheet" href="{{asset('web/css/bootstrap.min.css')}}">
    <!-- <link rel="stylesheet" href="css/bootstrap.css.map"> -->
    <link rel="stylesheet" href="{{asset('web/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('web/css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
    <link rel="stylesheet" href="{{asset('web/css/custom.css')}}">
<style type="text/css">
	
</style>
@yield('link')

	
