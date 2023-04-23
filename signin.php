<?php
$title = 'Přihlášení';
$active_page = 'login';
include 'includes/header.inc.php';
?>
<h1>Přihlášení</h1>
<div class="align-self-center">
    <div class="row justify-content-center align-self-center">
        <div class="col-3 align-self-center">
            <form method="post" action="includes/signin.inc.php">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Heslo</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary">Přihlásit</button>
            </form>

            <div class="row mt-5">
                <div>
                    Ještě nejste uživatel?
                    <a href="signup.php" class="btn btn-secondary">Zaregistrovat se</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.inc.php';
?>
