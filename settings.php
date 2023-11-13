<?php
require_once 'classes/User.class.php';
session_start();

$title = 'Nastavení';
$active_page = 'profile';

// Kontrola nepřihlášeného uživatele
if (!isset($_SESSION['user_id'])) {
    include 'includes/header.inc.php';
    echo '<h1>Na tuto stránku nemáte přístup!</h1>';
    include 'includes/footer.inc.php';
}

$user = new User($_SESSION['user_id']);
$requestMethod = $_SERVER['REQUEST_METHOD'];
if ($requestMethod == 'POST') {

    // Private se převrací na public
    if (isset($_POST['private-profile'])) {
        //$publicProfile = false;
        $publicProfile = true;
    } else {
        //$publicProfile = true;
        $publicProfile = false;
    }
    $watchLimit = $_POST['watch-limit'];

    try {
        $user->updateUsersSettings($publicProfile, $watchLimit);
        $isUpdateSuccessful = true;
    } catch (PDOException $exception) {
        $isUpdateSuccessful = false;
    }
}

$userFullData = $user->getFullUserData();

include 'includes/header.inc.php';

?>
<h1>Nastavení</h1>
<div class="container-sm">
    <div class="align-self-center">
        <?php
            $releaseDate = date_create(time());
            if ($requestMethod == 'POST' AND $isUpdateSuccessful) {
                echo '
                    <div class="alert alert-success" role="alert">
                        Změny úspěšně provedeny. (' . date("H:i:s") .')
                    </div>
                ';
            } elseif ($requestMethod == 'POST' AND $isUpdateSuccessful) {
                echo '
                    <div class="alert alert-success" role="alert">
                        Vyskytla se chyba. (' . date("H:i:s") .')
                    </div>
                ';
            }
        ?>
        <div class="row justify-content-center align-self-center">
            <h2>Uživatelské údaje</h2>
            <div class="col col-md-5 align-self-center">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="first-name" class="form-label">Jméno</label>
                                <input type="text" class="form-control" id="first-name" name="first-name" value="<?php echo $userFullData['first_name'] ?>" disabled>
                            </div>
                        </div>

                        <div class="col">
                            <div class="mb-3">
                                <label for="last-name" class="form-label">Příjmení</label>
                                <input type="text" class="form-control" id="last-name" name="last-name" value="<?php echo $userFullData['last_name'] ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="user-name" class="form-label">Uživatelské jméno</label>
                        <input type="text" class="form-control" id="user-name" name="user-name" value="<?php echo $userFullData['user_name'] ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $userFullData['email'] ?>" disabled>
                        <?php
                        if (isset($errors['emailTaken']) AND $errors['emailTaken']) {
                            echo '<div class="invalid-feedback" id="usernameTaken">Email je již zabraný.</div>';
                        } elseif (isset($errors['emailNotValid']) AND $errors['emailNotValid']) {
                            echo '<div class="invalid-feedback" id="usernameTaken">Email není validní.</div>';
                        }
                        ?>
                    </div>

                    <!--
                    <div class="row mb-2">
                        <div class="col">
                            <label for="password" class="form-label">Heslo</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="col">
                            <div class="mb-3">
                                <label for="password-repeat" class="form-label">Heslo znovu</label>
                                <input type="password" class="form-control" id="password-repeat" name="password-repeat" required>
                            </div>
                        </div>
                    </div>
                    -->
                    <form method="post" action="settings.php">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="private-profile" name="private-profile" value="TRUE" <?php echo ($userFullData['public_profile']) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="private-profile">Soukromý profil</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="watch-limit" class="form-label">Denní limit na sledování</label>
                                <input type="number" class="form-control" id="watch-limit" name="watch-limit" min="30" max="1440" step="1" value="<?php echo $userFullData['watch_limit'] ?>" required>
                                <div id="privateProfileHelp" class="form-text">Denní limit na sledování filmů a seriálů v minutách.</div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Aktualizovat</button>
                    </form>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.inc.php';