<?php
require_once '../includes/dbconn.inc.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == 'GET') {
    $queryString = $_GET['queryString'];

    if ($queryString) {
        $userQueryStatement = $db->prepare('
        SELECT id, concat(first_name, " ", last_name) as full_name, user_name
        FROM users
        WHERE first_name LIKE CONCAT("%", (:queryString), "%")
        OR last_name LIKE CONCAT("%", (:queryString), "%")
        OR user_name LIKE CONCAT("%", (:queryString), "%");
    ');
        $userQueryStatement->execute([
            ':queryString' => $queryString
        ]);
        $userQueryData = $userQueryStatement->fetchAll();
    } else {
        $userQueryData = [];
    }

    // Output of results in JSON format
    header("Content-Type: application/json");
    echo json_encode($userQueryData);
}