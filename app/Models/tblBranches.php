<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblBranches extends Model
{
    use HasFactory;

    protected $filable =[
        "BranchCode",
        "Decription",
        "Address",
        "Manager",
        "NoEmployees"
    ];

    protected $primareyKey = "id";
}
