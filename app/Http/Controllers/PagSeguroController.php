<?php

namespace App\Http\Controllers;

use App\models\inscrito;
use App\models\PagSeguro;
use App\models\transacao;
use App\models\viewstatu;
use App\models\viewstatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use PagSeguro\Configuration\Configure;
use PagSeguro\Library;

class PagSeguroController extends Controller
{
    private $_configs;
    private $idInscrito;
    public function __construct()
    {
        Library::initialize();
        $this->_configs = new Configure();
        $this->_configs->setCharset("UTF-8");
        $this->_configs->setAccountCredentials(env('PAGSEGURO_EMAIL'), env('PAGSEGURO_TOKEN'));
        $this->_configs->setEnvironment(env('PAGSEGURO_AMBIENTE'));
        $this->idInscrito = inscrito::all()->count() + 1;
    }

    public function gerarReferencia()
    {
        $ref = uniqid(rand());
        $verificar = transacao::where('referencia', '=', $ref)->count();
        if ($verificar == 0) {
            return $ref;
        } else {
            return $this->gerarReferencia();
        }
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
        $referencia = $this->gerarReferencia();
        $data = [
            'referencia'  => $referencia,
            'status'      => '1',
            'id_inscrito' => $this->idInscrito
        ];
        try {
            inscrito::create($request->all());
            transacao::create($data);
            echo "<pre>";
            $inscrito = true;
        } catch (\Exception $e) {
            $inscrito = false;
            echo "</br> <strong>";
            die($e->getMessage());
        }
        if ($inscrito == true) {
            PagSeguro::cartao($request, $this->getCredential(), $referencia);
        }
    }
    public function painel()
    {
        $data = viewstatu::all();
        return View('paineladmin/painel', compact('data'));
    }
    public function teste()
    {
        return $this->idInscrito;
    }
}