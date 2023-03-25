<?php

namespace App\Http\Controllers;

use App\Models\tblBranches;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AdminDashboard()
    {
        return view('Admin.dashboard');
    }

    public function BranchList()
    {
        $rsql = tblBranches::all();
        $data['list'] = $rsql;

        return view('Admin.branchlist',$data);
    }
}
