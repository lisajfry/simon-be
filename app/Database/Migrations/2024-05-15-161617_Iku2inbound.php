<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Iku2Inbound extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'iku2inbound_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'NIM' => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
            ],
            'asal_negara' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'asal_ptn' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'surat_rekomendasi' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'sks' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'tgl_mulai_inbound' =>[
                'type' => 'DATE',
            ],
            'tgl_selesai_inbound' =>[
                'type' => 'DATE',
            ],
        ]);

        $this->forge->addPrimaryKey('iku2inbound_id');
        $this->forge->addForeignKey('NIM', 'mahasiswa', 'NIM', 'CASCADE', 'CASCADE');
        $this->forge->createTable('iku2inbound');
    }

    public function down()
    {
        $this->forge->dropTable('iku2inbound');
    }
}