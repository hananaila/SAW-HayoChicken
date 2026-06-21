-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: spk_hayo_chicken
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `alternatif`
--

DROP TABLE IF EXISTS `alternatif`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alternatif` (
  `id_alternatif` varchar(2) NOT NULL,
  `nama_paket` varchar(100) DEFAULT NULL,
  `harga_paket` int DEFAULT NULL,
  PRIMARY KEY (`id_alternatif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alternatif`
--

LOCK TABLES `alternatif` WRITE;
/*!40000 ALTER TABLE `alternatif` DISABLE KEYS */;
INSERT INTO `alternatif` VALUES ('A1','Ayam Geprek + Nasi + Es Teh',16000),('A2','Chicken Katsu + Nasi + Es Teh',19000),('A3','Chicken Saus + Nasi + Es Teh',16000),('A4','Crispy Chicken Steak + Nasi + Es Teh',19000),('A5','Ayam Lalapan 1/4 + Nasi + Es Teh',19000);
/*!40000 ALTER TABLE `alternatif` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kriteria`
--

DROP TABLE IF EXISTS `kriteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kriteria` (
  `id_kriteria` varchar(2) NOT NULL,
  `nama_kriteria` varchar(50) DEFAULT NULL,
  `sifat` enum('Benefit','Cost') DEFAULT NULL,
  `bobot` float DEFAULT NULL,
  PRIMARY KEY (`id_kriteria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kriteria`
--

LOCK TABLES `kriteria` WRITE;
/*!40000 ALTER TABLE `kriteria` DISABLE KEYS */;
INSERT INTO `kriteria` VALUES ('C1','Margin Keuntungan','Benefit',0.25),('C2','Popularitas/Frekuensi','Benefit',0.2),('C3','Kepuasan Pelanggan','Benefit',0.25),('C4','Penggunaan Stok Bahan','Benefit',0.15),('C5','Harga Jual','Cost',0.15);
/*!40000 ALTER TABLE `kriteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kuesioner_pembeli`
--

DROP TABLE IF EXISTS `kuesioner_pembeli`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kuesioner_pembeli` (
  `id_kuesioner` int NOT NULL AUTO_INCREMENT,
  `nama_pembeli` varchar(50) DEFAULT NULL,
  `id_alternatif` varchar(2) DEFAULT NULL,
  `c2_menarik` int DEFAULT NULL,
  `c3_worth_it` int DEFAULT NULL,
  PRIMARY KEY (`id_kuesioner`),
  KEY `id_alternatif` (`id_alternatif`),
  CONSTRAINT `kuesioner_pembeli_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kuesioner_pembeli`
--

LOCK TABLES `kuesioner_pembeli` WRITE;
/*!40000 ALTER TABLE `kuesioner_pembeli` DISABLE KEYS */;
INSERT INTO `kuesioner_pembeli` VALUES (1,'naila','A1',2,4),(2,'naila','A2',5,5),(3,'naila','A3',3,3),(4,'naila','A4',5,5),(5,'naila','A5',4,5),(6,'nayli','A1',4,4),(7,'nayli','A2',4,3),(8,'nayli','A3',4,3),(9,'nayli','A4',3,3),(10,'nayli','A5',2,2),(11,'faizia','A1',5,4),(12,'faizia','A2',5,3),(13,'faizia','A3',3,4),(14,'faizia','A4',4,5),(15,'faizia','A5',2,1),(16,'Tita','A1',5,5),(17,'Tita','A2',5,5),(18,'Tita','A3',5,5),(19,'Tita','A4',5,5),(20,'Tita','A5',5,5),(21,'Aulia','A1',5,5),(22,'Aulia','A2',5,5),(23,'Aulia','A3',5,5),(24,'Aulia','A4',5,5),(25,'Aulia','A5',5,5),(26,'yunan','A1',4,4),(27,'yunan','A2',3,4),(28,'yunan','A3',4,4),(29,'yunan','A4',3,4),(30,'yunan','A5',4,3),(31,'Hardy','A1',1,1),(32,'Hardy','A2',5,5),(33,'Hardy','A3',1,1),(34,'Hardy','A4',5,5),(35,'Hardy','A5',1,1),(36,'Salma','A1',3,2),(37,'Salma','A2',4,4),(38,'Salma','A3',4,4),(39,'Salma','A4',5,4),(40,'Salma','A5',3,3),(41,'Ajeng','A1',4,4),(42,'Ajeng','A2',5,4),(43,'Ajeng','A3',3,3),(44,'Ajeng','A4',4,4),(45,'Ajeng','A5',3,3),(46,'Dera','A1',4,4),(47,'Dera','A2',4,4),(48,'Dera','A3',4,4),(49,'Dera','A4',4,4),(50,'Dera','A5',4,4),(51,'Amelia','A1',4,4),(52,'Amelia','A2',4,3),(53,'Amelia','A3',4,3),(54,'Amelia','A4',4,4),(55,'Amelia','A5',4,4),(56,'napi','A1',5,5),(57,'napi','A2',3,3),(58,'napi','A3',5,5),(59,'napi','A4',3,3),(60,'napi','A5',3,3),(61,'Zahra','A1',4,4),(62,'Zahra','A2',3,4),(63,'Zahra','A3',1,3),(64,'Zahra','A4',5,5),(65,'Zahra','A5',2,3),(66,'Alifah','A1',2,4),(67,'Alifah','A2',5,4),(68,'Alifah','A3',5,5),(69,'Alifah','A4',3,1),(70,'Alifah','A5',3,4),(71,'Danial','A1',1,2),(72,'Danial','A2',2,3),(73,'Danial','A3',2,3),(74,'Danial','A4',1,4),(75,'Danial','A5',2,5),(76,'Nadzare','A1',5,5),(77,'Nadzare','A2',4,5),(78,'Nadzare','A3',4,5),(79,'Nadzare','A4',4,5),(80,'Nadzare','A5',4,5),(81,'Rizki','A1',5,5),(82,'Rizki','A2',3,4),(83,'Rizki','A3',2,4),(84,'Rizki','A4',5,4),(85,'Rizki','A5',3,4),(86,'Dinda','A1',2,3),(87,'Dinda','A2',4,3),(88,'Dinda','A3',1,5),(89,'Dinda','A4',2,5),(90,'Dinda','A5',3,5),(91,'Intan A','A1',1,3),(92,'Intan A','A2',5,2),(93,'Intan A','A3',5,3),(94,'Intan A','A4',5,5),(95,'Intan A','A5',4,5),(96,'sky','A1',5,4),(97,'sky','A2',3,3),(98,'sky','A3',3,3),(99,'sky','A4',2,3),(100,'sky','A5',3,3),(101,'Caca','A1',1,5),(102,'Caca','A2',3,5),(103,'Caca','A3',1,5),(104,'Caca','A4',5,3),(105,'Caca','A5',5,5),(106,'Huri','A1',4,5),(107,'Huri','A2',1,3),(108,'Huri','A3',2,3),(109,'Huri','A4',5,5),(110,'Huri','A5',4,4),(111,'Lula','A1',3,4),(112,'Lula','A2',5,5),(113,'Lula','A3',1,5),(114,'Lula','A4',5,4),(115,'Lula','A5',4,5),(116,'Aurel','A1',5,5),(117,'Aurel','A2',3,5),(118,'Aurel','A3',5,5),(119,'Aurel','A4',1,3),(120,'Aurel','A5',5,5),(121,'Novia','A1',5,5),(122,'Novia','A2',5,5),(123,'Novia','A3',5,5),(124,'Novia','A4',5,5),(125,'Novia','A5',5,5),(126,'Ganda','A1',5,4),(127,'Ganda','A2',5,4),(128,'Ganda','A3',5,5),(129,'Ganda','A4',1,3),(130,'Ganda','A5',2,3),(131,'Gita','A1',5,3),(132,'Gita','A2',5,4),(133,'Gita','A3',5,3),(134,'Gita','A4',5,2),(135,'Gita','A5',5,3),(136,'Melody','A1',1,3),(137,'Melody','A2',4,5),(138,'Melody','A3',5,5),(139,'Melody','A4',4,5),(140,'Melody','A5',3,5),(141,'Wisnu','A1',3,5),(142,'Wisnu','A2',5,5),(143,'Wisnu','A3',4,5),(144,'Wisnu','A4',5,5),(145,'Wisnu','A5',5,5),(146,'adit','A1',4,4),(147,'adit','A2',4,4),(148,'adit','A3',4,4),(149,'adit','A4',4,4),(150,'adit','A5',4,4),(151,'Alip','A1',4,4),(152,'Alip','A2',4,4),(153,'Alip','A3',5,5),(154,'Alip','A4',5,5),(155,'Alip','A5',4,4),(156,'Intan','A1',5,5),(157,'Intan','A2',4,4),(158,'Intan','A3',5,4),(159,'Intan','A4',4,5),(160,'Intan','A5',5,5),(161,'saryy','A1',3,2),(162,'saryy','A2',3,2),(163,'saryy','A3',3,2),(164,'saryy','A4',3,2),(165,'saryy','A5',4,3),(166,'Najma','A4',4,4),(167,'Najma','A3',4,4);
/*!40000 ALTER TABLE `kuesioner_pembeli` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kuesioner_penjual`
--

DROP TABLE IF EXISTS `kuesioner_penjual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kuesioner_penjual` (
  `id_kuesioner` int NOT NULL AUTO_INCREMENT,
  `nama_internal` varchar(50) DEFAULT NULL,
  `id_alternatif` varchar(2) DEFAULT NULL,
  `c1_untung` int DEFAULT NULL,
  `c2_sering` int DEFAULT NULL,
  `c4_habis` int DEFAULT NULL,
  PRIMARY KEY (`id_kuesioner`),
  KEY `id_alternatif` (`id_alternatif`),
  CONSTRAINT `kuesioner_penjual_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kuesioner_penjual`
--

LOCK TABLES `kuesioner_penjual` WRITE;
/*!40000 ALTER TABLE `kuesioner_penjual` DISABLE KEYS */;
INSERT INTO `kuesioner_penjual` VALUES (1,'rahma','A1',4,3,3),(2,'rahma','A2',3,5,4),(3,'rahma','A3',4,3,3),(4,'rahma','A4',3,3,2),(5,'rahma','A5',4,4,5),(6,'Okti Salminah','A1',5,5,5),(7,'Okti Salminah','A2',3,4,3),(8,'Okti Salminah','A3',3,3,3),(9,'Okti Salminah','A4',3,3,3),(10,'Okti Salminah','A5',2,2,2),(11,'lina','A1',4,4,5),(12,'lina','A2',4,5,5),(13,'lina','A3',4,4,3),(14,'lina','A4',4,4,4),(15,'lina','A5',4,3,4);
/*!40000 ALTER TABLE `kuesioner_penjual` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-10 16:08:29
