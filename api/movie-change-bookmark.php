<?php
/**
 *
 */

session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Movie.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbconn.inc.php';

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

        $isBookmarkedStatement = $db->prepare('
            SELECT user_id, movie_id
            FROM bookmarked_movies
            WHERE user_id = (:user_id) AND movie_id = (:movie_id)
            LIMIT 1;
        ');

        $isBookmarkedStatement->execute([
            ':user_id' => $_SESSION['user_id'],
            ':movie_id' => $movieId
        ]);
        $isBookmarked = $isBookmarkedStatement->fetch();

        $response = new stdClass();

        if ($isBookmarked) {
            $deleteBookmarkStatement = $db->prepare('
                DELETE FROM bookmarked_movies
                WHERE user_id = (:user_id) AND movie_id = (:movie_id);
            ');
            $deleteBookmarkStatement->execute([
                ':user_id' => $_SESSION['user_id'],
                ':movie_id' => $movieId
            ]);
            $response->successfulChange = true;
            $response->newSeenStatus = false;
        } else {
            $insertBookmarkStatement = $db->prepare('
                INSERT INTO bookmarked_movies (user_id, movie_id)
                VALUES ((:user_id), (:movie_id));
            ');
            $insertBookmarkStatement->execute([
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