-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: inhamy
-- ------------------------------------------------------
-- Server version	8.0.42
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!50503 SET NAMES utf8 */
;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */
;
/*!40103 SET TIME_ZONE='+00:00' */
;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */
;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */
;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */
;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */
;
--
-- Table structure for table `pratos`
--
DROP TABLE IF EXISTS `pratos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */
;
/*!50503 SET character_set_client = utf8mb4 */
;
CREATE TABLE `pratos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `ingredientes` text NOT NULL,
  `tempo_preparo` int DEFAULT NULL COMMENT 'em minutos',
  `categoria` varchar(50) DEFAULT NULL,
  `favorito` tinyint(1) DEFAULT '0' COMMENT '1=sim, 0=não',
  `preco` decimal(10, 2) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL COMMENT 'caminho da imagem',
  `ativo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */
;
--
-- Dumping data for table `pratos`
--
LOCK TABLES `pratos` WRITE;
/*!40000 ALTER TABLE `pratos` DISABLE KEYS */
;
INSERT INTO `pratos`
VALUES (
    1,
    'bolinho ',
    'farinha, ovo, chocolate, leite\r\n',
    60,
    'sobremesa',
    NULL,
    10.00,
    NULL,
    1
  );
(
    2,
    'salada tropical',
    'alface, manga, castanha de caju, molho de limão',
    45,
    'vegano',
    'salada.png',
    15.00,
    NULL,
    1
  ),
  (
    3,
    'lasanha de berinjela',
    'berinjela, molho de tomate, tofu',
    90,
    'lactovegetariano',
    'lasanha.png',
    25.00,
    NULL,
    1
  ),
  (
    4,
    'mousse de maracujá',
    'maracujá, leite condensado vegano, creme vegetal',
    60,
    'sobremesa',
    'mousse.png',
    12.00,
    NULL,
    1
  );
  (
    5,
    'berinjela grelhada',
    'berinjela, chimichurri, azeite',
    60,
    'vegetariano',
    'berinjela.png',
    12.00,
    NULL,
    1
  );
  (
    6,
    'strogonoff de cogumelos',
    'cogumelos, arroz branco, creme vegetal, batata palha',
    60,
    'ovolactovegetariano',
    'strogonoff.png',
    12.00,
    NULL,
    1
  );
  (
    7,
    'salada mediterrânea',
    'tomatinhos-cereja, cubos de pão rústico, alface, rucula',
    60,
    'vegano',
    'salada.fit.png',
    12.00,
    NULL,
    1
  );
  

/*!40000 ALTER TABLE `pratos` ENABLE KEYS */
;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */
;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */
;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */
;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */
;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */
;
-- Dump completed on 2025-06-28 13:31:11