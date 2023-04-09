<?php

namespace App\Classes;

use App\Models\tblBranches;

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

}