<?php

namespace sistema\Nucleo;


class Sessao
{

    public function __construct()
    {
        //checa se não existe um ID de sessão
        if (!session_id()) {
            //inicia uma nova sessão ou resume uma sessão existente
            session_start();
        }
    }

    /**
     * Cria uma sessão
     */
    public function criar(string $chave, mixed $valor): Sessao
    {
        $_SESSION[$chave] = (is_array($valor) ? (object) $valor : $valor);
        return $this;
    }

    /**
     * Carrega uma sessão
     */
    public function carregar(): ?object
    {
        return (object) $_SESSION;
    }

    /**
     * Checa se uma sessão existe
     */
    public function checar(string $chave): bool
    {
        return isset($_SESSION[$chave]);
    }

    /**
     * Limpa a sessão especificada
     */
    public function limpar(string $chave): Sessao
    {
        unset($_SESSION[$chave]);
        return $this;
    }

    /**
     * Destrói todos os dados registrados em uma sessão
     */
    public function deletar(): Sessao
    {
        session_destroy();
        return $this;
    }

    /**
     * __get() é utilizado para ler dados de atributos inacessíveis.
     */
    public function __get($atributo)
    {
        if (!empty($_SESSION[$atributo])) {
            return $_SESSION[$atributo];
        }
    }

    /**
     * Checa ou limpa mensagens flash
     */
    public function flash(): ?Mensagem
    {
        if ($this->checar('flash')) {
            $flash = $this->flash;
            $this->limpar('flash');
            return $flash;
        }
        return null;
    }

}
