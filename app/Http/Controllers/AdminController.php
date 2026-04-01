<?php

namespace App\Http\Controllers;
use App\Services\Users\AdminService;
use App\Models\Cases;
use App\Models\OrganizationProcess;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct(protected AdminService $adminservice){}
    
    
    /**
     * Mostrar vista de reportes
     */
    public function reports()
    {
        $data = $this->adminservice->getReportStats();
        return view('admin.reports', compact('data'));
    }

    /**
    * Mostrar vista de dashboard
    */
    public function dashboard()
    {
        $data = $this->adminservice->getDashboardStats();
        return view('admin.dashboard', compact('data'));
    }
}

