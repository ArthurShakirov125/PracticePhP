<?php
class Layout{
    private static $instances = [];

    protected function __construct() 
    { 
        $this->setup_font("Montserrat");
        $this->set_static("css/bootstrap.css");
    }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): Layout
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    protected $static_js;
    protected $static_css;

    protected $static = [
        "style"=> [],
        "script" => []
    ];


    protected function setup_font($font_name){
        // добавить возможность добавлять шрифты с пробелом в названии
        $font_link = "<link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link href='https://fonts.googleapis.com/css2?family={$font_name}:wght@100;300&display=swap' rel='stylesheet'>";
        
        echo $font_link;

    }

    public function setup_styles(){
        foreach($this->static["style"] as $style){
            echo "<link rel='stylesheet' href='static/{$style}'>";
        }
    }

    public function setup_scripts(){
        foreach($this->static["script"] as $script){
            echo "<script src='static/{$script}'></script>";
        }
    }

    public function set_static($path){
        $exten = new SplFileInfo($path);
        if($exten->getExtension() == "js"){
            $this->static["script"][] = $path;
        }
        else{
            $this->static["style"][] = $path;
        }
    }
}
    
?>