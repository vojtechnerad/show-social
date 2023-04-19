<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbconn.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Movie.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.class.php';

// Check for PUT method
$requestMethod = $_SERVER['REQUEST_METHOD'];
$json = file_get_contents('php://input');
$data = json_decode($json);

if ($requestMethod === 'POST') {
    $rating = $data->rating;
    if ((is_int($rating) AND $rating <= 100 AND $rating >= 0) OR $rating == '') {
        $movie = new Movie($data->movieId);
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

            $response = new stdClass();

            if ($rating != '') {
                $insertRatingStatement = $db->prepare('
                    REPLACE INTO movie_ratings (user_id, movie_id, rating)
                    VALUES (:user_id, :movie_id, :rating);
                ');
                $insertRatingStatement->execute([
                    ':user_id' => $_SESSION['user_id'],
                    ':movie_id' => $data->movieId,
                    ':rating' => $rating
                ]);
                $response->successfulChange = true;
                $response->newRatingValue = $rating;
            } else {
                $deleteRatingStatement = $db->prepare('
                    DELETE FROM movie_ratings
                    WHERE user_id = (:user_id) AND movie_id = (:movie_id);
                ');
                $deleteRatingStatement->execute([
                    ':user_id' => $_SESSION['user_id'],
                    ':movie_id' => $data->movieId
                ]);
                $response->successfulChange = true;
                $response->newRatingValue = false;
            }
            $response->newServerRating = $movie->getMovieRating($data->movieId);
            header("Content-Type: application/json");
            echo json_encode($response);
        } catch (PDOException $PDOException) {
            $response = new stdClass();
            $response->successfulChange = false;
            header("Content-Type: application/json");
            echo json_encode($response);
        }
    }
}