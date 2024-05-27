<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Dosenpraktisi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'NIDN_praktisi'               => [
                'type'           => 'INT',
                'constraint'     => 20,
            ],
            'nama_dosen_praktisi'    => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
        ]);

        $this->forge->addKey('NIDN_praktisi', true);
        $this->forge->createTable('dosenpraktisi');
    }

    public function down()
    {
        $this->forge->dropTable('dosenpraktisi');
    }
}