<?php

namespace App\Http\Controllers;

use App\Models\tblBranches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function AddBranch(Request $request)
    {

        $var = (object) $request->all();
        // dd($var);

        $validate = Validator::make($request->all(),[
            "Address" => "required",
            "Description" => "required",
            "EmployeeCount" => "required",
            "Manager" => "required",
            "branchCode" => "required"
        ]);

        if ($validate->fails()) {
            return [
                "status" => "0",
                "message" => $validate->errors()
            ];
        }else{
            $save = tblBranches::updateOrCreate(
                [
                    "BranchCode" => $var->branchCode,
                ],[
                    "Description" => $var->Description,
                    "Address" => $var->Address,
                    "Manager" => $var->Manager,
                    "NoEmployees" => $var->EmployeeCount
                ]);

            return [
                "status" => "1",
                "message" => "Successfuly Saved"
            ];
        }
    }
    public function BranchDtable()
    {
        $users = tblBranches::select(['BranchCode', 'Description', 'Address', 'Manager', 'NoEmployees'])->get();
        $result['data'] = $users;
        
        return  json_encode($result);
    }
}
