<?php
require_once '../includes/dbconn.inc.php';
require_once '../classes/Movie.php';
session_start();

header("Access-Control-Allow-Origin: *");
$method = $_SERVER['REQUEST_METHOD'];

// Check for PUT method
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'PUT') {
    $movieId = $_GET['movie_id'];
    $movie = new Movie($movieId);
    $movieData = $movie->getDataFromTmdb();

    // Uložení dat o filmu do databáze
    $insertMovieDataStatement = $db->prepare('
        REPLACE INTO movies (movie_id, title, original_title, poster_path, runtime, release_date, overview)
        VALUES (:movie_id, :title, :original_title, :poster_path, :runtime, :release_date, :overview);
    ');
     $insertMovieDataStatement->execute([
        ':movie_id' => $movieData->id,
        ':title' => $movieData->title,
        ':original_title' => $movieData->original_title,
        ':poster_path' => $movieData->poster_path,
        ':runtime' => $movieData->runtime,
        ':release_date' => $movieData->release_date,
        ':overview' => $movieData->overview
     ]);

    $sql = 'SELECT user_id, movie_id FROM seen_movies WHERE user_id = ' . $_SESSION['user_id'] . ' AND movie_id = ' . $movieId;
    $queryResult = $db->query($sql);
    if ($queryResult->rowCount() == 1) {
        $sql = 'DELETE FROM `seen_movies` WHERE user_id = ' . $_SESSION['user_id'] . ' AND movie_id = ' . $movieId;
        if ($db->query($sql)) {
            $success = 1;
            $newStatus = 'notseen';
        } else {
            $success = 0;
        }
    } else {
        $sql = 'INSERT INTO seen_movies (user_id, movie_id) VALUES ("' . $_SESSION['user_id'] . '", ' . $movieId .')';
        if ($db->query($sql)) {
            $success = 1;
            $newStatus = 'seen';
        } else {
            $success = 0;
        }
    }

    header("Content-Type: application/json");
    $data = array('success' => $success, 'newStatus' => $newStatus);
    echo json_encode($data);
}