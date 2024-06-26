<?php 

namespace sistema\Controlador;

use sistema\Nucleo\Sessao;
use sistema\Nucleo\Helpers;
use sistema\Modelo\ItensModelo;


class PainelDashboard extends PainelControlador{


    public function dashboard(){

        $itens= (new ItensModelo());
        
        echo $this->template->renderizar('dashboard.html', [
            'itens' => [
                'acabando' => $itens->ItensAcabando(5),
                'acabados' => $itens->itensAcabados()
            ]
            
        ]);
    }

    public function sair()
    {

        $sessao = new Sessao();
        $sessao->limpar('usuarioId');

        $this->mensagem->informa('Você saiu do painel de controle!')->flash();
        Helpers::redirecionar();
    }

}




?>