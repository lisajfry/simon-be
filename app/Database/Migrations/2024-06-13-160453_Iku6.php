<?php


namespace App\Database\Migrations;


use CodeIgniter\Database\Migration;


class Iku6 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'iku6_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'auto_increment' => true
            ],            
            'nama_mitra' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nama_kegiatan' => [ // perhatikan nama_kriteria sekarang telah diubah menjadi nama_kegiatan
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'alamat_mitra' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tgl_mulai_kegiatan' =>[
                'type' => 'DATE',
            ],
            'tgl_selesai_kegiatan' =>[
                'type' => 'DATE',
            ],
            'kriteria_mitra' => [
                'type' => 'ENUM',
                'constraint' => ["perusahaan multinasional",
                                "perusahaan nasional berstandar tinggi, BUMN, dan/atau BUMD",
                                "perusahaan teknologi global",
                                "perusahaan rintisan (startup company) teknologi",
                                "organisasi nirlaba kelas dunia",
                                "institusi/organisasi multilateral",
                                "perguruan tinggi yang masuk dalam daftar QS200 berdasarkan bidang ilmu (QS200 by subject) perguruan tinggi luar negeri",
                                "perguruan tinggi yang masuk dalam daftar QS200 berdasarkan bidang ilmu (QS200 by subject) perguruan tinggi dalam negeri",
                                "instansi pemerintah",
                                "rumah sakit",
                                "lembaga riset pemerintah, swasta, nasional, maupun internasional",
                                "lembaga kebudayaan berskala nasional/bereputasi"],
                'null' => false,
            ],
            'mou' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);


        $this->forge->addKey('iku6_id', true);
        $this->forge->createTable('iku6');
    }


    public function down()
    {
        $this->forge->dropTable('iku6');
    }
}
