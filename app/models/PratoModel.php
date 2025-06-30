<?php
require_once __DIR__.'/../../includes/Database.php';

class PratoModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function listarTodos() {
    try {
        $sql = "SELECT id, nome, ingredientes, tempo_preparo, categoria, favorito, preco, imagem 
                FROM pratos 
                ORDER BY nome";
        $result = $this->db->query($sql);
        
        if (!$result) {
            throw new Exception("Erro ao executar consulta");
        }
        
        return $result->fetchAll();
    } catch (Exception $e) {
        error_log("Erro em listarTodos: " . $e->getMessage());
        return [];
    }
}

    public function buscarPorId($id) {
        $sql = "SELECT * FROM pratos WHERE id = ?";
        return $this->db->query($sql, [$id])->fetch();
    }

    public function salvar($dados) {
        $dadosCompletos = [
            'nome' => $dados['nome'],
            'ingredientes' => $dados['ingredientes'],
            'tempo_preparo' => $dados['tempo_preparo'] ?? null,
            'categoria' => $dados['categoria'] ?? null,
            'favorito' => isset($dados['favorito']) ? 1 : 0,
            'preco' => $dados['preco'],
            'imagem' => $dados['imagem'] ?? 'default.jpg',
            'id' => $dados['id'] ?? null
        ];

        if (empty($dadosCompletos['id'])) {
            return $this->inserir($dadosCompletos);
        } else {
            return $this->atualizar($dadosCompletos);
        }
    }

    private function inserir($dados) {
    $sql = "INSERT INTO pratos 
            (nome, ingredientes, tempo_preparo, categoria, favorito, preco, imagem) 
            VALUES 
            (:nome, :ingredientes, :tempo_preparo, :categoria, :favorito, :preco, :imagem)";
    
    // Remover o 'id' do array
    $params = $dados;
    unset($params['id']);
    
    return $this->db->query($sql, $params)->rowCount() > 0;
}


    private function atualizar($dados) {
        $sql = "UPDATE pratos SET 
                nome = :nome,
                ingredientes = :ingredientes,
                tempo_preparo = :tempo_preparo,
                categoria = :categoria,
                favorito = :favorito,
                preco = :preco,
                imagem = :imagem
                WHERE id = :id";
        return $this->db->query($sql, $dados)->rowCount() > 0;
    }

    public function excluir($id) {
        $sql = "DELETE FROM pratos WHERE id = ?";
        return $this->db->query($sql, [$id])->rowCount() > 0;
    }

    public function atualizarFavorito($pratoId, $favorito) {
        $sql = "UPDATE pratos SET favorito = :favorito WHERE id = :id";
        $stmt = Database::prepare($sql);
        $stmt->bindParam(':favorito', $favorito, PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $pratoId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}