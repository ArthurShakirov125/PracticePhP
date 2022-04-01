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


?>