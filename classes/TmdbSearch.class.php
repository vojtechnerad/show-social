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
        $url = $this->base_url . 'search/tv?' . $this->api_key . '&language=cs&query=' . $queryString;
        $json_data = file_get_contents($url);
        $response_data = json_decode($json_data);
        return $response_data;
    }
}