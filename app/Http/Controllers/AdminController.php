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
            "EmployeeCount" => "required|integer",
            "Manager" => "required",
            "branchCode" => "required"
        ]);

        $return =[
            "status" =>0,
            "message" =>$validate->errors()
        ];

        if (!$validate->fails()) {

            $tosave=[
                "BranchCode" => $var->branchCode,
                "Description" => $var->Description,
                "Address" => $var->Address,
                "Manager" => $var->Manager,
                "NoEmployees" => $var->EmployeeCount,
            ];
            
            if (isset($var->id) && !empty($var->id)) {
                
                tblBranches::where(['id' => $var->id])->update($tosave);

                $return =[
                    "status" =>1,
                    "message" =>"Updated Successfuly"
                ];

            }else{

                tblBranches::create($tosave);

                $return =[
                    "status" =>1,
                    "message" =>"Saved Successfuly"
                ];
            }

        }

        return $return;
    }
    
    public function BranchDtable()
    {
        $branch = tblBranches::select(['id','BranchCode', 'Description', 'Address', 'Manager', 'NoEmployees'])->orderBy('id','desc')->get();
        $branchArray = array();
        $count=0;
        
        foreach ($branch as $key => $row) {

            $actionButton = "<div class='btn-group btn-group-sm'>                                           
                                    <a class='btn btn-success edit' data-id='{$row->id}'><i class='fa fa-edit'></i></a>
                                    <a class='btn btn-danger' data-id='{$row->id}'><i class='fa fa-trash'></i></a>
                                </div>";

            $branchArray[$count++] = array(
                $row->id,
                $row->BranchCode,
                $row->Description,
                $row->Address,
                $row->Manager,
                $row->NoEmployees,
                $actionButton
            );
        }

        $result['data'] = $branchArray;

        return  json_encode($result);
    }

    public function editBranch(Request $request){
        $var = (object) $request->all();

        $result=[
            'data' => "",
            'status' => 0
        ];
        
        $branch = tblBranches::where(['id' => $var->id])->first();

        if (!empty($branch)) {
            $result=[
                'data' => $branch,
                'status' => 1
            ];    
        }

        return $result;
    }
}
