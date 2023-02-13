<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    //
    protected $guarded = [];
    protected $dates = ['from','to'];
    protected $table = 'salaries';
    public function reposite()
    {
        return $this->belongsTo('App\Reposite');
    }


    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }

    public static function createSalary($request)
    {
        $salary = self::create($request->all());
        $salary->reposite()->decrement('balance',$salary->net);
    }


    public  function deleteSalary()
    {
        $this->reposite()->increment('balance',$this->net);
        $this->delete();
    }


    public  function updateSalary($request)
    {
        $this->reposite()->increment('balance',$this->net);
        $this->update($request->all());
    }
}
