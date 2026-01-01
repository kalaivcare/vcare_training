<head>
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TXB3SPR');</script>
<!-- End Google Tag Manager -->


<!-- Global site tag (gtag.js) - Google Ads: 10784575539 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-10784575539"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js',new Date());

  gtag('config','AW-10784575539');
</script>
<meta charset="utf-8" />
<title>@yield('title') | {{ $project_title }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="title" content="NIHAWS | Online Courses">
<meta name="description" content="{{ $gsetting->meta_data_desc }}" />
<meta name="keywords" content="{{ $gsetting->meta_data_keyword }}">
<meta name="author" content="" />
<meta name="MobileOptimized" content="320" />
<meta name="robots" content="index, follow"> 
<link rel="canonical" href="https://www.nihaws.com/" />
<link rel="shortcut icon" href="#" />
<link rel="icon" type="image/icon" href="{{ asset('images/favicon/'.$gsetting->favicon) }}">

{{-- <link rel="icon" type="image/icon" href="{{ env('AWS_URL').('Storage/images/favicon/'.$gsetting->favicon) }}"> --}}
<!-- theme styles -->
<link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> <!-- bootstrap css -->
<!--<link href="https://fonts.googleapis.com/css?family=Great+Vibes|Poppins:300,400,500,700&display=swap" rel="stylesheet"> -->
<!--<link href="https://fonts.googleapis.com/css?family=Muli&display=swap:400,500,600,700" rel="stylesheet">-->
<link href='https://fonts.googleapis.com/css?family=Open Sans&display=swap' rel='stylesheet'>
<link rel="stylesheet" href="{{ url('vendor/fontawesome/css/all.css') }}" /> <!--  fontawesome css -->
<link rel="stylesheet" href="{{ url('vendor/font/flaticon.css') }}" /> <!-- fontawesome css -->
<link rel="stylesheet" href="{{ url('vendor/navigation/menumaker.css') }}" /> <!-- navigation css -->
<link rel="stylesheet" href="{{ url('vendor/owl/css/owl.carousel.min.css') }}" /> <!-- owl carousel css -->
<link rel="stylesheet" href="{{ url('vendor/protip/protip.css') }}" /> <!-- menu css -->

<?php
$language = Session::get('changed_language'); //or 'english' //set the system language
$rtl = array('ar','he','ur', 'arc', 'az', 'dv', 'ku'); //make a list of rtl languages
?>
@if (in_array($language,$rtl))
<link href="{{ url('css/rtl.css') }}" rel="stylesheet" type="text/css"/> <!-- rtl css -->
@else

<link href="{{ url('css/style.css') }}" rel="stylesheet" type="text/css"/> <!-- custom css -->
@endif
<link rel="stylesheet" href="{{ url('css/colorbox.css') }}">
<link rel="stylesheet" href="{{url('admin/bower_components/font-awesome/css/font-awesome.min.css')}}"><!-- fontawesome css -->
<link rel="stylesheet" href="{{ url('css/select2.min.css') }}"> <!-- select2 css -->
<link rel="stylesheet" href="{{ URL::asset('css/pace.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('css/protip.css') }}" /> <!-- protip css -->
<link rel="manifest" href="{{url('manifest.json')}}">
<link rel="stylesheet" href="{{ asset('css/custom-style.css') }}"/>

<meta name="csrf-token" content="{{ csrf_token() }}">



<meta name="facebook-domain-verification" content="kztybi9p0s5w1dxjbbtc0r23cvo06m" />




<!-- end theme styles -->
</head>