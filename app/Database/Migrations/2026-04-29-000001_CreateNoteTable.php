<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNoteTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'etudiant_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'matiere_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'valeur' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['etudiant_id', 'matiere_id'], 'uq_note_etudiant_matiere');
        $this->forge->addKey('matiere_id');

        $this->forge->addForeignKey('etudiant_id', 'etudiant', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('matiere_id', 'matiere', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('note', true);
    }

    public function down()
    {
        $this->forge->dropTable('note', true);
    }
}
