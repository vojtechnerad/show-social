<?php
    $active_link_classes = 'class="nav-link active" aria-current="page"';
    $nonactive_link_classes = 'class="nav-link"';
?>

<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            Show Social
            <img src="/assets/favicon/android-chrome-512x512.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-bottom">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a <?php echo(($active_page == 'dashboard') ? $active_link_classes : $nonactive_link_classes); ?> href="index.php">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a <?php echo(($active_page == 'movie') ? $active_link_classes : $nonactive_link_classes); ?> href="movie.php">Filmy</a>
                </li>

                <li class="nav-item">
                    <a <?php echo(($active_page == 'shows') ? $active_link_classes : $nonactive_link_classes); ?> href="shows.php">Seriály</a>
                </li>

                <li class="nav-item">
                    <a <?php echo(($active_page == 'people') ? $active_link_classes : $nonactive_link_classes); ?> href="people.php">Lidé</a>
                </li>

                <li class="nav-item">
                    <a <?php echo(($active_page == 'events') ? $active_link_classes : $nonactive_link_classes); ?> href="#">Události</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        echo '<a ' . (($active_page == 'profile') ? $active_link_classes : $nonactive_link_classes) . ' href="../profile.php"><i class="bi bi-person-circle"></i> ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] . '</a>';
                    } else {
                        echo '<a ' . (($active_page == 'login') ? $active_link_classes : $nonactive_link_classes) . ' href="../authentication.php"><i class="bi bi-person-circle"></i> Přihlášení</a>';
                    }
                    ?>
                </li>
                <?php
                if (isset($_SESSION['user_id'])) {
                    echo '<li class="nav-item dropdown">';
                    echo '<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>';
                    echo '<ul class="dropdown-menu dropdown-menu-end">';
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
</nav>