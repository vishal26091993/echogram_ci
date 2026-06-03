<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactListModel extends Model
{
    protected $table = 'contact_lists';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'client_id',
        'list_name',
        'total_numbers',
    ];
}
