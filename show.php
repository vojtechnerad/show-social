<?php
/**
 * Skript show.php vypisuje podrobná data zvoleného seriálu skrze GETtový parametr.
 * ID seriálu je převzato ze služby TMDB.
 * TODO check bez parametru/neexistuje
 */
session_start();
require_once 'classes/TvShow.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.class.php';
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

$tvShowRating = $tvShow->getTvShowRating($tvShowData['id']);

echo '<div class="mb-2">';
echo '<span><i class="bi bi-star-half"></i> Hodnocení: </span>';
echo '<span id="rating-text">' . $tvShowRating . '</span>';
echo '</div>';

// Button area
if (isset($_SESSION['user_id'])) {
    $user = new User($_SESSION['user_id']);
    echo '<div class="btn-group" role="group" aria-label="Tlačítka filmy">';
    $isBookmarkedByUser = $user->hasUserBookmarkedTvShow($tvShowData['id']);
    if ($isBookmarkedByUser) {
        echo '<button id="changeBookmarkStatusBtn" class="btn btn-success" onclick="bookmarkTvShow(' . $tvShowData['id'] . ')"><i class="bi bi-bookmark-fill"></i> Založeno</button>';
    } else {
        echo '<button id="changeBookmarkStatusBtn" class="btn btn-secondary" onclick="bookmarkTvShow(' . $tvShowData['id'] . ')"><i class="bi bi-bookmark"></i> Založit</button>';
    }

    $isUsersFavorite = $user->hasUserFavoriteTvShow($tvShowData['id']);
    if ($isUsersFavorite) {
        echo '<button id="changeFavoriteStatusBtn" class="btn btn-warning" onclick="favoriteTvShow(' . $tvShowData['id'] . ')"><i class="bi bi-star-fill"></i> Oblíbené</button>';
    } else {
        echo '<button id="changeFavoriteStatusBtn" class="btn btn-secondary" onclick="favoriteTvShow(' . $tvShowData['id'] . ')"><i class="bi bi-star"></i> Oblíbit</button>';
    }
    // Doporučit film tlačítko
    echo '<a href="showrecommendation.php?showId=' . $tvShowData['id'] . '" class="btn btn-primary"><i class="bi bi-people-fill"></i> Doporučit kamarádovi</a>';
    echo '</div>';

    // Hodnocení
    $rating = $user->getUsersShowRating($tvShowData['id']);
    $ratingAttribute = $rating != null ? 'value="' . $rating['rating'] . '"' : '';
    echo '<div class="input-group mb-3">';
    echo '<input type="number" class="form-control" id="input-rate-show" ' . $ratingAttribute . ' placeholder="Zatím nehodnoceno" min="0" step="1" max="100">';
    echo '<span class="input-group-text">%</span>';
    echo '<button class="btn btn-warning" type="button" id="button-rate-show" onclick="rateShow(' . $tvShowData['id'] . ')"><i class="bi bi-star-half"></i> Hodnotit</button>';
    echo '</div>';
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
echo '</div>';

// Hodnocení přátel
if (isset($user)) {
    echo '<div class="row mb-5">';

    echo '<h2>Hodnocení přátel</h2>';
    $tvShowRating = $user->getTvShowRatingsOfFriends($tvShowData['id']);

    echo '<div class="row row-cols-2 justify-content-center">';
    echo '<div class="col">';
    echo '<div class="list-group">';
    if ($tvShowRating) {
        foreach ($tvShowRating as $rating) {
            echo '<a href="./user.php?id=' . $rating['friend_id'] . '" class="list-group-item list-group-item-action">';
            echo '<div class="d-flex w-100 justify-content-between">';
            echo '<p class="fw-bold">' . $rating['full_name'] . ' (@' . $rating['user_name']  . ')</p>';
            $bookmarkedTime = date_create($rating['timestamp']);
            echo '<small class="text-secondary">' . date_format($bookmarkedTime, 'd.m.Y H:i') . '</small>';
            echo '<p class="fw-bold">' . $rating['rating'] . ' %</p>';
            echo '</div>';
            echo '</a>';
        }
    } else {
        echo '<div class="list-group-item">Žádný z vašich přátel zatím seriál neohodnotil.</div>';
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';

    echo '</div>';
}

// Komentáře
if (isset($_SESSION['user_id'])) {
    echo '<h5>Přidat nový komentář</h5>';
    echo '<form class="mb-3" method="post" action="./includes/insert-comment.inc.php">';
    echo '
        <input type="hidden" id="type" name="type" value="tv_show" />
        <input type="hidden" id="medium_id" name="medium_id" value="' . $tvShowData['id'] . '" />
    ';
    echo '
        <div class="mb-3">
            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            <div id="passwordHelpBlock" class="form-text">
                Komentář může obsahovat maximálně 1000 znaků.
            </div>
        </div>
    ';
    echo '<button type="submit" class="btn btn-primary"><i class="bi bi-chat-left-text-fill"></i> Okomentovat</button>';

    echo '</form>';
}

echo '<h5>Komentáře k filmu</h5>';
$tvShowComments = $tvShow->getTvShowComments();
if ($tvShowComments) {
    if (isset($_SESSION['user_id'])) {
        $userData = $user->getUserData();
    }

    echo '<div class="list-group mb-4">';
    foreach ($tvShowComments as $comment) {
        echo '<div class="list-group-item">';
        echo '<div class="d-flex w-100 justify-content-between">';
        echo '<a href="./user.php?id=' . $comment['user_id'] . '" class="d-flex">';
        echo '<h5 class="mb-1">' . $comment['full_name'] . '</h5>';
        echo '<h6 class="mb-1">@' . $comment['user_name'] . '</h6>';
        echo '</a>';
        if (isset($_SESSION['user_id'])) {
            if ($userData['id'] === $comment['user_id'] || $userData['moderator']) {
                echo '
                    <form action="./includes/delete-comment.inc.php" method="post">
                        <input type="hidden" id="type" name="type" value="tv_show" />
                        <input type="hidden" id="medium_id" name="medium_id" value="' . $tvShowData['id'] . '" />
                        <input type="hidden" id="comment_id" name="comment_id" value="' . $comment['comment_id'] . '" />
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill"></i> Smazat</button>
                    </form>
                ';
            }
        }
        echo '</div>';
        echo '<p class="mb-1">' . htmlspecialchars($comment['comment']) . '</p>';
        echo '<small>' . $comment['timestamp'] . '</small>';        
        echo '</div>';
    }
    echo '</div>';
} else {
    echo '<div class="list-group mb-4">';
    echo '<div class="list-group-item">';
    echo 'Zatím film nikdo neokomentoval.';
    echo '</div>';
    echo '</div>';
}

echo '</div>';
?>

<script>
    async function markEpisodeAsSeen(showId, seasonNumber, episodeNumber) {
        const request = await fetch("/api/episode-change-status.php", {
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
                const bingeMeterButton = document.getElementById('binge-meter-button');
                let bingeMeterClass = '';

                if (response['newSeenStatus']) {
                    button.innerText = 'Zhlédnuto';
                    button.classList = 'btn btn-success position-absolute top-0 end-0';
                } else {
                    button.innerText = 'Zapsat';
                    button.classList = 'btn btn-secondary position-absolute top-0 end-0';
                }
                bingeMeterButton.innerText = 'Binge Meter: ' + response['newWatchtimePercentage'];


                if (response['newWatchtimePercentage'] < 80) {
                    bingeMeterClass = 'success';
                } else if (response['newWatchtimePercentage'] < 100) {
                    bingeMeterClass = 'warning';
                } else {
                    bingeMeterClass = 'danger';
                }
                bingeMeterButton.classList = 'btn btn-' + bingeMeterClass;

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

    async function bookmarkTvShow(movieId) {
        const request = await fetch("/api/show-change-bookmark.php", {
            method: "post",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                "showId": movieId,
            })
        });
        const response = await request.json();

        console.log(response);

        if (response['successfulChange']) {
            const button = document.getElementById('changeBookmarkStatusBtn');

            if (response['newSeenStatus']) {
                button.innerHTML = '<i class="bi bi-bookmark-fill"></i> Založeno';
                button.classList = 'btn btn-success';
            } else {
                button.innerHTML = '<i class="bi bi-bookmark"></i> Založit';
                button.classList = 'btn btn-secondary';
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
                text: 'Nastala chyba - seriál pravěpodobně nemá všechny potřebná data',
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

    async function favoriteTvShow(movieId) {
        const request = await fetch("/api/show-change-favorite.php", {
            method: "post",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                "showId": movieId,
            })
        });
        const response = await request.json();

        if (response['successfulChange']) {
            const button = document.getElementById('changeFavoriteStatusBtn');

            if (response['newSeenStatus']) {
                button.innerHTML = '<i class="bi bi-star-fill"></i> Oblíbené';
                button.classList = 'btn btn-warning';
            } else {
                button.innerHTML = '<i class="bi bi-star"></i> Oblíbit';
                button.classList = 'btn btn-secondary';
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
                text: 'Nastala chyba - seriál pravěpodobně nemá všechny potřebná data',
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

    async function rateShow(showId) {
        let rating = document.getElementById('input-rate-show').value;

        // Kontrola celočíslené hodnoty mezi 0 a 100 včetně
        if ((rating && Number.isInteger(rating % 1) && (rating >= 0 && rating <= 100)) || rating == "") {
            if (rating) {
                rating = +rating;
            }
            const request = await fetch("/api/rate-show.php", {
                method: "post",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    "showId": showId,
                    "rating": rating
                })
            });
            const response = await request.json();

            if (response) {
                document.getElementById('rating-text').innerText = response['newServerRating'];
            }

            Toastify({
                text: 'Změna hodnocení úspěšně uložena',
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
                text: 'Špatná hodnota hodnocení, zadejte hodnotu mezi 0 a 100!',
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
</script>
<?php
include 'includes/footer.inc.php';
?>
