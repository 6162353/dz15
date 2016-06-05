-- MySQL dump 10.13  Distrib 5.5.43, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: dz9
-- ------------------------------------------------------
-- Server version	5.5.43-0ubuntu0.14.04.1

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
-- Table structure for table `ads`
--

DROP TABLE IF EXISTS `ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `price` varchar(11) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `email` varchar(32) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `descr` text NOT NULL,
  `id_city` varchar(11) NOT NULL,
  `id_tube_station` varchar(11) NOT NULL,
  `id_subcategory` varchar(11) NOT NULL,
  `private` varchar(1) NOT NULL,
  `send_to_email` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ads`
--

LOCK TABLES `ads` WRITE;
/*!40000 ALTER TABLE `ads` DISABLE KEYS */;
INSERT INTO `ads` VALUES (34,'asdf','1','1','1','1','1','641780','641630','25','0','1'),(40,'asdf','2','2','','','','641780','','','1','0'),(44,'asdf','0','','','','','641780','','','1',''),(45,'1','asfd','asdf','asdf','asdf','asdf','641510','2020','14','0','1');
/*!40000 ALTER TABLE `ads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Транспорт'),(2,'Недвижимость'),(3,'Работа'),(4,'Услуги'),(5,'Личные вещи'),(6,'Для дома и дачи'),(7,'Бытовая электроника'),(8,'Хобби и отдых'),(9,'Животные'),(10,'Для бизнеса');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `city` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` VALUES (70000,'Другой город...'),(641780,'Новосибирск'),(641490,'Барабинск'),(641510,'Бердск'),(641600,'Искитим'),(641630,'Колывань'),(641680,'Краснообск'),(641710,'Куйбышев'),(641760,'Мошково'),(641790,'Обь'),(641800,'Ордынское'),(641970,'Черепаново');
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcategories`
--

DROP TABLE IF EXISTS `subcategories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `subcategory` text NOT NULL,
  `category` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcategories`
--

LOCK TABLES `subcategories` WRITE;
/*!40000 ALTER TABLE `subcategories` DISABLE KEYS */;
INSERT INTO `subcategories` VALUES (9,'Автомобили с пробегом',1),(109,'Новые автомобили',1),(14,'Мотоциклы и мототехника',1),(81,'Грузовики и спецтехника',1),(11,'Водный транспорт',1),(10,'Запчасти и аксессуары',1),(24,'Квартиры',2),(23,'Комнаты',2),(25,'Дома, дачи, коттеджи',2),(26,'Земельные участки',2),(85,'Гаражи и машиноместа',2),(42,'Коммерческая недвижимость',2),(86,'Недвижимость за рубежом',2),(111,'Вакансии (поиск сотрудников)',3),(112,'Резюме (поиск работы)',3),(114,'Предложения услуг',4),(115,'Запросы на услуги',4),(27,'Одежда, обувь, аксессуары',5),(29,'Детская одежда и обувь',5),(30,'Товары для детей и игрушки',5),(28,'Часы и украшения',5),(88,'Красота и здоровье',5),(21,'Бытовая техника',6),(20,'Мебель и интерьер',6),(87,'Посуда и товары для кухни',6),(82,'Продукты питания',6),(19,'Ремонт и строительство',6),(106,'Растения',6),(32,'Аудио и видео',7),(97,'Игры, приставки и программы',7),(31,'Настольные компьютеры',7),(98,'Ноутбуки',7),(99,'Оргтехника и расходники',7),(96,'Планшеты и электронные книги',7),(84,'Телефоны',7),(101,'Товары для компьютера',7),(33,'Билеты и путешествия',8),(34,'Велосипеды',8),(83,'Книги и журналы',8),(36,'Коллекционирование',8),(38,'Музыкальные инструменты',8),(102,'Охота и рыбалка',8),(39,'Спорт и отдых',8),(103,'Знакомства',8),(89,'Собаки',9),(90,'Кошки',9),(91,'Птицы',9),(92,'Аквариум',9),(93,'Другие животные',9),(94,'Товары для животных',9),(116,'Готовый бизнес',10),(40,'Оборудование для бизнеса',10);
/*!40000 ALTER TABLE `subcategories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tube_stations`
--

DROP TABLE IF EXISTS `tube_stations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tube_stations` (
  `id` int(11) NOT NULL,
  `tube_station` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tube_stations`
--

LOCK TABLES `tube_stations` WRITE;
/*!40000 ALTER TABLE `tube_stations` DISABLE KEYS */;
INSERT INTO `tube_stations` VALUES (2028,'Берёзовая роща'),(2018,'Гагаринская'),(2017,'Заельцовская'),(2029,'Золотая Нива'),(641630,'Маршала Покрышкина'),(2021,'Октябрьская'),(2025,'Площадь Гарина-Михайловского'),(2020,'Площадь Ленина'),(2024,'Площадь Маркса'),(2022,'Речной вокзал'),(2026,'Сибирская'),(2023,'Студенческая');
/*!40000 ALTER TABLE `tube_stations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-06-27 20:48:56
