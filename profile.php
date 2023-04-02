<?php
//require 'includes/autoloader.inc.php';
require 'classes/dbh.class.php';
require 'classes/user.class.php';

session_start();
$title = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
$active_page = 'profile';
include 'includes/header.inc.php';
?>
<div id="profile-container">
<h1><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];?></h1>
</div>

<script>
<?php
$user = new User($_SESSION['user_id']);

$seenMovies = $user->getSeenMovies();
echo 'const seenMoviesArray = ' . json_encode($seenMovies) . ';';
?>
    function createSeenMoviesBar(seenMoviesArray) {
        const seenMoviesWrapper = document.createElement('div');
        seenMoviesWrapper.setAttribute("id", "seen-movies-wrapper");

        const seenMoviesTitle = document.createElement('h2');
        seenMoviesTitle.innerText = 'Zhlédnuté filmy';
        seenMoviesWrapper.appendChild(seenMoviesTitle);

        const seenMoviesContainer = document.createElement('div');
        seenMoviesContainer.setAttribute("id", "seen-movies-container");
        seenMoviesContainer.setAttribute("class", "row justify-content-start");

        seenMoviesArray.forEach(async seenMovie => {
            const res = await fetch("https://api.themoviedb.org/3/movie/" + seenMovie['movie_id'] + "?api_key=24d519ba38eaacef95f5c46bc71f2996&language=cs");
            let data = await res.json();

            //Col-12
            const column = document.createElement("div");
            column.setAttribute("class", "col-1 m-4");

            //Card
            const seenMovieCard = document.createElement('div');
            seenMovieCard.setAttribute("class", "card");
            seenMovieCard.setAttribute("style", "width: 12rem;");

            //Card body
            const seenMovieCardBody = document.createElement('div');
            seenMovieCardBody.setAttribute("class", "card-body");

            //Poster
            const seenMoviePoster = document.createElement("img");
            seenMoviePoster.src = "https://www.themoviedb.org/t/p/w500" + data["poster_path"];
            seenMoviePoster.setAttribute("class", "card-img-top");

            const seenMovieTileTitle = document.createElement('h5');
            seenMovieTileTitle.innerHTML = data["title"];

            //Link
            const seenMovieLink = document.createElement("a");
            seenMovieLink.setAttribute("href", "movie.php?id=" + seenMovie['movie_id']);
            seenMovieLink.setAttribute("class", "stretched-link");

            //Card footer
            const seenMovieCardFooter = document.createElement("div");
            seenMovieCardFooter.setAttribute("class", "card-footer");

            const seenMovieCardFooterSmall = document.createElement("small");
            seenMovieCardFooterSmall.setAttribute("class", "text-muted");
            seenMovieCardFooterSmall.innerHTML = "TODO ČAS";

            seenMovieCardFooter.appendChild(seenMovieCardFooterSmall);




            seenMovieCardBody.appendChild(seenMovieTileTitle);
            seenMovieCardBody.appendChild(seenMovieLink);
            seenMovieCard.appendChild(seenMoviePoster);
            seenMovieCard.appendChild(seenMovieCardBody);
            seenMovieCard.appendChild(seenMovieCardFooter);
            column.appendChild(seenMovieCard);
            seenMoviesContainer.appendChild(column);
        });

        seenMoviesWrapper.appendChild(seenMoviesContainer);
        document.getElementById("profile-container").appendChild(seenMoviesWrapper);
    }

    function createMovieTile(movieId) {

    }
    createSeenMoviesBar(seenMoviesArray);
<?php
echo '</script>';

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
    echo '<div class="card-footer text-body-secondary">';
    echo date_format($seenTime, 'd.m.Y H:i');
    echo '</div>';
    echo '</div>';
}
echo '</div>';
include 'includes/footer.inc.php';
?>