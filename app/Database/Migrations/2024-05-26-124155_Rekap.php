<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rekap extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'rekap_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'indikator'               => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'target'               => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
        ]);

        $this->forge->addKey('rekap_id', true);

        $this->forge->createTable('rekap');
    }

    public function down()
    {
        $this->forge->dropTable('rekap');
    }
}