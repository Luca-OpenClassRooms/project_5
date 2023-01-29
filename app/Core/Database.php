<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $_instance;

    private $pdo;
    
    public $connected = false;

    /**
     * Connect to the database
     *
     * @return void
     */
    public function connect()
    {
        try{
            $host = config("database.host");
            $port = config("database.port");
            $username = config("database.username");
            $password = config("database.password");
            $dbname = config("database.database");

            $this->pdo = new PDO("mysql:dbname=$dbname;host=$host;port=$port", $username, $password);
    
            $this->pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES \'UTF8\'');
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            $this->connected = true;
        } catch(PDOException $e) {
            die($e->getMessage());
        }        
    }

    /**
     * Query database
     *
     * @param string $query
     * @param array $params
     * @return void
     */
    public function query(string $query, array $params = [])
    {
        if( !$this->connected ) $this->connect();

        $pdo = $this->pdo;

        $req = $pdo->prepare($query);
        
        if( $req === false ){
            return $this;
        }

        foreach($params as $k => $v){
            $req->bindValue($k + 1, $v);
        }
        
        $req->execute();

        return $req;
    }

    /**
     * Get instance of database
     *
     * @return this
     */
    public static function getInstance()
    {   
        if( is_null(self::$_instance) ){
            self::$_instance = new Database();
        }

        return self::$_instance;
    }    
}