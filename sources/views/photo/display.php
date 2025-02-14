<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <section>
        <?php if (isset($photo->photo)):
            $imageData = base64_encode($photo->photo ?? ''); ?>
            <img src="<?= htmlspecialchars("data:image/jpeg;base64,{$imageData}"); ?>" alt="<?= htmlspecialchars($photo->label); ?>" width="700">
        <?php endif ?>
    </section>
</body>

</html>