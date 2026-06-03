<?php

namespace App\Controllers\Clients;

use App\Models\AuthenticationModel;
use App\Models\Clients;
use App\Models\ContactListModel;
use App\Models\ContactNumberModel;
use App\Models\Setting;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ClientsController extends Controller
{
    public function __construct()
    {
        $this->setting = new Setting();
        $this->client = new Clients();
        $this->contactList = new ContactListModel();
        $this->contactNumber = new ContactNumberModel();
        $this->authentication = new AuthenticationModel();
        $this->db = \Config\Database::connect();
    }

    public function clients()
    {
        $data['title'] = 'Clients List';

        return view('Admin/client_list', ['data' => $data]);
    }

    public function getClientsList()
    {
        $draw = $_POST['draw'];
        $row = $_POST['start'];
        $rowperpage = $_POST['length'];

        $columnIndex = $_POST['order'][0]['column'];
        $columnName = $_POST['columns'][$columnIndex]['data'];
        $columnSortOrder = $_POST['order'][0]['dir'];
        $searchValue = trim($_POST['search']['value']);

        $totalRecords = $this->client->where('isDelete', 0)->countAllResults();

        if ($columnName == '') {
            $order = ' ORDER BY id DESC';
        } else {
            $order = " ORDER BY $columnName $columnSortOrder ";
        }

        if (!empty($searchValue)) {
            $search = ' WHERE isDelete = 0 
        AND (mobile LIKE ? OR balance LIKE ?)';
            $params = ["%$searchValue%", "%$searchValue%"];
        } else {
            $search = ' WHERE isDelete = 0';
            $params = [];
        }

        $query = $this->client->query(
            "SELECT * FROM clients $search $order LIMIT $row, $rowperpage",
            $params
        );

        $records = $query->getResult();

        $data = [];

        foreach ($records as $key) {
            $tc = $key->tc_file
                ? '<a href="'.base_url('uploads/'.$key->tc_file).'" target="_blank">Click to open</a>'
                : '-';

            $acceptance = $key->acceptance_letter
                ? '<a href="'.base_url('uploads/'.$key->acceptance_letter).'" target="_blank">Click to open</a>'
                : '-';

            $campaign = $key->campaign_details;

            $account = '
                <a href="'.base_url('admin/client-account-details/'.$key->id).'"
                class="btn btn-primary btn-sm">
                Account Details
                </a>';

            $action = '
                <div class="d-flex gap-1">

                    <button
                        type="button"
                        class="btn btn-sm btn-primary"
                        onclick="edit_client('.$key->id.')">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button
                        type="button"
                        class="btn btn-sm btn-danger"
                        onclick="delete_client('.$key->id.')">
                        <i class="fa fa-trash"></i>
                    </button>

                </div>';

            $data[] = [
                'name' => $key->name,
                'mobile' => $key->mobile,
                'password' => base64_decode($key->password),
                'balance' => $key->balance,
                'campaign_details' => $campaign,
                'account_details' => $account,
                'tc_file' => $tc,
                'acceptance_letter' => $acceptance,
                'action' => $action,
            ];
        }

        echo json_encode([
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecords,
            'data' => $data,   // ✅ ONLY FIX HERE (aaData removed)
        ]);
    }

    public function accountDetails($clientId)
    {
        $client = $this->client
            ->where('id', $clientId)
            ->first();

        if (!$client) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $lists = $this->contactList
            ->where('client_id', $clientId)
            ->findAll();

        return view(
            'Admin/account_details',
            [
                'client' => $client,
                'lists' => $lists,
            ]
        );
    }

    public function fetchClient()
    {
        $id = $this->request->getVar('id');
        $fetchData = $this->client->where('id', $id)->first();
        if (!empty($fetchData)) {
            $data['response'] = $fetchData;
        } else {
            $data['response'] = '';
        }
        echo json_encode($data);
    }

    public function addClient()
    {
        $id = $this->request->getPost('id');

        $data = [
            'name' => $this->request->getPost('name'),
            'mobile' => $this->request->getPost('mobile'),
            'password' => base64_encode($this->request->getPost('password')),
            'balance' => $this->request->getPost('balance'),
            'campaign_details' => $this->request->getPost('campaign_details'),
        ];

        $uploadPath = FCPATH.'uploads/';

        foreach (['tc_file', 'acceptance_letter'] as $fileField) {
            $file = $this->request->getFile($fileField);

            if ($file
                && $file->isValid()
                && !$file->hasMoved()) {
                $newName = time().'_'.$file->getRandomName();

                $file->move($uploadPath, $newName);

                $data[$fileField] = $newName;
            }
        }

        if (empty($id)) {
            $data['createdAt'] = date('Y-m-d H:i:s');

            $insert = $this->client->insert($data);

            echo $insert ? SUCCESS_CODE : FAILD_CODE;
        } else {
            $update = $this->client->update($id, $data);

            echo $update ? SUCCESS_CODE : FAILD_CODE;
        }
    }

    public function delete_client()
    {
        $id = $this->request->getVar('id');

        $res = $this->client->set(['isDelete' => '1'])->where('id', $id)->update();

        if ($res > 0) {
            echo SUCCESS_CODE;
        } else {
            echo FAILD_CODE;
        }
    }

    public function exportClientsExcel()
    {
        $searchValue = trim($this->request->getGet('search'));

        // ============================
        // QUERY (NO LIMIT)
        // ============================
        $builder = $this->db->table('clients');
        $builder->select('
        name,
        balance,
        mobile,
        email,
        createdAt
    ');
        $builder->where('isDelete', '0');

        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('name', $searchValue)
                ->orLike('email', $searchValue)
                ->orLike('mobile', $searchValue)
                ->groupEnd();
        }

        $builder->orderBy('id', 'DESC');
        $result = $builder->get()->getResultArray();

        // ============================
        // CREATE EXCEL
        // ============================
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header row
        $headers = [
            'Client Name',
            'Balance',
            'Phone Number',
            'Email',
            'Created Date',
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col.'1', $header);
            $sheet->getStyle($col.'1')->getFont()->setBold(true);
            ++$col;
        }

        // Data rows
        $row = 2;
        foreach ($result as $data) {
            $sheet->setCellValue('A'.$row, $data['name']);
            $sheet->setCellValue('B'.$row, $data['balance']);
            $sheet->setCellValue('C'.$row, $data['mobile']);
            $sheet->setCellValue('D'.$row, $data['email']);
            $sheet->setCellValue('E'.$row, date('d-m-Y', strtotime($data['createdAt'])));

            ++$row;
        }

        // Auto-size columns
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // ============================
        // DOWNLOAD
        // ============================
        $fileName = 'Clients_List_'.date('Ymd_His').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function createContactList()
    {
        $clientId = $this->request->getPost('client_id');

        $listName = trim(
            $this->request->getPost('list_name')
        );

        $importType = $this->request->getPost('import_type');

        $listId = $this->contactList->insert([
            'client_id' => $clientId,
            'list_name' => $listName,
            'total_numbers' => 0,
        ]);

        $total = 0;

        /*
        =====================================
        MANUAL NUMBERS
        =====================================
        */

        if ($importType == 'manual') {
            $numbers = $this->request
                ->getPost('mobile_numbers');

            $numbers = preg_split(
                '/[\s,]+/',
                $numbers
            );

            foreach ($numbers as $mobile) {
                $mobile = preg_replace(
                    '/\D/',
                    '',
                    trim($mobile)
                );

                if (strlen($mobile) < 10) {
                    continue;
                }

                $this->contactNumber->insert([
                    'contact_list_id' => $listId,
                    'mobile' => $mobile,
                ]);

                ++$total;
            }
        }

        /*
        =====================================
        EXCEL / CSV
        =====================================
        */

        if ($importType == 'excel') {
            $file = $this->request->getFile('file');

            if ($file && $file->isValid()) {
                $spreadsheet =
                \PhpOffice\PhpSpreadsheet\IOFactory::load(
                    $file->getTempName()
                );

                foreach (
                    $spreadsheet
                    ->getActiveSheet()
                    ->toArray() as $row
                ) {
                    $mobile = preg_replace(
                        '/\D/',
                        '',
                        $row[0]
                    );

                    if (empty($mobile)) {
                        continue;
                    }

                    $this->contactNumber->insert([
                        'contact_list_id' => $listId,
                        'mobile' => $mobile,
                    ]);

                    ++$total;
                }
            }
        }

        $this->contactList->update(
            $listId,
            ['total_numbers' => $total]
        );

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Contact list created successfully.',
        ]);
    }

    public function deleteContactList()
    {
        $id = $this->request->getPost('id');

        $this->contactList->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Contact list deleted successfully.',
        ]);
    }

    public function contactListNumbers($listId)
    {
        $list = $this->contactList
            ->find($listId);

        if (!$list) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $numbers = $this->contactNumber
            ->where(
                'contact_list_id',
                $listId
            )
            ->findAll();

        return view(
            'Admin/contact_list_numbers',
            [
                'list' => $list,
                'numbers' => $numbers,
            ]
        );
    }

    public function getContactListNumbers()
    {
        $listId = $this->request->getPost('list_id');

        $numbers = $this->contactNumber
            ->where('contact_list_id', $listId)
            ->findAll();

        $html = '';

        $html .= '
    <table class="table table-bordered">

        <thead>

        <tr>

            <th width="50">
                <input type="checkbox"
                       id="select_all">
            </th>

            <th>Mobile Number</th>
        </tr>

        </thead>

        <tbody>';

        foreach ($numbers as $row) {
            $html .= '

        <tr>

            <td>

                <input
                    type="checkbox"
                    class="number_checkbox"
                    value="'.$row['id'].'">

            </td>

            <td>'.$row['mobile'].'</td>

         

        </tr>';
        }

        $html .= '

        </tbody>

    </table>';

        return $html;
    }

    // <td>

    //     <button
    //         class="btn btn-danger btn-sm"
    //         onclick="deleteNumber('.$row['id'].')">

    //         Delete

    //     </button>

    // </td>

    public function deleteSelectedNumbers()
    {
        $ids = $this->request->getPost('ids');

        if (!empty($ids)) {
            $first = $this->contactNumber
                ->where('id', $ids[0])
                ->first();

            $listId = $first['contact_list_id'];

            $this->contactNumber
                ->whereIn('id', $ids)
                ->delete();

            $total = $this->contactNumber
                ->where('contact_list_id', $listId)
                ->countAllResults();

            $this->contactList->update(
                $listId,
                [
                    'total_numbers' => $total,
                ]
            );
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Selected numbers deleted.',
        ]);
    }

    public function addContactNumbers()
    {
        $listId = $this->request->getPost('list_id');

        $numbers = $this->request->getPost('numbers');

        $numbers = preg_split(
            '/[\s,]+/',
            $numbers
        );

        $count = 0;

        foreach ($numbers as $mobile) {
            $mobile = preg_replace(
                '/\D/',
                '',
                trim($mobile)
            );

            if (strlen($mobile) < 10) {
                continue;
            }

            $this->contactNumber->insert([
                'contact_list_id' => $listId,
                'mobile' => $mobile,
            ]);

            ++$count;
        }

        $total =
        $this->contactNumber
            ->where('contact_list_id', $listId)
            ->countAllResults();

        $this->contactList
            ->update(
                $listId,
                ['total_numbers' => $total]
            );

        return $this->response->setJSON([
            'status' => 'success',
            'message' => $count.' numbers added successfully.',
        ]);
    }

    public function deleteContactNumber()
    {
        $id = $this->request->getPost('id');

        $number = $this->contactNumber
            ->where('id', $id)
            ->first();

        if (!$number) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Number not found.',
            ]);
        }

        $listId = $number['contact_list_id'];

        $this->contactNumber->delete($id);

        $total = $this->contactNumber
            ->where('contact_list_id', $listId)
            ->countAllResults();

        $this->contactList->update(
            $listId,
            [
                'total_numbers' => $total,
            ]
        );

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Number deleted successfully.',
        ]);
    }
}
