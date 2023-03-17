<?php
require_once '../../classes/Movie.php';

$movie = new Movie(913290);
$movieData = $movie->getDataFromTmdb();
var_dump($movieData);