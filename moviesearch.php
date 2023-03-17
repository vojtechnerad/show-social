<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/bootstrap.min.css">
    <title>Show Social</title>
</head>

<body>
    <?php
        include 'includes/navbar.inc.php';
    ?>

    <section>
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <img src="assets/images/poster-placeholder.jpg" class="img-fluid rounded" id="poster">
                    </div>
                    <div class="col">
                        <h1 class="placeholder-glow">
                            <span class="placeholder col-6"></span>
                        </h1>

                        <h3 class="placeholder-glow" id="original-title">
                            <span class="placeholder col-6"></span>
                        </h3>

                        <p id="genres"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="scripts/jquery-3.6.1.min.js"></script>
    <script>
        $(document).ready(function () {
            const linkQuery = 'https://api.themoviedb.org/3/movie/1895?api_key=24d519ba38eaacef95f5c46bc71f2996&language=cs';
            const pictureLink = 'https://www.themoviedb.org/t/p/w500';
            const movieId = '1895';

            async function fetchMovieData(movieId) {
                //const res = await fetch('https://api.themoviedb.org/3/movie/1895?api_key=24d519ba38eaacef95f5c46bc71f2996&language=cs');
                let data = await res.json();

                console.log(data);

                // Změna plakátu
                $('#poster').attr('src', pictureLink + data['poster_path']);

                // Změna hlavního nadpisu
                $('h1').empty();
                $('h1').removeAttr('class');
                $('h1').text(data['title']);

                // Změna podnadpisu (původní název)
                const originalTitle = $('#original-title');
                originalTitle.empty();
                originalTitle.removeAttr('class');
                originalTitle.text(data['original_title']);

                const genres = $('#genres');
                let genreList = '';
                data['genres'].forEach(genre => {
                    genreList = genreList += genre['name'] + ' ';
                })
                genres.text(genreList);
            }

            fetchMovieData('1895');


            $("#movieSearch").keyup(function () {
                $('#show-list').empty(); // Smaže původní výsledky vyhledávání

                let searchText = $(this).val();
                if (searchText != '') {
                    $.ajax({
                        type: 'GET',
                        url: 'https://api.themoviedb.org/3/search/movie?api_key=24d519ba38eaacef95f5c46bc71f2996&language=cs&query=' + searchText + '&page=1&include_adult=false',
                        success: function (data) {
                            data = data['results'];

                            data.forEach(movie => {
                                let movieTitle = movie['original_title'];
                                let movieResultLink = $('<a>' + movieTitle + '</a>');
                                movieResultLink.attr('class', 'list-group-item list-group-item-action border-1'); // Bootstrap stylování výsledku
                                movieResultLink.attr('href', '#');
                                $('#show-list').append(movieResultLink);
                            });

                            /*
                            console.log(data['results']);
                            data['results'].forEach(element => {
                            
                            });*/
                        },
                        error: function () {
                            console.log('API error');
                        }
                    });
                }
            })

        })
    </script>
</body>

</html>