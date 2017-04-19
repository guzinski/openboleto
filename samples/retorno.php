<?php

include '../vendor/autoload.php';

use Cnab\Factory;

$cnabFactory = new Factory();
$arquivo = $cnabFactory->createRetorno('RET20170418045751164.RET');
$detalhes = $arquivo->listDetalhes();
foreach($detalhes as $detalhe) {
    /* @var $detalhe Cnab\Retorno\Cnab240\Detalhe */
//    var_dump($detalhe);
    if($detalhe->getValorRecebido() > 0) {
        echo "Nosso Número" . $detalhe->getNossoNumero();
        echo "  -  Valor:". $detalhe->getValorRecebido();
        echo "  -  Data :". $detalhe->getDataOcorrencia()->format("d/m/Y");
        echo "  -  Data :". $detalhe->getDataCredito()->format("d/m/Y");
        echo "  -  Data :". $detalhe->getDataVencimento()->format("d/m/Y");
        echo "<br/><hr/>";
//        echo $nossoNumero   = $detalhe->getNossoNumero();
//        $valorRecebido = $detalhe->getValorRecebido();
//        echo $dataPagamento = $detalhe->getDataOcorrencia();
//        echo $detalhe->dump();
    
//        $carteira      = $detalhe->getCarteira();
//        // você já tem as informações, pode dar baixa no boleto aqui
    }
}

