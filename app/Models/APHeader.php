<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APHeader extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'ap_headers';
}
