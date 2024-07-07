<?php

namespace App\Database\Migrations; 

use CodeIgniter\Database\Migration;

class Iku5 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'iku5_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'NIDN' => [
                'type' => 'INT', 
                'constraint' => 20,
                'null' => true,
            ],
            'NIDK' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['mendapatkan rekognisi internasional', 'diterapkan di masyarakat/industri/pemerintah'],
                'null' => false,
            ], 
            'jenis_karya' => [
                'type' => 'ENUM',
                'constraint' => ['Karya Tulis Ilmiah', 'Karya Terapan', 'Karya Seni'],
                'null' => false,
            ],
            'kategori_karya' => [
                'type' => 'ENUM',
                'constraint' => [
                    'Artikel Ilmiah', 'Buku Akademik', 'Bab (chapter) dalam buku akademik', 'Karya rujukan', 'Studi kasus', 'Laporan penelitian untuk mitra',
                    'Karya Seni Visual', 'Karya Seni Audio', 'Karya Seni Audio-Visual', 'Karya Seni Pertunjukan',
                    'Karya Seni Desain', 'Karya Seni Novel', 'Karya Seni Sajak',
                    'Karya Seni Puisi', 'Karya Seni Notasi Musik', 'Karya Seni Preservasi'
                ],
                'null' => false,
            ],
            'judul_karya' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'pendanaan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'kriteria' => [
                'type' => 'ENUM',
                'constraint' => [
                    'buku referensi', 'jurnal internasional bereputasi', 'buku nasional/internasional yang mempunyai ISBN',
                    'book chapter internasional', 'jurnal nasional berbahasa inggris atau bahasa resmi PBB terindeks pada DOAJ', 'presiding internasional dalam seminar internasional', 'dalam bentuk monograf', 'hasil penelitian kerjasama industri termasuk penugasan dari kementerian atau LPNK yang tidak dipublikasikan',
                    'lainnya', 'diterapkan/digunakan/diaplikasikan pada Dunia Usaha dan Dunia Industri atau Masyarakat pada tingkat internasional atau Nasional', 'hasil Rancangan Teknologi/Seni yang dipatenkan secara internasional',
                    'belum diterapkan tetapi sudah mendapatkan ijin edar atau sudah terstandarisasi', 'hasil Rancangan Teknologi/Seni yang dipatenkan secara Nasional;', 'melaksanakan pengembangan hasil pendidikan dan penelitian',
                    'melaksanakan dan/atau menghasilkan karya seni atau kegiatan seni pada tingkat internasional',
                    'melaksanakan dan/atau menghasilkan karya seni atau kegiatan seni pada tingkat Nasional', 'melaksanakan penelitian di bidang seni yang dipatenkan atau dipublikasikan dalam seminar nasional',
                    'melaksanakan dan/atau menghasilkan karya seni atau kegiatan seni pada tingkat lokal', 'membuat rancangan karya seni atau kegiatan seni tingkat nasional', 'melaksanakan penelitian di bidang seni yang tidak dipatenkan atau dipublikasikan'
                ],
                'null' => false,
            ],
            'bukti_pendukung' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'tahun' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
        ]);

        $this->forge->addKey('iku5_id', true);
        $this->forge->addForeignKey('NIDN', 'dosen', 'NIDN', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('NIDK', 'dosenNIDK', 'NIDK', 'CASCADE', 'CASCADE');

        $this->forge->createTable('iku5');
    }

    public function down()
    {
        $this->forge->dropTable('iku5');
    }
}
