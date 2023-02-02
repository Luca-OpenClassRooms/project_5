<?php

namespace App\Models;

class PasswordReset extends Model
{
    /**
     * Delete password reset
     *
     * @param string $token
     * @param string $email
     * @return void
     */
    public function deleteToken(string $token, string $email)
    {
        $this->db->query("DELETE FROM password_resets WHERE token = ? AND email = ?", [$token, $email]);
    } 
}
