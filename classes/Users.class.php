<?php

class Users extends Dbh {

    function __construct() {

    }

    function getAllUsers() {
        $sql = 'SELECT id, first_name, last_name FROM users';
        $statement = $this->connect()->query($sql)->fetchAll();
        return $statement;
    }
}