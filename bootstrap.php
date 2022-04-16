<?php
    spl_autoload_register("load_classes");

    function load_classes($classname){
        $classname = strtolower($classname);
        $filename = "classes/".$classname.".php";
        require_once($filename);
    }

    $layout = Layout::getInstance();
    $layout->set_static("css/catalog.css");
    $layout->setup_styles();

    $db = DB::getInstance();

    $user_config = [
        "username" => [
        "name" => "username",
        "type" => "varchar",
        "null" => false,
        "primary_key" => false
        ],
        "id" => [
        "name" => "id",
        "type" => "int",
        "null" => false,
        "primary_key" => true
        ]
    ];

    $product = new Product(4);

    echo $product->price;

    //$db->create_table("client", $user_config);
    //echo $db->insert("client", $data);


?>