<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Groups</title>
</head> -->

<!-- <body>
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
                    <input type="hidden" name="photo_id" value="<?= $photo->id; ?>">
                </form>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</body> -->

<body class="mb-8">
    <nav class="navbar">
        <div class="container">
            <a href="/" class="navbar__title">ESGI-Photo</a>
            <ul>
                <li>
                    <a href="#">DarkMode</a>
                </li>
                <li>
                    <a href="#">Profile</a>
                </li>
                <li>
                    <a href="/logout" class="text-red">Logout</a>
                </li>
            </ul>
            <button class="navbar__button">
                <svg
                    width="18"
                    height="14"
                    viewBox="0 0 18 14"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M0.75 13C0.75 12.8011 0.829018 12.6103 0.96967 12.4697C1.11032 12.329 1.30109 12.25 1.5 12.25H16.5C16.6989 12.25 16.8897 12.329 17.0303 12.4697C17.171 12.6103 17.25 12.8011 17.25 13C17.25 13.1989 17.171 13.3897 17.0303 13.5303C16.8897 13.671 16.6989 13.75 16.5 13.75H1.5C1.30109 13.75 1.11032 13.671 0.96967 13.5303C0.829018 13.3897 0.75 13.1989 0.75 13ZM0.75 7C0.75 6.80109 0.829018 6.61032 0.96967 6.46967C1.11032 6.32902 1.30109 6.25 1.5 6.25H16.5C16.6989 6.25 16.8897 6.32902 17.0303 6.46967C17.171 6.61032 17.25 6.80109 17.25 7C17.25 7.19891 17.171 7.38968 17.0303 7.53033C16.8897 7.67098 16.6989 7.75 16.5 7.75H1.5C1.30109 7.75 1.11032 7.67098 0.96967 7.53033C0.829018 7.38968 0.75 7.19891 0.75 7ZM0.75 1C0.75 0.801088 0.829018 0.610322 0.96967 0.46967C1.11032 0.329018 1.30109 0.25 1.5 0.25H16.5C16.6989 0.25 16.8897 0.329018 17.0303 0.46967C17.171 0.610322 17.25 0.801088 17.25 1C17.25 1.19891 17.171 1.38968 17.0303 1.53033C16.8897 1.67098 16.6989 1.75 16.5 1.75H1.5C1.30109 1.75 1.11032 1.67098 0.96967 1.53033C0.829018 1.38968 0.75 1.19891 0.75 1Z"
                        fill="currentColor" />
                </svg>
            </button>
        </div>
    </nav>
    <div class="container mt-15">
        <div class="title-bar">
            <h1><?= $group->name ?></h1>
            <div class="title-bar__buttons">
                <?php if (User::currentUser()->getPermission($group->id) > 1) : ?>
                    <a href="<?= $group->id ?>/addPhotoForm" id="uploadPhotoBtn" data-group-id="<?= $group->id ?>" class="button button--primary">Upload photos</a>
                <?php endif; ?>
                <button class="button button--outline">Manage Members</button>
                <button class="button button--outline">Settings</button>
            </div>
        </div>
    </div>
    <div class="modal" id="photoUploadModal">
        <div class="modal__content">
            <button class="modal__close-btn" id="closeModalBtn">&times;</button>
            <h2 class="modal__title">Ajouter une photo</h2>
            <div class="modal__body" id="modalFormContent">
            </div>
            <div class="modal__footer">
                <button class="select select--danger" id="cancelModalBtn">Annuler</button>
            </div>
        </div>
    </div>
    <div class="container mt-15 card-photo__container">
        <?php foreach ($photos as $photo):
            $imageData = base64_encode($photo->photo ?? ''); ?>
            <div class="card-photo">
                <?php if ($photo->visibility === 'public'): ?>
                    <a href="/photo/<?= $photo->token ?>">
                    <?php endif ?>
                    <?php if (isset($photo->photo)): ?>
                        <img src="<?= htmlspecialchars("data:image/jpeg;base64,{$imageData}"); ?>" alt="<?= htmlspecialchars($photo->label); ?>" />
                    <?php endif ?>
                    <?php if ($photo->visibility === 'public'): ?>
                    </a>
                <?php endif ?>
                <div class="card-photo__banner">
                    <p class="card-photo__label"><?= htmlspecialchars($photo->label); ?></p>
                    <div class="card-photo__actions">
                        <?php if (User::currentUser()->getPermission($group->id) == 3 || User::currentUser()->isMyPhoto($photo->id)) : ?>
                            <!-- <i class="fa-solid fa-trash"></i> -->
                            <form action="<?= $group->id ?>/deletePhoto" method="POST">
                                <input type="hidden" name="photo_id" value="<?= $photo->id; ?>">
                                <button class="fa-solid fa-trash button--wb" type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cette photo ?');"></button>
                            </form>
                            <form id="visibilitySelect-<?= $photo->id ?>" method="POST" action="<?= $group->id ?>/changeVisibility" enctype="multipart/form-data">
                                <div class="card-photo__visibility">
                                    <!-- <p class="card-photo__label">Visibilité :</p> -->
                                    <select class="select--primary select" name="visibility" id="visibility" onchange="document.getElementById('visibilitySelect-<?= $photo->id ?>').submit();">
                                        <option value="group" <?php if ($photo->visibility == 'group') : ?> selected <?php endif ?>>Groupe uniquement</option>
                                        <option value="public" <?php if ($photo->visibility == 'public') : ?> selected <?php endif ?>>Public (lien unique)</option>
                                    </select>
                                    <input type="hidden" name="photo_id" value="<?= $photo->id; ?>">
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>