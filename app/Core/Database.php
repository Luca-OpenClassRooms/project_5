<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private $pdo;
    
    /**
     * Récupération de l'instance de PDO
     *
     * @return \PDO
     */
    public function getPDO()
    {
        if ($this->pdo != null)
            return $this->pdo;

        $host = config("database.host");
        $port = config("database.port");
        $username = config("database.username");
        $password = config("database.password");
        $dbname = config("database.database");
        
        try{
            $pdo = new \PDO(
                "mysql:dbname=$dbname;host=$host;port=$port", $username, $password, 
                [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
            );
    
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);        
        
            $this->pdo = $pdo;
        } catch(\PDOExecption $e) {
            dd($e->getMessage());
        }

        return $this->pdo;
    }

    /**
     * Return last insert id
     *
     * @return void
     */
    public function lastInsertId()
    {
        $pdo = $this->getPDO();
        return $pdo->lastInsertId();
    }

    /**
     * Execuse SQL request
     *
     * @param string $sql
     * @param array $params
     * @return \PDOStatement
     */
    public function query(string $sql, array $params = []): \PDOStatement
    {
        $pdo = $this->getPDO();

        $req = $pdo->prepare($sql);
        $req->execute($params);

        return $req;
    }
}
