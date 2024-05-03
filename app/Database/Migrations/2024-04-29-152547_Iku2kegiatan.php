<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Iku2kegiatan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'iku2kegiatan_id' => [
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
            'aktivitas' => [
                'type'           => 'ENUM',
                'constraint'     => ['magang/praktek kerja ', 'pertukaran pelajar', 'proyek kemanusiaan', 'mengajar di sekolah', 'studi/proyek independen', 'proyek di desa/kkn', 'kegiatan wirausaha', 'penelitian atau riset'],
            ],
            'sks' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
        ]);

        $this->forge->addPrimaryKey('iku2kegiatan_id');
        $this->forge->addForeignKey('NIM', 'mahasiswa', 'NIM', 'CASCADE', 'CASCADE');
        $this->forge->createTable('iku2kegiatan');
    }

    public function down()
    {
        $this->forge->dropTable('iku2kegiatan');
    }
}