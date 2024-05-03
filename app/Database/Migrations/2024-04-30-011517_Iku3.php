<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Iku3 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'iku3_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'NIDN' => [
                'type' => 'INT',
                'constraint' => 20,
            ],
            'nama_dosen' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'aktivitas_dosen' => [
                'type' => 'ENUM("Bertridharma di Kampus Lain", "Memiliki Pengalaman Sebagai Praktisi", "Membimbing Mahasiswa Berprestasi")',
            ],
        ]);

        $this->forge->addKey('iku3_id', true); // Mengubah nama kunci utama menjadi 'iku3_id'
        $this->forge->addForeignKey('NIDN', 'dosen', 'NIDN', 'CASCADE', 'CASCADE');
        $this->forge->createTable('iku3');
    }

    public function down()
    {
        $this->forge->dropTable('iku3');
    }
}
