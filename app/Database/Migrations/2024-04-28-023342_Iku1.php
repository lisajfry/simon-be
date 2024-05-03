<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Iku1 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'iku1_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'no_ijazah' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama_alumni' => [ // Menambahkan kolom nama_alumni
                'type' => 'VARCHAR',
                'constraint' => 100, // Sesuaikan constraint sesuai kebutuhan
            ],
            'status' => [
                'type' => 'ENUM("mendapat pekerjaan","melanjutkan studi","wiraswasta","mencari pekerjaan")',
                'null' => false,
            ],
            'gaji' => [
                'type' => 'ENUM("lebih dari 1.2xUMP","kurang dari 1.2xUMP","belum berpendapatan")',
                'null' => false,
            ],
            'masa_tunggu' => [
                'type' => 'ENUM("kurang dari 6 bulan","antara 6 sampai 12bulan")',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('iku1_id', true);
        $this->forge->addForeignKey('no_ijazah', 'lulusan', 'no_ijazah', 'CASCADE', 'CASCADE');

        $this->forge->createTable('iku1');
    }

    public function down()
    {
        $this->forge->dropTable('iku1');
    }
}
