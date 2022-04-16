<?php
class Model{
    protected $table_name;
    protected $table_columns = [];
    protected $primary_key = "id";
    protected $id;
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
            $this->id = $id;
            $this->find_by_id($id);

        }
        return true;
    }

    public function loaded(){
        return $this->loaded;
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
        $stmt = $this->db->select($this->table_name, "{$this->primary_key} = {$id}", 1);

        $this->entry = $stmt->fetch(PDO::FETCH_ASSOC);
        if($this->entry = []){
            $this->loaded = false;
            $this->entry["id"] = $this->id;
        }
        $this->loaded = true;
    }

    public function find($condition =''){
        $stmt = $this->db->select($this->table_name, "{$condition}", 1);
        
        $entry = new static();
        if($tuple = $stmt->fetch(PDO::FETCH_ASSOC)){
            $entry->entry = $tuple;
        }
        return $entry;
    }

    public function find_all($condition ='', $lim = 1){
        $entries = [];
        $stmt = $this->db->select($this->table_name, $condition, $lim);

        while($tuple = $stmt->fetch(PDO::FETCH_ASSOC)){
            $entry = new static();
            $entry->entry = $tuple;
            array_unshift($entries, $entry);
        }

        return $entries;
    }

    public function set($array){
        foreach ($array as $key => $value) {
            if(key_exists($key, $this->entry)){
                $this->entry[$key] = $value;
            }
        }
    }


    public function save(){
        if($this->loaded){
            $this->update();
        }
        else{
            $this->create_entry();
        }
    }

    protected function update(){
            $this->db->update_entry($this->table_name, $this->id, $this->entry);

    }

    protected function create_entry(){
        $this->id = $this->db->insert($this->table_name, $this->entry);
        $this->loaded = true;
    }
}
