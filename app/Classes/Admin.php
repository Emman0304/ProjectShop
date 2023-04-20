<?php

namespace App\Classes;

use App\Models\tblBranches;
use App\Models\tblEmployees;
use App\Models\tblPositions;
use Illuminate\Support\Facades\DB;

class Admin{

    public function CheckIfExistBranch()
    {
        
        $branches = tblBranches::select('BranchCode')->get();
        $arr = array();

        foreach ($branches as $key => $row) {
            $arr[$row->BranchCode] = $row->BranchCode; 
        }

        return $arr;
    }

    public function PostDesc($pos)
    {
        $positions = tblPositions::where(['PositionCode' => $pos])->first();

        $desc = isset($positions->Description) ? $positions->Description:"";

        return $desc;
    }

    public function Branchdesc($branch)
    {
        $branches = tblBranches::where(['BranchCode' => $branch])->first();

        $desc = isset($branches->Description) ? $branches->Description:"";

        return $desc;
    }

    public function ManagerName($id)
    {
        $manager = tblEmployees::select('Name')->where(['id'=>$id,'Position' => 'MNGR'])->first();

        $name = isset($manager->Name) ? $manager->Name:'No Manager Assigned';

        return $name;
    }

}