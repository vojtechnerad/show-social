<?php
require_once 'classes/Movie.php';
require_once 'classes/TmdbSearch.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.class.php';


$title = 'Filmy';
$active_page = 'movie';
include 'includes/header.inc.php';
require_once 'includes/searchbars/movie-search.inc.php';

if (isset($_GET['id'])) {
    $movieId = $_GET['id'];
        if ($movieId > 0) {
            $movie = new Movie($movieId);
            $movieDetails = $movie->getDataFromTmdb();

            echo '<div class="container-sm">';
            echo '<div class="row ">';
            echo '<div class="col-8">';
            echo '<h1>' . $movieDetails->title . '</h1>';
            echo '<h2>' . $movieDetails->original_title . '</h2>';
            echo '<p>' . $movieDetails->overview . '</p>';
            $releaseDate = date_create($movieDetails->release_date);
            echo '<p><i class="bi bi-calendar-event-fill"></i> ' . date_format($releaseDate, 'd.m.Y') . '</p>';
            echo '<p><i class="bi bi-clock-fill"></i> ' . $movieDetails->runtime . ' minut</p>';

            // Buttony
            if (isset($_SESSION['user_id'])) {
                echo '<div class="btn-group" role="group" aria-label="Tlačítka filmy">';
                $user = new User($_SESSION['user_id']);

                $isSeenByUser = $user->hasUserSeenMovie($movieId);
                if ($isSeenByUser) {
                    echo '<button id="changeStatusBtn" class="btn btn-success" onclick="markMovieAsSeen(' . $movieDetails->id . ')"><i class="bi bi-eye-fill"></i> Zhlédnuto</button>';
                } else {
                    echo '<button id="changeStatusBtn" class="btn btn-secondary" onclick="markMovieAsSeen(' . $movieDetails->id . ')"><i class="bi bi-eye"></i> Zapsat</button>';
                }

                $isBookmarkedByUser = $user->hasUserBookmarkedMovie($movieId);
                if ($isBookmarkedByUser) {
                    echo '<button id="changeBookmarkStatusBtn" class="btn btn-success" onclick="bookmarkMovie(' . $movieDetails->id . ')"><i class="bi bi-bookmark-fill"></i> Založeno</button>';
                } else {
                    echo '<button id="changeBookmarkStatusBtn" class="btn btn-secondary" onclick="bookmarkMovie(' . $movieDetails->id . ')"><i class="bi bi-bookmark"></i> Založit</button>';
                }

                $isUsersFavorite = $user->hasUserFavoriteMovie($movieId);
                if ($isUsersFavorite) {
                    echo '<button id="changeFavoriteStatusBtn" class="btn btn-warning" onclick="favoriteMovie(' . $movieDetails->id . ')"><i class="bi bi-star-fill"></i> Oblíbené</button>';
                } else {
                    echo '<button id="changeFavoriteStatusBtn" class="btn btn-secondary" onclick="favoriteMovie(' . $movieDetails->id . ')"><i class="bi bi-star"></i> Oblíbit</button>';
                }
                echo '</div>';
            }

            echo '</div>';

            echo '<div class="col-4">';
            echo '<img src="https://www.themoviedb.org/t/p/w500' . $movieDetails->poster_path . '" class="rounded float-start img-fluid" alt="Plakát filmu ' . $movieDetails->title . '">';
            echo '</div>';

            echo '</div>';
            echo '</div>';
        } else {
            //TODO not int id
        }
}
?>
<script>
    async function markMovieAsSeen(movieId) {
        const request = await fetch("/api/movie-change-status.php", {
            method: "post",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                "movieId": movieId,
            })
        });
        const response = await request.json();

        if (response['successfulChange']) {
            const button = document.getElementById('changeStatusBtn');
            const bingeMeterButton = document.getElementById('binge-meter-button');
            let bingeMeterClass = '';

            if (response['newSeenStatus']) {
                button.innerHTML = '<i class="bi bi-eye-fill"></i> Zhlédnuto';
                button.classList = 'btn btn-success';
            } else {
                button.innerHTML = '<i class="bi bi-eye"></i></i> Zapsat';
                button.classList = 'btn btn-secondary';
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

    async function bookmarkMovie(movieId) {
        const request = await fetch("/api/movie-change-bookmark.php", {
            method: "post",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                "movieId": movieId,
            })
        });
        const response = await request.json();

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

    async function favoriteMovie(movieId) {
        const request = await fetch("/api/movie-change-favorite.php", {
            method: "post",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                "movieId": movieId,
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
</script>
<?php
    include 'includes/footer.inc.php';
?>