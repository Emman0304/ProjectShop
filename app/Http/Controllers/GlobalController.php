<?php

namespace App\Http\Controllers;

use App\Models\tblEmployees;
use Illuminate\Http\Request;
use App\Classes\Admin as AdminClass;

class GlobalController extends Controller
{
    public function Profile(Request $request,$id)
    {
        $AdminClass = new AdminClass;

        $decrypID = base64_decode($id);

        $personalData = tblEmployees::where(['user_id' => $decrypID])->first();

        $data['data'] = $personalData;
        $data['position'] = $AdminClass->PostDesc($personalData->Position);
        $data['EmpfileActive'] = 'active';
        $data['listActive'] = 'active';
        $data['menu'] = 'menu-open';
        $data['id'] = $decrypID; 

        return view('components.profile',$data);
    }
}
