<?php require_once __DIR__ . "/../navbar.php"; ?>

<div class="container container-2xl mt-15">
    <div class="flex flex-row align-center gap-5 mb-5">
        <a href="/group/<?=$group->id?>"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>Paramètres</h1>
    </div>
    <div class="card">
        <div class="card__titleBar">
            <h2>Général</h2>
        </div>
        <div class="">
            <?php if (isset($flashMessage)) : ?>
                <p class="text-red"><?= $flashMessage ?></p>
            <?php endif; ?>
            <form method="POST" action="/group/<?=$group->id?>/update">
                <div class="flex flex-column gap-5">
                    <label for="name">Nom du groupe</label>
                    <input type="text" name="name" id="name" value="<?=$group->name?>">
                    <a href="/group/<?=$group->id?>/delete" class="text-red flex flex-row gap-1"><i class="fa-solid fa-triangle-exclamation"></i>Supprimer le groupe</a>
                    <button class="button button--primary">Sauvegarder</button>
                </div>
            </form>
        </div>

    </div>
</div>

<div class="modal" id="addMemberModal">
    <div class="modal__content">
        <button class="modal__close-btn" id="closeModalBtn">&times;</button>
        <h2 class="modal__title">Ajouter un membre</h2>
        <div class="modal__body" id="modalFormContent">
            <form class="modal__body__form" method="POST" action="/group/<?=$group->id?>/addUser">
                <input required placeholder="Email de l'utilisateur" type="email" name="email" id="email">
                <button class="button button--outline">
                    Ajouter
                </button>
        </div>
        <div class="modal__footer">
            <button class="select select--danger" id="cancelModalBtn">Annuler</button>
        </div>
    </div>
</div>
