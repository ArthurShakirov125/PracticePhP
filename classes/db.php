<?php
class DB{
    private static $instances = [];
    protected $pdo;
    protected $db_name;

    protected function __construct() {
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

        $pdo = new PDO($connectStr, $bd_info['username'], $bd_info['password']);
    }

    protected function make_connection_string(Array $bd_config)
    {
        return "mysql:
        host={$bd_config['host']};
        dbname={$bd_config['db']};
        charset={$bd_config['charset']};"; 
    }

    public function create_table(Array $columns)
    {
        # code...
    }
}

 ?>