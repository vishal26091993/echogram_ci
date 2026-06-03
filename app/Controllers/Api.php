<?php

namespace App\Controllers;
use App\Models\AuthenticationModel;
use App\Models\Users;


class Api extends BaseController
{
    
    public function __construct()
    {
       $this->db = \Config\Database::connect();
 
       $this->users = new Users();
       
       date_default_timezone_set('Asia/Kolkata');
    }
    
    public function userLogin()
    {
        $db = \Config\Database::connect();  
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey ? $apiKey->getValue() : '';
    
        $fetchxkeyQuery = $db->query("SELECT * FROM x_api_key");
        $xkey = $fetchxkeyQuery->getRow();
        $x_api_key = $xkey ? $xkey->x_api_key : '';
    
        if ($apiKeyValue == $x_api_key) {
            $mobile_number = $this->request->getPost('mobile_number');
            $password = $this->request->getPost('password');
            $base64pass = base64_encode($password);
    
            if (!empty($mobile_number) && !empty($password)) { 
                $passQuery = $db->query(
                    "SELECT * FROM users WHERE phoneNumber = ? AND password = ? AND isDelete = ?",
                    [$mobile_number, $base64pass, '0']
                );
                $passData = $passQuery->getRow();
    
                if ($passData) {
                    // Convert to array for easy modification
                    $userData = (array) $passData;
    
                    // Remove password
                    unset($userData['password']);
    
                    // Add full profile URL
                    if (!empty($userData['profile'])) {
                        $userData['profile'] = base_url('uploads/user_profile/' . $userData['profile']);
                    } else {
                        $userData['profile'] = base_url('profile/default.png'); // fallback image
                    }
    
                    $result = [
                        'message'   => 'success',
                        'result'    => $userData,
                        'error_msg' => 'Login Successfully'
                    ];
                } else {
                    $result = [
                        'message'   => 'fail',
                        'result'    => '',
                        'error_msg' => 'Enter valid username or password'
                    ];
                }
            } else {
                $result = [
                    'message'   => 'fail',
                    'result'    => '',
                    'error_msg' => 'Please enter username & password'
                ];
            }
        } else {
            $result = [
                'message'   => 'fail',
                'result'    => '',
                'error_msg' => 'Api Token Not Matched'
            ];
        }
    
        return $this->response->setJSON($result);
    }

  
    public function material_requisiution_requestBk()
    {
            $db = \Config\Database::connect();
        
            // Retrieve API Key from the request header
            $apiKey = $this->request->getHeader('X-API-KEY');
            $apiKeyValue = $apiKey->getValue();
        
            // Fetch the stored API Key from the database
            $fetchxkeyQuery = $db->query("SELECT * FROM x_api_key");
            $xkey = $fetchxkeyQuery->getRow();
            $x_api_key = $xkey->x_api_key;
        
            if ($apiKeyValue == $x_api_key) {
        
                // Get required fields
                $requestedBy = $this->request->getVar('requestedBy');
                $givenTo = $this->request->getVar('givenTo');
                $givenBy = $this->request->getVar('givenBy');
                $materialId = $this->request->getVar('materialId');
                $qtyRequested = $this->request->getVar('qtyRequested');
                $unit = $this->request->getVar('unit');
                $note = $this->request->getVar('note');
        
                $currentDate = date('Y-m-d H:i:s');
        
                // ---------- Insert into material_requisiution_request table ----------
                $materialData = [
                    'requestedBy' => $requestedBy,
                    'givenTo' => $givenTo,
                    'givenBy' => $givenBy,
                    'materialId' => $materialId,
                    'quantityRequested' => $qtyRequested,
                    'unit' => $unit,
                    'note' => $note,
                    'isTestData' => 0,
                    'isDelete' => 0,
                    'createdAt' => $currentDate
                ];
        
                $db->table('material_requisiution_request')->insert($materialData);
                $requestId = $db->insertID();  // inserted ID
        
                // ---------- Insert into material_requisition_details table ----------
                // $detailsData = [
                //     'request_id' => $requestId,   // foreign key link
                //     'material_id' => $materialId,
                //     'requested_by' => $requestedBy,
                //     'qty_requested' => $qtyRequested,
                //     'unit' => $unit,
                //     'note' => $note,
                //     'status' => 'Pending',
                //     'created_at' => $currentDate
                // ];
        
                // $db->table('material_requisition_details')->insert($detailsData);
        
                // Response
                $result = [
                    'message' => "Success",
                    'result' => $materialData,
                    'error_msg' => "Material Requisition Created Successfully"
                ];
        
            } else {
        
                $result = [
                    'message' => "fail",
                    'result' => "",
                    'error_msg' => "Api Token Not Matched"
                ];
            }
        
            echo json_encode($result);
        }
    
