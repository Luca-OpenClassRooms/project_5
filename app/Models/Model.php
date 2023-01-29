<?php

namespace App\Models;

use App\Core\App;

class Model 
{
    /**
     * Instance of database
     *
     * @var App\Core\Database
     */
    protected $db;

    /**
     * Table name
     *
     * @var string|boolean
     */
    public $table = false;


    protected $limit = "";

    public function __construct()
    {
        $app = App::getInstance();

        $this->db = $app->get("database");        
        $this->table = $this->getTableName();
    }

    /**
     * Get table name plural
     *
     * @return string
     */    
    public function getTableName()
    {
        $className = (new \ReflectionClass($this))->getShortName();

        $name = strtolower($className);
        $lastChar = $name[strlen($name) - 1];

        switch($lastChar) {
            case 'y':
                return substr($name, 0, -1) . 'ies';
            case 's':
                return $name . 'es';
            default:
                return $name .'s';
        }

        return $name;
    }

    /**
     * Get all entries of table
     *
     * @return object|false
     */    
    public function all()
    {
        return $this->db->query("SELECT * FROM {$this->table}")->fetchAll();
    }

    /**
     * Find entry by key
     *
     * @param integer $id
     * @return object|false
     */
    public function findBy(string $key, string $value)
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE {$key} = ?", [$value])->fetch();
    }

    /**
     * Get pagination limit
     *
     * @param integer $current
     * @param integer $perPage
     * @return void
     */
    public function paginate(int $current, int $perPage)
    {
        $count = $this->db->query("SELECT COUNT(*) as count FROM {$this->table}")->fetch();
        $nbData = $count->count;

        $pages = ceil($nbData / $perPage);
        $first = ($current * $perPage) - $perPage;

        $this->limit = "LIMIT $first, $perPage";

        return [
            "total" => $nbData,
            "pages" => $pages,
            "current" => $current,
            "perPage" => $perPage,
            "data" => $this->all(),
        ];
    }

    /**
     * Create a new instance of model
     *
     * @param array $data
     * @return object
     */
    public function create(array $data)
    {
        $sqlTable = "";
        $sqlValue = "";
        
        foreach($data as $k => $v)
        {
            $sqlTable .= "$k, ";
            $sqlValue .= ":$k, ";
        }

        $sqlTable = substr($sqlTable, 0, -2);
        $sqlValue = substr($sqlValue, 0, -2);

        $this->db->query("INSERT INTO {$this->table}($sqlTable) VALUES($sqlValue)", $data);
        $lastInsertId = $this->db->lastInsertId();

        return (object) array_merge(["id" => $lastInsertId], $data);
    }    

    /**
     * Update a instance of model
     *
     * @param array $data
     * @return object
     */
    public function update(int $id, array $data)
    {
        $sqlTable = "";
        $sqlValue = "";
        
        foreach($data as $k => $v)
        {
            $sqlTable .= "$k = :$k, ";
        }

        $sqlTable = substr($sqlTable, 0, -2);
        $sqlValue = substr($sqlValue, 0, -2);

        $this->db->query("UPDATE {$this->table} SET $sqlTable WHERE id = :id", [...$data, "id" => $id]);

        return (object) array_merge(["id" => $id], $data);
    }    

    /**
     * REmove a instance of model
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }
}