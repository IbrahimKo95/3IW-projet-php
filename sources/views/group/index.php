<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Groups</title>
</head>

<body>
<p><?= $group->name ?></p>
    <?php if (User::currentUser()->getPermission($group->id) == 2) : ?>
        <form method="POST" action="<?= $group->id ?>/addUser">
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
            <li><?= $user->fullName() . ' (' . $user->email . ') : ' . $user->getPermission($group->id) ?></li>
        <?php endforeach; ?>
    </ul>

    <?php if (User::currentUser()->getPermission($group->id) > 1) : ?>
        <a href="<?= $group->id ?>/addPhotoForm">Nouvelle photo</a>
    <?php endif; ?>
    <ul>
        <?php foreach ($photos as $photo):
            $imageData = base64_encode($photo->photo ?? ''); ?>
            <li>
                <?php if ($photo->visibility === 'public'): ?>
                    <a href="/photo/<?= $photo->token ?>">
                    <?php endif ?>
                    <?php if (isset($photo->photo)): ?>
                        <img src="<?= htmlspecialchars("data:image/jpeg;base64,{$imageData}"); ?>" alt="<?= htmlspecialchars($photo->label); ?>" width="200">
                    <?php endif ?>
                    <p><?= htmlspecialchars($photo->label); ?></p>
                    <?php if ($photo->visibility === 'public'): ?>
                    </a>
                <?php endif ?>
            </li>
            <?php if (User::currentUser()->getPermission($group->id) == 3 || User::currentUser()->isMyPhoto($photo->id)) : ?>
                <form action="<?= $group->id ?>/deletePhoto" method="POST">
                    <input type="hidden" name="photo_id" value="<?= $photo->id; ?>">
                    <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cette photo ?');">Supprimer</button>
                </form>
                <form id="visibilitySelect-<?= $photo->id ?>" method="POST" action="<?= $group->id ?>/changeVisibility" enctype="multipart/form-data">
                    <label>Visibilité :</label>
                    <select name="visibility" id="visibility" onchange="document.getElementById('visibilitySelect-<?= $photo->id ?>').submit();">
                        <option value="group" <?php if ($photo->visibility == 'group') : ?> selected <?php endif ?>>Groupe uniquement</option>
                        <option value="public" <?php if ($photo->visibility == 'public') : ?> selected <?php endif ?>>Public (lien unique)</option>
                    </select>
                    <input type="hidden" name="photo_id" value="<?= $photo->id;
                                                                var_dump($photo->id); ?>">
                </form>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</body>

</html>