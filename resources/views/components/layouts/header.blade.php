<div>
    <!-- Be present above all else. - Naval Ravikant -->
    <div class="header">
        <div class="main-header">
            <!-- Logo -->
            <div class="header-left active">
                <a href="{{ url('index') }}" class="logo logo-normal">
                    <img src="{{ URL::asset('/build/img/logos/logo-ferzaor.png') }}" alt="Img">
                </a>
                <a href="{{ url('index') }}" class="logo logo-white">
                    <img src="{{ URL::asset('/build/img/logos/logo-ferzaor.png') }}" alt="Img">
                </a>
                <a href="{{ url('index') }}" class="logo-small">
                    <img src="{{ URL::asset('/build/img/logos/icon.png') }}" alt="Img">
                </a>
            </div>
            <!-- /Logo -->
            <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>

            <!-- Header Menu -->
            <ul class="nav user-menu">

                <!-- Search -->
                <li class="nav-item nav-searchinputs">
                    <div class="top-nav-search">
                        <a href="javascript:void(0);" class="responsive-search">
                            <i class="fa fa-search"></i>
                        </a>
                        <form action="#" class="dropdown">
                            <div class="searchinputs input-group dropdown-toggle" id="dropdownMenuClickable"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                <input type="text" placeholder="Buscar">
                                <div class="search-addon">
                                    <span><i class="ti ti-search"></i></span>
                                </div>
                                <span class="input-group-text">
                                    <kbd class="d-flex align-items-center"><img
                                            src="{{ URL::asset('build/img/icons/command.svg') }}" alt="img"
                                            class="me-1">K</kbd>
                                </span>
                            </div>
                            <div class="dropdown-menu search-dropdown" aria-labelledby="dropdownMenuClickable">
                                <div class="search-info">
                                    <h6><span><i data-feather="search" class="feather-16"></i></span>Búsquedas recientes
                                    </h6>
                                    <ul class="search-tags">
                                        <li><a href="javascript:void(0);">Reservas</a></li>
                                        <li><a href="javascript:void(0);">Cupones</a></li>
                                        <li><a href="javascript:void(0);">Clientes</a></li>
                                    </ul>
                                </div>

                                <div class="search-info">
                                    <h6><span><i data-feather="user" class="feather-16"></i></span>Clientes</h6>
                                    <ul class="customers">
                                        <li><a href="javascript:void(0);">PALACE RESORT<img
                                                    src="{{ URL::asset('build/img/profiles/avator1.jpg') }}"
                                                    alt="Img" class="img-fluid"></a></li>

                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- /Search -->


                <li class="nav-item dropdown link-nav">
                    <a href="javascript:void(0);" class="btn btn-primary btn-md d-inline-flex align-items-center"
                        data-bs-toggle="dropdown">
                        <i class="ti ti-circle-plus me-1"></i>Agregar
                    </a>
                    <div class="dropdown-menu dropdown-xl dropdown-menu-center">
                        <div class="row g-2">
                            <div class="col-md-2">
                                <a href="#" class="link-item">
                                    <span class="link-icon">
                                        <i class="ti ti-brand-codepen"></i>
                                    </span>
                                    <p>Categoria</p>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a href="#" class="link-item">
                                    <span class="link-icon">
                                        <i class="ti ti-square-plus"></i>
                                    </span>
                                    <p>Producto</p>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ url('category-list') }}" class="link-item">
                                    <span class="link-icon">
                                        <i class="ti ti-shopping-bag"></i>
                                    </span>
                                    <p>Compra</p>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a href="#" class="link-item">
                                    <span class="link-icon">
                                        <i class="ti ti-shopping-cart"></i>
                                    </span>
                                    <p>Reserva</p>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a href="#" class="link-item">
                                    <span class="link-icon">
                                        <i class="ti ti-file-text"></i>
                                    </span>
                                    <p>Gasto</p>
                                </a>
                            </div>


                            <div class="col-md-2">
                                <a href="#" class="link-item">
                                    <span class="link-icon">
                                        <i class="ti ti-user"></i>
                                    </span>
                                    <p>Usuario</p>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a href="#" class="link-item">
                                    <span class="link-icon">
                                        <i class="ti ti-users"></i>
                                    </span>
                                    <p>Cliente</p>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a href="#" class="link-item">
                                    <span class="link-icon">
                                        <i class="ti ti-shield"></i>
                                    </span>
                                    <p>Factura</p>
                                </a>
                            </div>
                            <div class="col-md-2">
                                <a href="#" class="link-item">
                                    <span class="link-icon">
                                        <i class="ti ti-user-check"></i>
                                    </span>
                                    <p>Proveedor</p>
                                </a>
                            </div>

                        </div>
                    </div>
                </li>



                <li class="nav-item pos-nav">
                    <a href="#" class="btn btn-dark btn-md d-inline-flex align-items-center">
                        <i class="ti ti-device-laptop me-1"></i>POS
                    </a>
                </li>

                <li class="nav-item nav-item-box">
                    <a href="javascript:void(0);" id="btnFullscreen">
                        <i class="ti ti-maximize"></i>
                    </a>
                </li>


                <li class="nav-item nav-item-box">
                    <a href="#"><i class="ti ti-settings"></i></a>
                </li>
                <li class="nav-item dropdown has-arrow main-drop profile-nav">
                    <a href="javascript:void(0);" class="nav-link userset" data-bs-toggle="dropdown">
                        <span class="user-info p-0">
                            <span class="user-letter">
                                <img src="{{ auth()->user()->Imagen }}" alt="Img" class="img-fluid">
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu menu-drop-user">
                        <div class="profileset d-flex align-items-center">
                            <span class="user-img me-2">
                                <img src="{{ auth()->user()->Imagen }}" alt="Img">
                            </span>
                            <div>
                                <h6 class="fw-medium">{{ auth()->user()->name }}</h6>
                                <p>{{ auth()->user()->nameRol }}</p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="#"><i class="ti ti-user-circle me-2"></i>Mi Perfil</a>
                        <a class="dropdown-item" href="#"><i
                                class="ti ti-settings-2 me-2"></i>Configuración</a>
                        <hr class="my-2">
                        <a class="dropdown-item logout pb-0" href="javascript:void();"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="ti ti-logout me-2"></i>Salir</a>
                    </div>
                </li>
            </ul>
            <!-- /Header Menu -->

            <!-- Mobile Menu -->
            <div class="dropdown mobile-user-menu">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Mi Perfil</a>
                    <a class="dropdown-item" href="#">Configuración</a>
                    <a class="dropdown-item" href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Salir</a>
                </div>
            </div>
            <!-- /Mobile Menu -->
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
