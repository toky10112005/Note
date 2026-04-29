<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SysInfo — Connexion</title>
  <link rel="stylesheet" href="<?= base_url('style.css') ?>" />
</head>
<body>

<div class="login-page">
  <div class="login-card">

    <div class="login-logo">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" width="22" height="22"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      </div>
      <div>
        <h1>NotesSys</h1>
        <span>Système de gestion de notes</span>
      </div>
    </div>

    <h2>Connexion</h2>
    <p class="subtitle">Connectez-vous pour continuer</p>

    <?php if (! empty($success)): ?>
      <div class="alert alert-info" style="color:#15803d;background:rgba(34,197,94,.12)">
        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        <span><?= esc($success) ?></span>
      </div>
    <?php endif; ?>

    <?php if (! empty($errors)): ?>
      <div class="alert alert-info" style="color:#b91c1c;background:rgba(239,68,68,.12)">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
        <ul style="margin:0;padding-left:18px">
          <?php foreach ($errors as $error): ?>
            <li><?= esc($error) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <?php if (! empty($username)): ?>
      <p style="margin-bottom:20px;font-size:13px;color:var(--c-muted)">
        Déjà connecté en tant que: <strong><?= esc($username) ?></strong>.
      </p>
    <?php endif; ?>

    <form action="<?= site_url('login') ?>" method="post">
      <?= csrf_field() ?>
      
      <div class="field-group">
        <label>Identifiant (Username)</label>
        <div class="input-wrap">
          <div class="icon">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"></circle><path d="M20 21a8 8 0 1 0-16 0"></path></svg>
          </div>
          <input type="text" id="username" name="username" placeholder="Entrez votre identifiant" value="<?= old('username') ?>" required />
        </div>
      </div>

      <button type="submit" class="btn btn-primary btn-full" style="margin-top:15px">
        <svg viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        Se connecter
      </button>
    </form>

    <script>
      (function () {
        const input = document.getElementById('username');
        if (!input) return;

        const storageKey = 'lastUsername';
        const stored = (localStorage.getItem(storageKey) || '').trim();

        if (input.value.trim() === '') {
          input.value = stored !== '' ? stored : 'test';
        }

        const form = input.closest('form');
        if (form) {
          form.addEventListener('submit', function () {
            const current = (input.value || '').trim();
            if (current !== '') {
              localStorage.setItem(storageKey, current);
            }
          });
        }
      })();
    </script>
  </div>
</div>

</body>
</html>
