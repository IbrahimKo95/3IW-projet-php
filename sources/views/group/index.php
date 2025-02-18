
<?php require_once __DIR__ . "/../navbar.php"; ?>

    <div class="modal <?= isset($_SESSION['open_modal']) && $_SESSION['open_modal'] ? 'modal--visible' : '' ?>" id="addPhotoModal">
        <?php unset($_SESSION['open_modal']); ?>
        <div class="modal__content">
            <button class="modal__close-btn" id="closeModalBtn">&times;</button>
            <h2 class="modal__title">Ajouter une photo</h2>
            <div class="modal__body" id="modalFormContent">
                <?php if (!empty($_SESSION['modal_message'])) : ?>
                    <p style="color: red"><?= $_SESSION['modal_message']; ?></p>
                    <?php unset($_SESSION['modal_message']); ?>
                <?php endif; ?>
                <form class="modal__body__form" method="POST" action="/group/<?= $group->id ?>/addPhoto" enctype="multipart/form-data">
                    <input required placeholder="Image" type="file" name="file" id="file">
                    <input required placeholder="Label" type="text" name="label" id="label">
                    <button class="button button--outline">
                        Ajouter
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="container mt-15">
        <div class="title-bar">
            <h1><?= $group->name ?></h1>
            <div class="title-bar__buttons">
                <?php if (User::currentUser()->getPermission($group->id) > 1) : ?>
                    <button data-modal-target="addPhotoModal" class="button button--primary">Upload photos</button>
                <?php endif; ?>
                <?php if (User::currentUser()->getPermission($group->id) == 3) : ?>
                    <a href="<?= $group->id ?>/manageMember" class="button button--outline">Gérer les membres</a>
                    <a href="<?= $group->id ?>/parameters" class="button button--outline">Paramètres</a>
                <?php elseif (User::currentUser()->getPermission($group->id) < 3) : ?>
                    <a href="<?= $group->id ?>/quitGroup" class="button button--outline">Quitter le groupe</a>
                <?php endif; ?>
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