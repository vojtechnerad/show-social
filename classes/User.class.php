<?php
require_once 'classes/dbh.class.php';
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
            SELECT movie_id
            FROM seen_movies
            WHERE user_id = (:user_id)
        ';
        $statement = $this->connect()->prepare($sql);
        $statement->execute([
            ':user_id' => $this->id
        ]);
        return $statement->fetchAll();
    }

    function getLastSeenMovies() {
        $sql = '
            SELECT movie_id
            FROM seen_movies
            WHERE user_id = (:user_id)
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
            WHERE (adresseeId = (:current_user_id) AND isConfirmed = false)
            LIMIT 6;
        ';
        $statement = $this->connect()->prepare($sql);
        $statement->execute([
            ":current_user_id" => $this->id
        ]);
        return $statement->fetchAll();
    }

    function getId() {
        return $this->id;
    }
}