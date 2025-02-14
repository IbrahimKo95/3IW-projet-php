<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <form method="POST" action="/group/<?= $group->id ?>/addPhoto" enctype="multipart/form-data">
        <?php if (isset($flashMessage)) : ?>
            <p><?= $flashMessage ?></p>
        <?php endif; ?>

        <input type="file" name="file" id="file">
        <input type="text" name="label">
        <button>
            Upload
        </button>
    </form>
</body>

</html>