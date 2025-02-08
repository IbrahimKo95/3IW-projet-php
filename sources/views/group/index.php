<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Groups</title>
</head>

<body>
    <p><?= $group->name ?></p>
    <?php if (User::currentUser()->getPermission($group->id) == 2) : ?>
        <form method="POST" action="<?=$group->id?>/addUser">
            <h2>Add user to group</h2>
            <?php if (isset($flashMessage)) : ?>
                <p><?= $flashMessage ?></p>
            <?php endif; ?>
            <input type="email" name="email">
            <input type="submit">
        </form>
    <?php endif; ?>
    <ul>
        <?php foreach ($group->users() as $user) : ?>
            <li><?= $user->fullName() .' ('. $user->email .') : ' . $user->getPermission($group->id) ?></li>
        <?php endforeach; ?>
</body>

</html>