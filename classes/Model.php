<?php
class Model{
    protected $table_name;
    protected $table_columns = [];
    protected $primary_key = "id";
    protected $db;
    protected $entry = [];
    protected $loaded = false;

    // шаблон описания атрибута
    /* $table_columns = [
        "attribute_name" => [
            "name" => "attribute_name",
            "type" => "attribute_type",
            "null" => "false/true",
            "primary_key" => "false/true",
        ]
    ];*/

    public function get_entry(){
        return $this->entry;
    }

    public function __construct($id = "")
    {
        $this->db = DB::getInstance();
        if(!$this->db->is_table_exists($this->table_name)){
            $this->create_table();
        }
        if($id != ""){
            $this->find_by_id($id);
        }
        return true;
    }

    protected function create_table()
    {
        $this->db->create_table($this->table_name, $this->table_columns);
    }

    public function __get($attribute_name)
    {
        if(key_exists($attribute_name, $this->entry)){
            return $this->entry[$attribute_name];
        }
        return "";
    }

    public function __set($attribute_name, $value)
    {
        if(key_exists($attribute_name, $this->table_columns)){
            $this->entry[$attribute_name] = $value;
        }
    }

    public function find_by_id($id){
        $this->entry = $this->db->select($this->table_name, "{$this->primary_key} = {$id}", 1);
        $this->loaded = true;
    }

    public function set($array){
        foreach ($array as $key => $value) {
            if(key_exists($key, $this->entry)){
                $this->entry[$key] = $value;
            }
        }
    }


    public function update(){
            $this->db->update_entry($this->table_name, $this->primary_key, $this->entry);
    }

    public function create_entry(){
        $this->db->insert($this->table_name, $this->entry);
    }
}
