<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
</head>

<body>
  <form method="POST" action="/register">
    <?php if (isset($flashMessage)) : ?>
      <p><?= $flashMessage ?></p>
    <?php endif; ?>
    <input type="text" name="firstname" value="<?= htmlspecialchars($old['firstname'] ?? '') ?>">
    <input type="text" name="lastname" value="<?= htmlspecialchars($old['lastname'] ?? '') ?>">
    <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
    <input type="password" name="password">
    <input type="password" name="passwordConfirm">
    <button>
      Inscription
    </button>
  </form>
</body>

</html>