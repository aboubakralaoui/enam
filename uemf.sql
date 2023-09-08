-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: uemf
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.16.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `application`
--

DROP TABLE IF EXISTS `application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `mail_confirmation` tinyint(1) DEFAULT NULL,
  `payment_receipt_uploaded` tinyint(1) DEFAULT NULL,
  `documents_uploaded` tinyint(1) DEFAULT NULL,
  `mail_relance` tinyint(1) DEFAULT NULL,
  `school_id` int(11) NOT NULL,
  `trainingType_id` int(11) NOT NULL,
  `diplomaType_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A45BDDC1A76ED395` (`user_id`),
  KEY `IDX_A45BDDC1591CC992` (`course_id`),
  KEY `IDX_A45BDDC1C32A47EE` (`school_id`),
  KEY `IDX_A45BDDC1C02E95E3` (`trainingType_id`),
  KEY `IDX_A45BDDC1B534DF12` (`diplomaType_id`),
  CONSTRAINT `FK_A45BDDC1591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  CONSTRAINT `FK_A45BDDC1A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_A45BDDC1B534DF12` FOREIGN KEY (`diplomaType_id`) REFERENCES `diploma_type` (`id`),
  CONSTRAINT `FK_A45BDDC1C02E95E3` FOREIGN KEY (`trainingType_id`) REFERENCES `training_type` (`id`),
  CONSTRAINT `FK_A45BDDC1C32A47EE` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application`
--

LOCK TABLES `application` WRITE;
/*!40000 ALTER TABLE `application` DISABLE KEYS */;
INSERT INTO `application` VALUES (78,71,2,NULL,'2019-04-09 10:57:10',NULL,1,1,0,NULL,1,6,2);
/*!40000 ALTER TABLE `application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `application_diploma`
--

