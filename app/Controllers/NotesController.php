<?php

namespace App\Controllers;

use App\Models\EtudiantModel;
use App\Models\MatiereModel;
use App\Models\NoteModel;

class NotesController extends BaseController
{
    public function ajout()
    {
        $session = session();
        if (! $session->get('username')) {
            return redirect()->to('/');
        }

        $data = [
            'connectedUsername' => $session->get('username'),
            'success'           => $session->getFlashdata('success'),
            'errors'            => [],
            'matricule'         => '',
            'etudiant'          => null,
            'matieres'          => [],
            'notesByMatiereId'  => [],
            'postedNotes'       => null,
        ];

        $etudiantModel = new EtudiantModel();
        $matiereModel  = new MatiereModel();
        $noteModel     = new NoteModel();

        if (strtolower($this->request->getMethod()) === 'post') {
            $postedNotes = $this->request->getPost('notes');
            $etudiantId  = $this->request->getPost('etudiant_id');

            // Save notes mode
            if (! empty($etudiantId) && is_array($postedNotes)) {
                $data['postedNotes'] = $postedNotes;
                $data['matricule']   = trim((string) $this->request->getPost('matricule'));

                $etudiant = $etudiantModel->find((int) $etudiantId);
                if (! $etudiant) {
                    $data['errors'][] = "Étudiant introuvable.";
                } else {
                    $data['etudiant'] = $etudiant;

                    $errors = [];
                    foreach ($postedNotes as $matiereId => $rawValue) {
                        $matiereId = (int) $matiereId;
                        $valueStr = trim((string) $rawValue);

                        if ($valueStr === '') {
                            // Empty => delete
                            $existing = $noteModel
                                ->where('etudiant_id', (int) $etudiantId)
                                ->where('matiere_id', $matiereId)
                                ->first();

                            if ($existing) {
                                $noteModel->delete($existing['id']);
                            }
                            continue;
                        }

                        if (! is_numeric($valueStr)) {
                            $errors[] = "Note invalide pour la matière #{$matiereId}.";
                            continue;
                        }

                        $valeur = (float) $valueStr;
                        if ($valeur < 0 || $valeur > 20) {
                            $errors[] = "La note doit être entre 0 et 20 (matière #{$matiereId}).";
                            continue;
                        }

                        $existing = $noteModel
                            ->where('etudiant_id', (int) $etudiantId)
                            ->where('matiere_id', $matiereId)
                            ->first();

                        if ($existing) {
                            $noteModel->update($existing['id'], ['valeur' => $valeur]);
                        } else {
                            $noteModel->insert([
                                'etudiant_id' => (int) $etudiantId,
                                'matiere_id'  => $matiereId,
                                'valeur'      => $valeur,
                            ]);
                        }
                    }

                    if ($errors) {
                        $data['errors'] = $errors;
                    } else {
                        $session->setFlashdata('success', 'Notes enregistrées.');
                        return redirect()->to('/ajout?matricule=' . rawurlencode($data['matricule']));
                    }
                }
            } else {
                // Search mode
                $data['matricule'] = trim((string) $this->request->getPost('matricule'));

                if ($data['matricule'] === '') {
                    $data['errors'][] = 'Le matricule est obligatoire.';
                } else {
                    $etudiant = $etudiantModel->where('matricule', $data['matricule'])->first();
                    if (! $etudiant) {
                        $data['errors'][] = 'Aucun étudiant trouvé pour ce matricule.';
                    } else {
                        $data['etudiant'] = $etudiant;
                    }
                }
            }
        } else {

       
            // GET with previous matricule (flashdata or query)
            $data['matricule'] = trim((string) ($session->getFlashdata('matricule') ?? $this->request->getGet('matricule') ?? ''));
            if ($data['matricule'] !== '') {
                $etudiant = $etudiantModel->where('matricule', $data['matricule'])->first();
                if ($etudiant) {
                    $data['etudiant'] = $etudiant;
                }
            }
        }

        if ($data['etudiant']) {
            $matieres = $matiereModel->where('id_Semestre', (int) $data['etudiant']['id_semestre'])->findAll();
            $data['matieres'] = $matieres;

            try {
                $existingNotes = $noteModel->where('etudiant_id', (int) $data['etudiant']['id'])->findAll();
                $map = [];
                foreach ($existingNotes as $note) {
                    $map[(int) $note['matiere_id']] = $note['valeur'];
                }
                $data['notesByMatiereId'] = $map;
            } catch (\Throwable $e) {
                log_message('error', 'Notes DB error: ' . $e->getMessage());
                $data['errors'][] = "Impossible de charger/enregistrer les notes: table 'note' inexistante. Lance `php spark migrate` ou réimporte DataNote.sql.";
            }
        }

        return view('ajout', $data);
    }
}
