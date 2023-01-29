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
     * Find entry by id
     *
     * @param integer $id
     * @return object|false
     */
    public function findById(int $id)
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE id = ?", [$id])->fetch();
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
}