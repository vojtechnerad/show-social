<?php
/**
 * Page with details about selected show.
 */
session_start();
//require 'includes/autoloader.inc.php';
require_once 'classes/TvShow.class.php';
require_once 'includes/dbconn.inc.php';


$tvShow = new TvShow($_GET['id']);
$tvShowData = $tvShow->getDataFromTmdb();

$title = $tvShowData['name'];
$active_page = 'shows';

if (@$_SESSION['user_id']) {
    $seenStmnt = $db->prepare('
            SELECT id
            FROM seen_episodes
            WHERE user_id = (:user_id);
        ');
    $seenStmnt->bindParam(':user_id',$_SESSION['user_id']);
    $seenStmnt->execute();
    $result = $seenStmnt->fetchAll();

    $seenEpisodesArr = array();
    foreach ($result as $object) {
        array_push($seenEpisodesArr, $object['id']);
    }
}

include 'includes/header.inc.php';
require_once 'includes/searchbars/tv-show-search.inc.php';
?>
<div class="container-sm">
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

echo '<div class="accordion mb-3">';
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
        echo '<div>';
        echo '<li class="list-group-item">S' . $season->season_number . 'E' . $episode->episode_number . ' &ndash; ' . $episode->name;
        if ($_SESSION) {
            if (in_array($episode->id, $seenEpisodesArr)) {
                echo '<button class="btn btn-success position-absolute top-0 end-0" id="S' . $season->season_number . 'E' . $episode->episode_number . '" onclick="markEpisodeAsSeen(' . $tvShowData['id'] . ', ' . $season->season_number . ', ' . $episode->episode_number . ')">Zhlédnuto</button>';
            } else {
                echo '<button class="btn btn-secondary position-absolute top-0 end-0" id="S' . $season->season_number . 'E' . $episode->episode_number . '" onclick="markEpisodeAsSeen(' . $tvShowData['id'] . ', ' . $season->season_number . ', ' . $episode->episode_number . ')">Zapsat</button>';
            }
        }
        echo '</li></div>';
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

<script>
    async function markEpisodeAsSeen(showId, seasonNumber, episodeNumber) {
        const request = await fetch("http://localhost/api/episode-change-status.php", {
            method: "post",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                "showId": showId,
                "seasonNumber": seasonNumber,
                "episodeNumber": episodeNumber
            })
        });
        const response = await request.json();

        if (response) {
            if (response['successfulChange']) {
                const button = document.getElementById('S' + seasonNumber + 'E' + episodeNumber);

                if (response['newSeenStatus']) {
                    button.innerText = 'Zhlédnuto';
                    button.classList = 'btn btn-success position-absolute top-0 end-0';
                } else {
                    button.innerText = 'Zapsat';
                    button.classList = 'btn btn-secondary position-absolute top-0 end-0';
                }

                Toastify({
                    text: 'Změna úspěšně uložena',
                    duration: 1000,
                    newWindow: false,
                    gravity: "bottom",
                    position: "center",
                    style: {
                        background: "#158000"
                    }
                }).showToast();
            } else {
                Toastify({
                    text: 'Nastala chyba - epizoda pravěpodobně nemá všechny potřebná data',
                    duration: 2000,
                    newWindow: false,
                    gravity: "bottom",
                    position: "center",
                    style: {
                        background: "#80000b"
                    }
                }).showToast();
            }
        }
    }
</script>
<?php
include 'includes/footer.inc.php';
?>