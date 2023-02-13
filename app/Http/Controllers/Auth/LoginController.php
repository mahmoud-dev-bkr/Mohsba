<?php

namespace App\Http\Controllers\Auth;

use App\CompanySetting;
use App\Http\Controllers\Controller;
use App\Plan;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use Exception;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Jerry\JWT\JWT;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(Request $request)
    {
        $this->middleware('guest')->except('logout');
    }



    protected function authenticated(Request $request)
    {
        // login history

        $agent = new Agent();
        // dd($agent->city());
        $details = [
            "device" => $agent->device(),
            "platform" => $agent->platform(),
            "browser" => $agent->browser(),
        ];
        $activity_log = [
            'user_id' => Auth::user()->id,
            'ip' => request()->getClientIp(),
            'datetime' =>  Carbon::now()->toDateTimeString(),
            'created_at' =>  Carbon::now()->toDateTimeString(),
            'updated_at' =>  Carbon::now()->toDateTimeString(),
            'details' => json_encode($details)
        ];

        DB::table('login_histories')->insert($activity_log);

        // call api
        try {
            $base_url = 'http://127.0.0.1:5000';

            $payload = [
                'company_id' => config('api.COMPANY_ID')
            ];
            $jwt_token = JWT::basic_encode($payload, config('api.JWT_SECRET'));

            $response = Http::withHeaders([
                'access_token' =>  $jwt_token
            ])->get($base_url . '/api/getData');


            if($response->status() == 403) {
                // invalid access
               return $this->logTheUserOutWithMessage("Invalid access , this may happen because your company not registered on the sphinx database contact sphinx company ");
            }
            $alerts = $response['alerts'];

            $payment_detail = $response['payment_detail'];

            if (!$payment_detail)
               return $this->logTheUserOutWithMessage("sorry ,your subscription has expired .. contact sphinx company to renew your subscription");
            // check if company plan subscription is over

            $this->checkPlanEndDate($payment_detail['end_date']);

            $request->session()->flash('alerts', json_encode($alerts));
            $company_settings = CompanySetting::first();
            if (!$company_settings->registeration_num) {
                $company_settings->registeration_num = $payment_detail['company']['registration_num'];
                $company_settings->save();
            }

            $plan = Plan::first();
            $plan->start_date = $payment_detail['start_date'];
            $plan->end_date = $payment_detail['end_date'];
            $plan->number_days = $payment_detail['plan']['duration_days'];
            $plan->count_employees = $payment_detail['plan']['max_emp'];
            $plan->save();

        } catch (Exception $e) {
            // return $this->logTheUserOutWithMessage("sorry ,There is a problem connecting the sphinx server ,try again later");

        }

        $plan = Plan::first();
        if(isset($plan->start_date)){
           return $this->checkPlanEndDate($plan->end_date);
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('auth/login');
    }

    private function logTheUserOutWithMessage(String $msg){
        Auth::logout();
        return redirect('/login')->with('msg' , $msg);
    }
    private function checkPlanEndDate($end_date){
        $end_date = Carbon::parse($end_date);
        $allow_days = config('api.ALLOW_PLAN_DAYS') ?? 4 ;

        if ($end_date->copy()->addDays($allow_days)->isPast())
           return $this->logTheUserOutWithMessage("sorry ,your subscription has expired .. contact sphinx company to renew your subscription");
    }
}
