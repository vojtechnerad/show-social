<?php
/**
 * Page for searching TV shows.
 * Shows page contains search bar.
 * xd
 */

require 'includes/autoloader.inc.php';

$title = 'Seriály';
$active_page = 'shows';

include 'includes/header.inc.php';
?>
<div class="container-sm">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Seriály</li>
        </ol>
    </nav>
    <form action="#">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="show-search-box">
            <label for="show-search-box" class="form-label">Jméno seriálu</label>
        </div>
        <div class="col-12 position-relative">
            <div class="list-group" id="result-list"></div>
        </div>
    </form>
</div>

<script>
    // Script is being executed after DOM is completely loaded
    document.addEventListener('DOMContentLoaded', () => {

        // Set input box responsive
        const showSearchBox = document.getElementById('show-search-box');
        showSearchBox.addEventListener('keyup', async () => {
            const resultList = document.getElementById('result-list');
            const queryString = showSearchBox.value;

            while (resultList.firstChild) {
                resultList.removeChild(resultList.lastChild);
            }

            // Fetching data from TMDB API wrapper
            const res = await fetch('/api/tmdb-wrapper/tv-show-search.php?queryString=' + queryString);
            const data = await res.json();

            const tvShowsResultsWrapper = document.createElement('div');

            data.forEach(tvShow => {
                console.log(tvShow);
                const tvShowResultLink = document.createElement('a');
                tvShowResultLink.innerText = tvShow['name'];
                tvShowResultLink.setAttribute('class', 'list-group-item list-group-item-action border-1 dropdown-item');
                tvShowResultLink.setAttribute('href', 'show.php?id=' + tvShow['id']);
                tvShowsResultsWrapper.append(tvShowResultLink);
            });
            resultList.append(tvShowsResultsWrapper);


        });
    });
</script>
<?php
include 'includes/footer.inc.php';
?>