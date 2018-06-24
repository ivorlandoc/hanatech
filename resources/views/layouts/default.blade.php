<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <title>
        @section('title')
        | Welcome a Hanatech
        @show
    </title>
    <!--global css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/lib.css') }}">
    <!--end of global css-->
    <!--page level css-->
    @yield('header_styles')
    <!--end of page level css-->
</head>

<body>
    <!-- Header Start -->
    <header>
        <!-- Icon Section Start -->
        <div class="icon-section">
            <div class="container">
                <ul class="list-inline">
                    <li>
                        <a href="#"> <i class="livicon" data-name="facebook" data-size="18" data-loop="true" data-c="#fff" data-hc="#757b87"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <i class="livicon" data-name="twitter" data-size="18" data-loop="true" data-c="#fff" data-hc="#757b87"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <i class="livicon" data-name="google-plus" data-size="18" data-loop="true" data-c="#fff" data-hc="#757b87"></i>
                        </a>
                    </li>
                  
                    <li class="pull-right">
                        <ul class="list-inline icon-position">
                            <li>
                                <a href="mailto:"><i class="livicon" data-name="mail" data-size="18" data-loop="true" data-c="#fff" data-hc="#fff"></i></a>
                                <label class="hidden-xs"><a href="mailto:" class="text-white">contacto@hanatech.com</a></label>
                            </li>


                            <li>
                                <a href="tel:"><i class="livicon" data-name="cellphone" data-size="18" data-loop="true" data-c="#fff" data-hc="#fff"></i></a>
                                <label class="hidden-xs"><a href="tel:" class="text-white">(+51) 140 123 458</a></label>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- //Icon Section End -->
        <!-- Nav bar Start -->
        <nav class="navbar navbar-default container">
            <div class="navbar-header">               
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
                    <span><a href="#"><i class="livicon" data-name="responsive-menu" data-size="25" data-loop="true" data-c="#757b87" data-hc="#ccc"></i>
                    </a></span>

                </button>
                <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('assets/images/logo3.png') }}" alt="logo" class="logo_position">

                </a>
            </div>
            

            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li {!! (Request::is('/') ? 'class="active"' : '') !!}><a href="{{ route('home') }}"> Home</a></li> 
                    <li {!! (Request::is('portfolio') || Request::is('portfolioitem/*') ? 'class="active"' : '') !!}><a href="{{ URL::to('portfolio') }}"> tour</a></li>
                    <li {!! (Request::is('aboutus') || Request::is('portfolioitem/*') ? 'class="active"' : '') !!}><a href="{{ URL::to('aboutus') }}"> Documentación</a></li>
                    <li ><a href="http://infinitecperu.com/admin/" target="_blanck"> Pruébalo Gratis</a></li>
                    <li {!! (Request::is('contact') ? 'class="active"' : '') !!}><a href="{{ URL::to('contact') }}">Contacto</a></li>
                    <!--
                    {{--based on anyone login or not display menu items--}}
                    @if(Sentinel::guest())
                        <li><a href="{{ URL::to('login') }}">Login</a>
                        </li>
                        <li><a href="{{ URL::to('register') }}">Register</a>
                        </li>
                    @else
                        <li {{ (Request::is('my-account') ? 'class=active' : '') }}><a href="{{ URL::to('my-account') }}">My Account</a>
                        </li>
                        <li><a href="{{ URL::to('logout') }}">Logout</a>
                        </li>
                    @endif
                -->
                </ul>
            </div>
        </nav>
        <!-- Nav bar End -->
    </header>
    <!-- //Header End -->
    
    <!-- slider / breadcrumbs section -->
    @yield('top')

    <!-- Content -->
    @yield('content')

    <!-- Footer Section Start -->
    <footer>
        <div class="container footer-text">
            <!-- About Us Section Start -->
            <div class="col-sm-4">
                <h4>HanaTech</h4>
                <p>
                    Hanatech es una solución integral para gestiónar y llevar el control del Cuadro de Asignación de Persona-CAP en su institución.
                    Diseño sofisticado y escalable para las áreas productivas y servicios. Gestión integrada y eficiente, de rápida implementación.<br>
                    Operaciones en redes locales y/o en la nube.                
                  
                  
                </p>
                <hr id="hr_border2">
                <h4 class="menu">Síguenos</h4>
                <ul class="list-inline">
                    <li>
                        <a href="#"> <i class="livicon" data-name="facebook" data-size="18" data-loop="true" data-c="#ccc" data-hc="#ccc"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <i class="livicon" data-name="twitter" data-size="18" data-loop="true" data-c="#ccc" data-hc="#ccc"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#"> <i class="livicon" data-name="google-plus" data-size="18" data-loop="true" data-c="#ccc" data-hc="#ccc"></i>
                        </a>
                    </li>
                  
                </ul>
            </div>
            <!-- //About us Section End -->
            <!-- Contact Section Start -->
            <div class="col-sm-4">
                <h4>Ubícanos en:</h4>
                <ul class="list-unstyled">
                    <li>Av. Arenales 2614-Lince</li>
                    <li>Lima, Peru.</li>
                    <li><i class="livicon icon4 icon3" data-name="cellphone" data-size="18" data-loop="true" data-c="#ccc" data-hc="#ccc"></i>Telef:(+51) 140 123 458</li>
                    <li><i class="livicon icon4 icon3" data-name="whatsapp" data-size="18" data-loop="true" data-c="#ccc" data-hc="#ccc"></i> (+51) 140 123 458</li>
                    <li><i class="livicon icon3" data-name="mail-alt" data-size="20" data-loop="true" data-c="#ccc" data-hc="#ccc"></i> Email:<span class="text-success" style="cursor: pointer;">
                        contacto@hanatech.com</span>
                    </li>
                   
                </ul>
                <hr id="hr_border">
              
            </div>
            <!-- //Contact Section End -->
            <!-- Recent post Section Start -->
            <div class="col-sm-4">
                <h4>Servicios</h4>
                <div class="media">                   
                    <div class="media-body">
                        <p class="media-heading">Plataforma en la nube de HanaTech</p>
                        <p class="media-heading">Centro de formación Educación</p>
                       
                    </div>
                </div>
             
              
            </div>
            <!-- //Recent Post Section End -->
        </div>
    </footer>
    <!-- //Footer Section End -->
    <div class="copyright">
        <div class="container">
        <p>Copyright &copy;Hanatech, 2017</p>
        </div>
    </div>
    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
        <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
    </a>
    <!--global js starts-->
    <script type="text/javascript" src="{{ asset('assets/js/frontend/lib.js') }}"></script>
    <!--global js end-->
    <!-- begin page level js -->
    @yield('footer_scripts')
    <!-- end page level js -->
</body>

</html>
