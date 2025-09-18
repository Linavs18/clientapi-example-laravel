<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = env('URL_BASE_API',"http://localhost:8000");
            $response = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/order');
            if($response->successful())
            {
                $orders = $response->json();
                return view('order.index', compact('orders'));
            } 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $url = env('URL_BASE_API',"http://localhost:8000");
        $responseTechnicians = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/technician');
        $responseTypes = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/type_order');
        if($responseTechnicians->successful() and $responseTypes->successful()){

            $technicians = $responseTechnicians->json();
            $types = $responseTypes->json();
            return view('order.create',compact('observations','causals'));
        }
        else
        {
            abort($responseTechnicians->status());
        }    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $url = env('URL_BASE_API',"http://localhost:8000");
            $response = Http::acceptJson()->withToken(Session::get('token'))->post($url . '/order',[
                'legalization_date' => $request->legalization_date,
                'city' => $request->city,
                'address' => $request->address,
                'causal_id' => $request->causal_id,
                'observation_id' => $request->observation_id
            ]);

            if($response->successful()){
                session()->flash('message','Registro creado exitosamente');
                return redirect()->route('order.index');

            }
            elseif($response->status() == Response::HTTP_BAD_REQUEST)
            {
                $errors = $response->json()['errors'];
                return redirect()->route('order.create')
                ->withInput()->withErrors($errors);
            } 
            else
            {
                abort($response->status());
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $url = env('URL_BASE_API',"http://localhost:8000");
            $response = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/order/'. $id);

        if($response->successful())
            {
                $responseObservations = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/observation');
                $responseCausals = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/causal');
                if($responseObservations->successful() and $responseCausals->successful()){
                $observations = $responseObservations->json();
                $causals = $responseCausals->json();   
                $order = $response->json();
                return view('order.edit', compact('order','observations','causals'));
            }
        }
            elseif($response->status() == Response::HTTP_BAD_REQUEST)
            {
                $errors = $response->json()['errors'];
                return redirect()->route('order.index')
                ->withInput()->withErrors($errors);
            } 
            else
            {
                abort($response->status());
            }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $url = env('URL_BASE_API',"http://localhost:8000");
            $response = Http::acceptJson()->withToken(Session::get('token'))->put($url . '/order/'. $id,[
                'id' => $request->$id,
                'legalization_date' => $request->legalization_date,
                'city' => $request->city,
                'address' => $request->address,
                'causal_id' => $request->causal_id,
                'observation_id' => $request->observation_id


            ]);

            if($response->successful()){
                session()->flash('message','Registro actualizado exitosamente');
                return redirect()->route('order.index');

            }
            elseif($response->status() == Response::HTTP_BAD_REQUEST)
            {
                $errors = $response->json()['errors'];
                return redirect()->route('order.edit')
                ->withInput()->withErrors($errors);
            } 
            else
            {
                abort($response->status());
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $url = env('URL_BASE_API',"http://localhost:8000");
            $response = Http::acceptJson()->withToken(Session::get('token'))->delete($url . '/order/'.$id);

            if($response->successful()){
                session()->flash('message','Registro eliminado exitosamente');
                return redirect()->route('order.index');

            }
            elseif($response->status() == Response::HTTP_BAD_REQUEST)
            {
                $errors = $response->json()['errors'];
                return redirect()->route('order.index')
                ->withInput()->withErrors($errors);
            } 
            else
            {
                abort($response->status());
            }
    }

    public function add_activity(string $order_id, string $activity_id){
        
    }

    
}
