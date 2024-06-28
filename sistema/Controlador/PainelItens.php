<?php

namespace sistema\Controlador;

use sistema\Modelo\ItensModelo;
use sistema\Modelo\MovimentacaoModelo;
use Verot\Upload\Upload;
use sistema\Nucleo\Helpers;

class PainelItens extends PainelControlador
{

    private string $capa;



    public function listar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (isset($dados['codigo_barra_busca'])) {

            $codigobarra = $dados['codigo_barra_busca'];

            $item = (new ItensModelo())->buscaPorCodigoBarra($codigobarra);

            if ($item) {
                Helpers::redirecionar("dashboard/item/{$item->slug}");
            } else {
                $this->mensagem->alerta('Item não encontrado pelo código de barras informado.')->flash();
            }
        }


        $itens = (new ItensModelo())->busca();


        echo $this->template->renderizar('itens/listar.html', [

            'itens' => $itens->ordem('id DESC')->resultado(true),
            'total' => [
                'estoques' => $itens->busca(null, 'COUNT(id)', 'id')->total(),
                'estoquesAtivo' => $itens->busca('status = :s', 's=1 COUNT(status))', 'status')->total(),
                'estoqueInativo' => $itens->busca('status = :s', 's=0 COUNT(status)', 'status')->total(),
            ]
        ]);
    }


    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            if ($this->validarDados($dados)) {
                $item = new ItensModelo();


                $item->slug = Helpers::slug($dados['nome']);
                $item->nome = $dados['nome'];
                $item->capa = $this->capa ?? null;
                $item->quantidade = $dados['quantidade'];
                $item->quant_min = $dados['quant_min'];
                $item->codigo_barra = $dados['codigo_barra'];
                $item->status = $dados['status'];



                if ($item->salvar()) {
                    $this->mensagem->sucesso('Item cadastrado com sucesso')->flash();
                    Helpers::redirecionar('dashboard/itens/listar');
                } else {
                    $this->mensagem->erro($item->erro())->flash();
                    Helpers::redirecionar('dashboard/itens/listar');
                }
            }
        }

        echo $this->template->renderizar('itens/formulario.html', [
            'itens' => $dados
        ]);
    }

    public function editar(int $id): void
    {
        $item = (new ItensModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            if ($this->validarDados($dados)) {
                $item = (new ItensModelo())->buscaPorId($id);


                $item->slug = Helpers::slug($dados['nome']);
                $item->nome = $dados['nome'];
                $item->quantidade = $dados['quantidade'];
                $item->quant_min = $dados['quant_min'];
                $item->codigo_barra = $dados['codigo_barra'];
                $item->status = $dados['status'];


                //atualizar a capa no DB e no servidor, se um novo arquivo de imagem for enviado
                if (!empty($_FILES['capa']["name"])) {
                    if ($item->capa && file_exists("uploads/imagens/{$item->capa}")) {
                        unlink("uploads/imagens/{$item->capa}");
                        unlink("uploads/imagens/thumbs/{$item->capa}");
                    }
                    $item->capa = $this->capa ?? null;
                }

                if ($item->salvar()) {
                    $this->mensagem->sucesso('Item atualizado com sucesso')->flash();
                    Helpers::redirecionar('dashboard/itens/listar');
                } else {
                    $this->mensagem->erro($item->erro())->flash();
                    Helpers::redirecionar('dashboard/itens/listar');
                }
            }
        }

        echo $this->template->renderizar('itens/formulario.html', [
            'item' => $item,

        ]);
    }


    public function validarDados(array $dados): bool
    {

        if (empty($dados['nome'])) {
            $this->mensagem->alerta('Escreva um nome para o item!')->flash();
            return false;
        }
        if (empty($dados['quant_min'])) {
            $this->mensagem->alerta('Escreva a quantidade para te avisar quando estiver acabando!')->flash();
            return false;
        }


        if (!empty($_FILES['capa'])) {
            $upload = new Upload($_FILES['capa'], 'pt_BR');
            if ($upload->uploaded) {
                $titulo = $upload->file_new_name_body = Helpers::slug($dados['nome']);
                $upload->jpeg_quality = 90;
                $upload->image_convert = 'jpg';
                $upload->process('uploads/imagens/');

                if ($upload->processed) {
                    $this->capa = $upload->file_dst_name;
                    $upload->file_new_name_body = $titulo;
                    $upload->image_resize = true;
                    $upload->image_x = 500;
                    $upload->image_y = 400;
                    $upload->jpeg_quality = 70;
                    $upload->image_convert = 'jpg';
                    $upload->process('uploads/imagens/thumbs/');
                    $upload->clean();
                } else {
                    $this->mensagem->alerta($upload->error)->flash();
                    return false;
                }
            }
        }

        return true;
    }

    public function deletar(int $id): void
    {
        if (is_int($id)) {
            $item = (new ItensModelo())->buscaPorId($id);
            if (!$item) {
                $this->mensagem->alerta('A Item que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('dashboard/itens/listar');
            } else {



                if ($item->deletar()) {

                    // Deletar movimentações relacionadas ao item
                    $movimentacaoModelo = new MovimentacaoModelo();
                    $movimentacaoModelo->deletarPorItemId($id);

                    if ($item->capa && file_exists("uploads/imagens/{$item->capa}")) {
                        unlink("uploads/imagens/{$item->capa}");
                        unlink("uploads/imagens/thumbs/{$item->capa}");
                    }

                    $this->mensagem->sucesso('Item deletado com sucesso!')->flash();
                    Helpers::redirecionar('dashboard/itens/listar');
                } else {
                    $this->mensagem->erro($item->erro())->flash();
                    Helpers::redirecionar('dashboard/itens/listar');
                }
            }
        }
    }
}
