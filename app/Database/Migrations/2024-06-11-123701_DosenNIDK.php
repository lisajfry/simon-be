<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DosenNIDK extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'NIDK'               => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
            ],
            'nama_dosen'    => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
        ]);

        $this->forge->addKey('NIDK', true);
        $this->forge->createTable('dosenNIDK');
    }

    public function down()
    {
        $this->forge->dropTable('dosenNIDK');
    }
}