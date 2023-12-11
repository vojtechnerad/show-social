<?php
/**
 * Skript users.php slouží k vytvoření stránky určené pro výpis uživatelů sociální sítě.
 * Stránka obsahuje výpis polsedních zaregistrovaných uživatelů.
 * Pokud je uživatel přihlášen, na stránce se výpis rozšíří o výpis příchozích žádostí o přátelství,
 * a o seznam přátel přihlášeného uživatele.
 */

@session_start();
require_once 'classes/dbh.class.php';
require 'classes/Users.class.php';
require_once 'classes/User.class.php';

$active_page = 'people';
$title = 'Lidé';

include 'includes/header.inc.php';
require_once 'includes/searchbars/users-search.inc.php';

$isUserLogged = isset($_SESSION['user_id']);

if ($isUserLogged) {
    $loggedUser = new User($_SESSION['user_id']);
}

echo '<div class="container-sm">';
echo '<h1>Lidé</h1>';
echo '<div class="row">';
if ($isUserLogged) {
    $incomingFriendRequests = $loggedUser->getIncomingFriendRequests();
    echo '<div class="col-md">';
    echo '<h3>Příchozí žádosti o přátelství</h3>';
    echo '<div class="list-group">';
    if ($incomingFriendRequests) {
        foreach ($incomingFriendRequests as $friendRequest) { // Výpis jednotlivých příchozích žádostí o přátelství
            if ($friendRequest['requesterId'] != $_SESSION['user_id']) {
                $userId = $friendRequest['requesterId'];
                $userFullName = $friendRequest['requester_full_name'];
                $userUserName = $friendRequest['requester_user_name'];
            } else {
                $userId = $friendRequest['adresseeId'];
                $userFullName = $friendRequest['adressee_full_name'];
                $userUserName = $friendRequest['adressee_user_name'];
            }
            // Odkaz na profil
            echo '<a href="./user.php?id=' . $userId . '" class="list-group-item list-group-item-action">' . htmlspecialchars($userFullName) . ' (@' . htmlspecialchars($userUserName) . ')</a>';
        }
    } else {
        echo '<div class="list-group-item">Nemáte žádné příchozí žádosti</div>';
    }
    echo '</div>';
}
echo '</div>';

// Generování posledních zaregistrovaných uživatelů
$users = new Users();
$lastRegisteredUsers = $users->getLastRegisteredUsers();
echo '<div class="col-md">';
echo '<h3>Nově registrovaní</h3>';
echo '<div class="list-group">';
if ($lastRegisteredUsers) {
    foreach ($lastRegisteredUsers as $user) {
        $createdAtDate = date_create($user['created_at']);
        // Odkaz na profil
        echo '<a href="./user.php?id=' . $user['id'] . '" class="list-group-item list-group-item-action">' . htmlspecialchars($user['full_name']) . ' (@' . htmlspecialchars($user['user_name']) . ') ' . date_format($createdAtDate, 'd.m.Y H:i') . '</a>';
    }
}
echo '</div>';
echo '</div>';
echo '</div>';

if ($isUserLogged) {
    echo '<div>';
    echo '<h3>Přátelé</h3>';
    echo '<div class="list-group">';
    $userFriendShips = $loggedUser->getFriendShips();
    if ($userFriendShips) {
        foreach ($userFriendShips as $friendship) { // Výpis jednotlivých přátel
            if ($friendship['requesterId'] != $_SESSION['user_id']) {
                $userId = $friendship['requesterId'];
                $userFullName = $friendship['requester_full_name'];
                $userUserName = $friendship['requester_user_name'];
            } else {
                $userId = $friendship['adresseeId'];
                $userFullName = $friendship['adressee_full_name'];
                $userUserName = $friendship['adressee_user_name'];
            }
            // Odkaz na profil
            echo '<a href="./user.php?id=' . $userId . '" class="list-group-item list-group-item-action">';
            echo $userFullName;
            echo '</a>';
        }
    } else {
        echo '<p>Nemáte přidané žádné přátele.</p>';
    }
    echo '</div>';
    echo '</div>';

}
?>

<?php
echo '</div>'; // Container
include 'includes/footer.inc.php';
