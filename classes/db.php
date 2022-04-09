<?php
class DB{

    private static $instances = [];
    protected $connection;
    protected $db_name;

    protected const TYPE_INT = "INT";
    protected const TYPE_VARCHAR = "VARCHAR(255)";
    protected const TYPE_BOOLEAN = "BOOLEAN";
    protected const TYPE_NULL = "NULL";
    protected const TYPE_NOT_NULL = "NOT NULL";
    protected const TYPE_PRIMARY_KEY = "PRIMARY KEY";
    protected const TYPE_AUTO_INCREMENT = "AUTO_INCREMENT";


    protected function __construct() 
    {
        $this->connect();
    }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): DB
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    protected function connect()
    {
        $config = new Config();
        $bd_info = $config->get_config("configdb.php");

        $this->db_name = $bd_info['db'];

        $connectStr = $this->make_connection_string($bd_info);

        $this->connection = new PDO($connectStr, $bd_info['username'], $bd_info['password']);


    }

    protected function make_connection_string(Array $bd_config)
    {
        if(array_key_exists('host', $bd_config) && 
        array_key_exists('db', $bd_config) && 
        array_key_exists('charset', $bd_config))
        {
            return "mysql:
                host={$bd_config['host']};
                dbname={$bd_config['db']};
                charset={$bd_config['charset']};";
        }
        else{
            die("Отсутсвует ключ в конфиге для создания DSN");
        }
        
    }

    /*
    [
        "name" => str,
        "type" => str,
        "null" => bool,
        "primary_key" => bool
    ]
     */
    public function create_table($table_name, Array $tuples)
    {
        $query = $this->construct_query($table_name, $tuples);

        $stmt = $this->connection->prepare($query);

        try{
            $stmt->execute();
        }
        catch(PDOException $e){
            echo 'Ошибка выполнения запроса: ' . $e->getMessage();
        }
        
    }

    public function is_table_exists($table_name)
    {
        $query = "SHOW tables FROM {$this->db_name} LIKE '{$table_name}'";

        $is_exists = $this->connection->query($query)->rowCount();

        return $is_exists;
    }

    private function construct_query($table_name, Array $tuples)
    {

        $attributes = [];

        foreach($tuples as $tuple){
            $name = $tuple["name"];

            if($tuple["type"] == "varchar"){
                $type = self::TYPE_VARCHAR;
            } 
            else{ 
                $type = $tuple["type"];
            }

            if($tuple["null"]){
                $can_be_null = self::TYPE_NULL;
            }
            else{
                $can_be_null = self::TYPE_NOT_NULL;
            }

            if($tuple["primary_key"]){
                $primary_key = self::TYPE_PRIMARY_KEY." ".self::TYPE_AUTO_INCREMENT;
            }
            else{
                $primary_key = "";
            }
            
            $attribute = implode(" ", [$name, $type, $can_be_null, $primary_key]);
            array_unshift($attributes, $attribute);
        }

        $raw_query = "CREATE TABLE {$table_name}(".implode(", ", $attributes);
        $query = $raw_query.");";
    
        return $query;
    }
}

 ?>