const Prato = require('../models/Prato'); // Importa o model que interage com o banco de dados

// Controlador para criar um novo prato
exports.criarPrato = async (req, res) => {
  try {
    const novoPrato = await Prato.create(req.body); // Cria o prato com os dados do corpo da requisição
    res.status(201).json(novoPrato); // Retorna o prato criado com status 201 (Created)
  } catch (error) {
    res.status(400).json({ error: error.message }); // Retorna erro se algo falhar
  }
};

// Controlador para listar todos os pratos
exports.listarPratos = async (req, res) => {
  try {
    const pratos = await Prato.findAll(); // Busca todos os pratos no banco
    res.json(pratos); // Retorna os pratos como JSON
  } catch (error) {
    res.status(500).json({ error: error.message }); // Erro interno do servidor
  }
};

// Controlador para buscar um prato pelo ID
exports.buscarPrato = async (req, res) => {
  try {
    const prato = await Prato.findById(req.params.id); // Busca o prato pelo ID na URL
    if (!prato) return res.status(404).json({ error: 'Prato não encontrado' }); // Se não achar, retorna 404
    res.json(prato); // Retorna o prato encontrado
  } catch (error) {
    res.status(500).json({ error: error.message }); // Erro interno
  }
};

// Controlador para atualizar um prato existente
exports.atualizarPrato = async (req, res) => {
  try {
    const pratoAtualizado = await Prato.update(req.params.id, req.body); // Atualiza com os dados do corpo
    res.json(pratoAtualizado); // Retorna o prato atualizado
  } catch (error) {
    res.status(400).json({ error: error.message }); // Retorna erro de requisição
  }
};

// Controlador para deletar um prato
exports.deletarPrato = async (req, res) => {
  try {
    await Prato.delete(req.params.id); // Remove o prato do banco
    res.status(204).send(); // Retorna status 204 (sem conteúdo)
  } catch (error) {
    res.status(500).json({ error: error.message }); // Erro interno
  }
};

// Controlador para listar apenas os pratos favoritos
exports.listarFavoritos = async (req, res) => {
  try {
    const favoritos = await Prato.findFavoritos(); // Busca pratos onde favorito = 1
    res.json(favoritos); // Retorna os favoritos
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

// Controlador para listar pratos filtrados por categoria
exports.listarPorCategoria = async (req, res) => {
  try {
    const pratos = await Prato.findByCategoria(req.params.categoria); // Filtra por categoria passada na URL
    res.json(pratos); // Retorna os pratos encontrados
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};
