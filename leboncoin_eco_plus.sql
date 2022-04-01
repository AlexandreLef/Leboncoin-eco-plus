-- MySQL dump 10.13  Distrib 8.0.28, for macos12.2 (x86_64)
--
-- Host: 127.0.0.1    Database: leboncoin_eco_plus
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Les pires'),(2,'Voitures'),(8,'Instruments'),(9,'Humains'),(10,'Drogues');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorite`
--

DROP TABLE IF EXISTS `favorite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favorite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_68C58ED9A76ED395` (`user_id`),
  KEY `IDX_68C58ED94584665A` (`product_id`),
  CONSTRAINT `FK_68C58ED94584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_68C58ED9A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorite`
--

LOCK TABLES `favorite` WRITE;
/*!40000 ALTER TABLE `favorite` DISABLE KEYS */;
INSERT INTO `favorite` VALUES (14,5,1,'2022-03-30'),(30,6,13,'2022-04-01'),(31,6,11,'2022-04-01'),(32,9,1,'2022-04-01'),(33,9,14,'2022-04-01');
/*!40000 ALTER TABLE `favorite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `product_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307FF624B39D` (`sender_id`),
  KEY `IDX_B6BD307FCD53EDB6` (`receiver_id`),
  KEY `IDX_B6BD307F4584665A` (`product_id`),
  CONSTRAINT `FK_B6BD307F4584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_B6BD307FCD53EDB6` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_B6BD307FF624B39D` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `description` varchar(4096) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quality` int NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04AD12469DE2` (`category_id`),
  KEY `IDX_D34A04ADA76ED395` (`user_id`),
  CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `FK_D34A04ADA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,1,'Lamborghini Aventador Roadster 6.5 V12 LP700-4',28000000,'TRES URGENT: cause redressement fiscal définitif, vends Lamborghini Aventador Roadster 6.5 V12 LP700-4.\r\n\r\nMise en circulation 2022 / 1 400 kms.\r\n\r\nPrix sacrifié à seulement 280 000 euros si vente avant 31 août.\r\nPassé cette date le paiement des pénalités sera échu et je remettrai le véhicule à son véritable prix, soit 420 000\r\neuros.\r\n\r\nUn contrôle complet auprès de la concession Lamborghini de votre choix peut être effectué à mes frais.\r\n\r\nVéhicule comme neuf, était absolument parfait. Consommables neufs. Jamais de circuit. S\'est contenté d\'arpenter\r\ncalmement les rues londoniennes et monégasques en compagnie \"d\'amis\" qui seront à leur tour je l\'espère redressés...\r\n\r\nHistorique limpide, tous les papiers et carnets à jour et en ma possession.\r\n\r\nListes de l\'équipement complet er des très nombreuses et onéreuses options disponibles sur simple demande.\r\n\r\nVéhicule fantastique aux performances incroyables, même si 3 secondes d\'accélération peuvent vous conduire en prison, et\r\n 9 secondes déclencher une intervention présidentielle au 20h pour dénoncer l\'immonde crime alors commis.\r\n\r\n Vous l\'aurez compris, aucun échange possible (sauf contre projet de loi visant à interdire les contrôles fiscaux avec\r\n assurance de sa validation par l\'assemblée nationale).\r\n\r\n A l\'attention des adorateurs de bisounours et autres rêveurs idiots : véhicule extrêmement cher et puissant,\r\n inassurable (68cv fiscaux) et à l\'entretien prohibitif. Merci de nous épargner à tous du temps en évitant les messages\r\n du type \"wesh jte l\'échange contre l\'S3 de mon cousin, elle a un pot william saurin\" ou encore \"jsuis pas sur de mon\r\n coup, jviens la test avec ma meuf et jte redis si jla prends\" voir l\'inévitable \"particulièrement intéressé par votre\r\n véhicule je souhaiterais au préalable connaître sa consommation et le prix des pneumatiques\". Si vous écrivez ce\r\n message, c\'est que votre salaire ne vous permettrait même pas de remplacer les balais d\'essuie-glaces !\r\n\r\n Enfin merci aux frustrés, jaloux, stalinistes, gilet jaunes ou autres écolos mangeurs de pousses de soja de ne pas\r\n m\'importuner inutilement. Oui cette voiture émet plus de CO2 qu\'un troupeau de vache sortant d\'un banquet de cassoulet\r\n et oui son prix permettrait de nourrir un village malien pendant deux générations, voire même Carlos pendant une\r\n semaine, mais on ne l\'achète pas pour sauver les ours polaires ou aller à distribution de la soupe populaire.\r\n\r\n Vente rapide et sécurisée à un client sérieux ayant les moyens de ses ambitions.\r\n\r\n Modalités de paiement à voir avec nos conseillers financier respectifs ; virement SEPA en jours ouvrés à préférer.\r\n\r\n CONTACT UNIQUEMENT PAR TELEPHONE, je ne répondrai pas aux emails, ceux-ci parvenant pour la majorité de jeunes\r\n imbéciles ayant récemment constatés que l\'adjonction et l\'écriture et de l\'informatique pouvait leur permettre de\r\n plumer autre chose que de la volaille.',2,'Paris','2022-03-29 13:21:46',5),(11,8,'Piano',140000,'Vends piano droit Hyundai très bon état\r\nA faire accorder car non servi depuis longtemps',5,'Paris','2022-04-01 09:24:30',11),(12,9,'Construction Corps humain',1000,'Il suffit de reconstituer les organes vitaux du corps humain foie, rate, cœur ect.',2,'Drôme','2022-04-01 09:26:51',11),(13,10,'Petites pastilles de toute les couleurs',12000,'Vend de la bonne came.\r\nPrix au 100g\r\nGoût légèrement sucré, possibilité d\'en avoir acidulé (avec supp.).\r\n\r\nChoix de la couleur possible mais temps de livraison possiblement retardé !\r\n\r\nPour toute réclamation veuillez contacter les Stup ou Haribo.',5,'Grenoble','2022-04-01 09:32:58',10),(14,2,'Vega missyl',100000000,'Une base de Ford Sierra d\'origine doté d\'un moteur 1.8 litres essence de 90 chevaux :\r\n\r\n• Une puissance totale de 935 chevaux, soit un gain de 845 chevaux \r\n\r\n• Un aileron sur le toit comprenant une vingtaine d\'aérations pour une bonne circulation de l\'air \r\n\r\n• 80 kilos d\'aileron \r\n\r\n• 20 litres au 100 kilomètres \r\n\r\n• À 380 km/h, l\'accélération ne serait qu\'à moitié poussée.\r\n\r\nLien de la voiture en fonctionnement :  https://www.youtube.com/watch?v=5V2D1aXX_UM',1,'Casse','2022-04-01 09:37:30',10),(15,1,'1000tipla',100000000,'Lien de documentation visuelle : https://youtube.com/playlist?list=PL0jDgoxSZ3hU84yL6Vz3qc9tkoXvb4vk7',5,'Paris','2022-04-01 09:55:59',5);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rate`
--

DROP TABLE IF EXISTS `rate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `reviewer_id` int NOT NULL,
  `rate` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DFEC3F39A76ED395` (`user_id`),
  KEY `IDX_DFEC3F3970574616` (`reviewer_id`),
  CONSTRAINT `FK_DFEC3F3970574616` FOREIGN KEY (`reviewer_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_DFEC3F39A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rate`
--

LOCK TABLES `rate` WRITE;
/*!40000 ALTER TABLE `rate` DISABLE KEYS */;
/*!40000 ALTER TABLE `rate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `reviewer_id` int NOT NULL,
  `rate` int NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_794381C6A76ED395` (`user_id`),
  KEY `IDX_794381C670574616` (`reviewer_id`),
  CONSTRAINT `FK_794381C670574616` FOREIGN KEY (`reviewer_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_794381C6A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (2,5,6,4,'tes','2022-04-01'),(3,10,6,4,'Pastilles de bon goût vendeur expert dans son domaine, je recommande','2022-04-01');
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `search`
--

DROP TABLE IF EXISTS `search`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `search` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `search` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B4F0DBA7A76ED395` (`user_id`),
  KEY `IDX_B4F0DBA712469DE2` (`category_id`),
  CONSTRAINT `FK_B4F0DBA712469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `FK_B4F0DBA7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `search`
--

LOCK TABLES `search` WRITE;
/*!40000 ALTER TABLE `search` DISABLE KEYS */;
INSERT INTO `search` VALUES (1,5,NULL,'tgf',''),(2,5,NULL,'gfbfg',''),(3,5,NULL,'gfbfg',''),(4,5,NULL,'gfbfg','dsvdv'),(5,5,NULL,'','dsvdv'),(6,5,2,'','dsvdv'),(7,6,NULL,'lamborgini',''),(8,6,NULL,'lamborghini',''),(9,9,NULL,'veag',''),(10,9,NULL,'vega',''),(11,9,NULL,'','cass'),(12,9,NULL,'','gre'),(13,9,NULL,'','par');
/*!40000 ALTER TABLE `search` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` int DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creation` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (5,'admin','admin','admin@admin.com','$2y$13$143VCC7JvIvbSHQQSHMYreUhSu6nG1H8xaiYb6ol8kcQBgNN2IIzO','dc',896752,'Isère','ROLE_ADMIN','2022-03-29 11:52:04'),(6,'user','user','user@user.com','$2y$13$1WvUWq7JOxOF5rPrBE8vX.ks5DeNLr9NL5WB0NNalNSzQCF.slugu',NULL,NULL,NULL,'ROLE_USER','2022-03-31 07:56:12'),(9,'de La Fontaine','Jean','jean.dlf@test.com','$2y$13$kw9UpsRo7oq5pkewULUWyuWKYGCTnBE778spBK2Uxy.Ap38n02ZPG','Avenue de la Fontaine',33333,'Paris','ROLE_USER','2022-04-01 09:10:35'),(10,'La taupe','René','renelataupe@test.com','$2y$13$xRFrmvescM8cF2QPbI2Ou.zKVVjRH2vLXQAV9PhjByPoWAUNuKQKS','Un grand terrier',73000,'Savoie','ROLE_USER','2022-04-01 09:12:33'),(11,'Sardou','Michel','michel.sardou@test.com','$2y$13$GyfQqzV6a.STV.wt74FKD.4jeJ94w9ZDCmN1OP77tELZG60XLc6i.',NULL,NULL,NULL,'ROLE_USER','2022-04-01 09:16:56');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-01 13:39:41
