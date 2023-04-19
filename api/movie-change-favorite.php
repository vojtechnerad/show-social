<?php
/**
 *
 */

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/Movie.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/dbconn.inc.php';

// Kontrola POST requestu
header("Access-Control-Allow-Origin: *");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    //$movieId = $data->movieId;
    $movieId = $data->movieId;

    $movie = new Movie($movieId);
    $movieData = $movie->getDataFromTmdb();

    // Odchytávání chyby při zápisu do databáze
    try {
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

        $isFavoriteStatement = $db->prepare('
            SELECT user_id, movie_id
            FROM favorite_movies
            WHERE user_id = (:user_id) AND movie_id = (:movie_id)
            LIMIT 1;
        ');

        $isFavoriteStatement->execute([
            ':user_id' => $_SESSION['user_id'],
            ':movie_id' => $movieId
        ]);
        $isFavorite = $isFavoriteStatement->fetch();

        $response = new stdClass();

        if ($isFavorite) {
            $deleteFavoriteStatement = $db->prepare('
                DELETE FROM favorite_movies
                WHERE user_id = (:user_id) AND movie_id = (:movie_id);
            ');
            $deleteFavoriteStatement->execute([
                ':user_id' => $_SESSION['user_id'],
                ':movie_id' => $movieId
            ]);
            $response->successfulChange = true;
            $response->newSeenStatus = false;
        } else {
            $insertFavoriteStatement = $db->prepare('
                INSERT INTO favorite_movies (user_id, movie_id)
                VALUES ((:user_id), (:movie_id));
            ');
            $insertFavoriteStatement->execute([
                ':user_id' => $_SESSION['user_id'],
                ':movie_id' => $movieId
            ]);
            $response->successfulChange = true;
            $response->newSeenStatus = true;
        }

        header("Content-Type: application/json");
        echo json_encode($response);
    } catch (PDOException $PDOException) {
        $response = new stdClass();
        header("Content-Type: application/json");
        $response->successfulChange = false;
        echo json_encode($response);
    }
}