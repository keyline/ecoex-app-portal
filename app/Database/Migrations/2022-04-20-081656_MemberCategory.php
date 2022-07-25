<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MemberCategory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'member_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'member_type'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addKey('member_id', true);
        $this->forge->createTable('ecoex_member_category');
    }

    public function down()
    {
        $this->forge->dropTable('ecoex_member_category');
    }
}
