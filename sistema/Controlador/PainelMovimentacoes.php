<?php

namespace sistema\Controlador;

use sistema\Modelo\ItensModelo;
use sistema\Modelo\MovimentacaoModelo;
use sistema\Modelo\UsuarioModelo;
use sistema\Nucleo\Helpers;


class PainelMovimentacoes extends PainelControlador
{

    /* ==============================MENU ============================== */

    public function menu($slug)
    {

        $item = $slug;
        $itemBusca = (new ItensModelo())->buscaPorSlug($slug);

        $movimentacoes = (new MovimentacaoModelo())->busca("id_item = {$itemBusca->id}")->ordem("id DESC")->limite(5)->resultado(true);


        echo $this->template->renderizar('itens/menu/item.html', [
            'item' => $item,
            'itemCapa' => $itemBusca->capa,
            'quantidade' => $itemBusca->quantidade,
            'movimentacoes' => $movimentacoes
        ]);
    }


    public function adicionar($slug)
    {

        $item = $slug;
        $usuario = (new UsuarioModelo());

        $itemBusca = (new ItensModelo())->buscaPorSlug($slug);


        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            if ($this->validarMovimentacaoAdicionar($dados)) {
                $movimentacao = new MovimentacaoModelo();

                $movimentacao->id_item = $itemBusca->id;
                $movimentacao->usuario_responsavel_id = $dados['usuario_responsavel_id'];
                $movimentacao->tipo = 'entrada';
                $movimentacao->quantidade_mov = $dados['quantidade_mov'];
                $movimentacao->data = date('Y/m/d H:i:s');
                $movimentacao->descricao = $dados['descricao'];


                if ($movimentacao->salvar()) {
                    $itensModelo = new ItensModelo();
                    $itensModelo->atualizarSomaQuantidade($itemBusca->id, $movimentacao->quantidade_mov);

                    $this->mensagem->sucesso('Movimentação feita com sucesso!')->flash();
                    Helpers::redirecionar('dashboard/item/' . $slug);
                } else {
                    $this->mensagem->erro($movimentacao->erro())->flash();
                    Helpers::redirecionar('dashboard/item/' . $slug);
                }
            }
        }


        echo $this->template->renderizar('itens/menu/adicionar.html', [
            'item' => $item,
            'usuarios' => $usuario->busca()->ordem('nome ASC')->resultado(true)
        ]);
    }

    public function remover($slug)
    {

        $item = $slug;
        $usuario = (new UsuarioModelo());

        $itemBusca = (new ItensModelo())->buscaPorSlug($slug);


        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            if ($this->validarMovimentacaoRemover($dados)) {
                $movimentacao = new MovimentacaoModelo();

                $movimentacao->id_item = $itemBusca->id;
                $movimentacao->usuario_retirante_id = $dados['usuario_retirante_id'];
                $movimentacao->usuario_entregador_id = $dados['usuario_entregador_id'];
                $movimentacao->tipo = 'saida';
                $movimentacao->quantidade_mov = $dados['quantidade_mov'];
                $movimentacao->data = date('Y/m/d H:i:s');
                $movimentacao->descricao = $dados['descricao'];


                if ($movimentacao->salvar()) {
                    $itensModelo = new ItensModelo();
                    $itensModelo->atualizarSubtracaoQuantidade($itemBusca->id, $movimentacao->quantidade_mov);

                    $this->mensagem->sucesso('Movimentação feita com sucesso!')->flash();
                    Helpers::redirecionar('dashboard/item/' . $slug);
                } else {
                    $this->mensagem->erro($movimentacao->erro())->flash();
                    Helpers::redirecionar('dashboard/item/' . $slug);
                }
            }
        }


        echo $this->template->renderizar('itens/menu/remover.html', [
            'item' => $item,
            'usuarios' => $usuario->busca()->ordem('nome ASC')->resultado(true)
        ]);
    }





    public function validarMovimentacaoAdicionar($dados)
    {
        if (empty($dados['quantidade_mov'])) {
            $this->mensagem->alerta('Escreva a quantidade!')->flash();
            return false;
        }
        
        if ($dados['quantidade_mov'] <= 0) {
            $this->mensagem->alerta('A quantidade não pode ser igual ou menor que 0')->flash();
            return false;
        }

        if (empty($dados['usuario_responsavel_id'])) {
            $this->mensagem->alerta('Quem é o responsavel?')->flash();
            return false;
        }

        return true;
    }

    public function validarMovimentacaoRemover($dados)
    {

        if (empty($dados['quantidade_mov'])) {
            $this->mensagem->alerta('Escreva a quantidade!')->flash();
            return false;
        }
        
        if ($dados['quantidade_mov'] <= 0) {
            $this->mensagem->alerta('A quantidade não pode ser igual ou menor que 0')->flash();
            return false;
        }

        if ($dados['usuario_retirante_id'] == 0) {
            $this->mensagem->alerta('Selecione o Retirante!')->flash();
            return false;
        }

        if ($dados['usuario_entregador_id'] == 0) {
            $this->mensagem->alerta('Selecione o Entregador!')->flash();
            return false;
        }

        return true;
    }


    public function movimentacoes($slug)
    {

        $item = $slug;

        $itemBusca = (new ItensModelo())->buscaPorSlug($slug);

        $movimentacoes = (new MovimentacaoModelo())->busca("id_item = {$itemBusca->id}")->ordem("id DESC")->limite(5)->resultado(true);

        echo $this->template->renderizar('itens/menu/movimentacoes.html', [
            'item' => $item,
            'movimentacoes' => $movimentacoes
        ]);
    }

    public function detalhesMovimentacao($slug_item, $id_movi)
    {

        $item = $slug_item;

        $itemBusca = (new ItensModelo())->buscaPorSlug($slug_item);

        $movimentacoes = (new MovimentacaoModelo())->buscaPorId($id_movi);

        if ($movimentacoes->usuario_responsavel_id) {
            $usuarios_resp = (new UsuarioModelo())->buscaPorId($movimentacoes->usuario_responsavel_id);
        }




        if ($movimentacoes->usuario_entregador_id && $movimentacoes->usuario_retirante_id) {
            $usuarios_entregador = (new UsuarioModelo())->buscaPorId($movimentacoes->usuario_entregador_id);
            $usuarios_retirante = (new UsuarioModelo())->buscaPorId($movimentacoes->usuario_retirante_id);
        }



        echo $this->template->renderizar('itens/menu/detalhes.html', [
            'item' => $item,
            'movimentacao' => $movimentacoes,
            'usuarioResp' => $usuarios_resp,
            'usuarioEntre' => $usuarios_entregador,
            'usuarioReti' => $usuarios_retirante

        ]);
    }


    public function listar()
    {
        $movimentacoesModelo = new MovimentacaoModelo();
        $movimentacoes = $movimentacoesModelo->buscaComSlug();  // Chamando diretamente o método buscaComItens
    
        echo $this->template->renderizar('movimentacoes.html', [
            'movimentacoes' => $movimentacoes
        ]);
    }
    
}
