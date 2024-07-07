<?php




namespace App\Database\Migrations;




use CodeIgniter\Database\Migration;




class Berkassertifikasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_berkas'          => [
                'type'           => 'INT',
                'constraint'     => 20,
            ],
            'nama_berkas'    => [
                'type'           => 'ENUM',
                'constraint' => ['Lembaga Sertifikasi Kompetensi (LSK)', 'Lembaga Sertifikasi Profesi (LSP)',
                                 'Lembaga atau Asosiasi Profesi atau Sertifikasi Internasional', 'Perusahaan Fortune 500',
                                 'Dunia Usaha Industri', 'Sertifikasi Profesi Dosen', 'Dari Kalangan Praktisi Profesional atau Dunia kerja'],
            ],
        ]);




        $this->forge->addKey('id_berkas', true);
        $this->forge->createTable('berkassertifikasi');
    }




    public function down()
    {
        $this->forge->dropTable('berkassertifikasi');
    }
}
