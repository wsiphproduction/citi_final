<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchGroup extends Model
{
    use HasFactory;

    protected $table = 'branch_groups';

    protected $casts = [
        'branch'    => 'array'
    ];

    protected $guarded = [];

    public function user() {

        return $this->hasOne(User::class);
        
    }

}
