<?php

class Dbh {
    // Údaje pro webglobe hosting
    private $host = "db.dw175.webglobe.com";
    private $username = "showsocialuser";
    private $password = "Ayylmao1337";
    private $dbname = "show_social";

    // Údaje pro lokální vývojové prostředí
    /*
    private $host = "localhost";
    private $username = "root";
    private $password = "ayylmao1337";
    private $dbname = "show_social";
    */

    public function connect() {
        $dsn = 'mysql:host=' .  $this->host .';dbname=' . $this->dbname;
        $pdo = new PDO($dsn, $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}