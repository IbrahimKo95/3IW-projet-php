<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>

<body>
  <form method="POST" action="/login">
      <?php if (isset($flashMessage)) : ?>
          <p><?= $flashMessage ?></p>
      <?php endif; ?>
    <input type="email" name="email">
    <input type="password" name="password">
    <button>
      Connexion
    </button>
  </form>
</body>

</html>