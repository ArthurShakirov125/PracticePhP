<?php 
    $products = [
        "product1" => [
            "price" => 100,
            "name" => "product1 name",
            "brend" => "products brand"
        ],
        "product2" => [
            "price" => 1000,
            "name" => "product2 name",
            "brend" => "products brand"
        ],
        "product3" => [
            "price" => 500,
            "name" => "product3 name",
            "brend" => "products brand"
        ],
        "product4" => [
            "price" => 1000,
            "name" => "product4 name",
            "brend" => "products brand"
        ],
    ];
?>

<div class="catalog">
    <?php foreach($products as $product):?>
        <div class='product'>
        <h3>
            <?=$product['name']?>
        </h3>
        <p>
        <?=$product['price']?>
        </p>
        <p>
        <?=$product['brend']?>
        </p>
        </div>
    <?php endforeach;?>
</div>