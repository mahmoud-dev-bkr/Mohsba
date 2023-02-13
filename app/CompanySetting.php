<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $table = "company_settings";

    protected $fillable = [
        'name', 'plan_id', 'vication_days', 'registeration_date', 'email', 'logo', 'background', 'phone', 'ssid', 'mac_address', 'notes','absence_percentage','	absence_with_permission_precentage','hourly_rate_per_day','overtime_price'
    ];
}
