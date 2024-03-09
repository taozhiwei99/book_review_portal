CREATE DATABASE  IF NOT EXISTS `csci314` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `csci314`;
-- MariaDB dump 10.19  Distrib 10.4.25-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: csci314
-- ------------------------------------------------------
-- Server version	10.4.25-MariaDB

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
-- Table structure for table `author`
--

DROP TABLE IF EXISTS `author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `author` (
  `author_ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_ID` varchar(45) NOT NULL,
  PRIMARY KEY (`author_ID`),
  UNIQUE KEY `user_ID_UNIQUE` (`user_ID`),
  CONSTRAINT `author_FK1` FOREIGN KEY (`user_ID`) REFERENCES `user_info` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author`
--

LOCK TABLES `author` WRITE;
/*!40000 ALTER TABLE `author` DISABLE KEYS */;
INSERT INTO `author` VALUES (1,'author01'),(2,'author02'),(3,'author03'),(4,'author04'),(5,'author05'),(6,'author06'),(7,'author07'),(8,'author08'),(9,'author09'),(10,'author10'),(11,'author11'),(12,'author12'),(13,'author13'),(14,'author14'),(15,'author15'),(16,'author16'),(17,'author17'),(18,'author18'),(19,'author19'),(20,'author20'),(21,'author21'),(22,'author22'),(23,'author23'),(24,'author24'),(25,'author25'),(26,'author26'),(27,'author27'),(28,'author28'),(29,'author29'),(30,'author30'),(31,'author31'),(32,'author32'),(33,'author33'),(34,'author34'),(35,'author35'),(36,'author36'),(37,'author37'),(38,'author38'),(39,'author39'),(40,'author40'),(41,'author41'),(42,'author42'),(43,'author43'),(44,'author44'),(45,'author45'),(46,'author46'),(47,'author47'),(48,'author48'),(49,'author49'),(50,'author50');
/*!40000 ALTER TABLE `author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `author_has_paper`
--

DROP TABLE IF EXISTS `author_has_paper`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `author_has_paper` (
  `paper_ID` int(11) NOT NULL,
  `author_ID` int(11) NOT NULL,
  PRIMARY KEY (`paper_ID`,`author_ID`),
  KEY `author_has_paper_FK1_idx` (`author_ID`),
  CONSTRAINT `author_has_paper_FK1` FOREIGN KEY (`author_ID`) REFERENCES `author` (`author_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `author_has_paper_FK2` FOREIGN KEY (`paper_ID`) REFERENCES `paper` (`paper_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `author_has_paper`
--

LOCK TABLES `author_has_paper` WRITE;
/*!40000 ALTER TABLE `author_has_paper` DISABLE KEYS */;
INSERT INTO `author_has_paper` VALUES (1,1),(1,2),(2,1),(3,1),(4,1),(5,1),(6,1),(7,2),(8,2),(9,2),(10,3),(11,1),(12,2),(13,1),(13,2),(14,1),(14,5),(15,1),(15,2),(16,1),(16,2),(17,1),(17,3),(101,3),(102,6),(103,8),(104,11),(106,14),(107,15),(108,16),(109,17),(110,18),(111,18),(112,19),(113,20),(114,21),(115,21),(116,22),(117,22),(118,23),(119,24),(120,25),(121,25),(122,26),(123,27),(124,28),(125,28),(126,29),(127,30),(128,31),(129,31),(130,32),(131,33),(132,33),(133,34),(134,34),(135,35),(136,36),(137,36),(138,37),(139,38),(140,38),(141,39),(142,40),(143,40),(144,41),(145,42),(146,42),(147,44),(148,45),(149,46),(150,47),(151,48),(152,49),(153,50),(154,3),(155,4),(156,4),(157,5),(158,5),(159,6),(160,7),(161,8),(162,9),(163,10),(164,11),(165,12),(166,13),(167,14),(168,15),(169,16),(170,18),(171,17),(172,19),(173,20),(174,21),(175,22),(176,22),(177,25),(178,26),(179,27),(180,28),(181,29),(182,30),(183,31),(184,1),(185,1),(186,12),(186,42),(187,42),(188,13),(188,42);
/*!40000 ALTER TABLE `author_has_paper` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `comment_ID` int(11) NOT NULL AUTO_INCREMENT,
  `comment_Content` varchar(4500) NOT NULL,
  `review_ID` int(11) NOT NULL,
  PRIMARY KEY (`comment_ID`),
  KEY `comment_FK1_idx` (`review_ID`),
  CONSTRAINT `comment_FK1` FOREIGN KEY (`review_ID`) REFERENCES `review` (`review_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'Yes very well written indeed',1),(2,'Goes into details',2),(3,'Grammar isnt really that bad',3),(4,'Still some flaws',4),(5,'additional commenttttt',1),(6,'time for a new comment',1),(7,'did it actually work',1),(8,'yay it workssss',1),(9,'poor grandpa',3),(10,'additional comment',7),(11,'another additional comment',7),(12,'evidence that it works',1),(13,'new additional comt',7),(16,'proof',7),(19,'new comment',7),(21,'evidence',7),(22,'new new',14),(23,'even more',14),(24,'hiiii',21),(25,'lolololl',21),(26,'yes i agree',26),(27,'adasda',22),(28,'hahahaahaha LOL',23),(29,'HEHEHHEE',23),(30,'where got',32),(31,'agree',35);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conference_chair`
--

DROP TABLE IF EXISTS `conference_chair`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conference_chair` (
  `conference_chair_ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_ID` varchar(45) NOT NULL,
  PRIMARY KEY (`conference_chair_ID`),
  UNIQUE KEY `user_ID_UNIQUE` (`user_ID`),
  CONSTRAINT `conference_chair_FK1` FOREIGN KEY (`user_ID`) REFERENCES `user_info` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conference_chair`
--

LOCK TABLES `conference_chair` WRITE;
/*!40000 ALTER TABLE `conference_chair` DISABLE KEYS */;
INSERT INTO `conference_chair` VALUES (15,'cc10'),(1,'conference01'),(2,'conference02'),(3,'conference03'),(4,'conference04'),(5,'conference05'),(6,'conference06'),(7,'conference07'),(8,'conference08'),(9,'conference09'),(10,'conference10'),(11,'conference11'),(12,'conference12'),(13,'conference13'),(14,'conference14');
/*!40000 ALTER TABLE `conference_chair` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `paper_ID` int(11) NOT NULL,
  `status` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`paper_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
INSERT INTO `notification` VALUES (1,'old'),(2,'old'),(3,'old'),(4,'old'),(5,'old'),(6,'old'),(7,'new'),(10,'new'),(11,'old'),(13,'old'),(14,'old'),(15,'old'),(16,'old'),(120,'new'),(126,'new'),(186,'old'),(188,'old');
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paper`
--

DROP TABLE IF EXISTS `paper`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paper` (
  `paper_ID` int(11) NOT NULL AUTO_INCREMENT,
  `paper_Name` varchar(45) NOT NULL,
  `paper_Content` longtext DEFAULT NULL,
  `paper_Status` varchar(45) NOT NULL DEFAULT 'pending',
  `submitted_by_author` int(11) NOT NULL,
  `conference_chair_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`paper_ID`),
  KEY `paper_FK1_idx` (`conference_chair_ID`),
  KEY `paper_FK2_idx` (`submitted_by_author`),
  CONSTRAINT `paper_FK1` FOREIGN KEY (`conference_chair_ID`) REFERENCES `conference_chair` (`conference_chair_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `paper_FK2` FOREIGN KEY (`submitted_by_author`) REFERENCES `author` (`author_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paper`
--

LOCK TABLES `paper` WRITE;
/*!40000 ALTER TABLE `paper` DISABLE KEYS */;
INSERT INTO `paper` VALUES (1,'test.txt','test','accepted',1,1),(2,'abc2.txt','test02','accepted',1,NULL),(3,'abc3.txt','test03','rejected',1,NULL),(4,'abc4.txt','test04','rejected',1,NULL),(5,'abc5.txt','test05','accepted',1,NULL),(6,'abc6.txt','test06','accepted',1,1),(7,'abc7.txt','test07','accepted',2,5),(8,'abc8.txt','test08','pending',2,NULL),(9,'abc9.txt','test09','pending',2,NULL),(10,'abc10.txt','test10','rejected',3,1),(11,'abc11.txt','test11','accepted',1,NULL),(12,'abc12.txt','test12','pending',2,NULL),(13,'abc13.txt','test13','accepted',1,1),(14,'abc14.txt','test14','accepted',1,NULL),(15,'abc15.txt','test15','rejected',1,NULL),(16,'abc16.txt','test16','accepted',1,NULL),(17,'abc17.txt','test17','pending',1,NULL),(101,'abc18.txt','test18','pending',3,NULL),(102,'abc19.txt','test19','pending',6,NULL),(103,'abc20.txt','test20','pending',8,NULL),(104,'abc21.txt','test21','pending',10,NULL),(105,'abc22.txt','test22','pending',11,NULL),(106,'abc23.txt','test23','pending',14,NULL),(107,'abc24.txt','test24','pending',15,NULL),(108,'abc25.txt','test25','pending',16,NULL),(109,'abc26.txt','test26','pending',17,NULL),(110,'abc27.txt','test27','pending',18,NULL),(111,'abc28.txt','test28','pending',18,NULL),(112,'abc29.txt','test29','pending',19,NULL),(113,'abc30.txt','test30','pending',20,NULL),(114,'abc31.txt','test31','pending',21,NULL),(115,'abc32.txt','test32','pending',21,NULL),(116,'abc33.txt','test33','pending',22,NULL),(117,'abc34.txt','test34','pending',22,NULL),(118,'abc35.txt','test35','pending',23,NULL),(119,'abc36.txt','test36','pending',24,NULL),(120,'abc37.txt','test37','accepted',25,5),(121,'abc38.txt','test38','pending',25,NULL),(122,'abc39.txt','test39','pending',26,NULL),(123,'abc40.txt','test40','pending',27,NULL),(124,'abc41.txt','test41','pending',28,NULL),(125,'abc42.txt','test42','pending',28,NULL),(126,'abc43.txt','test43','rejected',29,5),(127,'abc44.txt','test44','pending',30,NULL),(128,'abc45.txt','test45','pending',31,NULL),(129,'abc46.txt','test46','pending',31,NULL),(130,'abc47.txt','test47','pending',32,NULL),(131,'abc48.txt','test48','pending',33,NULL),(132,'abc49.txt','test49','pending',33,NULL),(133,'abc50.txt','test50','pending',34,NULL),(134,'abc51.txt','test51','pending',34,NULL),(135,'abc52.txt','test52','pending',35,NULL),(136,'abc53.txt','test53','pending',36,NULL),(137,'abc54.txt','test54','pending',36,NULL),(138,'abc55.txt','test55','pending',37,NULL),(139,'abc56.txt','test56','pending',38,NULL),(140,'abc57.txt','test57','pending',38,NULL),(141,'abc58.txt','test58','pending',39,NULL),(142,'abc59.txt','test59','pending',40,NULL),(143,'abc60.txt','test60','pending',40,NULL),(144,'abc61.txt','test61','pending',41,NULL),(145,'abc62.txt','test62','pending',42,NULL),(146,'abc63.txt','test63','pending',43,NULL),(147,'abc64.txt','test64','pending',44,NULL),(148,'abc65.txt','test65','pending',45,NULL),(149,'abc66.txt','test66','pending',46,NULL),(150,'abc67.txt','test67','pending',47,NULL),(151,'abc68.txt','test68','pending',48,NULL),(152,'abc69.txt','test69','pending',49,NULL),(153,'abc70.txt','test70','pending',50,NULL),(154,'abc71.txt','test71','pending',3,NULL),(155,'abc72.txt','test72','pending',4,NULL),(156,'abc73.txt','test73','pending',4,NULL),(157,'abc74.txt','test74','pending',5,NULL),(158,'abc75.txt','test75','pending',5,NULL),(159,'abc76.txt','test76','pending',6,NULL),(160,'abc77.txt','test77','accepted',7,2),(161,'abc78.txt','test78','pending',8,NULL),(162,'abc79.txt','test79','pending',9,NULL),(163,'abc80.txt','test80','pending',10,NULL),(164,'abc81.txt','test81','pending',11,NULL),(165,'abc82.txt','test82','pending',12,NULL),(166,'abc83.txt','test83','pending',13,NULL),(167,'abc84.txt','test84','accepted',14,4),(168,'abc85.txt','test85','pending',15,NULL),(169,'abc86.txt','test86','pending',16,NULL),(170,'abc87.txt','test87','pending',18,NULL),(171,'abc88.txt','test88','pending',17,NULL),(172,'abc89.txt','test89','pending',19,NULL),(173,'abc90.txt','test90','pending',20,NULL),(174,'abc91.txt','test91','pending',21,NULL),(175,'abc92.txt','test92','pending',22,NULL),(176,'abc93.txt','test93','pending',24,NULL),(177,'abc94.txt','test94','pending',25,NULL),(178,'abc95.txt','test95','pending',26,NULL),(179,'abc96.txt','test96','pending',27,NULL),(180,'abc97.txt','test97','pending',28,NULL),(181,'abc98.txt','test98','pending',29,NULL),(182,'abc99.txt','test99','pending',30,NULL),(183,'abc100.txt','test100','pending',31,NULL),(184,'testinggggg','adsadasdadasdadada','pending',1,NULL),(185,'teettasda','adsdasdsd','pending',1,NULL),(186,'hehe42','adasdsadasdasd','accepted',42,2),(187,'hehe43','asdasdsadadasd','pending',42,NULL),(188,'hehe44','asdsadsadasds','rejected',42,2);
/*!40000 ALTER TABLE `paper` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `review` (
  `review_ID` int(11) NOT NULL AUTO_INCREMENT,
  `reviewer_Rating` int(11) NOT NULL,
  `reviewer_Comment` varchar(45) DEFAULT NULL,
  `reviewer_ID` int(11) NOT NULL,
  `paper_ID` int(11) NOT NULL,
  `author_Rating` int(11) DEFAULT NULL,
  PRIMARY KEY (`review_ID`),
  KEY `review_FK1_idx` (`reviewer_ID`),
  KEY `review_FK2_idx` (`paper_ID`),
  CONSTRAINT `review_FK1` FOREIGN KEY (`reviewer_ID`) REFERENCES `reviewer` (`reviewer_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `review_FK2` FOREIGN KEY (`paper_ID`) REFERENCES `paper` (`paper_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (1,0,'testing a whole new comment',1,1,NULL),(2,3,'Specific',2,1,NULL),(3,1,'Poor grammar',3,1,NULL),(4,3,'Good',1,2,3),(6,2,'Poor',2,2,NULL),(7,3,'Average',3,3,NULL),(8,1,'Bad',4,4,2),(9,3,'Very good',5,5,NULL),(14,2,'paper3',1,3,NULL),(15,2,'paper3',1,16,NULL),(21,2,'newnew',1,11,NULL),(22,2,'new',1,10,NULL),(23,-1,'aaaaaaffff',3,13,NULL),(24,-3,'ruf',1,14,NULL),(25,3,'aaawee',1,15,NULL),(26,2,'very good',10,6,-1),(27,3,'extremely good',11,6,NULL),(28,-2,'adsasd',1,13,NULL),(29,-2,'asdsada',20,120,NULL),(30,1,'asdsadaadada',20,7,NULL),(31,-1,'asdasdasdasd',20,126,NULL),(32,3,'good',15,186,-2),(33,3,'bagus',15,188,NULL),(34,0,'meh',16,186,2),(35,3,'pretty good',16,188,NULL);
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviewer`
--

DROP TABLE IF EXISTS `reviewer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviewer` (
  `reviewer_ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_ID` varchar(45) NOT NULL,
  `workload` int(11) DEFAULT 1,
  PRIMARY KEY (`reviewer_ID`),
  UNIQUE KEY `user_ID_UNIQUE` (`user_ID`),
  CONSTRAINT `reviewer_FK1` FOREIGN KEY (`user_ID`) REFERENCES `user_info` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviewer`
--

LOCK TABLES `reviewer` WRITE;
/*!40000 ALTER TABLE `reviewer` DISABLE KEYS */;
INSERT INTO `reviewer` VALUES (1,'reviewer01',4),(2,'reviewer02',1),(3,'reviewer03',2),(4,'reviewer04',1),(5,'reviewer05',1),(6,'reviewer06',1),(7,'reviewer07',1),(8,'reviewer08',1),(9,'reviewer09',1),(10,'reviewer10',2),(11,'reviewer11',1),(12,'reviewer12',1),(13,'reviewer13',1),(14,'reviewer14',1),(15,'reviewer15',10),(16,'reviewer16',10),(17,'reviewer17',1),(18,'reviewer18',1),(19,'reviewer19',1),(20,'reviewer20',3),(21,'reviewer21',1),(22,'reviewer22',1),(23,'reviewer23',1),(24,'reviewer24',1),(25,'reviewer25',1),(26,'reviewer26',1),(27,'reviewer27',1),(28,'reviewer28',1),(29,'reviewer29',1),(30,'reviewer30',1),(31,'reviewer31',1),(32,'reviewer32',1),(33,'reviewer33',1),(34,'reviewer34',1),(35,'reviewer35',1);
/*!40000 ALTER TABLE `reviewer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviewer_bid`
--

DROP TABLE IF EXISTS `reviewer_bid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviewer_bid` (
  `reviewer_ID` int(11) NOT NULL,
  `paper_ID` int(11) NOT NULL,
  `bid_Status` varchar(45) NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`reviewer_ID`,`paper_ID`),
  KEY `reviewer_bid_FK2_idx` (`paper_ID`),
  CONSTRAINT `reviewer_bid_FK1` FOREIGN KEY (`reviewer_ID`) REFERENCES `reviewer` (`reviewer_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `reviewer_bid_FK2` FOREIGN KEY (`paper_ID`) REFERENCES `paper` (`paper_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviewer_bid`
--

LOCK TABLES `reviewer_bid` WRITE;
/*!40000 ALTER TABLE `reviewer_bid` DISABLE KEYS */;
INSERT INTO `reviewer_bid` VALUES (1,1,'success'),(1,2,'success'),(1,3,'success'),(1,4,'fail'),(1,5,'fail'),(1,6,'fail'),(1,7,'fail'),(1,8,'fail'),(1,9,'fail'),(1,10,'success'),(1,11,'success'),(1,12,'success'),(1,13,'success'),(1,14,'success'),(1,15,'success'),(1,16,'success'),(1,17,'success'),(1,101,'success'),(1,102,'success'),(1,103,'success'),(1,104,'success'),(1,105,'success'),(1,106,'success'),(1,107,'success'),(1,108,'success'),(1,109,'success'),(1,110,'success'),(1,111,'success'),(1,112,'success'),(1,113,'fail'),(1,114,'fail'),(2,8,'success'),(2,9,'fail'),(2,10,'fail'),(3,16,'success'),(3,17,'success'),(10,6,'success'),(11,6,'success'),(15,186,'success'),(15,187,'fail'),(15,188,'success'),(16,186,'success'),(16,187,'fail'),(16,188,'success'),(20,7,'success'),(20,17,'fail'),(20,120,'success'),(20,126,'success');
/*!40000 ALTER TABLE `reviewer_bid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_admin`
--

DROP TABLE IF EXISTS `system_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_admin` (
  `Admin_ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_ID` varchar(45) NOT NULL,
  PRIMARY KEY (`Admin_ID`),
  UNIQUE KEY `user_ID_UNIQUE` (`user_ID`),
  CONSTRAINT `admin_FK1` FOREIGN KEY (`user_ID`) REFERENCES `user_info` (`user_ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_admin`
--

LOCK TABLES `system_admin` WRITE;
/*!40000 ALTER TABLE `system_admin` DISABLE KEYS */;
INSERT INTO `system_admin` VALUES (1,'admin01'),(2,'admin02'),(3,'admin03'),(4,'admin04'),(5,'admin05');
/*!40000 ALTER TABLE `system_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_info` (
  `user_ID` varchar(45) NOT NULL,
  `user_FName` varchar(45) NOT NULL,
  `user_LName` varchar(45) NOT NULL,
  `user_Email` varchar(45) NOT NULL,
  `user_Mobile` varchar(45) NOT NULL,
  `user_Password` varchar(45) NOT NULL,
  `user_Profile` varchar(45) NOT NULL,
  PRIMARY KEY (`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES ('admin01','gate','bills','gatebills@mail.com','123-45-6789','admin01','System Admin'),('admin02','sam','wilson','samwilson@mail.com','999-12-1234','admin02','System Admin'),('admin03','john','cena','cenaJohn@mail.com','345-11-9812','admin03','System Admin'),('admin04','Theodor','rock','tock@mail.com','123-22-2234','admin04','System Admin'),('admin05','steven','Lim','limsteven@mail.com','999-99-9999','admin05','System Admin'),('author01','Marin','Fallon','mfallone@reuters.com','238-50-8089','author01','Author'),('author02','Oralla','Harome','oharomef@nih.gov','515-68-4330','author02','Author'),('author03','Massimiliano','Bucher','mbucherg@hc360.com','376-09-2797','author03','Author'),('author04','Nathaniel','Tims','ntimsh@wordpress.com','866-21-5160','author04','Author'),('author05','Luciana','Massinger','lmassingeri@hostgator.com','735-34-6420','author05','Author'),('author06','Lucie','Vallow','lvallowj@bizjournals.com','841-65-9049','author06','Author'),('author07','Tallia','Ousby','tousbyk@symantec.com','109-82-5888','author07','Author'),('author08','Holly','Mulgrew','hmulgrewl@mail.ru','665-68-1263','author08','Author'),('author09','Chastity','Yuryichev','cyuryichevm@quantcast.com','597-27-7850','author09','Author'),('author10','Gaynor','Crix','gcrixn@creativecommons.org','273-14-7719','author10','Author'),('author11','Andeee','Fassbender','afassbendero@t-online.de','615-31-5790','author11','Author'),('author12','Giacobo','Cornewell','gcornewellp@va.gov','392-72-3426','author12','Author'),('author13','Easter','Been','ebeenq@a8.net','144-14-2550','author13','Author'),('author14','Byrom','Priestnall','bpriestnallr@comcast.net','315-92-0756','author14','Author'),('author15','Rosemaria','Garbutt','rgarbutts@vimeo.com','544-28-2758','author15','Author'),('author16','Blondie','Haddinton','bhaddintont@t.co','448-49-5179','author16','Author'),('author17','Leelah','Waddams','lwaddamsu@webeden.co.uk','307-67-3460','author17','Author'),('author18','Vasily','Tidridge','vtidridgev@wired.com','334-12-7035','author18','Author'),('author19','Layne','Shier','lshierw@ihg.com','885-79-6930','author19','Author'),('author20','Jennine','Banbrick','jbanbrickx@ucsd.edu','198-34-1835','author20','Author'),('author21','Luciana','Banton','lbantony@booking.com','178-81-4143','author21','Author'),('author22','Derek','Gosden','dgosdenz@disqus.com','649-34-5983','author22','Author'),('author23','Brit','Geistmann','bgeistmann10@hc360.com','577-86-1887','author23','Author'),('author24','Cybil','Heining','cheining11@ucsd.edu','229-03-9074','author24','Author'),('author25','Garik','Kiff','gkiff12@webeden.co.uk','454-09-6192','author25','Author'),('author26','Rhodia','Handslip','rhandslip13@independent.co.uk','722-60-8051','author26','Author'),('author27','Sheff','Teeney','steeney14@un.org','744-86-4683','author27','Author'),('author28','Orran','McGahey','omcgahey15@angelfire.com','559-10-3961','author28','Author'),('author29','Siegfried','McGuirk','smcguirk16@huffingtonpost.com','465-24-4017','author29','Author'),('author30','Demetri','Faulds','dfaulds17@sciencedaily.com','597-91-2921','author30','Author'),('author31','Emmit','Jessett','ejessett18@google.cn','697-33-4686','author31','Author'),('author32','Mallory','Bonsale','mbonsale19@gmpg.org','534-74-7414','author32','Author'),('author33','Gino','Simonds','gsimonds1a@constantcontact.com','494-03-9926','author33','Author'),('author34','Claude','Gover','cgover1b@shinystat.com','468-23-5727','author34','Author'),('author35','Early','Feldbaum','efeldbaum1c@wikimedia.org','732-64-9597','author35','Author'),('author36','Alvan','Kirkpatrick','akirkpatrick1d@prlog.org','639-09-4782','author36','Author'),('author37','Em','Cansfield','ecansfield1e@twitter.com','837-70-0438','author37','Author'),('author38','Berni','Pettecrew','bpettecrew1f@uiuc.edu','191-22-6154','author38','Author'),('author39','Nan','Merryweather','nmerryweather1g@wunderground.com','671-78-0859','author39','Author'),('author40','Cobb','Braham','cbraham1h@prlog.org','376-58-7694','author40','Author'),('author41','Knox','Greenstock','kgreenstock1i@hatena.ne.jp','413-26-2871','author41','Author'),('author42','Tracey','Lechmere','tlechmere1j@tamu.edu','166-24-2673','author42','Author'),('author43','Salli','Jennemann','sjennemann1k@photobucket.com','826-69-4422','author43','Author'),('author44','Kingsly','Beckey','kbeckey1l@blog.com','589-89-0517','author44','Author'),('author45','Rosemary','Northage','rnorthage1m@wikimedia.org','397-47-4637','author45','Author'),('author46','Erika','Clemmensen','eclemmensen1n@alibaba.com','227-61-4850','author46','Author'),('author47','Gabriello','Copestake','gcopestake1o@studiopress.com','213-22-0433','author47','Author'),('author48','Margaretha','Bonfield','mbonfield1p@nydailynews.com','461-45-4396','author48','Author'),('author49','Renard','Armytage','rarmytage1q@admin.ch','743-77-8289','author49','Author'),('author50','Devon','Breffitt','dbreffitt1r@skype.com','187-65-0340','author50','Author'),('cc10','cc10','Conference Chair','cc','10','10','10@gmail.com'),('conference01','cunt1','balls2','kukubird@gmail.com','00000000','conference01','Conference Chair'),('conference02','Beatrisa','Stiven','bstiven1@wufoo.com','435-60-1513','conference02','Conference Chair'),('conference03','Dar','Coare','dcoare2@statcounter.com','677-14-0742','conference03','Conference Chair'),('conference04','Fara','Peniman','fpeniman3@tmall.com','826-43-1634','conference04','Conference Chair'),('conference05','Perkin','Ipwell','pipwell4@msn.com','381-70-8396','conference05','Conference Chair'),('conference06','Amelina','Tollerton','atollerton5@is.gd','209-96-4894','conference06','Conference Chair'),('conference07','Ediva','Ryott','eryott6@census.gov','293-41-2971','conference07','Conference Chair'),('conference08','Faydra','Nockells','fnockells7@guardian.co.uk','719-94-8532','conference08','Conference Chair'),('conference09','Germain','Tassel','gtassel8@redcross.org','799-70-0257','conference09','Conference Chair'),('conference10','Coleen','Remirez','cremirez9@typepad.com','674-56-1146','conference10','Conference Chair'),('conference11','Brenden','Pizey','bpizeya@360.cn','603-05-9606','conference11','Conference Chair'),('conference12','Virgil','Esp','vespb@netlog.com','492-88-7482','conference12','Conference Chair'),('conference13','Paxon','Glanert','pglanertc@a8.net','402-06-7564','conference13','Conference Chair'),('conference14','Sutherland','Trinbey','strinbeyd@youtube.com','855-69-9058','conference14','Conference Chair'),('reviewer01','testes','balls','jabrahamowitcz1s@weather.com','999','reviewer01','Reviewer'),('reviewer02','Aeriel','Limprecht','alimprecht1t@cocolog-nifty.com','462-91-4986','reviewer02','Reviewer'),('reviewer03','Todd','Ilett','tilett1u@instagram.com','367-03-0468','reviewer03','Reviewer'),('reviewer04','Hakeem','Burree','hburree1v@dell.com','602-96-1246','reviewer04','Reviewer'),('reviewer05','Donna','Heephy','dheephy1w@studiopress.com','773-14-5881','reviewer05','Reviewer'),('reviewer06','Lacee','Cloney','lcloney1x@csmonitor.com','624-12-1561','reviewer06','Reviewer'),('reviewer07','Vikky','Cazin','vcazin1y@mashable.com','282-27-5617','reviewer07','Reviewer'),('reviewer08','Dukey','Wandless','dwandless1z@cargocollective.com','832-01-1674','reviewer08','Reviewer'),('reviewer09','Foster','Raitt','fraitt20@foxnews.com','291-65-3768','reviewer09','Reviewer'),('reviewer10','Alane','Mangan','amangan21@mlb.com','869-04-3063','reviewer10','Reviewer'),('reviewer11','Theodor','Porteous','tporteous22@1688.com','814-48-4626','reviewer11','Reviewer'),('reviewer12','Una','Tabard','utabard23@wsj.com','507-04-0675','reviewer12','Reviewer'),('reviewer13','Jennica','Tamblingson','jtamblingson24@tamu.edu','812-28-7473','reviewer13','Reviewer'),('reviewer14','Kendell','Meeus','kmeeus25@yelp.com','764-30-9606','reviewer14','Reviewer'),('reviewer15','Tiffy','Laidel','tlaidel26@google.it','509-82-6663','reviewer15','Reviewer'),('reviewer16','Terrijo','Novakovic','tnovakovic27@newsvine.com','132-80-5191','reviewer16','Reviewer'),('reviewer17','Egor','Hissett','ehissett28@techcrunch.com','395-96-4816','reviewer17','Reviewer'),('reviewer18','Aldwin','Bearman','abearman29@toplist.cz','660-09-1505','reviewer18','Reviewer'),('reviewer19','Ally','Le Marquis','alemarquis2a@newyorker.com','619-66-4560','reviewer19','Reviewer'),('reviewer20','Rudyard','Dowding','rdowding2b@ibm.com','859-37-1690','reviewer20','Reviewer'),('reviewer21','Andrus','Jeandeau','ajeandeau2c@dion.ne.jp','212-74-2359','reviewer21','Reviewer'),('reviewer22','Jorrie','Perks','jperks2d@paypal.com','476-37-2744','reviewer22','Reviewer'),('reviewer23','Augy','Jannings','ajannings2e@washington.edu','732-64-7482','reviewer23','Reviewer'),('reviewer24','Bellanca','Lyttle','blyttle2f@prnewswire.com','301-21-1190','reviewer24','Reviewer'),('reviewer25','Gran','Scritch','gscritch2g@businessinsider.com','805-43-5515','reviewer25','Reviewer'),('reviewer26','Aland','Kilmaster','akilmaster2h@blog.com','588-09-8632','reviewer26','Reviewer'),('reviewer27','Marlow','Cristou','mcristou2i@nsw.gov.au','310-20-5205','reviewer27','Reviewer'),('reviewer28','Sianna','Markova','smarkova2j@reference.com','179-31-3977','reviewer28','Reviewer'),('reviewer29','Maribeth','McLugish','mmclugish2k@nymag.com','295-42-9464','reviewer29','Reviewer'),('reviewer30','Page','Bodham','pbodham2l@friendfeed.com','244-85-4980','reviewer30','Reviewer'),('reviewer31','Brandyn','Fladgate','bfladgate2m@over-blog.com','414-95-8582','reviewer31','Reviewer'),('reviewer32','Alessandra','Delahunt','adelahunt2n@elegantthemes.com','533-20-8527','reviewer32','Reviewer'),('reviewer33','Earvin','Boyes','eboyes2o@icq.com','701-21-2421','reviewer33','Reviewer'),('reviewer34','Mycah','Rothwell','mrothwell2p@de.vu','221-90-9647','reviewer34','Reviewer'),('reviewer35','Niles','Djurevic','ndjurevic2q@sogou.com','206-28-3352','reviewer35','Reviewer');
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-11-15  5:58:14
