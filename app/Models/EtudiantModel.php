<?php
    namespace App\Models;

    use CodeIgniter\Model;

    class EtudiantModel extends Model
    {
      protected $table = 'etudiant';
      protected $primaryKey = 'id';
      protected $allowedFields=['nom','prenom','matricule','id_semestre'];

        
    }