<?php

namespace App\DataTables;

use App\CompanySetting;
use App\Employee;
use Yajra\DataTables\Services\DataTable;

use Carbon\Carbon;
use Faker\Provider\ar_JO\Company;
use Illuminate\Support\Facades\DB as DB;

class SalaryDataTable extends DataTable
{

    public function dataTable($query)
    {

        try {
            return datatables($query)
                ->addColumn('basic', function (Employee $employee) {
                    $id = $employee->id;
                    $basic = $employee->salary;
                    //            dd($basic);
                    return view('salary.datatbles.basic', compact('id', 'basic', 'employee'))->render();
                })
                ->addColumn('notes', function (Employee $employee) {
                    $notes = optional($employee->salaries->first())->notes;
                    $id = $employee->id;
                    //            dd($basic);
                    return view('salary.datatbles.notes', compact('id', 'notes', 'employee'))->render();
                })
                ->addColumn('loans', function (Employee $employee) {
                    // $loans = $employee->loans->where('paid', 0)->where('type', 'solfa')->sum('cost') + $employee->solaf_balance;
                    $loans = $employee->solaf_balance;
                    $id = $employee->id;
                    return view('salary.datatbles.loans', compact('id', 'loans'))->render();
                })
                ->addColumn('workhour',function(Employee $employee)
                {
                    return $employee->workHours($this->request()->date);
                })
                ->addColumn('overtime',function(Employee $employee)
                {
                    return $employee->overTime($this->request()->date);
                })
                ->addColumn('absencewithpermission',function(Employee $employee)
                {
                    return $employee->abcenceWithPermission($this->request()->date);
                })
                ->addColumn('abcencewithvacation',function(Employee $employee){
                    return $employee->abcenceWithVacation($this->request()->date);
                })
                ->addColumn('madionia', function (Employee $employee) {
                    // $loans = $employee->loans
                    $loans = DB::table('loans')
                        ->where('employee_id', $employee->id)
                        ->where('paid', '0')
                        ->whereRaw('paid_value < cost')
                        ->where('type', 'madionia')
                        ->sum('cost');

                    $totalLoans = DB::table('loans')
                        ->where('employee_id', $employee->id)
                        ->where('paid', 0)
                        ->whereRaw('paid_value < cost')
                        ->where('type', 'madionia')
                        ->sum('cost');

                    $id = $employee->id;

                    $month = DB::table('loans')
                        ->where('employee_id', $employee->id)
                        ->where('paid', '0')
                        ->whereRaw('paid_value < cost')
                        ->where('type', 'madionia')
                        ->sum('month');

                    $employee_madionia = $employee->madionia_balance;

                    if ($employee_madionia == 0) {
                        $loans = 0;
                    }

                    $month = ($month == 0 || !$month) ? 1 : $month;

                    //                if (sizeOf($loans2) > 0) {
                    //                    $month = $loans2[0]->month;
                    //                }

                    return view('salary.datatbles.madionia', compact('id', 'loans', 'month', 'employee_madionia', 'totalLoans'))->render();
                })
                ->addColumn('bonus', function (Employee $employee) {
                    $bonus = optional($employee->salaries->first())->bonus;
                    $id = $employee->id;
                    return view('salary.datatbles.bonus', compact('id', 'bonus'))->render();
                
                })
                ->addColumn('transports', function (Employee $employee) {
                    $transports = $employee->getTransports();
                    $id = $employee->id;
                    return view('salary.datatbles.transports', compact('id', 'transports'))->render();
                })
                ->addColumn('financial_penalties', function (Employee $employee) {
                    $financialPenalties = optional($employee->salaries->first())->financial_penalties;
                    $id = $employee->id;
                    return view('salary.datatbles.financial-penalties', compact('id', 'financialPenalties'))->render();
                })
                ->addColumn('insurance', function (Employee $employee) {
                    $insurance = optional($employee->salaries->first())->insurance;
                    $id = $employee->id;
                    return view('salary.datatbles.insurance', compact('id', 'insurance'))->render();
                })
                ->addColumn('net', function (Employee $employee) {
                    $overtimeprice = Employee::select('overtime_price')->where('id',$employee->id)->first();
                    $date = $this->request()->date;
                    $hourly_rate_per_day = CompanySetting::first()->hourly_rate_per_day;
                    $absence_percentage = CompanySetting::first()->absence_percentage;
                    $absence_with_permission_precentage = CompanySetting::first()->absence_with_permission_precentage;
                    return view('salary.datatbles.calc_salary', ['type' => 'net', 'employee' => $employee,'date'=>$this->request()->date,'overtimeprice'=>$overtimeprice,'hourly_rate_per_day'=>$hourly_rate_per_day,'absence_percentage'=>$absence_percentage,'absence_with_permission_precentage'=>$absence_with_permission_precentage]);
                })
                ->addColumn('late', function (Employee $employee) {
                    return $employee->late($this->request()->date);
                })
                ->addColumn('absence', function (Employee $employee) {
                    return $employee->absence($this->request()->date);
                })
                // ->addColumn('late_cost', function (Employee $employee) {
                //     $workDays = AttendanceSettings::first()->work_days;
                //     $workHours = AttendanceSettings::first()->work_hours;
                //     $hour_cost = $employee->salary / ($workDays * $workHours);
                //     return "<span class='late-cost' >" . $hour_cost * $employee->late($this->request()->date) . "</span>";

                // })
                // ->addColumn('absence_cost', function (Employee $employee) {
                //     $workDays = AttendanceSettings::first()->work_days;
                //     $day_cost = $employee->salary / ($workDays); 
                //     return "<span class='absence-cost' >" . $day_cost * $employee->absence($this->request()->date) . "</span>";

                // })
                // ->addColumn('total_registered_days', function (Employee $employee) {
                //     return $employee->attendancesPerMonth(date("Y-m-d"));
                // })
                ->addColumn('action', function (Employee $employee) {
                    $id = $employee->id;
                    $salary = optional($employee->salaries->first());
                    $date = $this->request()->date;
                    return view('salary.datatbles.actions', compact('id', 'salary', 'date'))->render();
                })
                ->addColumn('reposite_id', function (Employee $employee) {
                    $id = $employee->id;
                    $reposite_id = optional($employee->salaries->first())->reposite_id;
                    return view('salary.datatbles.reposite', compact('id', 'reposite_id'))->render();
                })
                ->rawColumns(['basic', 'madionia', 'loans', 'bonus', 'transports', 'financial_penalties', 'insurance', 'net', 'reposite_id', 'action', 'late_cost', 'absence_cost', 'notes']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    public function query(Employee $model)
    {
        $date = Carbon::parse($this->request()->date);
        if(auth()->user()->hasRole('super_admin'))
        {
            $query = $model->query();
        }
        else{
            $query = $model->where('branch_id',auth()->user()->branch_id);
        }
        $query = $model
            ->with([
                'salaries' => function ($query) use ($date) {
                    $query
                        ->whereMonth('date', $date->month)
                        ->whereYear('date', $date->year);
                },
                'loans',
                'transports' => function ($query) use ($date) {
                    $query
                        ->whereMonth('date', $date->month)
                        ->whereYear('date', $date->year);
                }

            ])
            ->select(
                'employees.id',
                'employees.name as employee',
                'jobs.name as job',
                'employees.salary',
                'employees.solaf_balance',
                'employees.madionia_balance',
                'employees.created_at'
            )
            ->leftJoin('jobs', 'employees.job_id', '=', 'jobs.id')
            ->where('active', '1')
            ->latest();

        // if (auth()->user()->id != 1) {
        //     $query = $query->where('branch_id', auth()->user()->branch_id);
        // }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->ajax([
                'data' => 'function(data){
                            data.date = date;
                 }'
            ])
            ->parameters($this->getBuilderParameters());
    }


