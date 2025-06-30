<?php
require_once __DIR__ . '/../../includes/Database.php';

class PratoModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function listarTodos()
    {
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

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM pratos WHERE id = ?";
        return $this->db->query($sql, [$id])->fetch();
    }

    public function salvar($dados)
{
    error_log("📦 Model - Recebendo dados: " . print_r($dados, true));

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

    return empty($dadosCompletos['id']) 
        ? $this->inserir($dadosCompletos) 
        : $this->atualizar($dadosCompletos);
}

private function inserir($dados)
{
    error_log("🟢 Model - Inserindo dados: " . print_r($dados, true));

    $sql = "INSERT INTO pratos 
        (nome, ingredientes, tempo_preparo, categoria, favorito, preco, imagem) 
        VALUES 
        (:nome, :ingredientes, :tempo_preparo, :categoria, :favorito, :preco, :imagem)";

    unset($dados['id']); // remover ID

    $stmt = $this->db->query($sql, $dados);

    if (!$stmt) {
        error_log("❌ Erro ao inserir no banco.");
        return false;
    }

    $linhas = $stmt->rowCount();
    error_log("✅ Inserção executada. rowCount = $linhas");

    return true;
}


    private function atualizar($dados)
    {
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

    public function excluir($id)
    {
        try {
            // Primeiro obtém informações do prato para excluir a imagem
            $prato = $this->buscarPorId($id);

            if ($prato && $prato['imagem'] != 'default.jpg') {
                $caminhoImagem = realpath(__DIR__ . '/../../uploads/' . $prato['imagem']);
                if (file_exists($caminhoImagem)) {
                    unlink($caminhoImagem);
                }
            }

            // Cria uma instância do Database e executa a query
            $database = new Database();
            $sql = "DELETE FROM pratos WHERE id = ?";
            $stmt = $database->query($sql, [$id]);

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Erro ao excluir prato: " . $e->getMessage());
            return false;
        }
    }

    public function atualizarFavorito($pratoId, $favorito)
    {
        $sql = "UPDATE pratos SET favorito = :favorito WHERE id = :id";
        $params = [
            ':favorito' => $favorito,
            ':id' => $pratoId
        ];
        return $this->db->query($sql, $params)->rowCount() > 0;
    }

    public function contarFavoritos()
    {
        $sql = "SELECT COUNT(*) as total FROM pratos WHERE favorito = 1";
        $stmt = $this->db->query($sql);
        $resultado = $stmt->fetch();
        return $resultado['total'] ?? 0;
    }
}
