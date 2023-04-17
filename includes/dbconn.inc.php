<?php
/** @var \PDO $db - připojení k databázi */
//$db = new PDO('mysql:host=sqlb1.endora.cz;port=3306;dbname=showsocial;charset=utf8', 'vojtechnerad', 'Ayylmao1337');
$db = new PDO('mysql:host=localhost;dbname=show_social;charset=utf8', 'root', 'ayylmao1337');

//při chybě v SQL chceme vyhodit Exception
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);