<?php

namespace sistema\Controlador;

use sistema\Modelo\ItensModelo;


class PainelCompras extends PainelControlador
{

    public function menu()
    {
        

        echo $this->template->renderizar('compras/menu.html', [
            
        ]);
    }
    public function acabando()
    {

        $itens = (new ItensModelo())->ItensAcabando();



        echo $this->template->renderizar('compras/acabando.html', [
            'itens' => [
                'acabando' => $itens,
            ]
        ]);
    }
    public function esgotado()
    {

        $itens = (new ItensModelo())->itensAcabados();



        echo $this->template->renderizar('compras/esgotado.html', [
            'itens' => [
                'acabado' => $itens,
            ]
        ]);
    }
}
