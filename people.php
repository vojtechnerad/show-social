<?php
//require 'includes/autoloader.inc.php';
require 'classes/dbh.class.php';
require 'classes/Users.class.php';

session_start();
$active_page = 'people';
$title = 'Lidé';
include 'includes/header.inc.php';

$users = new Users();
$allUsers = $users->getAllUsers();

foreach ($allUsers as $user) {
    echo '<a href="user.php?id='. $user['id'] .'">';
    echo $user['first_name'] . ' ' . $user['last_name'];
    echo '</a>';
}

    $friendlistStatement = $db->prepare('
            SELECT friendslist.requesterId, friendslist.adresseeId, friendslist.isConfirmed, concat(u1.first_name, " ", u1.last_name) as requester_full_name, concat(u2.first_name, " ", u2.last_name) as adressee_full_name
            FROM friendslist
            LEFT JOIN users u1
            ON friendslist.requesterId = u1.id
            LEFT JOIN users u2
            ON friendslist.adresseeId = u2.id
            WHERE (requesterId = (:current_user_id) AND isConfirmed = true)
            OR (adresseeId = (:current_user_id) AND isConfirmed = true);
        ');
    $friendlistStatement->execute([
        ':current_user_id' => $_SESSION['user_id']
    ]);
    $friendlistData = $friendlistStatement->fetchAll();

    echo '<h1>Lidé</h1>';
    echo '<h3>Přátelé</h3>';
    foreach ($friendlistData as $friendship) {
        if ($friendship['requesterId'] != $_SESSION['user_id']) {
            echo '<a href="./user.php?id=' . $friendship['requesterId'] . '">' . $friendship['requester_full_name'] . '</a>';
        } else {
            echo '<a href="./user.php?id=' . $friendship['adresseeId'] . '">' . $friendship['adressee_full_name'] . '</a>';
        }
    }

    $incomingFriendRequestsStatement = $db->prepare('
        SELECT friendslist.requesterId, friendslist.adresseeId, friendslist.isConfirmed, concat(u1.first_name, " ", u1.last_name) as requester_full_name, concat(u2.first_name, " ", u2.last_name) as adressee_full_name
        FROM friendslist
        LEFT JOIN users u1
        ON friendslist.requesterId = u1.id
        LEFT JOIN users u2
        ON friendslist.adresseeId = u2.id
        WHERE (adresseeId = (:current_user_id) AND isConfirmed = false);
    ');
    $incomingFriendRequestsStatement->execute([
        ':current_user_id' => $_SESSION['user_id']
    ]);
    $incomingFriendRequestsData = $incomingFriendRequestsStatement->fetchAll();
    if ($incomingFriendRequestsData) {
        echo '<h3>Příchozí žádosti o přátelství</h3>';

        foreach ($incomingFriendRequestsData as $friendRequest) {
            if ($friendRequest['requesterId'] != $_SESSION['user_id']) {
                echo '<div><a href="./user.php?id=' . $friendRequest['requesterId'] . '">' . $friendRequest['requester_full_name'] . '</a></div>';
            } else {
                echo '<div><a href="./user.php?id=' . $friendRequest['adresseeId'] . '">' . $friendRequest['adressee_full_name'] . '</a></div>';
            }
        }
    }
?>

<?php
include 'includes/footer.inc.php';
