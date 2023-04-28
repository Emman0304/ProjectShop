<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Admin as AdminClass;
use App\Models\tblEmployees;
use App\Models\tblPositions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeFileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function employeeList()
    {
        $AdminClass = new AdminClass;

        $data['EmpfileActive'] = 'active';
        $data['listActive'] = 'active';
        $data['EmployeeMenu'] = 'menu-open';
        $data['positions'] = $AdminClass->PositionDropdown(['addBlank' => true]);
        $data['branches'] = $AdminClass->BranchDropdown(['addBlank' => true]);

        return view('Admin.EmployeeFile.EmployeeList',$data);
    }

    public function employeeTable(Request $request)
    {
        $employee = tblEmployees::orderBy('id','desc')->get();
        $employeeArray = array();
        $count=0;
        
        $AdminClass = new AdminClass;

        foreach ($employee as $key => $row) {

            $PosDesc = $AdminClass->PostDesc($row->Position);
            $branchDesc = $AdminClass->Branchdesc($row->BranchCode);

            $actionButton = "<div class='btn-group btn-group-sm'>                                           
                                    <a class='btn btn-success edit' data-id='{$row->id}'><i class='fa fa-edit'></i></a>
                                    <a class='btn btn-danger delete' data-id='{$row->id}'><i class='fa fa-trash'></i></a>
                                    <a class='btn btn-success view' data-id='{$row->user_id}'><i class='fa fa-eye'></i></a>
                                </div>";

            $employeeArray[$count++] = array(
                $row->user_id,
                $row->Name,
                $PosDesc,
                $branchDesc,
                $actionButton
            );
        }

        $result['data'] = $employeeArray;

        return  json_encode($result);
    }

    public function AddEmployee(Request $request)
    {   
        $var = (object) $request->all();

        $AdminClass = new AdminClass;
    
        $validate = Validator::make($request->all(),[
            "id" =>'nullable|integer',
            "Address" => "required",
            "contactNo" => "required|unique:tbl_employees,ContactNo,".$var->id,
            "Position" => "required",
            "LName" => "required",
            "FName" => "required",
            "Age" => "required",
            "branchCode" => "required",
            "email" => "required|unique:tbl_employees,Email,".$var->id
        ]);

        $return =[
            "status" =>0,
            "message" =>$validate->errors()->all()
        ];

        if (isset($var->MName) && !empty($var->MName) && isset($var->Suffix) && !empty($var->Suffix)) {
            $Fullname = $var->FName." ".$var->MName." ".$var->LName.", ".$var->Suffix;
        }elseif (isset($var->MName) && !empty($var->MName) && !isset($var->Suffix) && empty($var->Suffix)) {
            $Fullname = $var->FName." ".$var->MName." ".$var->LName;
        }elseif(!isset($var->MName) && empty($var->MName) && isset($var->Suffix) && !empty($var->Suffix)){
            $Fullname = $var->FName." ".$var->LName.", ".$var->Suffix;
        }else{
            $Fullname = $var->FName." ".$var->LName;
        }

        if (!$validate->fails()) {

            $params =[
                'branch' => $var->branchCode,
                'position' => $var->Position,
                'id' => $var->id
            ];

            $tosave=[
                "BranchCode" => $var->branchCode,
                "Position" => $var->Position,
                "LName" => $var->LName,
                "FName" => $var->FName,
                "MName" => $var->MName,
                'Name' => $Fullname,
                "Suffix" => $var->Suffix,
                "Age" => $var->Age,
                "ContactNo" => $var->contactNo,
                "Address" => $var->Address,
                "Email" => $var->email,
                "user_id" => $AdminClass->IDGen($params)
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

    public function deleteEmployee(Request $request)
    {
        $var = (object) $request->all();

        $return = [
            'status' => 0,
            'message' => "Error Occured."
        ];

        if (isset($var->id) && !empty($var->id)) {
            tblEmployees::where(['id' => $var->id])->first()->delete();

            $return = [
                'status' => 1,
                'message' => "Deleted Succesfully."
            ];
        }
        
        return $return;
    }

    public function editEmployee(Request $request){
        $var = (object) $request->all();
 
        $result=[
            'data' => "Error Occured.",
            'status' => 0
        ];
        
        $employee = tblEmployees::where(['id' => $var->id])->first();

        if (!empty($employee)) {
            $result=[
                'data' => $employee,
                'status' => 1
            ];    
        }

        return $result;
    }

    public function positionList(Request $request)
    {
        $data['EmpfileActive'] = 'active';
        $data['positionActive'] = 'active';
        $data['EmployeeMenu'] = 'menu-open';

        return view('Admin.EmployeeFile.positions',$data);
    }

    public function PositionTable(Request $request)
    {
        $position = tblPositions::orderBy('id','desc')->get();
        // dd($position);
        $positionArray = array();
        $count=0;
        
        foreach ($position as $key => $row) {

            $actionButton = "<div class='btn-group btn-group-sm'>                                           
                                    <a class='btn btn-success edit' data-id='{$row->id}'><i class='fa fa-edit'></i></a>
                                    <a class='btn btn-danger delete' data-id='{$row->id}'><i class='fa fa-trash'></i></a>
                                </div>";
  
            $positionArray[$count++] = array(
                $row->PositionCode,
                $row->Description,
                $row->Role,
                $row->created_by,
                $actionButton
            );
        }

        $result['data'] = $positionArray;

        return  json_encode($result);
    }

    public function addPosition(Request $request)
    {
        $var = (object) $request->all();

        $validate = Validator::make($request->all(),[
            'positionCode' => 'required|unique:tbl_positions,PositionCode,'.$var->id,
            'Description' => 'required',
            'Role' => 'required'
        ]);

        $return = [
            'status' => 0,
            'message' => $validate->errors()->all()
        ];

        if (!$validate->fails()) {
            
            $tosave = [
                'PositionCode' => $var->positionCode,
                'Description' => $var->Description,
                'Role' => $var->Role,
                'created_by' => Auth::user()->name
            ];

            if (isset($var->id) && !empty($var->id)) {
                tblPositions::updateOrCreate(['id' => $var->id],$tosave);    
                
                $return = [
                    'status' => 1,
                    'message' => 'Updated Successfully.'
                ];
            }else{
                tblPositions::create($tosave);

                $return = [
                    'status' => 1,
                    'message' => 'Saved Successfully.'
                ];
            }   
        }

        return response()->json($return);
    }

    public function editPosition(Request $request){

        $var = (object) $request->all();

        $result=[
            'data' => "Error Occured.",
            'status' => 0
        ];
        
        $position = tblPositions::where(['id' => $var->id])->first();

        if (!empty($position)) {
            $result=[
                'data' => $position,
                'status' => 1
            ];    
        }

        return $result;
    }

    public function deletePosition(Request $request)
    {
        $var = (object) $request->all();

        $return = [
            'status' => 0,
            'message' => "Error Occured."
        ];

        if (isset($var->id) && !empty($var->id)) {
            tblPositions::where(['id' => $var->id])->first()->delete();

            $return = [
                'status' => 1,
                'message' => "Deleted Succesfully."
            ];
        }
        
        return $return;
    }
}