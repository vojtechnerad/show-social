<?php
    require 'includes/autoloader.inc.php';
    require_once 'classes/Movie.php';
    $title = 'Filmy';
    $active_page = 'movie';
    include 'includes/header.inc.php';
?>
    <div class="row justify-content-start">
        <div class="col-1">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" id="breadcrumb-list">
                    <li class="breadcrumb-item active" aria-current="page">Filmy</li>
                </ol>
            </nav>
        </div>
        <div class="col">
            <div class="container-sm">
                <form action="#">
                    <div class="mb-3">
                        <label for="movie-search" class="form-label">Jméno filmu</label>
                        <input type="text" class="form-control" id="movie-search" aria-describedby="emailHelp">
                    </div>
                    <div class="col-12">
                        <div class="list-group" id="show-list"></div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-1">
        </div>
    </div>
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
                        echo '<button id="changeStatusBtn">Zapsat</button>';
                        echo '<button id="" class="btn btn-secondary">Bookmark</button>';
                        echo '<button class="btn btn-outline-warning"><i class="bi bi-star"></i> Oblíbené</button>';
                    }
                    echo '<pre>';
                    var_dump($movieDetails);
                    echo '</pre>';

                } else {
                    //TODO not int id
                }
            }
        ?>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const linkQuery = 'https://api.themoviedb.org/3/movie/1895?api_key=24d519ba38eaacef95f5c46bc71f2996&language=cs';

        let nameInputBox = document.getElementById("movie-search");
        nameInputBox.addEventListener("keyup", async () => {
            const resultDiv = document.getElementById('show-list');

            while (resultDiv.firstChild) {
                resultDiv.removeChild(resultDiv.lastChild);
            }

            queryString = nameInputBox.value;
            const res = await fetch('https://api.themoviedb.org/3/search/movie?api_key=24d519ba38eaacef95f5c46bc71f2996&language=cs&query=' + queryString + '&page=1&include_adult=false');
            let data = await res.json();
            data = data['results'];
            data.forEach(movie => {
                const movieResultLink = document.createElement("a");
                movieResultLink.innerText = movie['original_title'];
                console.log(movie['original_title'])
                movieResultLink.setAttribute('class', 'list-group-item list-group-item-action border-1 dropdown-item');
                movieResultLink.setAttribute('href', 'movie.php?id=' + movie['id']);
                resultDiv.append(movieResultLink);

            });

        });
    });

    <?php
        if (isset($_GET['id'])) {
            echo '
            const changeStatusBtn = document.getElementById("changeStatusBtn");
            changeStatusBtn.addEventListener("click", async () => {
                let request = await fetch("http://localhost/api/movie-change-status.php?movie_id=' . $_GET['id'] . '", {
                    method: "PUT"
                });
                let response = await request.json();
                console.log(response);
                if (response["success"] == 1) {
                    if (response["newStatus"] == "seen") {
                        changeStatusBtn.setAttribute("class", "btn btn-success");
                    } else {
                        changeStatusBtn.setAttribute("class", "btn btn-secondary");
                    }
                } else if (response["success"] == 0) {
                    // TODO dodělat error
                }
            });

            async function getStatus() {
                let request = await fetch("http://localhost/api/movie-get-status.php?movie_id=' . $_GET['id'] . '");
                let response = await request.json();
                if (response["status"] == "seen") {
                    changeStatusBtn.setAttribute("class", "btn btn-success");
                } else {
                    changeStatusBtn.setAttribute("class", "btn btn-secondary");
                }
            };
            getStatus();
            ';
        }
    ?>
    </script>

<?php
    include 'includes/footer.inc.php';
?>