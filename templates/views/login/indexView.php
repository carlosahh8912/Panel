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
        
        <?php require_once INCLUDES.'inc_styles.php'; ?>

    </head>
    <body>

        <main>
            <section class="d-flex align-items-center my-5 mt-lg-6 mb-lg-5">
                <div class="container">
                    <p class="text-center">
                      <?php echo Flasher::flash(); ?>
                    </p>
                    <div class="row justify-content-center form-bg-image" data-background-lg="<?=get_image('signin.svg')?>">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <div class="bg-white shadow-soft border rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                                <div class="text-center text-md-center mb-5 mt-md-0"><h1 class="mb-0 h3">Inicia sesión para ingresar</h1></div>
                                <form action="login/post_login" method="post" class="mt-4 needs-validation">
                                  <?php echo insert_inputs(); ?>
                                    <div class="form-group mb-4">
                                        <label for="email">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1"><span class="fas fa-envelope"></span></span>
                                            <input type="email" class="form-control" placeholder="example@company.com" id="email" name="email" autofocus required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group mb-4">
                                            <label for="password">Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon2"><span class="fas fa-unlock-alt"></span></span> 
                                                <input type="password" placeholder="Password" name="password" class="form-control" id="password" required />
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end align-items-top my-4">
                                            <div class="py-2"><a href="./login/forgot-password" class="small text-right">¿Olvidaste tu contraseña?</a></div>
                                        </div>
                                    </div>
                                    <div class="d-grid"><button type="submit" class="btn btn-dark">Acceder</button></div>
                                </form>
                              
                                <div class="d-flex justify-content-center my-5">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <?php require_once INCLUDES.'inc_scripts.php'; ?>
    </body>
</html>




