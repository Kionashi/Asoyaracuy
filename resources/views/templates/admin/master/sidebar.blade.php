<section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENÚ PRINCIPAL</li>
        @if(\AdminAuthHelper::hasPermission('dashboard'))
            <li class="{{ \AdminRouteHelper::getSidebarClass('dashboard')}}">
                <a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
        @endif
        <li class="treeview col-xs-12 {{ \AdminRouteHelper::getSidebarClass('management')}}">
            <a href="#"> <i class="fa fa-wrench"></i>
                <span>Gestión</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu col-xs-12">
           	    @if(\AdminAuthHelper::hasPermission('management/admin-users'))
                    <li class="col-xs-12 sidebar-menu-item {{ \AdminRouteHelper::getSidebarClass('management/admin-users')}}">
                        <i class="fa fa-circle-o sidebar-menu-bullet col-xs-2"></i>
                        <a class="sidebar-menu-title col-xs-10" href="{{ route('management/admin-users') }}">
                            Administradores
                        </a>
                    </li>
                @endif
                @if(\AdminAuthHelper::hasPermission('management/contacts'))
                    <li class="col-xs-12 sidebar-menu-item {{ \AdminRouteHelper::getSidebarClass('management/contacts')}}">
                        <i class="fa fa-circle-o sidebar-menu-bullet col-xs-2"></i>
                        <a class="sidebar-menu-title col-xs-10" href="{{ route('management/contacts') }}">
                            Contactos
                        </a>
                    </li>
                @endif
                @if(\AdminAuthHelper::hasPermission('management/static-contents'))
                    <li class="col-xs-12 sidebar-menu-item {{ \AdminRouteHelper::getSidebarClass('management/static-contents')}}">
                        <i class="fa fa-circle-o sidebar-menu-bullet col-xs-2"></i>
                        <a class="sidebar-menu-title col-xs-10" href="{{ route('management/static-contents') }}">
                            Contenidos estáticos
                        </a>
                    </li>
                @endif
                @if(\AdminAuthHelper::hasPermission('management/config-items'))
                    <li class="col-xs-12 sidebar-menu-item {{ \AdminRouteHelper::getSidebarClass('management/config-items')}}">
                        <i class="fa fa-circle-o sidebar-menu-bullet col-xs-2"></i>
                        <a class="sidebar-menu-title col-xs-10" href="{{ route('management/config-items') }}">
                            Elementos de configuración
                        </a>
                    </li>
                @endif
                @if(\AdminAuthHelper::hasPermission('management/polls'))
                    <li class="col-xs-12 sidebar-menu-item {{ \AdminRouteHelper::getSidebarClass('management/polls')}}">
                        <i class="fa fa-circle-o sidebar-menu-bullet col-xs-2"></i>
                        <a class="sidebar-menu-title col-xs-10" href="{{ route('management/polls') }}">
                            Encuesta
                        </a>
                    </li>
                @endif
                @if(\AdminAuthHelper::hasPermission('management/contact-reasons'))
                    <li class="col-xs-12 sidebar-menu-item {{ \AdminRouteHelper::getSidebarClass('management/contact-reasons')}}">
                        <i class="fa fa-circle-o sidebar-menu-bullet col-xs-2"></i>
                        <a class="sidebar-menu-title col-xs-10" href="{{ route('management/contact-reasons') }}">
                            Razones de contacto
                        </a>
                    </li>
                @endif
                @if(\AdminAuthHelper::hasPermission('management/users'))
                    <li class="col-xs-12 sidebar-menu-item {{ \AdminRouteHelper::getSidebarClass('management/users')}}">
                        <i class="fa fa-circle-o sidebar-menu-bullet col-xs-2"></i>
                        <a class="sidebar-menu-title col-xs-10" href="{{ route('management/users') }}">
                            Usuarios
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        <li>
            @if(\AdminAuthHelper::hasPermission('management/users'))
                <li class="col-xs-12 sidebar-menu-item {{ \AdminRouteHelper::getSidebarClass('management/audits')}}">
                    <i class="fa fa-circle-o sidebar-menu-bullet col-xs-2"></i>
                    <a class="sidebar-menu-title col-xs-10" href="{{ route('management/audits') }}">
                        Auditorias
                    </a>
                </li>
            @endif
        </li>
    </ul>
</section>