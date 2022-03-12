<?php
class Layout{
    private static $instances = [];

    protected function __construct() 
    { 
        
        $this->static_bootstrap_css = "static\css\bootstrap.css";
        $this->setup_font("Montserrat");
    }

    protected function __clone() { }

    protected function __wakeup(){ }

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
    protected $static_bootstrap_css;


    protected function setup_font($font_name){
        // установка шрифта
        $font_url = "@import url('https://fonts.googleapis.com/css2?family={$font_name}:wght@100&display=swap');";

        if(is_writable($this->static_bootstrap_css)){
            $fp = fopen($this->static_bootstrap_css, "r");
            fwrite($fp, $font_url);
            fclose($fp);
        }
        
    }

    public function set_static($path, $exten){
        if($exten == "css"){
            if(file_exists("static/".$path)){
                $this->static_css = file_get_contents("static/".$path);
            }   
        }
        if($exten == "js"){
            if(file_exists("static/".$path)){
                $this->static_js = file_get_contents("static/".$path);
            }
        }
    }
}
    
?>