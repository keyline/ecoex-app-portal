<?php namespace App\Models;

use CodeIgniter\Model;

class MemberType extends Model{

    protected $table ='ecoex_member_category';
    protected $primaryKey='member_id';
    protected $allowedFields =[
        'member_type',
        'created_at',
        'updated_at'     
    ];
}

?>