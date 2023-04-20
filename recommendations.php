<?php
session_start();
require_once 'classes/User.class.php';

$title = 'Doporučení';
$active_page = 'recommendations';
$user = new User($_SESSION['user_id']);

require_once 'includes/header.inc.php';

echo '<h1>Doporučení kamarádů</h1>';

echo '<div class="container-sm">';
echo '<h2>Doporučené filmy</h2>';

$recommendedMovies = $user->getUsersMovieRecommendations();

foreach ($recommendedMovies as $recommendation) {
    var_dump($recommendation);
}

echo '<h2>Doporučené seriály</h2>';
echo '</div>';

require_once 'includes/footer.inc.php';