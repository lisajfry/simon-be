<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Iku4 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'iku4_id'            => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
                'first'          => true, // set as first column
            ],
            'NIDN'               => [
                'type'           => 'INT', // Diasumsikan NIDN adalah tipe integer
                'constraint'     => 20,
            ],
            'nama_dosen'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Dosen Berkualifikasi S3', 'Sertifikasi Kompetensi Dosen', 'Praktisi Menjadi Dosen','Praktisi Mengajar (Flagship)'],
            ],
        ]);

        $this->forge->addKey('iku4_id', true);
        $this->forge->addForeignKey('NIDN','dosen', 'NIDN', 'CASCADE','CASCADE');

        $this->forge->createTable('iku4');
        
        // Set auto-increment starting from 1000
        $this->db->query('ALTER TABLE iku4 AUTO_INCREMENT = 1000');
    }

    public function down()
    {
        $this->forge->dropTable('iku4');
    }
}