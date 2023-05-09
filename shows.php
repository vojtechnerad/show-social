<?php
/**
 * Skript shows.php slouží pro generování stránky pro vyhledávání seriálů
 * s výpisem trendujících seriálů.
 */

require_once 'classes/TmdbSearch.class.php';

$title = 'Seriály';
$active_page = 'shows';

$tmdbSearch = new TmdbSearch();

include 'includes/header.inc.php';
require_once 'includes/searchbars/tv-show-search.inc.php';
?>
<h1>Seriály</h1>
<?php
// Výpis populárních seriálů
$popularTvShows = $tmdbSearch->getPopularTvShows();
if ($popularTvShows) {
    $popularTvShows = array_slice($popularTvShows, 0, 10); // Omezení pouze na prvních 10 nejpopulárnějších

    echo '<h2>Populární seriály</h2>';
    echo '<div class="row">';
    foreach ($popularTvShows as $popularTvShow) {
        echo '<div class="card p-0 ms-2 mb-2" style="width: 10rem;">';
        echo '<img src="https://image.tmdb.org/t/p/w500' . $popularTvShow->poster_path . '" class="card-img-top" alt="...">'; // TODO alt text
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $popularTvShow->name . '</h5>';
        $releaseDate = date_create($popularTvShow->first_air_date);
        echo '<p class="card-text"><i class="bi bi-calendar"></i> ' . date_format   ($releaseDate, 'd.m.Y') . '</p>';
        echo '</div>';
        echo '<a href="show.php?id=' . $popularTvShow->id . '" class="stretched-link""></a>';
        echo '</div>';
    }
    echo '</div>';
}
include 'includes/footer.inc.php';
?>