<?php

class Dbh {
    private $host = "localhost";
    private $username = "root";
    private $password = "ayylmao1337";
    private $dbname = "show_social";

    public function connect() {
        $dsn = 'mysql:host=' .  $this->host .';dbname=' . $this->dbname;
        $pdo = new PDO($dsn, $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}