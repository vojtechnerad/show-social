<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbconn.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Movie.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.class.php';

header("Access-Control-Allow-Origin: *");
$method = $_SERVER['REQUEST_METHOD'];

// Check for PUT method
$requestMethod = $_SERVER['REQUEST_METHOD'];
$json = file_get_contents('php://input');
$data = json_decode($json);

if ($requestMethod === 'POST') {
    $movieId = $data->movieId;
    $movie = new Movie($movieId);
    $movieData = $movie->getDataFromTmdb();

    try {
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

        $response = new stdClass();

        if ($queryResult->rowCount() == 1) {
            $sql = 'DELETE FROM `seen_movies` WHERE user_id = ' . $_SESSION['user_id'] . ' AND movie_id = ' . $movieId;
            $db->query($sql);
            $response->successfulChange = true;
            $response->newSeenStatus = false;

        } else {
            $sql = 'INSERT INTO seen_movies (user_id, movie_id) VALUES ("' . $_SESSION['user_id'] . '", ' . $movieId .')';
            $db->query($sql);
            $response->successfulChange = true;
            $response->newSeenStatus = true;
        }

        $user = new User($_SESSION['user_id']);
        $watchtimeObject = $user->getWatchtimePerLastDay();
        $response->newWatchtimePercentage = $watchtimeObject->watchtimePercentage;
        header("Content-Type: application/json");
        echo json_encode($response);
    } catch (PDOException $PDOException) {
        $response = new stdClass();
        $response->successfulChange = false;
        header("Content-Type: application/json");
        echo json_encode($response);
    }
}