<?php
require_once 'TmdbApi.php';
/**
 * Class made for making queries to TMDB API.
 *
 */
class TmdbSearch extends TmdbApi {

    public function __construct() {

    }

    /**
     * @param $queryString
     * @return void
     */
    public function searchTvShows($queryString) {
        $url = $this->base_url . 'search/tv?' . $this->api_key . '&language=cs&query=' . urlencode($queryString);
        $json_data = file_get_contents($url);
        $response_data = json_decode($json_data);
        $limitedResults = $this->limitResults($response_data->results);
        return $limitedResults;
    }

    public function searchMovies($queryString) {
        $url = $this->base_url . 'search/movie?' . $this->api_key . '&language=cs&query=' . urlencode($queryString);
        $json_data = file_get_contents($url);
        $response_data = json_decode($json_data);
        $limitedResults = $this->limitResults($response_data->results);
        return $limitedResults;
    }

    public function getPopularMovies() {
        $url = $this->base_url . 'movie/popular?' . $this->api_key . '&language=cs';
        $json_data = file_get_contents($url);
        $response_data = json_decode($json_data);
        return $response_data->results;
    }

    public function getPopularTvShows() {
        $url = $this->base_url . 'tv/popular?' . $this->api_key . '&language=cs';
        $json_data = file_get_contents($url);
        $response_data = json_decode($json_data);
        return $response_data->results;
    }

    private function limitResults($results) {
        if (count((array) $results) > $this->resultItemsNumber) {
            $results = array_slice((array) $results, 0, $this->resultItemsNumber);
        }
        return $results;
    }
}