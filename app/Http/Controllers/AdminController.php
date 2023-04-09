<?php

namespace App\Http\Controllers;

use App\Models\tblBranches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Classes\Admin as AdminClass;
use App\Models\tblEmployees;

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

    public function BranchList()
    {
        $data['activeBranch'] = 'active';

        return view('Admin.branchlist',$data);
    }

    public function employeeList()
    {
        $data['EmpfileActive'] = 'active';
        $data['listActive'] = 'active';
        $data['menu'] = 'menu-open';

        return view('Admin.EmployeeList',$data);
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
    public function employeeTable(Request $request)
    {
        $employee = tblEmployees::orderBy('id','desc')->get();
        $employeeArray = array();
        $count=0;
        
        foreach ($employee as $key => $row) {

            $actionButton = "<div class='btn-group btn-group-sm'>                                           
                                    <a class='btn btn-success edit' data-id='{$row->id}'><i class='fa fa-edit'></i></a>
                                    <a class='btn btn-danger delete' data-id='{$row->id}'><i class='fa fa-trash'></i></a>
                                </div>";
            $MName = isset($row->MName) ? $row->MName:'';
            $Suffix = isset($row->Suffix) ? $row->Suffix:'';

            $employeeArray[$count++] = array(
                $row->id,
                $row->FName." ".$row->LName.", ".$MName,
                $row->Position,
                $row->BranchCode,
                $actionButton
            );
        }

        $result['data'] = $employeeArray;

        return  json_encode($result);
    }
    public function deleteEmployee(Request $request)
    {
        $var = (object) $request->all();

        $return = [
            'status' => 0,
            'message' => "An Error Occured"
        ];

        if (isset($var->id) && !empty($var->id)) {
            tblEmployees::where(['id' => $var->id])->first()->delete();

            $return = [
                'status' => 1,
                'message' => "Deleted Succesfully"
            ];
        }
        
        return $return;
    }
    public function AddEmployee(Request $request)
    {   
        $var = (object) $request->all();
        
        $validate = Validator::make($request->all(),[
            "Address" => "required",
            "contactNo" => "required",
            "Position" => "required",
            "LName" => "required",
            "FName" => "required",
            "Age" => "required",
            "branchCode" => "required",
            "email" => "required"
        ]);

        $return =[
            "status" =>0,
            "message" =>'An Eror Occured'
        ];

        if (!$validate->fails()) {

            $tosave=[
                "BranchCode" => $var->branchCode,
                "Position" => $var->Position,
                "LName" => $var->LName,
                "FName" => $var->FName,
                "MName" => $var->MName,
                "Suffix" => $var->Suffix,
                "Age" => $var->Age,
                "ContactNo" => $var->contactNo,
                "Address" => $var->Address,
                "Email" => $var->email
            ];
            
            if (isset($var->id) && !empty($var->id)) {    
                
                tblEmployees::updateOrCreate(['id' => $var->id],$tosave);

                $return =[
                    "status" =>1,
                    "message" =>"Updated Successfuly."
                ];

            }else{

                tblEmployees::create($tosave);
                $return =[
                    "status" =>1,
                    "message" =>"Saved Successfuly."
                ];              
            }
        }
        return $return;
    }

    public function editEmployee(Request $request){
        $var = (object) $request->all();
   
        $result=[
            'data' => "",
            'status' => 0
        ];
        
        $employee = tblEmployees::where(['id' => $var->id])->first();

        if (!empty($employee)) {
            $result=[
                'data' => $employee,
                'status' => 1
            ];    
        }
            // dd($result);
        return $result;
    }
}
