<!DOCTYPE html>
 <html lang="en">
 <head>
      <!-- Messenger Chat plugin Code -->
    <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v10.0'
          });
        };

        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
      </script>

      <!-- Your Chat plugin code -->
      <div class="fb-customerchat"
        attribution="page_inbox"
        page_id="106900561507265">
      </div>
     <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-RZH3HVBGTY"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-RZH3HVBGTY');
    </script>
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <title>@yield('title', 'FlingEx - Pack, Send And Relax')</title>
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta property="og:title" content="@yield('title', 'FlingEx - Pack, Send And Relax')" />
    <meta property="og:image" content="https://flingex.com/public/frontEnd/images/flingex_og.jpeg" />
    <meta property="og:description" content="@yield('description', 'FlingEx is one of the fastest and reliable courier service organization. We are delivering your parcel to your preferred destination with great care.')" />
    
    <meta property="og:site_name" content="FlingEx" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{  Request::url() }}" />
    <link rel="canonical" href="{{  Request::url() }}" />
    <!-- Twitter -->
    <meta name="twitter:title" content="@yield('title', 'FlingEx - Pack, Send And Relax')">
    <meta name="twitter:description" content="@yield('description', 'FlingEx is one of the fastest and reliable courier service organization. We are delivering your parcel to your preferred destination with great care.')">
    <meta name="twitter:image" content="https://flingex.com/public/frontEnd/images/twitter.png">
    <!--<meta name="twitter:site" content="@USERNAME">-->
    <!--<meta name="twitter:creator" content="@USERNAME">-->
     <!--@foreach($whitelogo as $wlogo)-->
     <!--<link rel="shortcut icon" type="image/jpg" href="{{asset($wlogo->image)}}"/>-->
     <!--@endforeach-->
     <!--====== Favicon Icon ======-->
     <link rel="apple-touch-icon" sizes="57x57" href="https://flingex.com/public/frontEnd/images/icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="https://flingex.com/public/frontEnd/images/icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="https://flingex.com/public/frontEnd/images/icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="https://flingex.com/public/frontEnd/images/icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="https://flingex.com/public/frontEnd/images/icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="https://flingex.com/public/frontEnd/images/icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="https://flingex.com/public/frontEnd/images/icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="https://flingex.com/public/frontEnd/images/icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="https://flingex.com/public/frontEnd/images/icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="https://flingex.com/public/frontEnd/images/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://flingex.com/public/frontEnd/images/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="https://flingex.com/public/frontEnd/images/icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://flingex.com/public/frontEnd/images/icon/favicon-16x16.png">
    <link rel="manifest" href="https://flingex.com/public/frontEnd/images/icon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="https://flingex.com/public/frontEnd/images/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="{{asset('public/frontEnd')}}/assets/css/bootstrap.min.css">
     <!-- Icon -->
     <link rel="stylesheet" href="{{asset('public/frontEnd')}}/assets/fonts/line-icons.css">
     <link rel="stylesheet" href="{{asset('public/frontEnd')}}/css/fontawesome-all.min.css">
     <!-- Owl carousel -->
     <link rel="stylesheet" href="{{asset('public/frontEnd')}}/assets/css/owl.carousel.min.css">
     <link rel="stylesheet" href="{{asset('public/frontEnd')}}/assets/css/owl.theme.css">
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/dist/css/toastr.min.css">
     <!-- Animate -->
     <link rel="stylesheet" href="{{asset('public/frontEnd')}}/assets/css/animate.css">
     <!-- Main Style -->
     <link rel="stylesheet" href="{{asset('public/frontEnd')}}/assets/css/main.css">
     <!-- Responsive Style -->
     <link rel="stylesheet" href="{{asset('public/frontEnd')}}/assets/css/responsive.css">

 </head>

 <body>
     <!-- Header Area wrapper Starts -->
     <header id="header-wrap">
         <!-- Navbar Start -->
         <nav class="navbar navbar-expand-md bg-inverse fixed-top scrolling-navbar">
             <div class="container">
                 <!-- Brand and toggle get grouped for better mobile display -->
                 <a href="{{url('/')}}" class="navbar-brand">
                  @foreach($whitelogo as $wlogo)
                  <img src="{{asset($wlogo->image)}}" alt="">
                  @endforeach
                </a> 
                 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                     <i class="lni-menu"></i>
                 </button>
                 <div class="collapse navbar-collapse" id="navbarCollapse">
                     <ul class="navbar-nav mr-auto w-100 justify-content-end clearfix">
                         <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                             <a class="nav-link" href="{{url('/')}}">
                                 Home
                             </a>
                         </li>
                         <!--<li class="nav-item {{ Request::is('about-us') ? 'active' : '' }}">-->
                         <!--    <a class="nav-link" href="{{url('about-us')}}">-->
                         <!--        About Us-->

                         <!--    </a>-->

                         <!--</li>-->

                         <li class="nav-item dropdown {{ Request::is('our-service/') ? 'active' : '' }}">
                             <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 Services<i class="lni lni-chevron-down"></i>
                             </a>
                             <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @foreach($services as $key=>$value)
                                 <a class="dropdown-item" href="{{url('our-service/'.$value->id)}}">
                             <i class="lni {{$value->icon}}"></i> {{$value->title}}</a>
                                 @endforeach
                             </div>
                         </li>
                         <li class="nav-item {{ Request::is('pricing') ? 'active' : '' }}">
                             <a class="nav-link" href="{{url('')}}#pricing">
                                 Pricing
                             </a>
                         </li>
                         <li class="nav-item {{ Request::is('one-time-service') ? 'active' : '' }}">
                             <a class="nav-link" href="{{url('')}}#one-time-service">
                                 Pick & Drop
                             </a>
                         </li>
                         <li class="nav-item {{ Request::is('gallery') ? 'active' : '' }}">
                             <a class="nav-link" href="{{url('gallery')}}">
                                 Gallery
                             </a>
                         </li>
                         <li class="nav-item {{ Request::is('notice') ? 'active' : '' }}">
                             <a class="nav-link" href="{{url('notice')}}">
                                 Notice
                             </a>
                         </li>
                         <li class="nav-item {{ Request::is('contact-us') ? 'active' : '' }}">
                             <a class="nav-link" href="{{url('contact-us')}}">
                                 Contact
                             </a>
                         </li>
                         <li class="nav-item quicktech-register {{ Request::is('merchant/register') ? 'active' : '' }}">
                             <a class="nav-link " href="{{url('merchant/register')}}">
                                 Register
                             </a>
                         </li>
                         <li class="nav-item quicktech-register {{ Request::is('merchant/login') ? 'active' : '' }}">
                             <a class="nav-link" href="{{url('merchant/login')}}">
                                 Login
                             </a>
                         </li>
                     </ul>
                 </div>
             </div>
         </nav>
         <!-- Navbar End -->

     </header>
      <!-- Hero Area Start -->
     <!-- Header Area wrapper End -->
    @yield('content')
     <!-- Footer Section Start -->
     <footer id="footer" class="footer-area section-padding">
         <div class="container">
             <div class="container">
                 <div class="row">
                     <!--
                     <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-mb-12">
                         <div class="widget">
                             <h3 class="footer-logo"><img src="{{asset('public/frontEnd')}}/assets/img/logo.png" alt=""></h3>
                             <div class="textwidget">
                                 <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque lobortis tincidunt est, et euismod purus suscipit quis.</p>
                             </div>
                             
                         </div>
                     </div>
