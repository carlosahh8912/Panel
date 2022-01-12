<?php

if (count($data) > 0) :


    for ($i = 0; $i < count($data); $i++) :
?>

        <div class="col-6">
            <div class="card shadow mb-3 mx-1">
                <img src="https://www.gavadesign.com/b2b/assets/uploads/products/<?= strtoupper($data[$i]['brand']) . '/' . $data[$i]['id'] ?>_a.jpg" class="card-img-top" alt="prod-img">
                <div class="card-body py-0">
                    <p class="small m-0 d-none d-sm-block fw-bolder"><?= $data[$i]['title'] ?></p>
                    <p class="small m-0"><span class="fw-bolder">Clave: </span><span><?= $data[$i]['id'] ?></span></p>
                    <p class="small m-0"><span class="fw-bolder">Precio: </span><span><?= money($data[$i]['standard_price']) ?></span></p>
                    <p class="small m-0"><span class="fw-bolder">Stock: </span><span><?= number_format($data[$i]['stock']) ?></span></p>
                </div>
                <div class="card-footer px-1">
                    <input type="number" class="form-control mb-2" id="qty<?= $data[$i]['id'] ?>" placeholder="Pz">
                    <button class="btn btn-secondary btn_add_product btn-sm w-100" id="btn_<?= $data[$i]['id'] ?>" onclick=" add_product_pos_detail(`<?= $data[$i]['id'] ?>`);">Add<i class="ms-3 fas fa-cart-plus"></i></button>
                </div>
            </div>
        </div>

    <?php
    endfor;
else :
    ?>
    <div class="col-12 my-3 text-center">
        <h5>No hay productos</h5>
    </div>

<?php
endif
?>