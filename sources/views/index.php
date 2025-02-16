<?php require_once __DIR__ . "/navbar.php"; ?>

<div class="container mt-15">
    <div class="title-bar">
        <h1>Mes groupes</h1>
        <div class="title-bar__buttons">
            <button data-modal-target="createGroupModal" class="button button--primary"><i class="fa-solid fa-plus"></i>Create a group</button>
        </div>
    </div>
</div>
<div class="container mt-15 card-group__container">
    <?php foreach ($groups as $group) : ?>
    <div class="card-group">
        <h2 class="card-group__title"><?=$group->name?></h2>
        <div class="card-group__content">
            <p><i class="fa-solid fa-user-group"></i><?=count($group->users())?> membres</p>
            <p><i class="fa-solid fa-image"></i><?=count($group->photos())?> photos</p>
        </div>
        <div class="card-group__footer">
            <a href="/group/<?=$group->id?>" class="button button--primary">Voir le groupe</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="modal" id="createGroupModal">
    <div class="modal__content">
        <button class="modal__close-btn" id="closeModalBtn">&times;</button>
        <h2 class="modal__title">Créer un groupe</h2>
        <div class="modal__body" id="modalFormContent">
            <form class="modal__body__form" method="POST" action="/group/create">
                <input required placeholder="Nom du groupe" type="text" name="name" id="name">
                <button class="button button--outline">
                    Créer
                </button>
            </form>
        </div>
        <div class="modal__footer">
            <button class="select select--danger" id="cancelModalBtn">Annuler</button>
        </div>
    </div>
</div>