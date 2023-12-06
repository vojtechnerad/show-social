<?php
require_once 'TmdbApi.php';

class TvShow extends TmdbApi {
    private $tvShowId;

    function __construct($tvShowId) {
        $this->tvShowId = $tvShowId;
    }

    /**
     * Returns details about tv show based on provided ID.
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

    public function getTvShowComments() {
        $statement = $this->connect()->prepare('
            SELECT
                tv_show_comments.comment_id,
                tv_show_comments.comment,
                tv_show_comments.timestamp,
                users.id as user_id,
                CONCAT(users.first_name, " " , users.last_name) as full_name,
                users.user_name
            FROM tv_show_comments
            LEFT JOIN users
            ON tv_show_comments.user_id = users.id
            WHERE tv_show_id = (:tv_show_id);
        ');

        $statement->execute([
            'tv_show_id' => $this->tvShowId
        ]);

        $result = $statement->fetchAll();
        return $result;
    }

    public function deleteTvShowComment($commentId) {
        $statement = $this->connect()->prepare('
            DELETE FROM tv_show_comments
            WHERE comment_id = (:comment_id);
        ');
        $statement->execute([
            ':comment_id' => $commentId
        ]);
    }

    public function getTvShowComment($commentId) {
        $statement = $this->connect()->prepare('
            SELECT *
            FROM tv_show_comments
            WHERE comment_id = (:comment_id);
        ');

        $statement->execute([
            'comment_id' => $commentId
        ]);

        $result = $statement->fetch();
        return $result;
    }

    public function insertNewComment($userId, $comment) {
        $statement = $this->connect()->prepare('
            INSERT INTO tv_show_comments (tv_show_id, user_id, comment)
            VALUES (:tv_show_id, :user_id, :comment);
        ');
        $statement->execute([
            ':tv_show_id' => $this->tvShowId,
            ':user_id' => $userId,
            ':comment' => $comment
        ]);
    }
}