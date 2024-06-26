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
            // 'NIDK'               => [
            //     'type'           => 'VARCHAR', // Diasumsikan NIDN adalah tipe integer
            //     'constraint'     => 20,
            // ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Dosen yang Memiliki Sertifikasi Kompetensi/Profesi', 'Dosen dari Kalangan Praktisi Profesional'],
            ],
            'bukti_pdf'               => [
                'type'           => 'VARCHAR', // Diasumsikan NIDN adalah tipe integer
                'constraint'     => 20,
            ],

        ]);

        $this->forge->addKey('iku4_id', true);
        $this->forge->addForeignKey('NIDN','dosen', 'NIDN', 'CASCADE','CASCADE');
        // $this->forge->addForeignKey('NIDK','dosenNIDK', 'NIDK', 'CASCADE','CASCADE');
        $this->forge->createTable('iku4');
        
        // Set auto-increment starting from 1000
    }

    public function down()
    {
        $this->forge->dropTable('iku4');
    }
}