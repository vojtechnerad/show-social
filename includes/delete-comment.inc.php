<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Movie.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/TvShow.class.php';
@session_start();
$signedUserId = $_SESSION['user_id'];

if ($signedUserId) {
    $signedUser = new User($signedUserId);
    $signedUserData = $signedUser->getUserData();
    $type = $_POST['type'];
    $idOfMedium = $_POST['medium_id']; // id buď filmu nebo seriálu
    $commentId = $_POST['comment_id']; // id komentáře
    
    if ($type === 'movie') {
        $movie = new Movie($idOfMedium);
        $commentData = $movie->getMovieComment($commentId);

        if ($signedUserData['moderator'] || $commentData['user_id'] === $signedUserData['id']) {
            $movie->deleteMovieComment($commentId);
            header('Location: ../movie.php?id=' . $idOfMedium);
            exit();
        }
    }

    if ($type === 'tv_show') {
        $tvShow = new TvShow($idOfMedium);
        $commentData = $tvShow->getTvShowComment($commentId);

        if ($signedUserData['moderator'] || $commentData['user_id'] === $signedUserData['id']) {
            $tvShow->deleteTvShowComment($commentId);
            header('Location: ../show.php?id=' . $idOfMedium);
            exit();
        }
    }
}

echo 'Chyba - nesprávná oprávnění!';
echo '<a href="../">Zpět do aplikace</a>';