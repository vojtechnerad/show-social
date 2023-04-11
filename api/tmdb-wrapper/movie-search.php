<?php
/**
 * Wrapper script pro vyhledávání filmů na TMDB API.
 *
 * Outputs movies matching query in JSON format, limited to 10 items.
 */
require_once '../../classes/TmdbSearch.class.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == 'GET') {
    $queryString = $_GET['queryString'];

    $tvShowSearch = new TmdbSearch();
    $searchResults = $tvShowSearch->searchMovies($queryString);
    $searchResults = $searchResults->results;

    if (count((array) $searchResults) > 10) {
        $searchResults = array_slice((array) $searchResults, 0, 10);
    };

    // Output of results in JSON format
    header("Content-Type: application/json");
    echo json_encode($searchResults);
}