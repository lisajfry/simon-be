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
            'countries' => [ // Mengganti kolom negara menjadi countries
                'type'           => 'TEXT', // Gunakan tipe data yang sesuai
                'null'           => true, // Jika countries boleh kosong, atur ke true
            ],
            'provinces' => [ // Kolom untuk menyimpan provinsi
                'type'           => 'TEXT', // Gunakan tipe data yang sesuai
                'null'           => true, // Jika provinsi boleh kosong, atur ke true
            ],
            'jmlh_peserta' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => true,
            ],
            'jmlh_provinsi_mengikuti' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => true,
            ],
            'jmlh_negara_mengikuti' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => true,
            ],
            'sertifikat' => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'sk_penugasan' => [
                'type'           => 'TEXT',
                'null'           => true,
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
