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
        $query = "SELECT movimentacoes.*, itens.nome AS item_nome, itens.slug AS item_slug FROM movimentacoes JOIN itens ON movimentacoes.id_item = itens.id ORDER BY movimentacoes.id DESC";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_OBJ);

        return $resultado;
    }

    public function deletarPorItemId($id_item)
    {
        $query = "DELETE FROM movimentacoes WHERE id_item = :id_item";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->bindParam(':id_item', $id_item, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
