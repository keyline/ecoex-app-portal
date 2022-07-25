<?php namespace App\Models;
use CodeIgniter\Model;
class UserModel extends Model{
    protected $table ='ecoex_user_table';
    protected $primaryKey='user_id';
    protected $allowedFields =[
        'c_id',
        'user_email',
        'user_mobile',
        'user_membership_type',
        'user_sub_member_type',
        'user_password'
    ];
}
?>