DROP TABLE IF EXISTS `application_diploma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `application_diploma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` int(11) NOT NULL,
  `diploma_id` int(11) NOT NULL,
  `ord` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_79F8C643E030ACD` (`application_id`),
  KEY `IDX_79F8C64A99ACEB5` (`diploma_id`),
  CONSTRAINT `FK_79F8C643E030ACD` FOREIGN KEY (`application_id`) REFERENCES `application` (`id`),
  CONSTRAINT `FK_79F8C64A99ACEB5` FOREIGN KEY (`diploma_id`) REFERENCES `diploma` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application_diploma`
--

LOCK TABLES `application_diploma` WRITE;
/*!40000 ALTER TABLE `application_diploma` DISABLE KEYS */;
INSERT INTO `application_diploma` VALUES (144,78,5,1),(145,78,6,2),(146,78,11,3),(147,78,7,4);
/*!40000 ALTER TABLE `application_diploma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autorisations`
--

DROP TABLE IF EXISTS `autorisations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autorisations` (
  `role_id` int(11) NOT NULL,
  `fonctionnalite_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`fonctionnalite_id`),
  KEY `IDX_3AB39F8FD60322AC` (`role_id`),
  KEY `IDX_3AB39F8F4477C5D8` (`fonctionnalite_id`),
  CONSTRAINT `FK_3AB39F8F4477C5D8` FOREIGN KEY (`fonctionnalite_id`) REFERENCES `fonctionnalites` (`id`),
  CONSTRAINT `FK_3AB39F8FD60322AC` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autorisations`
--

LOCK TABLES `autorisations` WRITE;
/*!40000 ALTER TABLE `autorisations` DISABLE KEYS */;
INSERT INTO `autorisations` VALUES (3,2),(3,3);
/*!40000 ALTER TABLE `autorisations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `conditions` longtext COLLATE utf8_unicode_ci NOT NULL,
  `school_year` int(11) NOT NULL,
  `application_deadline` datetime DEFAULT NULL,
  `files_deadline` datetime DEFAULT NULL,
  `payment_receipt_deadline` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES (1,'Licence professionnelle','La Licence Professionnelle de l’ESITH est accessible aux bacheliers scientifiques.',2019,'2019-06-26 00:00:00','2019-07-01 00:00:00','2019-06-26 00:00:00'),(2,'Master spécialisé','Le &nbsp;Master Spécialisé de l’ESITH est accessible aux titulaires d’une Licence Professionnelle ou équivalent.',2019,'2019-06-28 00:00:00',NULL,'2019-07-04 00:00:00'),(3,'Cycle d\'ingénieur de l\'ESITH','Le Cycle Ingénieur est accessible pour les titulaires du DEUG, DEUP, DEUST, BTS, DUT ou DTS et de la Licence Professionnelle. Les candidats doivent remplir les conditions ci-après, Obtention en 2 années du :<br>&nbsp; &nbsp; &nbsp; -&nbsp; DEUG dans les spécialités suivantes : Mathématiques-Physique / Physique-Chimie.<br>&nbsp; &nbsp; &nbsp; -&nbsp; DEUP ou DEUST dans les spécialités suivantes : Génie chimique, électrique et mécanique.<br>&nbsp; &nbsp; &nbsp; -&nbsp; DUT dans les spécialités suivantes : Génie électrique, mécanique, procédés et Maintenance industrielle.<br>&nbsp; &nbsp; &nbsp; -&nbsp; BTS dans les spécialités suivantes : Génie électrique et mécanique.<br>&nbsp; &nbsp; &nbsp; -&nbsp; DTS dans les spécialités suivantes : Génie électrique, mécanique et climatique, Textiles, Chimie-parachimie.<br>&nbsp; &nbsp; &nbsp; -&nbsp; Age maximal : 24 ans à la date du concours.<br>',2019,'2019-06-28 00:00:00','2019-12-12 00:00:00','2019-06-28 00:00:00');
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_diploma`
--

DROP TABLE IF EXISTS `course_diploma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_diploma` (
  `course_id` int(11) NOT NULL,
  `diploma_id` int(11) NOT NULL,
  PRIMARY KEY (`course_id`,`diploma_id`),
  KEY `IDX_E4E28CBB591CC992` (`course_id`),
  KEY `IDX_E4E28CBBA99ACEB5` (`diploma_id`),
  CONSTRAINT `FK_E4E28CBB591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  CONSTRAINT `FK_E4E28CBBA99ACEB5` FOREIGN KEY (`diploma_id`) REFERENCES `diploma` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_diploma`
--

LOCK TABLES `course_diploma` WRITE;
/*!40000 ALTER TABLE `course_diploma` DISABLE KEYS */;
INSERT INTO `course_diploma` VALUES (1,1),(1,2),(1,3),(1,4),(1,8),(2,5),(2,6),(2,7),(2,11),(3,9),(3,10);
/*!40000 ALTER TABLE `course_diploma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_document_type`
--

DROP TABLE IF EXISTS `course_document_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `course_document_type` (
  `course_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  PRIMARY KEY (`course_id`,`document_type_id`),
  KEY `IDX_E8E79F63591CC992` (`course_id`),
  KEY `IDX_E8E79F6361232A4F` (`document_type_id`),
  CONSTRAINT `FK_E8E79F63591CC992` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`),
  CONSTRAINT `FK_E8E79F6361232A4F` FOREIGN KEY (`document_type_id`) REFERENCES `document_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course_document_type`
--

