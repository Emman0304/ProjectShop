<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblEmployees extends Model
{
    use HasFactory;
    
    protected $table = 'tbl_employees';
    protected $fillable = [
            'BranchCode',
            'Position',
            'LName',
            'FName',
            'MName',
            'Name',
            'Suffix',
            'Address',
            'Age',
            'ContactNo',
            'Email',
            'user_id'
        ];
    protected $primaryKey = 'id';

}
