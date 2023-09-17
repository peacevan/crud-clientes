<?php
namespace app\config;

//require './vendor/autoload.php';
use PDO;

class Connection
{
    private static $instance = null;
    private static $use = "root";
    private static $pass = "";
    private static $host = "localhost";
    private static $db = "crud-cliente";

    private function __construct($use, $pass, $host, $db)
    {
        Connection::$use = $use;
        Connection::$pass = $pass;
        Connection::$host = $host;
        Connection::$db = $db;
    }
    public static function getInstance($use = "root", $pass = '', $host = 'localhost', $db = 'crud-cliente')
    {
        if (self::$instance == null) {
            self::$instance = new Connection($use, $pass, $host, $db);
        }
        return self::$instance;
    }

    public static function getConection()
    {
        $conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db, self::$use, self::$pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}
