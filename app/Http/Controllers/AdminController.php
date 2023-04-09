<?php

namespace App\Http\Controllers;

use App\Models\tblBranches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Classes\Admin as AdminClass;

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

        $validate = Validator::make($request->all(),[
            "Address" => "required",
            "Description" => "required",
            "EmployeeCount" => "required|integer",
            "Manager" => "required",
            "branchCode" => "required|unique:tbl_branches,BranchCode,".$var->id
        ]);

        $return =[
            "status" =>0,
            "message" =>'Branch Code Already Exist.'
        ];

        if (!$validate->fails()) {

            $tosave=[
                "BranchCode" => strtoupper($var->branchCode),
                "Description" => $var->Description,
                "Address" => $var->Address,
                "Manager" => $var->Manager,
                "NoEmployees" => $var->EmployeeCount,
            ];
            
            if (isset($var->id) && !empty($var->id)) {    
                
                tblBranches::updateOrCreate(['id' => $var->id],$tosave);

                $return =[
                    "status" =>1,
                    "message" =>"Updated Successfuly."
                ];

            }else{
                $setTableSave = tblBranches::where(['BranchCode' => $var->branchCode])->first();

                if (isset($setTableSave) && !empty($setTableSave)) {
                    $return =[
                        "status" =>0,
                        "message" =>"Branch Code Already Exist."
                    ];
                }else{
                    tblBranches::create($tosave);
                    $return =[
                        "status" =>1,
                        "message" =>"Saved Successfuly."
                    ];
                }       
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
                                    <a class='btn btn-danger delete' data-id='{$row->id}'><i class='fa fa-trash'></i></a>
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

    public function deleteBranch(Request $request)
    {
        $var = (object) $request->all();

        $return = [
            'status' => 0,
            'message' => "An Error Occured"
        ];

        if (isset($var->id) && !empty($var->id)) {
            tblBranches::where(['id' => $var->id])->first()->delete();

            $return = [
                'status' => 1,
                'message' => "Deleted Succesfully"
            ];
        }
        
        return $return;
    }
}
