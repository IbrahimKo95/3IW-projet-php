<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <form class="modal__body__form" method="POST" action="/group/<?= $group->id ?>/addPhoto" enctype="multipart/form-data">
        <?php if (isset($flashMessage)) : ?>
            <p><?= $flashMessage ?></p>
        <?php endif; ?>

        <input placeholder="Image" type="file" name="file" id="file">
        <input placeholder="Label" type="text" name="label">
        <button class="button button--outline">
            Upload
        </button>
    </form>
</body>

</html>