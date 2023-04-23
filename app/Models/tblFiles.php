<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblFiles extends Model
{
    use HasFactory;

    protected $table = 'tbl_files';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'size',
        'data'
    ];
}
