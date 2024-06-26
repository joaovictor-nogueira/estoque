<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;
use sistema\Nucleo\Conexao;

/**
 * Classe MovimentacaoModelo
 */
class MovimentacaoModelo extends Modelo
{

    public function __construct()
    {
        parent::__construct('movimentacoes');
    }


    public function buscaComItens()
    {
        $query = "SELECT movimentacoes.*, itens.nome AS item_nome FROM movimentacoes JOIN itens ON movimentacoes.id_item = itens.id ORDER BY movimentacoes.id DESC";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_OBJ);

        return $resultado;
    }
    public function buscaComSlug()
    {
        $query = "SELECT movimentacoes.*, itens.slug AS item_slug FROM movimentacoes JOIN itens ON movimentacoes.id_item = itens.id ORDER BY movimentacoes.id DESC";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_OBJ);

        return $resultado;
    }
}
