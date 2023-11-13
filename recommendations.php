<?php
session_start();
require_once 'classes/User.class.php';

$title = 'Doporučení';
$active_page = 'recommendations';
$user = new User($_SESSION['user_id']);

require_once 'includes/header.inc.php';

echo '<h1 class="mb-4">Doporučení kamarádů</h1>';

echo '<div class="container-sm">';
echo '<h2 class="mb-3">Doporučené filmy</h2>';

$recommendedMovies = $user->getUsersMovieRecommendations();

echo '<div class="list-group mb-4">';
if ($recommendedMovies) {
    foreach ($recommendedMovies as $recommendation) {
        echo '<div class="list-group-item">';
        echo '<div class="row row-cols-md-2 row-cols-1 mb-3">';

        echo '<div class="col">';
        echo '<h5>' . $recommendation['title'] . '</h5>';
        echo '<p>' . $recommendation['original_title'] . '</p>';
        echo '</div>';

        echo '<div class="col">';
        echo '<h5>' . htmlspecialchars($recommendation['full_name']) . '</h5>';
        echo '<p><i class="bi bi-sticky-fill"></i> ' . htmlspecialchars($recommendation['description']) . '</p>';
        $timestamp = date_create($recommendation['timestamp']);
        echo '<small class="text-body-secondary"><i class="bi bi-clock-fill"></i> Doporučeno: ' . htmlspecialchars(date_format($timestamp, 'd.m.Y H:m')) . '</small>';
        echo '</div>';

        echo '</div>';


        // Buttony

        echo '<div class="btn-group" role="group" aria-label="Basic example">';
        echo '<a href="movie.php?id=' . $recommendation['movie_id'] . '" class="btn btn-primary"><i class="bi bi-film"></i> Film</a>';
        echo '<a href="user.php?id=' . $recommendation['source_user_id'] . '" class="btn btn-secondary"><i class="bi bi-person-fill"></i> Uživatel</a>';
        echo '</div>';

        echo '</div>';
    }
} else {
    echo '<div class="list-group">';
    echo '<div class="list-group-item">Zatím vám nikdo žádný film nedoporučil.</div>';
    echo '</div>';
}

echo '</div>';

echo '<h2>Doporučené seriály</h2>';
$recommendedShows = $user->getUsersShowRecommendations();

echo '<div class="list-group mb-4">';
if ($recommendedShows) {
    foreach ($recommendedShows as $recommendation) {
        echo '<div class="list-group-item">';
        echo '<div class="row row-cols-md-2 row-cols-1 mb-3">';

        echo '<div class="col">';
        echo '<h5>' . $recommendation['name'] . '</h5>';
        echo '<p>' . $recommendation['original_name'] . '</p>';
        echo '</div>';

        echo '<div class="col">';
        echo '<h5>' . htmlspecialchars($recommendation['full_name']) . '</h5>';
        echo '<p><i class="bi bi-sticky-fill"></i> ' . htmlspecialchars($recommendation['description']) . '</p>';
        $timestamp = date_create($recommendation['timestamp']);
        echo '<small class="text-body-secondary"><i class="bi bi-clock-fill"></i> Doporučeno: ' . htmlspecialchars(date_format($timestamp, 'd.m.Y H:m')) . '</small>';
        echo '</div>';

        echo '</div>';


        // Buttony

        echo '<div class="btn-group" role="group" aria-label="Basic example">';
        echo '<a href="show.php?id=' . $recommendation['show_id'] . '" class="btn btn-primary"><i class="bi bi-film"></i> Seriál</a>';
        echo '<a href="user.php?id=' . $recommendation['source_user_id'] . '" class="btn btn-secondary"><i class="bi bi-person-fill"></i> Uživatel</a>';
        echo '</div>';

        echo '</div>';
    }
} else {
    echo '<div class="list-group">';
    echo '<div class="list-group-item">Zatím vám nikdo žádný seriál nedoporučil.</div>';
    echo '</div>';
}

echo '</div>';

require_once 'includes/footer.inc.php';