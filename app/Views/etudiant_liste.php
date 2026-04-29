<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SysInfo — Liste des étudiants</title>
  <link rel="stylesheet" href="<?= base_url('style.css') ?>" />
</head>
<body>

<div class="app">
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      </div>
      <div>
        <div class="brand-name">NotesSys</div>
      </div>
    </div>

    <div class="sidebar-section">Menu</div>
    <a href="<?= site_url('ajout') ?>" class="nav-item">
      <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      Saisir les notes
    </a>
    <a href="<?= site_url('liste-etudiants') ?>" class="nav-item active">
      <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      Liste des étudiants
    </a>

    <div class="sidebar-bottom">
      <a href="<?= site_url('login') ?>" class="user-row" style="margin-bottom:0">
        <div class="avatar"><?= strtoupper(substr($connectedUsername ?? 'U', 0, 2)) ?></div>
        <div class="user-info">
          <div class="name"><?= esc($connectedUsername ?? '') ?></div>
          <div class="role" style="color:#ef4444">Déconnexion</div>
        </div>
      </a>
    </div>
  </aside>

  <div class="main">
    <div class="topbar">
      <div class="topbar-title">Liste des étudiants</div>
    </div>

    <div class="content">
      <div class="page-header" style="margin-bottom: 24px;">
        <div style="flex:1">
          <h2>Étudiants inscrits</h2>
          <div class="breadcrumb">Accueil / <span>Liste des étudiants</span></div>
        </div>
      </div>

      <div class="table-card">
        <table>
          <thead>
            <tr>
              <th class="sortable">Nom complet</th>
              <th class="sortable">Matricule</th>
              <th>Semestre</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($etudiants)): ?>
              <?php foreach ($etudiants as $etudiant): ?>
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:10px">
                    <div class="avatar-sm" style="background:#3b82f6;color:white;display:flex;align-items:center;justify-content:center;border-radius:6px;width:32px;height:32px;font-size:12px;font-weight:600;">
                      <?= strtoupper(substr($etudiant['prenom'], 0, 1) . substr($etudiant['nom'], 0, 1)) ?>
                    </div>
                    <div>
                      <div style="font-weight:600"><?= esc($etudiant['nom']) ?> <?= esc($etudiant['prenom']) ?></div>
                    </div>
                  </div>
                </td>
                <td style="color:var(--c-muted);font-family:monospace;font-weight:500;font-size:14px"><?= esc($etudiant['matricule']) ?></td>
                <td><span class="badge badge-blue">S<?= esc($etudiant['id_semestre']) ?></span></td>
                <td>
                  <div class="td-actions">
                    <a href="<?= site_url('ajout?matricule=' . esc($etudiant['matricule'])) ?>" class="action-btn" title="Gérer les notes" style="color:var(--c-primary);background:var(--c-primary-light);">
                      <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </a>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" style="text-align:center;padding:30px;color:var(--c-muted);">Aucun étudiant enregistré.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</body>
</html>
