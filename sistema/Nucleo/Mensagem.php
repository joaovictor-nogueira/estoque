<?php

namespace sistema\Nucleo;

/**
 * Classe Mensagem – responsável por exibir as mensagens do sistema.
 */
class Mensagem
{

    private $texto;
    private $css;

    public function __toString()
    {
        return $this->renderizar();
    }

    /**
     * Método responsável pelas mensagens de sucesso
     */
    public function sucesso(string $mensagem): Mensagem
    {
        $this->css = 'alert alert-success';
        $this->texto = $this->filtrar($mensagem);
        return $this;
    }

    /**
     * Método responsável pelas mensagens de erro
     */
    public function erro(string $mensagem): Mensagem
    {
        $this->css = 'alert alert-danger';
        $this->texto = $this->filtrar($mensagem);
        return $this;
    }

    /**
     * Método responsável pelas mensagens de alerta
     */
    public function alerta(string $mensagem): Mensagem
    {
        $this->css = 'alert alert-warning';
        $this->texto = $this->filtrar($mensagem);
        return $this;
    }

    /**
     * Método responsável pelas mensagens de informações
     */
    public function informa(string $mensagem): Mensagem
    {
        $this->css = 'alert alert-primary';
        $this->texto = $this->filtrar($mensagem);
        return $this;
    }

    /**
     * Método responsável pela renderização das mensagens
     */
    public function renderizar(): string
    {
        return "<div class='{$this->css} alert-dismissible fade show'>{$this->texto}<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }

    /**
     * Método responsável por filtrar as mensagens
     */
    private function filtrar(string $mensagem): string
    {
        return filter_var($mensagem, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    /**
     * Cria a sessão das mensagens flash
     */
    public function flash(): void
    {
        (new Sessao())->criar('flash', $this);
    }

}
