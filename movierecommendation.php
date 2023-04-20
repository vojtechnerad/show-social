<?php
session_start();
require_once 'classes/User.class.php';
require_once 'classes/Movie.php';
require_once 'includes/dbconn.inc.php';

$title = 'Doporučení filmu';
$active_page = 'movie';

if (!isset($_GET['movieId'])) {
    include 'includes/header.inc.php';
    echo '<h1>Chyba</h1>';
    include 'includes/footer.inc.php';
    exit();
}
$user = new User($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {

        $movieId = $_GET['movieId'];
        $movie = new Movie($movieId);
        $movieData = $movie->getDataFromTmdb();
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
        if (isset($_POST['save']) OR isset($_POST['update'])) {
            $user->recommendMovie($_GET['targetUserId'], $_GET['movieId'], $_POST['description']);
            echo 'xd1';
        } elseif (isset($_POST['delete'])) {
            $user->deleteMovieRecommendation($_GET['targetUserId'], $_GET['movieId']);
        }
        header('Location: movierecommendation.php?targetUserId=' . $_GET['targetUserId'] . '&movieId=' . $_GET['movieId']);
        exit();
    } catch (PDOException $PDOException) {

    }
}

$selectedMovie = new Movie($_GET['movieId']);
$selectedMovieData = $selectedMovie->getDataFromTmdb();

include 'includes/header.inc.php';
echo '<h1>Doporučení filmu</h1>';
echo '<div class="container-sm">';
// Výpis zvoleného filmu
echo '<div class="row">';

echo '<div class="col-8 col-md-10">';
echo '<h3>' . $selectedMovieData->title . '</h3>';
echo '<h4 class="mb-3">' . $selectedMovieData->original_title . '</h4>';
echo '<p class="mb-2"><i class="bi bi-calendar-event-fill"></i> ' . $selectedMovieData->release_date . '</p>';
echo '<p><i class="bi bi-clock-fill"></i> ' . $selectedMovieData->runtime . ' minut</p>';
echo '<p>' . $selectedMovieData->overview . '</p>';
echo '</div>';

echo '<div class="col-4 col-md-2">';
echo '<img src="https://www.themoviedb.org/t/p/w500' . $selectedMovieData->poster_path . '" class="rounded float-start img-fluid" alt="Plakát filmu ' . $selectedMovieData->title . '">';
echo '</div>';

echo '</div>';




$friends = $user->getFriendslist();
echo '<h2>Vybrat kamaráda</h2>';
echo '<form action="movierecommendation.php" method="get" class="row row-cols-lg-auto g-3 align-items-center justify-content-center mb-5">';
echo '<div class="col-12">';
echo '<select class="form-select" name="targetUserId" id="targetUserId" required>';
echo '<option disabled selected value="">Zvolte uživatele kterému chcete film doporučit</option>';
foreach ($friends as $friend) {
    $selected = '';
    if ($friend['friend_id'] == $_GET['targetUserId']) {
        $selected = ' selected';
    }
    echo '<option value="' . $friend['friend_id'] . '"' . $selected . '>' . $friend['full_name'] . ' (@' . $friend['user_name'] . ')</option>';
}
echo '</select>';
echo '</div>';

echo '<div class="col-12">';
echo ' <input type="hidden" id="movieId" name="movieId" value="' . $_GET['movieId'] . '">';
echo '<button type="submit" class="btn btn-primary">Vybrat</button>';
echo '</div>';
echo '</form>';
?>

<?php


if (isset($_GET['targetUserId'])) {
    $targetUserId = $_GET['targetUserId'];
    $friend = new User($targetUserId);
    $friendData = $friend->getUserData();

    echo '<h3>Obsah doporučení pro ' . $friendData['full_name'] . ' (@' . $friendData['full_name'] . ')</h3>';

    $isMovieAlreadyRecommended = $user->isMovieRecommendedToUser($targetUserId, $_GET['movieId']);

    echo '<form action="movierecommendation.php?targetUserId=' . $_GET['targetUserId'] . '&movieId=' . $_GET['movieId'] . '" method="post">';
    if ($isMovieAlreadyRecommended) {
        echo '<textarea class="form-control" id="description" name="description" rows="3" placeholder="Napište kamarádivu důvod proč mu film doporučujete.">' . $isMovieAlreadyRecommended['description'] . '</textarea>';
        echo '<button type="submit" class="btn btn-primary" name="update"><i class="bi bi-arrow-repeat"></i> Aktualizovat</button>';
        echo '<button type="submit" class="btn btn-danger" name="delete"><i class="bi bi-trash-fill"></i> Smazat</button>';
    } else {
        echo '<textarea class="form-control" id="description" name="description" rows="3" placeholder="Napište kamarádivu důvod proč mu film doporučujete."></textarea>';
        echo '<button type="submit" class="btn btn-primary" name="save"><i class="bi bi-save2-fill"></i> Uložit</button>';
    }
    echo '</form>';




}
echo '</div>';
include 'includes/footer.inc.php';
