<?php 
class Config{
    protected $src = "configs/";
    protected $file_in_cash;
    protected $configs = [];

    public function get_config($name, $key = " "){
        if(empty($this->configs)){
            $this->configs = include_once $this->src.$name;
            $this->file_in_cash = $name;
        }
        if($this->file_in_cash == $name){
            if($key != " "){
                return $this->configs[$key];
            }
            return $this->configs;
        }
        else{
            $this->configs = include_once $this->src.$name;
            $this->file_in_cash = $name;

            if($key != " "){
                return $this->configs[$key];
            }
            return $this->configs;
        }
        
        
    }
}