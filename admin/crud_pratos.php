<?php
require_once 'includes/db.php'; // Alterado para includes/db.php

class PratoCRUD {
    private $conn;
    
    public function __construct() {
        global $conn;
        if (!$conn) {
            throw new Exception("Conexão com banco de dados não estabelecida");
        }
        $this->conn = $conn;
    }
    
    public function criar($dados) {
        $stmt = $this->conn->prepare(
            "INSERT INTO pratos 
            (nome, ingredientes, tempo_preparo, categoria, favorito, imagem, preco) 
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        
        $stmt->bind_param(
            "ssisisd",
            $dados['nome'],
            $dados['ingredientes'],
            $dados['tempo_preparo'],
            $dados['categoria'],
            $dados['favorito'],
            $dados['imagem'],
            $dados['preco']
        );
        
        return $stmt->execute();
    }
    
    public function listar() {
        $result = $this->conn->query("
            SELECT * FROM pratos 
            WHERE ativo = 1 
            ORDER BY nome ASC
        ");
        
        if (!$result) {
            throw new Exception("Erro ao listar pratos: " . $this->conn->error);
        }
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function atualizar($id, $dados) {
        $stmt = $this->conn->prepare(
            "UPDATE pratos SET 
            nome = ?, ingredientes = ?, tempo_preparo = ?, 
            categoria = ?, favorito = ?, imagem = ?, preco = ?
            WHERE id = ?"
        );
        
        $stmt->bind_param(
            "ssisisd",
            $dados['nome'],
            $dados['ingredientes'],
            $dados['tempo_preparo'],
            $dados['categoria'],
            $dados['favorito'],
            $dados['imagem'],
            $dados['preco'],
            $id
        );
        
        return $stmt->execute();
    }
    
    public function deletar($id) {
        $stmt = $this->conn->prepare(
            "UPDATE pratos SET ativo = 0 WHERE id = ?"
        );
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}