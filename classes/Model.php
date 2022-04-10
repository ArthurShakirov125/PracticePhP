<?php
class Model{
    protected $table_name;
    protected $table_columns = [];
    protected $primary_key;
    protected $db;
    protected $properties = [];

    // шаблон описания колонки
    /* $table_columns = [
        "attribute_name" => [
            "name" => "attribute_name",
            "type" => "attribute_type",
            "null" => "false/true",
            "primary_key" => "false/true",
        ]
    ];*/

    public function __construct()
    {
        $this->db = DB::getInstance();
        if(!$this->db->is_table_exists($this->table_name)){
            $this->create_table();
        }
    }

    protected function create_table()
    {
        $this->db->create_table($this->table_name, $this->table_columns);
        $this->find_primary_key($this->table_columns);
    }

    protected function find_primary_key($table_columns){
        foreach($table_columns as $col){
            if($col["primary_key"]){
                $this->primary_key = $col["name"];
            }
        }
    }

    public function __get($attribute_name)
    {
        if(array_key_exists($attribute_name, $this->table_columns)){
            return $this->properties[$attribute_name];
        }
        return null;
    }

    public function __set($attribute_name, $value)
    {
        
    }
}
?>