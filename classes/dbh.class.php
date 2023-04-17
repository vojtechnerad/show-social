<?php

class Dbh {
    /* endora
    private $host = "sqlb1.endora.cz";
    private $username = "vojtechnerad";
    private $password = "Ayylmao1337";
    private $dbname = "showsocial";
    */
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