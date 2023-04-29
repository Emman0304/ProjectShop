<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\Admin as AdminClass;
use App\Models\tblEmployees;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserFileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function usersList(Request $request)
    {
        $AdminClass = new AdminClass;

        $data['UserFileActive'] = 'active';
        $data['UserMenu'] = 'menu-open';
        $data['activeUserList'] = 'active';
        $data['positions'] = $AdminClass->PositionDropdown(['addBlank' => true]);
        $data['branches'] = $AdminClass->BranchDropdown(['addBlank' => true]);

        return view('Admin.UserFile.userAccounts',$data);
    }

    public function CreateGenAcc()
    {
        $AdminClass = new AdminClass;

        $data['UserFileActive'] = 'active';
        $data['UserMenu'] = 'menu-open';
        $data['activeCreateGen'] = 'active';
 
        return view('Admin.UserFile.CreateGenerateAcc',$data);
    }

    public function usersTable(Request $request)
    {
        $users = User::select(['id','name','username','branch','position','email'])->orderBy('id','desc')->get();
        $userArray = array();
        $count=0;
        
        $AdminClass = new AdminClass;

        foreach ($users as $key => $row) {
            
            $branchDescription = $AdminClass->Branchdesc($row->branch);
            $actionButton = "<div class='btn-group btn-group-sm'>                                           
                                    <a class='btn btn-danger delete' data-id='{$row->id}'><i class='fa fa-trash'></i></a>
                                </div>";

            $userArray[$count++] = array(
                $row->id,
                $branchDescription,
                $row->name,
                $row->username,
                $row->email,
                $row->position,
                $actionButton
            );
        }

        $result['data'] = $userArray;

        return  json_encode($result);
    }

    public function addUser(Request $request)
    {
        $var = (object) $request->all();

        $validate = Validator::make($request->all(),[
            'id' => 'nullable|integer',
            'Branch' => 'required',
            'Name' => 'required',
            'Position' => 'required',
            'Email' => 'required|email|unique:users,email'.$var->id,
            'Password' => 'required',
            'Confirm_Password' => 'required|same:Password'
        ]);

        $return = ['status' => 0, 'message' => $validate->errors()->all()];

        if (!$validate->fails()) {
            $toSave = [
                'name' => $var->Name,
                'email' => $var->Email,
                'username' => $var->Username,
                'branch' => $var->Branch,
                'position' => $var->Position,
                'password' => Hash::make($var->Password) 
            ];
                User::create($toSave);
                $return = ['status' => 1, 'message' => 'New User Added'];
        }

        return $return;
    }

    public function deleteUser(Request $request)
    {
        $var = (object) $request->all();

        $return = [
            'status' => 0,
            'message' => "Error Occured."
        ];

        if (isset($var->id) && !empty($var->id)) {
            User::where(['id' => $var->id])->first()->delete();

            $return = [
                'status' => 1,
                'message' => "Deleted Succesfully."
            ];
        }
        
        return $return;
    }

    public function findID(Request $request)
    {
        $var = (object) $request->all();
        // dd($var);
        $return = ['status' => 0, 'message' => 'Employee Not Found.', 'data' => ""];

        if(isset($var->id) && !empty($var->id)){
            $employees = tblEmployees::where(['user_id' => $var->id])->first();
            if(isset($employees) && !empty($employees)){
                $return = ['status' => 1, 'message' => 'Employee Found.', 'data' => $employees ];
            }     
        }
        
        return $return;
    }
}
