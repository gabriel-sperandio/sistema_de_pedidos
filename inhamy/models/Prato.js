const pool = require('../config/db'); // Importa a conexão com o banco de dados

// Define a classe Prato para lidar com operações relacionadas à tabela 'pratos'
class Prato {
  // Cria um novo prato no banco
  static async create({ nome, ingredientes, tempo_preparo, categoria, favorito, imagem }) {
    const [result] = await pool.execute(
      `INSERT INTO pratos 
       (nome, ingredientes, tempo_preparo, categoria, favorito, imagem) 
       VALUES (?, ?, ?, ?, ?, ?)`,
      [nome, ingredientes, tempo_preparo, categoria, favorito || 0, imagem]
    );
    return this.findById(result.insertId); // Retorna o prato recém-criado
  }

  // Retorna todos os pratos do banco
  static async findAll() {
    const [rows] = await pool.query('SELECT * FROM pratos');
    return rows;
  }

  // Busca um prato pelo seu ID
  static async findById(id) {
    const [rows] = await pool.execute('SELECT * FROM pratos WHERE id = ?', [id]);
    return rows[0];
  }

  // Atualiza um prato com base no ID e nos novos dados
  static async update(id, { nome, ingredientes, tempo_preparo, categoria, favorito, imagem }) {
    await pool.execute(
      `UPDATE pratos SET 
       nome = ?, ingredientes = ?, tempo_preparo = ?, 
       categoria = ?, favorito = ?, imagem = ?
       WHERE id = ?`,
      [nome, ingredientes, tempo_preparo, categoria, favorito, imagem, id]
    );
    return this.findById(id); // Retorna o prato atualizado
  }

  // Exclui um prato pelo ID
  static async delete(id) {
    await pool.execute('DELETE FROM pratos WHERE id = ?', [id]);
    return true;
  }

  // Retorna apenas os pratos marcados como favoritos
  static async findFavoritos() {
    const [rows] = await pool.query('SELECT * FROM pratos WHERE favorito = 1');
    return rows;
  }

  // Retorna os pratos filtrados por categoria
  static async findByCategoria(categoria) {
    const [rows] = await pool.execute('SELECT * FROM pratos WHERE categoria = ?', [categoria]);
    return rows;
  }
}

module.exports = Prato; 
