<?php

namespace App\Models;

class PostComment extends Model
{
    public function __construct(private int $postId)
    {
        parent::__construct();
    }
    /**
     * Get all entries of table
     *
     * @return object|false
     */    
    public function all()
    {
        return $this->db->query("
            SELECT * FROM {$this->table} 
            WHERE post_id = ?
        ", [$this->postId])->fetchAll();
    }

    /**
     * Find a entry of table
     *
     * @param integer $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE id = ?", [$id])->fetch();
    }
}