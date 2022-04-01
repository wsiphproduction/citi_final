<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, \OwenIt\Auditing\Auditable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $auditExclude  = [];


    public function ts() {

        return $this->hasManay(TemporarySlip::class);

    }

    public function pcv() {

        return $this->hasManay(Pcv::class);

    }

    public function branch_group() {

        return $this->belongsTo(BranchGroup::class);

    }

    public function branch() {

        return $this->belongsTo(Branch::class, 'assign_to', 'store_id');

    }

    public function getUserAssignTo() {

        if(Str::contains($this->branch->store_type, 'Head Office'))
            return 'ssc';

        return 'dc/store';

    }

}
