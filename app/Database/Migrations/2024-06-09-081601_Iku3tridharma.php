<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Iku3tridharma extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'iku3tridharma_id' => [
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
            'jenis_tridharma' => [
                'type'           => 'ENUM',
                'constraint'     => ['pendidikan', 'penelitian', 'pengabdian kepada masyarakat'],
            ],
            'nama_aktivitas_tridharma' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'tempat_tridharma' =>[
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tgl_mulai_tridharma' =>[
                'type' => 'DATE',
            ],
            'tgl_selesai_tridharma' =>[
                'type' => 'DATE',
            ],
        ]);

        $this->forge->addKey('iku3tridharma_id', true); // Mengubah nama kunci utama menjadi 'iku3_id'
        $this->forge->addForeignKey('NIDN', 'dosen', 'NIDN', 'CASCADE', 'CASCADE');
        $this->forge->createTable('iku3tridharma');
    }

    public function down()
    {
        $this->forge->dropTable('iku3tridharma');
    }
}