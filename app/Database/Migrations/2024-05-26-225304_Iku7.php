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
            'kode_mk' => [
                'type' => 'INT',
                'constraint' => 20,
            ],
            'nama_mk' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tahun' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'semester' => [
                'type' => 'ENUM("1","2","3","4","5","6")',
                'null' => false,
            ],
            'kelas' => [
                'type' => 'ENUM("A","B","C","D")',
                'null' => false,
            ],
            'jum_bobot' => [
                'type' => 'INT',
                'constraint' => 3,
            ],
            'rps' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