    protected function getColumns()
    {
        return [
            [
                'name' => 'employees.name',
                'data' => 'employee',
                'title' => 'Employee',
            ],
            [
                'name' => 'jobs.name',
                'data' => 'job',
                'title' => 'Job',
            ],

            [
                'name' => 'basic',
                'data' => 'basic',
                'title' => 'Basic',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'name' => 'notes',
                'data' => 'notes',
                'title' => 'Notes',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'name' => 'madionia',
                'data' => 'madionia',
                'title' => 'Debt',
                'orderable' => false,
                'searchable' => false,
            ],

            [
                'name' => 'loans',
                'data' => 'loans',
                'title' => 'Loans',
                'orderable' => false,
                'searchable' => false,
            ],

            [
                'name' => 'transports',
                'data' => 'transports',
                'title' => 'Transports',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'name' => 'bonus',
                'data' => 'bonus',
                'title' => 'Bonus',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'name' => 'financial_penalties',
                'data' => 'financial_penalties',
                'title' => 'Financial penalties',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'name' => 'insurance',
                'data' => 'insurance',
                'title' => 'Insurance',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'name'=>'workhour',
                'data'=>'workhour',
                'title'=>'Work Hours',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'name' => 'overtime',
                'data' => 'overtime',
                'title' => 'OverTime Hours',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'name'=>'late',
                'data'=>'late',
                'title'=>'Late Hours',
                'orderable' => false,
                'searchable' => false,    
            ],
            [
                'name' => 'absence',
                'data' => 'absence',
                'title' => 'Absence',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'name' => 'abcencewithvacation',
                'data' => 'abcencewithvacation',
                'title' => 'Abcence With Vacation',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'name' => 'absencewithpermission',
                'data' => 'absencewithpermission',
                'title' => 'Absence With Permission',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'name' => 'net',
                'data' => 'net',
                'title' => 'Net Salary',
                'orderable' => false,
                'searchable' => false,
            ],
            // [
            //     'name' => 'late',
            //     'data' => 'late',
            //     'title' => 'تاخير ( ساعة )',
            //     'orderable' => false,
            //     'searchable' => false,
            // ],[
            //     'name' => 'late_cost',
            //     'data' => 'late_cost',
            //     'title' => 'تاخير ( جنيه )',
            //     'orderable' => false,
            //     'searchable' => false,
            // ],
            
            // [
            //     'name' => 'absence_cost',
            //     'data' => 'absence_cost',
            //     'title' => 'غياب ( جنيه )',
            //     'orderable' => false,
            //     'searchable' => false,
            // ],
            // [
            //     'name' => 'total_registered_days',
            //     'data' => 'total_registered_days',
            //     'title' => 'اجمالي الايام المسجلة',
            //     'orderable' => false,
            //     'searchable' => false,
            // ],
            [
                'name' => 'action',
                'data' => 'action',
                'title' => 'Action',
                'exportable' => false,
                'printable' => false,
                'searchable' => false,
                'orderable' => false,
            ],
        ];
    }


    /**
     *Get the builder parameters
     * @return array
     */
    public function getBuilderParameters()
    {
        return [
            'dom' => 'Bfrtip',
            'buttons' => [
                'excel', 'print'
                //, 'reset', 'reload'
            ],
            'language' => [
                'url' => url('/vendor/datatables/arabic.json'),
                'paginate' => [
                    "previous" => "<i class='mdi mdi-chevron-left'>",
                    "next" => "<i class='mdi mdi-chevron-right'>"
                ]
                ],
            'filter' => true,
            'order' => [ [0,'desc'] ],
            'lengthMenu' => [10,25,50]

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Salary_' . date('YmdHis');
    }
}
