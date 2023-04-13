<?php
    $active_link_classes = 'class="nav-link active" aria-current="page"';
    $nonactive_link_classes = 'class="nav-link"';

    if (isset($_SESSION['user_id'])) {
        $userDataStatement = $db->prepare('
            SELECT watch_limit
            FROM users
            WHERE id = (:id)
            LIMIT 1;
        ');
        $userDataStatement->execute(array(':id' => $_SESSION['user_id']));
        $userData = $userDataStatement->fetch();
    }
?>

<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">
            <img src="/assets/favicon/android-chrome-512x512.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-bottom">
            &nbsp;Show Social
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        echo '<a ' . (($active_page == 'dashboard') ? $active_link_classes : $nonactive_link_classes) . ' href="../index.php"><i class="bi bi-easel-fill"></i> Dashboard</a>';
                    } else {
                        echo '<a ' . (($active_page == 'introduction') ? $active_link_classes : $nonactive_link_classes) . ' href="../index.php">Úvod</a>';
                    }
                    ?>
                </li>

                <li class="nav-item">
                    <a <?php echo(($active_page == 'movie') ? $active_link_classes : $nonactive_link_classes); ?> href="movies.php"><i class="bi bi-camera-video-fill"></i> Filmy</a>
                </li>

                <li class="nav-item">
                    <a <?php echo(($active_page == 'shows') ? $active_link_classes : $nonactive_link_classes); ?> href="shows.php"><i class="bi bi-tv-fill"></i> Seriály</a>
                </li>

                <li class="nav-item">
                    <a <?php echo(($active_page == 'people') ? $active_link_classes : $nonactive_link_classes); ?> href="users.php"><i class="bi bi-people-fill"></i> Lidé
                    <?php
                        if (isset($_SESSION['user_id'])) {
                            $friendlistStatement = $db->prepare('
                                SELECT requesterId, adresseeId, isConfirmed
                                FROM friendslist
                                WHERE adresseeId = (:selectedUser) AND isConfirmed = false;
                            ');
                            $friendlistStatement->execute(
                                array(':selectedUser' => $_SESSION['user_id'])
                            );
                            $friendlistData = $friendlistStatement->fetchAll();
                            $numberOfFriendRequests = count($friendlistData);
                            if ($numberOfFriendRequests > 0)
                            echo '<span class="badge text-bg-danger">' . $numberOfFriendRequests . '</span>';
                        }
                    ?>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $seenMinutesTodayStatement = $db->prepare('
                            SELECT seen_episodes.id as id, seen_episodes.timestamp as seen_time, seen_episodes.user_id as user_id, tv_show_episodes.runtime as runtime
                            FROM seen_episodes
                            LEFT JOIN tv_show_episodes
                            ON seen_episodes.id = tv_show_episodes.id
                            WHERE seen_episodes.timestamp >= NOW() - INTERVAL 1 DAY AND user_id = (:user_id);
                        ');
                        $seenMinutesTodayStatement->execute([
                                ':user_id' => $_SESSION['user_id']
                        ]);
                        $seenMinutesTodayData = $seenMinutesTodayStatement->fetchAll();

                        $seenMinutesInTotal = 0;
                        foreach ($seenMinutesTodayData as $show) {
                            $seenMinutesInTotal = $seenMinutesInTotal + $show['runtime'];
                        }

                        $bingeMeterClass = ($seenMinutesInTotal > $userData['watch_limit']) ? 'btn-danger' : 'btn-success';
                        $seenPercentage = 0;
                        $seenPercentage = round((($seenMinutesInTotal/$userData['watch_limit']) * 100), 1);

                        if ($seenPercentage < 80) {
                            $bingeMeterClass = 'success';
                        } elseif ($seenPercentage < 100) {
                            $bingeMeterClass = 'warning';
                        } else {
                            $bingeMeterClass = 'danger';
                        }


                        $bingeMeterContent = 'Za dnešek jste zhlédli ' . $seenMinutesInTotal . ' minut obsahu (' . $seenPercentage . ' %) z vašeho limitu ' . $userData['watch_limit'] . ' minut.';
                        //echo '<button type="button" class="btn ' . $bingeMeterClass . '" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-title="Binge Meter statistika" data-bs-content="' . $bingeMeterContent . '">';
                        echo '<button type="button" class="btn btn-' . $bingeMeterClass . '" data-bs-toggle="modal" data-bs-target="#exampleModal" data-backdrop="false">';
                        echo 'Binge Meter: ' . $seenPercentage;
                        echo '</button>';
                    }
                    ?>
                </li>
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        echo '<a ' . (($active_page == 'profile') ? $active_link_classes : $nonactive_link_classes) . ' href="../profile.php"><i class="bi bi-person-circle"></i> ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '</a>';
                    } else {
                        echo '<a ' . (($active_page == 'login') ? $active_link_classes : $nonactive_link_classes) . ' href="../signin.php"><i class="bi bi-person-circle"></i> Přihlášení</a>';
                    }
                    ?>
                </li>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<li class="nav-item dropdown">';
                    echo '<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>';
                    echo '<ul class="dropdown-menu dropdown-menu-end">';
                    echo '<li><a class="dropdown-item" href="#"><i class="bi bi-bookmarks-fill"></i> Bookmarks</a></li>';
                    echo '<li><hr class="dropdown-divider"></li>';
                    echo '<li><a class="dropdown-item" href="#"><i class="bi bi-gear-fill"></i> Nastavení profilu</a></li>';
                    echo '<li><hr class="dropdown-divider"></li>';
                    echo '<li><a class="dropdown-item" href="../includes/signout.inc.php"><p class="text-danger mb-0"><i class="bi bi-box-arrow-right"></i> Odhlášení</p></a></li>';
                    echo '</ul>';
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <!-- Binge Meter Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Binge Meter statistika</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $bingeMeterContent ?></p>
                    <div class="progress">
                        <div class="progress-bar bg-<?php echo $bingeMeterClass ?>" role="progressbar" style="width: <?php echo $seenPercentage ?>%" aria-valuenow="<?php echo $seenPercentage ?>" aria-valuemin="0" aria-valuemax="100">
                            <?php echo $seenPercentage . ' %' ?>
                        </div>
                    </div>
                    <br />
                    <?php
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
                </div>
                <div class="modal-footer">
                    <a class="btn btn-light" href="../bingemeterexplanation.php">Jak to funguje?</a>
                </div>
            </div>
        </div>
    </div>
</nav>