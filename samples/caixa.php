<?php

require "../vendor/autoload.php";

use Cnab\Banco;
use Cnab\Especie;
use Cnab\Remessa\Cnab240\Arquivo;
use OpenBoleto\Agente;
use OpenBoleto\Banco\Caixa;

$sacado = new Agente('Luciano Guzinski', '024.232.580-43', 'Rua Abaeté, 52', '91130-490', 'Porto Alegre', 'RS');
$cedente = new Agente('CGE CENTRAL GAUCHA DE ESTAGIOS', '23.678.359/0001-18', 'Assis Brasil 3535 8º Andar, Sala 814 ', '91010-007', 'Porto Alegre', 'RS');


$vencimento = new DateTime('2017-04-28');
$valor = 1.25;
$nossoNumero = 302;


$boleto = new Caixa(array(
    // Parâmetros obrigatórios
    'dataVencimento' => $vencimento,
    'valor' => $valor,
    'sequencial' => $nossoNumero,
    'numeroDocumento' => $nossoNumero,
    'sacado' => $sacado,
    'cedente' => $cedente,
    'agencia' => '0451', // Até 4 dígitos
    'carteira' => 'RG', // SR => Sem Registro ou RG => Registrada
    'conta' => '678000', // Até 6 dígitos
    'convenio' => '678000', // 4, 6 ou 7 dígitos
    'contaDv' => 8,
    'agenciaDv' => 0,
    'descricaoDemonstrativo' => array(// Até 5
        'Boleto de Testes',
    ),
    'instrucoes' => array(// Até 8
        'MULTA DE 10% APOS o VENCIMENTO.',
        'JUROS DE R$: 0,44 AO DIA.',
        'NÃO RECEBER APOS 5 DIAS DE ATRASO.',
        'TARIFA BANCARIA 4,50.',
        'DEPOSITO OU PAGTO NA CGE TARIFA ISENTA',
    ),
    // Parâmetros opcionais
    //'resourcePath' => '../resources',
    //'moeda' => Caixa::MOEDA_REAL,
    //'dataDocumento' => new DateTime(),
    //'dataProcessamento' => new DateTime(),
    //'contraApresentacao' => true,
    //'pagamentoMinimo' => 23.00,
    //'aceite' => 'N',
    'especieDoc' => 'FAT',
        //'usoBanco' => 'Uso banco',
        //'layout' => 'caixa.phtml',
        //'logoPath' => 'http://boletophp.com.br/img/opensource-55x48-t.png',
        //'sacadorAvalista' => new Agente('Antônio da Silva', '02.123.123/0001-11'),
        //'descontosAbatimentos' => 123.12,
        //'moraMulta' => 123.12,
        //'outrasDeducoes' => 123.12,
        //'outrosAcrescimos' => 123.12,
        //'valorCobrado' => 123.12,
        //'valorUnitario' => 123.12,
        //'quantidade' => 1,
        ));

$codigo_banco = Banco::CEF;
$arquivo = new Arquivo($codigo_banco, $layoutVersao = 'sigcb');
$arquivo->configure(array(
    'data_geracao' => new DateTime(),
    'data_gravacao' => new DateTime(),
    'nome_fantasia' => 'CGE CENTRAL GAUCHA DE ESTAGIOS',
    'razao_social' => 'CGE CENTRAL GAUCHA DE ESTAGIOS', // sua razão social
    'cnpj' => '23.678.359/0001-18', // seu cnpj completo
    'banco' => $codigo_banco, //código do banco
    'logradouro' => 'Assis Brasil  8º Andar, ',
    'numero' => '3535',
    'bairro' => 'Cristo Redentor',
    'cidade' => 'Porto Alegre',
    'uf' => 'RS',
    'cep' => '91010-007',
    'agencia' => '0451',
    'agencia_dv' => '0',
    'conta' => '33526', // número da conta
    'conta_dac' => '9', // digito da conta
    'codigo_cedente' => '678000',
    'operacao' => '003',
    'numero_sequencial_arquivo' => 1,
));

$arquivo->insertDetalhe(array(
    'modalidade_carteira' => '14', //14 (título Registrado emissão Beneficiário)
    'aceite' => 'N',
    'registrado' => 1,
    'codigo_ocorrencia' => 1, // 1 = Entrada de título, futuramente poderemos ter uma constante
    'nosso_numero' => 14000000000000000 + $nossoNumero,
    'numero_documento' => $nossoNumero,
    'especie' => Especie::CEF_DUPLICATA_DE_PRESTACAO_DE_SERVICOS, // Você pode consultar as especies Cnab\Especie
    'valor' => $valor, // Valor do boleto
    'instrucao1' => 0,
    'instrucao2' => 0,
    'sacado_nome' => $sacado->getNome(),
    'sacado_tipo' => 'cpf', //campo fixo, escreva 'cpf' (sim as letras cpf)
    'sacado_cpf' => $sacado->getDocumento(),
    'sacado_logradouro' => "Rua Abaeté 52",
    'sacado_bairro' => "Sarandi",
    'sacado_cep' => "91130-490", // sem hífem
    'sacado_cidade' => "Porto Alegre",
    'sacado_uf' => "RS",
    'data_vencimento' => $vencimento,
    'data_cadastro' => new DateTime("now"),
    'prazo' => 0, // prazo de dias para o cliente pagar após o vencimento
    'taxa_de_permanencia' => '0',
    'juros_de_um_dia' => 0,
    'valor_desconto' => 0,
    'valor_multa' => 0,
    'mensagem' => ' ',
    'identificacao_distribuicao' => 0
));


// para salvar
$arquivo->save('meunomedearquivo.txt');




echo $boleto->getOutput();
