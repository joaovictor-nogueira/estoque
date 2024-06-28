<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;
use sistema\Nucleo\Conexao;

/**
 * Classe ItensModelo
 */
class ItensModelo extends Modelo
{

    public function __construct()
    {
        parent::__construct('itens');
    }



    /**
     * Busca o usuário pelo ID
     */
    public function usuario(): ?UsuarioModelo
    {
        if ($this->usuario_id) {
            return (new UsuarioModelo())->buscaPorId($this->usuario_id);
        }
        return null;
    }
    /**
     * Salva a viagem com slug
     */
    public function salvar(): bool
    {
        $this->slug();
        return parent::salvar();
    }

    public function buscaPorCodigoBarra(string $codigobarra)
    {
        $busca = $this->busca("codigo_barra = :c", "c={$codigobarra}");
        return $busca->resultado();
    }

    public function ItensAcabando($limite = null)
    {
        // Base da consulta
        $query = "SELECT * FROM itens WHERE quantidade <= quant_min AND quantidade > 0 AND `status` = 1";

        // Adiciona a cláusula LIMIT se um limite for fornecido
        if ($limite !== null) {
            $query .= " LIMIT :limite";
        }

        $stmt = Conexao::getInstancia()->prepare($query);

        // Liga o parâmetro limite se ele for fornecido
        if ($limite !== null) {
            $stmt->bindValue(':limite', (int) $limite, \PDO::PARAM_INT);
        }

        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }

    public function itensAcabados($limite = null)
    {
        $query = "SELECT * FROM itens WHERE quantidade = 0 AND `status` = 1";

        // Adiciona a cláusula LIMIT se um limite for fornecido
        if ($limite !== null) {
            $query .= " LIMIT :limite";
        }

        $stmt = Conexao::getInstancia()->prepare($query);

        // Liga o parâmetro limite se ele for fornecido
        if ($limite !== null) {
            $stmt->bindValue(':limite', (int) $limite, \PDO::PARAM_INT);
        }

        $stmt->execute();
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $resultado;
    }

    public function atualizarSomaQuantidade($id_item, $quantidade)
    {
        $query = "UPDATE itens SET quantidade = quantidade + :quantidade WHERE id = :id";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':id', $id_item);
        return $stmt->execute();
    }

    public function atualizarSubtracaoQuantidade($id_item, $quantidade)
    {
        $query = "UPDATE itens SET quantidade = quantidade - :quantidade WHERE id = :id";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':id', $id_item);
        return $stmt->execute();
    }
}
