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

  public function testLeilaoSemLancesRepetidos () {
    $this->expectException(\DomainException::class);
    $this->expectExceptionMessage('O usuário não pode propor 2 lances seguidos.');

    $leilao = new Leilao ('Fiat 147 0km');

    $ana = new Usuario ('Ana');

    $leilao->recebeLance (new Lance ($ana, 1000));
    $leilao->recebeLance (new Lance ($ana, 1500));
  }

  public function testNaoAceitarMaisDe5LancesPorPessoa () {
    $this->expectException(\DomainException::class);
    $this->expectExceptionMessage('Nenhum usuário pode propor mais de 5 lances no mesmo leilão');

    $leilao = new Leilao('Brasília Amarela 0km');

    $matheus = new Usuario ('Matheus');
    $amanda = new Usuario ('Amanda');

    $leilao->recebeLance (new Lance ($matheus, 1000));
    $leilao->recebeLance (new Lance ($amanda, 1500));

    $leilao->recebeLance (new Lance ($matheus, 2000));
    $leilao->recebeLance (new Lance ($amanda, 2500));

    $leilao->recebeLance (new Lance ($matheus, 3000));
    $leilao->recebeLance (new Lance ($amanda, 3500));

    $leilao->recebeLance (new Lance ($matheus, 4000));
    $leilao->recebeLance (new Lance ($amanda, 4500));

    $leilao->recebeLance (new Lance ($matheus, 5000));
    $leilao->recebeLance (new Lance ($amanda, 5500));

    $leilao->recebeLance (new Lance ($matheus, 6000));
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