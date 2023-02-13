<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class Loan extends Model
{
    //
    protected $guarded = [];

    protected $dates = ['date'];

    public static function createLoan($request)
    {
        DB::beginTransaction();
        // first create the loan 
        $loan = self::create([
            'type'=>$request->type,
            'date'=>$request->date,
            'employee_id'=>$request->employee_id,
            'reposite_id'=>$request->reposite_id,
            'notes'=>$request->notes,
            'cost'=>$request->cost,
            'month'=>$request->month,
        ]);
        // second decrease the reposite balance
        // $loan->reposite()->decrement('balance',$loan->cost);
        // $loan->employee()->decrement('balance',$loan->cost);
        DB::commit();
    }


    public  function deleteLoan()
    {
        DB::beginTransaction();
        if(!$this->pending){
            $this->reposite()->increment('balance',$this->cost);
            $this->employee()->increment('balance',$this->cost);
        }
        $this->delete();
        DB::commit();
    }


    public  function updateLoan($request)
    {
        DB::beginTransaction();

       if(!$this->pending){
            $this->reposite()->increment('balance',$this->cost);
            $this->employee()->increment('balance',$this->cost);
            $this->reposite()->decrement('balance',$request->cost);
            $this->employee()->decrement('balance',$request->cost);
       }
        $this->update($request->all());
        DB::commit();
    }


    public function reposite()
    {
        return $this->belongsTo('App\Models\Reposite');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }


    public function performPending()
    {
        if($this->reposite->balance >= $this->cost){
            $this->reposite()->decrement('balance',$this->cost);
            $this->employee()->decrement('balance',$this->cost);
            $this->update(['pending'=>false]);
            return true;
        } else {
            return false;
        }
        
    }
}
