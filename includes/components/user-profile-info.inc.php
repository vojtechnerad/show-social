<?php
    /**
     * Komponenta pro výpis přehledu zhlédnutých filmů/seriálů/kombinaci.
     * Vytvořená pro použití jak na profilu přihlášeného uživatele, tak na profilech ostatních lidí.
     */

    // Pokud je zvoleno ID uživatele, hledá se uživatel
    // Jinak se bere hodnota přihlášeného uživatele
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];
    } else {
        $userId = $_SESSION['user_id'];
    }
    
    $user = new User($userId);
    $userData = $user->getFullUserData();
    $profileCreatedAt = date_format(date_create($userData["created_at"]),"d. m. Y");

    $seenMoviesRuntimeSum = $user->getSeenMoviesRuntimeSum();
    $seenEpisodesRuntimeSum = $user->getSeenEpisodesRuntimeSum();
    $seenTimeSum = $seenMoviesRuntimeSum + $seenEpisodesRuntimeSum;

    /**
     * Funkce pro formátování času stráveném sledováním. Formátuje počet minut.
     * 
     * @param $minutes number - počet minut, které se mají formátovat
     * @return string zformátovaný textový řetězec s časem
     */
    function getSeenTimeFormatted($minutes) {
        $formattedString = '';
        $numOfHours = floor($minutes / 60);
        $numOfMinutes = $minutes % 60;

        if ($numOfHours > 0) {
            $formattedString .= $numOfHours;
            if ($numOfHours > 5) {
                $formattedString .= ' hodin';
            } elseif ($numOfHours > 2) {
                $formattedString .= ' hodiny';
            } else {
                $formattedString .= ' hodina';
            }
        }

        if ($numOfHours > 0 && $numOfMinutes > 0) { $formattedString .= ' a '; }
        
        $formattedString .= $numOfMinutes;
        if ($numOfMinutes > 5 || $numOfMinutes === 0) {
            $formattedString .= ' minut';
        } elseif ($numOfMinutes > 2) {
            $formattedString .= ' minuty';
        } else {
            $formattedString .= ' minuta';
        }

        return $formattedString;
    }

    $bingeMeterRating = $user->getBingeMeterRating();
    $bingeMeterPercentage = $bingeMeterRating['bingeMeterRating'];
    
    if (!$bingeMeterPercentage) {
        $bingeStatusColor = 'bg-secondary';
        $bingeStatusText = 'zatím nemůže být hodnocen jako';
        $bingeMeterRatingText = 'Uživatel zatím nemá žádný záznam.';
    } else {
        if ($bingeMeterPercentage < 33.3) {
            $bingeStatusColor = 'bg-danger';
            $bingeStatusText = 'je častý';
        } else if ($bingeMeterPercentage < 66.6) {
            $bingeStatusColor = 'bg-warning';
            $bingeStatusText = 'je občasný';
        } else {
            $bingeStatusColor = 'bg-success';
            $bingeStatusText = 'není';
        }

        $bingeMeterRatingText = 'Uživatel sledoval filmy a seriály v nastaveném limitu do ' . $bingeMeterRating['limit'] . ' minut celkem ' . $bingeMeterPercentage . '% (' . $bingeMeterRating['days_within_limit'] . ' z '. $bingeMeterRating['days_watching_total'] . ') dní.';
    }

    
?>
<!-- Níže je template pro komponentu -->
<div class="container-fluid">
    <div class="row row-cols-1 row-cols-md-2">
        <div class="col p-0">
            <p class="fs-5 p-0 mb-1 text-start"><i class="bi bi-calendar-event-fill"></i> uživatelem od <?php echo $profileCreatedAt ?></p>
            <p class="text-start mb-0 fs-6 <?php echo $bingeStatusColor ?> text-white" style="width: fit-content; padding: 8px; border-radius: 10px;">
                Uživatel <?php echo $bingeStatusText?> binge watcher
            </p>
            <p class="text-muted"><?php echo $bingeMeterRatingText ?></p>
        </div>
        <div class="col p-0">
            <p class="fs-5 p-0 pb-1 m-0 text-start text-md-end">
                Celkem zhlédnuto <?php echo getSeenTimeFormatted($seenTimeSum)?>
            </p>

            <p class="fs-6 p-0 pb-1 pl-1 m-0 text-start text-md-end">
                &nbsp;<span class="fw-bold"><i class="bi bi-camera-video-fill"></i>&nbsp; Filmy</span>&nbsp;&nbsp;
                <?php echo getSeenTimeFormatted($seenMoviesRuntimeSum)?>
            </p>

            <p class="fs-6 p-0 pb-2 m-0 text-start text-md-end">
                &nbsp;<span class="fw-bold"><i class="bi bi-tv-fill"></i>&nbsp; Seriály</span>&nbsp;&nbsp;
                <?php echo getSeenTimeFormatted($seenEpisodesRuntimeSum)?>
            </p>
        </div>
    </div>
</div>