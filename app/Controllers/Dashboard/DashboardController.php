<?php

namespace App\Controllers\Dashboard;

use App\Models\Clients;
use App\Models\Site;
use App\Models\Users;
use CodeIgniter\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->clients = new Clients();
        $this->users = new Users();
        $this->site = new Site();
    }

    public function index()
    {
        $db = \Config\Database::connect();

        // Get current date and date of the previous month

        $currentMonth = date('Y-m');
        $previousMonth = date('Y-m', strtotime('-1 month'));

        $data['clients'] = $this->clients->where('isDelete', '0')->countAllResults();

        $data['technicians'] = $db->table('users')
                ->join('technicians', 'technicians.userId = users.id')
                ->where('users.isDelete', '0')
                ->where('technicians.isDelete', '0')
                ->countAllResults();

        $data['supplier'] = $db->table('suppliers')
                ->where('suppliers.isDelete', '0')
                ->countAllResults();

        $data['contractor'] = $db->table('contractor')
                ->where('contractor.isDelete', '0')
                ->countAllResults();

        $data['sites'] = $db->table('sites')
                ->where('sites.isDelete', '0')
                ->countAllResults();
        // echo $db->getLastQuery(); die;

        /*********** site pagination **************/
        $perPage = 8;

        // Ensure page variables are set correctly
        $activePage = $this->request->getVar('page_active') ?? 1;
        $completedPage = $this->request->getVar('page_completed') ?? 1;

        // Calculate offsets for pagination
        $offsetActive = ($activePage - 1) * $perPage;
        $offsetCompleted = ($completedPage - 1) * $perPage;

        // Fetch active and completed sites with pagination
        $data['activeSites'] = $this->site->getSites('0', $perPage, $offsetActive);
        $data['completedSites'] = $this->site->getSites('1', $perPage, $offsetCompleted);

        // Initialize pager service
        $pager = \Config\Services::pager();

        // Get counts for pagination
        $data['pager'] = $pager;
        $data['activeCount'] = $this->site->getCount('0');
        $data['completedCount'] = $this->site->getCount('1');

        // Pass current page numbers and perPage to the view
        $data['activePage'] = $activePage;
        $data['completedPage'] = $completedPage;
        $data['perPage'] = $perPage;
        /*************** end ********************/

        $data['title'] = 'Dashboard';

        return view('Admin/dashboard', ['data' => $data]);
    }

    public function manage_content()
    {
        $data['title'] = 'Report Reason';

        return view('Admin/static_contant', ['data' => $data]);
    }

    public function business_category()
    {
        $data['title'] = 'Business Category';

        return view('Admin/business_category', ['data' => $data]);
    }

    public function headquarters()
    {
        $data['title'] = 'Headquarters';

        return view('Admin/headquarters', ['data' => $data]);
    }

    public function cancel_reason()
    {
        $data['title'] = 'Cancel Reason';

        return view('Admin/cancel_reason', ['data' => $data]);
    }
}
