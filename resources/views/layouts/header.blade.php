<!DOCTYPE html>
<html lang="en-US" class="no-js scheme_default">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="Cache-Control: public, max-age=31536000"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>
    <meta name="google-site-verification" content="kz0jW8P0ZXYec37awl79cMX367AGpQ_haFp6GB0l7Fc" />
    <meta name="msvalidate.01" content="058CE2BBE3EF9D932E6FA366CAC4120F" />
   
    <!--<meta name="facebook-domain-verification" content="ijicroog46un4zpog2phqh297tt92n" />-->
    <link rel="icon" type="image/png" defer href="{{ secure_asset("assets/images/favicon-32x32.png") }}" sizes="32x32"/>
    <link rel="icon" type="image/png" defer href="{{ secure_asset("assets/images/favicon-16x16.png") }}" sizes="16x16"/>
    @php
        $site_settings_main=[];
            $settingsAll = App\settings::all();
                    foreach ($settingsAll as $setting) {
                        $site_settings_main[$setting->field_name] = $setting->field_value;
                    }
    @endphp
        @hasSection('title') <title>@yield('title')</title> @else
        <title>{{ $site_settings_main["site_title"] }}</title> @endif
    @hasSection('meta_description')
        <meta name="description" content="@yield('meta_description')"> @else
        <meta name="description" content="{{ $site_settings_main["meta_description"] }}"> @endif
    @hasSection('meta_keyword')
        <meta name="keywords" content="@yield('meta_keyword')"> @else
        <meta name="keywords" content="{{ $site_settings_main["meta_keyword"] }}">@endif


    <script src="{{ secure_asset('assets/front/js/jquery.min.js') }}"></script>
@if (Route::currentRouteName() == 'main')  
    <!--<link rel="stylesheet"  href='{{ secure_asset("assets/css/menu.css") }}'  media="all" type='text/css'/>-->
    <!--<link rel="stylesheet"  href='{{ secure_asset("assets/front/parkingzone/css/all_home.css") }}'  media="all" type='text/css'/>-->
    <style>
        
    </style>
@else
    <link rel="stylesheet"  href='{{ secure_asset("assets/front/parkingzone/css/all.css") }}'  media="all" type='text/css'/>
@endif

    <link rel='dns-prefetch' href='https://ajax.googleapis.com'/>

    <link rel='dns-prefetch' href='https://fonts.googleapis.com'/>
     <link rel="canonical" href="{{ str_replace("","/",Request::fullUrl()) }}" /> 
   <!-- <link rel="canonical" href="{{ str_replace("//","/",Request::fullUrl()) }}" /> -->

    <meta name="twitter:title" content="{!!   $site_settings_main["site_twitter_title"] !!}">
    <meta property="og:title" content="{!!   $site_settings_main["site_og_title"] !!}">
    <meta property="og:type" content="{!!   $site_settings_main["site_og_type"] !!}">
    <meta property="og:image" content="{!!   $site_settings_main["site_og_image"] !!}">
    <meta property="og:url" content="{!!   $site_settings_main["site_og_url"] !!}">
    <meta name="robots" content="">
    <meta name="author" content="{!!   $site_settings_main["site_author"] !!}">

    {!!   $site_settings_main["site_schema"] !!}

@if (\Request::is('main'))  
   
@else

@endif
{!!   $site_settings_main["site_schema"] !!}


<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-T3WQBWX');</script>
<!-- End Google Tag Manager -->




<!-- Global site tag (gtag.js) - Google Analytics -->
<script src="https://www.googletagmanager.com/gtag/js?id=UA-129660178-1"></script>

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-129660178-1');
</script>

<noscript id="deferred-styles">
    
<!--<link rel="stylesheet"  type="text/css" href="{{url('theme/styles/bootstrap4/bootstrap.min.css')}}">-->

<!--<link href="{{url('theme/plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}"  rel="stylesheet" type="text/css">-->
</noscript>

<script>
  var loadDeferredStyles = function() {
    var addStylesNode = document.getElementById("deferred-styles");
    var replacement = document.createElement("div");
    replacement.innerHTML = addStylesNode.textContent;
    document.body.appendChild(replacement)
    addStylesNode.parentElement.removeChild(addStylesNode);
  };
  var raf = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
      window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
  if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
  else window.addEventListener('load', loadDeferredStyles);
</script>

    
<link rel="stylesheet"  type="text/css" href="{{url('theme/styles/bootstrap4/bootstrap.min.css')}}">

<!--<link href="{{url('theme/plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}"  rel="stylesheet" type="text/css">-->
<link rel="stylesheet"   type="text/css" href="{{url('theme/plugins/OwlCarousel2-2.2.1/owl.carousel.css')}}">
<link rel="stylesheet"  type="text/css" href="{{url('theme/plugins/OwlCarousel2-2.2.1/owl.theme.default.css')}}">
<link rel="stylesheet"  type="text/css" href="{{url('theme/plugins/OwlCarousel2-2.2.1/animate.css')}}">
<link rel="stylesheet"   type="text/css" href="{{ secure_asset('assets/front/css/datepicker.css') }}" media="all">

<!--<link rel="stylesheet"   type="text/css" href="{{url('theme/styles/responsive.css')}}">-->
<link rel="stylesheet"  type="text/css" href="{{url('theme/styles/main_styles.css')}}">
<link rel="stylesheet"  type="text/css" href="{{url('theme/styles/index-main.css')}}">
<!-- Facebook Pixel Code -->
<?php /*
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '474510773562678');
  fbq('track', 'PageView');
</script>

 */ ?>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=474510773562678&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "e29av9oghi");
</script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-11007667491"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-11007667491');
</script>
<!-- Bing tracking-->
<script>(function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[],f=function(){var o={ti:"343006614"};o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")},n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function(){var s=this.readyState;s&&s!=="loaded"&&s!=="complete"||(f(),n.onload=n.onreadystatechange=null)},i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)})(window,document,"script","//bat.bing.com/bat.js","uetq");</script>

</head>


<body>

<div class="super_container">
    
    <!-- Header -->

        <!-- Main Navigation -->