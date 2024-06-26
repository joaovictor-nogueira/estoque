<?php

namespace sistema\Controlador;

use sistema\Nucleo\Controlador;
use sistema\Nucleo\Helpers;


class SiteControlador extends Controlador
{
    protected $usuario;
    

    public function __construct()
    {
        parent::__construct('templates/site/views');
    }

    /**
     * Home Page
     */
    public function index(): void
    {

        $this->usuario = UsuarioControlador::usuario();

        if ($this->usuario && $this->usuario->level == 3) {
            Helpers::redirecionar('dashboard');
        }

        echo $this->template->renderizar('index.html', [

        ]);
    }

    public function erro404(): void
    {
        echo $this->template->renderizar('404.html', [

        ]);
    }

  

}
