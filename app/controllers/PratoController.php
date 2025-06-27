<?php
require_once __DIR__.'/../../includes/Database.php';
require_once __DIR__.'/../models/PratoModel.php';

class PratoController {
    private $model;

    public function __construct() {
        $this->model = new PratoModel();
    }

    public function listarPratos() {
        return $this->model->listarTodos();
    }

    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'id' => $_POST['id'] ?? null,
                'nome' => $_POST['nome'],
                'ingredientes' => $_POST['ingredientes'],
                'tempo_preparo' => $_POST['tempo_preparo'] ?? null,
                'categoria' => $_POST['categoria'] ?? null,
                'favorito' => $_POST['favorito'] ?? 0,
                'preco' => $_POST['preco'],
                'imagem' => $_FILES['imagem']['name'] ?? 'default.jpg'
            ];

            if ($this->model->salvar($dados)) {
                header('Location: /?sucesso=Prato+salvo+com+sucesso');
            } else {
                header('Location: /?erro=Erro+ao+salvar+prato');
            }
            exit;
        }
    }

    public function excluir() {
        if (isset($_GET['id'])) {
            $this->model->excluir($_GET['id']);
            header('Location: /?sucesso=Prato+excluído+com+sucesso');
            exit;
        }
    }
}