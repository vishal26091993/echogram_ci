<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactNumberModel extends Model
{
    protected $table = 'contact_numbers';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'contact_list_id',
        'mobile',
    ];
}
