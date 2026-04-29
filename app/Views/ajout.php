<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SysInfo — Gestion des Notes</title>
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

    <div class="sidebar-section">Saisie</div>
    <a href="<?= site_url('ajout') ?>" class="nav-item active">
      <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      Saisir les notes
    </a>
    <a href="<?= site_url('liste-etudiants') ?>" class="nav-item">
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
      <div class="topbar-title">Ajout des notes (0 à 20)</div>
    </div>

    <div class="content">
      <div class="page-header">
        <div>
          <h2>Gestion des notes</h2>
          <div class="breadcrumb">Accueil / <span>Notes</span></div>
        </div>
      </div>

      <?php if (! empty($success)): ?>
        <div class="alert alert-info" style="color:#15803d;background:rgba(34,197,94,.12)">
          <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
          <span style="font-weight:600"><?= esc($success) ?></span>
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

      <div class="form-card section-gap">
        <div class="form-section-title">1. Rechercher un étudiant</div>
        <form action="<?= site_url('ajout') ?>" method="get" style="display:flex;gap:12px;align-items:flex-end;max-width:500px">
          <div style="flex:1">
            <label class="field-label">Matricule <span class="required">*</span></label>
            <input type="text" id="matricule" name="matricule" value="<?= esc($matricule ?? '') ?>" required placeholder="Ex: 3909">
          </div>
          <button type="submit" class="btn btn-secondary">Afficher</button>
        </form>
      </div>

      <?php if (! empty($etudiant)): ?>
        <form action="<?= site_url('ajout') ?>" method="post">
          <?= csrf_field() ?>
          <input type="hidden" name="etudiant_id" value="<?= (int) $etudiant['id'] ?>">
          <input type="hidden" name="matricule" value="<?= esc($etudiant['matricule']) ?>">
          
          <div class="form-card section-gap">
            <div class="form-section-title">2. Informations de l'étudiant</div>
            <div class="form-grid">
              <div>
                <label class="field-label">Nom complet</label>
                <input type="text" value="<?= esc($etudiant['nom'] . ' ' . $etudiant['prenom']) ?>" readonly style="background:var(--c-input);color:var(--c-muted)">
              </div>
              <div>
                <label class="field-label">Informations universitaires</label>
                <input type="text" value="Matricule: <?= esc($etudiant['matricule']) ?> — Semestre <?= esc($etudiant['id_semestre']) ?>" readonly style="background:var(--c-input);color:var(--c-muted)">
              </div>
            </div>
          </div>

          <?php if (! empty($matieres)): ?>
            <div class="table-card section-gap" style="overflow:visible">
              <table>
                <thead>
                  <tr>
                    <th>Matricule</th>
                    <th>Matière</th>
                    <th>Coef</th>
                    <th style="width:200px">Note (0 - 20)</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($matieres as $matiere): ?>
                    <?php
                      $matiereId = (int) $matiere['id'];
                      $value = '';
                      if (is_array($postedNotes) && array_key_exists($matiereId, $postedNotes)) {
                        $value = (string) $postedNotes[$matiereId];
                      } elseif (array_key_exists($matiereId, $notesByMatiereId)) {
                        $value = (string) $notesByMatiereId[$matiereId];
                      }
                    ?>
                    <tr>
                      <td><strong><?= esc($matiere['matricule']) ?></strong></td>
                      <td><?= esc($matiere['nom']) ?></td>
                      <td><?= esc($matiere['coefficient']) ?></td>
                      <td style="padding:8px 16px">
                        <input 
                          type="number" 
                          name="notes[<?= $matiereId ?>]" 
                          min="0" max="20" step="0.01" 
                          value="<?= esc($value) ?>" 
                          placeholder="—"
                        >
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

            <div class="form-footer" style="padding-top:0;border:none">
              <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Enregistrer les notes
              </button>
            </div>
          <?php else: ?>
            <div class="alert alert-info">Aucune matière trouvée pour ce semestre.</div>
          <?php endif; ?>
        </form>
      <?php elseif (!empty($matricule)): ?>
          <!-- Error handled by the controller above -->
      <?php else: ?>
        <div class="alert alert-info">Veuillez entrer un matricule et valider pour saisir les notes.</div>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
