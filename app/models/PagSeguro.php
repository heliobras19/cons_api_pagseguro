<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class PagSeguro extends Model
{
    public static function processar_pagamento($credencial)
    {
        $data = [];
        $sessioCode = \PagSeguro\Services\Session::create($credencial);
        $idSession = $sessioCode->getResult();
        $data['sessionID'] = $idSession;
        return view("compra/pagar", $data);
    }

    public static function cartao($request, $credencial, $referencia)
    {
        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();

        $creditCard->setReference($referencia);

        $creditCard->setCurrency("BRL");

        $creditCard->addItems()->withParameters(
            '0001',
            'Curso PHP',
            1,
            200.00
        );

        $creditCard->setSender()->setName($request->nome);
        $creditCard->setSender()->setEmail('email@sandbox.pagseguro.com.br');

        $creditCard->setSender()->setPhone()->withParameters(
            11,
            $request->celular
        );

        $creditCard->setSender()->setDocument()->withParameters(
            'CPF',
            '711.277.090-46'
        );

        $creditCard->setSender()->setHash($request['hashseller']);
        $creditCard->setShipping()->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );

        $creditCard->setBilling()->setAddress()->withParameters(
            'Av. Brig. Faria Lima',
            '1384',
            'Jardim Paulistano',
            '01452002',
            'São Paulo',
            'SP',
            'BRA',
            'apto. 114'
        );
        $creditCard->setToken($request['tokenCartao']);
        $creditCard->setInstallment()->withParameters(1, '200.00');

        $creditCard->setHolder()->setBirthdate('01/10/1979');
        $creditCard->setHolder()->setName('João Comprador'); // Equals in Credit Card

        $creditCard->setHolder()->setPhone()->withParameters(
            11,
            56273440
        );

        $creditCard->setHolder()->setDocument()->withParameters(
            'CPF',
            '274.870.690-01'
        );

        $creditCard->setMode('DEFAULT');
        try {
            $result = $creditCard->register(
                $credencial
            );
            echo "<pre>";
            print_r($result);
        } catch (\Exception $e) {
            echo "</br> <strong>";
            die($e->getMessage());
        }
    }
}