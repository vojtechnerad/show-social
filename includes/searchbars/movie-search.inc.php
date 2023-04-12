<?php
echo '
    <div class="container-fluid position-relative mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control" id="movie-seach-input" placeholder="Zadej název hledaného filmu">
            <div class="position-absolute" id="search-results-box">
                <div class="list-group" id="list-group">
                </div>
            </div>
        </div>
    </div>
';
?>

<script>
    /*
     Funkce zajišťující prodlevu mezi zadáváním uživatele a vyhledáváním seriálu.
     Při každém stisknutí tlačítka se doba resetuje, a tak se snižuje počet poslaných requestů.
     */

    function debounce(func, timeout = 300){
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => { func.apply(this, args); }, timeout);
        };
    }

    window.addEventListener("DOMContentLoaded", () => {
        const movieSearchInput = document.getElementById("movie-seach-input");
        const movieSearchResults = document.getElementById("search-results-box");

        movieSearchInput.addEventListener("input", debounce(async (event) => {
            const queryString = event.target.value;

            const res = await fetch('/api/tmdb-wrapper/movie-search.php?queryString=' + queryString);
            const data = await res.json();
            console.log(data);

            const listGroupOld = document.getElementById("list-group");
            if (listGroupOld) {
                movieSearchResults.removeChild(listGroupOld);
            }

            if (data) {
                const listGroup = document.createElement("div");
                listGroup.classList.add("list-group");
                listGroup.setAttribute("id", "list-group");

                data.forEach(movie => {
                    const movieResultLink = document.createElement("a");
                    movieResultLink.classList.add("list-group-item", "list-group-item-action");
                    movieResultLink.setAttribute("href", "movie.php?id=" + movie["id"]);

                    const movieResultBox = document.createElement("div");
                    movieResultBox.classList.add("w-100");

                    const movieResultTitle = document.createElement("h6");
                    movieResultTitle.classList.add("mb-1");
                    const releaseYear = new Date(movie['release_date']);
                    movieResultTitle.innerText = movie["title"] + ' / '+ movie["original_title"] + ' (' + releaseYear.getFullYear() + ')';

                    movieResultBox.appendChild(movieResultTitle);
                    movieResultLink.appendChild(movieResultBox);
                    listGroup.appendChild(movieResultLink);
                });
                movieSearchResults.appendChild(listGroup);
            }
        }));
    });
</script>
