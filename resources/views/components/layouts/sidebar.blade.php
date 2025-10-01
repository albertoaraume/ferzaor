 <div class="sidebar" id="sidebar">
     <!-- Logo -->
     <div class="sidebar-logo active">
         <a href="{{ url('index') }}" class="logo logo-normal">
             <img src="{{ URL::asset('build/img/logos/logo-ferzaor.png') }}" alt="Img">
         </a>
         <a href="{{ url('index') }}" class="logo logo-white">
             <img src="{{ URL::asset('build/img/logos/logo-ferzaor.png') }}" alt="Img">
         </a>
         <a href="{{ url('index') }}" class="logo-small">
             <img src="{{ URL::asset('build/img/logos/icon.png') }}" alt="Img">
         </a>
         <a id="toggle_btn" href="javascript:void(0);">
             <i data-feather="chevrons-left" class="feather-16"></i>
         </a>
     </div>
     <!-- /Logo -->
     <div class="modern-profile p-3 pb-0">
         <div class="text-center rounded bg-light p-3 mb-4 user-profile">
             <div class="avatar avatar-lg online mb-3">
                 <img src="{{ URL::asset('build/img/customer/customer15.jpg') }}" alt="Img"
                     class="img-fluid rounded-circle">
             </div>
             <h6 class="fs-12 fw-normal mb-1">Adrian Herman</h6>
             <p class="fs-10 mb-0">System Admin</p>
         </div>
         <div class="sidebar-nav mb-3">
             <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent" role="tablist">
                 <li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
                 <li class="nav-item"><a class="nav-link border-0" href="#">Chats</a></li>
                 <li class="nav-item"><a class="nav-link border-0" href="#">Inbox</a></li>
             </ul>
         </div>
     </div>
     <div class="sidebar-header p-3 pb-0 pt-2">
         <div class="text-center rounded bg-light p-2 mb-4 sidebar-profile d-flex align-items-center">
             <div class="avatar avatar-md onlin">
                 <img src="{{ URL::asset('build/img/customer/customer15.jpg') }}" alt="Img"
                     class="img-fluid rounded-circle">
             </div>
             <div class="text-start sidebar-profile-info ms-2">
                 <h6 class="fs-12 fw-normal mb-1">Adrian Herman</h6>
                 <p class="fs-10">System Admin</p>
             </div>
         </div>
         <div class="d-flex align-items-center justify-content-between menu-item mb-3">
             <div>
                 <a href="#" class="btn btn-sm btn-icon bg-light">
                     <i class="ti ti-layout-grid-remove"></i>
                 </a>
             </div>
             <div>
                 <a href="#" class="btn btn-sm btn-icon bg-light">
                     <i class="ti ti-brand-hipchat"></i>
                 </a>
             </div>
             <div>
                 <a href="#" class="btn btn-sm btn-icon bg-light position-relative">
                     <i class="ti ti-message"></i>
                 </a>
             </div>
             <div class="notification-item">
                 <a href="#" class="btn btn-sm btn-icon bg-light position-relative">
                     <i class="ti ti-bell"></i>
                     <span class="notification-status-dot"></span>
                 </a>
             </div>
             <div class="me-0">
                 <a href="#" class="btn btn-sm btn-icon bg-light">
                     <i class="ti ti-settings"></i>
                 </a>
             </div>
         </div>
     </div>
     <div class="sidebar-inner slimscroll">
         <div id="sidebar-menu" class="sidebar-menu">
             <ul>

                 <li class="submenu-open">
                     <h6 class="submenu-hdr">Menu</h6>
                     <ul>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('index', '/', 'sales-dashboard', 'admin-dashboard') ? 'active subdrop' : '' }}"><i
                                     class="ti ti-layout-grid fs-16 me-2"></i><span>Dashboard</span><span
                                     class="menu-arrow"></span></a>
                             <ul>

                                 <li><a href="#"
                                         class="{{ Request::is('admin-dashboard') ? 'active' : '' }}">Reservas</a></li>
                                 <li><a href="#"
                                         class="{{ Request::is('admin-dashboard') ? 'active' : '' }}">Transportadora</a>
                                 </li>
                                 <li><a href="#"
                                         class="{{ Request::is('index', '/') ? 'active' : '' }}">Finanzas</a>
                                 </li>
                                 <li><a href="{{ route('admin.dashboards.ventas') }}"
                                         class="{{ Request::is('admin.dashboards.ventas') ? 'active' : '' }}">Ventas</a>
                                 </li>
                             </ul>
                         </li>

                     </ul>
                 </li>
                 <li class="submenu-open">
                     <h6 class="submenu-hdr">Inventario</h6>
                     <ul>
                         <li class="{{ Request::is('product-list', 'product-details') ? 'active' : '' }}"><a
                                 href="#"><i data-feather="box"></i><span>Productos</span></a>
                         </li>
                         <li class="{{ Request::is('add-product') ? 'active' : '' }}"><a href="#"><i
                                     class="ti ti-table-plus fs-16 me-2"></i><span>Crear Producto</span></a></li>




                     </ul>
                 </li>
                 <li class="submenu-open">
                     <h6 class="submenu-hdr">Ventas</h6>
                     <ul>

                         <li class="{{ Request::is('admin.ventas.facturas') ? 'active' : '' }}"><a
                                 href="{{ route('admin.ventas.facturas') }}"><i
                                     class="ti ti-file-invoice fs-16 me-2"></i><span>Facturas</span></a></li>

                         <li class="{{ Request::is('admin.reportes.ingresos') ? 'active' : '' }}"><a href=""><i
                                     class="ti ti-device-laptop fs-16 me-2"></i><span>POS</span></a></li>




                     </ul>
                 </li>


                 <li class="submenu-open">
                     <h6 class="submenu-hdr">Finanzas y Cuentas</h6>
                     <ul>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('expense-list', 'expense-category') ? 'active' : '' }}"><i
                                     class="ti ti-file-stack fs-16 me-2"></i><span>Gastos</span><span
                                     class="menu-arrow"></span></a>
                             <ul>
                                 <li><a href="{{ url('expense-list') }}"
                                         class="{{ Request::is('expense-list') ? 'active' : '' }}">Egresos</a></li>

                             </ul>
                         </li>

                         <li class="{{ Request::is('admin.reportes.ingresos') ? 'active' : '' }}"><a
                                 href="{{ route('admin.reportes.ingresos') }}"><i
                                     class="ti ti-chart-ppf fs-16 me-2"></i><span>Ingresos</span></a></li>




                     </ul>
                 </li>


                 <li class="submenu-open">
                     <h6 class="submenu-hdr">Reportes</h6>
                     <ul>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('sales-report', 'best-seller') ? 'active' : '' }}"><i
                                     class="ti ti-chart-bar fs-16 me-2"></i><span>Ventas</span><span
                                     class="menu-arrow"></span></a>
                             <ul>
                                 <li><a href="#"
                                         class="{{ Request::is('sales-report') ? 'active' : '' }}">Servicios</a>
                                 </li>
                                 <li><a href="#"
                                         class="{{ Request::is('best-seller') ? 'active' : '' }}">Productos</a></li>
                                 <li><a href="{{ route('admin.reportes.ventas.vta-enms') }}"
                                         class="{{ Request::is('admin.reportes.ventas.vta-enms') ? 'active' : '' }}">ENM's</a>
                                 </li>
                                 <li><a href="{{ route('admin.reportes.ventas.cortes') }}"
                                         class="{{ Request::is('admin.reportes.ventas.cortes') ? 'active' : '' }}">Cortes</a>
                                 </li>
                             </ul>
                         </li>
                         <li class="{{ Request::is('purchase-report') ? 'active' : '' }}"><a href="#"><i
                                     class="ti ti-chart-pie-2 fs-16 me-2"></i><span>Comisiones</span></a></li>

                         <li class="{{ Request::is('reportes.estado-cuenta.clientes') ? 'active' : '' }}"><a
                                 href="{{ route('admin.reportes.estado-cuenta.clientes') }}"><i
                                     class="ti ti-chart-pie-2 fs-16 me-2"></i><span>Pendientes de Pago</span></a></li>

                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('inventory-report', 'stock-history', 'sold-stock') ? 'active' : '' }}"><i
                                     class="ti ti-triangle-inverted fs-16 me-2"></i><span>Reservas</span><span
                                     class="menu-arrow"></span></a>
                             <ul>
                                 <li><a href="{{ route('admin.reportes.reservas.general') }}"
                                         class="{{ Request::is('admin.reportes.reservas.general') ? 'active' : '' }}">General</a>
                                 </li>
                                 <li><a href="{{ route('admin.reportes.reservas.actividades') }}"
                                         class="{{ Request::is('admin.reportes.reservas.actividades') ? 'active' : '' }}">Actividades</a>
                                 </li>
                                 <li><a href="{{ route('admin.reportes.reservas.yates') }}"
                                         class="{{ Request::is('admin.reportes.reservas.yates') ? 'active' : '' }}">Yates</a>
                                 </li>
                                 <li><a href="{{ route('admin.reportes.reservas.tours') }}"
                                         class="{{ Request::is('admin.reportes.reservas.tours') ? 'active' : '' }}">Tours</a>
                                 </li>
                                 <li><a href="{{ route('admin.reportes.reservas.transportacion') }}"
                                         class="{{ Request::is('admin.reportes.reservas.transportacion') ? 'active' : '' }}">Transportacion</a>
                                 </li>
                                 <li><a href="{{ route('admin.reportes.reservas.adicionales') }}"
                                         class="{{ Request::is('admin.reportes.reservas.adicionales') ? 'active' : '' }}">Adicionales</a>
                                 </li>
                             </ul>
                         </li>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('inventory-report', 'stock-history', 'sold-stock') ? 'active' : '' }}"><i
                                     class="ti ti-triangle-inverted fs-16 me-2"></i><span>Facturas</span><span
                                     class="menu-arrow"></span></a>
                             <ul>
                                 <li><a href="{{ url('inventory-report') }}"
                                         class="{{ Request::is('inventory-report') ? 'active' : '' }}">General</a>
                                 </li>
                                 <li><a href="{{ url('stock-history') }}"
                                         class="{{ Request::is('stock-history') ? 'active' : '' }}">Pendientes de
                                         Pago</a>
                                 </li>


                             </ul>
                         </li>

                     </ul>
                 </li>

                 <li class="submenu-open">
                     <h6 class="submenu-hdr">Usuarios</h6>
                     <ul>
                         <li class="{{ Request::is('users') ? 'active' : '' }}"><a href=""><i
                                     class="ti ti-shield-up fs-16 me-2"></i><span>Usuarios</span></a></li>
                         <li class="{{ Request::is('roles-permissions') ? 'active' : '' }}"><a href="#"><i
                                     class="ti ti-jump-rope fs-16 me-2"></i><span>Roles & Permisos</span></a></li>

                     </ul>
                 </li>

                 <li class="submenu-open">
                     <h6 class="submenu-hdr">Configuración</h6>
                     <ul>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('general-settings', 'security-settings', 'notification', 'activities', 'connected-apps') ? 'active' : '' }}"><i
                                     class="ti ti-settings fs-16 me-2"></i><span>General</span><span
                                     class="menu-arrow"></span></a>
                             <ul>
                                 <li><a href="#"
                                         class="{{ Request::is('general-settings') ? 'active' : '' }}">Mis
                                         Empresas</a>
                                 </li>
                                 <li><a href="#"
                                         class="{{ Request::is('security-settings') ? 'active' : '' }}">Catalogos</a>
                                 </li>
                                 <li><a href="{{ url('notification') }}"
                                         class="{{ Request::is('notification', 'activities') ? 'active' : '' }}">Notificaciones</a>
                                 </li>

                             </ul>
                         </li>



                         <li class="submenu-open">
                             <h6 class="submenu-hdr">Ayuda</h6>
                             <ul>
                                 <li><a href="{{ route('admin.ayuda.monitoreo') }}"><i
                                             class="ti ti-file-text fs-16 me-2"></i><span>Monitoreo</span></a></li>
                                 <li><a href="{{ config('app.url') }}/admin/log-viewer"><i
                                             class="ti ti-file-text fs-16 me-2"></i><span>Logs</span></a></li>


                             </ul>
                         </li>
                     </ul>
         </div>
     </div>
 </div>
 <!-- /Sidebar -->
