<?php

namespace App\Models;

class Model 
{
    /**
     * Table name
     *
     * @var string|boolean
     */
    public $table = false;

    public function getTableName()
    {
        if( $this->table )
            return $this->table;
    }
}