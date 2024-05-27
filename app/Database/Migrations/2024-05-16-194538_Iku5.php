<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Iku5 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'iku5_id'            => [
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
            'nama_dosen'    => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'hasilkerjadosen' => [
                'type' => 'ENUM',
                'constraint' => ['Karya Tulis Ilmiah', 'Karya Terapan', 'Karya Seni'],
            ],
        ]);

        $this->forge->addKey('iku5_id', true);
        $this->forge->addForeignKey('NIDN','dosen', 'NIDN', 'CASCADE','CASCADE');


        $this->forge->createTable('iku5');
        
    }

    public function down()
    {
        $this->forge->dropTable('iku5');
    }
}