LOCK TABLES `course_document_type` WRITE;
/*!40000 ALTER TABLE `course_document_type` DISABLE KEYS */;
INSERT INTO `course_document_type` VALUES (1,1),(1,5),(1,6),(1,7),(2,1),(2,2),(2,3),(2,4),(2,5),(2,9),(2,11),(3,1),(3,5),(3,9),(3,10),(3,12);
/*!40000 ALTER TABLE `course_document_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diploma`
--

DROP TABLE IF EXISTS `diploma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diploma` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `school_field_id` int(11) NOT NULL,
  `diploma_type_id` int(11) NOT NULL,
  `training_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_EC218957C32A47EE` (`school_id`),
  KEY `IDX_EC218957BA7133F4` (`school_field_id`),
  KEY `IDX_EC218957D2BDC45D` (`diploma_type_id`),
  KEY `IDX_EC21895718721C9D` (`training_type_id`),
  CONSTRAINT `FK_EC21895718721C9D` FOREIGN KEY (`training_type_id`) REFERENCES `training_type` (`id`),
  CONSTRAINT `FK_EC218957BA7133F4` FOREIGN KEY (`school_field_id`) REFERENCES `school_field` (`id`),
  CONSTRAINT `FK_EC218957C32A47EE` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`),
  CONSTRAINT `FK_EC218957D2BDC45D` FOREIGN KEY (`diploma_type_id`) REFERENCES `diploma_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diploma`
--

LOCK TABLES `diploma` WRITE;
/*!40000 ALTER TABLE `diploma` DISABLE KEYS */;
INSERT INTO `diploma` VALUES (1,1,1,1,6),(2,1,2,1,6),(3,1,3,1,6),(4,1,4,1,6),(5,1,9,2,6),(6,1,8,2,6),(7,1,6,2,6),(8,1,5,1,6),(9,1,10,4,6),(10,1,11,4,6),(11,1,7,2,6);
/*!40000 ALTER TABLE `diploma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `diploma_type`
--

DROP TABLE IF EXISTS `diploma_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diploma_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `order_row` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_DD5D6F5E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diploma_type`
--

LOCK TABLES `diploma_type` WRITE;
/*!40000 ALTER TABLE `diploma_type` DISABLE KEYS */;
INSERT INTO `diploma_type` VALUES (1,'Licence Professionnelle','<b>Curabitur</b> non nulla sit amet nisl tempus convallis quis ac lectus. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Nulla quis lorem ut libero malesuada feugiat. Donec sollicitudin molestie malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque in ipsum id orci porta dapibus. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.',1),(2,'Master Spécialisé','Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Nulla quis lorem ut libero malesuada feugiat. Donec sollicitudin molestie malesuada. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque in ipsum id orci porta dapibus. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.',2),(4,'Ingénieur','Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Nulla porttitor accumsan tincidunt. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Nulla porttitor accumsan tincidunt. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Pellentesque in ipsum id orci porta dapibus. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.',3);
/*!40000 ALTER TABLE `diploma_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document`
--

DROP TABLE IF EXISTS `document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `application_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extension` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D8698A76A76ED395` (`user_id`),
  KEY `IDX_D8698A7661232A4F` (`document_type_id`),
  KEY `IDX_D8698A763E030ACD` (`application_id`),
  CONSTRAINT `FK_D8698A763E030ACD` FOREIGN KEY (`application_id`) REFERENCES `application` (`id`),
  CONSTRAINT `FK_D8698A7661232A4F` FOREIGN KEY (`document_type_id`) REFERENCES `document_type` (`id`),
  CONSTRAINT `FK_D8698A76A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=286 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document`
--

LOCK TABLES `document` WRITE;
/*!40000 ALTER TABLE `document` DISABLE KEYS */;
INSERT INTO `document` VALUES (285,71,8,78,'payment_receipt_09-04-2019_1554800301_5cac5ead19dfb_8470.png','png',NULL);
/*!40000 ALTER TABLE `document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_type`
--

DROP TABLE IF EXISTS `document_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `multiple` tinyint(1) DEFAULT NULL,
  `order_row` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2B6ADBBA5E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_type`
--

LOCK TABLES `document_type` WRITE;
/*!40000 ALTER TABLE `document_type` DISABLE KEYS */;
INSERT INTO `document_type` VALUES (1,'CIN (Carte d\'identité nationale)','cin',1,13),(2,'Curriculum Vitae','curriculum_vitae',0,12),(3,'Relevé de notes des 3 années du cycle Licence','releve_notes_annees_cycle_Licence',1,NULL),(4,'Photocopie de l\'attestation du diplôme de la Licence d\'État ou équivalent','photocopie_attestation_diplome_licence_etat_equivalent',1,NULL),(5,'photo récente','recent_picture',0,NULL),(6,'Relevé de notes des trois années de l\'enseignement secondaire','releve_notes_trois_annee_enseignement_secondaire',1,NULL),(7,'Certificat de scolarité de la 2ème  année du baccalauréat','certificat_scolarite_2eme_annee_baccalauréat',0,NULL),(8,'Reçu de paiement','payment_receipt',0,NULL),(9,'Photocopie légalisée du Baccalauréat','photocopie_legalisee_Baccalaureat',0,NULL),(10,'Attestation de réussite en 1ère  et 2ème  année','attestation_reussite_1ere_2eme_annee',1,NULL),(11,'Lettre de Motivation','mettre_motivation',0,NULL),(12,'Relevé de notes du 1er  cycle universitaire','releve_notes_1er_cycle_universitaire',1,NULL);
/*!40000 ALTER TABLE `document_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fonctionnalites`
--

DROP TABLE IF EXISTS `fonctionnalites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fonctionnalites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6386856277153098` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fonctionnalites`
--

LOCK TABLES `fonctionnalites` WRITE;
/*!40000 ALTER TABLE `fonctionnalites` DISABLE KEYS */;
INSERT INTO `fonctionnalites` VALUES (2,'create user','Ajouter utilisateur'),(3,'update user','update user');
/*!40000 ALTER TABLE `fonctionnalites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nationality`
--

DROP TABLE IF EXISTS `nationality`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nationality` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8AC58B705E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=252 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nationality`
--

LOCK TABLES `nationality` WRITE;
/*!40000 ALTER TABLE `nationality` DISABLE KEYS */;
INSERT INTO `nationality` VALUES (62,'Afghane'),(63,'Albanaise'),(64,'Algerienne'),(65,'Allemande'),(66,'Americaine'),(67,'Andorrane'),(68,'Angolaise'),(69,'Antiguaise et barbudienne'),(70,'Argentine'),(71,'Armenienne'),(72,'Australienne'),(73,'Autrichienne'),(74,'AzerbaÃ¯djanaise'),(2,'BÃ©ninoise'),(75,'Bahamienne'),(76,'Bahreinienne'),(77,'Bangladaise'),(78,'Barbadienne'),(79,'Belge'),(80,'Belizienne'),(81,'Bhoutanaise'),(82,'Bielorusse'),(83,'Birmane'),(84,'Bissau-GuinÃ©enne'),(85,'Bolivienne'),(86,'Bosnienne'),(87,'Botswanaise'),(88,'Bresilienne'),(89,'Britannique'),(90,'Bruneienne'),(91,'Bulgare'),(3,'Burkinabaise'),(92,'Burkinabe'),(93,'Burundaise'),(94,'Cambodgienne'),(95,'Camerounaise'),(96,'Canadienne'),(97,'Cap-verdienne'),(98,'Centrafricaine'),(99,'Chilienne'),(100,'Chinoise'),(101,'Chypriote'),(102,'Colombienne'),(103,'Comorienne'),(104,'Congolaise'),(105,'Costaricaine'),(106,'Croate'),(107,'Cubaine'),(108,'Danoise'),(109,'Djiboutienne'),(110,'Dominicaine'),(111,'Dominiquaise'),(112,'Egyptienne'),(113,'Emirienne'),(114,'Equato-guineenne'),(115,'Equatorienne'),(116,'Erythreenne'),(117,'Espagnole'),(118,'Est-timoraise'),(119,'Estonienne'),(120,'Ethiopienne'),(121,'Fidjienne'),(122,'Finlandaise'),(123,'FranÃ§aise'),(5,'Gabonaise'),(124,'Gambienne'),(125,'Georgienne'),(126,'Ghaneenne'),(127,'Grenadienne'),(128,'Guatemalteque'),(129,'Guineenne'),(130,'Guyanienne'),(131,'HaÃ¯tienne'),(132,'Hellenique'),(133,'Hondurienne'),(134,'Hongroise'),(135,'Indienne'),(136,'Indonesienne'),(137,'Irakienne'),(138,'Irlandaise'),(139,'Islandaise'),(140,'IsraÃ©lienne'),(141,'Italienne'),(142,'Ivoirienne'),(143,'JamaÃ¯caine'),(144,'Japonaise'),(145,'Jordanienne'),(146,'Kazakhstanaise'),(147,'Kenyane'),(148,'Kirghize'),(149,'Kiribatienne'),(150,'Kittitienne-et-nevicienne'),(151,'Kossovienne'),(152,'Koweitienne'),(153,'Laotienne'),(154,'Lesothane'),(155,'Lettone'),(156,'Libanaise'),(157,'Liberienne'),(158,'Libyenne'),(159,'Liechtensteinoise'),(160,'Lituanienne'),(161,'Luxembourgeoise'),(162,'Macedonienne'),(163,'Malaisienne'),(164,'Malawienne'),(165,'Maldivienne'),(166,'Malgache'),(7,'Malienne'),(167,'Maltaise'),(1,'Marocaine'),(168,'Marshallaise'),(169,'Mauricienne'),(170,'Mauritanienne'),(171,'Mexicaine'),(172,'Micronesienne'),(173,'Moldave'),(174,'Monegasque'),(175,'Mongole'),(176,'Montenegrine'),(177,'Mozambicaine'),(178,'Namibienne'),(179,'Nauruane'),(180,'Neerlandaise'),(181,'Neo-zelandaise'),(182,'Nepalaise'),(183,'Nicaraguayenne'),(184,'Nigeriane'),(185,'Nigerienne'),(186,'Nord-corÃ©enne'),(187,'Norvegienne'),(188,'Omanaise'),(189,'Ougandaise'),(190,'Ouzbeke'),(191,'Pakistanaise'),(192,'Palau'),(193,'Palestinienne'),(194,'Panameenne'),(195,'Papouane-neoguineenne'),(196,'Paraguayenne'),(197,'Peruvienne'),(198,'Philippine'),(199,'Polonaise'),(200,'Portoricaine'),(201,'Portugaise'),(202,'Qatarienne'),(203,'Roumaine'),(204,'Russe'),(205,'Rwandaise'),(206,'Saint-lucienne'),(207,'Saint-marinaise'),(208,'Saint-vincentaise-et-grenadine'),(209,'Salomonaise'),(210,'Salvadorienne'),(211,'Samoane'),(212,'Santomeenne'),(213,'Saoudienne'),(214,'Senegalaise'),(215,'Serbe'),(216,'Seychelloise'),(217,'Sierra-leonaise'),(218,'Singapourienne'),(219,'Slovaque'),(220,'Slovene'),(221,'Somalienne'),(222,'Soudanaise'),(223,'Sri-lankaise'),(224,'Sud-africaine'),(225,'Sud-corÃ©enne'),(226,'Suedoise'),(227,'Suisse'),(228,'Surinamaise'),(229,'Swazie'),(230,'Syrienne'),(231,'Tadjike'),(232,'Taiwanaise'),(233,'Tanzanienne'),(234,'Tchadienne'),(235,'Tcheque'),(236,'ThaÃ¯landaise'),(237,'Togolaise'),(238,'Tonguienne'),(239,'Trinidadienne'),(240,'Tunisienne'),(241,'Turkmene'),(242,'Turque'),(243,'Tuvaluane'),(244,'Ukrainienne'),(245,'Uruguayenne'),(246,'Vanuatuane'),(247,'Venezuelienne'),(248,'Vietnamienne'),(249,'Yemenite'),(250,'Zambienne'),(251,'Zimbabweenne');
/*!40000 ALTER TABLE `nationality` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B63E2EC7A4D60759` (`libelle`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (3,'reerre');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school`
--

DROP TABLE IF EXISTS `school`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phoneNumber` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `code` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F99EDABB5E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school`
--

LOCK TABLES `school` WRITE;
/*!40000 ALTER TABLE `school` DISABLE KEYS */;
INSERT INTO `school` VALUES (1,'Esith','Route d\'Eljadida, km 8, BP 7731 - Oulfa, Casa','(212) 522 23 41 24','2017-03-28 11:22:01','2019-03-03 12:46:35','Esith');
/*!40000 ALTER TABLE `school` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_field`
--

DROP TABLE IF EXISTS `school_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_accreditation` datetime NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_850FF3425E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_field`
--

LOCK TABLES `school_field` WRITE;
/*!40000 ALTER TABLE `school_field` DISABLE KEYS */;
INSERT INTO `school_field` VALUES (1,'Développement en Habillement','2067-04-07 00:00:00','<b>Praesent</b> sapien massa, convallis a pellentesque nec, egestas non nisi. Vivamus suscipit tortor eget felis porttitor volutpat. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Pellentesque in ipsum id orci porta dapibus. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Nulla porttitor accumsan tincidunt. Curabitur aliquet quam id dui posuere blandit. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Proin eget tortor risus. Quisque velit nisi, <b><u>pretium</u></b> ut lacinia in, elementum id enim.'),(2,'Gestion de la Production en Habillement','2012-01-01 00:00:00','Sed porttitor lectus nibh. Cras ultricies ligula sed magna dictum porta. Vivamus suscipit tortor eget felis porttitor volutpat. Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus. Proin eget tortor risus. Nulla porttitor accumsan tincidunt. Nulla porttitor accumsan tincidunt. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Quisque velit nisi, pretium ut lacinia in, elementum id enim.'),(3,'Gestion de la Production en Textile','2012-01-01 00:00:00','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sollicitudin molestie malesuada. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Donec rutrum congue leo eget malesuada. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur aliquet quam id dui posuere blandit. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Sed porttitor lectus nibh. Vivamus suscipit tortor eget felis porttitor volutpat. Proin eget tortor risus.'),(4,'Gestion de la Chaine Logistique','2012-01-01 00:00:00','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Curabitur aliquet quam id dui posuere blandit. Nulla porttitor accumsan tincidunt. Nulla quis lorem ut libero malesuada feugiat. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin eget tortor risus. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.'),(5,'Gestion des Achats & Sourcing','2012-01-01 00:00:00','Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Donec rutrum congue leo eget malesuada. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Nulla quis lorem ut libero malesuada feugiat. Nulla porttitor accumsan tincidunt. Curabitur aliquet quam id dui posuere blandit. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Vivamus suscipit tortor eget felis porttitor volutpat.'),(6,'E-Logistique','2012-01-01 00:00:00','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque in ipsum id orci porta dapibus. Sed porttitor lectus nibh. Nulla porttitor accumsan tincidunt. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Pellentesque in ipsum id orci porta dapibus. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus.'),(7,'Hygiène, Sécurité et Environnement','2012-01-01 00:00:00','Donec sollicitudin molestie malesuada. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Donec rutrum congue leo eget malesuada. Pellentesque in ipsum id orci porta dapibus. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Pellentesque in ipsum id orci porta dapibus. Donec sollicitudin molestie malesuada. Curabitur aliquet quam id dui posuere blandit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.'),(8,'Distribution et Merchandising','2012-01-01 00:00:00','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Nulla porttitor accumsan tincidunt. Sed porttitor lectus nibh. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Nulla porttitor accumsan tincidunt. Nulla quis lorem ut libero malesuada feugiat. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a.'),(9,'Management Produit Textile-Habillement','2012-01-01 00:00:00','Praesent sapien massa, convallis a pellentesque nec, egestas non nisi. Cras ultricies ligula sed magna dictum porta. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Cras ultricies ligula sed magna dictum porta. Donec sollicitudin molestie malesuada. Donec sollicitudin molestie malesuada. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec rutrum congue leo eget malesuada. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Sed porttitor lectus nibh.'),(10,'Génie Industriel','2012-01-01 00:00:00','Nulla quis lorem ut libero malesuada feugiat. Mauris blandit aliquet elit, eget tincidunt nibh pulvinar a. Curabitur aliquet quam id dui posuere blandit. Nulla quis lorem ut libero malesuada feugiat. Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Sed porttitor lectus nibh. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Pellentesque in ipsum id orci porta dapibus. Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui. Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus.'),(11,'Informatique et Management des Systèmes','2012-01-01 00:00:00','Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Cras ultricies ligula sed magna dictum porta. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ultricies ligula sed magna dictum porta. Pellentesque in ipsum id orci porta dapibus. Donec rutrum congue leo eget malesuada. Donec rutrum congue leo eget malesuada. Donec sollicitudin molestie malesuada. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.');
/*!40000 ALTER TABLE `school_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `training`
--

DROP TABLE IF EXISTS `training`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `training` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `year_graduation` int(11) NOT NULL,
  `specialty` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `establishment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `level` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `moyenne` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D5128A8FA76ED395` (`user_id`),
  CONSTRAINT `FK_D5128A8FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `training`
--

LOCK TABLES `training` WRITE;
/*!40000 ALTER TABLE `training` DISABLE KEYS */;
INSERT INTO `training` VALUES (29,14,2010,'kldklflk','dffd','Bac','15','',0),(30,14,2010,'ddffd','fdfdf','Bac','13.5','',0),(33,14,1981,'kldklflk','fdflkl','Semestre 2 deuxiÃ¨me annÃ©e bac','15','',0),(34,14,2011,'genie informatique','jkjkj','Première année baccalauréat','54','',0),(38,14,2012,'fff','fff','Tronc commun','30','dffd',0),(63,71,2018,'toto','yoyoy','Troisième année Post Baccalauréat (Licence ou équivalent)','12','casablanca',1),(64,71,2017,'toto','yoyoy','Première année Post Baccalauréat','12','casablanca',1),(65,71,2016,'toto','yoyoy','Première année baccalauréat','12','casablanca',1);
/*!40000 ALTER TABLE `training` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `training_type`
--

DROP TABLE IF EXISTS `training_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `training_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8344106A5E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `training_type`
--

LOCK TABLES `training_type` WRITE;
/*!40000 ALTER TABLE `training_type` DISABLE KEYS */;
INSERT INTO `training_type` VALUES (6,'Formation initiale');
/*!40000 ALTER TABLE `training_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_diploma_type`
--

DROP TABLE IF EXISTS `user_diploma_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_diploma_type` (
  `user_id` int(11) NOT NULL,
  `diploma_type_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`diploma_type_id`),
  KEY `IDX_8011216DA76ED395` (`user_id`),
  KEY `IDX_8011216DD2BDC45D` (`diploma_type_id`),
  CONSTRAINT `FK_8011216DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_8011216DD2BDC45D` FOREIGN KEY (`diploma_type_id`) REFERENCES `diploma_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_diploma_type`
--

LOCK TABLES `user_diploma_type` WRITE;
/*!40000 ALTER TABLE `user_diploma_type` DISABLE KEYS */;
INSERT INTO `user_diploma_type` VALUES (14,1),(14,2),(14,4),(71,1),(71,2),(71,4);
/*!40000 ALTER TABLE `user_diploma_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nationality_id` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `first_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `cin` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cne` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phoneNumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `place_birth` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_date` datetime DEFAULT NULL,
  `role` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `internat` tinyint(1) DEFAULT NULL,
  `father` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mother` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_1483A5E9ABE530DA` (`cin`),
  UNIQUE KEY `UNIQ_1483A5E973767F95` (`cne`),
  KEY `IDX_1483A5E91C9DA55` (`nationality_id`),
  KEY `IDX_1483A5E9C32A47EE` (`school_id`),
  CONSTRAINT `FK_1483A5E91C9DA55` FOREIGN KEY (`nationality_id`) REFERENCES `nationality` (`id`),
  CONSTRAINT `FK_1483A5E9C32A47EE` FOREIGN KEY (`school_id`) REFERENCES `school` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (14,1,'ouchayan.h@gmail.com','ouchayan.h@gmail.com',1,'1srjamcxm0cgwkcwww0k4oow4cso480','$2y$13$1srjamcxm0cgwkcwww0k4e/./l/x5xqQfh2WVgMcIAl86VPSBXx7.','2019-04-08 18:26:28',0,0,NULL,'fiXFvgDpGru-SkUTUAlA7_Vl4blGVZ9ENwJtfxyRF8w',NULL,'a:0:{}',0,NULL,'ouchayankkj','hamid','123',NULL,'kfdklfdkl','fdlkkldfdd','casablanca','2017-01-31 00:00:00','administrator',NULL,'',NULL,NULL,1,1,NULL,NULL),(71,1,'ouchayan.zaid@gmail.com','ouchayan.zaid@gmail.com',1,'7pxdqzp851sss84cs0gkscw0k4gog0s','$2y$13$7pxdqzp851sss84cs0gksO6Aek7bOZ/5w3stDMvCZYLI8dXe.CdZ6','2019-04-09 10:53:18',0,0,NULL,NULL,NULL,'a:0:{}',0,NULL,'ouchayan','kamal','klllklk','2304040','TOUR A COEUR DEFENSE 110 ESPLANADE DU GENERAL DE G','188321333','Casablanca','1989-10-12 00:00:00','student',NULL,'','2019-04-08 18:31:45',NULL,NULL,1,'zaid ouchayan','ndjdjd');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-09 14:52:11
