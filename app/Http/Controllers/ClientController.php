<?php

namespace App\Http\Controllers;

use App\Client;
use Dotenv\Validator;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function getClients(){
        $Clients = Client::latest('id');
        $data = Datatables()->eloquent($Clients)
        ->addColumn('action' , function($Client){
            return view('Sales.Clients.actions' , ['type' => 'action' , 'Client' => $Client]);
        })
        ->editColumn('status', function ($Client){
            if ($Client->status == 1) {
                return "مفعل";
            } else {
                return "غير مفعل";
            }
        })
        ->toJson();


        return $data;
    }
    public function index()
    {
        $Client = Client::all();
        return view('Sales.Clients.index', compact(
            [
                'Client'
            ]
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Sales.Clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();

        if ($request->pointsClient == 'on') {
            $data['pointsClient'] = 1;
        } else {
            $data['pointsClient'] = 0;
        }
        Client::create($data);
        // fill appointments em ployees
        return redirect()->route('client.index')->with(['success' => 'تم الحفظ بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Request $client)
    {
        return $_GET;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Client = Client::FindOrFail($id);
        return view('Sales.Clients.update', compact('Client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Client = Client::findOrFail($id);
        $data = $request->all();

        if ($request->pointsClient == 'on') {
            $data['pointsClient'] = 1;
        } else {
            $data['pointsClient'] = 0;
        }
        //update in db
        $Client->update($data);
        return redirect()->route('client.index')->with(['success' => 'تم تحديث بيانات العميل بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $Client = Client::find($id);
            $deleted =  $Client->delete();
            if (!$deleted) {
                return redirect()->route('client.index')->with(['error' => 'هذه الوظيفة لا يمكن مسحها']);
            }
            return redirect()->route('client.index')->with(['success' => 'تم حذف الوظيفة بنجاح']);
        } catch (\Exception $ex) {
            return redirect()->route('client.index')->with(['error' => 'هناك خطأ برجاء المحاولة ثانيا']);
        }
    }
}
