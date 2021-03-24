<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

require 'vendor/autoload.php';

// preparação para o cenário de teste
$leilao = new Leilao ('Fiat 147 0km');

$amanda = new Usuario ('Amanda');
$matheus = new Usuario ('Matheus');

$leilao->recebeLance (new Lance ($matheus, 2000));
$leilao->recebeLance (new Lance ($amanda, 2500));

$leiloeiro = new Avaliador();

// execução do teste
$leiloeiro->avalia ($leilao);

$maiorValor = $leiloeiro->getMaiorValor();


// validação da saida
$valorEsperado= 2500;

if ($maiorValor == $valorEsperado) {
  echo 'Teste OK :)';
} else {
  echo 'Teste falhou :(';
}