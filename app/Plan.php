<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Setting;
class Plan extends Model
{
    protected $table = "plans";

   protected $fillable = [
        'name',
        'count_employees',
        'price',
        'number_days',
        'desciption'
   ];
   protected $appends = [
    'company_plan'
   ];

    public function getCompanyPlanAttribute()
    {
        $plan_id = Setting::find(1)->value;
        $plan = Plan::FindOrFail($plan_id);
        return $plan;
    }
}
