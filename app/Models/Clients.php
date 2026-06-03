<?php

namespace App\Models;

use CodeIgniter\Model;

class Clients extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id',
        'name',
        'mobile',
        'password',
        'balance',
        'campaign_details',
        'account_details',
        'tc_file',
        'acceptance_letter',
        'isDelete',
        'createdAt',
        'updatedAt',
    ];
}
