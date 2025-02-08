<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>

<body>
<p><?=
    User::currentUser()->email
    ?></p>
<form method="POST" action="/group/create">
    <input type="text" name="name">
    <input type="submit">
</form>
<ul>
    <?php foreach ($groups as $group) : ?>
        <li><a href="/group/<?=$group->id?>"><?= $group->name ?></a></li>
    <?php endforeach; ?>
</ul>
</body>

</html>