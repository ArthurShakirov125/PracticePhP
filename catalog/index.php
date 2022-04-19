<?php

$product = new Product();
$products = $product->find_all('', 4);
$product1 = new Product(1);
$product1->p_name = "Gawr Gura";
$product1->save();
?>

<div class="catalog">
    <?php foreach($products as $product):?>
        <div class='product'>
        <h3>
            <?=$product->p_name?>
        </h3>
        <p>
        <?=$product->price?>
        </p>
        </div>
    <?php endforeach;?>
</div>