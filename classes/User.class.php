<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/dbh.class.php';
class User extends Dbh {
    private $id;

    function __construct($userId) {
        $this->id = $userId;
    }

    function getUserData() {
        $sql = '
            SELECT
                id,
                concat(first_name, " ", last_name) as full_name,
                user_name,
                public_profile
            FROM users
            WHERE id = (:user_id)
            LIMIT 1;
        ';
        $statement = $this->connect()->prepare($sql);
        $statement->execute([
            ':user_id' => $this->id
        ]);
        return $statement->fetch();
    }

    function getFullUserData() {
        $sql = '
            SELECT *
            FROM users
            WHERE id = (:user_id)
            LIMIT 1;
        ';
        $statement = $this->connect()->prepare($sql);
        $statement->execute([
            ':user_id' => $this->id
        ]);
        return $statement->fetch();
    }

    function isUserBefriendedWith($askingUser) {
        $sql = '
            SELECT requesterId, adresseeId, isConfirmed, timestamp
            FROM friendslist
            WHERE (requesterId = (:requesterUser) AND adresseeId = (:targetUser)) AND isConfirmed = true
            OR (requesterId = (:targetUser) AND adresseeId = (:requesterUser)) AND isConfirmed = true
            LIMIT 1;
        ';
        $statement = $this->connect()->prepare($sql);
        $statement->execute([
            ':requesterUser' => $askingUser,
            ':targetUser' => $this->id
        ]);
        return $statement->fetch();
    }

    function getSeenMovies() {
        $sql = '
            SELECT seen_movies.user_id as user_id,
                   seen_movies.movie_id as movie_id,
                   seen_movies.timestamp as seen_time,
                   movies.title as title,
                   movies.original_title as original_title,
                   movies.runtime as runtime,
                   movies.poster_path as poster_path
            FROM seen_movies
            LEFT JOIN movies
            ON seen_movies.movie_id = movies.movie_id
            WHERE user_id = (:user_id)
            ORDER BY seen_time DESC;
        ';
        $statement = $this->connect()->prepare($sql);
        $statement->execute([
            ':user_id' => $this->id
        ]);
        return $statement->fetchAll();
    }

    function getLastSeenMovies() {
        $sql = '
            SELECT seen_movies.user_id as user_id, seen_movies.movie_id as movie_id, seen_movies.timestamp as seen_time, movies.title as title, movies.poster_path as poster_path
            FROM seen_movies
            LEFT JOIN movies
            ON seen_movies.movie_id = movies.movie_id
            WHERE user_id = (:user_id)
            ORDER BY seen_time DESC
            LIMIT 10;
        ';
        $statement = $this->connect()->prepare($sql);
        $statement->execute([
            ':user_id' => $this->id
        ]);
        return $statement->fetchAll();
    }

    function getSeenEpisodes() {
        $sql = '
            SELECT tv_shows.id as show_id,
            tv_shows.name as show_name,
            tv_shows.poster_path as poster_path,
            tv_show_episodes.name as episode_name,
            seen_episodes.timestamp as seen_time,
            tv_show_episodes.season_number as season_number,
            tv_show_episodes.episode_number as episode_number,
            tv_show_episodes.runtime as runtime
            FROM seen_episodes
            LEFT JOIN tv_show_episodes
            ON seen_episodes.id = tv_show_episodes.id
            LEFT JOIN tv_shows
            ON tv_show_episodes.show_id = tv_shows.id
            WHERE user_id = (:user_id)
            ORDER BY seen_time DESC;
        ';
        $statement = $this->connect()->prepare($sql);
        $statement->execute([
            ':user_id' => $this->id
        ]);
        return $statement->fetchAll();
    }

    function getLastSeenEpisodes() {
        $sql = '
            SELECT tv_shows.id as show_id,
            tv_shows.name as show_name,
            tv_shows.poster_path as poster_path,
            tv_show_episodes.name as episode_name,
            seen_episodes.timestamp as seen_time,
            tv_show_episodes.season_number as season_number,
            tv_show_episodes.episode_number as episode_number
            FROM seen_episodes
            LEFT JOIN tv_show_episodes
            ON seen_episodes.id = tv_show_episodes.id
            LEFT JOIN tv_shows
            ON tv_show_episodes.show_id = tv_shows.id
            WHERE user_id = (:user_id)
            ORDER BY seen_time DESC
            LIMIT 10;
        ';
        $statement = $this->connect()->prepare($sql);
        $statement->execute([
            ':user_id' => $this->id
        ]);
        return $statement->fetchAll();
    }

