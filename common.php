<?php
session_start();
require_once 'classes/User.class.php';
$targetUserId = $_GET['targetUser'];
if (!isset($targetUserId)) {
    require_once 'includes/header.inc.php';
    echo '<h1>Chyba</h1>';
    require_once 'includes/footer.inc.php';
}


$active_page = 'people';
$title = 'Společné';

$user = new User($_SESSION['user_id']);


require_once 'includes/header.inc.php';

echo '<h1>Společné zhlédnuté</h1>';


echo '<div class="container-sm mb-3">';
echo '<h2>Společné filmy</h2>';
$movieList = $user->listSeenMoviesInCommon($targetUserId);

echo '<div class="list-group">';
if ($movieList) {
    foreach ($movieList as $movie) {
        echo '<a href="./movie.php?id=' . $movie['movie_id'] . '" class="list-group-item list-group-item-action">';
        echo '<div class="d-flex w-100 justify-content-between">';
        echo '<h5 class="mb-1">' . $movie['title'] . '</h5>';
        echo '</div>';
        echo '<p class="mb-1">' . htmlspecialchars($movie['original_title']) . '</p>';
        echo '</a>';
    }
} else {
    echo '<div class="list-group-item">Nemáte žádné společné zhlédnuté filmy.</div>';
}
echo '</div>';
echo '</div>';



echo '<div class="container-sm mb-3">';
echo '<h2>Společné epizody</h2>';
$episodeList = $user->listSeenEpisodesInCommon($targetUserId);

echo '<div class="list-group">';
if ($episodeList) {
    foreach ($episodeList as $episode) {
        echo '<a href="./show.php?id=' . $episode['show_id'] . '" class="list-group-item list-group-item-action">';
        echo '<div class="d-flex w-100 justify-content-between">';
        echo '<h5 class="mb-1">' . $episode['show_name'] . '</h5>';
        echo '</div>';
        echo '<p class="mb-1">' . htmlspecialchars($episode['show_original_name']) . '</p>';
        echo '<p class="mb-1"><small class="text-body-secondary">' . htmlspecialchars('[' . $episode['episode_code'] . '] ' . $episode['episode_name']) . '</small></p>';
        echo '</a>';
    }
} else {
    echo '<div class="list-group-item">Nemáte žádné společné zhlédnuté epizody.</div>';
}
echo '</div>';
echo '</div>';
require_once 'includes/footer.inc.php';