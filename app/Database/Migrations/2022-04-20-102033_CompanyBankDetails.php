<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CompanyBankDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'company_bank_id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'c_id'       => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'c_account_type'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'c_ifsc'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'c_bank_name'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'c_branch_name'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'c_acct_holder_name'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'c_account_no'       => [
                'type'       => 'bigint',
                'constraint' => 255,
            ],
            'c_re_account_no'       => [
                'type'       => 'bigint',
                'constraint' => 255,
            ],
            'c_cancelled_cheque'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'c_micr_code'       => [
                'type'       => 'bigint',
                'constraint' => 255,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp',
        ]);
        $this->forge->addKey('company_bank_id', true);
        $this->forge->createTable('ecoex_company_bank_details');
    }

    public function down()
    {
        $this->forge->dropTable('ecoex_company_bank_details');
    }
}
