<?php

namespace App\Controllers;

use App\Models\Users;

class Api extends BaseController
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();

        $this->users = new Users();

        date_default_timezone_set('Asia/Kolkata');
    }

    public function clientLogin()
    {
        $db = \Config\Database::connect();

        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey ? $apiKey->getValue() : '';

        $xkey = $db->table('x_api_key')->get()->getRow();
        $x_api_key = $xkey ? $xkey->x_api_key : '';

        if ($apiKeyValue != $x_api_key) {
            return $this->response->setJSON([
                'message' => 'fail',
                'result' => '',
                'error_msg' => 'Api Token Not Matched',
            ]);
        }

        $mobile = trim($this->request->getPost('mobile'));
        $password = trim($this->request->getPost('password'));

        if (empty($mobile) || empty($password)) {
            return $this->response->setJSON([
                'message' => 'fail',
                'result' => '',
                'error_msg' => 'Please enter mobile and password',
            ]);
        }

        $password = base64_encode($password);

        $client = $db->table('clients')
            ->where('mobile', $mobile)
            ->where('password', $password)
            ->where('isDelete', '0')
            ->get()
            ->getRowArray();

        if (!$client) {
            return $this->response->setJSON([
                'message' => 'fail',
                'result' => '',
                'error_msg' => 'Invalid mobile or password',
            ]);
        }

        unset($client['password']);

        return $this->response->setJSON([
            'message' => 'success',
            'result' => $client,
            'error_msg' => 'Login Successfully',
        ]);
    }

    public function getContactLists()
    {
        $clientId = $this->request->getPost('client_id');

        if (empty($clientId)) {
            return $this->response->setJSON([
                'message' => 'fail',
                'result' => '',
                'error_msg' => 'Client ID required',
            ]);
        }

        $lists = $this->db
            ->table('contact_lists')
            ->where('client_id', $clientId)
            ->orderBy('id', 'DESC')
            ->get()
            ->getResult();

        $data = [];

        foreach ($lists as $row) {
            $data[] = [
                'id' => $row->id,
                'list_name' => $row->list_name,
                'total_numbers' => $row->total_numbers,
                'created_at' => $row->created_at,
            ];
        }

        return $this->response->setJSON([
            'message' => 'success',
            'result' => [
                'contact_lists' => $data,
            ],
            'error_msg' => 'Contact Lists',
        ]);
    }

    public function getContactNumbers()
    {
        $listId = $this->request->getPost('contact_list_id');

        if (empty($listId)) {
            return $this->response->setJSON([
                'message' => 'fail',
                'result' => '',
                'error_msg' => 'Contact List ID required',
            ]);
        }

        $numbers = $this->db
            ->table('contact_numbers')
            ->where('contact_list_id', $listId)
            ->orderBy('id', 'ASC')
            ->get()
            ->getResult();

        $data = [];

        foreach ($numbers as $row) {
            $data[] = [
                'id' => $row->id,
                'mobile' => $row->mobile,
            ];
        }

        return $this->response->setJSON([
            'message' => 'success',
            'result' => [
                'contact_numbers' => $data,
            ],
            'error_msg' => 'Contact Numbers',
        ]);
    }

    /* public function labour_add()
     {
         $db = \Config\Database::connect();

         // Retrieve API Key from the request header
         $apiKey = $this->request->getHeader('X-API-KEY');
         $apiKeyValue = $apiKey->getValue();

         // Fetch the stored API Key from the database
         $fetchxkeyQuery = $db->query('SELECT * FROM x_api_key');
         $xkey = $fetchxkeyQuery->getRow();
         $x_api_key = $xkey->x_api_key;

         if ($apiKeyValue == $x_api_key) {
             // Get required fields
             $labourName = $this->request->getVar('labourName');
             $siteId = $this->request->getVar('siteId');
             // $labourId = $this->request->getVar('labourId');
             $mobileNo = $this->request->getVar('mobileNo');
             $gender = $this->request->getVar('gender');
             $dailyWiseAmount = $this->request->getVar('dailyWiseAmount');

             $currentDate = date('Y-m-d H:i:s');

             // ---------- Insert into material_requisiution_request table ----------
             $materialData = [
                 'labourName' => $labourName,
                 'siteId' => $siteId,
                 'mobileNo' => $mobileNo,
                 'gender' => $gender,
                 'dailyWiseAmount' => $dailyWiseAmount,
                 'isTestData' => 0,
                 'isDelete' => 0,
                 'createdAt' => $currentDate,
             ];

             $db->table('labour')->insert($materialData);
             $requestId = $db->insertID();  // inserted ID

             $materialDataResponse = [
                 'labourName' => $labourName,
                 'siteId' => $siteId,
                 'labourId' => $requestId,
                 'mobileNo' => $mobileNo,
                 'gender' => $gender,
                 'dailyWiseAmount' => $dailyWiseAmount,
                 'isTestData' => 0,
                 'isDelete' => 0,
                 'createdAt' => $currentDate,
             ];
             // Response
             $result = [
                 'message' => 'Success',
                 'result' => $materialDataResponse,
                 'error_msg' => 'Labour Added Successfully',
             ];
         } else {
             $result = [
                 'message' => 'fail',
                 'result' => '',
                 'error_msg' => 'Api Token Not Matched',
             ];
         }

         echo json_encode($result);
     }

     public function get_dashboard()
     {
         $db = \Config\Database::connect();

         // ---------------------------------
         // Validate API Key
         // ---------------------------------
         $apiKey = $this->request->getHeader('X-API-KEY');
         $apiKeyValue = $apiKey->getValue();

         $xkey = $db->query('SELECT x_api_key FROM x_api_key')->getRow();
         if (!$xkey || $apiKeyValue != $xkey->x_api_key) {
             return $this->response->setJSON([
                 'message' => 'fail',
                 'result' => '',
                 'error_msg' => 'Api Token Not Matched',
             ]);
         }

         // ---------------------------------
         // INPUT
         // ---------------------------------
         $userId = $this->request->getVar('userId');
         if (!$userId) {
             return $this->response->setJSON([
                 'message' => 'fail',
                 'result' => '',
                 'error_msg' => 'userId is required',
             ]);
         }

         // ---------------------------------
         // FETCH SITES + MULTIPLE CLIENTS
         // ---------------------------------
         $builder = $db->table('sites s');
         $builder->select('
                 s.id AS siteId,
                 s.siteName,
                 s.location,
                 s.status,

                 c.id AS clientId,
                 c.name AS clientName,
                 c.email AS clientEmail,
                 c.phoneNumber AS clientPhone,
                 c.address AS clientAddress
             ');

         $builder->join('site_technicians st', 'st.siteId = s.id');
         $builder->join('site_clients sc', 'sc.siteId = s.id', 'left');
         $builder->join('clients c', 'c.id = sc.clientId', 'left');

         $builder->where('st.userId', $userId);
         $builder->where('s.isDelete', 0);
         $builder->where('st.isDelete', 0);
         $builder->where('sc.isDelete', 0);

         $rows = $builder->get()->getResult();

         // ---------------------------------
         // GROUP SITES + CLIENTS
         // ---------------------------------
         $grouped = [];

         foreach ($rows as $row) {
             // --- ADD STATUS LOGIC ---
             $statusLabel = ($row->status == 0) ? 'Active' : 'Completed';
             $statusColor = ($row->status == 0) ? '#0CD2A4' : '#D2440C';

             $siteId = $row->siteId;

             if (!isset($grouped[$siteId])) {
                 $grouped[$siteId] = [
                     'siteDetails' => [
                         'siteId' => $row->siteId,
                         'siteName' => $row->siteName,
                         'location' => $row->location,
                         'status' => $row->status,
                         'statusLabel' => $statusLabel,
                         'statusColor' => $statusColor,
                     ],
                     'clients' => [],
                 ];
             }

             if (!empty($row->clientId)) {
                 $grouped[$siteId]['clients'][] = [
                     'clientId' => $row->clientId,
                     'name' => $row->clientName,
                     'email' => $row->clientEmail,
                     'phoneNumber' => $row->clientPhone,
                     'address' => $row->clientAddress,
                 ];
             }
         }

         $final = array_values($grouped);

         // ---------------------------------
         // RESPONSE
         // ---------------------------------
         return $this->response->setJSON([
             'message' => 'Success',
             'result' => ['dashboard' => $final],
             'error_msg' => 'Dashboard List',
         ]);
     } */
}
