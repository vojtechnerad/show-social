<?php
/**
 * Script user.php pro tvorbu uživatelského profilu.
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


if (!$selectedUser->getId()) {
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
if (isset($_SESSION['user_id'])) {
    $isBefriended = $selectedUser->isUserBefriendedWith($_SESSION['user_id']);
} else {
    $isBefriended = false;
}


if (!$selectedUserData['public_profile'] AND !$isBefriended) {
    echo '<h3>Uživatel má soukromý profil.</h3>';
} else {
    // Odkaz na výpis filmů a seriálů zhlédnuté přihlášeným uživatelem i zobrazovaným uživatelem
    if (isset($_SESSION['user_id'])) {
        echo '<a href="common.php?targetUser=' . $userId . '" class="btn btn-primary"><i class="bi bi-people-fill"></i> Zobrazit společné zhlédnuté</a>';
    }

    // Výpis filmů
    echo '<h3>Poslední zlhédnuté filmy</h3>';
    $lastSeenMovies = $selectedUser->getLastSeenMovies();
    if ($lastSeenMovies) {
        echo '<div class="row">';
        foreach ($lastSeenMovies as $seenMovie) {
            echo '<div class="card p-0 ms-2 mb-2" style="width: 10rem;">';
            echo '<img src="https://image.tmdb.org/t/p/w500' . $seenMovie['poster_path'] . '" class="card-img-top" alt="...">'; // TODO alt text
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $seenMovie['title'] . '</h5>';

            echo '<a href="movie.php?id=' . $seenMovie['movie_id'] . '" class="stretched-link"></a>';
            $seenTime = date_create($seenMovie['seen_time']);
            echo '</div>';
            echo '<div class="card-footer text-body-secondary">';
            echo date_format($seenTime, 'd.m.Y H:i');
            echo '</div>';
            echo '</div>';
        }
        echo '<a href="seenmovies.php?user_id=' . $userId .'" class="btn btn-light btn-lg my-3">Výpis všech zhlédnutých filmů <i class="bi bi-arrow-right"></i></a>';
        echo '</div>';
    } else {
        echo '<p>Uživatel zatím nemá žádné zhlédnuté filmy.</p>';
    }

    // Výpis seriálů
    echo '<h3>Poslední zlhédnuté seriály</h3>';
    $lastSeenEpisodes = $selectedUser->getLastSeenEpisodes();
    if ($lastSeenEpisodes) {
        echo '<div class="row">';
        foreach ($lastSeenEpisodes as $seenEpisode) {
            // Tvorba karty epizody
            echo '<div class="card p-0 ms-2 mb-2" style="width: 10rem;">';
            echo '<img src="https://image.tmdb.org/t/p/w500' . $seenEpisode['poster_path'] . '" class="card-img-top" alt="...">'; // TODO alt text
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $seenEpisode['show_name'] . '</h5>';
            echo '<h6 class="card-title">' . $seenEpisode['episode_name'] . '</h6>';
            $episodeCode = 'S' . $seenEpisode['season_number'] . 'E' . $seenEpisode['episode_number'];
            echo '<p class="card-text">' . $episodeCode . '</p>';
            echo '<a href="show.php?id=' . $seenEpisode['show_id'] . '" class="stretched-link""></a>';
            $seenTime = date_create($seenEpisode['seen_time']);
            echo '</div>';
            echo '<div class="card-footer text-body-secon dary">';
            echo date_format($seenTime, 'd.m.Y H:i');
            echo '</div>';
            echo '</div>';
        }
        echo '<a href="seenepisodes.php?user_id=' . $userId .'" class="btn btn-light btn-lg my-3">Výpis všech zhlédnutých epizod <i class="bi bi-arrow-right"></i></a>';
        echo '</div>';
    } else {
        echo '<p>Uživatel zatím nemá žádné zhlédnuté epizody.</p>';
    }
}

?>

<?php
include 'includes/footer.inc.php';
?>

