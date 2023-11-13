<?php
/** @var \PDO $db - připojení k databázi */
// Údaje pro Webglobe hosting
$db = new PDO('mysql:host=db.dw175.webglobe.com;port=3306;dbname=show_social;charset=utf8', 'showsocialuser', 'Ayylmao1337');

// Údaje pro lokální vývojové prostředí
// $db = new PDO('mysql:host=localhost;dbname=show_social;charset=utf8', 'root', 'ayylmao1337');

//při chybě v SQL chceme vyhodit Exception
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);