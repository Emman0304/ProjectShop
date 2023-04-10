<?php

namespace App\Classes;

use App\Models\tblBranches;
use App\Models\tblPositions;

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

    public function Positions()
    {
        $positions = tblPositions::orderBy('id','asc')->get();
        $posArray = array();

        $posArray[""] = "Select Position";

        foreach ($positions as $key => $row) {
            $posArray[$row->PositionCode] = $row->Description;
        }

        return $posArray;
    }

}