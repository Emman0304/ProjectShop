<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Admin as AdminClass;
use App\Models\tblBranches;
use Illuminate\Support\Facades\Validator;

class BranchFileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function BranchList()
    {
        $AdminClass = new AdminClass;

        $data['activeBranch'] = 'active';
        $data['managers'] = $AdminClass->ManagersDropdown(['addBlank' => true]);

        return view('Admin.BranchFile.branchList',$data);
    }

    public function BranchDtable()
    {
        $branch = tblBranches::select(['id','BranchCode', 'Description', 'Address', 'Manager', 'NoEmployees'])->orderBy('id','desc')->get();
        $branchArray = array();
        $count=0;
        $AdminClass = new AdminClass;
        
        foreach ($branch as $key => $row) {

            $actionButton = "<div class='btn-group btn-group-sm'>                                           
                                    <a class='btn btn-success edit' data-id='{$row->id}'><i class='fa fa-edit'></i></a>
                                    <a class='btn btn-danger delete' data-id='{$row->id}'><i class='fa fa-trash'></i></a>
                                </div>";
            $mngrName = $AdminClass->ManagerName($row->Manager);

            $branchArray[$count++] = array(
                $row->id,
                $row->BranchCode,
                $row->Description,
                $row->Address,
                $mngrName,
                $row->NoEmployees,
                $actionButton
            );
        }

        $result['data'] = $branchArray;

        return  json_encode($result);
    }

    public function AddBranch(Request $request)
    {   
        $var = (object) $request->all();

        $validate = Validator::make($request->all(),[
            "id" => 'nullable|integer',
            "Address" => "required",
            "Description" => "required",
            "EmployeeCount" => "required|integer",
            "branchCode" => "required|unique:tbl_branches,BranchCode,".$var->id
        ]);

        $return =[
            "status" =>0,
            "message" =>$validate->errors()->all()
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
            'message' => "Error Occured."
        ];

        if (isset($var->id) && !empty($var->id)) {
            tblBranches::where(['id' => $var->id])->first()->delete();

            $return = [
                'status' => 1,
                'message' => "Deleted Succesfully."
            ];
        }
        
        return $return;
    }
}
