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

include 'includes/footer.inc.php';
?>