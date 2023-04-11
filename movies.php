<?php
require_once 'classes/TmdbSearch.class.php';

$title = 'Filmy';
$active_page = 'movie';

include 'includes/header.inc.php';
require_once 'includes/movie-search.inc.php';

$tmdbSearch = new TmdbSearch();

echo '<h1>Filmy</h1>';

// Vyhledávání filmů

?>

<?php
// Výpis populárních filmů
$popularMovies = $tmdbSearch->getPopularMovies()->results;
if ($popularMovies) {
    $popularMovies = array_slice($popularMovies, 0, 10); // Omezení pouze na prvních 10 nejpopulárnějších

    echo '<h2>Populární filmy</h2>';
    echo '<div class="row">';
    foreach ($popularMovies as $popularMovie) {
        echo '<div class="card p-0 ms-2 mb-2" style="width: 10rem;">';
        echo '<img src="https://image.tmdb.org/t/p/w500' . $popularMovie->poster_path . '" class="card-img-top" alt="...">'; // TODO alt text
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $popularMovie->title . '</h5>';
        $releaseDate = date_create($popularMovie->release_date);
        echo '<p class="card-text"><i class="bi bi-calendar"></i> ' . date_format   ($releaseDate, 'd.m.Y') . '</p>';
        echo '</div>';
        echo '<a href="movie.php?id=' . $popularMovie->id . '" class="stretched-link""></a>';
        echo '</div>';
    }
    echo '</div>';
}


include 'includes/footer.inc.php';
?>