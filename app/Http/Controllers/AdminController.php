<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AdminDashboard()
    {
        $data['activeDash'] = 'active';

        return view('Admin.dashboard',$data);
    }
}
