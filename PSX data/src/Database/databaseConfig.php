<?php


define('DB_SERVER','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','psx_data');

class databaseConfig {
    private static $instance = null;
    private $connect;

    private function __construct() {
        $this->connect = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConn(){
        return $this->connect;
    }
}
