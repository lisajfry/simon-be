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
                'type' => 'BIGINT',
                'constraint' => 11,  // Berikan constraint yang cukup besar
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
                'type' => 'ENUM("Ganjil","Genap")',
                'null' => false,
            ],
            'kelas' => [
                'type' => 'ENUM("A","B","C","D")',
                'null' => false,
            ],
            'case_method' => [
                'type' => 'INT',
                'constraint' => 3,
            ],
            'tb_project' => [
                'type' => 'INT',
                'constraint' => 3,
            ],
            'presentase_bobot' => [
                'type' => 'FLOAT',
                'null' => false,
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
