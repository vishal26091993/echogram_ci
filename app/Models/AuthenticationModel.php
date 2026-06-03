<?php 
namespace App\Models;
use CodeIgniter\Model;

class AuthenticationModel extends Model
{    
        protected $table = 'admin_users';
        protected $primaryKey = 'id';    
        protected $allowedFields = ['id','email','username','password','profileImage','forgotPassIdentity','rememberToken','phoneNumber','isEmailVerified','isAdmin','isActive','isTestData','isDelete','createdAt','updatedAt'];
} 


