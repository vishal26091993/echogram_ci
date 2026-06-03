<?php 
namespace App\Models;
use CodeIgniter\Model;

class Device_token extends Model
{    
    protected $table = 'device_token';
    protected $primaryKey = 'id';    
    protected $allowedFields = ['id','user_id','device_type','device_token','is_delete','is_testdata','created_at','updated_at'];
}
