<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mahasiswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'NIM'               => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
            ],
            'nama_mahasiswa'    => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'angkatan'    => [
                'type'           => 'ENUM',
                'constraint'     => ['TI 2020','TI 2021','TI 2022','TI 2023'],
            ],
            'keterangan'    => [
                'type'           => 'ENUM',
                'constraint'     => ['lulus','mahasiswa aktif'],
            ],
        ]);

        $this->forge->addKey('NIM', true);
        $this->forge->createTable('mahasiswa');
    }

    public function down()
    {
        $this->forge->dropTable('mahasiswa');
    }
}
