<?php
/** @var \PDO $db - připojení k databázi */
$db = new PDO('mysql:host=127.0.0.1;dbname=show_social;charset=utf8', 'root', 'ayylmao1337');

//při chybě v SQL chceme vyhodit Exception
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);