<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajout des notes</title>
</head>
<body>

<p>Utilisateur: <strong><?= esc($connectedUsername ?? '') ?></strong></p>

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

<h2>Rechercher un étudiant</h2>
<form action="<?= site_url('ajout') ?>" method="get">
    <?= csrf_field() ?>
    <label for="matricule">Matricule</label>
    <input type="text" id="matricule" name="matricule" value="<?= esc($matricule ?? '') ?>" required>
    <button type="submit">Afficher les matières</button>
</form>

<?php if (! empty($etudiant)) { ?>
    <hr>
    <h3>Étudiant</h3>
    <p>
        <strong><?= esc($etudiant['nom'] . ' ' . $etudiant['prenom']) ?></strong>
        (Matricule: <?= esc($etudiant['matricule']) ?>)
        — Semestre: <?= esc($etudiant['id_semestre']) ?>
    </p>

    <h2>Notes par matière (0 à 20)</h2>
    <form action="<?= site_url('ajout') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="etudiant_id" value="<?= (int) $etudiant['id'] ?>">
        <input type="hidden" name="matricule" value="<?= esc($etudiant['matricule']) ?>">

        <table border="1" cellpadding="6" cellspacing="0">
            <thead>
            <tr>
                <th>Matière</th>
                <th>Coefficient</th>
                <th>Note</th>
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
                    <td><?= esc($matiere['matricule'] . ' - ' . $matiere['nom']) ?></td>
                    <td><?= esc($matiere['coefficient']) ?></td>
                    <td>
                        <input
                            type="number"
                            name="notes[<?= $matiereId ?>]"
                            min="0"
                            max="20"
                            step="0.01"
                            value="<?= esc($value) ?>"
                        >
                        <small>(laisser vide pour supprimer)</small>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit">Enregistrer</button>
    </form>
<?php }
else{
    echo "<p>Veuillez rechercher un étudiant pour afficher les matières.</p>";
}?>

</body>
</html>
