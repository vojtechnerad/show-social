<?php
/**
 * Stránka Seen Movies
 *
 */
@session_start();
//require_once './includes/dbconn.inc.php';
require_once 'classes/User.class.php';

$userId = $_GET['user_id'];
$title = 'Zhlédnuté filmy';
$active_page = 'people';

if (!is_numeric($userId)) {
    include 'includes/header.inc.php';
    echo '<h1>Chyba!</h1>';
    echo '<p>Hledaný účet neexistuje.</p>';
    include 'includes/footer.inc.php';
    exit();
}

$selectedUser = new User($userId);
$selectedUserData = $selectedUser->getUserData();

include 'includes/header.inc.php';

echo '<h1>' . htmlspecialchars($selectedUserData['full_name']) . '</h1>';
echo '<h2>@' .htmlspecialchars($selectedUserData['user_name']) . '</h2>';

$seenEpisodes = $selectedUser->getSeenEpisodes();

echo '<div class="container-sm">';
echo '<h3 class="mb-3">Zhlédnuté epizody</h3>';
echo '<div class="row col-12 p-3 m-0">';

foreach ($seenEpisodes as $seenEpisode) {
    echo '<div class="col-lg-6">';
    echo '<div class="card mb-3">';
    echo '<div class="row row-cols-auto g-0">';
    // Plakát část
    echo '<div>';
    echo '<img src="https://image.tmdb.org/t/p/w500' . $seenEpisode['poster_path'] . '" class="img-fluid rounded-start" alt="..." style="max-height: 210px;">';
    echo '</div>';

    // Body část
    echo '<div>';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $seenEpisode['show_name'] . '</h5>';
    echo '<h6 class="card-subtitle mb-2 text-body-secondary">' . $seenEpisode['episode_name'] . '</h6>';
    $episodeCode = 'S' . $seenEpisode['season_number'] . 'E' . $seenEpisode['episode_number'];
    echo '<p class="card-text">' . $episodeCode . '</p>';
    echo '<p class="card-text"><i class="bi bi-clock-fill"></i> ' . $seenEpisode['runtime'] . ' minut</p>';
    $seenTime = date_create($seenEpisode['seen_time']);
    echo '<p class="card-text"><small class="text-body-secondary"><i class="bi bi-calendar-event-fill"></i> Zhlédnuto: ' . date_format($seenTime, 'd.m.Y H:i') . '</small></p>';
    echo '<a href="show.php?id=' . $seenEpisode['show_id'] . '" class="stretched-link""></a>';
    echo '</div>';
    echo '</div>';

    echo '</div>';
    echo '</div>';
    echo '</div>';
}

echo '</div>';
echo '</div>';

include 'includes/footer.inc.php';
?>

