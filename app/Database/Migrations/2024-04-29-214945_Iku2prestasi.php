<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Iku2prestasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'iku2prestasi_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'NIM' => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
            ],
            'nama_mahasiswa' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'angkatan' => [
                'type'           => 'ENUM',
                'constraint'     => ['2021', '2022', '2023'],
            ],
            'tingkat_lomba' => [
                'type'           => 'ENUM',
                'constraint'     => ['internasional', 'nasional', 'provinsi', 'peserta'],
            ],
            'prestasi' => [
                'type'           => 'ENUM',
                'constraint'     => ['juara1', 'juara2', 'juara3', 'peserta'],
            ],
        ]);

        $this->forge->addPrimaryKey('iku2prestasi_id');
        $this->forge->addForeignKey('NIM', 'mahasiswa', 'NIM', 'CASCADE', 'CASCADE');
        $this->forge->createTable('iku2prestasi');
    }

    public function down()
    {
        $this->forge->dropTable('iku2prestasi');
    }
}