-->
                     <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                         <h3 class="footer-titel"> Services</h3>
                         <ul class="footer-link">
                             <li><a href="/our-service/1">Home Delivery</a></li>
                             <li><a href="/our-service/2">Pick and Drop</a></li>
                             <li><a href="/our-service/3">Warehousing</a></li>
                             <li><a href="/our-service/4">Cash On Delivery</a></li>
                             <li><a href="/our-service/5">Logistics Services</a></li>
                        
                             <li><a href="/our-service/6">Local Courier Service</a></li>
                             <li><a href="/our-service/7">Online Parcel Delivery</a></li>
                             <li><a href="/our-service/8">Food Delivery</a></li>

                         </ul>
                     </div>
                     <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                         <h3 class="footer-titel">Quick Links</h3>
                         <ul class="footer-link">
                             <li><a href="{{url('/about-us')}}">
                                     About Us
                                 </a></li>
                             <li><a href="{{url('/')}}#pricing">
                                     Pricing
                                 </a></li>
                             <li><a href="{{url('/')}}#one-time-service">Pick & Drop</a></li>
                             <li><a href="{{url('career')}}">Career</a></li>
                             <li><a href="{{url('/gallery')}}">Gallery</a></li>
                             <li><a href="{{url('/contact-us')}}">Contact Us</a></li>
                             <li><a href="{{url('/merchant/register')}}">Register</a></li>
                             <li><a href="{{url('/merchant/login')}}">Login </a></li>
                         </ul>
                     </div>
                     <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                         <h3 class="footer-titel">Contact</h3>
                         <ul class="address">
                             <li>
                                 <a href="#"><i class="lni-map-marker"></i>H# 17, Road #5, Block #B, Kaderabad Housing, Mohammadpur, Dhaka-1207</a>
                             </li>
                             <li>
                                 <a href="tel:09666-911-629"><i class="lni-phone-handset"></i> 09666 911 629</a>
                             </li>
                             <li>
                                 <a href="mailto:info@flingex.com"><i class="lni-envelope"></i>info@flingex.com
                                 </a>
                             </li>
                         </ul>
                         <br/> 
                         <ul class="footer-link">
                            <a class="d-block" href="https://flingex.com/flingex.apk" role="button">
                                <img class="d-app-icon" src="https://mmart.com.bd/storage/app/public/png/google_app.png" alt="" style="max-width: 250px">
                            </a>
                             <div class="social-icon">
                                 <a class="facebook" href="https://www.facebook.com/flingex" target="_blank"><i class="lni-facebook-filled"></i></a>
                                 <a class="twitter" href="#" target="_blank"><i class="lni-twitter-filled"></i></a>
                                 <a class="instagram" href="https://www.instagram.com/fling.ex/" target="_blank"><i class="lni-instagram-filled"></i></a>
                                 <a class="linkedin" href="https://www.linkedin.com/company/flingex" target="_blank"><i class="lni-linkedin-filled"></i></a>
                             </div>
                         </ul>

                     </div>
                     <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">

                         
                     </div>
                     <!--<div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">-->
                     <!--    <ul class="footer-link">-->

                     <!--        <div class="social-icon">-->
                     <!--            <a class="facebook" href="https://www.facebook.com/packenmove"><i class="lni-facebook-filled"></i></a>-->
                     <!--            <a class="twitter" href="#"><i class="lni-twitter-filled"></i></a>-->
                     <!--            <a class="instagram" href="#"><i class="lni-instagram-filled"></i></a>-->
                     <!--            <a class="linkedin" href="#"><i class="lni-linkedin-filled"></i></a>-->
                     <!--        </div>-->
                     <!--    </ul>-->
                     <!--</div>-->
                     <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">

                        
                     </div>
                 </div>
             </div>
         </div>
         <div id="copyright">
             <div class="container">
                 <div class="row">
                     <div class="col-md-12">
                         <div class="copyright-content">
                             <p>© 2021 Flingex. All rights reserved. Developed by <a href="https://evertechit.com" target="_blank">Evertech IT</a></p>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </footer>
     <!-- Footer Section End -->

     <!-- Go to Top Link -->
     <a href="#" class="back-to-top">
         <i class="lni lni-angle-double-up"></i>
     </a>

     <!-- Preloader -->

 <!--     <div id="preloader">
         <div class="loader" id="loader-1">
             <img src="{{asset('public/frontEnd')}}/assets/img/preloader.png" alt="">
         </div>
     </div> -->

     <!-- End Preloader -->


     <!-- jQuery first, then Popper.js, then Bootstrap JS -->
     <script src="{{asset('public/frontEnd')}}/assets/js/jquery-min.js"></script>
     <script src="{{asset('public/frontEnd')}}/assets/js/popper.min.js"></script>
     <script src="{{asset('public/frontEnd')}}/assets/js/bootstrap.min.js"></script>
     <script src="{{asset('public/frontEnd')}}/assets/js/owl.carousel.min.js"></script>
     <script src="{{asset('public/frontEnd')}}/assets/js/wow.js"></script>
     <script src="{{asset('public/frontEnd')}}/assets/js/jquery.nav.js"></script>
     <script src="{{asset('public/frontEnd')}}/assets/js/scrolling-nav.js"></script>
     <script src="{{asset('public/frontEnd')}}/assets/js/jquery.easing.min.js"></script>
     <script src="{{asset('public/frontEnd')}}/assets/js/main.js"></script>
     <script src="{{asset('public/frontEnd')}}/assets/js/form-validator.min.js"></script>
     <script src="{{asset('public/frontEnd')}}/assets/js/contact-form-script.min.js"></script>
      <script src="{{asset('public/backEnd/')}}/dist/js/toastr.min.js"></script>
       {!! Toastr::message() !!}

 </body>

 </html>
