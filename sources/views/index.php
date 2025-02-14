<div class="container mt-15">
    <div class="title-bar">
        <h1>Mes groupes</h1>
        <div class="title-bar__buttons">
            <button id="openModal" class="button button--primary"><i class="fa-solid fa-plus"></i>Create a group</button>
        </div>
    </div>
</div>
<div class="container mt-15 card-group__container">
    <?php foreach ($groups as $group) : ?>
    <div class="card-group">
        <h2 class="card-group__title"><?=$group->name?></h2>
        <div class="card-group__content">
            <p><i class="fa-solid fa-user-group"></i><?=count($group->users())?> membres</p>
            <p><i class="fa-solid fa-image"></i>10 photos</p>
        </div>
        <div class="card-group__footer">
            <a href="/group/<?=$group->id?>" class="button button--primary">Voir le groupe</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>