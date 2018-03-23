<ul id="menu" class="page-sidebar-menu">

    <li {!! (Request::is('admin') ? 'class="active"' : '') !!}>
        <a href="{{ route('admin.dashboard') }}">
            <i class="livicon" data-name="dashboard" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Dashboard</span>
        </a>
    </li>
          <!-- 
        <li {!! (Request::is('admin/generator_builder') ? 'class="active"' : '') !!}>
            <a href="{{  URL::to('admin/generator_builder') }}">
                <i class="livicon" data-name="shield" data-size="18" data-c="#F89A14" data-hc="#F89A14"
                   data-loop="true"></i>
                Generator Crud
            </a>
        </li>
     
    
        <li {!! (Request::is('admin/log_viewers') || Request::is('admin/log_viewers/logs')  ? 'class="active"' : '') !!}>

            <a href="{{  URL::to('admin/log_viewers') }}">
                <i class="livicon" data-name="help" data-size="18" data-c="#1DA1F2" data-hc="#1DA1F2"
                   data-loop="true"></i>
                Log
            </a>
        </li>
    
        <li {!! (Request::is('admin/activity_log') ? 'class="active"' : '') !!}>
            <a href="{{  URL::to('admin/activity_log') }}">
                <i class="livicon" data-name="eye-open" data-size="18" data-c="#F89A14" data-hc="#F89A14"
                   data-loop="true"></i>
                Activity Log
            </a>
        </li>
   

  <!--
 <li {!! (Request::is('admin/users') || Request::is('admin/users/create') || Request::is('admin/user_profile') || Request::is('admin/users/*') || Request::is('admin/deleted_users') ? 'class="active"' : '') !!}>       
  -->

    @if(Sentinel::getUser()->permissions === 1)
      <li {!! (Request::is('admin/users') || Request::is('admin/users/create') || Request::is('admin/user_profile') || Request::is('admin/users/*') || Request::is('admin/deleted_users') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="user" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"
               data-loop="true"></i>
            <span class="title">Usuarios</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/users') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/users') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Lista Usuarios 
                </a>
            </li>
            <li {!! (Request::is('admin/users/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/users/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Nuevo Usuario
                </a>
            </li>
            <li {!! ((Request::is('admin/users/*')) && !(Request::is('admin/users/create')) ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::route('admin.users.show',Sentinel::getUser()->id) }}">
                    <i class="fa fa-angle-double-right"></i>
                    Ver Perfil
                </a>
            </li>
            <li {!! (Request::is('admin/deleted_users') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/deleted_users') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Usuarios Eliminados
                </a>
            </li>
        </ul>
    </li>
    
  <li {!! (Request::is('admin/permisos') || Request::is('admin/permisos/create') || Request::is('admin/permisos/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="wrench" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Permisos</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/permisos') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/permisos') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Lista de permisos
                </a>
            </li>
           
        </ul>
    </li>

    <li {!! (Request::is('admin/groups') || Request::is('admin/groups/create') || Request::is('admin/groups/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="users" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Roles y Permisos</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/groups') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/groups') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Lista de Roles
                </a>
            </li>
            <li {!! (Request::is('admin/groups/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/groups/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Nuevo Rol
                </a>
            </li>
        </ul>
    </li>

    <li {!! ( Request::is('admin/periodop') || Request::is('admin/tipo') || Request::is('admin/tipo/create') || Request::is('admin/cargo') || Request::is('admin/nivel') || Request::is('admin/mantestruct') || Request::is('admin/mantestruct/create') ||  Request::is('admin/mantestruct/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="doc-portrait" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Mantenedores</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/mantestruct') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/mantestruct') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Estructuras
                </a>
            </li>
            <li {!! (Request::is('admin/mantestruct/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/mantestruct/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Actualizar Población
                </a>
            </li>
            <li {!! (Request::is('admin/periodop/') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/periodop') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Actualizar Periodo Ppto
                </a>
            </li>
             <li {!! (Request::is('admin/tipo') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/tipo') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Tipos de Cargos
                </a>
            </li>

            <li {!! (Request::is('admin/nivel') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/nivel') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Nivel Ocupacional
                </a>
            </li>

               <li {!! (Request::is('admin/cargo') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/cargo') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Cargos
                </a>
            </li>

        </ul>
    </li>

 
<li {!! (( Request::is('admin/estructura') || Request::is('admin/plazas/create') || Request::is('admin/plazas') || Request::is('admin/bajaplazas') || Request::is('admin/gesplazas')  || Request::is('admin/upmov') || Request::is('admin/rpteplazas') || Request::is('admin/altaplaza') || Request::is('admin/creaplaza') || Request::is('admin/reserva') || Request::is('admin/cambio') || Request::is('admin/integra')  ) ||  Request::is('admin/tipo/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="users" data-c="#F89A14" data-hc="#F89A14" data-size="18"
               data-loop="true"></i>
            <span class="title">Gestión RRHH</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/creaplaza') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/creaplaza') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Crear Plaza
                </a>
            </li>

             <li {!! (Request::is('admin/reserva') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/reserva') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Reserva de Plaza
                </a>
            </li>

            <li {!! (Request::is('admin/integra') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/integra') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Recategorización Plaza
                </a>
            </li>

             <li {!! (Request::is('admin/cambio') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/cambio') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Cambio de Denominación
                </a>
            </li>

           

             <li {!! (Request::is('admin/estructura') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/estructura') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Población x Dependencia
                </a>
            </li> 
             <li {!! (Request::is('admin/plazas') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/plazas') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Nominativo | Depend.
                </a>
            </li>

             <li {!! (Request::is('admin/altaplaza') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/altaplaza') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Alta de Plazas
                </a>
            </li>

            <li {!! (Request::is('admin/gesplazas') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/gesplazas') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Movimiento de Plazas
                </a>
            </li>
            <li {!! (Request::is('admin/upmov') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/upmov') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Actualizar Movimientos
                </a>
            </li>

            <li {!! (Request::is('admin/bajaplazas') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/bajaplazas') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Baja de Plazas
                </a>
            </li>
            
            <li {!! (Request::is('admin/rpteplazas') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/rpteplazas') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Consulta por Plaza
                </a>
            </li>

        </ul>
        
        <li {!! (Request::is('admin/rptetempo') || Request::is('admin/rptetempo/create') || Request::is('reportes/rplazas') || Request::is('reportes/rbajas') || Request::is('reportes/plazacargo')|| Request::is('admin/rptetempo/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="barchart" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"
               data-loop="true"></i>
            <span class="title">Reportes</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/rptetempo') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/rptetempo') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Consulta(T)
                </a>
            </li>

            <li {!! (Request::is('reportes/rplazas') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('reportes/rplazas') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Rpte de Plazas x Estado
                </a>
            </li>
            
            <li {!! (Request::is('reportes/plazacargo/') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('reportes/plazacargo') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Plazas Por Cargo
                </a>
            </li>
             <li {!! (Request::is('reportes/reject/') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('reportes/reject') }}">
                    <i class="fa fa-angle-double-right"></i>
                    ...
                </a>
            </li>

             <li {!! (Request::is('reportes/rbajas/') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('reportes/rbajas') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Altas y Bajas
                </a>
            </li>
           
        </ul>
    </li>


 <li {!! (Request::is('servicio/reservas') || Request::is('servicio/reservas/bandeja') || Request::is('servicio/reservas/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="show" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Solicitud de Servicio</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('servicio/reservas') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('servicio/reservas') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Solicitud
                </a>
            </li>

             <li {!! (Request::is('servicio/reservas/bandeja') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('servicio/reservas/bandeja') }}" id="idreservasbandeja">
                    <i class="fa fa-angle-double-right"></i>
                    Bandeja
                </a>
            </li>
        </ul>
    </li>

  @elseif(Sentinel::getUser()->permissions === 4)
    <li {!! ((Request::is('admin/estructura') || Request::is('admin/plazas') || Request::is('admin/bajaplazas') || Request::is('admin/gesplazas') || Request::is('admin/rpteplazas') || Request::is('admin/reserva')) ||  Request::is('admin/tipo/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="users" data-c="#F89A14" data-hc="#F89A14" data-size="18"
               data-loop="true"></i>
            <span class="title">Gestión RRHH</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
              <li {!! (Request::is('admin/reserva') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/reserva') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Reserva de Plaza
                </a>
            </li>

             <li {!! (Request::is('admin/estructura') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/estructura') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Población x Dependencia
                </a>
            </li> 
             <li {!! (Request::is('admin/plazas') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/plazas') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Plazas x Dependencia
                </a>
            </li>

             <li {!! (Request::is('admin/altaplaza') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/altaplaza') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Alta de Plazas
                </a>
            </li>
            
            <li {!! (Request::is('admin/gesplazas') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/gesplazas') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Movimiento de Plazas
                </a>
            </li>

            <li {!! (Request::is('admin/bajaplazas') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/bajaplazas') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Baja de Plazas
                </a>
            </li>
            
            <li {!! (Request::is('admin/rpteplazas') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/rpteplazas') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Consulta por Plaza
                </a>
            </li>

        </ul>

    <li {!! (Request::is('admin/mantestruct') || Request::is('admin/mantestruct/create') || Request::is('admin/mantestruct/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="shield" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Mantenedores</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/mantestruct') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/mantestruct') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Estructuras
                </a>
            </li>

            <li {!! (Request::is('admin/mantestruct/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/mantestruct/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Actualizar Población
                </a>
            </li>
            
        </ul>
    </li>

    

      <li {!! (Request::is('servicio/reservas') || Request::is('servicio/reservas/bandeja') || Request::is('servicio/reservas/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="show" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Solicitud de Servicio</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('servicio/reservas') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('servicio/reservas') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Solicitud
                </a>
            </li>

             <li {!! (Request::is('servicio/reservas/bandeja') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('servicio/reservas/bandeja') }}" id="idreservasbandeja">
                    <i class="fa fa-angle-double-right"></i>
                    Bandeja
                </a>
            </li>
        </ul>
    </li>



    <li {!! (Request::is('admin/rptetempo') || Request::is('admin/rptetempo/create') || Request::is('reportes/plazas') || Request::is('reportes/rbajas') || Request::is('admin/rptetempo/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="barchart" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"
               data-loop="true"></i>
            <span class="title">Reportes</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/rptetempo') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/rptetempo') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Consulta(T)
                </a>
            </li>

            <li {!! (Request::is('reportes/plazas') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('reportes/plazas') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Reporte Gral de Plazas
                </a>
            </li>

            <li {!! (Request::is('reportes/rbajas/') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('reportes/rbajas') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Altas y Bajas
                </a>
            </li>
           
        </ul>
    </li>

    @elseif(Sentinel::getUser()->permissions === 2)
    <li {!! (Request::is('admin/rptetempo') || Request::is('admin/rptetempo/create') || Request::is('admin/rptetempo/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="show" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Reportes</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/rptetempo') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/rptetempo') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Consulta(T)
                </a>
            </li>
           
        </ul>
    </li>
    @else

            <a href="#">
                <i class="livicon" data-name="users" data-c="#F89A14" data-hc="#F89A14" data-size="18"
                   data-loop="true"></i>
                <span class="title">Invitados</span>
                <span class="fa arrow"></span>
                {{ Sentinel::getUser()->permissions }}
            </a>               
    @endif 


<!--
    <li {!! ((Request::is('admin/blogcategory') || Request::is('admin/blogcategory/create') || Request::is('admin/blog') ||  Request::is('admin/blog/create')) || Request::is('admin/blog/*') || Request::is('admin/blogcategory/*') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="comment" data-c="#F89A14" data-hc="#F89A14" data-size="18"
               data-loop="true"></i>
            <span class="title">Blog</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/blogcategory') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/blogcategory') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Blog Category List
                </a>
            </li>
            <li {!! (Request::is('admin/blog') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/blog') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Blog List
                </a>
            </li>
            <li {!! (Request::is('admin/blog/create') ? 'class="active"' : '') !!}>
                <a href="{{ URL::to('admin/blog/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Add New Blog
                </a>
            </li>
        </ul>
    
-->
  

    <!-- Menus generated by CRUD generator -->
    @include('admin/layouts/menu')
</ul>