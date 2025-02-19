<?php require_once __DIR__ . "./../navbar.php"; ?>

<div class="container container-2xl mt-10">

  <form class="form" method="POST" action="/register">
    <?php if (isset($flashMessage)) : ?>
      <p><?= $flashMessage ?></p>
    <?php endif; ?>
    <div class="form__group">
      <label for="firstname">Prénom</label>
      <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($old['firstname'] ?? '') ?>">
    </div>
    <div class="form__group">
      <label for="lastname">Nom</label>
      <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($old['lastname'] ?? '') ?>">
    </div>
    <div class="form__group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
    </div>
    <div class="form__group">
      <label for="password">Mot de passe</label>
      <input type="password" id="password" name="password">
    </div>
    <div class="form__group">
      <label for="passwordConfirm">Confirmation du mot de passe</label>
      <input type="password" id="passwordConfirm" name="passwordConfirm">
    </div>
    <button class="button button--primary">
      Inscription
    </button>
    <p>Vous avez déjà un compte ? <a href="/login" class="text-primary">Connection</a></p>
  </form>
</div>