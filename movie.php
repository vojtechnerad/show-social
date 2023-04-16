<?php
    require_once 'classes/Movie.php';
    require_once 'classes/TmdbSearch.class.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.class.php';


    $title = 'Filmy';
    $active_page = 'movie';
    include 'includes/header.inc.php';
    require_once 'includes/searchbars/movie-search.inc.php';
?>
    <div id="results-container">
        <?php
            if (isset($_GET['id'])) {
                $movieId = $_GET['id'];
                if ($movieId > 0) {
                    $movie = new Movie($movieId);
                    $movieDetails = $movie->getDataFromTmdb();

                    echo '<h1>' . $movieDetails->title . '</h1>';
                    echo '<h2>' . $movieDetails->original_title . '</h2>';
                    echo '<img src="https://www.themoviedb.org/t/p/w500' . $movieDetails->poster_path . '" alt="Plakát filmu ' . $movieDetails->title . '">';
                    echo '<p>' . $movieDetails->overview . '</p>';
                    echo '<p><i class="bi bi-clock-fill"></i>' . $movieDetails->runtime . ' minut</p>';
                    if (isset($_SESSION['user_id'])) {
                        $user = new User($_SESSION['user_id']);
                        $isSeenByUser = $user->hasUserSeenMovie($movieId);
                        $buttonClass = '';
                        if ($isSeenByUser) {
                            echo '<button id="changeStatusBtn" class="btn btn-success" onclick="markMovieAsSeen(' . $movieDetails->id . ')">Zhlédnuto</button>';
                        } else {
                            echo '<button id="changeStatusBtn" class="btn btn-secondary" onclick="markMovieAsSeen(' . $movieDetails->id . ')">Zapsat</button>';
                        }

                    }
                } else {
                    //TODO not int id
                }
            }
        ?>
    </div>
<script>
    async function markMovieAsSeen(movieId) {
        const request = await fetch("http://localhost/api/movie-change-status.php", {
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
                button.innerText = 'Zhlédnuto';
                button.classList = 'btn btn-success';
            } else {
                button.innerText = 'Zapsat';
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
</script>
<?php
    include 'includes/footer.inc.php';
?>