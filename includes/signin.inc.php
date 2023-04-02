<?php
require_once 'user.inc.php';

if (!empty($_POST)) {
    // Předávání přihlašovacích údajů uživatele
    $email = $_POST['email'];
    $password = $_POST['password'];

    echo $email;
    echo $password;

    $emailQuery = $db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1;');
    $emailQuery->execute([
        'email'=>$email
    ]);
    $emailQuery = $emailQuery->fetchAll(PDO::FETCH_ASSOC);

    if ($emailQuery) {
        $emailQuery = $emailQuery[0];
        if (password_verify($password, $emailQuery['password_hash'])) {
            $_SESSION['user_id'] = $emailQuery['id'];
            $_SESSION['user_name'] = $emailQuery['user_name'];
            $_SESSION['first_name'] = $emailQuery['first_name'];
            $_SESSION['last_name'] = $emailQuery['last_name'];
            header('Location: ../profile.php');
            exit();
        }
    }

    header('Location: ../authentication.php');
    exit();

    var_dump($emailQuery);
}