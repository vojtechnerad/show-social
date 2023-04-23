<?php
require_once 'dbh.class.php';


class Users extends Dbh {

    function __construct() {

    }

    function getAllUsers() {
        $sql = 'SELECT id, first_name, last_name FROM users';
        $statement = $this->connect()->query($sql)->fetchAll();
        return $statement;
    }

    function getLastRegisteredUsers() {
        $sql = '
            SELECT id, concat(first_name, " ", last_name) as full_name, user_name, created_at
            FROM users
            ORDER BY created_at DESC
            LIMIT 6';
        $statement = $this->connect()->query($sql)->fetchAll();
        return $statement;
    }

    function isEmailTaken($email) {
        $statement = $this->connect()->prepare('
            SELECT email
            FROM users
            WHERE email = (:email)
            LIMIT 1;
        ');

        $statement->execute([
           ':email' => $email
        ]);

        $emailStatus = $statement->fetch();

        if ($emailStatus) {
            return true;
        } else {
            return false;
        }
    }

    function isUsernameTaken($username) {
        $statement = $this->connect()->prepare('
            SELECT user_name
            FROM users
            WHERE user_name = (:user_name)
            LIMIT 1;
        ');

        $statement->execute([
            ':user_name' => $username
        ]);

        $emailStatus = $statement->fetch();

        if ($emailStatus) {
            return true;
        } else {
            return false;
        }
    }

    function signUpNewUser($username, $firstname, $lastname, $email, $password, $watchLimit, $isProfilePublic) {
        $insertStatement = $this->connect()->prepare('
            INSERT INTO users (user_name, first_name, last_name, email, password_hash, watch_limit, public_profile)
            VALUES (:user_name, :first_name, :last_name, :email, :password_hash, :watch_limit, :public_profile)
        ');

        $insertStatement->execute([
            ':user_name' => $username,
            ':first_name' => $firstname,
            ':last_name' => $lastname,
            ':email' => $email,
            ':password_hash' => password_hash($password, PASSWORD_DEFAULT),
            ':watch_limit' => $watchLimit,
            ':public_profile' => $isProfilePublic
        ]);
    }

    function getUserByEmail($email) {
        $statement = $this->connect()->prepare('
            SELECT id, user_name, first_name, last_name
            FROM users
            WHERE email = (:email)
            LIMIT 1;
        ');

        $statement->execute([
            ':email' => $email
        ]);

        $userResult = $statement->fetch();

        return $userResult;
    }
}