<?php

namespace sistema\Nucleo;

use sistema\Nucleo\Conexao;
use sistema\Nucleo\Mensagem;

/**
 * Classe Active Record Modelo - Active Record é um padrão de projeto que trabalha com a técnica ORM (Object Relational Mapper). Este padrão consiste em mapear um objeto a uma tabela do Banco da dados, a fim de tornar o trabalho com os dados persistido em um banco de dados, totalmente orientado a objetos.
 */
abstract class Modelo
{

    protected $dados;
    protected $query;
    protected $erro;
    protected $parametros;
    protected $tabela;
    protected $ordem;
    protected $limite;
    protected $offset;
    protected $mensagem;

    /**
     * Construtor da classe
     */
    public function __construct(string $tabela)
    {
        $this->tabela = $tabela;
        $this->mensagem = new Mensagem();
    }

    /**
     * Ordenação
     */
    public function ordem(string $ordem)
    {
        $this->ordem = " ORDER BY {$ordem}";
        return $this;
    }

    /**
     * Limite
     */
    public function limite(string $limite)
    {
        $this->limite = " LIMIT {$limite}";
        return $this;
    }

    /**
     * Offset

     */
    public function offset(string $offset)
    {
        $this->offset = " OFFSET {$offset}";
        return $this;
    }

    /**
     * Erros
     */
    public function erro(): mixed
    {
        return $this->erro;
    }

    /**
     * Mensagens
     */
    public function mensagem(): ?Mensagem
    {
        return $this->mensagem;
    }

    /**
     * Dados
     */
    public function dados(): ?object
    {
        return $this->dados;
    }

    /**
     * __set() é executado ao escrever dados em atributos inacessíveis.
     */
    public function __set($nome, $valor)
    {
        if (empty($this->dados)) {
            $this->dados = new \stdClass();
        }
        $this->dados->$nome = $valor;
    }

    /**
     * __isset() é disparado ao chamar a função isset() ou empty() em atributos inacessíveis.
     */
    public function __isset($nome)
    {
        return isset($this->dados->$nome);
    }

    /**
     * __get é ativado sempre que tentar acessar uma atributos que não existe ou está inacessivel
     */
    public function __get($nome)
    {
        return $this->dados->$nome ?? null;
    }

    /**
     * Busca dados de acordo com os termos e parametros informados
     */
    public function busca(?string $termos = null, string $parametros = '', string $colunas = '*'): object
    {
        if ($termos) {
            $this->query = "SELECT {$colunas} FROM " . $this->tabela . " WHERE {$termos} ";
            parse_str($parametros, $this->parametros);
            return $this;
        }

        $this->query = "SELECT {$colunas} FROM " . $this->tabela;
        return $this;
    }

    /**
     * Retorna um ou todos os registros
     */
    public function resultado(bool $todos = false): mixed
    {
        try {
            $stmt = Conexao::getInstancia()->prepare($this->query . $this->ordem . $this->limite . $this->offset);
            $stmt->execute($this->parametros);

            if (!$stmt->rowCount()) {
                return null;
            }

            if ($todos) {
                //PDO::FETCH_CLASS: Retorna instâncias da classe especificada, mapeando as colunas de cada linha para propriedades nomeadas na classe.
                return $stmt->fetchAll(\PDO::FETCH_CLASS, static::class);
            }
            //fetchObject - Busca a próxima linha e a retorna como um objeto
            return $stmt->fetchObject(static::class);
        } catch (\PDOException $ex) {
            $this->erro = $ex;
            return null;
        }
    }

    /**
     * Cadastra os dados
     */
    protected function cadastrar(array $dados): ?int
    {
        try {
            $colunas = implode(',', array_keys($dados));
            $valores = ':' . implode(',:', array_keys($dados));

            $query = "INSERT INTO " . $this->tabela . " ({$colunas}) VALUES ({$valores}) ";
            $stmt = Conexao::getInstancia()->prepare($query);
            $stmt->execute($this->filtro($dados));

            return Conexao::getInstancia()->lastInsertId();
        } catch (\PDOException $ex) {
            $this->erro = $ex->getMessage();
            return null;
        }
    }

