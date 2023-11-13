<?php
    @session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/classes/User.class.php';

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

        $user = new User($_SESSION['user_id']);

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
                    if (!isset($_SESSION['user_id'])) {
                        echo '<a ' . (($active_page == 'introduction') ? $active_link_classes : $nonactive_link_classes) . ' href="../index.php"><i class="bi bi-house-fill"></i> Úvod</a>';
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
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<li class="nav-item">';
                    echo '<a ' . (($active_page == 'recommendations') ? $active_link_classes : $nonactive_link_classes) . ' href="../recommendations.php"><i class="bi bi-hand-thumbs-up-fill"></i> Doporučené</a>';
                    echo '</li>';
                    }
                ?>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $watchtimeObject = $user->getWatchtimePerLastDay();
                        $seenMinutesInTotal = $watchtimeObject->watchtime;
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
                        echo '<a href="../bingemeter.php" id="binge-meter-button" class="btn btn-' . $bingeMeterClass . '">';
                        echo 'Binge Meter: ' . $seenPercentage;
                        echo '</a>';
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
                    echo '<li><a class="dropdown-item" href="../bookmarks.php"><i class="bi bi-bookmarks-fill"></i> Založené</a></li>';
                    echo '<li><a class="dropdown-item" href="../favorites.php"><i class="bi bi-heart-fill"></i> Oblíbené</a></li>';
                    echo '<li><hr class="dropdown-divider"></li>';
                    echo '<li><a class="dropdown-item" href="settings.php"><i class="bi bi-gear-fill"></i> Nastavení profilu</a></li>';
                    echo '<li><hr class="dropdown-divider"></li>';
                    echo '<li><a class="dropdown-item" href="../includes/signout.inc.php"><p class="text-danger mb-0"><i class="bi bi-box-arrow-right"></i> Odhlášení</p></a></li>';
                    echo '</ul>';
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>