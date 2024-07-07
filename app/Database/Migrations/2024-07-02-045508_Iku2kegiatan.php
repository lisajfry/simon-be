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
            'semester' => [
                'type' => 'ENUM("4","5")',
                'null' => false,
            ],
            'tahun' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'aktivitas' => [
                'type'           => 'ENUM',
                'constraint'     => ['magang/praktek kerja ', 'proyek kemanusiaan', 'mengajar di sekolah', 'studi/proyek independen', 'proyek di desa/kkn', 'kegiatan wirausaha', 'penelitian atau riset'],
            ],
            'tempat_kegiatan' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'sks' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'tgl_mulai_kegiatan' =>[
                'type' => 'DATE',
            ],
            'tgl_selesai_kegiatan' =>[
                'type' => 'DATE',
            ],
            'NIDN' => [
                'type'           => 'INT',
                'constraint'     => 20,
            ]
        ]);

        $this->forge->addPrimaryKey('iku2kegiatan_id');
        $this->forge->addForeignKey('NIM', 'mahasiswa', 'NIM', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('NIDN', 'dosen', 'NIDN', 'CASCADE', 'CASCADE');
        $this->forge->createTable('iku2kegiatan');
    }

    public function down()
    {
        $this->forge->dropTable('iku2kegiatan');
    }
}