    /**
     * Atualiza dados de acordo com os termos e parametros informados
     */
    protected function atualizar(array $dados, string $termos): int
    {
        try {
            $set = [];

            foreach ($dados as $chave => $valor) {
                $set[] = "{$chave} = :{$chave}";
            }
            $set = implode(', ', $set);

            $query = "UPDATE " . $this->tabela . " SET {$set} WHERE {$termos}";
            $stmt = Conexao::getInstancia()->prepare($query);
            $stmt->execute($this->filtro($dados));

            return ($stmt->rowCount() ?? 1);
        } catch (\PDOException $ex) {
            $this->erro = $ex->getMessage();
            return null;
        }
    }

    /**
     * Filtra os dados
     */
    private function filtro(array $dados): ?array
    {
        $filtro = [];

        foreach ($dados as $chave => $valor) {
            $filtro[$chave] = (is_null($valor) ? null : filter_var($valor, FILTER_DEFAULT));
        }
        return $filtro;
    }

    /**
     * Armazena os dados
     */
    protected function armazenar(): ?array
    {
        $dados = (array) $this->dados;

        return $dados;
    }

    /**
     * Busca por ID
     */
    public function buscaPorId(int $id): ?Modelo
    {
        $busca = $this->busca("id = {$id}");
        return $busca->resultado();
    }

    /**
     * Busca por Slug
     */
    public function buscaPorSlug(string $slug): ?Modelo
    {
        $busca = $this->busca("slug = :s", "s={$slug}");
        return $busca->resultado();
    }

    /**
     * Apaga registros de acordo com os termos informados
     */
    public function apagar(string $termos): bool
    {
        try {
            $query = "DELETE FROM " . $this->tabela . " WHERE {$termos}";
            $stmt = Conexao::getInstancia()->prepare($query);
            $stmt->execute();

            return true;
        } catch (\PDOException $ex) {
            $this->erro = $ex->getMessage();
            return null;
        }
    }

    /**
     * Deleta um registro pelo ID
     */
    public function deletar(): bool
    {
        if (empty($this->id)) {
            $this->erro = 'Erro de sistema ao tentar deletar!';
            return false;
        }

        $deletar = $this->apagar("id = {$this->id}");
        return $deletar;
    }

    /**
     * Retorna o total de registros
     */
    public function total(): int
    {
        $stmt = Conexao::getInstancia()->prepare($this->query);
        $stmt->execute($this->parametros);
        return $stmt->rowCount();
    }

    /**
     * Salva e atualiza os dados
     */
    public function salvar(): bool
    {
        //CADASTRAR
        if (empty($this->id)) {
            $id = $this->cadastrar($this->armazenar());
            if ($this->erro) {
                $this->mensagem->erro('Erro de sistema ao tentar cadastrar os dados');
                return false;
            }
        }

        //ATUALIZAR
        if (!empty($this->id)) {
            $id = $this->id;
            $this->atualizar($this->armazenar(), "id = {$id}");
            if ($this->erro) {
                $this->mensagem->erro('Erro de sistema ao tentar atualizar os dados');
                return false;
            }
        }

        $this->dados = $this->buscaPorId($id)->dados();
        return true;
    }

    /**
     * Retorna o ultimo ID da tabela
     */
    public function ultimoId(): int
    {
        return Conexao::getInstancia()->query("SELECT MAX(id) as maximo FROM {$this->tabela}")->fetch()->maximo;
    }

    /**
     * Checa e monta Slug - URL amigável
     */
    protected function slug(): void
    {
        $baseSlug = $this->slug; // Pega o slug base do título

        $suffix = 1; // Inicializa o sufixo numérico
        // Enquanto houver slugs iguais no banco de dados, aumenta o sufixo
        while ($this->checaSlugExistente($this->slug)) {
            $this->slug = "{$baseSlug}-{$suffix}";
            $suffix++;
        }
    }

    /**
     * Verifica se o slug já existe no banco de dados
     */
    private function checaSlugExistente($slug): bool
    {
        return $this->busca("slug = :s AND id != :id", "s={$slug}&id={$this->id}")->total() > 0;
    }



}
