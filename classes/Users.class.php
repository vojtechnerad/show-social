<?php

class Users extends Dbh {

    function __construct() {

    }

    function getAllUsers() {
        $sql = 'SELECT id, first_name, last_name FROM users';
        $statement = $this->connect()->query($sql)->fetchAll();
        return $statement;
    }

    function getLastRegisteredUsers() {
        $sql = '
            SELECT id, concat(first_name, " ", last_name) as full_name, user_name, created_at
            FROM users
            ORDER BY created_at DESC
            LIMIT 6';
        $statement = $this->connect()->query($sql)->fetchAll();
        return $statement;
    }
}