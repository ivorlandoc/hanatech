<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- global level css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendors/bootstrapvalidator/css/bootstrapValidator.min.css') }}" rel="stylesheet"/>
    <!-- end of global level css -->
    <!-- page level css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/login.css') }}" />
    <link href="{{ asset('assets/vendors/iCheck/css/square/blue.css') }}" rel="stylesheet"/>
    <!-- end of page level css -->

</head>

<body>
    <div class="container">
        <div class="row vertical-offset-100">
            <!-- Notifications -->
           <div id="notific">
               @include('notifications')
           </div>

            <div class="col-sm-6 col-sm-offset-3  col-md-5 col-md-offset-4 col-lg-4 col-lg-offset-4">
                <div id="container_demo">
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <a class="hiddenanchor" id="toforgot"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form action="{{ route('signin') }}" autocomplete="on" method="post" role="form" id="login_form">
                                <!--<h3 class="black_bg">
                                   <img src="{{ asset('assets/img/logo.png') }}" alt="josh logo">
                                    <br>Log In</h3>
                                    -->
                                    <!-- CSRF Token -->
                                    <h3>Inicio de sesión</h3>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                    <label style="margin-bottom:0px;" for="email" class="uname control-label"> <i class="livicon" data-name="mail" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                        E-mail
                                    </label>
                                    <input id="email" name="email" type="email" placeholder="E-mail"
                                           value="{!! old('email') !!}"/>
                                    <div class="col-sm-12">
                                        {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->first('password', 'has-error') }}">
                                    <label style="margin-bottom:0px;" for="password" class="youpasswd"> <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                        Password
                                    </label>
                                    <input id="password" name="password" type="password" placeholder="Enter a password" />
                                    <div class="col-sm-12">
                                        {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="remember-me" id="remember-me" value="remember-me"
                                               class="square-blue"/>
                                        Mantenme conectado
                                    </label>
                                </div>
                                <p class="login button">
                                    <input type="submit" value="Listo" class="btn btn-info" />
                                </p>
                                <p class="change_link">
                                    <a href="#toforgot">
                                        <button type="button" class="btn btn-responsive botton-alignment btn-warning btn-sm">Se te olvidó tu contraseña</button>
                                    </a>
                                    <a href="#toregister">
                                        <button type="button" id="signup" class="btn btn-responsive botton-alignment btn-success btn-sm" style="float:right;">Regístrate</button>
                                    </a>
                                </p>
                            </form>
                        </div>
                        <div id="register" class="animate form">
                            <form action="{{ route('admin.signup') }}" autocomplete="on" method="post" role="form" id="register_here">
                               <!-- <h3 class="black_bg">
                                    <img src="{{ asset('assets/img/logo.png') }}" alt="josh logo">-->
                                  
                                    <h3>Regístrate</h3>
                                    <!--</h3>-->
                                    <!-- CSRF Token -->
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                    <div class="form-group {{ $errors->first('first_name', 'has-error') }}">
                                        <label style="margin-bottom:0px;" for="first_name" class="youmail">
                                            <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                            Nombres
                                        </label>
                                        <input id="first_name" name="first_name" required type="text" placeholder="Orlando"
                                               value="{!! old('first_name') !!}"/>
                                        <div class="col-sm-12">
                                            {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->first('last_name', 'has-error') }}">
                                        <label style="margin-bottom:0px;" for="last_name" class="youmail">
                                            <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                            Apellidos
                                        </label>
                                        <input id="last_name" name="last_name" required type="text" placeholder="Iparraguirre"
                                               value="{!! old('last_name') !!}"/>
                                        <div class="col-sm-12">
                                            {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                        <label style="margin-bottom:0px;" for="email" class="youmail">
                                            <i class="livicon" data-name="mail" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                            E-mail
                                        </label>
                                        <input id="email" name="email" value="{!! old('email') !!}" required type="email"
                                               placeholder="mysupermail@mail.com"/>
                                        <div class="col-sm-12">
                                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->first('email_confirm', 'has-error') }}">
                                        <label style="margin-bottom:0px;" for="email" class="youmail">
                                            <i class="livicon" data-name="mail" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                            Confirmar E-mail
                                        </label>
                                        <input id="email_confirm" name="email_confirm" required type="email"
                                               placeholder="mysupermail@mail.com" value="{!! old('email_confirm') !!}"/>
                                        <div class="col-sm-12">
                                            {!! $errors->first('email_confirm', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->first('password', 'has-error') }}">
                                        <label style="margin-bottom:0px;" for="password" class="youpasswd">
                                            <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                            Password
                                        </label>
                                        <input id="password" name="password" required type="password" placeholder="Password" />
                                        <div class="col-sm-12">
                                            {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>

                                    <div class="form-group {{ $errors->first('password_confirm', 'has-error') }}">
                                        <label style="margin-bottom:0px;" for="passwor_confirm" class="youpasswd">
                                            <i class="livicon" data-name="key" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                            Confirmar Password
                                        </label>
                                        <input id="password_confirm" name="password_confirm" required type="password" placeholder="Confirm Password" />
                                        <div class="col-sm-12">
                                            {!! $errors->first('password_confirm', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                <p class="signin button">
                                    <input type="submit" class="btn btn-info" value="Crear Cuenta" />
                                </p>
                                <p class="change_link">
                                    <a href="#tologin" class="to_register">
                                        <button type="button" class="btn btn-responsive botton-alignment btn-warning btn-sm">Regresar</button>
                                    </a>
                                </p>
                            </form>
                        </div>
                        <div id="forgot" class="animate form">
                            <form action="{{ url('admin/forgot-password') }}" autocomplete="on" method="post" role="form" id="reset_pw">
                               <!-- <h3 class="black_bg">
                                    <img src="{{ asset('assets/img/logo.png') }}" alt="josh logo"><br>-->
                                <h3>Olvidó tu contraseña</h3>

                                <!--</h3>-->
                                <p>
                                    Ingrese su dirección de correo electrónico, le enviaremos un enlace a su bandeja de entrada para restablecer su contraseña.
                                </p>

                                <!-- CSRF Token -->
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                    <label style="margin-bottom:0px;" for="emailsignup1" class="youmai">
                                        <i class="livicon" data-name="mail" data-size="16" data-loop="true" data-c="#3c8dbc" data-hc="#3c8dbc"></i>
                                        Su email
                                    </label>
                                    <input id="email" name="email" required type="email" placeholder="your@mail.com"
                                           value="{!! old('email') !!}"/>
                                    <div class="col-sm-12">
                                        {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>
                                <p class="login button">
                                    <input type="submit" value="Restablecer la contraseña" class="btn btn-info" />
                                </p>
                                <p class="change_link">
                                    <a href="#tologin" class="to_register">
                                        <button type="button" class="btn btn-responsive botton-alignment btn-warning btn-sm">Regresar</button>
                                    </a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- global js -->
    <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <!--livicons-->
    <script src="{{ asset('assets/js/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/js/livicons-1.4.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/pages/login.js') }}" type="text/javascript"></script>
    <!-- end of global js -->
</body>
</html>