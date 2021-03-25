<?php

namespace Alura\Leilao\Model;

class Leilao {
  /** @var Lance[] */
  private $lances;
  /** @var string */
  private $descricao;

  public function __construct (string $descricao) {
    $this->descricao = $descricao;
    $this->lances = [];
  }

  public function recebeLance (Lance $lance) {
    if (!empty($this->lances) && $this->doUltimoUsuario($lance)) {
      return;
    }
    
    $this->lances[] = $lance;
  }

  /**
   * @return Lance[]
  */
  
  public function getLances (): array {
    return $this->lances;
  }

  /**
   * @param Lance $lance
   * @return bool
  */

  private function doUltimoUsuario (Lance $lance): bool {
    $ultimoLance = $this->lances[array_key_last($this->lances)];

    return $lance->getUsuario() == $ultimoLance->getUsuario();
  }
}
