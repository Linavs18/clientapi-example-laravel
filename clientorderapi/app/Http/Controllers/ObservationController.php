<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ObservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/observation');
        if($response->successful())
        {
            $observations = $response->json();
            return view('observation.index', compact('observations'));
        }
        else
        {
            abort($response->status());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('observation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken(Session::get('token'))->post($url . '/observation', [
            'description' => $request->description
        ]);

        if($response->successful())
            {
                session()->flash('message', 'Observacion creada exitosamente');
                return redirect()->route('observation.index');
            }
        elseif($response->status() == Response::HTTP_BAD_REQUEST)
        {
            $errors = $response->json()['errors'];
            return redirect()->route('observation.create')->withInput()->withErrors($errors);
        }
        else
        {
            abort($response->status());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/observation/' . $id);

        if($response->successful())
        {
            $observation = $response->json();
            return view('observation.edit', compact('observation'));
        }
        elseif($response->status() == Response::HTTP_BAD_REQUEST)
        {
            $errors = $response->json()['errors'];
            return redirect()->route('observation.index')->withInput()->withErrors($errors);
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
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken(Session::get('token'))->put($url . '/observation/' . $id, [
            "id" => $request->id,
            'description' => $request->description
        ]);

        if($response->successful())
        {
            session()->flash('message', 'observacion actualizada exitosamente');
            return redirect()->route('observation.index');
        }
        elseif($response->status() == Response::HTTP_BAD_REQUEST)
        {
            $errors = $response->json()['errors'];
            return redirect()->route('observation.edit')->withInput()->withErrors($errors);
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
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken(Session::get('token'))->delete($url . '/observation/' . $id);

        if($response->successful())
        {
            session()->flash('message', 'Registro eliminado exitosamente');
            return redirect()->route('observation.index');
        }
        elseif($response->status() == Response::HTTP_BAD_REQUEST)
        {
            $errors = $response->json()['errors'];
            return redirect()->route('observation.index')->withInput()->withErrors($errors);
        }
        else
        {
            abort($response->status());
        }
    }
}
