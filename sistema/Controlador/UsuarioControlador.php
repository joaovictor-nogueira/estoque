<?php

namespace sistema\Controlador;

use sistema\Nucleo\Controlador;
use sistema\Nucleo\Helpers;
use sistema\Nucleo\Sessao;
use sistema\Modelo\UsuarioModelo;


class UsuarioControlador extends Controlador
{

    public function __construct()
    {
        parent::__construct('templates/painel/views');
    }

    /**
     * Busca usuário pela sessão
     */
    public static function usuario(): ?UsuarioModelo
    {
        $sessao = new Sessao();
        if (!$sessao->checar('usuarioId')) {
            return null;
        }

        return (new UsuarioModelo())->buscaPorId($sessao->usuarioId);
    }
    /**
     * Login
     */
    public function login(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if (in_array('', $dados)) {
                $this->mensagem->erro('Informe seu login e senha!')->flash();
                Helpers::redirecionar();
            } else {
                $usuario = new UsuarioModelo();

                if ($usuario->login($dados, 1)) {
                    $this->mensagem->sucesso('Login realizado com sucesso!')->flash();
                    Helpers::redirecionar('dashboard');
                } else {
                    $this->mensagem->erro(strip_tags($usuario->mensagem()))->flash();
                    Helpers::redirecionar();
                }
            }
        }
    }
}
