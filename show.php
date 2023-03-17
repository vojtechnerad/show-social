<?php
/**
 * Page with details about selected show.
 */

require 'includes/autoloader.inc.php';
require_once 'classes/TvShow.class.php';


$tvShow = new TvShow($_GET['id']);
$tvShowData = $tvShow->getDataFromTmdb();

$title = $tvShowData['name'];
$active_page = 'shows';

include 'includes/header.inc.php';

?>
<div class="container-sm">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="shows.php">Seriály</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $tvShowData['name'] ?></li>
        </ol>
    </nav>
    <div class="row">
<?php
echo '<div class="col">';
if ($tvShowData['name']) {
    echo '<h1>' . $tvShowData['name'] . '</h1>';
}

if ($tvShowData['original_name']) {
    echo '<h3>' . $tvShowData['original_name'] . '</h3>';
}

if ($tvShowData['number_of_seasons']) {
    echo '<p>Počet sezón: ' . $tvShowData['number_of_seasons'] . '</p>';
}

if ($tvShowData['number_of_episodes']) {
    echo '<p>Počet epizod: ' . $tvShowData['number_of_episodes'] . '</p>';
}

if ($tvShowData['homepage']) {
    echo '<a href="' . $tvShowData['homepage'] . '" class="btn btn-dark" target="_blank">Domovská stránka <i class="bi bi-box-arrow-up-right"></i></a>';
}

if ($tvShowData['overview']) {
    echo '<p>' . $tvShowData['overview'] . '</p>';
}
echo '</div>';
echo '<div class="col-4">';
echo '<img src="https://image.tmdb.org/t/p/w500' . $tvShowData['poster_path'] . '" class="rounded float-start img-fluid" alt="Plakát seriálu ' . $tvShowData['name'] . '">';
echo '</div>';
echo '</div>';

// Seasons
echo '<div class="row">';
echo '<h2>Sezóny</h2>';

echo '<div class="accordion" id="accordionPanelsStayOpenExample">';
foreach ($tvShowData['seasons'] as $season) {
    $tvShowSeasonData = $tvShow->getSeasonData($season->season_number);
    // Accordion item
    echo '<div class="accordion-item">';

    // Heading of item
    echo '<h2 class="accordion-header" id="panelsStayOpen-heading' . $season->season_number . '">';
    echo '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse' . $season->season_number . '" aria-expanded="false" aria-controls="panelsStayOpen-collapse' . $season->season_number . '">';
    echo $season->name . ' &ndash; ' . $season->episode_count . ' dílů';
    echo '</button>';
    echo '</h2>';

    // Body of item
    echo '<div id="panelsStayOpen-collapse' . $season->season_number . '" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading' . $season->season_number . '">';
    echo '<div class="accordion-body">';
    echo $tvShowSeasonData['overview'];

    echo '<ul class="list-group">';

    foreach ($tvShowSeasonData['episodes'] as $episode) {
        echo '<li class="list-group-item">S' . $season->season_number . 'E' . $episode->episode_number . ' &ndash; ' . $episode->name . '</li>';
    }

    echo '</ul>';

    echo '</div>';
    echo '</div>';

    echo '</div>';
}
echo '</div>';
?>
</div>
</div>
<?php
include 'includes/footer.inc.php';
?>