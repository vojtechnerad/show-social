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

    public function getMovieRating($movieId) {
        $movieRatingStatement = $this->connect()->prepare('
            SELECT AVG(rating) as rating
            FROM movie_ratings
            WHERE movie_id = (:movie_id);
        ');

        $movieRatingStatement->execute([
            'movie_id' => $movieId
        ]);

        $movieRating = $movieRatingStatement->fetch();

        if ($movieRating['rating']) {
            return round($movieRating['rating'], 1) . ' %';
        } else {
            return "Nehodnoceno";
        }
    }

    public function getMovieComments() {
        $statement = $this->connect()->prepare('
            SELECT
                movie_comments.comment_id,
                movie_comments.comment,
                movie_comments.timestamp,
                users.id as user_id,
                CONCAT(users.first_name, " " , users.last_name) as full_name,
                users.user_name
            FROM movie_comments
            LEFT JOIN users
            ON movie_comments.user_id = users.id
            WHERE movie_id = (:movie_id);
        ');

        $statement->execute([
            'movie_id' => $this->movieId
        ]);

        $result = $statement->fetchAll();
        return $result;
    }

    public function deleteMovieComment($commentId) {
        $statement = $this->connect()->prepare('
            DELETE FROM movie_comments
            WHERE comment_id = (:comment_id);
        ');
        $statement->execute([
            ':comment_id' => $commentId
        ]);
    }

    public function getMovieComment($commentId) {
        $statement = $this->connect()->prepare('
            SELECT *
            FROM movie_comments
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
            INSERT INTO movie_comments (movie_id, user_id, comment)
            VALUES (:movie_id, :user_id, :comment);
        ');
        $statement->execute([
            ':movie_id' => $this->movieId,
            ':user_id' => $userId,
            ':comment' => $comment
        ]);
    }
}