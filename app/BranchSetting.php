<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchSetting extends Model
{
    protected $table = 'branch_setting';
    protected $fillable = [
        'id', 'branch_id', 'over_time_count', 'vication_days'
    ];
}
