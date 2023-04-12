<?php
echo '
    <div class="container-fluid position-relative mb-3">
        <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control" id="tv-show-seach-input" placeholder="Zadej název hledaného seriálu">
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
        const tvShowSearchInput = document.getElementById("tv-show-seach-input");
        const tvShowSearchResults = document.getElementById("search-results-box");

        tvShowSearchInput.addEventListener("input", debounce(async (event) => {
            const queryString = event.target.value;

            const res = await fetch('/api/tmdb-wrapper/tv-show-search.php?queryString=' + queryString);
            const data = await res.json();
            console.log(data);

            const listGroupOld = document.getElementById("list-group");
            if (listGroupOld) {
                tvShowSearchResults.removeChild(listGroupOld);
            }

            if (data) {
                const listGroup = document.createElement("div");
                listGroup.classList.add("list-group");
                listGroup.setAttribute("id", "list-group");

                data.forEach(tvShow => {
                    console.log(tvShow);
                    const tvShowResultLink = document.createElement("a");
                    tvShowResultLink.classList.add("list-group-item", "list-group-item-action");
                    tvShowResultLink.setAttribute("href", "show.php?id=" + tvShow["id"]);

                    const tvShowResultBox = document.createElement("div");
                    tvShowResultBox.classList.add("w-100");

                    const tvShowResultTitle = document.createElement("h6");
                    tvShowResultTitle.classList.add("mb-1");
                    const releaseYear = new Date(tvShow['first_air_date']);
                    tvShowResultTitle.innerText = tvShow["name"] + ' / '+ tvShow["original_name"] + ' (' + releaseYear.getFullYear() + ')';

                    tvShowResultBox.appendChild(tvShowResultTitle);
                    tvShowResultLink.appendChild(tvShowResultBox);
                    listGroup.appendChild(tvShowResultLink);
                });
                tvShowSearchResults.appendChild(listGroup);
            }
        }));
    });
</script>
