<?php
require_once '../includes/dbconn.inc.php';
session_start();

header("Access-Control-Allow-Origin: *");
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $movieId = $_GET['movie_id'];

    $sql = 'SELECT user_id, movie_id FROM seen_movies WHERE user_id = ' . $_SESSION['user_id'] . ' AND movie_id = ' . $movieId;
    $queryResult = $db->query($sql);
    if ($queryResult->rowCount() == 1) {
        $seen = 'seen';
    } else {
        $seen = 'notseen';
    }

    header("Content-Type: application/json");
    $data = array('status' => $seen);
    echo json_encode($data);
}