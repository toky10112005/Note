<?php

namespace App\Controllers;

use App\Models\EtudiantModel;
use App\Models\NoteModel;

class EtudiantController extends BaseController
{
    public function liste()
    {
        $session = session();
        if (! $session->get('username')) {
            return redirect()->to('/');
        }

        $etudiantModel = new EtudiantModel();
        $etudiants = $etudiantModel->findAll();

        $data = [
            'connectedUsername' => $session->get('username'),
            'etudiants' => $etudiants
        ];

        return view('etudiant_liste', $data);
    }
}
