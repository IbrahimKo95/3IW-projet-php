<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <div class="container mt-15">
        <?php if (isset($photo->photo)):
            $imageData = base64_encode($photo->photo ?? ''); ?>
            <img src="<?= htmlspecialchars("data:image/jpeg;base64,{$imageData}"); ?>" alt="<?= htmlspecialchars($photo->label); ?>" width="1000">
        <?php endif ?>
    </div>
</body>

</html>