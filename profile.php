<?php
require 'classes/dbh.class.php';
require 'classes/User.class.php';

session_start();

if (!$_SESSION['user_id']) {
    header('Location: signin.php');
    exit();
}

$title = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
$active_page = 'profile';
include 'includes/header.inc.php';
?>
<div id="profile-container">
<h1><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];?></h1>
</div>

<?php
$user = new User($_SESSION['user_id']);
$lastSeenMoviesStatement = $db->prepare('
    SELECT seen_movies.user_id as user_id, seen_movies.movie_id as movie_id, seen_movies.timestamp as seen_time, movies.title as title, movies.poster_path as poster_path
    FROM seen_movies
    LEFT JOIN movies
    ON seen_movies.movie_id = movies.movie_id
    WHERE user_id = (:user_id)
    ORDER BY seen_time DESC
    LIMIT 10;
');
$lastSeenMoviesStatement->execute([
   ':user_id' => $_SESSION['user_id']
]);
$lastSeenMoviesData = $lastSeenMoviesStatement->fetchAll();
if ($lastSeenMoviesData) {
    echo '<h2>Poslední zhlédnuté filmy</h2>';
    echo '<div class="row">';
    foreach ($lastSeenMoviesData as $seenMovie) {
        echo '<div class="card p-0 ms-2 mb-2" style="width: 10rem;">';
        echo '<img src="https://image.tmdb.org/t/p/w500' . $seenMovie['poster_path'] . '" class="card-img-top" alt="...">'; // TODO alt text
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $seenMovie['title'] . '</h5>';

        echo '<a href="movie.php?id=' . $seenMovie['movie_id'] . '" class="stretched-link"></a>';
        $seenTime = date_create($seenMovie['seen_time']);
        echo '</div>';
        echo '<div class="card-footer text-body-secondary">';
        echo date_format($seenTime, 'd.m.Y H:i');
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}


echo '<h2>Poslední zhlédnuté epizody</h2>';
$lastSeenEpisodesStatement = $db->prepare('
    SELECT tv_shows.id as show_id,
           tv_shows.name as show_name,
           tv_shows.poster_path as poster_path,
           tv_show_episodes.name as episode_name,
           seen_episodes.timestamp as seen_time,
           tv_show_episodes.season_number as season_number,
           tv_show_episodes.episode_number as episode_number
    FROM seen_episodes
    LEFT JOIN tv_show_episodes
    ON seen_episodes.id = tv_show_episodes.id
    LEFT JOIN tv_shows
    ON tv_show_episodes.show_id = tv_shows.id
    WHERE user_id = (:user_id)
    ORDER BY seen_time DESC
    LIMIT 10;
');
$lastSeenEpisodesStatement->bindParam(':user_id', $_SESSION['user_id']);
$lastSeenEpisodesStatement->execute();
$lastSeenEpisodesData = $lastSeenEpisodesStatement->fetchAll();
echo '<div class="row">';
foreach ($lastSeenEpisodesData as $seenEpisode) {
    //var_dump($seenEpisode);
    // Tvorba karty epizody
    echo '<div class="card p-0 ms-2 mb-2" style="width: 10rem;">';
    echo '<img src="https://image.tmdb.org/t/p/w500' . $seenEpisode['poster_path'] . '" class="card-img-top" alt="...">'; // TODO alt text
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $seenEpisode['show_name'] . '</h5>';
    echo '<h6 class="card-title">' . $seenEpisode['episode_name'] . '</h6>';
    $episodeCode = 'S' . $seenEpisode['season_number'] . 'E' . $seenEpisode['episode_number'];
    echo '<p class="card-text">' . $episodeCode . '</p>';
    echo '<a href="show.php?id=' . $seenEpisode['show_id'] . '" class="stretched-link""></a>';
    $seenTime = date_create($seenEpisode['seen_time']);
    echo '</div>';
    echo '<div class="card-footer text-body-secon dary">';
    echo date_format($seenTime, 'd.m.Y H:i');
    echo '</div>';
    echo '</div>';
}
echo '</div>';
include 'includes/footer.inc.php';
?>