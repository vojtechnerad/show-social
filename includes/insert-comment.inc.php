<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Movie.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/TvShow.class.php';
@session_start();
$signedUserId = $_SESSION['user_id'];

if ($signedUserId) {
    $signedUser = new User($signedUserId);
    $type = $_POST['type'];
    $idOfMedium = $_POST['medium_id']; // id buď filmu nebo seriálu
    $comment = $_POST['comment'];
    
    if ($type === 'movie') {
        if ($comment !== '') {
            $movie = new Movie($idOfMedium);
            $movie->insertNewComment($signedUserId, $comment);
        }
        header('Location: ../movie.php?id=' . $idOfMedium);
        exit();
    }

    if ($type === 'tv_show') {
        if ($comment !== '') {
            $tvShow = new TvShow($idOfMedium);
            $tvShow->insertNewComment($signedUserId, $comment);
        }
        header('Location: ../show.php?id=' . $idOfMedium);
        exit();
    }
}

echo 'Chyba - nesprávná oprávnění!';
echo '<a href="../">Zpět do aplikace</a>';