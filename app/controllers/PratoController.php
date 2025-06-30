<?php
require_once __DIR__ . '/../../includes/Database.php';
require_once __DIR__ . '/../models/PratoModel.php';

class PratoController
{
    private $model;

    public function __construct()
    {
        $this->model = new PratoModel();
    }

    public function handleRequest()
    {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'salvar':
                    $this->salvar();
                    break;
                case 'excluir':
                    $this->excluir();
                    break;
                case 'novo':
                    // Apenas mostra o formulário
                    break;
                case 'editar':
                    $prato = $this->buscarPratoPorId($_GET['id']);
                    $caminhoForm = __DIR__ . '/../views/pratos/form.php';
                    if (file_exists($caminhoForm)) {
                        include $caminhoForm;
                    } else {
                        throw new Exception("Arquivo do formulário não encontrado: " . $caminhoForm);
                    }
                    break;
            }
        }
    }


    public function listarPratos()
    {
        return $this->model->listarTodos();
    }

    public function buscarPratoPorId($id)
    {
        return $this->model->buscarPorId($id);
    }

    public function salvar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $nome = trim($_POST['nome']);
                $ingredientes = trim($_POST['ingredientes']);
                $preco = floatval($_POST['preco']);
                $tempo = intval($_POST['tempo_preparo']);
                $categoria = $_POST['categoria'];

                if ($preco < 0) throw new Exception("Preço inválido.");
                if ($tempo <= 0) throw new Exception("Tempo inválido.");
                if (!in_array($categoria, ['entrada', 'principal', 'sobremesa'])) {
                    throw new Exception("Categoria inválida.");
                }

                $imagem = $this->processarUploadImagem();

                $dados = [
                    'id' => $_POST['id'] ?? null,
                    'nome' => $nome,
                    'ingredientes' => $ingredientes,
                    'tempo_preparo' => $tempo,
                    'categoria' => $categoria,
                    'favorito' => isset($_POST['favorito']) ? 1 : 0,
                    'preco' => $preco,
                    'imagem' => $imagem ?? ($_POST['imagem_atual'] ?? 'default.jpg')
                ];

                error_log("🔧 Controller - Enviando dados para model: " . print_r($dados, true));

                if ($this->model->salvar($dados)) {
                    $_SESSION['mensagem'] = ['tipo' => 'success', 'texto' => 'Prato salvo com sucesso!'];
                } else {
                    $_SESSION['mensagem'] = ['tipo' => 'danger', 'texto' => 'Erro ao salvar prato (model retornou false).'];
                }
            } catch (Exception $e) {
                echo "<h4>Erro no salvar(): " . $e->getMessage() . "</h4>";
                echo "<pre>POST:\n" . print_r($_POST, true) . "</pre>";
                echo "<pre>FILES:\n" . print_r($_FILES, true) . "</pre>";
                exit;
            }

            header('Location: dashboard.php');
            exit;
        }
    }


    private function processarUploadImagem()
    {
        if (!empty($_FILES['imagem']['name']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $diretorio = realpath(__DIR__ . '/../../uploads/');

            if (!$diretorio || !is_dir($diretorio)) {
                throw new Exception("Diretório de uploads não encontrado.");
            }

            if (!is_writable($diretorio)) {
                throw new Exception("Diretório de uploads sem permissão de escrita.");
            }

            $nomeArquivo = uniqid() . '_' . basename($_FILES['imagem']['name']);
            $caminhoDestino = $diretorio . DIRECTORY_SEPARATOR . $nomeArquivo;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
                return $nomeArquivo;
            } else {
                throw new Exception("Erro ao mover o arquivo para: " . $caminhoDestino);
            }
        }

        return null; // nenhuma imagem enviada
    }

    public function excluir()
    {
        if (isset($_GET['id'])) {
            if ($this->model->excluir($_GET['id'])) {
                $_SESSION['mensagem'] = ['tipo' => 'success', 'texto' => 'Prato excluído com sucesso!'];
            } else {
                $_SESSION['mensagem'] = ['tipo' => 'danger', 'texto' => 'Erro ao excluir prato.'];
            }
            header('Location: dashboard.php'); // <== corrigido aqui
            exit;
        }
    }


    public function marcarFavorito($pratoId, $favorito)
    {
        if (!$this->isAdmin()) {
            throw new Exception('Apenas administradores podem gerenciar destaques');
        }

        if ($favorito && $this->model->contarFavoritos() >= 3) {
            throw new Exception('Limite de 3 destaques atingido');
        }

        if ($this->model->atualizarFavorito($pratoId, $favorito)) {
            $_SESSION['mensagem'] = ['tipo' => 'success', 'texto' => 'Destaque atualizado com sucesso!'];
        } else {
            $_SESSION['mensagem'] = ['tipo' => 'danger', 'texto' => 'Erro ao atualizar destaque.'];
        }
    }

    private function isAdmin()
    {
        return isset($_SESSION['usuario']) && $_SESSION['usuario']['is_admin'] == 1;
    }
}
