<?php

namespace Alura\Leilao\Model;

class Leilao {
  /** @var Lance[] */
  private $lances;
  /** @var string */
  private $descricao;
  /**$var bool */
  private $finalizado;

  public function __construct (string $descricao) {
    $this->descricao = $descricao;
    $this->lances = [];
    $this->finalizado = false;
  }

  public function recebeLance (Lance $lance) {
    if (!empty($this->lances) && $this->doUltimoUsuario($lance)) {
      throw new \DomainException('O usuário não pode propor 2 lances seguidos.');
    }

    $totalLancesUsuario = $this->quantidadeLancesPorUsuario($lance->getUsuario());

    if($totalLancesUsuario >= 5) {
      throw new \DomainException('Nenhum usuário pode propor mais de 5 lances no mesmo leilão');
    }
    
    $this->lances[] = $lance;
  }

  /**
   * @return Lance[]
  */
  
  public function getLances (): array {
    return $this->lances;
  }

  public function finaliza () {
    $this->finalizado = true;
  }

  public function estaFinalizado (): bool {
    return $this->finalizado;
  }

  /**
   * @param Lance $lance
   * @return bool
  */

  private function doUltimoUsuario (Lance $lance): bool {
    $ultimoLance = $this->lances[array_key_last($this->lances)];

    return $lance->getUsuario() == $ultimoLance->getUsuario();
  }

  private function quantidadeLancesPorUsuario (Usuario $usuario) {
    $totalLancesUsuario = array_reduce(
      $this->lances, 
      function (int $totalAcumulado, Lance $lanceAtual) use ($usuario) {
        if ($lanceAtual->getUsuario() == $usuario) {
          return $totalAcumulado + 1;
        }
        return $totalAcumulado;
      }, 
    0);

    return $totalLancesUsuario;
  }
}
