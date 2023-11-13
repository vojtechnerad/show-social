<?php
session_start();
require_once 'classes/User.class.php';
require_once 'classes/TvShow.class.php';
require_once 'includes/dbconn.inc.php';

$title = 'Doporučení seriálu';
$active_page = 'shows';

if (!isset($_GET['showId'])) {
    include 'includes/header.inc.php';
    echo '<h1>Chyba</h1>';
    include 'includes/footer.inc.php';
    exit();
}
$user = new User($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $showId = $_GET['showId'];
        $show = new TvShow($showId);
        $showData = $show->getDataFromTmdb();
        $insertShowDataStatement = $db->prepare('
            REPLACE INTO tv_shows (id, name, original_name, poster_path)
            VALUES (:id, :name, :original_name, :poster_path);
        ');
        $insertShowDataStatement->execute([
            ':id' => $showData['id'],
            ':name' => $showData['name'],
            ':original_name' => $showData['original_name'],
            ':poster_path' => $showData['poster_path'],
        ]);
        if (isset($_POST['save']) OR isset($_POST['update'])) {
            $user->recommendShow($_GET['targetUserId'], $_GET['showId'], $_POST['description']);
        } elseif (isset($_POST['delete'])) {
            $user->deleteShowRecommendation($_GET['targetUserId'], $_GET['showId']);
        }
        header('Location: showrecommendation.php?targetUserId=' . $_GET['targetUserId'] . '&showId=' . $_GET['showId']);
        exit();
    } catch (PDOException $PDOException) {

    }
}

$selectedShow = new TvShow($_GET['showId']);
$selectedShowData = $selectedShow->getDataFromTmdb();

include 'includes/header.inc.php';
echo '<h1>Doporučení seriálu</h1>';
echo '<div class="container-sm">';
// Výpis zvoleného filmu
echo '<div class="row">';

echo '<div class="col-8 col-md-10">';
echo '<h3>' . $selectedShowData['name'] . '</h3>';
echo '<h4 class="mb-3">' . $selectedShowData['original_name'] . '</h4>';
echo '<p class="mb-2"><i class="bi bi-calendar-event-fill"></i> ' . $selectedShowData['first_air_date'] . '</p>';
echo '<p><i class="bi bi-clock-fill"></i> ' . $selectedShowData['number_of_seasons'] .' sezón(a) / ' . $selectedShowData['number_of_episodes'] . ' epizod</p>';
echo '<p>' . $selectedShowData['overview'] . '</p>';
echo '</div>';

echo '<div class="col-4 col-md-2">';
echo '<img src="https://www.themoviedb.org/t/p/w500' . $selectedShowData['poster_path'] . '" class="rounded float-start img-fluid" alt="Plakát filmu ' . $selectedShowData['name'] . '">';
echo '</div>';

echo '</div>';




$friends = $user->getFriendslist();
echo '<h2>Vybrat kamaráda</h2>';
echo '<form action="showrecommendation.php" method="get" class="row row-cols-lg-auto g-3 align-items-center justify-content-center mb-5">';
echo '<div class="col-12">';
echo '<select class="form-select" name="targetUserId" id="targetUserId" required>';
echo '<option disabled selected value="">Zvolte uživatele kterému chcete seriál doporučit</option>';
foreach ($friends as $friend) {
    $selected = '';
    if ($friend['friend_id'] == $_GET['targetUserId']) {
        $selected = ' selected';
    }
    echo '<option value="' . $friend['friend_id'] . '"' . $selected . '>' . $friend['full_name'] . ' (@' . $friend['user_name'] . ')</option>';
}
echo '</select>';
echo '</div>';

echo '<div class="col-12">';
echo ' <input type="hidden" id="showId" name="showId" value="' . $_GET['showId'] . '">';
echo '<button type="submit" class="btn btn-primary">Vybrat</button>';
echo '</div>';
echo '</form>';
?>

<?php
if (isset($_GET['targetUserId'])) {
    $targetUserId = $_GET['targetUserId'];
    $friend = new User($targetUserId);
    $friendData = $friend->getUserData();

    echo '<h3>Obsah doporučení pro ' . $friendData['full_name'] . ' (@' . $friendData['full_name'] . ')</h3>';

    $isShowAlreadyRecommended = $user->isShowRecommendedToUser($targetUserId, $_GET['showId']);

    echo '<form action="showrecommendation.php?targetUserId=' . $_GET['targetUserId'] . '&showId=' . $_GET['showId'] . '" method="post">';
    if ($isShowAlreadyRecommended) {
        echo '<textarea class="form-control" id="description" name="description" rows="3" placeholder="Napište kamarádivu důvod proč mu film doporučujete.">' . $isShowAlreadyRecommended['description'] . '</textarea>';
        echo '<button type="submit" class="btn btn-primary" name="update"><i class="bi bi-arrow-repeat"></i> Aktualizovat</button>';
        echo '<button type="submit" class="btn btn-danger" name="delete"><i class="bi bi-trash-fill"></i> Smazat</button>';
    } else {
        echo '<textarea class="form-control" id="description" name="description" rows="3" placeholder="Napište kamarádivu důvod proč mu film doporučujete."></textarea>';
        echo '<button type="submit" class="btn btn-primary" name="save"><i class="bi bi-save2-fill"></i> Uložit</button>';
    }
    echo '</form>';
}
echo '</div>';
include 'includes/footer.inc.php';
