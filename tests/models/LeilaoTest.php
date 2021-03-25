<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase {

  /**
   * @dataProvider geraLances
   */

  public function testLeilaoRecebeLances (int $qntLances, Leilao $leilao, array $valores) {
    
    static::assertCount ($qntLances, $leilao->getLances());

    foreach ($valores as $i => $valorEsperado) {
      static::assertEquals ($valorEsperado, $leilao->getLances()[$i]->getValor());
    }
  }

  public function geraLances () {
    $matheus = new Usuario ('Matheus');
    $amanda = new Usuario ('Amanda');

    $leilao2Lances = new Leilao ('Fiat 147 0km');
    $leilao2Lances->recebeLance (new Lance ($matheus, 1000));
    $leilao2Lances->recebeLance (new Lance ($amanda, 2000));

    $leilao1Lance = new Leilao ('Fusca 1972 0km');
    $leilao1Lance->recebeLance (new Lance ($matheus, 5000));

    return [
      '1 Lance' => [1, $leilao1Lance, [5000]],
      '2 Lances' => [2, $leilao2Lances, [1000, 2000]]
    ];
  }
}