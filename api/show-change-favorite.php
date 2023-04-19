<?php
/**
 *
 */

session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/TvShow.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/dbconn.inc.php';

// Kontrola POST requestu
header("Access-Control-Allow-Origin: *");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    //$movieId = $data->movieId;
    $showId = $data->showId;

    $show = new TvShow($showId);
    $showData = $show->getDataFromTmdb();

    // Odchytávání chyby při zápisu do databáze
    try {
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


        $isFavoritedStatement = $db->prepare('
            SELECT user_id, show_id
            FROM favorite_tv_shows
            WHERE user_id = (:user_id) AND show_id = (:show_id)
            LIMIT 1;
        ');
        $isFavoritedStatement->execute([
            ':user_id' => $_SESSION['user_id'],
            ':show_id' => $showId
        ]);
        $isFavorited = $isFavoritedStatement->fetch();

        $response = new stdClass();

        if ($isFavorited) {
            $deleteBookmarkStatement = $db->prepare('
                DELETE FROM favorite_tv_shows
                WHERE user_id = (:user_id) AND show_id = (:show_id);
            ');
            $deleteBookmarkStatement->execute([
                ':user_id' => $_SESSION['user_id'],
                ':show_id' => $showId
            ]);
            $response->successfulChange = true;
            $response->newSeenStatus = false;
        } else {
            $insertBookmarkStatement = $db->prepare('
                INSERT INTO favorite_tv_shows (user_id, show_id)
                VALUES ((:user_id), (:show_id));
            ');
            $insertBookmarkStatement->execute([
                ':user_id' => $_SESSION['user_id'],
                ':show_id' => $showId
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