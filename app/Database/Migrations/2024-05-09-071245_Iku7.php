<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Iku7 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'iku7_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true
            ],            
            'Kode_MK' => [
                'type' => 'BIGINT',
                'constraint' => 20,
            ],
            'Nama_MK' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'Tahun' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'Semester' => [
                'type' => 'INT',
                'constraint' => 1,
            ],
            'Kelas' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'Presentase_Bobot_Terpenuhi' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'RPS' => [
                'type' => 'TEXT',
            ],
            'Rancangan_Tugas_Dan_Evaluasi' => [
                'type' => 'TEXT', 
            ],
        ]);

        $this->forge->addKey('iku7_id', true);
        $this->forge->createTable('iku7');
    }
    
    public function down()
    {
        $this->forge->dropTable('iku7');
    }
}