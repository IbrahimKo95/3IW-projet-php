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

<div class="container mb-5">
    <h3>Select</h3>
    <select class="select select--primary">
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
    </select>
</div>

<div class="container mt-15 card-photo__container">
    <h3>CardPhoto</h3>
    <div class="card-photo">
        <img src="../src/images/photoTest.jpg" alt="Photo test" />
        <div class="card-photo__banner">
            <p class="card-photo__label">Photo test</p>
            <div class="card-photo__actions">
                <button class="fa-solid fa-trash button--wb" type="submit" onclick="return confirm('Voulez-vous vraiment supprimer cette photo ?');"></button>
                <div class="card-photo__visibility">
                    <select class="select--primary select" name="visibility" id="visibility" onchange="document.getElementById('visibilitySelect-<?= $photo->id ?>').submit();">
                        <option value="group" selected>Groupe uniquement</option>
                        <option value="public">Public (lien unique)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mb-10">
    <h3>Modal</h3>
    <button data-modal-target="openModal" class="button button--primary">Open modal</button>

    <div class="modal" id="openModal">
        <div class="modal__content">
            <button class="modal__close-btn" id="closeModalBtn">&times;</button>
            <h2 class="modal__title">Modal d'exemple</h2>
            <div class="modal__body" id="modalFormContent">
                <p style="color: red">Message d'erreur exemple</p>
                <form class="modal__body__form" method="POST" action="#">
                    <input required type="file">
                    <input required placeholder="Text" type="text">
                    <button class="button button--outline">
                        Ajouter
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>