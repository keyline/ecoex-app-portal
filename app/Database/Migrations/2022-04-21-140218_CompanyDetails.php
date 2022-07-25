<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CompanyDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'company_details_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'c_id'       => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'c_pan'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'c_pan_file'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'c_gst'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'c_gst_file'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'c_business_category'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],            
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addKey('company_details_id', true);
        $this->forge->createTable('ecoex_company_details');
    }

    public function down()
    {
        $this->forge->dropTable('ecoex_company_details');
    }
}
