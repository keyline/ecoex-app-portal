<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'c_id'       => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'user_name'       => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'user_email'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'user_email_auth'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'user_email_verified_at'       => [
                'type'       => 'datetime',
            ],
            'user_alternate_email'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'user_mobile'       => [
                'type'       => 'bigint',
                'constraint' => 11,
            ],
            'user_mobile_auth'       => [
                'type'       => 'int',
            ],
            'user_mobile_verified_at'       => [
                'type'       => 'datetime',
            ],
            'user_alternative_mobile'       => [
                'type'       => 'bigint',
                'constraint' => 11,
            ],
            'user_membership_type'       => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'user_role_type'       => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addKey('user_id', true);
        $this->forge->createTable('ecoex_user_table');
    }

    public function down()
    {
        $this->forge->dropTable('ecoex_user_table');
    }
}
