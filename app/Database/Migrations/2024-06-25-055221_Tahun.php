<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateYearsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tahun' => [
                'type' => 'YEAR',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('years');
    }

    public function down()
    {
        $this->forge->dropTable('years');
    }
}
