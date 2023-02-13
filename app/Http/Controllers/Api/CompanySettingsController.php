<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CompanySettingsController extends Controller
{
    public function getData(Request $request)
    {
        $data =  DB::table('company_settings')->first();
        return Response()->json(['status' => 1, 'message' => 'success', 'data' => $data]);
    }
}