    function getFriendShips() {
        $sql = '
            SELECT
                friendslist.requesterId,
                friendslist.adresseeId,
                friendslist.isConfirmed,
                concat(u1.first_name, " ", u1.last_name) as requester_full_name,
                concat(u2.first_name, " ", u2.last_name) as adressee_full_name,
                u1.user_name as requester_user_name,
                u2.user_name as adressee_user_name
            FROM friendslist
            LEFT JOIN users u1
            ON friendslist.requesterId = u1.id
            LEFT JOIN users u2
            ON friendslist.adresseeId = u2.id
            WHERE (requesterId = (:current_user_id) AND isConfirmed = true)
            OR (adresseeId = (:current_user_id) AND isConfirmed = true);
        ';
        $statement = $this->connect()->prepare($sql);
        $statement->execute([
            ":current_user_id" => $this->id
        ]);
        return $statement->fetchAll();
    }

    function getFriendslist() {
        $friendslistStatement = $this->connect()->prepare('
            SELECT
                friend_id,
                CONCAT(users.first_name, " " , users.last_name) as full_name,
                users.user_name as user_name
            FROM (
                SELECT adresseeId as friend_id
                FROM friendslist
                WHERE isConfirmed = 1 AND requesterId = (:user_id)
                UNION
                SELECT requesterId as friend_id
                FROM friendslist
                WHERE isConfirmed = 1 AND adresseeId = (:user_id)
            ) friends
            LEFT JOIN users
            ON friends.friend_id = users.id;
        ');

        $friendslistStatement->execute([
            ':user_id' => $_SESSION['user_id']
        ]);

        $friendslist = $friendslistStatement->fetchAll();

        return $friendslist;
    }

    function getMovieRatingsOfFriends($movieId) {
        $ratingsStatement = $this->connect()->prepare('
            SELECT
                friend_id,
                CONCAT(users.first_name, " " , users.last_name) as full_name,
                users.user_name as user_name,
                movie_ratings.rating as rating,
                movie_ratings.timestamp as timestamp
            FROM (
                SELECT adresseeId as friend_id
                FROM friendslist
                WHERE isConfirmed = 1 AND requesterId = (:user_id)
                UNION
                SELECT requesterId as friend_id
                FROM friendslist
                WHERE isConfirmed = 1 AND adresseeId = (:user_id)
            ) friends
            LEFT JOIN users
            ON friends.friend_id = users.id
            INNER JOIN movie_ratings
            ON friends.friend_id = movie_ratings.user_id
            WHERE movie_ratings.movie_id = (:movie_id)
            ORDER BY movie_ratings.timestamp DESC;
        ');

        $ratingsStatement->execute([
            ':user_id' => $_SESSION['user_id'],
            ':movie_id' => $movieId
        ]);

        $ratings = $ratingsStatement->fetchAll();

        return $ratings;
    }

    function getTvShowRatingsOfFriends($tvShowId) {
        $ratingsStatement = $this->connect()->prepare('
            SELECT
                friend_id,
                CONCAT(users.first_name, " " , users.last_name) as full_name,
                users.user_name as user_name,
                show_ratings.rating as rating,
                show_ratings.timestamp as timestamp
            FROM (
                SELECT adresseeId as friend_id
                FROM friendslist
                WHERE isConfirmed = 1 AND requesterId = (:user_id)
                UNION
                SELECT requesterId as friend_id
                FROM friendslist
                WHERE isConfirmed = 1 AND adresseeId = (:user_id)
            ) friends
            LEFT JOIN users
            ON friends.friend_id = users.id
            INNER JOIN show_ratings
            ON friends.friend_id = show_ratings.user_id
            WHERE show_ratings.show_id = (:show_id)
            ORDER BY show_ratings.timestamp DESC;
        ');

        $ratingsStatement->execute([
            ':user_id' => $_SESSION['user_id'],
            ':show_id' => $tvShowId
        ]);

        $ratings = $ratingsStatement->fetchAll();

        return $ratings;
    }

    function getIncomingFriendRequests() {
        $sql = '
            SELECT
                friendslist.requesterId,
                friendslist.adresseeId,
                friendslist.isConfirmed,
                concat(u1.first_name, " ", u1.last_name) as requester_full_name,
                concat(u2.first_name, " ", u2.last_name) as adressee_full_name,
                u1.user_name as requester_user_name,
                u2.user_name as adressee_user_name
            FROM friendslist
            LEFT JOIN users u1
            ON friendslist.requesterId = u1.id
            LEFT JOIN users u2
            ON friendslist.adresseeId = u2.id
            WHERE (adresseeId = (:current_user_id) AND isConfirmed = false);
        ';
        $statement = $this->connect()->prepare($sql);
        $statement->execute([
            ":current_user_id" => $this->id
        ]);
        return $statement->fetchAll();
    }

    function getWatchtimePerLastDay() {
        $showSql = '
            SELECT SUM(tv_show_episodes.runtime) as runtime
            FROM seen_episodes
            LEFT JOIN tv_show_episodes
            ON seen_episodes.id = tv_show_episodes.id
            WHERE seen_episodes.timestamp >= NOW() - INTERVAL 1 DAY AND user_id = (:user_id);
        ';
        $showsStatement = $this->connect()->prepare($showSql);
        $showsStatement->execute([
            ":user_id" => $this->id
        ]);
        $showsWatchtime = $showsStatement->fetch();

        $moviesSql = '
            SELECT SUM(movies.runtime) as runtime
            FROM seen_movies
            LEFT JOIN movies
            ON seen_movies.movie_id = movies.movie_id
            WHERE seen_movies.timestamp >= NOW() - INTERVAL 1 DAY AND user_id = (:user_id);
        ';
        $moviesStatement = $this->connect()->prepare($moviesSql);
        $moviesStatement->execute([
            ":user_id" => $this->id
        ]);
        $moviesWatchtime = $moviesStatement->fetch();

        $totalWatchtime = new stdClass();
        $totalWatchtime->watchtime = 0;

        if ($showsWatchtime['runtime']) {
            $totalWatchtime->watchtime = $totalWatchtime->watchtime + $showsWatchtime['runtime'];
        }

        if ($moviesWatchtime['runtime']) {
            $totalWatchtime->watchtime = $totalWatchtime->watchtime + $moviesWatchtime['runtime'];
        }

        $limitSql = '
            SELECT watch_limit
            FROM users
            WHERE id = (:user_id)
            LIMIT 1;
        ';
        $limitStatement = $this->connect()->prepare($limitSql);
        $limitStatement->execute([
            ':user_id' => $this->id
        ]);
        $watchtimeLimit = $limitStatement->fetch();

        $totalWatchtime->watchtimeLimit = $watchtimeLimit['watch_limit'];

        $totalWatchtime->watchtimePercentage = round((($totalWatchtime->watchtime/$totalWatchtime->watchtimeLimit) * 100), 1);
        return $totalWatchtime;
    }

    function hasUserSeenMovie($movieId) {
        $sql = '
            SELECT timestamp
            FROM `seen_movies`
            WHERE user_id = (:user_id) and movie_id = (:movie_id)
            LIMIT 1;
        ';
        $seenMovieStatement = $this->connect()->prepare($sql);
        $seenMovieStatement->execute([
            ':user_id' => $this->id,
            ':movie_id' => $movieId,
        ]);
        $seenMovieData = $seenMovieStatement->fetch();

        if (@$seenMovieData['timestamp']) {
            return true;
        } else {
            return false;
        }
    }

    function hasUserBookmarkedMovie($movieId) {
        $bookmarkedMovieStatement = $this->connect()->prepare('
            SELECT timestamp
            FROM bookmarked_movies
            WHERE user_id = (:user_id) and movie_id = (:movie_id)
            LIMIT 1;
        ');
        $bookmarkedMovieStatement->execute([
            ':user_id' => $this->id,
            ':movie_id' => $movieId,
        ]);

        $bookmarkedMovieData = $bookmarkedMovieStatement->fetch();

        if (@$bookmarkedMovieData['timestamp']) {
            return true;
        } else {
            return false;
        }
    }

    function hasUserBookmarkedTvShow($showId) {
        $bookmarkedShowStatement = $this->connect()->prepare('
            SELECT timestamp
            FROM bookmarked_tv_shows
            WHERE user_id = (:user_id) and show_id = (:show_id)
            LIMIT 1;
        ');
        $bookmarkedShowStatement->execute([
            ':user_id' => $this->id,
            ':show_id' => $showId,
        ]);

        $bookmarkedShowData = $bookmarkedShowStatement->fetch();

        if (@$bookmarkedShowData['timestamp']) {
            return true;
        } else {
            return false;
        }
    }

    function bookmarkedMovies() {
        $bookmarkedMoviesStatement = $this->connect()->prepare('
            SELECT movies.movie_id, movies.title, movies.original_title, movies.poster_path, bookmarked_movies.timestamp
            FROM bookmarked_movies
            LEFT JOIN movies
            ON bookmarked_movies.movie_id = movies.movie_id
            WHERE user_id = (:user_id)
            ORDER BY bookmarked_movies.timestamp DESC;
        ');

        $bookmarkedMoviesStatement->execute([
            ':user_id' => $this->id
        ]);
        $bookmarkedMoviesData = $bookmarkedMoviesStatement->fetchAll();
        return $bookmarkedMoviesData;
    }

    function bookmarkedTvShows() {
        $bookmarkedTvShowsStatement = $this->connect()->prepare('
            SELECT tv_shows.id as show_id, tv_shows.name, tv_shows.original_name, tv_shows.poster_path, bookmarked_tv_shows.timestamp
            FROM bookmarked_tv_shows
            LEFT JOIN tv_shows
            ON bookmarked_tv_shows.show_id = tv_shows.id
            WHERE user_id = (:user_id)
            ORDER BY bookmarked_tv_shows.timestamp DESC;
        ');

        $bookmarkedTvShowsStatement->execute([
            ':user_id' => $this->id
        ]);
        $bookmarkedTvShowsData = $bookmarkedTvShowsStatement->fetchAll();
        return $bookmarkedTvShowsData;
    }

    function hasUserFavoriteMovie($movieId) {
        $favoriteMovieStatement = $this->connect()->prepare('
            SELECT timestamp
            FROM favorite_movies
            WHERE user_id = (:user_id) and movie_id = (:movie_id)
            LIMIT 1;
        ');
        $favoriteMovieStatement->execute([
            ':user_id' => $this->id,
            ':movie_id' => $movieId,
        ]);

        $favoriteMovieData = $favoriteMovieStatement->fetch();

        if (@$favoriteMovieData['timestamp']) {
            return true;
        } else {
            return false;
        }
    }

    function hasUserFavoriteTvShow($showId) {
        $favoriteShowStatement = $this->connect()->prepare('
            SELECT timestamp
            FROM favorite_tv_shows
            WHERE user_id = (:user_id) and show_id = (:show_id)
            LIMIT 1;
        ');
        $favoriteShowStatement->execute([
            ':user_id' => $this->id,
            ':show_id' => $showId,
        ]);

        $favoriteShowData = $favoriteShowStatement->fetch();

        if (@$favoriteShowData['timestamp']) {
            return true;
        } else {
            return false;
        }
    }

    function favoriteMovies() {
        $favoriteMoviesStatement = $this->connect()->prepare('
            SELECT movies.movie_id, movies.title, movies.original_title, movies.poster_path, favorite_movies.timestamp
            FROM favorite_movies
            LEFT JOIN movies
            ON favorite_movies.movie_id = movies.movie_id
            WHERE user_id = (:user_id)
            ORDER BY favorite_movies.timestamp DESC;
        ');

        $favoriteMoviesStatement->execute([
            ':user_id' => $this->id
        ]);
        $favoriteMoviesData = $favoriteMoviesStatement->fetchAll();
        return $favoriteMoviesData;
    }

    function favoriteTvShows() {
        $favoriteTvShowsStatement = $this->connect()->prepare('
            SELECT tv_shows.id as show_id, tv_shows.name, tv_shows.original_name, tv_shows.poster_path, favorite_tv_shows.timestamp
            FROM favorite_tv_shows
            LEFT JOIN tv_shows
            ON favorite_tv_shows.show_id = tv_shows.id
            WHERE user_id = (:user_id)
            ORDER BY favorite_tv_shows.timestamp DESC;
        ');

        $favoriteTvShowsStatement->execute([
            ':user_id' => $this->id
        ]);
        $favoriteTvShowsData = $favoriteTvShowsStatement->fetchAll();
        return $favoriteTvShowsData;
    }

    function getId() {
        return $this->id;
    }

    function movieRating($movieId) {
        $movieRatingStatement = $this->connect()->prepare('
            SELECT rating
            FROM movie_ratings
            WHERE user_id = (:user_id) AND movie_id = (:movie_id)
            LIMIT 1;
        ');

        $movieRatingStatement->execute([
            'user_id' => $_SESSION['user_id'],
            'movie_id' => $movieId
        ]);

        $movieRating = $movieRatingStatement->fetch();
        return $movieRating;
    }

    function getUsersShowRating($showId) {
        $showRatingStatement = $this->connect()->prepare('
            SELECT rating
            FROM show_ratings
            WHERE user_id = (:user_id) AND show_id = (:show_id)
            LIMIT 1;
        ');

        $showRatingStatement->execute([
            'user_id' => $_SESSION['user_id'],
            'show_id' => $showId
        ]);

        $showRating = $showRatingStatement->fetch();
        return $showRating;
    }

    function listSeenMoviesInCommon($targetUserId) {
        $movieListStatement = $this->connect()->prepare('
            SELECT currentUser.movie_id, movies.title, movies.original_title, movies.poster_path
            FROM (
                SELECT movie_id
                FROM seen_movies
                WHERE user_id = (:current_user_id)
            ) currentUser
            JOIN (
                SELECT movie_id
                FROM seen_movies
                WHERE user_id = (:target_user_id)
            ) targetUser
            ON currentUser.movie_id = targetUser.movie_id
            LEFT JOIN movies
            ON currentUser.movie_id = movies.movie_id;
        ');

        $movieListStatement->execute([
            ':current_user_id' => $_SESSION['user_id'],
            ':target_user_id' => $targetUserId
        ]);

        $movieList = $movieListStatement->fetchAll();
        return $movieList;
    }

    function listSeenEpisodesInCommon($targetUserId) {
        $episodeListStatement = $this->connect()->prepare('
            SELECT
                tv_show_episodes.name as episode_name,
                CONCAT("S", tv_show_episodes.season_number , "E", tv_show_episodes.episode_number) as episode_code,
                tv_shows.id as show_id,
                tv_shows.name as show_name,
                tv_shows.original_name as show_original_name,
                tv_shows.poster_path as poster_path
            FROM (
                SELECT id
                FROM seen_episodes
                WHERE user_id = (:current_user_id)
            ) currentUser
            JOIN (
                SELECT id, timestamp
                FROM seen_episodes
                WHERE user_id = (:target_user_id)
            ) targetUser
            ON currentUser.id = targetUser.id
            LEFT JOIN tv_show_episodes
            ON currentUser.id = tv_show_episodes.id
            LEFT JOIN tv_shows
            ON tv_show_episodes.show_id = tv_shows.id
            ORDER BY targetUser.timestamp DESC;
        ');

        $episodeListStatement->execute([
            ':current_user_id' => $_SESSION['user_id'],
            ':target_user_id' => $targetUserId
        ]);

        $episodeList = $episodeListStatement->fetchAll();
        return $episodeList;
    }

    function recommendMovie($targetUserId, $movieId, $description) {
        $movieRecommendationStatement = $this->connect()->prepare('
            REPLACE INTO movie_recommendations (source_user_id, target_user_id, movie_id, description)
            VALUES (:source_user_id, :target_user_id, :movie_id, :description);
        ');
        $movieRecommendationStatement->execute([
            ':source_user_id' => $_SESSION['user_id'],
            ':target_user_id' => $targetUserId,
            ':movie_id' => $movieId,
            ':description' => $description,
        ]);
    }

    function recommendShow($targetUserId, $showId, $description) {
        $showRecommendationStatement = $this->connect()->prepare('
            REPLACE INTO show_recommendations (source_user_id, target_user_id, show_id, description)
            VALUES (:source_user_id, :target_user_id, :show_id, :description);
        ');
        $showRecommendationStatement->execute([
            ':source_user_id' => $_SESSION['user_id'],
            ':target_user_id' => $targetUserId,
            ':show_id' => $showId,
            ':description' => $description,
        ]);
    }

    function isMovieRecommendedToUser($targetUserId, $movieId) {
        $movieRecommendationStatement = $this->connect()->prepare('
            SELECT timestamp, description
            FROM movie_recommendations
            WHERE source_user_id = (:source_user_id)
            AND target_user_id = (:target_user_id)
            AND movie_id = (:movie_id)
            LIMIT 1;
        ');
        $movieRecommendationStatement->execute([
            ':source_user_id' => $_SESSION['user_id'],
            ':target_user_id' => $targetUserId,
            ':movie_id' => $movieId,
        ]);

        $movieRecommendation = $movieRecommendationStatement->fetch();

        return $movieRecommendation;
    }

    function isShowRecommendedToUser($targetUserId, $showId) {
        $showRecommendationStatement = $this->connect()->prepare('
            SELECT timestamp, description
            FROM show_recommendations
            WHERE source_user_id = (:source_user_id)
            AND target_user_id = (:target_user_id)
            AND show_id = (:show_id)
            LIMIT 1;
        ');
        $showRecommendationStatement->execute([
            ':source_user_id' => $_SESSION['user_id'],
            ':target_user_id' => $targetUserId,
            ':show_id' => $showId,
        ]);
        $showRecommendation = $showRecommendationStatement->fetch();
        return $showRecommendation;
    }

    function deleteMovieRecommendation($targetUserId, $movieId) {
        $movieRecommendationStatement = $this->connect()->prepare('
            DELETE FROM movie_recommendations
            WHERE source_user_id = (:source_user_id)
            AND target_user_id = (:target_user_id)
            AND movie_id = (:movie_id);
        ');
        $movieRecommendationStatement->execute([
            ':source_user_id' => $_SESSION['user_id'],
            ':target_user_id' => $targetUserId,
            ':movie_id' => $movieId,
        ]);
    }

    function deleteShowRecommendation($targetUserId, $showId) {
        $showRecommendationStatement = $this->connect()->prepare('
            DELETE FROM show_recommendations
            WHERE source_user_id = (:source_user_id)
            AND target_user_id = (:target_user_id)
            AND show_id = (:show_id);
        ');
        $showRecommendationStatement->execute([
            ':source_user_id' => $_SESSION['user_id'],
            ':target_user_id' => $targetUserId,
            ':show_id' => $showId,
        ]);
    }

    function getUsersMovieRecommendations() {
        $movieRecommendationsStatement = $this->connect()->prepare('
            SELECT
                movie_recommendations.timestamp as timestamp,
                movie_recommendations.description as description,
                movies.movie_id as movie_id,
                movies.title as title,
                movies.original_title as original_title,
                users.id as source_user_id,
                CONCAT (users.first_name, " ", users.last_name) as full_name,
                users.user_name as user_name
            FROM movie_recommendations
            LEFT JOIN movies
            ON movie_recommendations.movie_id = movies.movie_id
            LEFT JOIN users
            ON movie_recommendations.source_user_id = users.id
            WHERE movie_recommendations.target_user_id = (:user_id)
            ORDER BY movie_recommendations.timestamp DESC;
        ');
        $movieRecommendationsStatement->execute([
            ':user_id' => $_SESSION['user_id'],
        ]);

        $movieRecommendations = $movieRecommendationsStatement->fetchAll();

        return $movieRecommendations;
    }

    function getUsersShowRecommendations() {
        $showRecommendationsStatement = $this->connect()->prepare('
            SELECT
                show_recommendations.timestamp as timestamp,
                show_recommendations.description as description,
                tv_shows.id as show_id,
                tv_shows.name as name,
                tv_shows.original_name as original_name,
                users.id as source_user_id,
                CONCAT (users.first_name, " ", users.last_name) as full_name,
                users.user_name as user_name
            FROM show_recommendations
            LEFT JOIN tv_shows
            ON show_recommendations.show_id = tv_shows.id
            LEFT JOIN users
            ON show_recommendations.source_user_id = users.id
            WHERE show_recommendations.target_user_id = (:user_id)
            ORDER BY show_recommendations.timestamp DESC;
        ');
        $showRecommendationsStatement->execute([
            ':user_id' => $_SESSION['user_id'],
        ]);
        $showRecommendations = $showRecommendationsStatement->fetchAll();
        return $showRecommendations;
    }

    function updateUsersSettings($publicProfile, $watchLimit) {
        $insertChangesStatement = $this->connect()->prepare('
            UPDATE users
            SET watch_limit = (:watch_limit), public_profile = (:public_profile), created_at = created_at
            WHERE id = (:user_id)
        ');
        $insertChangesStatement->execute([
            ':watch_limit' => $watchLimit,
            ':public_profile' => $publicProfile,
            ':user_id' => $_SESSION['user_id']
        ]);
    }
}