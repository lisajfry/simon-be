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
                'first'          => true, // set sebagai kolom pertama
            ],
            'NIDN'               => [
                'type'           => 'INT', // Diasumsikan NIDN adalah tipe integer
                'constraint'     => 20,
                'null'           => true, // NIDN bisa null
            ],
            'NIDK'               => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'null'           => true, // NIDK bisa null
            ],
            'id_berkas'          => [
                'type'           => 'INT',
                'constraint'     => 20,
                'null'           => false, // NIDK bisa null
            ],
            'tanggal'            => [
                'type'           => 'DATE',
                'null'           => false, // NIDK bisa null
            ],
            'status'             => [
                'type'           => 'ENUM',
                'constraint'     => ['Dosen yang Memiliki Sertifikasi Kompetensi/Profesi', 'Dosen dari Kalangan Praktisi Profesional'],
                'null'           => false, // NIDK bisa null


            ],
            'bukti_pdf'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
        ]);


        $this->forge->addKey('iku4_id', true);




        $this->forge->addForeignKey('NIDN', 'dosen', 'NIDN', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('NIDK', 'dosenNIDK', 'NIDK', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_berkas', 'berkassertifikasi', 'id_berkas', 'CASCADE', 'CASCADE');
       
       
        $this->forge->createTable('iku4');
    }


    public function down()
    {
        $this->forge->dropTable('iku4');
    }
}
