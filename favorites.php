<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.class.php';

$title = 'Oblíbené';
$active_page = 'profile';

// Generování obsahu stránky
include 'includes/header.inc.php';
echo '<h1>Oblíbené</h1>';

$user = new User($_SESSION['user_id']);


// Založené filmy
$bookmarkedMovies = $user->favoriteMovies();

echo '<div class="container-sm mb-3">';
echo '<h2>Oblíbené filmy</h2>';

echo '<div class="list-group">';
if ($bookmarkedMovies) {
    foreach ($bookmarkedMovies as $bookmarkedMovie) {
        echo '<a href="./movie.php?id=' . $bookmarkedMovie['movie_id'] . '" class="list-group-item list-group-item-action">';
        echo '<div class="d-flex w-100 justify-content-between">';
        echo '<h5 class="mb-1">' . $bookmarkedMovie['title'] . '</h5>';
        $bookmarkedTime = date_create($bookmarkedMovie['timestamp']);
        echo '<small>' . date_format($bookmarkedTime, 'd.m.Y H:i') . '</small>';
        echo '</div>';
        echo '<p class="mb-1">' . htmlspecialchars($bookmarkedMovie['original_title']) . '</p>';
        echo '</a>';
    }
} else {
    echo '<div class="list-group-item">Nemáte žádné založené filmy.</div>';
}
echo '</div>';
echo '</div>';

// Založené seriály
$bookmarkedTvShows = $user->favoriteTvShows();

echo '<div class="container-sm mb-3">';
echo '<h2>Oblíbené seriály</h2>';

echo '<div class="list-group">';
if ($bookmarkedTvShows) {
    foreach ($bookmarkedTvShows as $bookmarkedTvShow) {
        echo '<a href="./show.php?id=' . $bookmarkedTvShow['show_id'] . '" class="list-group-item list-group-item-action">';
        echo '<div class="d-flex w-100 justify-content-between">';
        echo '<h5 class="mb-1">' . $bookmarkedTvShow['name'] . '</h5>';
        $bookmarkedTime = date_create($bookmarkedTvShow['timestamp']);
        echo '<small>' . date_format($bookmarkedTime, 'd.m.Y H:i') . '</small>';
        echo '</div>';
        echo '<p class="mb-1">' . htmlspecialchars($bookmarkedTvShow['original_name']) . '</p>';
        echo '</a>';
    }
} else {
    echo '<div class="list-group-item">Nemáte žádné založené seriály.</div>';
}
echo '</div>';
echo '</div>';


include 'includes/footer.inc.php';
?>
