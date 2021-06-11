<html>
<head></head>
<body> 
   <form id="cad_cliente">
    <input type="hidden" name="hashseller" class="hash" id="hash">
    <h3>Dados do cartão</h3>
    cartao        <input class="cartao" type="text" name="ncartao"><br>
    CVV           <input class="cvv" type="text" name="cvv"><br>
    Mes expiração <input class="mes" type="text" name="mesexp"><br>
    Ano expiração <input class="ano" type="text" name="anoexp"><br>
    Nome          <input class="nome" type="text" name="nome"><br>
    <h3>Dados Pessoais</h3>
    email <input type="email" name="email"><br>
    empresa <input type="text" name="empresa"><br>
    telefone <input type="numbar" maxlength="8" name="telefone"><br>
    celular <input type="numbar" maxlength="8" name="celular"><br>
    ocupacao<select name="ocupacao">
    <option value="Estudante">Estudante</option>
    <option value="Profissional">Profissional</option>
    <option value="Associado">Associado</option>
    </select>
    <input type="hidden" name="tokenCartao" class="tokenCartao">
    @csrf
    </form>
    <input type="button" class="pagar" value="verificar">
    <input type="button" value="PAGAR !" onclick="enviar()">
  
<script src="https://code.jquery.com/jquery-3.6.0.min.js">
</script>
<script type="text/javascript" src=
"https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>


<script>
function carregar() {
    PagSeguroDirectPayment.setSessionId('{{$sessionID}}')
}
window.onload = function () {
    carregar()
    var token_cartao
}
$('.cartao').on('blur', function () {
    PagSeguroDirectPayment.onSenderHashReady(function (response) {
        if (response.status == 'error') {
            console.log(response.message);
            return false;
        }
        var hash = response.senderHash; //Hash estará disponível nesta variável.
        document.getElementById('hash').value = hash;
    })
})

$('.parcela').on('blur', function () {
    var bandeira = 'visa';
    totalParcelas = $(this).val();
    PagSeguroDirectPayment.getInstallments({
        amount: $('.total').val(),
        maxInstallmentNoInterest: 2,
        brand: bandeira,
        success: function (response) {
            console.log(response)
            let totalpagar = response['installments'][bandeira][totalParcelas - 1]['totalAmount']
            let valorParcela = response['installments'][bandeira][totalParcelas - 1]['installmentAmount']
            $(".total-pagar").val(totalpagar)
            $(".t-parcela").val(valorParcela)
            console.log(totalpagar)
            console.log(valorParcela)

        },
        error: function (response) {
            // callback para chamadas que falharam.
        },
        complete: function (response) {
            // Callback para todas chamadas.
        }
    });

})

$('.pagar').on("click", function (params) {
    var numero_cartao = $(".cartao").val()
    var iniciocart = numero_cartao.substr(0, 6)
    var cvv = $(".cvv").val()
    var ano = $(".ano").val()
    var mes = $(".mes").val()
    var hashseller = $(".hashseller").val()

    PagSeguroDirectPayment.createCardToken({
        cardNumber: numero_cartao,
        brand: 'visa', // Bandeira do cartão
        cvv: cvv, // CVV do cartão
        expirationMonth: mes, // Mês da expiração do cartão
        expirationYear: ano, // Ano da expiração do cartão, é necessário os 4 dígitos.
        success: function (response) {
            console.log(response)
            $('.tokenCartao').val(response.card.token)
        },
        error: function (response) {
            console.log(response)
        },
        complete: function (response) {
            // Callback para todas chamadas.
        }
    });
})


function enviar() {
    $.ajax({
        type: "POST",
        url: '{{route("concluir")}}',
        data: $('#cad_cliente').serialize(),
        success: function (data) {
            console.log(data)
        }
    });
}
</script>
</body>
</html>
