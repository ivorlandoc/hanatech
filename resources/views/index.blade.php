@extends('layouts/default')

{{-- Page title --}}
@section('title')
Home | Hanatech
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/tabbular.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/animate/animate.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/jquery.circliful.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/owl_carousel/css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/owl_carousel/css/owl.theme.css') }}">

    <!--end of page level css-->
@stop

{{-- slider --}}
@section('top')
 <div class="breadcum"></div>
    <!--Carousel Start -->
    <!--<div id="owl-demo" class="owl-carousel owl-theme">      
        <div class="item"><img src="{{ asset('assets/images/slide_2.jpg') }}" alt="slider-image">            
        </div>

        <div class="item"><img src="{{ asset('assets/images/slide_4.png') }}" alt="slider-image">
        </div>
    </div>-->
    <!-- //Carousel End -->

                <div class="panel-body">
                    <div class="row">
                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img src="{{ asset('assets/img/parallax/photo4.jpg') }}"  class="img-responsive" alt="image1">
                                    <div class="carousel-caption">
                                        <h2>HANATECH</h2>
                                        <p class="text-center"> 
                                            SOLUCION TECNOLÓGICA PARA LA GESTIÓN EFICIENTE <br>
                                            DEL CUADRO DE ASIGNACIÓN DE PERSONAL<br>
                                            Accede a la información en tiempo real para una rápida toma de decisiones.<br><br><br>

                                        </p>
                                    </div>
                                </div>
                                <!-- End Item -->
                                <div class="item">
                                    <img src="{{ asset('assets/img/parallax/photo2.jpg') }}"  class="img-responsive" alt="image1">
                                    <div class="carousel-caption">
                                        <h2>HANATECH</h2>
                                        <p class="text-center">   
                                            MEJORA EL DESEMPEÑO DE TU INSTITUCIÓN Y OBTÉN MEJORES RESULTADOS.
                                        </p>
                                          <p class="text-center"> 
                                           ¡Transforma tu proceso de Asignación de personal!
                                       </p>
                                       <br><br><br>
                                        
                                    </div>
                                </div>
                                <!-- End Item -->
                               <div class="item">
                                    <img src="{{ asset('assets/img/parallax/photo3.jpg') }}"  class="img-responsive" alt="image1">
                                    <div class="carousel-caption">
                                        <h3>HANATECH</h3>
                                        <p>
                                            Es una solución integral para gestiónar y llevar el control del Cuadro de Asignación de Persona-CAP en su institución. Diseño sofisticado y escalable para las áreas productivas y servicios. Gestión integrada y eficiente, de rápida implementación.<br><br><br>
                                        </p>
                                    </div>
                                </div>
                                <!-- End Item -->
                                <div class="item">
                                    <img src="{{ asset('assets/img/parallax/photo1.jpg') }}"  class='img-responsive' alt="image">
                                    <div class="carousel-caption" style="c">                                            
                                        <h3>Nosotros</h3>
                                        <p>
                                            Somos expertos automatizando procesos de Recursos Humanos usando tecnologías de información, logrando que tu compañia sea más ágil y competitiva.
                                        </p>

                                        <h3>¿Por qué confiar en nosotros?</h3>                                        
                                        <p>
                                           Tenemos un equipo de profesionales innovadores y expertos en automatización de procesos en  áreas claves que tienen como objetivo apoyar desde el servicio a mejorar el desempeño de las organizacion con el uso de las Tencologías de Información.
                                        </p>

                                    </div>
                                </div>
                                <!-- End Item -->
                            </div>
                            <!-- End Carousel Inner -->
                           <!-- <ul class="nav nav-pills nav-justified">
                                <li data-target="#myCarousel" data-slide-to="0" >
                                    <a href="#">Home</a>
                                </li>
                                <li data-target="#myCarousel" data-slide-to="1">
                                    <a href="#">Next</a>
                                </li>
                                <li data-target="#myCarousel" data-slide-to="2">
                                    <a href="#">Next</a>
                                </li>
                                <li data-target="#myCarousel" data-slide-to="3">
                                    <a href="#">Nosotros</a>
                                </li>
                            </ul>-->
                        </div>
                        <!-- End Carousel -->
                    </div>
                </div>
@stop

{{-- content --}}
@section('content')
  


   
  
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    <script type="text/javascript" src="{{ asset('assets/js/frontend/jquery.circliful.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/owl_carousel/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/index.js') }}"></script>
    <!--page level js ends-->
@stop
