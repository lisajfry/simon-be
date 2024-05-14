<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Iku3praktisi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'iku3praktisi_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'NIDN' => [
                'type' => 'INT',
                'constraint' => 20,
            ],
            'surat_sk' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'instansi_praktisi' =>[
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tgl_mulai_praktisi' =>[
                'type' => 'DATE',
            ],
            'tgl_selesai_praktisi' =>[
                'type' => 'DATE',
            ],
        ]);

        $this->forge->addKey('iku3praktisi_id', true); // Mengubah nama kunci utama menjadi 'iku3_id'
        $this->forge->addForeignKey('NIDN', 'dosen', 'NIDN', 'CASCADE', 'CASCADE');
        $this->forge->createTable('iku3praktisi');
    }

    public function down()
    {
        $this->forge->dropTable('iku3praktisi');
    }
}