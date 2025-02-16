<?php require_once __DIR__ . "./../navbar.php"; ?>

<div class="container container-2xl mt-10">
        <form class="form" method="POST" action="/login">
            <h1>Connexion</h1>
            <?php if (isset($flashMessage)) : ?>
                <p><?= $flashMessage ?></p>
            <?php endif; ?>
            <div class="form__group">
                <label for="email">Adresse email</label>
                <input id="email" type="email" name="email">
            </div>
            <div class="form__group">
                <label for="password">Mot de passe</label>
                <input id="password" type="password" name="password">
            </div>
            <button class="button button--primary">
                Connexion
            </button>
            <p>Vous n'avez pas encore de compte ? <a href="/register" class="text-primary">Inscrivez-vous</a></p>
            <a class="text-primary" href="#">Mot de passe oublié</a>
        </form>
</div>
