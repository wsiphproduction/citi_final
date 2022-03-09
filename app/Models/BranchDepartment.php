<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchDepartment extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'branch_departments';


    public function branch() {
        return $this->belongsTo(Branch::class);
    }

}
