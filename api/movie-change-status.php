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

// Check for PUT method
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'PUT') {
    $movieId = $_GET['movie_id'];

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