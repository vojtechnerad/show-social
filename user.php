<?php
/**
 * Stránka User
 *
 * Výpis profilu zvoleného uživatele skrze GETový parametr.
 * Zvolený parametr bude zkontrolován že je ve správném formátu (numerický a celočíselný)
 * a poté se zadá jako parametr pro query databáze.
 */

//require_once './includes/dbconn.inc.php';
require_once 'classes/User.class.php';
@session_start();
$userId = $_GET['id'];
$title = 'Úvod';
$active_page = 'people';

if (!is_numeric($userId)) {
    include 'includes/header.inc.php';
    echo '<h1>Chyba!</h1>';
    echo '<p>Hledaný účet neexistuje.</p>';
    include 'includes/footer.inc.php';
    exit();
}

// Pokud uživatel klikne na vlastní profil, přesune ho to na na profile.php
if ($userId == @$_SESSION['user_id']) {
    header('Location: ./profile.php');
    exit();
}

$selectedUser = new User($userId);


if (!$selectedUser) {
    include 'includes/header.inc.php';
    echo '<h1>Chyba!</h1>';
    echo '<p>Hledaný účet neexistuje.</p>';
    include 'includes/footer.inc.php';
    exit();
}

include 'includes/header.inc.php';

$selectedUserData = $selectedUser->getUserData();



echo '<h1>' . htmlspecialchars($selectedUserData['full_name']) . '</h1>';
echo '<h2>@' .htmlspecialchars($selectedUserData['user_name']) . '</h2>';

// Generování buttonu na spřátelení
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $userId) {
    // Získání stavu přátelství
    $friendlistStatement = $db->prepare('
        SELECT requesterId, adresseeId, isConfirmed, timestamp
        FROM friendslist
        WHERE (requesterId = (:requesterUser) AND adresseeId = (:targetUser))
        OR (requesterId = (:targetUser) AND adresseeId = (:requesterUser))
        LIMIT 1;
    ');
    $friendlistStatement->execute(
        array(
            ':requesterUser' => $_SESSION['user_id'],
            ':targetUser' => $userId
        )
    );
    $friendlistData = $friendlistStatement->fetch();

    echo '<form action="./includes/change-friendship-status.php" method="POST">';
    echo '<input type="hidden" name="target-user" id="target-user" value="' . $userId . '">';
    if (!$friendlistData) {
        echo '<button type="submit" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i> Přidat do přátel</button>';
    }

    if (@$friendlistData['requesterId'] == $_SESSION['user_id'] and @$friendlistData['isConfirmed'] == false) {
        echo '<button type="submit" class="btn btn-danger"><i class="bi bi-x"></i> Stáhnout požadavek o přidání</button>';
        $requestCreatedAt = date_create($friendlistData['timestamp']);
        echo '<p class="fw-light">Požadavek jste zaslali ' . date_format($requestCreatedAt, 'd.m.Y H:i') . '</p>';
    }

    if (@$friendlistData['adresseeId'] == $_SESSION['user_id'] and @$friendlistData['isConfirmed'] == false) {
        echo '<button type="submit" class="btn btn-success"><i class="bi bi-check"></i> Potvrdit přátelství</button>';
        $requestCreatedAt = date_create($friendlistData['timestamp']);
        echo '<p class="fw-light">Požadavek byl vytvořen ' . date_format($requestCreatedAt, 'd.m.Y H:i') . '</p>';
    }

    if ((@$friendlistData['requesterId'] == $_SESSION['user_id'] OR @$friendlistData['adresseeId'] == $_SESSION['user_id']) AND @$friendlistData['isConfirmed'] == true) {
        $friendsSince = date_create($friendlistData['timestamp']);
        echo '<p class="fw-light">Přátelé jste od ' . date_format($friendsSince, 'd.m.Y H:i') . '</p>';
        echo '<button type="submit" class="btn btn-danger"><i class="bi bi-person-dash-fill"></i> Odebrat z přátel</button>';
    }
    echo '</form>';
}

// Kontrola soukromého profilu a spřetelených účtů
$isBefriended = $selectedUser->isUserBefriendedWith($_SESSION['user_id']);
if (!$selectedUserData['public_profile'] AND !$isBefriended) {
    echo '<h3>Uživatel má soukromý profil.</h3>';
} else {
    echo '<h3>Lze vidět.</h3>';
}

?>

<?php
include 'includes/footer.inc.php';
?>

