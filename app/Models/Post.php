<?php

namespace App\Models;

class Post extends Model
{
    /**
     * Get all entries of table
     *
     * @return object|false
     */    
    public function all()
    {
        return $this->db->query("SELECT 
            p.*,
            (
                SELECT COUNT(*)
                FROM post_comments as c
                WHERE c.post_id = p.id AND c.validated = 1
            ) AS comments_count
            FROM {$this->table} as p
            ORDER BY created_at DESC
            {$this->limit}
        ")->fetchAll();
    }


    /**
     * Find a entry of table
     *
     * @param string $slug
     * @return mixed
     */
    public function find(string $slug)
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE slug = ?", [$slug])->fetch();
    }
}
