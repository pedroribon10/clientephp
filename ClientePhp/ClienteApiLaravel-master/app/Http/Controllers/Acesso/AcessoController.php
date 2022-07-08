<?php

namespace App\Http\Controllers\Acesso;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class AcessoController extends Controller
{
    public function index()
    {
        $response = $this->getToken();

        $response1 = Http::withToken($response->json()['access_token'])->get(env('API_URL').'api/clientes');

        return response($response1);
    }

    public function show($id)
    {
        $response = Http::withBasicAuth('admin@admin.com','123456789')->get(env('API_URL').'api/cliente/'.$id);

        return response($response);
    }

    public function create()
    {
        $response = Http::post(env('API_URL').'api/clientes',[
            'nome'=>'',
            'cpf_cnpj'=>'',
            'email'=>'',
            'tipo_pessoa'=>'',
            'data_nasc'=>'',
            'id_loja' =>''
        ]);
    }

    public function getToken()
    {
        $response = Http::asForm()->post(env('API_URL').'oauth/token',
            [
                'grant_type' => 'client_credentials',
                'client_id' => env('API_CREDENTIAL_ID'),
                'client_secret' => env('API_CREDETIAL_SECRET'),
                'scope' => ''
            ]
        );
        return $response;

    }

}
