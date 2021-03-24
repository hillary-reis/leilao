<?php

namespace Alura\Leilao\Tests\Service;

use PHPUnit\Framework\TestCase;
use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

class AvaliadorTest extends TestCase {

  private $leiloeiro;

  protected function setUp (): void {
    $this->leiloeiro =  new Avaliador();
  }

  /**
   * @dataProvider leilaoOrdemCrescente
   * @dataProvider leilaoOrdemDecrescente
   * @dataProvider leilaoOrdemAleatoria
  */
  //métodos de testes
  public function testAvaliadorEncontraMaiorValorLances (Leilao $leilao) {
    // execução do teste
    $this->leiloeiro->avalia ($leilao);

    $maiorValor = $this->leiloeiro->getMaiorValor();

    self::assertEquals(5200, $maiorValor);
  }

  /**
   * @dataProvider leilaoOrdemCrescente
   * @dataProvider leilaoOrdemDecrescente
   * @dataProvider leilaoOrdemAleatoria
  */
  public function testAvaliadorEncontraMenorValorLances (Leilao $leilao) {
    // execução do teste
    $this->leiloeiro->avalia ($leilao);

    $menorValor = $this->leiloeiro->getMenorValor();

    self::assertEquals(1210, $menorValor);
  }

  /**
   * @dataProvider leilaoOrdemCrescente
   * @dataProvider leilaoOrdemDecrescente
   * @dataProvider leilaoOrdemAleatoria
  */
  public function testAvaliadorEncontraTresMaioresLances (Leilao $leilao) {
    // execução do teste
    $this->leiloeiro->avalia ($leilao);

    $maiores = $this->leiloeiro->getMaioresLances();

    // verificação de quantos itens tem no array
    static::assertCount(3, $maiores);

    // verificação do conteudo do aray $maiores
    static::assertEquals(5200, $maiores[0]->getValor());
    static::assertEquals(3280, $maiores[1]->getValor());
    static::assertEquals(2200, $maiores[2]->getValor());
  }

  // métodos para tirar a repetição de código (dados)
  public function leilaoOrdemCrescente () {
    $leilao = new Leilao ('Fiat 147 0km');

    $matheus = new Usuario ('Matheus');
    $amanda = new Usuario ('Amanda');
    $bruno = new Usuario ('Bruno');
    $davi = new Usuario ('Davi');

    $leilao->recebeLance (new Lance ($matheus, 1210));
    $leilao->recebeLance (new Lance ($bruno, 2200));
    $leilao->recebeLance (new Lance ($davi, 3280));
    $leilao->recebeLance (new Lance ($amanda, 5200));

    return [[$leilao]];
  }
  public function leilaoOrdemDecrescente () {
    $leilao = new Leilao ('Fiat 147 0km');

    $matheus = new Usuario ('Matheus');
    $amanda = new Usuario ('Amanda');
    $bruno = new Usuario ('Bruno');
    $davi = new Usuario ('Davi');

    $leilao->recebeLance (new Lance ($amanda, 5200));
    $leilao->recebeLance (new Lance ($davi, 3280));
    $leilao->recebeLance (new Lance ($bruno, 2200));
    $leilao->recebeLance (new Lance ($matheus, 1210));

    return [[$leilao]];
  }
  public function leilaoOrdemAleatoria () {
    $leilao = new Leilao ('Fiat 147 0km');

    $matheus = new Usuario ('Matheus');
    $amanda = new Usuario ('Amanda');
    $bruno = new Usuario ('Bruno');
    $davi = new Usuario ('Davi');

    $leilao->recebeLance (new Lance ($davi, 3280));
    $leilao->recebeLance (new Lance ($bruno, 2200));
    $leilao->recebeLance (new Lance ($amanda, 5200));
    $leilao->recebeLance (new Lance ($matheus, 1210));

    return [[$leilao]];
  }
}
