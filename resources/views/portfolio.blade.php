@extends('layouts/default')

{{-- Page title --}}
@section('title')
Tour 
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/portfolio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fancybox/jquery.fancybox.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-buttons.css') }}">
    <!--end of page level css-->
  
@stop

{{-- breadcrumb --}}

@section('top')
   <div class="breadcum">
        <!--<div class="container">
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}"> <i class="livicon icon3 icon4" data-name="home" data-size="18" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i>Dashboard
                    </a>
                </li>
                <li class="hidden-xs">
                    <i class="livicon icon3" data-name="angle-double-right" data-size="18" data-loop="true" data-c="#01bc8c" data-hc="#01bc8c"></i>
                    <a href="#">Portfolio</a>
                </li>
            </ol>
            <div class="pull-right">
                <i class="livicon icon3" data-name="briefcase" data-size="20" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i> Portfolio
            </div>
        </div>-->
    </div>
    @stop


{{-- Page content --}}
@section('content')
    <!-- Container Section Start -->
    <div class="container">
        <h2 id="portfolio_title">HanaTech Videos</h2>
        <!-- Images Section Start -->
        <div class="col-md-12" style="padding: 0">
            <div id="gallery">
               <!-- <div id="portfolio_btns">
                    <button class=" btn filter btn-primary" data-filter="all">ALL</button>
                    <button class="btn filter btn-primary" data-filter=".category-1">HTML</button>
                    <button class=" btn filter btn-primary" data-filter=".category-2">BOOTSTRAP</button>
                </div>-->
             
                <div>
                    <div class="mix category-1" data-my-order="1">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                           <!--<a data-fancybox href="{{ asset('assets/images/gallery/v1.mp4') }}"><i class="fa fa-search-plus"></i></a> -->   


                            <video width="250" height="125" controls id="myVideo">
                                 <source src="{{ asset('assets/images/gallery/v1.mp4') }}" type="video/mp4">
                            </video>
                           <!-- <a href="{{ URL::to('portfolioitem') }}"><i class="fa fa-link"></i></a>-->
                        </div>
                        <!--<div class="thumb_zoom"><img src="{{ asset('assets/images/gallery/10.jpg') }}" class="img-responsive"> </div>-->
                    </div>


                    <div class="mix category-1" data-my-order="2">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <a class="fancybox" href="{{ asset('assets/images/gallery/8.jpg') }}"><i class="fa fa-search-plus"></i></a>
                           <!--  <a href="{{ URL::to('portfolioitem') }}"><i class="fa fa-link"></i></a>-->
                        </div>
                        <div class="thumb_zoom"><img src="{{ asset('assets/images/gallery/8.jpg') }}" class="img-responsive"> </div>
                    </div>

                    <div class="mix category-2" data-my-order="3">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <a class="fancybox" href="{{ asset('assets/images/gallery/7.jpg') }}"><i class="fa fa-search-plus"></i></a>
                           <!--  <a href="{{ URL::to('portfolioitem') }}"><i class="fa fa-link"></i></a>-->
                        </div>
                        <div class="thumb_zoom"><img src="{{ asset('assets/images/gallery/7.jpg') }}" class="img-responsive"> </div>
                    </div>

                    <div class="mix category-1" data-my-order="4">
                        <div class="col-md-3 col-sm-6 col-xs-6">
                            <a class="fancybox" href="{{ asset('assets/images/gallery/16.jpg') }}"><i class="fa fa-search-plus"></i></a>
                            <!-- <a href="{{ URL::to('portfolioitem') }}"><i class="fa fa-link"></i></a>-->
                        </div>
                        <div class="thumb_zoom"><img src="{{ asset('assets/images/gallery/16.jpg') }}" class="img-responsive"> </div>
                    </div>

                                     
                  
                </div>
            </div>
        </div>
        <!-- //Images Section End -->
    </div>
    <!-- Container Section End -->
@stop

{{-- page level scripts --}}
@section('footer_scripts')
     <!-- page level js starts-->
    <script type="text/javascript" src="{{ asset('assets/vendors/mixitup/jquery.mixitup.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/fancybox/jquery.fancybox.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-buttons.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/fancybox/helpers/jquery.fancybox-media.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/portfolio.js') }}"></script>
    <!--page level js ends-->

@stop
