<?php

if(count($data) > 0):


    for ($i=0; $i < count($data); $i++) :
?>

<div class="row align-items-center border-bottom pb-2 mb-2">
    <div class="col-sm-1">
        <button class="btn btn-sm btn-icon-only btn-outline-danger" onclick="delete_product_detail(`<?=$data[$i]['id']?>`);">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="col-sm-7">
        <h3 class="h5 mb-1"><?=$d[$i]->title?></h3>
        <span><?=$d[$i]->id?></span> <span = class="text-danger small ms-4"><?= $d[$i]->quantity > $d[$i]->stock ? $d[$i]->stock : ''; ?></span>
        <div class="small fw-bold"><?=money($data[$i]['price'])?>  x <?=$data[$i]['quantity']?></div>
    </div>
    <div class="col-sm-4 text-end">
        <h4 class="fw-bold"><?=money($d[$i]->price * ($d[$i]->quantity - $d[$i]->backorder))?></h4>
    </div>
</div>


<?php
    endfor;
else:
?>
<div class="col-12 my-3 text-center">
    <h6>No hay productos</h6>
</div>

<?php
endif
?>