<?php
class Layout{
    private static $instances = [];

    protected function __construct() 
    {
        $this->setup_font();
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


    protected function setup_font(){
        $config = new Config();
        $raw_font_name = $config->get_config("layout.php", "font");

        $font_name = str_replace(" ", "+", $raw_font_name);

        $font_link = "<link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link href='https://fonts.googleapis.com/css2?family={$font_name}:wght@100;300&display=swap' rel='stylesheet'>
        <style>:root{font-family: '{$raw_font_name}', sans-serif;}</style>";
        
        echo $font_link;

    }

    public function setup_styles(){
        $this->static["style"] = array_unique($this->static["style"]);

        foreach($this->static["style"] as $style){
            if(file_exists("static/{$style}")){
                echo "<link rel='stylesheet' href='static/{$style}'>";
            }
        }
    }

    public function setup_scripts(){
        $this->static["script"] = array_unique($this->static["script"]);

        foreach($this->static["script"] as $script){
            if(file_exists("static/{$script}")){
                echo "<script src='static/{$script}'></script>";
            }
        }
    }

    public function set_static($path){
        $file_info = new SplFileInfo($path);
        if($file_info->getExtension() == "js"){
            $this->static["script"][] = $path;
        }
        else{
            $this->static["style"][] = $path;
        }
    }
}
    
?>