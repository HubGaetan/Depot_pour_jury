<?php

namespace App\models;

class User extends Model {

    protected $table = 'users';

    /**
     * Summary of getByUsername
     * @param string $username
     * @return User
     */
    public function getByUsername(string $username): User|bool
    {
        return $this->query("SELECT * FROM {$this->table} WHERE username = ?", [$username], true);
    }
}
