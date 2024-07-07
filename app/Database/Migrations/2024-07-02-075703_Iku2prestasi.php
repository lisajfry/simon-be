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

            'tahun' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'NIDN' => [
                'type'           => 'INT',
                'constraint'     => 20,
            ],
            'nama_kompetisi' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'penyelenggara' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'tingkat_kompetisi' => [
                'type'           => 'ENUM',
                'constraint'     => ['internasional', 'nasional', 'provinsi'],
            ],
            'prestasi' => [
                'type'           => 'ENUM',
                'constraint'     => ['juara1', 'juara2', 'juara3', 'peserta'],
            ],
            'countries' => [
                'type'           => 'TEXT',
            ],
            'provinces' => [
                'type'           => 'TEXT',
            ],
            'jmlh_peserta' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'jmlh_provinsi_mengikuti' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'jmlh_negara_mengikuti' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'sertifikat' => [
                'type'           => 'TEXT',
            ],
            
        ]);

        $this->forge->addPrimaryKey('iku2prestasi_id');
        $this->forge->addForeignKey('NIM', 'mahasiswa', 'NIM', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('NIDN', 'dosen', 'NIDN', 'CASCADE', 'CASCADE');
        $this->forge->createTable('iku2prestasi');
    } 

    public function down()
    {
        $this->forge->dropTable('iku2prestasi');
    }
}
