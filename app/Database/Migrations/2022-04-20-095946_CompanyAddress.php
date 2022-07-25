<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CompanyAddress extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'company_address_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'c_id'       => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'c_country'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'c_state'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'c_city'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'c_district'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'c_pincode'       => [
                'type'       => 'bigint',
                'constraint' => 11,
            ],
            'c_full_address'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addKey('company_address_id', true);
        $this->forge->createTable('ecoex_company_address');
    }

    public function down()
    {
        $this->forge->dropTable('ecoex_company_address');
    }
}
