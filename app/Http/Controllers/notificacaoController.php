<?php

namespace App\Http\Controllers;

use App\models\transacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class notificacaoController extends Controller
{
    private $email;
    private $token;
    public function __construct()
    {
        $this->email = env('PAGSEGURO_EMAIL');
        $this->token = env('PAGSEGURO_TOKEN');
    }

    public function getCredenciais()
    {
        $dados['email'] = $this->email;
        $dados['token'] = $this->token;
        return http_build_query($dados);
    }
    public function url($code, $credenciais)
    {
        return "https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/" . $code . "?" . $credenciais;
    }

    public function atualizaStatus(array $data)
    {
        $status = transacao::where('referencia', '=', $data['referencia']);
        if ($status) {
            $status->update(['status' => $data['status']]);
            return 'atulizado';
        } else {
            return 'error';
        }
    }
    public function notificacao(Request $request)
    {
        try {
            $url = $this->url($request->notificationCode, $this->getCredenciais());
            $return = Http::get($url);
            $xml = simplexml_load_string($return);
            $data = [
                'referencia' =>  $xml->reference,
                'status'     => $xml->status
            ];
            return  $this->atualizaStatus($data);
        } catch (\Exception $e) {
            die($e);
        }
    }
}