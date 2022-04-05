<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Branch extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $table = 'temp_branch';

    protected $auditExclude  = [];


    public static function getBranch() {

        return \DB::table('temp_branch')->where('status', 1)->get();

    }

    public function branch_department() {

        return $this->hasMany(BranchDepartment::class);

    }

    public function vendor() {

        return $this->hasOne(Vendor::class, 'branch_id', 'store_id');

    }

}
