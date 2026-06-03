<?php 
namespace App\Models;
use CodeIgniter\Model;

class Setting extends Model
{    
    protected $table = 'setting';
    protected $primaryKey = 'id';    
    protected $allowedFields = ['id','type','key','value','tooltip','is_delete','is_testdata','created_at','updated_at'];
}
