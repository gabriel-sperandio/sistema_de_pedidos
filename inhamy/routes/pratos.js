const express = require('express');
const router = express.Router();
const PratoController = require('../controllers/PratoController');

// CRUD 
router.post('/pratos', PratoController.criarPrato);
router.get('/pratos', PratoController.listarPratos);
router.get('/pratos/:id', PratoController.buscarPrato);
router.put('/pratos/:id', PratoController.atualizarPrato);
router.delete('/pratos/:id', PratoController.deletarPrato);

// Rotas adicionais
router.get('/pratos/favoritos', PratoController.listarFavoritos);
router.get('/pratos/categoria/:categoria', PratoController.listarPorCategoria);

module.exports = router;