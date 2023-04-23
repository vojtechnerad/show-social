<?php
/**
 * Skript signup.php slouží k vygenerování stránky s formulářem pro registraci nového uživatele.
 * Skript zároveň obsahuje mechanismus pro validaci dat, konkrétně
 * - zadání všech požadovaných polí
 * - email není zabraný + je validní
 * - uživatelské jméno není zabrané
 * - heslo a heslo znovu se shodují
 * Po úspěšné validaci všech dat skript obsahuje kód pro registraci nového uživatele, a následně ho přihlásí.
 */

require_once 'classes/Users.class.php';
$title = 'Registrace';
$active_page = 'login';
include 'includes/header.inc.php';


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $users = new Users();
    $errors = []; // Pole, do kterého se budou zapisovat potenciální errory

    // Kontrola vyplnění všech povinných polí
    if (empty($_POST['first-name']) OR
        empty($_POST['last-name']) OR
        empty($_POST['user-name']) OR
        empty($_POST['email']) OR
        empty($_POST['password']) OR
        empty($_POST['password-repeat']) OR
        empty($_POST['watch-limit'])
    ) {
        $errors['notAllRequiredFieldsFilled'] = true;
    } else {
        // Kontrola zabraného emailu
        $isEmailTaken = $users->isEmailTaken($_POST['email']);
        if ($isEmailTaken) {
            $errors['emailTaken'] = true;
        } else {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['emailNotValid'] = true;
            }
        }

        // Kontrola zabraného uživatelského jména
        $isUsernameTaken = $users->isUsernameTaken($_POST['user-name']);
        if ($isUsernameTaken) {
            $errors['usernameTaken'] = true;
        }

        // Kontrola shodnosti hesel
        if ($_POST['password'] !== $_POST['password-repeat']) {
            $errors['passwordsDoNotMatch'] = true;
        }

        // Pokud nejsou žádné nedostatky, zaregistrovat uživatele a rovnou ho přihlásit
        if (!$errors) {
            $isPublicProfile = (!isset($_POST['private-profile']));

            try {
                $users->signUpNewUser(
                    $_POST['user-name'],
                    $_POST['first-name'],
                    $_POST['last-name'],
                    $_POST['email'],
                    $_POST['password'],
                    $_POST['watch-limit'],
                    $isPublicProfile
                );

                // Získání dat o nově zaregistrovaném uživateli - je potřeba získat jeho vygenerované ID
                $userData = $users->getUserByEmail($_POST['email']);

                // Pokud se úspěšně navrátí uživatelova data, rovnou ho přihlásíme a přesměrujeme na jeho nový profil
                if ($userData) {
                    $_SESSION['user_id'] = $userData['id'];
                    $_SESSION['user_name'] = $userData['user_name'];
                    $_SESSION['first_name'] = $userData['first_name'];
                    $_SESSION['last_name'] = $userData['last_name'];
                    header('Location: profile.php');
                    exit();
                }
            } catch (PDOException $PDOException) { // V případě problému při zápisu nového uživatele do databáze odchytíme chybu a vypíšeme jí
                echo '<div class="alert alert-danger" role="alert">Zápis nového uživatele do databáze se nepovedl!</div>';
            }
        }
    }
}
?>
<h1>Registrace</h1>
<div class="align-self-center">
    <div class="row justify-content-center align-self-center">
        <div class="col-3 align-self-center">
            <form method="post" action="signup.php">
                <?php
                    if (isset($errors['notAllRequiredFieldsFilled']) AND $errors['notAllRequiredFieldsFilled']) {
                        echo '
                            <div class="alert alert-danger" role="alert">
                              Nebyla vyplněna všechna pole formuláře!
                            </div>
                        ';
                    }
                ?>
                <div class="row">
                    <?php
                        $firstnamePost = isset($_POST['first-name']) ? 'value="' . $_POST['first-name'] . '"' : '';
                    ?>
                    <div class="col">
                        <div class="mb-3">
                            <label for="first-name" class="form-label">Jméno</label>
                            <input type="text" class="form-control" id="first-name" name="first-name" <?php echo $firstnamePost ?> required>
                        </div>
                    </div>

                    <?php
                        $lastnamePost = isset($_POST['last-name']) ? 'value="' . $_POST['last-name'] . '"' : '';
                    ?>
                    <div class="col">
                        <div class="mb-3">
                            <label for="last-name" class="form-label">Příjmení</label>
                            <input type="text" class="form-control" id="last-name" name="last-name" <?php echo $lastnamePost ?> required>
                        </div>
                    </div>
                </div>

                <?php
                    $usernameValidation = ((isset($errors['usernameTaken'])) AND $errors['usernameTaken']) ? 'is-invalid' : '';
                    $usernamePost = isset($_POST['user-name']) ? 'value="' . $_POST['user-name'] . '"' : '';
                ?>
                <div class="mb-3">
                    <label for="user-name" class="form-label">Uživatelské jméno</label>
                    <input type="text" class="form-control <?php echo $usernameValidation ?>" id="user-name" name="user-name" <?php echo $usernamePost ?> required>
                    <?php
                        if (isset($errors['usernameTaken']) AND $errors['usernameTaken']) {
                            echo '<div class="invalid-feedback" id="usernameTaken">Uživatelské jméno je již zabrané.</div>';
                        }
                    ?>
                </div>

                <?php
                    $emailPost = isset($_POST['email']) ? 'value="' . $_POST['email'] . '"' : '';
                    if (isset($errors['emailTaken'])) {
                        $emailValidation = ($errors['emailTaken']) ? 'is-invalid' : '';
                    } elseif (isset($errors['emailNotValid'])) {
                        $emailValidation = ($errors['emailNotValid']) ? 'is-invalid' : '';
                    }
                ?>
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="text" class="form-control <?php echo $emailValidation ?>" id="email" name="email" <?php echo $emailPost ?> required>
                    <?php
                        if (isset($errors['emailTaken']) AND $errors['emailTaken']) {
                            echo '<div class="invalid-feedback" id="usernameTaken">Email je již zabraný.</div>';
                        } elseif (isset($errors['emailNotValid']) AND $errors['emailNotValid']) {
                            echo '<div class="invalid-feedback" id="usernameTaken">Email není validní.</div>';
                        }
                    ?>
                </div>

                <div class="row mb-2">
                    <?php
                        $passwordValidation = ((isset($errors['passwordsDoNotMatch'])) AND $errors['passwordsDoNotMatch']) ? 'is-invalid' : '';
                    ?>
                    <div class="col">
                        <label for="password" class="form-label">Heslo</label>
                        <input type="password" class="form-control <?php echo $passwordValidation ?>" id="password" name="password" required>
                        <?php
                            if (isset($errors['passwordsDoNotMatch']) AND $errors['passwordsDoNotMatch']) {
                                echo '<div class="invalid-feedback" id="passwordsDoNotMatch">Hesla se neshodují.</div>';
                            }
                        ?>
                    </div>

                    <div class="col">
                        <div class="mb-3">
                            <label for="password-repeat" class="form-label">Heslo znovu</label>
                            <input type="password" class="form-control <?php echo $passwordValidation ?>" id="password-repeat" name="password-repeat" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <?php
                        $privateProfilePost = isset($_POST['private-profile']) ? ' checked' : '';
                    ?>
                    <div class="col">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="private-profile" name="private-profile" value="TRUE" <?php echo $privateProfilePost ?>>
                            <label class="form-check-label" for="private-profile">Soukromý profil</label>
                        </div>
                        <div id="privateProfileHelp" class="form-text">Toto nastavení omezí možnost zobrazení vašeho profilu pouze na vaše přátele.</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <?php
                        $watchLimitPost = isset($_POST['watch-limit']) ? 'value="' . $_POST['watch-limit'] . '"' : '';
                    ?>
                    <div class="col">
                        <label for="watch-limit" class="form-label">Denní limit na sledování</label>
                        <input type="number" class="form-control" id="watch-limit" name="watch-limit" min="30" max="1440" step="1" <?php echo $watchLimitPost ?> required>
                        <div id="privateProfileHelp" class="form-text">Nastavte si denní limit na sledování filmů a seriálů v minutách.</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Zaregistrovat se</button>
            </form>
        </div>
    </div>
</div>
<?php
include 'includes/footer.inc.php';
?>
