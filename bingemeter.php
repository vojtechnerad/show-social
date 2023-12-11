<?php
$title = 'Co je to Binge Meter? • Show Social';
$active_page = 'profile';
@session_start();

if (@!$_SESSION['user_id']) {
    include 'includes/header.inc.php';
    echo '<h1>Chyba</h1>';
    include 'includes/footer.inc.php';
    exit();
}

include 'includes/header.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.class.php';



$user = new User($_SESSION['user_id']);
$watchtimeObject = $user->getWatchtimePerLastDay();
$seenMinutesInTotal = $watchtimeObject->watchtime;
$seenPercentage = $watchtimeObject->watchtimePercentage;
$limit = $watchtimeObject->watchtimeLimit;
echo '<div class="container-sm">';
echo '<h1>Binge Meter</h1>';
echo '<h2>Současný stav</h2>';
$bingeMeterContent = 'Za dnešek jste zhlédli ' . $seenMinutesInTotal . ' minut obsahu (' . $seenPercentage . ' %) z vašeho limitu ' . $limit . ' minut.';
echo '<p>' . $bingeMeterContent . '</p>';
echo '<p>';
    if ($seenPercentage < 80) {
    echo 'Do nastaveného limitu zbývá ještě dost času. Užívejte si sledování.';
    } elseif ($seenPercentage < 100) {
    echo 'Začínáte se blížit nastavenému limitu. Pomalu byste měli přestat sledovat.';
    } else {
    echo 'Limit pro sledování vypršel. Vraťte se ke sledování zase zítra.';
    }
    echo '</p>';
?>
<h3>Popis funkce Binge Meteru</h3>
<div class="accordion mb-4" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
        <strong>Co to je</strong>
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        Binge Meter je speciální ukazatel, zobrazující kolik času uživatel strávil sledováním filmů a seriálů.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        <strong>Jak funguje</strong>
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <p>Binge Meter počítá podíl mezi celkovým počtem nasledovaného času na filmech a seriálech za posledních 24 hodin, a soft limitem, který si uživatel předem nastavil.</p>
        <p>Jelikož jde o podíl těchto dvou čísel, možné hodnoty kterých ukazatel Binge Meter může nabývat</p>
        <ul>
            <li>0 &rarr; pokud uživatel neshlédl za den žádnný film ani epizodu</li>
            <li>1 až 99 &rarr; pokud uživatel shlédl obsah v délce menší než jím nastavený limit</li>
            <ul>
                <li><span class="text-white bg-success">1 až 79</span> je označeno zeleně a signalizuje že uživatel má daleko ke svému dennímu limitu</li>
                <li><span class="text-white bg-warning">80 až 99</span> je označeno žlutě a signalizuje že se uživatel blíží ke svému dennímu limitu</li>
                <li><span class="text-white bg-danger">100 a více</span> je označeno zeleně a signalizuje že uživatel překročil svůj denní limit a měl by pro daný den ukončit sledování</li>
            </ul>
            <li>100 a více &rarr; pokud uživatel shlédl obsah v délce svého limitu a více</li>
        </ul>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        <strong>K čemu slouží</strong>
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      <p>Binge watching, pojem známý jen několik málo let, se používá v souvislosti s televizními seriály. Označuje zhlédnutí velkého množství dílů seriálu (nebo i filmů, které mají několik dílů) v nepřetržitém sledu. V současné době se jedná o velmi oblíbený způsob sledování televizních seriálů především u mladé generace.</p>
      <p>Podle odborníků se s binge watchingem pojí řada potenciálních zdravotních rizik. Přece jenom člověk při sledování seriálů či filmů sedí klidně i po několik hodin.</p>
      <p>Pomocí Binge Metru tato stránka chce upozornit uživatele o jejich stavu zhlédnutých filmů či seriálů za daný den. A odratit je tak od dalšího nekončícího sledování 'dalšího jednoho dílu'.</p>
      </div>
    </div>
  </div>
</div>
<?php
$todaySeenMovies = $user->getTodaySeenMovies();
if ($todaySeenMovies) {
    echo '<h3>Dnes zhlédnuté filmy</h3>';
    echo '<div class="list-group mb-3">';
    foreach ($todaySeenMovies as $todaySeenMovie) {
        echo '<a href="./movie.php?id=' . $todaySeenMovie['movie_id'] . '" class="list-group-item list-group-item-action">';
        echo '<div class="d-flex w-100 justify-content-between">';
        echo '<h5 class="mb-1">' . $todaySeenMovie['title'] . '</h5>';
        $bookmarkedTime = date_create($todaySeenMovie['seen_time']);
        echo '<small>' . date_format($bookmarkedTime, 'd.m.Y H:i') . '</small>';
        echo '</div>';
        echo '<p class="mb-1">' . htmlspecialchars($todaySeenMovie['original_title']) . '</p>';
        echo '</a>';
    }
    echo '</div>';
}

$todaySeenEpisodes = $user->getTodaySeenEpisodes();
if ($todaySeenEpisodes) {
    echo '<h3>Dnes zhlédnuté epizody</h3>';
    echo '<div class="list-group">';
    foreach ($todaySeenEpisodes as $todaySeenEpisode) {
        echo '<a href="./show.php?id=' .  $todaySeenEpisode['show_id'] . '" class="list-group-item list-group-item-action">';
        echo '<div class="d-flex w-100 justify-content-between">';
        echo '<h5 class="mb-1">' .  $todaySeenEpisode['show_name'] . '</h5>';
        $bookmarkedTime = date_create($todaySeenEpisode['seen_time']);
        echo '<small>' . date_format($bookmarkedTime, 'd.m.Y H:i') . '</small>';
        echo '</div>';
        echo '<p class="mb-1">' . htmlspecialchars($todaySeenEpisode['original_name']) . '</p>';
        echo '</a>';
    }
    echo '</div>';
}
echo '</div>';
include 'includes/footer.inc.php';
?>
