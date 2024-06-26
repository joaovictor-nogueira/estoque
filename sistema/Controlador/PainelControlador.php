<?php

namespace sistema\Controlador;

use sistema\Controlador\UsuarioControlador;
use sistema\Nucleo\Controlador;
use sistema\Nucleo\Helpers;
use sistema\Nucleo\Sessao;

/**
 * Classe SaasControlador
 */
class PainelControlador extends Controlador
{
    private $usuario;
    
    public function __construct()
    {
        parent::__construct('templates/painel/views');
        
        $this->usuario = UsuarioControlador::usuario();

        if(!$this->usuario OR $this->usuario->level < 1){
            $this->mensagem->alerta('Faça login para acessar o painel!')->flash();
            
            $sessao = new Sessao();
            $sessao->limpar('usuarioId');
            
            Helpers::redirecionar();
        }
    }


    
}
