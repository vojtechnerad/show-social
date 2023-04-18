<?php
require_once 'TmdbApi.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/dbh.class.php';
class Movie extends TmdbApi {
    private $movieId;

    function __construct($movieId) {
        $this->movieId = $movieId;
    }

    /**
     * Returns details about movie based on provided ID.
     *
     * @return array
     */
    function getDataFromTmdb() {
        $url = $this->base_url . 'movie/' . $this->movieId . '?' . $this->api_key . '&language=cs';
        $json_data = file_get_contents($url);
        $response_data = json_decode($json_data);
        return $response_data;
    }
}