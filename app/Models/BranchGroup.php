<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BranchGroup extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = 'branch_groups';

    protected $casts = [
        'branch'    => 'array'
    ];

    protected $auditExclude  = [];

    protected $guarded = [];

    public function user() {

        return $this->hasOne(User::class);
        
    }

}
