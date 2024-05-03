<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lulusan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'no_ijazah'               => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
            ],
            'nama_alumni'    => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
        ]);

        $this->forge->addKey('no_ijazah', true);
        $this->forge->createTable('lulusan');
    }

    public function down()
    {
        $this->forge->dropTable('lulusan');
    }
}