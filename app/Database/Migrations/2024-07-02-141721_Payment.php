<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Payment extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'kode' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tanggal_payment' => [
                'type'    => 'DATETIME',
            ],
            'nis_siswa' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'nominal' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],
            'bertita' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                
            ],

        ]);
        
        $this->forge->addKey('kode', true);
        $this->forge->addForeignKey('nis_siswa', 'siswa', 'nis', 'CASCADE', '');
        $this->forge->createTable('payment');
    }

    public function down()
    {
        $this->forge->dropTable('payment');
    }
}
