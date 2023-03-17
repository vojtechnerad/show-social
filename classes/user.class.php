<?php

class User extends Dbh {
    private $id;

    function __construct($userId) {
        $this->id = $userId;
    }

    function getSeenMovies() {
        $sql = 'SELECT movie_id FROM seen_movies WHERE user_id = ' . $_SESSION['user_id'];
        $statement = $this->connect()->query($sql)->fetchAll();
        return $statement;
    }

    function getId() {
        return $this->id;
    }
}