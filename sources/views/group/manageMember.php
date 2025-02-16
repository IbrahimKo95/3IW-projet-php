<?php require_once __DIR__ . "/../navbar.php"; ?>

<div class="container container-2xl mt-15">
    <div class="flex flex-row align-center gap-5 mb-5">
        <a href="/group/<?=$group->id?>"><i class="fa-solid fa-arrow-left"></i></a>
        <h1>Manage Members</h1>
    </div>
    <div class="card">
        <div class="card__titleBar">
            <h2>Membres</h2>
            <div>
                <button data-modal-target="addMemberModal" class="button button--primary" id="openModal"><i class="fa-solid fa-plus"></i>Ajouter un membre</button>
            </div>
        </div>
        <div class="px-5">
            <?php if (isset($flashMessage)) : ?>
                <p class="text-red"><?= $flashMessage ?></p>
            <?php endif; ?>
            <?php foreach ($group->users() as $member) : ?>
            <div class="card-member">
                <div>
                    <h3><?=$member->fullName()?></h3>
                    <p><?=$member->email?></p>
                </div>
                <div class="card-member__actions">
                    <form id="formPerm<?=$member->id?>" method="POST" action="changePermission/<?=$member->id?>">
                        <select name="permission" <?=$member->getPermission($group->id) == 3 ? "disabled" : ""?> class="select select--primary" onchange="document.getElementById('formPerm<?=$member->id?>').submit()">
                            <?php if ($member->getPermission($group->id) == 3) : ?>
                                <option <?=$member->getPermission($group->id) == 3 ? "selected" : ""?>>Créateur</option>
                            <?php endif; ?>
                            <option value="1" <?=$member->getPermission($group->id) == 1 ? "selected" : ""?>>Lecteur</option>
                            <option value="2" <?=$member->getPermission($group->id) == 2 ? "selected" : ""?>>Editeur</option>
                        </select>
                    </form>
                    <?php if ($member->getPermission($group->id) != 3) : ?>
                    <a href="deleteMember/<?=$member->id?>" class="button button--outline">Supprimer</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
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
