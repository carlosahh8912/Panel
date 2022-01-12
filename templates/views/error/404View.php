<!DOCTYPE html>
<html lang="<?php echo SITE_LANG; ?>">
    <head>
        <!-- Agregar basepath para definir a partir de donde se deben generar los enlaces y la carga de archivos -->
        <base href="<?php echo BASEPATH; ?>">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo isset($d->title) ? $d->title.' - '.get_sitename() : get_sitename(); ?></title>
        <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://panel.gavadesign.com" />
        <meta property="og:title" content="Panel - Gava Design" />
        <!-- Favicon del sitio -->
        <?php echo get_favicon(); ?>
        <link rel="apple-touch-icon" sizes="180x180" href="<?=FAVICON.'favicon_180.png'?>" />
        <link rel="icon" type="image/png" sizes="32x32" href="<?=FAVICON.'favicon_32.png'?>" />
        <link rel="icon" type="image/png" sizes="16x16" href="<?=FAVICON.'favicon_16.png'?>" />
        <link rel="manifest" href="./site.webmanifest" />
        <!-- <link rel="mask-icon" href="./assets/img/favicon/safari-pinned-tab.svg" color="#ffffff" /> -->
        <meta name="msapplication-TileColor" content="#ffffff" />
        <meta name="theme-color" content="#ffffff" />

        <!-- inc_styles.php -->
        <?php require_once INCLUDES.'inc_styles.php'; ?>

    </head>
    <body>
        
        <main>
            <section class="vh-100 d-flex align-items-center justify-content-center">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center d-flex align-items-center justify-content-center">
                            <div>
                                <img class="img-fluid w-75" src="<?=get_image('404.svg')?>" alt="404 not found" />
                                <h1 class="mt-5">Page not <span class="fw-bolder text-primary">found</span></h1>
                                <p class="lead my-4">Oops!... entraste a otra dimensión, la página que buscas no existe aquí.</p>
                                <a class="btn btn-dark animate-hover" href="./"><i class="fas fa-chevron-left me-3 ps-2 animate-left-3"></i>Regresar al inicio</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <?php require_once INCLUDES.'inc_scripts.php'; ?>
    </body>
</html>
