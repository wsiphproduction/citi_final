<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'temp_branch';


    public static function getBranch() {

        return \DB::table('temp_branch')->where('status', 1)->get();

    }

    public function branch_department() {
        return $this->hasMany(BranchDepartment::class);
    }

}
