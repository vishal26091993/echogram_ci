<?php 
namespace App\Models;
use CodeIgniter\Model;

class Users extends Model
{    
        protected $table = 'users';
        protected $primaryKey = 'id';    
        protected $allowedFields = ['id','name','email','password','phoneNumber','profile','accountType','isDelete','createdAt','updatedAt'];
}


          