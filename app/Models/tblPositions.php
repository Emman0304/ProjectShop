<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblPositions extends Model
{
    use HasFactory;

    protected $table = 'tbl_positions';
    protected $fillable = [
        'PositionCode',
        'Description',
        'created_by',
        'Role'
    ];
    protected $primaryKey = 'id';
}
