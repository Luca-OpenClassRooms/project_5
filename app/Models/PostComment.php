<?php

namespace App\Models;

class PostComment extends Model
{

    private string $hiddenSQL = "";

    public function __construct(private int $postId, private bool $showHidden = false)
    {
        parent::__construct();

        if (!$this->showHidden) {
            if (isset($_SESSION["user"])) {
                $this->hiddenSQL = "AND (validated = 1 OR user_id = {$_SESSION["user"]->id})";
            } else {
                $this->hiddenSQL = "AND validated = 1";
            }
        }
    }
    /**
     * Get all entries of table
     *
     * @return object|false
     */    
    public function all()
    {
        return $this->db->query("
            SELECT a.*, b.first_name, b.last_name FROM {$this->table} as a
            LEFT JOIN users as b ON a.user_id = b.id
            WHERE post_id = ? {$this->hiddenSQL}
            ORDER BY id DESC
            {$this->limit}
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

    /**
     * Get pagination limit
     *
     * @param integer $current
     * @param integer $perPage
     * @return void
     */
    public function paginate(int $current, int $perPage)
    {
        $count = $this->db->query("SELECT COUNT(*) as count FROM {$this->table} WHERE post_id = ? {$this->hiddenSQL}", [$this->postId])->fetch();
        $nbData = $count->count;

        $pages = ceil($nbData / $perPage);
        $first = ($current * $perPage) - $perPage;

        $this->limit = "LIMIT $first, $perPage";

        return [
            "total" => $nbData,
            "pages" => $pages,
            "current" => $current,
            "perPage" => $perPage,
            "data" => $this->all()
        ];
    }    
}