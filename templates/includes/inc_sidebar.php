<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-md-none">
        <a class="navbar-brand me-lg-5" href="/">
            <img class="navbar-brand-dark" src="<?=get_image('gava_logo_dark.png');?>" alt="Gava logo" /> <img class="navbar-brand-light" src="<?=get_image('gava_logo_dark.png');?>" alt="Gava logo" />
        </a>
        <div class="d-flex align-items-center">
            <button class="navbar-toggler d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <nav id="sidebarMenu" class="sidebar d-md-block bg-dark text-white collapse" data-simplebar>
        <div class="sidebar-inner px-4 pt-3" style="overflow: hidden;">
            <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
                <div class="d-flex align-items-center">
                    <div class="user-avatar lg-avatar me-4"><img src="<?= $_SESSION['user_session']['user']['avatar'] != null ? $_SESSION['user_session']['user']['avatar'] : 'https://ui-avatars.com/api/?name='.$_SESSION['user_session']['user']['name'].'+'.$_SESSION['user_session']['user']['lastname'].'&background=random&format=svg' ?>" class="card-img-top rounded-circle border-white" alt="avatar" /></div>
                    <div class="d-block">
                        <h2 class="h6">Hola, <?=  $_SESSION['user_session']['user']['name']?></h2>
                        <a href="./logout" class="btn btn-secondary text-dark btn-xs confirmar">
                            <span class="me-2"><span class="fas fa-sign-out-alt"></span></span>Salir
                        </a>
                    </div>
                </div>
                <div class="collapse-close d-md-none">
                    <a href="#sidebarMenu" class="fas fa-times" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true" aria-label="Toggle navigation"></a>
                </div>
            </div>
            <ul class="nav flex-column pt-3 pt-md-0">
                <li class="nav-item">
                    <a href="./" class="nav-link d-flex align-items-center">
                        <span class="sidebar-icon"><img class="rounded" src="<?= get_image('gava_logo_200x200.jpg');?>" height="30" width="30" alt="Gava Logo" /> </span><span class="mt-1 sidebar-text">Panel Gava</span>
                    </a>
                </li>
            </ul>
            <span id="show_menu">

            </span>
        </div>
    </nav>