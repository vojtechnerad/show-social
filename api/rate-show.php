<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/dbconn.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/TvShow.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/User.class.php';

// Check for PUT method
$requestMethod = $_SERVER['REQUEST_METHOD'];
$json = file_get_contents('php://input');
$data = json_decode($json);

if ($requestMethod === 'POST') {
    $rating = $data->rating;
    if ((is_int($rating) AND $rating <= 100 AND $rating >= 0) OR $rating == '') {
        $show = new TvShow($data->showId);
        $showData = $show->getDataFromTmdb();

        try {
            // Uložení dat o seriálu do databáze
            $insertShowDataStatement = $db->prepare('
            REPLACE INTO tv_shows (id, name, original_name, poster_path)
            VALUES (:id, :name, :original_name, :poster_path);
        ');
            $insertShowDataStatement->execute([
                ':id' => $showData['id'],
                ':name' => $showData['name'],
                ':original_name' => $showData['original_name'],
                ':poster_path' => $showData['poster_path'],
            ]);

            $response = new stdClass();

            if ($rating != '') {
                $insertRatingStatement = $db->prepare('
                    REPLACE INTO show_ratings (user_id, show_id, rating)
                    VALUES (:user_id, :show_id, :rating);
                ');
                $insertRatingStatement->execute([
                    ':user_id' => $_SESSION['user_id'],
                    ':show_id' => $data->showId,
                    ':rating' => $rating
                ]);
                $response->successfulChange = true;
                $response->newRatingValue = $rating;
            } else {
                $deleteRatingStatement = $db->prepare('
                    DELETE FROM show_ratings
                    WHERE user_id = (:user_id) AND show_id = (:show_id);
                ');
                $deleteRatingStatement->execute([
                    ':user_id' => $_SESSION['user_id'],
                    ':show_id' => $data->showId
                ]);
                $response->successfulChange = true;
                $response->newRatingValue = false;
            }
            $response->newServerRating = $show->getTvShowRating($data->showId);
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