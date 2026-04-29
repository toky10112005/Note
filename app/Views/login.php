<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
</head>
<body>

<?php if (! empty($success)): ?>
    <p><?= esc($success) ?></p>
<?php endif; ?>

<?php if (! empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (! empty($username)): ?>
    <p>Connecté en tant que: <strong><?= esc($username) ?></strong></p>
<?php else: ?>
    <form action="<?= site_url('login') ?>" method="post">
        <?= csrf_field() ?>
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?= old('username') ?>" required>
        <button type="submit">Valider</button>
    </form>
<?php endif; ?>

</body>
</html>
