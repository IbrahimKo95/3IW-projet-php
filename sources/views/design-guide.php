<div class="container py-5">
    <h2>Design Guide</h2>
</div>

<div class="container mb-10">
    <h3>Card</h3>
    <div class="card">
        <div class="card__titleBar">
            <p>Title</p>
            <div>
                <button class="button button--primary"><i class="fa-solid fa-plus"></i>Button</button>
            </div>
        </div>
        <div>
            <p>Content</p>
        </div>
    </div>
</div>

<div class="container mb-10">
    <h3>TitleBar</h3>
    <div class="title-bar">
        <h1>Mes groupes</h1>
        <div class="title-bar__buttons">
            <button data-modal-target="createGroupModal" class="button button--primary"><i class="fa-solid fa-plus"></i>Create a group</button>
        </div>
    </div>
</div>

<div class="container mb-10">
    <h3>CardGroup</h3>
    <div class="container mt-15 card-group__container">
        <div class="card-group">
            <h2 class="card-group__title">Test</h2>
            <div class="card-group__content">
                <p><i class="fa-solid fa-user-group"></i>10 membres</p>
                <p><i class="fa-solid fa-image"></i>40 photos</p>
            </div>
            <div class="card-group__footer">
                <a href="#" class="button button--primary">Voir le groupe</a>
            </div>
        </div>
    </div>
</div>

<div class="container mb-10">
    <h3>CardMember</h3>
    <div class="card-member">
        <div>
            <h3>John Doe</h3>
            <p>john.doe@gmail.com</p>
        </div>
        <div class="card-member__actions">
            <a href="#" class="button button--outline">Supprimer</a>
        </div>
    </div>
</div>

<div class="container mb-10">
    <h3>Form</h3>
    <form class="form">
        <div class="form__group">
            <label for="email">Adresse email</label>
            <input id="email" type="email" name="email">
        </div>
        <div class="form__group">
            <label for="password">Mot de passe</label>
            <input id="password" type="password" name="password">
    </form>
</div>