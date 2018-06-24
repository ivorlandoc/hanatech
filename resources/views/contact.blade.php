@extends('layouts/default')

{{-- Page title --}}
@section('title')
Contacto | Hanatech
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/contact.css') }}">
    <!--end of page level css-->
@stop

{{-- breadcrumb --}}
@section('top')
    <div class="breadcum">
       <!-- <div class="container">
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}"> <i class="livicon icon3 icon4" data-name="home" data-size="18" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i>Dashboard
                    </a>
                </li>
                <li class="hidden-xs">
                    <i class="livicon icon3" data-name="angle-double-right" data-size="18" data-loop="true" data-c="#01bc8c" data-hc="#01bc8c"></i>
                    <a href="#">Contacto</a>
                </li>
            </ol>
            <div class="pull-right">
                <i class="livicon icon3" data-name="cellphone" data-size="20" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i> Contacto
            </div>
        </div>-->
    </div>
@stop


{{-- Page content --}}
@section('content')
    <!-- Map Section Start -->
   <!--<div class="">
        <div id="map" style="width:100%; height:400px;"></div>
    </div>-->
    <!-- //map Section End -->
    <!-- Container Section Start -->
   
    <div class="container">
        <div class="row">
            <!-- Contact form Section Start -->
            <div class="col-md-6"> 
                <h2>Contacto</h2>
                <!-- Notifications -->
                <div id="notific">
                @include('notifications')
                </div>
                <form class="contact" id="contact" action="{{route('contact')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group">
                        <input type="text" name="contact-name" class="form-control input-lg" placeholder="Apellidos y Nombres*" required style="height:55px">
                    </div>
                    <div class="form-group">
                        <input type="email" name="contact-email" class="form-control input-lg" placeholder="Email*" required style="height:55px">
                    </div>
                     <div class="form-group">
                        <input type="text" name="contact-asunto" class="form-control input-lg" placeholder="Asunto*" required style="height:55px">
                    </div>
                    <div class="form-group">
                        <textarea name="contact-msg" class="form-control input-lg no-resize resize_vertical" rows="5" placeholder="Mensaje" required></textarea>
                    </div>
                    <div class="login button">
                        <button class="btn btn-success btn-lg btn-block" type="submit">Enviar</button>
                        
                    </div>
                </form>
            </div>
            <!-- //Conatc Form Section End -->
            <div class="col-md-6" >
                
            </div>
            
        </div>
    </div>

    
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/gmaps/js/gmaps.min.js') }}" ></script>
    <!--page level js ends-->
    <script>

        $(document).ready(function() {
            var map = new GMaps({
                el: '#map',
                lat: 38.8921021,
                lng: -77.0260358
            });
            map.addMarker({
                lat: 38.8921021,
                lng: -77.0260358,
                title: 'Washington'
            });
        });
    </script>

@stop
