<?php
require_once 'TmdbApi.php';

class TvShow extends TmdbApi {
    private $tvShowId;

    function __construct($tvShowId) {
        $this->tvShowId = $tvShowId;
    }

    /**
     * Returns details about movie based on provided ID.
     *
     * @return array TV show data from TMDB API.
     */
    function getDataFromTmdb() {
        $url = $this->base_url . 'tv/' . $this->tvShowId . '?' . $this->api_key . '&language=cs';
        $json_data = file_get_contents($url);
        $response_data = json_decode($json_data);
        return (array) $response_data;
    }

    /**
     * Return details about single season and its episodes.
     *
     * @param $seasonNumber number of desired season
     * @return array season data
     */
    public function getSeasonData($seasonNumber) {
        $url = $this->base_url . 'tv/' . $this->tvShowId . '/season/' . $seasonNumber .'?' . $this->api_key . '&language=cs';
        $json_data = file_get_contents($url);
        $response_data = json_decode($json_data);
        return (array) $response_data;
    }

    public function getEpisodeData($seasonNumber, $episodeNumber) {
        $url = "{$this->base_url}/tv/{$this->tvShowId}/season/{$seasonNumber}/episode/{$episodeNumber}?{$this->api_key}&language=cs";
        $json_data = file_get_contents($url);
        $response_data = json_decode($json_data);
        return (array) $response_data;
    }

    public function getTvShowRating($tvShowId) {
        $tvShowRatingStatement = $this->connect()->prepare('
            SELECT AVG(rating) as rating
            FROM show_ratings
            WHERE show_id = (:show_id);
        ');

        $tvShowRatingStatement->execute([
            'show_id' => $tvShowId
        ]);

        $tvShowRating = $tvShowRatingStatement->fetch();

        if ($tvShowRating['rating']) {
            return round($tvShowRating['rating'], 1) . ' %';
        } else {
            return "Nehodnoceno";
        }
    }
}