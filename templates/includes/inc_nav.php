<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
            <div class="d-flex align-items-center">
                <button id="sidebar-toggle" class="sidebar-toggle me-3 btn btn-icon-only btn-lg btn-circle d-none d-md-inline-block"><span class="fas fa-bars"></span></button>
                <!-- <form class="navbar-search form-inline" id="navbar-search-main">
                    <div class="input-group input-group-merge search-bar">
                        <span class="input-group-text" id="topbar-addon"><span class="fas fa-search"></span></span>
                        <input type="text" class="form-control" id="topbarInputIconLeft" placeholder="Search" aria-label="Search" aria-describedby="topbar-addon" />
                    </div>
                </form> -->
                <div class="">
                    <?= format_date(now())?>
                </div>
            </div>
            <ul class="navbar-nav align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="media d-flex align-items-center">
                            <img class="user-avatar md-avatar rounded-circle" alt="Image placeholder" src="<?= $_SESSION['user_session']['user']['avatar'] != null ? $_SESSION['user_session']['user']['avatar'] : 'https://ui-avatars.com/api/?name='.$_SESSION['user_session']['user']['name'].'+'.$_SESSION['user_session']['user']['lastname'].'&background=f3b773&format=svg' ?>" />
                            <div class="media-body ms-2 text-dark align-items-center d-none d-lg-block"><span class="mb-0 font-small fw-bold"><?= $_SESSION['user_session']['user']['name'].' '. $_SESSION['user_session']['user']['lastname'] ?></span></div>
                        </div>
                    </a>
                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-0">
                        <a class="dropdown-item rounded-top fw-bold" href="./users/profile"><span class="far fa-user-circle"></span>Perfil</a> 
                        <a class="dropdown-item fw-bold" href="./customers"><span class="fas fa-users"></span>Clientes</a>
                        <a class="dropdown-item fw-bold" href="./pos"><span class="fas fa-file-invoice-dollar"></span>Pedidos</a> 
                        <a class="dropdown-item fw-bold" href="./products"><span class="fas fa-box"></span>Productos</a>
                        <div role="separator" class="dropdown-divider my-0"></div>
                        <a class="dropdown-item rounded-bottom fw-bold confirmar" href="./logout"><span class="fas fa-sign-out-alt text-danger"></span>Salir</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>