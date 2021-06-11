<?php

namespace App\Http\Controllers;

use App\models\inscrito;
use App\models\PagSeguro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use PagSeguro\Configuration\Configure;
use PagSeguro\Library;

class PagSeguroController extends Controller
{
    private $_configs;
    public function __construct()
    {
        Library::initialize();
        /*        Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
        Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");*/
        $this->_configs = new Configure();
        $this->_configs->setCharset("UTF-8");
        $this->_configs->setAccountCredentials(env('PAGSEGURO_EMAIL'), env('PAGSEGURO_TOKEN'));
        $this->_configs->setEnvironment(env('PAGSEGURO_AMBIENTE'));
    }

    public function getCredential()
    {
        return $this->_configs->getAccountCredentials();
    }

    public function pagar()
    {
        return PagSeguro::processar_pagamento($this->getCredential());
    }
    public function finalizar(Request $request)
    {
        $data = [$request->nome, $request->email, $request->empresa, $request->telefone, $request->celular, $request->ocupacao];
        try {
            inscrito::create($request->all());
            echo "<pre>";
            $inscrito = true;
        } catch (\Exception $e) {
            $inscrito = false;
            echo "</br> <strong>";
            die($e->getMessage());
        }
        if ($inscrito == true) {
            PagSeguro::cartao($request, $this->getCredential());
        }
    }
    public function painel()
    {
        $data = inscrito::all();
        return View('paineladmin/painel', compact('data'));
    }
}