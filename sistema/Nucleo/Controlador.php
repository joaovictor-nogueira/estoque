<?php

namespace sistema\Nucleo;

use sistema\Suporte\Template;

/**
 * Classe Controlador, responsável por instanciar templates e mensagens para uso global
 */
class Controlador
{
    protected Template $template;
    protected Mensagem $mensagem;

    /**
     * Construtor responsável por definir o diretório pai das views e criar a instancia do engine template e mensagens.
     */
    public function __construct(string $diretorio)
    {
        $this->template = new Template($diretorio);
        
        $this->mensagem = new Mensagem();
    }
}