    public function material_requisiution_request()
    {
        $db = \Config\Database::connect();
    
        // Retrieve API Key from header
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey->getValue();
    
        // Validate API Key
        $xkey = $db->query("SELECT x_api_key FROM x_api_key")->getRow();
        if (!$xkey || $apiKeyValue != $xkey->x_api_key) {
    
            echo json_encode([
                'message' => "fail",
                'result' => "",
                'error_msg' => "Api Token Not Matched"
            ]);
            return;
        }
    
        // ------- Get Input Fields -------
        $requestedBy  = $this->request->getVar('requestedBy');
        $givenTo      = $this->request->getVar('givenTo');
        $givenBy      = $this->request->getVar('givenBy');
        $materialId   = $this->request->getVar('materialId');
        $qtyRequested = $this->request->getVar('qtyRequested');
        $unit         = $this->request->getVar('unit');
        $note         = $this->request->getVar('note');
    
        $currentDate  = date('Y-m-d H:i:s');
    
        // ------- Insert into Table -------
        $materialData = [
            'requestedBy' => $requestedBy,
            'givenTo' => $givenTo,
            'givenBy' => $givenBy,
            'materialId' => $materialId,
            'quantityRequested' => $qtyRequested,
            'unit' => $unit,
            'note' => $note,
            'isTestData' => 0,
            'isDelete' => 0,
            'createdAt' => $currentDate
        ];
    
        $db->table('material_requisiution_request')->insert($materialData);
        $requestId = $db->insertID();
    
        // ============ FETCH CURRENTLY ADDED RECORD WITH JOINS ============
        $current = $db->table('material_requisiution_request m')
            ->select("m.*, 
                s.siteName,
                u1.name AS requesterName,
                u2.name AS givenByName,
                mm.materialName,
                CASE 
                    WHEN m.requestStatus = 1 THEN 'Approved'
                    WHEN m.requestStatus = 2 THEN 'Disapproved'
                    ELSE 'Pending'
                END AS statusName")
            ->join('sites s', 's.id = m.givenTo', 'left')
            ->join('users u1', 'u1.id = m.requestedBy', 'left')
            ->join('users u2', 'u2.id = m.givenBy', 'left')
            ->join('material_master mm', 'mm.id = m.materialId', 'left')
            ->where('m.id', $requestId)
            ->get()->getRowArray();
    
        // ============ FETCH LAST 15 DAYS RECORDS ============
        $last15days = $db->table('material_requisiution_request m')
            ->select("m.*, 
                s.siteName,
                u1.name AS requesterName,
                u2.name AS givenByName,
                mm.materialName,
                CASE 
                    WHEN m.requestStatus = 1 THEN 'Approved'
                    WHEN m.requestStatus = 2 THEN 'Disapproved'
                    ELSE 'Pending'
                END AS statusName")
            ->join('sites s', 's.id = m.givenTo', 'left')
            ->join('users u1', 'u1.id = m.requestedBy', 'left')
            ->join('users u2', 'u2.id = m.givenBy', 'left')
            ->join('material_master mm', 'mm.id = m.materialId', 'left')
            ->where('m.createdAt >=', date('Y-m-d H:i:s', strtotime('-15 days')))
            ->orderBy('m.id', 'DESC')
            ->get()->getResultArray();
    
        // ============ FINAL RESPONSE ============
        $result = [
            'message' => "Success",
            'current_request' => $current,
            'last15days' => $last15days,
            'error_msg' => "Material Requisition Created Successfully"
        ];
    
        echo json_encode($result);
    }

    public function labour_add()
    {
            $db = \Config\Database::connect();
        
            // Retrieve API Key from the request header
            $apiKey = $this->request->getHeader('X-API-KEY');
            $apiKeyValue = $apiKey->getValue();
        
            // Fetch the stored API Key from the database
            $fetchxkeyQuery = $db->query("SELECT * FROM x_api_key");
            $xkey = $fetchxkeyQuery->getRow();
            $x_api_key = $xkey->x_api_key;
        
            if ($apiKeyValue == $x_api_key) {
        
                // Get required fields
                $labourName = $this->request->getVar('labourName');
                $siteId = $this->request->getVar('siteId');
                //$labourId = $this->request->getVar('labourId');
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
                    'createdAt' => $currentDate
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
                    'createdAt' => $currentDate
                ];         
                // Response
                $result = [
                    'message' => "Success",
                    'result' => $materialDataResponse,
                    'error_msg' => "Labour Added Successfully"
                ];
        
            } else {
        
                $result = [
                    'message' => "fail",
                    'result' => "",
                    'error_msg' => "Api Token Not Matched"
                ];
            }
        
            echo json_encode($result);
        }
     
    public function labour_attendance_addbk()
    {
        $db = \Config\Database::connect();
    
        $siteId = $this->request->getVar('siteId');
        $labourId = $this->request->getVar('labourId');
        $attendanceType = $this->request->getVar('attendanceType'); // IN / OUT
        $attendanceDate = $this->request->getVar('attendanceDate');
        $time = $this->request->getVar('time');
    
        // File handling
        $inPhotoFile = $this->request->getFile('inPhoto');
        $outPhotoFile = $this->request->getFile('outPhoto');
    
        $inPhotoName = "";
        $outPhotoName = "";
    
        if ($inPhotoFile && $inPhotoFile->isValid()) {
            $inPhotoName = time() . '_' . $inPhotoFile->getName();
            $inPhotoFile->move('uploads/labour_attendance', $inPhotoName);
        }
    
        if ($outPhotoFile && $outPhotoFile->isValid()) {
            $outPhotoName = time() . '_' . $outPhotoFile->getName();
            $outPhotoFile->move('uploads/labour_attendance', $outPhotoName);
        }
    
        // ----------------------------------------
        // CHECK EXISTING RECORD FOR SAME DATE
        // ----------------------------------------
        $existing = $db->table('labour_attendance')
            ->where('labourId', $labourId)
            ->where('attendanceDate', $attendanceDate)
            ->get()
            ->getRow();
    
        // ----------------------------------------
        // CASE 1: FIRST TIME HIT = IN (INSERT)
        // ----------------------------------------
        if (!$existing && $attendanceType == "IN") {
    
            $insertData = [
                'siteId' => $siteId,
                'labourId' => $labourId,
                'attendanceType' => 'IN',
                'attendanceDate' => $attendanceDate,
                'inTime' => $time,
                'inPhoto' => $inPhotoName,
                'status' => 'Present',
                'isDelete' => 0,
                'createdAt' => date('Y-m-d H:i:s'),
                'updatedAt' => date('Y-m-d H:i:s'),
            ];
    
            $db->table('labour_attendance')->insert($insertData);
            $attendanceId = $db->insertID();
    
        }
    
        // ----------------------------------------
        // CASE 2: HIT = OUT (UPDATE)
        // ----------------------------------------
        else if ($existing && $attendanceType == "OUT") {
    
            // ALWAYS allow OUT if record exists
            $updateData = [
                'attendanceType' => 'OUT',
                'outTime' => $time,
                'updatedAt' => date('Y-m-d H:i:s'),
            ];
    
            if ($outPhotoName != "") {
                $updateData['outPhoto'] = $outPhotoName;
            }
    
            $db->table('labour_attendance')->where('id', $existing->id)->update($updateData);
    
            $attendanceId = $existing->id;
    
        }
    
        // ----------------------------------------
        // CASE 3: Invalid OUT (no IN record found)
        // ----------------------------------------
        else if (!$existing && $attendanceType == "OUT") {
    
            echo json_encode([
                "message" => "fail",
                "result" => "",
                "error_msg" => "Cannot record 'OUT' without a matching 'IN' for the same date."
            ]);
    
            return;
        }
    
        // ----------------------------------------
        // FETCH FINAL RECORD TO RETURN
        // ----------------------------------------
        $finalData = $db->table('labour_attendance')
            ->where('id', $attendanceId)
            ->get()
            ->getRow();
    
        // ----------------------------------------
        // FINAL RESPONSE
        // ----------------------------------------
        echo json_encode([
            "message" => "Success",
            "result" => [
                'attendanceId'   => $attendanceId,
                'attendanceType' => $finalData->attendanceType, // Always show actual DB status
                'attendanceDate' => $finalData->attendanceDate,
    
                'inTime'  => $finalData->inTime,
                'inPhoto' => $finalData->inPhoto ? LABOUR_ATTEND . $finalData->inPhoto : "",
    
                'outTime'  => $finalData->outTime,
                'outPhoto' => $finalData->outPhoto ? LABOUR_ATTEND . $finalData->outPhoto : "",
            ],
            "error_msg" => "Attendance " . $finalData->attendanceType . " saved successfully"
        ]);
    }
    
    
    public function labour_attendance_add()
    {
    $db = \Config\Database::connect();

    $siteId         = $this->request->getVar('siteId');
    $labourId       = $this->request->getVar('labourId');
    $attendanceType = $this->request->getVar('attendanceType'); // IN / OUT
    $attendanceDate = $this->request->getVar('attendanceDate');
    $time           = $this->request->getVar('time');

    // ---------------------------
    // PHOTO UPLOADS
    // ---------------------------
    $inPhotoFile  = $this->request->getFile('inPhoto');
    $outPhotoFile = $this->request->getFile('outPhoto');

    $inPhotoName  = "";
    $outPhotoName = "";

    if ($inPhotoFile && $inPhotoFile->isValid()) {
        $inPhotoName = time() . '_' . $inPhotoFile->getName();
        $inPhotoFile->move('uploads/labour_attendance', $inPhotoName);
    }

    if ($outPhotoFile && $outPhotoFile->isValid()) {
        $outPhotoName = time() . '_' . $outPhotoFile->getName();
        $outPhotoFile->move('uploads/labour_attendance', $outPhotoName);
    }
    
    $attendanceDate = date('Y-m-d');
    // ---------------------------
    // CHECK IF RECORD EXISTS FOR SAME DATE
    // ---------------------------
    $existing = $db->table('labour_attendance')
        ->where('labourId', $labourId)
        ->where('attendanceDate', $attendanceDate)
        ->get()
        ->getRow();

    // ---------------------------
    // CASE 1: FIRST TIME IN â†’ INSERT
    // ---------------------------
    if (!$existing && $attendanceType == "IN") {

        $insertData = [
            'siteId'        => $siteId,
            'labourId'      => $labourId,
            'attendanceType'=> 'IN',
            'attendanceDate'=> $attendanceDate,
            'inTime'        => $time,
            'inPhoto'       => $inPhotoName,
            'status'        => 'Present',
            'isDelete'      => 0,
            'createdAt'     => date('Y-m-d H:i:s'),
            'updatedAt'     => date('Y-m-d H:i:s'),
        ];

        $db->table('labour_attendance')->insert($insertData);
        $attendanceId = $db->insertID();
    }

    // ---------------------------
    // CASE 2: OUT â†’ UPDATE OUT TIME
    // ---------------------------
    else if ($existing && $attendanceType == "OUT") {

        $updateData = [
            'attendanceType' => 'OUT',
            'outTime'        => $time,
            'updatedAt'      => date('Y-m-d H:i:s'),
        ];

        if ($outPhotoName != "") {
            $updateData['outPhoto'] = $outPhotoName;
        }

        $db->table('labour_attendance')->where('id', $existing->id)->update($updateData);

        $attendanceId = $existing->id;
    }

    // ---------------------------
    // CASE 3: OUT WITHOUT IN â†’ ERROR
    // ---------------------------
    else if (!$existing && $attendanceType == "OUT") {

        echo json_encode([
            "message"   => "fail",
            "result"    => "",
            "error_msg" => "Cannot record OUT without a matching IN for the same date."
        ]);
        return;
    }

    // ---------------------------
    // CASE 4: IN AGAIN â†’ UPDATE IN TIME
    // ---------------------------
    else if ($existing && $attendanceType == "IN") {

        $updateData = [
            'inTime'    => $time,
            'updatedAt' => date('Y-m-d H:i:s'),
        ];

        if ($inPhotoName != "") {
            $updateData['inPhoto'] = $inPhotoName;
        }

        $db->table('labour_attendance')->where('id', $existing->id)->update($updateData);

        $attendanceId = $existing->id;
    }

    // ---------------------------
    // FETCH FINAL RECORD FOR RESPONSE
    // ---------------------------
    $finalData = $db->table('labour_attendance')
        ->where('id', $attendanceId)
        ->get()
        ->getRow();

    // ---------------------------
    // FINAL JSON RESPONSE
    // ---------------------------
    echo json_encode([
        "message" => "Success",
        "result" => [
            'attendanceId'   => $attendanceId,
            'attendanceType' => $finalData->attendanceType,
            'attendanceDate' => $finalData->attendanceDate,

            'inTime'  => $finalData->inTime,
            'inPhoto' => $finalData->inPhoto ? LABOUR_ATTEND . $finalData->inPhoto : "",

            'outTime'  => $finalData->outTime,
            'outPhoto' => $finalData->outPhoto ? LABOUR_ATTEND . $finalData->outPhoto : "",
        ],
        "error_msg" => "Attendance " . $finalData->attendanceType . " saved successfully"
    ]);
}

    
    // Helper function (unchanged)
    private function uploadPhoto($photoType)
    {
        $photo = "";
        if ($file = $this->request->getFile($photoType)) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = time() . '_' . $file->getName();
                $file->move(USER_UPLOAD_IMAGE, $newName);
                $photo = $newName;
            }
        }
        return $photo;
    }


    public function get_sites_details()
    {
        $db = \Config\Database::connect();
    
        // ------------------------------
        // Validate API Key
        // ------------------------------
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey ? $apiKey->getValue() : '';
    
        $xkey = $db->query("SELECT x_api_key FROM x_api_key")->getRow();
        if (!$xkey || $apiKeyValue != $xkey->x_api_key) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "Api Token Not Matched"
            ]);
        }
    
        // ------------------------------
        // GET PARAMS
        // ------------------------------
        $siteId  = $this->request->getGet('siteId');
        $dprDate = $this->request->getGet('dprDate');   // NEW PARAM
    
        if (!$siteId) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "siteId is required"
            ]);
        }
    
        // ------------------------------
        // FETCH SITE DETAILS
        // ------------------------------
        $site = $db->table('sites')
            ->where('id', $siteId)
            ->where('isDelete', 0)
            ->get()
            ->getRow();
    
        if (!$site) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "Site Not Found"
            ]);
        }
    
        // ------------------------------
        // STATUS DETAILS
        // ------------------------------
        $statusLabel = ($site->status == 0) ? "Active" : "Completed";
        $statusColor = ($site->status == 0) ? "#0CD2A4" : "#D2440C";
    
        // ------------------------------
        // FETCH MULTIPLE CLIENTS
        // ------------------------------
        $clientRows = $db->table('site_clients sc')
            ->select("
                c.id AS clientId,
                c.name,
                c.email,
                c.phoneNumber,
                c.address
            ")
            ->join('clients c', 'c.id = sc.clientId')
            ->where('sc.siteId', $siteId)
            ->where('sc.isDelete', 0)
            ->get()
            ->getResult();
    
        $clients = [];
        foreach ($clientRows as $cl) {
            $clients[] = [
                "clientId"    => $cl->clientId,
                "name"        => $cl->name,
                "email"       => $cl->email,
                "phoneNumber" => $cl->phoneNumber,
                "address"     => $cl->address
            ];
        }
    
        // ------------------------------
        // FETCH MULTIPLE TECHNICIANS
        // ------------------------------
        $techRows = $db->table('site_technicians st')
            ->select("
                t.id AS technicianId,
                t.licenceNumber,
                t.tradeTypeId,
                t.shiftTime,
                tt.tradeType AS tradeTypeName
            ")
            ->join('technicians t', 't.id = st.technicianId')
            ->join('trade_types tt', 'tt.id = t.tradeTypeId', 'left')
            ->where('st.siteId', $siteId)
            ->where('st.isDelete', 0)
            ->get()
            ->getResult();
    
        $technicians = [];
        foreach ($techRows as $tc) {
            $technicians[] = [
                "technicianId"  => $tc->technicianId,
                "licenceNumber" => $tc->licenceNumber,
                "tradeTypeId"   => $tc->tradeTypeId,
                "tradeTypeName" => $tc->tradeTypeName,
                "shiftTime"     => $tc->shiftTime
            ];
        }
    
        // -------------------------------------------------------
        // NEW FETCH DAILY DPR RECORDS (daily_work_progress)
        // -------------------------------------------------------
       $dprRows = $db->table('daily_work_progress')
        ->where('siteId', $siteId)
        ->where('isDelete', 0)
        ->where("DATE(createdAt)", $dprDate) // *** FILTER HERE ***
        ->get()
        ->getResult();
        
        $dailyProgress = [];
        foreach ($dprRows as $dpr) {
            $dailyProgress[] = [
                "id"                   => $dpr->id,
                "siteId"               => $dpr->siteId,
                "activityPerform"      => $dpr->activityPerform,
                "location"             => $dpr->location,
                "qtyOfWork"            => $dpr->qtyOfWork,
                "qtyMaterialConsumed"  => $dpr->qtyMaterialConsumed,
                "createdAt"            => $dpr->createdAt
            ];
        } 
        
        
                // -----------------------------------------
    // FETCH MATERIAL LIST WITH REQUIRED JOINS
    // -----------------------------------------
    $materialRows = $db->table('material_master mm')
        ->select("
            mm.id AS materialId,
            mm.materialName,
            mm.catType,
            mm.qty,
            mm.unit,
            mm.rate,
            mm.description,
            mm.code,
            mm.expenseType,
            sc.subCatName,
            mc.mainCatName
        ")
        ->join('material_sub_category sc', 'sc.id = mm.catType', 'left')
        ->join('material_main_category mc', 'mc.id = sc.mainCatId', 'left')
        ->where('mm.isDelete', 0)
        ->where('sc.isDelete', 0)
        ->where('mc.isDelete', 0)
        ->get()
        ->getResult();

    // -----------------------------------------
    // MAP DATA INTO CLEAN JSON ARRAY
    // -----------------------------------------
    $materials = [];

    foreach ($materialRows as $mt) {
        $materials[] = [
            "materialId"    => $mt->materialId,
            "materialName"  => $mt->materialName,
            "mainCatName"   => $mt->mainCatName,
            "subCatName"    => $mt->subCatName,
            "qty"           => $mt->qty,
            "unit"          => $mt->unit,
            "rate"          => $mt->rate,
            "description"   => $mt->description,
            "code"          => $mt->code,
            "expenseType"   => $mt->expenseType
        ];
    }
        
        // Material Unites
        
         $units = $db->table('material_units')
            ->where('isDelete', '0')
            ->get()
            ->getResult();
    
        $material_units = [];
    
        foreach ($units as $st) {
            $material_units[] = array(
                'id'       => $st->id,
                'unitName' => $st->unitName
            );
        }
    
        // ------------------------------
        // FINAL OUTPUT STRUCTURE
        // ------------------------------
        $allocatedmaterial = [];
        
        $response = [
            "siteInfo" => [
                "siteId"      => $site->id,
                "siteName"    => $site->siteName,
                "location"    => $site->location,
                "status"      => $site->status,
                "statusLabel" => $statusLabel,
                "statusColor" => $statusColor
            ],
            "clients"        => $clients,
            "technicians"    => $technicians,
            "dailyProgress"  => $dailyProgress,  //  NEW ARRAY
            "materials"  => $materials,  //  NEW ARRAY
            "dailyProgress"  => $dailyProgress,  //  NEW ARRAY
            "material_units"  => $material_units,  //  NEW ARRAY
            "allocatedMaterial"  => $allocatedmaterial  //  NEW ARRAY
        ];
    
        // ------------------------------
        // JSON RESPONSE
        // ------------------------------
        return $this->response->setJSON([
            'message'   => "Success",
            'result'    => $response,
            'error_msg' => "Site Details Fetched"
        ]);
    }

    public function get_material_units()
    {
        $db = \Config\Database::connect();
    
        $units = $db->table('material_units')
            ->where('isDelete', '0')
            ->get()
            ->getResult();
    
        $data = [];
        $data['material_units'] = [];
    
        foreach ($units as $st) {
            $data['material_units'][] = array(
                'id'       => $st->id,
                'unitName' => $st->unitName
            );
        }
    
        $result = array(
            'message'   => "Success",
            'result'    => $data,
            'error_msg' => "All Units"
        );
    
        return $this->response->setJSON($result);
    }
    
    
    public function get_manager_users()
    {
        $db = \Config\Database::connect();
    
        // ----------------------------------------------------
        // FETCH ALL USERS + TECHNICIANS + ROLE
        // ----------------------------------------------------
        $query = $db->table('technicians t')
            ->select("
                u.id AS userId,
                u.name,
                u.email,
                u.phoneNumber,
    
                t.id AS technicianRecordId,
                t.technicianId,
                t.licenceNumber,
                t.shiftTime,
                t.tradeTypeId,
                tt.tradeType,
    
                ur.roleId
            ")
            ->join('users u', 'u.id = t.userId', 'left')
            ->join('user_role ur', 'ur.userId = u.id', 'left')
            ->join('trade_types tt', 'tt.id = t.tradeTypeId', 'left')
            ->where('t.isDelete', 0)
            ->get()
            ->getResult();
    
        // ----------------------------------------------------
        // SEPARATE ARRAYS BASED ON ROLE ID
        // ----------------------------------------------------
        $data = [
            "purchaseUsers"  => [], // roleId = 1
            "orderUsers"     => [], // roleId = 2
            "receivedUsers"  => [], // roleId = 3
        ];
    
        foreach ($query as $item) {
    
            $userArray = [
                "userId"              => $item->userId,
                "name"                => $item->name,
                "email"               => $item->email,
                "phoneNumber"         => $item->phoneNumber,
    
                "technicianRecordId"  => $item->technicianRecordId,
                "technicianId"        => $item->technicianId,
                "licenceNumber"       => $item->licenceNumber,
                "shiftTime"           => $item->shiftTime,
    
                "tradeTypeId"         => $item->tradeTypeId,
                "tradeType"           => $item->tradeType,
                "roleId"              => $item->roleId
            ];
    
            if ($item->roleId == 1) {
                $data["purchaseUsers"][] = $userArray;
            }
            elseif ($item->roleId == 2) {
                $data["orderUsers"][] = $userArray;
            }
            elseif ($item->roleId == 3) {
                $data["receivedUsers"][] = $userArray;
            }
        }
        
        
         // ----------------------------------------------------
        // FETCH SUPPLIERS
        // ----------------------------------------------------
        $supplierRows = $db->table('suppliers')
            ->select("id, supplierName, gstn, mobileNo, supplierEmail, supplierAddress")
            ->where('isDelete', 0)
            ->get()
            ->getResult();
    
        $suppliers = [];
    
        foreach ($supplierRows as $sp) {
            $suppliers[] = [
                "supplierId"      => $sp->id,
                "supplierName"    => $sp->supplierName,
                "gstn"            => $sp->gstn,
                "mobileNo"        => $sp->mobileNo,
                "supplierEmail"   => $sp->supplierEmail,
                "supplierAddress" => $sp->supplierAddress
            ];
        }
        
           // -----------------------------------------
    // FETCH MATERIAL LIST WITH REQUIRED JOINS
    // -----------------------------------------
    $materialRows = $db->table('material_master mm')
        ->select("
            mm.id AS materialId,
            mm.materialName,
            mm.catType,
            mm.qty,
            mm.unit,
            mm.rate,
            mm.description,
            mm.code,
            mm.expenseType,
            sc.subCatName,
            mc.mainCatName
        ")
        ->join('material_sub_category sc', 'sc.id = mm.catType', 'left')
        ->join('material_main_category mc', 'mc.id = sc.mainCatId', 'left')
        ->where('mm.isDelete', 0)
        ->where('sc.isDelete', 0)
        ->where('mc.isDelete', 0)
        ->get()
        ->getResult();

    // -----------------------------------------
    // MAP DATA INTO CLEAN JSON ARRAY
    // -----------------------------------------
    $materials = [];

    foreach ($materialRows as $mt) {
        $materials[] = [
            "materialId"    => $mt->materialId,
            "materialName"  => $mt->materialName,
            "mainCatName"   => $mt->mainCatName,
            "subCatName"    => $mt->subCatName,
            "qty"           => $mt->qty,
            "unit"          => $mt->unit,
            "rate"          => $mt->rate,
            "description"   => $mt->description,
            "code"          => $mt->code,
            "expenseType"   => $mt->expenseType
        ];
    }
        
        // Material Unites
        
         $units = $db->table('material_units')
            ->where('isDelete', '0')
            ->get()
            ->getResult();
    
        $material_units = [];
    
        foreach ($units as $st) {
            $material_units[] = array(
                'id'       => $st->id,
                'unitName' => $st->unitName
            );
        }
    
    
        // ----------------------------------------------------
        // FETCH SUPPLIERS
        // ----------------------------------------------------
        $supplierRows = $db->table('suppliers')
            ->select("id, supplierName, gstn, mobileNo, supplierEmail, supplierAddress")
            ->where('isDelete', 0)
            ->get()
            ->getResult();
    
        $suppliers = [];
    
        foreach ($supplierRows as $sp) {
            $suppliers[] = [
                "supplierId"      => $sp->id,
                "supplierName"    => $sp->supplierName,
                "gstn"            => $sp->gstn,
                "mobileNo"        => $sp->mobileNo,
                "supplierEmail"   => $sp->supplierEmail,
                "supplierAddress" => $sp->supplierAddress
            ];
        }
    
        // ----------------------------------------------------
        // FINAL RESPONSE
        // ----------------------------------------------------
        return $this->response->setJSON([
            "message"   => "Success",
            "result"    => [
                "purchaseUsers" => $data["purchaseUsers"],
                "orderUsers"    => $data["orderUsers"],
                "receivedUsers" => $data["receivedUsers"],
                "suppliers"     => $suppliers,
                "material_units"     => $material_units,
                "materials_list"     => $materials
            ],
            "error_msg" => "All Manager Users & Suppliers"
        ]);
    }


    
    public function suppliers()
    {
        $db = \Config\Database::connect();
    
        $units = $db->table('suppliers')
            ->where('isDelete', '0')
            ->get()
            ->getResult();
    
        $data = [];
        $data['suppliers'] = [];
    
        foreach ($units as $st) {
            $data['suppliers'][] = array(
                'id'       => $st->id,
                'supplierName' => $st->supplierName,
                'gstn'=> $st->gstn,
                'mobileNo'=> $st->mobileNo,
                'supplierEmail'=> $st->supplierEmail,
                'supplierAddress'=> $st->supplierAddress
            );
        }
    
        $result = array(
            'message'   => "Success",
            'result'    => $data,
            'error_msg' => "All Suppliers"
        );
    
        return $this->response->setJSON($result);
    }
    

    
    public function material_puchase_cash()
    {
            $db = \Config\Database::connect();
        
            // Retrieve API Key from the request header
            $apiKey = $this->request->getHeader('X-API-KEY');
            $apiKeyValue = $apiKey->getValue();
        
            // Fetch the stored API Key from the database
            $fetchxkeyQuery = $db->query("SELECT * FROM x_api_key");
            $xkey = $fetchxkeyQuery->getRow();
            $x_api_key = $xkey->x_api_key;
        
            if ($apiKeyValue == $x_api_key) {
                
                //print_r($_POST); die;
        
                // Get required fields
                $purchaseBy = $this->request->getVar('purchaseBy');
                $siteId = $this->request->getVar('siteId');
                $orderBy = $this->request->getVar('orderBy');
                $receivedBy = $this->request->getVar('receivedBy');
                $paymentPaidBy = $this->request->getVar('paymentPaidBy');
                $totalBillAmt = $this->request->getVar('totalBillAmt');
                $totalPaid = $this->request->getVar('totalPaid');
                $totalBalance = $this->request->getVar('totalBalance');
                
                $sitePhoto = $this->request->getFile('sitePhoto');
                $cashMemoDcPhoto = $this->request->getFile('cashMemoDcPhoto');
                $BillFromDealerPhoto = $this->request->getFile('BillFromDealerPhoto');
               

                $sitePhotoName = "";
                $cashMemoDcPhotoName = "";
                $BillFromDealerPhotoName = "";
            
                if ($sitePhoto && $sitePhoto->isValid()) {
                    $sitePhotoName = time() . '_' . $sitePhoto->getName();
                    $sitePhoto->move('uploads/site_documents', $sitePhotoName);
                }
            
                if ($cashMemoDcPhoto && $cashMemoDcPhoto->isValid()) {
                    $cashMemoDcPhotoName = time() . '_' . $cashMemoDcPhoto->getName();
                    $cashMemoDcPhoto->move('uploads/site_documents', $cashMemoDcPhotoName);
                }
                
                if ($BillFromDealerPhoto && $BillFromDealerPhoto->isValid()) {
                    $BillFromDealerPhotoName = time() . '_' . $BillFromDealerPhoto->getName();
                    $BillFromDealerPhoto->move('uploads/site_documents', $BillFromDealerPhotoName);
                }
        
                $currentDate = date('Y-m-d H:i:s');
        
                // ---------- Insert into material_requisiution_request table ----------
                $materialData = [
                    'purchaseBy' => $purchaseBy,
                    'siteId' => $siteId,
                    'orderBy' => $orderBy,
                    'receivedBy' => $receivedBy,
                    'paymentPaidBy' => $paymentPaidBy,
                    'totalBillAmt' => $totalBillAmt,
                    'totalPaid' => $totalPaid,
                    'totalBalance' => $totalBalance,
                    'sitePhoto' => $sitePhotoName,
                    'cashMemoDcPhoto' => $cashMemoDcPhotoName,
                    'BillFromDealerPhoto' => $BillFromDealerPhotoName,
                    'isTestData' => 0,
                    'isDelete' => 0,
                    'createdAt' => $currentDate
                ];
        
                $db->table('material_purchase_cash')->insert($materialData);
                $requestId = $db->insertID();  // inserted ID
                
                
                // --------- INSERT MULTIPLE MATERIAL ITEMS FROM JSON ---------
                $itemJson = $this->request->getVar('itemData');
                $itemArray = json_decode($itemJson, true);
                
                if (!empty($itemArray) && isset($itemArray['materials'])) 
                {
                    foreach ($itemArray['materials'] as $item) 
                    {
                        $itemData = [
                            'purchaseId' => $requestId,                 // link to parent
                            'materialId' => $item['material_type'],     // material type ID
                            'billNo'     => $item['bill_no'],
                            'qty'        => $item['qty'],
                            'unit'       => $item['unit'],
                            'rate'       => $item['rate'],
                            'amount'     => $item['amount'],
                            'paid'       => $item['paid'],
                            'unpaid'     => $item['unpaid'],
                            'isDelete'   => 0,
                            'isTestData' => 0,
                            'createdAt'  => date('Y-m-d H:i:s')
                        ];
                
                        $db->table('material_purchase_items')->insert($itemData);
                    }
                }

        
                // Response
               $result = [
                    'message' => "Success",
                    'result' => [
                        'mainData' => [
                            'siteId' => $siteId,
                            'purchaseBy' => $purchaseBy,
                            'orderBy' => $orderBy,
                            'receivedBy' => $receivedBy,
                            'paymentPaidBy' => $paymentPaidBy,
                            'totalBillAmt' => $totalBillAmt,
                            'totalPaid' => $totalPaid,
                            'totalBalance' => $totalBalance,
                
                            // FULL IMAGE URL
                            'sitePhoto' => $sitePhotoName ? SITE_DOCUMENT . $sitePhotoName : "",
                            'cashMemoDcPhoto' => $cashMemoDcPhotoName ? SITE_DOCUMENT . $cashMemoDcPhotoName : "",
                            'BillFromDealerPhoto' => $BillFromDealerPhotoName ? SITE_DOCUMENT . $BillFromDealerPhotoName : "",
                        ],
                
                        // Items section stays same
                        'itemsInserted' => $itemArray['materials']
                    ],
                    'error_msg' => "Material Purchase Successfully"
                ];

        
            } else {
        
                $result = [
                    'message' => "fail",
                    'result' => "",
                    'error_msg' => "Api Token Not Matched"
                ];
            }
        
            echo json_encode($result);
        }

    public function material_puchase_dealer()
    {
            $db = \Config\Database::connect();
        
            // Retrieve API Key from the request header
            $apiKey = $this->request->getHeader('X-API-KEY');
            $apiKeyValue = $apiKey->getValue();
        
            // Fetch the stored API Key from the database
            $fetchxkeyQuery = $db->query("SELECT * FROM x_api_key");
            $xkey = $fetchxkeyQuery->getRow();
            $x_api_key = $xkey->x_api_key;
        
            if ($apiKeyValue == $x_api_key) {
                
                //print_r($_POST); die;
        
                // Get required fields
                $siteId = $this->request->getVar('siteId');
                $supplier = $this->request->getVar('supplier');
                $gstn = $this->request->getVar('gstn');
                $invoiceBillNo = $this->request->getVar('invoiceBillNo');
                $paymentPaidBy = $this->request->getVar('paymentPaidBy');
                $totalBillAmt = $this->request->getVar('totalBillAmt');
                $totalPaid = $this->request->getVar('totalPaid');
                $totalBalance = $this->request->getVar('totalBalance');
                $driverName = $this->request->getVar('driverName');
                $driverMobile = $this->request->getVar('driverMobile');
                $driverVehicle = $this->request->getVar('driverVehicle');
                
                $dcofSupplierPhoto = $this->request->getFile('dcofSupplierPhoto');
                $grnofCompany = $this->request->getFile('grnofCompany');
                $receipientWithTruck = $this->request->getFile('receipientWithTruck');
                $unloadedMaterial = $this->request->getFile('unloadedMaterial');
               

                $dcofSupplierPhotoName = "";
                $grnofCompanyName = "";
                $receipientWithTruckName = "";
                $unloadedMaterialName = "";
            
                if ($dcofSupplierPhoto && $dcofSupplierPhoto->isValid()) {
                    $dcofSupplierPhotoName = time() . '_' . $dcofSupplierPhoto->getName();
                    $dcofSupplierPhoto->move('uploads/site_documents', $dcofSupplierPhotoName);
                }
            
                if ($grnofCompany && $grnofCompany->isValid()) {
                    $grnofCompanyName = time() . '_' . $grnofCompany->getName();
                    $grnofCompany->move('uploads/site_documents', $grnofCompanyName);
                }
                
                if ($receipientWithTruck && $receipientWithTruck->isValid()) {
                    $receipientWithTruckName = time() . '_' . $receipientWithTruck->getName();
                    $receipientWithTruck->move('uploads/site_documents', $receipientWithTruckName);
                }
                
               if ($unloadedMaterial && $unloadedMaterial->isValid()) {
                    $unloadedMaterialName = time() . '_' . $unloadedMaterial->getName();
                    $unloadedMaterial->move('uploads/site_documents', $unloadedMaterialName);
                }
                
                $currentDate = date('Y-m-d H:i:s');
        
                // ---------- Insert into material_requisiution_request table ----------
                $materialData = [
                    'siteId' => $siteId,
                    'supplier' => $supplier,
                    'gstn' => $gstn,
                    'invoiceBillNo' => $invoiceBillNo,
                    'paymentPaidBy' => $paymentPaidBy,
                    'totalBillAmt' => $totalBillAmt,
                    'totalPaid' => $totalPaid,
                    'totalBalance' => $totalBalance,
                    
                    'driverName' => $driverName,
                    'driverMobile' => $driverMobile,
                    'driverVehicle' => $driverVehicle,
                    
                    'dcofSupplierPhoto' => $dcofSupplierPhotoName,
                    'grnofCompany' => $grnofCompanyName,
                    'receipientWithTruck' => $receipientWithTruckName,
                    'unloadedMaterial' => $unloadedMaterialName,
                    
                    'isTestData' => 0,
                    'isDelete' => 0,
                    'createdAt' => $currentDate
                ];
        
                $db->table('material_purchase_dealer')->insert($materialData);
                $requestId = $db->insertID();  // inserted ID
                
                
                // --------- INSERT MULTIPLE MATERIAL ITEMS FROM JSON ---------
                $itemJson = $this->request->getVar('itemData');
                $itemArray = json_decode($itemJson, true);
                
                if (!empty($itemArray) && isset($itemArray['materials'])) 
                {
                    foreach ($itemArray['materials'] as $item) 
                    {
                        $itemData = [
                            'purchaseId' => $requestId,                 // link to parent
                            'materialId' => $item['material_type'],     // material type ID
                            'billNo'     => $item['bill_no'],
                            'qty'        => $item['qty'],
                            'unit'       => $item['unit'],
                            'rate'       => $item['rate'],
                            'amount'     => $item['amount'],
                            'paid'       => $item['paid'],
                            'unpaid'     => $item['unpaid'],
                            'isDelete'   => 0,
                            'isTestData' => 0,
                            'createdAt'  => date('Y-m-d H:i:s')
                        ];
                
                        $db->table('material_purchase_items_dealer')->insert($itemData);
                    }
                }

        
                // Response
               $result = [
                    'message' => "Success",
                    'result' => [
                        'mainData' => [
                            'supplier' => $supplier,
                            'gstn' => $gstn,
                            'invoiceBillNo' => $invoiceBillNo,
                            'paymentPaidBy' => $paymentPaidBy,
                            'totalBillAmt' => $totalBillAmt,
                            'totalPaid' => $totalPaid,
                            'totalBalance' => $totalBalance,
                            
                            'driverName' => $driverName,
                            'driverMobile' => $driverMobile,
                            'driverVehicle' => $driverVehicle,
                            // FULL IMAGE URL
                            'dcofSupplierPhoto' => $dcofSupplierPhotoName ? SITE_DOCUMENT . $dcofSupplierPhotoName : "",
                            'grnofCompany' => $grnofCompanyName ? SITE_DOCUMENT . $grnofCompanyName : "",
                            'receipientWithTruck' => $receipientWithTruckName ? SITE_DOCUMENT . $receipientWithTruckName : "",
                            'unloadedMaterial' => $unloadedMaterialName ? SITE_DOCUMENT . $unloadedMaterialName : "",
                        ],
                
                        // Items section stays same  'itemsInserted' => $itemArray['materials']
                        'itemsInserted' => (!empty($itemArray) && isset($itemArray['materials']))
                                            ? $itemArray['materials']
                                            : []

                    ],
                    'error_msg' => "Material Purchase Successfully"
                ];

        
            } else {
        
                $result = [
                    'message' => "fail",
                    'result' => "",
                    'error_msg' => "Api Token Not Matched"
                ];
            }
        
            echo json_encode($result);
        }

        public function get_labours()
        {
            $db = \Config\Database::connect();
        
            // Retrieve API Key from header
            $apiKey = $this->request->getHeader('X-API-KEY');
            $apiKeyValue = $apiKey->getValue();
        
            // Fetch stored API Key
            $xkey = $db->query("SELECT * FROM x_api_key")->getRow();
            $x_api_key = $xkey->x_api_key;
        
            if ($apiKeyValue != $x_api_key) {
                return $this->response->setJSON([
                    'message' => "fail",
                    'result' => "",
                    'error_msg' => "Api Token Not Matched"
                ]);
            }
        
            // ------------ INPUTS -------------
            $siteId = $this->request->getVar('siteId');
            $today  = date('Y-m-d');
        
          // ------------ FETCH LABOURS + TODAY ATTENDANCE -------------
            $builder = $db->table('labour l');
            $builder->select("
                l.*, 
                la.id AS attendanceId,
                la.attendanceType,
                la.attendanceDate,
                la.inTime, la.inPhoto,
                la.outTime, la.outPhoto
            ");
            $builder->join(
                'labour_attendance la',
                'la.labourId = l.id AND la.attendanceDate = "'.$today.'"',
                'left'
            );
            $builder->where('l.siteId', $siteId);
            $builder->where('l.isDelete', 0);
            
            // *** ORDER BY labour.id DESC ***
            $builder->orderBy('l.id', 'DESC');
            
            $labours = $builder->get()->getResult();

        
        
            // ------------ FORMAT OUTPUT -------------
            $data = [];
            foreach ($labours as $st) {
        
                $data[] = [
                    'id'            => $st->id,
                    'labourName'    => $st->labourName,
                    'labourId'      => $st->id,
                    'siteId'        => $st->siteId,
                    'mobileNo'      => $st->mobileNo,
                    'gender'        => $st->gender,
                    'dailyWiseAmount' => $st->dailyWiseAmount,
        
                    // Today's Attendance
                    'attendanceId'   => $st->attendanceId ?? "",
                    'attendanceType' => $st->attendanceType ?? "",
                    'attendanceDate' => $st->attendanceDate ?? "",
        
                    'inTime'  => $st->inTime ?? "",
                    'inPhoto' => $st->inPhoto ? LABOUR_ATTEND . $st->inPhoto : "",
        
                    'outTime'  => $st->outTime ?? "",
                    'outPhoto' => $st->outPhoto ? LABOUR_ATTEND . $st->outPhoto : "",
                ];
            }
        
            // ------------ FINAL RESPONSE -------------
            return $this->response->setJSON([
                'message'   => "Success",
                'result'    => ['labours' => $data],
                'error_msg' => "All Labours"
            ]);
        }

    public function get_dashboard()
    {
            
        $db = \Config\Database::connect();
    
        // ---------------------------------
        // Validate API Key
        // ---------------------------------
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey->getValue();
    
        $xkey = $db->query("SELECT x_api_key FROM x_api_key")->getRow();
        if (!$xkey || $apiKeyValue != $xkey->x_api_key) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "Api Token Not Matched"
            ]);
        }
    
        // ---------------------------------
        // INPUT
        // ---------------------------------
        $userId = $this->request->getVar('userId');
        if (!$userId) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "userId is required"
            ]);
        }
    
        // ---------------------------------
        // FETCH SITES + MULTIPLE CLIENTS
        // ---------------------------------
        $builder = $db->table('sites s');
        $builder->select("
            s.id AS siteId,
            s.siteName,
            s.location,
            s.status,
    
            c.id AS clientId,
            c.name AS clientName,
            c.email AS clientEmail,
            c.phoneNumber AS clientPhone,
            c.address AS clientAddress
        ");
    
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
            $statusLabel = ($row->status == 0) ? "Active" : "Completed";
            $statusColor = ($row->status == 0) ? "#0CD2A4" : "#D2440C";
    
            $siteId = $row->siteId;
    
            if (!isset($grouped[$siteId])) {
                $grouped[$siteId] = [
                    "siteDetails" => [
                        "siteId"       => $row->siteId,
                        "siteName"     => $row->siteName,
                        "location"     => $row->location,
                        "status"       => $row->status,
                        "statusLabel"  => $statusLabel,
                        "statusColor"  => $statusColor
                    ],
                    "clients" => []
                ];
            }
    
            if (!empty($row->clientId)) {
                $grouped[$siteId]["clients"][] = [
                    "clientId"      => $row->clientId,
                    "name"          => $row->clientName,
                    "email"         => $row->clientEmail,
                    "phoneNumber"   => $row->clientPhone,
                    "address"       => $row->clientAddress
                ];
            }
        }
    
        $final = array_values($grouped);
    
        // ---------------------------------
        // RESPONSE
        // ---------------------------------
        return $this->response->setJSON([
            'message'   => "Success",
            'result'    => ["dashboard" => $final],
            'error_msg' => "Dashboard List"
        ]);
    }

    public function add_daily_progressbk()
    {
        $db = \Config\Database::connect();
    
        // ------------------------------
        // Validate API Key
        // ------------------------------
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey ? $apiKey->getValue() : '';
    
        $xkey = $db->query("SELECT x_api_key FROM x_api_key")->getRow();
        if (!$xkey || $apiKeyValue != $xkey->x_api_key) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "Api Token Not Matched"
            ]);
        }
    
        // ------------------------------
        // Required Inputs
        // ------------------------------
        $siteId              = $this->request->getVar('siteId');
        $activityPerform     = $this->request->getVar('activityPerform');
        $location            = $this->request->getVar('location');
        $qtyOfWork           = $this->request->getVar('qtyOfWork');
        $qtyMaterialConsumed = $this->request->getVar('qtyMaterialConsumed');
        $materialId          = $this->request->getVar('materialId');
        $unit                = $this->request->getVar('unit');
    
        // Check Required fields
        if (!$siteId || !$activityPerform) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "siteId and activityPerform are required"
            ]);
        }
    
        $currentDate = date('Y-m-d H:i:s');
    
        // ------------------------------
        // Insert into daily_work_progress
        // ------------------------------
        $insertData = [
            "siteId"              => $siteId,
            "activityPerform"     => $activityPerform,
            "location"            => $location,
            "qtyOfWork"           => $qtyOfWork,
            "qtyMaterialConsumed" => $qtyMaterialConsumed,
            "materialId"          => $materialId,
            "unit"                => $unit,
            "isDelete"            => 0,
            "createdAt"           => $currentDate
        ];
    
        $db->table('daily_work_progress')->insert($insertData);
        $insertId = $db->insertID();
    
        // ------------------------------
        // Response
        // ------------------------------
        return $this->response->setJSON([
            'message'   => "Success",
            'result'    => [
                "insertId" => $insertId,
                "details"  => $insertData
            ],
            'error_msg' => "Daily Progress Report Added"
        ]);
    }
    
    public function add_daily_progress()
{
    $db = \Config\Database::connect();

    // ------------------------------
    // Validate API Key
    // ------------------------------
    $apiKey = $this->request->getHeader('X-API-KEY');
    $apiKeyValue = $apiKey ? $apiKey->getValue() : '';

    $xkey = $db->query("SELECT x_api_key FROM x_api_key")->getRow();
    if (!$xkey || $apiKeyValue != $xkey->x_api_key) {
        return $this->response->setJSON([
            'message'   => "fail",
            'result'    => "",
            'error_msg' => "Api Token Not Matched"
        ]);
    }

    // ------------------------------
    // Required Inputs
    // ------------------------------
    $siteId              = $this->request->getVar('siteId');
    $activityPerform     = $this->request->getVar('activityPerform');
    $location            = $this->request->getVar('location');
    $qtyOfWork           = $this->request->getVar('qtyOfWork');
    $qtyMaterialConsumed = $this->request->getVar('qtyMaterialConsumed');
    $materialId          = $this->request->getVar('materialId');
    $unit                = $this->request->getVar('unit');

    if (!$siteId || !$activityPerform) {
        return $this->response->setJSON([
            'message'   => "fail",
            'result'    => "",
            'error_msg' => "siteId and activityPerform are required"
        ]);
    }

    $currentDate = date('Y-m-d H:i:s');

    // ------------------------------
    // Insert into daily_work_progress
    // ------------------------------
    $insertData = [
        "siteId"              => $siteId,
        "activityPerform"     => $activityPerform,
        "location"            => $location,
        "qtyOfWork"           => $qtyOfWork,
        "qtyMaterialConsumed" => $qtyMaterialConsumed,
        "materialId"          => $materialId,
        "unit"                => $unit,
        "isDelete"            => 0,
        "createdAt"           => $currentDate
    ];

    $db->table('daily_work_progress')->insert($insertData);
    $insertId = $db->insertID();

    // ------------------------------
    // Fetch Material Name (JOIN)
    // ------------------------------
    $materialName = null;

    if (!empty($materialId)) {
        $material = $db->table('material_master')
                       ->select('materialName')
                       ->where('id', $materialId)
                       ->get()
                       ->getRow();

        if ($material) {
            $materialName = $material->materialName;
        }
    }

    // Add to API Result
    $insertData["materialName"] = $materialName;

    // ------------------------------
    // Response
    // ------------------------------
    return $this->response->setJSON([
        'message'   => "Success",
        'result'    => [
            "insertId" => $insertId,
            "details"  => $insertData
        ],
        'error_msg' => "Daily Progress Report Added"
    ]);
}



    public function get_contractor()
    {
        $db = \Config\Database::connect();
        
       // ------------------------------
        // Validate API Key
        // ------------------------------
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey ? $apiKey->getValue() : '';
    
        $xkey = $db->query("SELECT x_api_key FROM x_api_key")->getRow();
        if (!$xkey || $apiKeyValue != $xkey->x_api_key) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "Api Token Not Matched"
            ]);
        }
        
        
        // ------------------------------
        // GET PARAMS
        // ------------------------------
        $siteId  = $this->request->getGet('siteId');

        if (!$siteId) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "siteId is required"
            ]);
        }

    
        $contractor = $db->table('contractor')
            ->where('siteId', $siteId)
            ->where('isDelete', '0')
            ->get()
            ->getResult();
    
        $data = [];
        $data['contractor'] = [];
    
        foreach ($contractor as $st) {
            $data['contractor'][] = array(
                'id'       => $st->id,
                'contractorName' => $st->contractorName,
                'mobileNo'=> $st->mobileNo,
                'email'=> $st->email,
                'address'=> $st->address
            );
        }
    
        $result = array(
            'message'   => "Success",
            'result'    => $data,
            'error_msg' => "Site Contractor List"
        );
    
        return $this->response->setJSON($result);
    }
    
    public function get_labour_attendance_summarybk()
    {
        $db = \Config\Database::connect();
    
        // ------------------------------
        // Validate API Key
        // ------------------------------
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey ? $apiKey->getValue() : '';
    
        $xkey = $db->query("SELECT x_api_key FROM x_api_key")->getRow();
        if (!$xkey || $apiKeyValue != $xkey->x_api_key) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "Api Token Not Matched"
            ]);
        }
    
        // ------------------------------
        // GET PARAMS
        // ------------------------------
        $siteId  = $this->request->getGet('siteId');
    
        if (!$siteId) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "siteId is required"
            ]);
        }
    
        $today = date('Y-m-d');
        $weekStart = date('Y-m-d', strtotime('-6 days'));
        $weekEnd = $today;
        
      
         
        // ===================================================
        // 🔵 1. DAILY LABOUR SUMMARY
        // ===================================================
    
        // Today Present (Male/Female)
        $presentMale = $db->query("
            SELECT COUNT(*) AS total 
            FROM labour l 
            JOIN labour_attendance a ON a.labourId = l.id 
            WHERE a.status = 'Present' 
            AND l.gender = 'male' 
            AND a.attendanceDate = '$today'
            AND l.siteId = '$siteId'
            AND l.isDelete = 0
            AND a.isDelete = 0
        ")->getRow()->total;
        
        // echo $db->getLastQuery(); die;
    
        $presentFemale = $db->query("
            SELECT COUNT(*) AS total 
            FROM labour l 
            JOIN labour_attendance a ON a.labourId = l.id 
            WHERE a.status = 'Present' 
            AND l.gender = 'female' 
            AND a.attendanceDate = '$today'
            AND l.siteId = '$siteId'
            AND l.isDelete = 0
            AND a.isDelete = 0
        ")->getRow()->total;
    
        $totalPresent = $presentMale + $presentFemale;
    
        // Daily payment balance from labour_payments
        $dailyPaymentBalance = $db->query("
            SELECT SUM(dailyPayment - recordedPayment) AS balance
            FROM labour_payments
            WHERE siteId = '$siteId'
            AND paymentDate = '$today'
            AND isDelete = 0
        ")->getRow()->balance ?? 0;
    
    
        // ===================================================
        // 🔵 WEEKLY LABOUR PRESENT SUMMARY (Male/Female)
        // ===================================================
        
        $weeklyMale = $db->query("
            SELECT COUNT(*) AS total 
            FROM labour l 
            JOIN labour_attendance a ON a.labourId = l.id 
            WHERE a.status = 'Present' 
            AND l.gender = 'male' 
            AND a.attendanceDate BETWEEN '$weekStart' AND '$weekEnd'
            AND l.siteId = '$siteId'
            AND l.isDelete = 0
            AND a.isDelete = 0
        ")->getRow()->total;
        
        $weeklyFemale = $db->query("
            SELECT COUNT(*) AS total 
            FROM labour l 
            JOIN labour_attendance a ON a.labourId = l.id 
            WHERE a.status = 'Present' 
            AND l.gender = 'female' 
            AND a.attendanceDate BETWEEN '$weekStart' AND '$weekEnd'
            AND l.siteId = '$siteId'
            AND l.isDelete = 0
            AND a.isDelete = 0
        ")->getRow()->total;
        
        $weeklyTotalPresent = $weeklyMale + $weeklyFemale;
            
            // ===================================================
        // 🔵 WEEKLY PAYMENT BALANCE (FIX FOR ERROR)
        // ===================================================
        
        $weeklyBalance = $db->query("
            SELECT SUM(dailyPayment - recordedPayment) AS balance
            FROM labour_payments
            WHERE siteId = '$siteId'
            AND paymentDate BETWEEN '$weekStart' AND '$weekEnd'
            AND isDelete = 0
        ")->getRow()->balance ?? 0;
        
        // ===================================================
        // 🔵 3. DAILY CONTRACTOR SUMMARY
        // ===================================================
    
        $contractorSummary = $db->query("
            SELECT 
                SUM(c.skilledLabourMale) AS skilledLabourMale,
                SUM(c.skilledLabourFemale) AS skilledLabourFemale,
                SUM(c.unSkilledMale) AS unSkilledMale,
                SUM(c.unSkilledFemale) AS unSkilledFemale,
                SUM(c.qtyWorkInTime) AS qtyWork
            FROM contractor_labour c
            JOIN contractor ct ON ct.id = c.contractorId
            WHERE c.workDate = '$today'
            AND c.siteId = '$siteId'
            AND c.isDelete = 0
            AND ct.isDelete = 0
        ")->getRow();
    
    
        // ===================================================
        // 🔵 4. WEEKLY CONTRACTOR PAYMENT SUMMARY
        // ===================================================
    
        $contractorPayment = $db->query("
            SELECT 
                SUM(paymentDue) AS totalPaymentDue,
                MAX(lastPaymentDate) AS lastPaymentDate,
                SUM(lastPaymentAmount) AS lastPaymentAmount
            FROM contractor_payments
            WHERE siteId = '$siteId'
            AND lastPaymentDate BETWEEN '$weekStart' AND '$weekEnd'
            AND isDelete = 0
        ")->getRow();
    
    
        // ===================================================
        // 🔵 FINAL RESPONSE
        // ===================================================
    
        $data = [
            "daily_labour_summary" => [
                "total_male_present"    => $presentMale,
                "total_female_present"  => $presentFemale,
                "total_present_today"   => $totalPresent,
                "daily_payment_balance" => (float)$dailyPaymentBalance
            ],
    
           "weekly_labour_summary" => [
                "weekly_total_male_present"   => (int)$weeklyMale,
                "weekly_total_female_present" => (int)$weeklyFemale,
                "weekly_total_present"        => (int)$weeklyTotalPresent,
                "weekly_payment_balance"      => (float)$weeklyBalance
            ],
    
            "daily_contractor_summary" => [
                "skilled_labour_male"     => (int)$contractorSummary->skilledLabourMale,
                "skilled_labour_female"     => (int)$contractorSummary->skilledLabourFemale,
                "unskilled_male"     => (int)$contractorSummary->unSkilledMale,
                "unskilled_female"   => (int)$contractorSummary->unSkilledFemale,
                "qty_work"           => $contractorSummary->qtyWork
            ],
    
            "weekly_contractor_summary" => [
                "total_payment_due"   => (float)$contractorPayment->totalPaymentDue,
                "last_payment_date"   => $contractorPayment->lastPaymentDate,
                "last_payment_amount" => (float)$contractorPayment->lastPaymentAmount
            ]
        ];
    
        return $this->response->setJSON([
            "message" => "Success",
            "result"  => $data,
            "error_msg" => ""
        ]);
    }
    
   public function get_labour_attendance_summary()
    {
        $db = \Config\Database::connect();
    
        // ------------------------------
        // Validate API Key
        // ------------------------------
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey ? $apiKey->getValue() : '';
    
        $xkey = $db->query("SELECT x_api_key FROM x_api_key")->getRow();
        if (!$xkey || $apiKeyValue != $xkey->x_api_key) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "Api Token Not Matched"
            ]);
        }
    
        // ------------------------------
        // GET PARAMS
        // ------------------------------
        $siteId  = $this->request->getGet('siteId');
    
        if (!$siteId) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "siteId is required"
            ]);
        }
    
        $today = date('Y-m-d');
        $weekStart = date('Y-m-d', strtotime('-6 days'));
        $weekEnd = $today;
    
    
        // ===================================================
        // 🔵 1. DAILY LABOUR SUMMARY
        // ===================================================
    
        $presentMale = $db->query("
            SELECT COUNT(*) AS total 
            FROM labour l 
            JOIN labour_attendance a ON a.labourId = l.id 
            WHERE a.status = 'Present' 
            AND l.gender = 'male' 
            AND a.attendanceDate = '$today'
            AND l.siteId = '$siteId'
            AND l.isDelete = 0
            AND a.isDelete = 0
        ")->getRow()->total;
    
        $presentFemale = $db->query("
            SELECT COUNT(*) AS total 
            FROM labour l 
            JOIN labour_attendance a ON a.labourId = l.id 
            WHERE a.status = 'Present' 
            AND l.gender = 'female' 
            AND a.attendanceDate = '$today'
            AND l.siteId = '$siteId'
            AND l.isDelete = 0
            AND a.isDelete = 0
        ")->getRow()->total;
    
        $totalPresent = $presentMale + $presentFemale;
    
        $dailyPaymentBalance = $db->query("
            SELECT SUM(dailyPayment - recordedPayment) AS balance
            FROM labour_payments
            WHERE siteId = '$siteId'
            AND paymentDate = '$today'
            AND isDelete = 0
        ")->getRow()->balance ?? 0;
    
    
    
        // ===================================================
        // 🔵 2. WEEKLY LABOUR PRESENT SUMMARY
        // ===================================================
    
        $weeklyMale = $db->query("
            SELECT COUNT(*) AS total 
            FROM labour l 
            JOIN labour_attendance a ON a.labourId = l.id 
            WHERE a.status = 'Present' 
            AND l.gender = 'male' 
            AND a.attendanceDate BETWEEN '$weekStart' AND '$weekEnd'
            AND l.siteId = '$siteId'
            AND l.isDelete = 0
            AND a.isDelete = 0
        ")->getRow()->total;
    
        $weeklyFemale = $db->query("
            SELECT COUNT(*) AS total 
            FROM labour l 
            JOIN labour_attendance a ON a.labourId = l.id 
            WHERE a.status = 'Present' 
            AND l.gender = 'female' 
            AND a.attendanceDate BETWEEN '$weekStart' AND '$weekEnd'
            AND l.siteId = '$siteId'
            AND l.isDelete = 0
            AND a.isDelete = 0
        ")->getRow()->total;
    
        $weeklyTotalPresent = $weeklyMale + $weeklyFemale;
    
        $weeklyBalance = $db->query("
            SELECT SUM(dailyPayment - recordedPayment) AS balance
            FROM labour_payments
            WHERE siteId = '$siteId'
            AND paymentDate BETWEEN '$weekStart' AND '$weekEnd'
            AND isDelete = 0
        ")->getRow()->balance ?? 0;
    
    
    
        // ===================================================
        // 🔵 3. DAILY CONTRACTOR SUMMARY (MULTIPLE CONTRACTORS)
        // ===================================================
    
        $contractorSummaryRows = $db->query("
            SELECT 
                ct.id AS contractorId,
                ct.contractorName,
                SUM(c.skilledLabourFemale) AS skilledLabourFemale,
                SUM(c.skilledLabourMale) AS skilledLabourMale,
                SUM(c.unSkilledMale) AS unSkilledMale,
                SUM(c.unSkilledFemale) AS unSkilledFemale,
                SUM(c.qtyWorkInTime) AS qtyWork
            FROM contractor_labour c
            JOIN contractor ct ON ct.id = c.contractorId
            WHERE c.workDate = '$today'
            AND c.siteId = '$siteId'
            AND c.isDelete = 0
            AND ct.isDelete = 0
            GROUP BY ct.id
        ")->getResult();
    
        $dailyContractors = [];
        foreach ($contractorSummaryRows as $r) {
            $dailyContractors[] = [
                "contractor_id"      => (int)$r->contractorId,
                "contractor_name"    => $r->contractorName,
                "skilled_labour_male"     => (int)$r->skilledLabourMale,
                "skilled_labour_female"     => (int)$r->skilledLabourFemale,
                "unskilled_male"     => (int)$r->unSkilledMale,
                "unskilled_female"   => (int)$r->unSkilledFemale,
                "qty_work"           => $r->qtyWork,
            ];
        }
    
    
    
        // ===================================================
        // 🔵 4. WEEKLY CONTRACTOR SUMMARY (CONTRACTOR-WISE)
        // ===================================================
    

        
        $weeklyContractorRows = $db->query("
        SELECT 
            ct.id AS contractorId,
            ct.contractorName,
    
            (SELECT SUM(cp.paymentDue)
             FROM contractor_payments cp
             WHERE cp.contractorId = ct.id
               AND cp.siteId = '$siteId'
               AND cp.lastPaymentDate BETWEEN '$weekStart' AND '$weekEnd'
               AND cp.isDelete = 0
            ) AS totalDue,
    
            (SELECT cp.lastPaymentDate
             FROM contractor_payments cp
             WHERE cp.contractorId = ct.id
               AND cp.siteId = '$siteId'
               AND cp.isDelete = 0
             ORDER BY cp.lastPaymentDate DESC LIMIT 1
            ) AS lastPaymentDate,
    
            (SELECT cp.lastPaymentAmount
             FROM contractor_payments cp
             WHERE cp.contractorId = ct.id
               AND cp.siteId = '$siteId'
               AND cp.isDelete = 0
             ORDER BY cp.lastPaymentDate DESC LIMIT 1
            ) AS lastPaymentAmount
    
        FROM contractor ct
        WHERE ct.isDelete = 0
        AND ct.id IN (SELECT contractorId FROM contractor_payments WHERE siteId = '$siteId')
    ")->getResult();
    
        
        $weeklyContractors = [];
        foreach ($weeklyContractorRows as $w) {
            $weeklyContractors[] = [
                "contractor_id"        => (int)$w->contractorId,
                "contractor_name"      => $w->contractorName,
                "total_payment_due"    => (float)$w->totalDue,
                "last_payment_date"    => $w->lastPaymentDate,
                "last_payment_amount"  => (float)$w->lastPaymentAmount
            ];
        }
        
        // ===================================================
        // 🔵 4. SITE CONTRACTOR LIST   (NEW REQUEST)
        // ===================================================
        
        $contractorList = $db->query("
            SELECT 
                id AS contractorId,
                contractorName,
                mobileNo,
                address
            FROM contractor
            WHERE siteId = '$siteId'
            AND isDelete = 0
        ")->getResult();
        
        $contractors = [];
        foreach ($contractorList as $c) {
            $contractors[] = [
                "contractor_id"   => (int)$c->contractorId,
                "contractor_name" => $c->contractorName,
                "mobile_no"       => $c->mobileNo,
                "address"         => $c->address
            ];
        }
        
            
        // ===================================================
        // 🔵 FINAL RESPONSE
        // ===================================================
    
        $data = [
            "daily_labour_summary" => [
                "total_male_present"    => (int)$presentMale,
                "total_female_present"  => (int)$presentFemale,
                "total_present_today"   => (int)$totalPresent,
                "daily_payment_balance" => (float)$dailyPaymentBalance
            ],
    
            "weekly_labour_summary" => [
                "weekly_total_male_present"   => (int)$weeklyMale,
                "weekly_total_female_present" => (int)$weeklyFemale,
                "weekly_total_present"        => (int)$weeklyTotalPresent,
                "weekly_payment_balance"      => (float)$weeklyBalance
            ],
    
            "daily_contractor_summary"  => $dailyContractors,
            "weekly_contractor_summary" => $weeklyContractors,
            "contractors"               => $contractors  

        ];
    
        return $this->response->setJSON([
            "message" => "Success",
            "result"  => $data,
            "error_msg" => ""
        ]);
    }
     
    public function contractor_labour_update()
    {
        $db = \Config\Database::connect();
    
        // ------------------------------
        // Validate API KEY
        // ------------------------------
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey ? $apiKey->getValue() : '';
    
        $xkey = $db->query("SELECT x_api_key FROM x_api_key")->getRow();
        if (!$xkey || $apiKeyValue != $xkey->x_api_key) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "Api Token Not Matched"
            ]);
        }
    
        // ------------------------------
        // Get Inputs
        // ------------------------------
        $contractorId       = $this->request->getVar('contractorId');
        $siteId             = $this->request->getVar('siteId');
        $skilledMale        = $this->request->getVar('skilledLabourMale');
        $skilledFemale      = $this->request->getVar('skilledLabourFemale');
        $unskilledMale      = $this->request->getVar('unSkilledMale');
        $unskilledFemale    = $this->request->getVar('unSkilledFemale');
        $qtyWorkInTime      = $this->request->getVar('qtyWorkInTime');
        $workDate           = $this->request->getVar('workDate');  // Y-m-d
    
        // Required
        if (!$contractorId || !$siteId || !$workDate) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "contractorId, siteId and workDate are required"
            ]);
        }
    
        // ------------------------------
        // Check if today's record exists
        // ------------------------------
        $builder = $db->table('contractor_labour');
    
        $existing = $builder->where([
            "contractorId" => $contractorId,
            "siteId"       => $siteId,
            "workDate"     => $workDate
        ])->get()->getRow();
    
        $data = [
            "contractorId"       => $contractorId,
            "siteId"             => $siteId,
            "skilledLabourMale"  => $skilledMale,
            "skilledLabourFemale"=> $skilledFemale,
            "unSkilledMale"      => $unskilledMale,
            "unSkilledFemale"    => $unskilledFemale,
            "qtyWorkInTime"      => $qtyWorkInTime,
            "workDate"           => $workDate
        ];
    
        // ------------------------------
        // INSERT if not exist, UPDATE if exists
        // ------------------------------
        if ($existing) {
            // Update
            $builder->where("id", $existing->id)->update($data);
            $msg = "Record updated successfully";
            $operation = "update";
            $rowId = $existing->id;
        } else {
            // Insert
            $builder->insert($data);
            $rowId = $db->insertID();
            $msg = "Record inserted successfully";
            $operation = "insert";
        }
    
        // ------------------------------
        // Response
        // ------------------------------
        return $this->response->setJSON([
            'message'   => "Success",
            'operation' => $operation,
            'result'    => [
                "id"     => $rowId,
                "details"=> $data
            ],
            'error_msg' => $msg
        ]);
    }
    
    
    public function profile_update()
    {
        $db = \Config\Database::connect();
    
        // Retrieve API Key from the request header
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey ? $apiKey->getValue() : '';
    
        // Fetch stored API Key
        $fetchxkeyQuery = $db->query("SELECT * FROM x_api_key");
        $xkey = $fetchxkeyQuery->getRow();
        $x_api_key = $xkey->x_api_key;
    
        if ($apiKeyValue != $x_api_key) {
    
            return json_encode([
                'message' => "fail",
                'result'  => "",
                'error_msg' => "Api Token Not Matched"
            ]);
        }
    
        // ----------------------------
        // REQUIRED INPUTS
        // ----------------------------
        $userId = $this->request->getVar('userId');
        $name   = $this->request->getVar('name');
        $email  = $this->request->getVar('email');
        $profilePhoto = $this->request->getFile('profilePhoto');
    
        if (!$userId) {
            return json_encode([
                'message' => "fail",
                'result' => "",
                'error_msg' => "userId is required"
            ]);
        }
    
        // Fetch current user record
        $user = $db->table('users')->where('id', $userId)->get()->getRow();
    
        if (!$user) {
            return json_encode([
                'message' => "fail",
                'result' => "",
                'error_msg' => "User not found"
            ]);
        }
    
        // ----------------------------
        // HANDLE PROFILE PHOTO
        // ----------------------------
        $profilePhotoName = $user->profile; // Keep old if no new file uploaded
    
        if ($profilePhoto && $profilePhoto->isValid()) {
    
            $profilePhotoName = time() . '_' . $profilePhoto->getName();
            $profilePhoto->move('uploads/user_profile', $profilePhotoName);
        }
    
        // ----------------------------
        // UPDATE USER DATA
        // ----------------------------
        $updateData = [
            'name'   => $name,
            'email'  => $email,
            'profile' => $profilePhotoName,
            'updatedAt' => date('Y-m-d H:i:s')
        ];
    
        $db->table('users')->where('id', $userId)->update($updateData);
    
        $result = [
            'message' => "Success",
            'result' => [
                    'userId'  => $userId,
                    'name'    => $name,
                    'email'   => $email,
                    'profile' => $profilePhotoName ? USER_IMAGE . $profilePhotoName : "",
            ],
            'error_msg' => "Profile Updated Successfully"
        ];
    
        echo json_encode($result);
    }
    
    public function get_material_requisition_dropdown()
    {
        $db = \Config\Database::connect();
        
         // Retrieve API Key from the request header
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey ? $apiKey->getValue() : '';
    
        // Fetch stored API Key
        $fetchxkeyQuery = $db->query("SELECT * FROM x_api_key");
        $xkey = $fetchxkeyQuery->getRow();
        $x_api_key = $xkey->x_api_key;
    
        if ($apiKeyValue != $x_api_key) {
    
            return json_encode([
                'message' => "fail",
                'result'  => "",
                'error_msg' => "Api Token Not Matched"
            ]);
        }
        
        $userId = $this->request->getVar('userId');

    
        if (!$userId) {
            return json_encode([
                'message' => "fail",
                'result' => "",
                'error_msg' => "userId is required"
            ]);
        }
    
        // ----------------------------------------------------
        // FETCH ALL USERS + TECHNICIANS + ROLE
        // ----------------------------------------------------
        $query = $db->table('technicians t')
            ->select("
                u.id AS userId,
                u.name,
                u.email,
                u.phoneNumber,
    
                t.id AS technicianRecordId,
                t.technicianId,
                t.licenceNumber,
                t.shiftTime,
                t.tradeTypeId,
                tt.tradeType,
    
                ur.roleId
            ")
            ->join('users u', 'u.id = t.userId', 'left')
            ->join('user_role ur', 'ur.userId = u.id', 'left')
            ->join('trade_types tt', 'tt.id = t.tradeTypeId', 'left')
            ->where('t.isDelete', 0)
            ->get()
            ->getResult();
    
        // ----------------------------------------------------
        // SEPARATE ARRAYS BASED ON ROLE ID
        // ----------------------------------------------------
        $data = [
            "purchaseUsers"  => [], // roleId = 1
            "orderUsers"     => [], // roleId = 2
        ];
    
        foreach ($query as $item) {
    
            $userArray = [
                "userId"              => $item->userId,
                "name"                => $item->name,
                "email"               => $item->email,
                "phoneNumber"         => $item->phoneNumber,
    
                "technicianRecordId"  => $item->technicianRecordId,
                "technicianId"        => $item->technicianId,
                "licenceNumber"       => $item->licenceNumber,
                "shiftTime"           => $item->shiftTime,
    
                "tradeTypeId"         => $item->tradeTypeId,
                "tradeType"           => $item->tradeType,
                "roleId"              => $item->roleId
            ];
    
            if ($item->roleId == 1) {
                $data["purchaseUsers"][] = $userArray;
            }
            elseif ($item->roleId == 2) {
                $data["orderUsers"][] = $userArray;
            }
        }
    
              // ----------------------------------------------------
        // FETCH SITES ASSIGNED TO TECHNICIAN (JOIN WITH sites)
        // ----------------------------------------------------
        $siteRows = $db->table('site_technicians st')
            ->select("
                st.id AS siteTechnicianId, 
                s.id AS siteId,
                s.siteName AS siteName, 
                s.location
            ")
            ->join('sites s', 's.id = st.siteId', 'left')
            ->where('st.userId', $userId)
            ->where('st.isDelete', 0)
            ->where('s.isDelete', 0)   // Optional: To avoid deleted sites
            ->groupBy('s.id')          // If same technician assigned multiple times
            ->get()
            ->getResult();
        
        $sites = [];
        
        foreach ($siteRows as $sp) {
            $sites[] = [
                "siteId"   => $sp->siteId,
                "siteName" => $sp->siteName,
                "location" => $sp->location
            ];
        }
              // -----------------------------------------
    // FETCH MATERIAL LIST WITH REQUIRED JOINS
    // -----------------------------------------
    $materialRows = $db->table('material_master mm')
        ->select("
            mm.id AS materialId,
            mm.materialName,
            mm.catType,
            mm.qty,
            mm.unit,
            mm.rate,
            mm.description,
            mm.code,
            mm.expenseType,
            sc.subCatName,
            mc.mainCatName
        ")
        ->join('material_sub_category sc', 'sc.id = mm.catType', 'left')
        ->join('material_main_category mc', 'mc.id = sc.mainCatId', 'left')
        ->where('mm.isDelete', 0)
        ->where('sc.isDelete', 0)
        ->where('mc.isDelete', 0)
        ->get()
        ->getResult();

    // -----------------------------------------
    // MAP DATA INTO CLEAN JSON ARRAY
    // -----------------------------------------
    $materials = [];

    foreach ($materialRows as $mt) {
        $materials[] = [
            "materialId"    => $mt->materialId,
            "materialName"  => $mt->materialName,
            "mainCatName"   => $mt->mainCatName,
            "subCatName"    => $mt->subCatName,
            "qty"           => $mt->qty,
            "unit"          => $mt->unit,
            "rate"          => $mt->rate,
            "description"   => $mt->description,
            "code"          => $mt->code,
            "expenseType"   => $mt->expenseType
        ];
    }
        
        // Material Unites
        
         $units = $db->table('material_units')
            ->where('isDelete', '0')
            ->get()
            ->getResult();
    
        $material_units = [];
    
        foreach ($units as $st) {
            $material_units[] = array(
                'id'       => $st->id,
                'unitName' => $st->unitName
            );
        }
        
        // ----------------------------------------------------
        // FETCH MATERIAL REQUISITION REQUEST – LAST 15 DAYS
        // ----------------------------------------------------
        $reqRows = $db->table('material_requisiution_request mrr')
            ->select("
                mrr.id,
                mrr.requestedBy,
                mrr.givenTo,
                mrr.givenBy,
                mrr.materialId,
                mrr.quantityRequested,
                mrr.unit,
                mrr.note,
                mrr.adminNote,
                mrr.requestStatus,
                mrr.createdAt,
        
                s.siteName,
                u1.name AS requestedByName,
                u2.name AS givenByName,
                mm.materialName
            ")
            ->join('sites s', 's.id = mrr.givenTo', 'left')
            ->join('users u1', 'u1.id = mrr.requestedBy', 'left')
            ->join('users u2', 'u2.id = mrr.givenBy', 'left')
            ->join('material_master mm', 'mm.id = mrr.materialId', 'left')
            ->where('mrr.isDelete', 0)
            ->where('mrr.createdAt >=', date('Y-m-d H:i:s', strtotime('-15 days')))
            ->orderBy('mrr.createdAt', 'DESC')
            ->get()
            ->getResult();
        
        // Convert Status Number → Text
        $materialRequisition = [];
        
        foreach ($reqRows as $r) {
        
            $statusText = "Pending";
            if ($r->requestStatus == 1) $statusText = "Approved";
            elseif ($r->requestStatus == 2) $statusText = "Disapproved";
        
            $materialRequisition[] = [
                "id"                => $r->id,
        
                // Users
                "requestedBy"       => $r->requestedBy,
                "requestedByName"   => $r->requestedByName,
                "givenBy"           => $r->givenBy,
                "givenByName"       => $r->givenByName,
        
                // Site
                "siteId"            => $r->givenTo,
                "siteName"          => $r->siteName,
        
                // Material
                "materialId"        => $r->materialId,
                "materialName"      => $r->materialName,
        
                // Other Fields
                "quantityRequested" => $r->quantityRequested,
                "unit"              => $r->unit,
                "note"              => $r->note,
                "adminNote"         => $r->adminNote,
                "status"            => $statusText,
                "createdAt"         => $r->createdAt
            ];
        }

        
        // ----------------------------------------------------
        // FINAL RESPONSE
        // ----------------------------------------------------
        return $this->response->setJSON([
            "message"   => "Success",
            "result"    => [
                "purchaseUsers" => $data["purchaseUsers"],
                "orderUsers"    => $data["orderUsers"],
                "sites"         => $sites,
                "materials"      => $materials,
                "material_units"   => $material_units,
                "material_requisition" => $materialRequisition
            ],
            "error_msg" => "All Manage dropdowns"
        ]);

    }

    public function stock_register()
    {
    $db = \Config\Database::connect();

    // Validate API Key
    $apiKey = $this->request->getHeader('X-API-KEY');
    $apiKeyValue = $apiKey ? $apiKey->getValue() : '';

    $xkey = $db->query("SELECT x_api_key FROM x_api_key")->getRow();
    if (!$xkey || $apiKeyValue != $xkey->x_api_key) {
        return $this->response->setJSON([
            'message'   => "fail",
            'result'    => "",
            'error_msg' => "Api Token Not Matched"
        ]);
    }

    $siteId = $this->request->getVar('siteId');

    if (!$siteId) {
        return $this->response->setJSON([
            'message' => "fail",
            'result'  => "",
            'error_msg' => "siteId is required"
        ]);
    }


    // ------------------------------------------------------
    // 1️⃣ FETCH RECEIVED MATERIALS (CASH + DEALER)
    // ------------------------------------------------------

    // CASH PURCHASES
    $cash = $db->query("
        SELECT 
            mpi.materialId,
            SUM(mpi.qty) AS received_qty,
            mpi.unit,
            mm.materialName
        FROM material_purchase_cash mp
        JOIN material_purchase_items mpi ON mpi.purchaseId = mp.id
        JOIN material_master mm ON mm.id = mpi.materialId
        WHERE mp.siteId = '$siteId'
        GROUP BY mpi.materialId
    ")->getResultArray();

    // DEALER PURCHASES
    $dealer = $db->query("
        SELECT 
            mpid.materialId,
            SUM(mpid.qty) AS received_qty,
            mpid.unit,
            mm.materialName
        FROM material_purchase_dealer mpd
        JOIN material_purchase_items_dealer mpid ON mpid.purchaseId = mpd.id
        JOIN material_master mm ON mm.id = mpid.materialId
        WHERE mpd.siteId = '$siteId'
        GROUP BY mpid.materialId
    ")->getResultArray();


    // MERGE RECEIVED STOCK BY materialId
    $received = [];

    foreach ($cash as $row) {
        $id = $row['materialId'];
        $received[$id] = [
            "materialId" => $id,
            "materialName" => $row['materialName'],
            "unit" => $row['unit'],
            "received" => (float)$row['received_qty'],
            "used" => 0,
            "balance" => 0,
        ];
    }

    foreach ($dealer as $row) {
        $id = $row['materialId'];

        if (!isset($received[$id])) {
            $received[$id] = [
                "materialId" => $id,
                "materialName" => $row['materialName'],
                "unit" => $row['unit'],
                "received" => 0,
                "used" => 0,
                "balance" => 0,
            ];
        }

        $received[$id]['received'] += (float)$row['received_qty'];
    }


    // ------------------------------------------------------
    // 2️⃣ FETCH USED / CONSUMED MATERIALS
    // ------------------------------------------------------

    $usedData = $db->query("
        SELECT 
            materialId,
            SUM(qtyMaterialConsumed) AS used_qty
        FROM daily_work_progress
        WHERE siteId = '$siteId' AND isDelete = 0
        GROUP BY materialId
    ")->getResultArray();

    foreach ($usedData as $row) {
        $id = $row['materialId'];

        if (!isset($received[$id])) {
            // Material appears ONLY in daily_work_progress
            $received[$id] = [
                "materialId" => $id,
                "materialName" => "",
                "unit" => "",
                "received" => 0,
                "used" => (float)$row['used_qty'],
                "balance" => 0,
            ];
        } else {
            $received[$id]['used'] = (float)$row['used_qty'];
        }
    }


    // ------------------------------------------------------
    // 3️⃣ CALCULATE BALANCE
    // ------------------------------------------------------
    foreach ($received as $id => $row) {
        $received[$id]['balance'] = $row['received'] - $row['used'];
    }

    // Reset array index
    $stock = array_values($received);


    // ------------------------------------------------------
    // FINAL RESPONSE
    // ------------------------------------------------------
    return $this->response->setJSON([
        "message" => "Success",
        "result" => [
            "stock" => $stock
        ],
        "error_msg" => "Stock Register"
    ]);
}

    public function site_expense_dropdowns()
    {
        $db = \Config\Database::connect();
        
         // Retrieve API Key from the request header
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey ? $apiKey->getValue() : '';
    
        // Fetch stored API Key
        $fetchxkeyQuery = $db->query("SELECT * FROM x_api_key");
        $xkey = $fetchxkeyQuery->getRow();
        $x_api_key = $xkey->x_api_key;
    
        if ($apiKeyValue != $x_api_key) {
    
            return json_encode([
                'message' => "fail",
                'result'  => "",
                'error_msg' => "Api Token Not Matched"
            ]);
        }
        
        $siteId = $this->request->getVar('siteId');

    
        if (!$siteId) {
            return json_encode([
                'message' => "fail",
                'result' => "",
                'error_msg' => "siteId is required"
            ]);
        }

        // ----------------------------------------------------
        // FETCH SITES Category Head
        // ----------------------------------------------------
        
        $expenseHeadRows = $db->table('material_sub_category st')
            ->select("
                st.id AS id, 
                st.subCatName AS subCatName
            ")
            ->where('st.isDelete', 0)
            ->get()
            ->getResult();
        
        $expenseHead = [];
        
        foreach ($expenseHeadRows as $sp) {
            $expenseHead[] = [
                "catId"   => $sp->id,
                "subCatName" => $sp->subCatName
            ];
        }
        
        
        // ----------------------------------------------------
        // FETCH SITES Paid By
        // ----------------------------------------------------
        
        $paidBy = $db->table('users')
            ->select("
                id, 
                name,
                email,
                phoneNumber
            ")
            ->where('isDelete', 0)
            ->get()
            ->getResult();
        
        $paidbyname = [];
        
        foreach ($paidBy as $us) {
            $paidbyname[] = [
                "userid"   => $us->id,
                "name" => $us->name,
                "email" => $us->email,
                "phoneNumber" => $us->phoneNumber
            ];
        }
        
        // Site Expenses
        
        $sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));
        
            
      $siteExpense = $db->table('site_expenses_tracker se')
                        ->select("
                            se.id,
                            se.headCategory,
                            st.subCatName AS headCategoryName,
                            se.paidTo,
                            se.paidBy,
                            u.name AS paidByName,
                            se.amount,
                            se.supportingBill,
                            se.createdAt
                        ")
                        ->join('material_sub_category st', 'st.id = se.headCategory', 'left')
                        ->join('users u', 'u.id = se.paidBy', 'left')   // <-- JOIN USERS TABLE
                        ->where('se.siteId', $siteId)
                        ->where('se.isDelete', 0)
                        ->where('se.createdAt >=', $sevenDaysAgo)
                        ->orderBy('se.id', 'DESC')
                        ->get()
                        ->getResult();

    
        $siteExpenseTracker = [];
        foreach ($siteExpense as $et) {
            $siteExpenseTracker[] = [
                "id"               => $et->id,
                "headCategory"     => $et->headCategory,
                "headCategoryName" => $et->headCategoryName,
                "paidTo"           => $et->paidTo,
                "paidBy"           => $et->paidByName,
                "amount"           => $et->amount,
                "supportingBill"   => $et->supportingBill ? SITE_DOCUMENT . $et->supportingBill : "",
                "createdAt"        => $et->createdAt
            ];
        }
        
        // ----------------------------------------------------
        // FINAL RESPONSE
        // ----------------------------------------------------
        return $this->response->setJSON([
            "message"   => "Success",
            "result"    => [
                "expensehead"         => $expenseHead,
                "paidby"         => $paidbyname,
                "recentexpenselog"         => $siteExpenseTracker
            ],
            "error_msg" => "Site Expenses Tracker"
        ]);

    } 
    
    public function add_site_expese()
    {
        $db = \Config\Database::connect();
    
        // ------------------------------
        // Validate API Key
        // ------------------------------
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey ? $apiKey->getValue() : '';
    
        $xkey = $db->query("SELECT x_api_key FROM x_api_key")->getRow();
        if (!$xkey || $apiKeyValue != $xkey->x_api_key) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "Api Token Not Matched"
            ]);
        }
    
        // ------------------------------
        // Required Inputs
        // ------------------------------
        $siteId       = $this->request->getVar('siteId');
        $headCategory = $this->request->getVar('headCategory');
        $paidTo       = $this->request->getVar('paidTo');
        $paidBy       = $this->request->getVar('paidBy');
        $amount       = $this->request->getVar('amount');
    
        $supportingBill = $this->request->getFile('supportingBill');
    
        if (!$siteId) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "siteId is required"
            ]);
        }
    
        // ----------------------------
        // FILE UPLOAD
        // ----------------------------
        $supportingBillName = null;
    
        if ($supportingBill && $supportingBill->isValid()) {
            $supportingBillName = time() . '_' . $supportingBill->getName();
            $supportingBill->move('uploads/site_documents', $supportingBillName);
        }
    
        $currentDate = date('Y-m-d H:i:s');
    
        // ------------------------------
        // Insert
        // ------------------------------
        $insertData = [
            "siteId"         => $siteId,
            "headCategory"   => $headCategory,
            "paidTo"         => $paidTo,
            "paidBy"         => $paidBy,
            "amount"         => $amount,
            "supportingBill" => $supportingBillName,
            "isDelete"       => 0,
            "createdAt"      => $currentDate
        ];
    
        $db->table('site_expenses_tracker')->insert($insertData);
        $insertId = $db->insertID();
    
        // ---------------------------------------------------
        // FETCH NEWLY ADDED EXPENSE
        // ---------------------------------------------------
        
        // ---------------------------------------------------
        // FETCH NEWLY ADDED EXPENSE WITH HEAD CATEGORY NAME
        // ---------------------------------------------------
        $newExpense = $db->table('site_expenses_tracker se')
            ->select("
                se.id,
                se.headCategory,
                st.subCatName AS headCategoryName,
                se.paidTo,
                se.paidBy,
                se.amount,
                se.supportingBill,
                se.createdAt
            ")
            ->join('material_sub_category st', 'st.id = se.headCategory', 'left')
            ->where('se.id', $insertId)
            ->get()
            ->getRow();
    
        // Append image path
        if ($newExpense) {
            $newExpense->supportingBill = $newExpense->supportingBill 
                ? SITE_DOCUMENT . $newExpense->supportingBill 
                : "";
        }
    
        // ---------------------------------------------------
        // FETCH LAST 7 DAYS EXPENSES
        // ---------------------------------------------------
          $sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));

    $siteExpense = $db->table('site_expenses_tracker se')
        ->select("
            se.id,
            se.headCategory,
            st.subCatName AS headCategoryName,
            se.paidTo,
            se.paidBy,
            se.amount,
            se.supportingBill,
            se.createdAt
        ")
        ->join('material_sub_category st', 'st.id = se.headCategory', 'left')
        ->where('se.siteId', $siteId)
        ->where('se.isDelete', 0)
        ->where('se.createdAt >=', $sevenDaysAgo)
        ->orderBy('se.id', 'DESC')
        ->get()
        ->getResult();

    $siteExpenseTracker = [];
    foreach ($siteExpense as $et) {
        $siteExpenseTracker[] = [
            "id"               => $et->id,
            "headCategory"     => $et->headCategory,
            "headCategoryName" => $et->headCategoryName,
            "paidTo"           => $et->paidTo,
            "paidBy"           => $et->paidBy,
            "amount"           => $et->amount,
            "supportingBill"   => $et->supportingBill ? SITE_DOCUMENT . $et->supportingBill : "",
            "createdAt"        => $et->createdAt
        ];
    }
    
        // ------------------------------
        // Response
        // ------------------------------
        return $this->response->setJSON([
            'message'   => "Success",
            'result'    => [
                "newExpense"  => $newExpense,
                "recent7Days" => $siteExpenseTracker
            ],
            'error_msg' => "Expense Added Successfully"
        ]);
    }
    
    
    public function site_accounts_dropdowns()
    {
        $db = \Config\Database::connect();
        
         // Retrieve API Key from the request header
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey ? $apiKey->getValue() : '';
    
        // Fetch stored API Key
        $fetchxkeyQuery = $db->query("SELECT * FROM x_api_key");
        $xkey = $fetchxkeyQuery->getRow();
        $x_api_key = $xkey->x_api_key;
    
        if ($apiKeyValue != $x_api_key) {
    
            return json_encode([
                'message' => "fail",
                'result'  => "",
                'error_msg' => "Api Token Not Matched"
            ]);
        }
        
        $siteId = $this->request->getVar('siteId');

    
        if (!$siteId) {
            return json_encode([
                'message' => "fail",
                'result' => "",
                'error_msg' => "siteId is required"
            ]);
        }

        // ----------------------------------------------------
        // FETCH SITES Category Head
        // ----------------------------------------------------
        
        $expenseHeadRows = $db->table('other_expense_heads')
            ->select("*")
            ->where('other_expense_heads.isDelete', 0)
            ->get()
            ->getResult();
        
        $expenseHead = [];
        
        foreach ($expenseHeadRows as $sp) {
            $expenseHead[] = [
                "id"   => $sp->id,
                "name" => $sp->name
            ];
        }
        
        
        // ----------------------------------------------------
        // FETCH SITES Paid By
        // ----------------------------------------------------
        
        $paidBy = $db->table('users')
            ->select("
                id, 
                name,
                email,
                phoneNumber
            ")
            ->where('isDelete', 0)
            ->get()
            ->getResult();
        
        $paidbyname = [];
        
        foreach ($paidBy as $us) {
            $paidbyname[] = [
                "userid"   => $us->id,
                "name" => $us->name,
                "email" => $us->email,
                "phoneNumber" => $us->phoneNumber
            ];
        }
        
        // Site Expenses
        
        $sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));
        
            
      $siteExpense = $db->table('site_other_expenses se')
                        ->select("
                            se.id,
                            se.headCategory,
                            st.name AS headCategoryName,
                            se.paidTo,
                            se.paidBy,
                            u.name AS paidByName,
                            se.amount,
                            se.note,
                            se.createdAt
                        ")
                        ->join('other_expense_heads st', 'st.id = se.headCategory', 'left')
                        ->join('users u', 'u.id = se.paidBy', 'left')   // <-- JOIN USERS TABLE
                        ->where('se.siteId', $siteId)
                        ->where('se.isDelete', 0)
                        ->where('se.createdAt >=', $sevenDaysAgo)
                        ->orderBy('se.id', 'DESC')
                        ->get()
                        ->getResult();

    
        $siteExpenseTracker = [];
        foreach ($siteExpense as $et) {
            $siteExpenseTracker[] = [
                "id"               => $et->id,
                "headCategory"     => $et->headCategory,
                "headCategoryName" => $et->headCategoryName,
                "paidTo"           => $et->paidTo,
                "paidBy"           => $et->paidByName,
                "amount"           => $et->amount,
                "note"             => $et->note,
                "createdAt"        => $et->createdAt
            ];
        }
        
        
        // ---------------------------------------------
        // TOTAL: Material Purchase (Cash)
        // ---------------------------------------------
        $cashTotal = $db->table('material_purchase_cash')
                        ->selectSum('totalBillAmt', 'total')
                        ->where('siteId', $siteId)
                        ->where('isDelete', 0)
                        ->get()
                        ->getRow()
                        ->total ?? 0;
        
        // ---------------------------------------------
        // TOTAL: Material Purchase (Dealer)
        // ---------------------------------------------
        $dealerTotal = $db->table('material_purchase_dealer')
                        ->selectSum('totalBillAmt', 'total')
                        ->where('siteId', $siteId)
                        ->where('isDelete', 0)
                        ->get()
                        ->getRow()
                        ->total ?? 0;
        
        // ---------------------------------------------
        // TOTAL: Total Site Expenses (site_expenses_tracker)
        // ---------------------------------------------
        $siteExpenseTotal = $db->table('site_expenses_tracker')
                              ->selectSum('amount', 'total')
                              ->where('siteId', $siteId)
                              ->where('isDelete', 0)
                              ->get()
                              ->getRow()
                              ->total ?? 0;
        
        // ---------------------------------------------
        // TOTAL: Total Accounts Expense (site_other_expenses)
        // ---------------------------------------------
        $accountsExpenseTotal = $db->table('site_other_expenses')
                                  ->selectSum('amount', 'total')
                                  ->where('siteId', $siteId)
                                  ->where('isDelete', 0)
                                  ->get()
                                  ->getRow()
                                  ->total ?? 0;

        
        // ----------------------------------------------------
        // FINAL RESPONSE
        // ----------------------------------------------------
      return $this->response->setJSON([
                    "message"   => "Success",
                    "result"    => [
                        
                         // ADD TOTALS HERE
                        "materialPurchaseCashTotal"   => (float)$cashTotal,
                        "materialPurchaseDealerTotal" => (float)$dealerTotal,
                        "totalSiteExpenses"           => (float)$siteExpenseTotal,
                        "totalAccountsExpenses"       => (float)$accountsExpenseTotal,
                        
                        "expensehead"           => $expenseHead,
                        "recentexpenselog"      => $siteExpenseTracker
                

                    ],
                    "error_msg" => "Account Expenses Tracker"
                ]);


    } 

    public function add_account_expese()
    {
        $db = \Config\Database::connect();
    
        // ------------------------------
        // Validate API Key
        // ------------------------------
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey ? $apiKey->getValue() : '';
    
        $xkey = $db->query("SELECT x_api_key FROM x_api_key")->getRow();
        if (!$xkey || $apiKeyValue != $xkey->x_api_key) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "Api Token Not Matched"
            ]);
        }
    
        // ------------------------------
        // Required Inputs
        // ------------------------------
        $siteId       = $this->request->getVar('siteId');
        $headCategory = $this->request->getVar('headCategory');
        $paidTo       = $this->request->getVar('paidTo');
        $paidBy       = $this->request->getVar('paidBy');
        $amount       = $this->request->getVar('amount');
        $note       = $this->request->getVar('note');
    

    
        if (!$siteId) {
            return $this->response->setJSON([
                'message'   => "fail",
                'result'    => "",
                'error_msg' => "siteId is required"
            ]);
        }
    

        $currentDate = date('Y-m-d H:i:s');
    
        // ------------------------------
        // Insert
        // ------------------------------
        $insertData = [
            "siteId"         => $siteId,
            "headCategory"   => $headCategory,
            "paidTo"         => $paidTo,
            "paidBy"         => $paidBy,
            "amount"         => $amount,
            "note"          => $note,
            "isDelete"       => 0,
            "createdAt"      => $currentDate
        ];
    
        $db->table('site_other_expenses')->insert($insertData);
        $insertId = $db->insertID();
    
        // ---------------------------------------------------
        // FETCH NEWLY ADDED EXPENSE
        // ---------------------------------------------------
        
        // ---------------------------------------------------
        // FETCH NEWLY ADDED EXPENSE WITH HEAD CATEGORY NAME
        // ---------------------------------------------------
        $newExpense = $db->table('site_other_expenses se')
            ->select("
                se.id,
                se.headCategory,
                st.name AS headCategoryName,
                se.paidTo,
                se.paidBy,
                se.amount,
                se.note,
                se.createdAt
            ")
            ->join('other_expense_heads st', 'st.id = se.headCategory', 'left')
            ->where('se.id', $insertId)
            ->get()
            ->getRow();
    
        // ---------------------------------------------------
        // FETCH LAST 7 DAYS EXPENSES
        // ---------------------------------------------------
          $sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));

        $siteExpense = $db->table('site_other_expenses se')
        ->select("
            se.id,
            se.headCategory,
            st.name AS headCategoryName,
            se.paidTo,
            se.paidBy,
            se.amount,
            se.note,
            se.createdAt
        ")
        ->join('other_expense_heads st', 'st.id = se.headCategory', 'left')
        ->where('se.siteId', $siteId)
        ->where('se.isDelete', 0)
        ->where('se.createdAt >=', $sevenDaysAgo)
        ->orderBy('se.id', 'DESC')
        ->get()
        ->getResult();

    $siteExpenseTracker = [];
    foreach ($siteExpense as $et) {
        $siteExpenseTracker[] = [
            "id"               => $et->id,
            "headCategory"     => $et->headCategory,
            "headCategoryName" => $et->headCategoryName,
            "paidTo"           => $et->paidTo,
            "paidBy"           => $et->paidBy,
            "amount"           => $et->amount,
            "note"             => $et->note,
            "createdAt"        => $et->createdAt
        ];
    }
    
        // ------------------------------
        // Response
        // ------------------------------
        return $this->response->setJSON([
            'message'   => "Success",
            'result'    => [
                "newExpense"  => $newExpense,
                "recent7Days" => $siteExpenseTracker
            ],
            'error_msg' => "Expense Added Successfully"
        ]);
    }
    
    public function get_dpr_dropdown()
    {
        $db = \Config\Database::connect();
        
         // Retrieve API Key from the request header
        $apiKey = $this->request->getHeader('X-API-KEY');
        $apiKeyValue = $apiKey ? $apiKey->getValue() : '';
    
        // Fetch stored API Key
        $fetchxkeyQuery = $db->query("SELECT * FROM x_api_key");
        $xkey = $fetchxkeyQuery->getRow();
        $x_api_key = $xkey->x_api_key;
    
        if ($apiKeyValue != $x_api_key) {
    
            return json_encode([
                'message' => "fail",
                'result'  => "",
                'error_msg' => "Api Token Not Matched"
            ]);
        }
        
        $siteId = $this->request->getVar('siteId');

    
        if (!$siteId) {
            return json_encode([
                'message' => "fail",
                'result' => "",
                'error_msg' => "siteId is required"
            ]);
        }
        
        $dprDate = date('Y-m-d');
        
         $dprRows = $db->table('daily_work_progress')
        ->where('siteId', $siteId)
        ->where('isDelete', 0)
        ->where("DATE(createdAt)", $dprDate) // *** FILTER HERE ***
        ->get()
        ->getResult();
        
        $dailyProgress = [];
        foreach ($dprRows as $dpr) {
            $dailyProgress[] = [
                "id"                   => $dpr->id,
                "siteId"               => $dpr->siteId,
                "activityPerform"      => $dpr->activityPerform,
                "location"             => $dpr->location,
                "qtyOfWork"            => $dpr->qtyOfWork,
                "qtyMaterialConsumed"  => $dpr->qtyMaterialConsumed,
                "createdAt"            => $dpr->createdAt
            ];
        }
              // -----------------------------------------
    // FETCH MATERIAL LIST WITH REQUIRED JOINS
    // -----------------------------------------
    $materialRows = $db->table('material_master mm')
        ->select("
            mm.id AS materialId,
            mm.materialName,
            mm.catType,
            mm.qty,
            mm.unit,
            mm.rate,
            mm.description,
            mm.code,
            mm.expenseType,
            sc.subCatName,
            mc.mainCatName
        ")
        ->join('material_sub_category sc', 'sc.id = mm.catType', 'left')
        ->join('material_main_category mc', 'mc.id = sc.mainCatId', 'left')
        ->where('mm.isDelete', 0)
        ->where('sc.isDelete', 0)
        ->where('mc.isDelete', 0)
        ->get()
        ->getResult();

    // -----------------------------------------
    // MAP DATA INTO CLEAN JSON ARRAY
    // -----------------------------------------
    $materials = [];

    foreach ($materialRows as $mt) {
        $materials[] = [
            "materialId"    => $mt->materialId,
            "materialName"  => $mt->materialName,
            "mainCatName"   => $mt->mainCatName,
            "subCatName"    => $mt->subCatName,
            "qty"           => $mt->qty,
            "unit"          => $mt->unit,
            "rate"          => $mt->rate,
            "description"   => $mt->description,
            "code"          => $mt->code,
            "expenseType"   => $mt->expenseType
        ];
    }
        
        // Material Unites
        
         $units = $db->table('material_units')
            ->where('isDelete', '0')
            ->get()
            ->getResult();
    
        $material_units = [];
    
        foreach ($units as $st) {
            $material_units[] = array(
                'id'       => $st->id,
                'unitName' => $st->unitName
            );
        }
        // ----------------------------------------------------
        // FINAL RESPONSE
        // ----------------------------------------------------
        return $this->response->setJSON([
            "message"   => "Success",
            "result"    => [
                "materials"      => $materials,
                "material_units"   => $material_units,
                "dailyProgress"   => $dailyProgress
            ],
            "error_msg" => "All Dpr dropdowns"
        ]);

    }

}
