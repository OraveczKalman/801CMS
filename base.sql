-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.9 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Verzió:              9.4.0.5130
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for tábla alap.artist
CREATE TABLE IF NOT EXISTS `artist` (
  `ArtistId` bigint(20) NOT NULL AUTO_INCREMENT,
  `ArtistName` varchar(255) DEFAULT NULL,
  `Created` datetime NOT NULL,
  `CreatedBy` bigint(20) NOT NULL,
  `Modified` datetime NOT NULL,
  `ModifiedBy` bigint(20) NOT NULL,
  `Active` tinyint(4) NOT NULL,
  PRIMARY KEY (`ArtistId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table alap.artist: ~0 rows (approximately)
/*!40000 ALTER TABLE `artist` DISABLE KEYS */;
/*!40000 ALTER TABLE `artist` ENABLE KEYS */;

-- Dumping structure for tábla alap.csunya_szok
CREATE TABLE IF NOT EXISTS `csunya_szok` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `szo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table alap.csunya_szok: ~0 rows (approximately)
/*!40000 ALTER TABLE `csunya_szok` DISABLE KEYS */;
/*!40000 ALTER TABLE `csunya_szok` ENABLE KEYS */;

-- Dumping structure for tábla alap.forum_message
CREATE TABLE IF NOT EXISTS `forum_message` (
  `MessageId` bigint(20) NOT NULL AUTO_INCREMENT,
  `DocId` bigint(20) NOT NULL DEFAULT '0',
  `ReplyTo` bigint(20) DEFAULT NULL,
  `Message` longtext NOT NULL,
  `Active` tinyint(4) NOT NULL DEFAULT '0',
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` bigint(20) NOT NULL DEFAULT '0',
  `Modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ModifiedBy` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`MessageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table alap.forum_message: ~0 rows (approximately)
/*!40000 ALTER TABLE `forum_message` DISABLE KEYS */;
/*!40000 ALTER TABLE `forum_message` ENABLE KEYS */;

-- Dumping structure for tábla alap.gallery_picture
CREATE TABLE IF NOT EXISTS `gallery_picture` (
  `MainHeaderId` bigint(20) NOT NULL,
  `PictureId` bigint(20) NOT NULL,
  `Rank` bigint(20) NOT NULL,
  `Cover` tinyint(4) DEFAULT NULL,
  `Active` tinyint(4) NOT NULL,
  PRIMARY KEY (`MainHeaderId`,`PictureId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table alap.gallery_picture: ~7 rows (approximately)
/*!40000 ALTER TABLE `gallery_picture` DISABLE KEYS */;
INSERT INTO `gallery_picture` (`MainHeaderId`, `PictureId`, `Rank`, `Cover`, `Active`) VALUES
	(1, 1, 0, NULL, 1),
	(1, 2, 0, NULL, 1),
	(1, 3, 0, NULL, 1),
	(1, 4, 0, NULL, 1),
	(1, 5, 0, NULL, 1),
	(1, 6, 0, NULL, 1),
	(1, 7, 0, NULL, 1);
/*!40000 ALTER TABLE `gallery_picture` ENABLE KEYS */;

-- Dumping structure for tábla alap.genre
CREATE TABLE IF NOT EXISTS `genre` (
  `GenreId` bigint(20) NOT NULL AUTO_INCREMENT,
  `GenreName` varchar(255) DEFAULT NULL,
  `Created` datetime NOT NULL,
  `CreatedBy` bigint(20) NOT NULL,
  `Modified` datetime NOT NULL,
  `ModifiedBy` bigint(20) NOT NULL,
  `Active` tinyint(4) NOT NULL,
  PRIMARY KEY (`GenreId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table alap.genre: ~0 rows (approximately)
/*!40000 ALTER TABLE `genre` DISABLE KEYS */;
/*!40000 ALTER TABLE `genre` ENABLE KEYS */;

-- Dumping structure for tábla alap.grid_main
CREATE TABLE IF NOT EXISTS `grid_main` (
  `gridId` bigint(20) NOT NULL AUTO_INCREMENT,
  `gridName` varchar(50) DEFAULT NULL,
  `columnName` varchar(30) DEFAULT NULL,
  `fieldName` varchar(30) DEFAULT NULL,
  `fieldLongName` varchar(50) DEFAULT NULL,
  `align` varchar(10) DEFAULT NULL,
  `orderBy` bigint(20) DEFAULT NULL,
  `orderByType` varchar(4) DEFAULT NULL,
  `colPosition` bigint(20) DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  `hidden` tinyint(1) DEFAULT NULL,
  `inSearch` tinyint(1) DEFAULT NULL,
  `mask` varchar(50) DEFAULT NULL,
  `minValue` bigint(20) DEFAULT NULL,
  `maxValue` bigint(20) DEFAULT NULL,
  `flagDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`gridId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table alap.grid_main: ~0 rows (approximately)
/*!40000 ALTER TABLE `grid_main` DISABLE KEYS */;
/*!40000 ALTER TABLE `grid_main` ENABLE KEYS */;

-- Dumping structure for tábla alap.grid_users
CREATE TABLE IF NOT EXISTS `grid_users` (
  `gridId` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) DEFAULT NULL,
  `gridName` varchar(50) DEFAULT NULL,
  `columnName` varchar(30) DEFAULT NULL,
  `fieldName` varchar(30) DEFAULT NULL,
  `fieldLongName` varchar(50) DEFAULT NULL,
  `align` varchar(10) DEFAULT NULL,
  `orderBy` bigint(20) DEFAULT NULL,
  `orderByType` varchar(4) DEFAULT NULL,
  `colPosition` bigint(20) DEFAULT NULL,
  `visibility` tinyint(1) DEFAULT NULL,
  `hidden` tinyint(1) DEFAULT NULL,
  `inSearch` tinyint(1) DEFAULT NULL,
  `mask` varchar(50) DEFAULT NULL,
  `minValue` bigint(20) DEFAULT NULL,
  `maxValue` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`gridId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table alap.grid_users: ~0 rows (approximately)
/*!40000 ALTER TABLE `grid_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `grid_users` ENABLE KEYS */;

-- Dumping structure for tábla alap.header_artist
CREATE TABLE IF NOT EXISTS `header_artist` (
  `MainHeaderId` bigint(20) unsigned NOT NULL,
  `ArtistId` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`MainHeaderId`,`ArtistId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table alap.header_artist: ~0 rows (approximately)
/*!40000 ALTER TABLE `header_artist` DISABLE KEYS */;
/*!40000 ALTER TABLE `header_artist` ENABLE KEYS */;

-- Dumping structure for tábla alap.header_genre
CREATE TABLE IF NOT EXISTS `header_genre` (
  `MainHeaderId` bigint(20) unsigned NOT NULL,
  `GenreId` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`MainHeaderId`,`GenreId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table alap.header_genre: ~0 rows (approximately)
/*!40000 ALTER TABLE `header_genre` DISABLE KEYS */;
/*!40000 ALTER TABLE `header_genre` ENABLE KEYS */;

-- Dumping structure for tábla alap.kontakt_form
CREATE TABLE IF NOT EXISTS `kontakt_form` (
  `ContactId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) DEFAULT NULL,
  `TargetMail` varchar(100) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `Phone` varchar(100) DEFAULT NULL,
  `Mobile` varchar(100) DEFAULT NULL,
  `SmtpPassword` varchar(100) DEFAULT NULL,
  `Fax` varchar(100) DEFAULT NULL,
  `SmtpServer` varchar(100) DEFAULT NULL,
  `Port` bigint(20) DEFAULT NULL,
  `UserName` varchar(100) DEFAULT NULL,
  `Created` datetime NOT NULL,
  `CreatedBy` bigint(20) NOT NULL,
  `Modified` datetime NOT NULL,
  `ModifiedBy` bigint(20) NOT NULL,
  `Active` tinyint(4) NOT NULL,
  PRIMARY KEY (`ContactId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table alap.kontakt_form: ~0 rows (approximately)
/*!40000 ALTER TABLE `kontakt_form` DISABLE KEYS */;
/*!40000 ALTER TABLE `kontakt_form` ENABLE KEYS */;

-- Dumping structure for tábla alap.lang_header
CREATE TABLE IF NOT EXISTS `lang_header` (
  `LangHeaderId` bigint(20) NOT NULL AUTO_INCREMENT,
  `MainHeaderId` bigint(20) NOT NULL,
  `ParentId` bigint(20) NOT NULL,
  `Caption` varchar(255) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Heading` varchar(255) DEFAULT NULL,
  `Link` varchar(255) DEFAULT NULL,
  `Keywords` longtext,
  `Language` varchar(50) DEFAULT 'hu',
  `Rank` bigint(20) DEFAULT NULL,
  `Counter` bigint(20) DEFAULT NULL,
  `Created` datetime NOT NULL,
  `CreatedBy` bigint(20) NOT NULL,
  `Modified` datetime NOT NULL,
  `ModifiedBy` bigint(20) NOT NULL,
  `Active` tinyint(4) NOT NULL,
  PRIMARY KEY (`LangHeaderId`,`MainHeaderId`,`ParentId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping structure for tábla alap.main_header
CREATE TABLE IF NOT EXISTS `main_header` (
  `MainHeaderId` bigint(20) NOT NULL AUTO_INCREMENT,
  `AdditionalField` varchar(255) DEFAULT NULL COMMENT 'Tabellánál json, Galéria esetén: 0-normál galéria, 1-címlap slider, 2-slider',
  `Role` bigint(20) DEFAULT NULL,
  `MainPage` tinyint(4) DEFAULT '0',
  `MainNode` bigint(20) DEFAULT '0',
  `MoreFlag` tinyint(4) DEFAULT NULL,
  `Counter` bigint(20) DEFAULT NULL,
  `Target` varchar(255) DEFAULT NULL,
  `UserIn` tinyint(4) DEFAULT NULL,
  `Popup` tinyint(4) NOT NULL DEFAULT '0',
  `Commentable` tinyint(4) NOT NULL DEFAULT '0',
  `Module` varchar(255) DEFAULT NULL,
  `Created` datetime NOT NULL,
  `CreatedBy` bigint(20) NOT NULL,
  `Modified` datetime NOT NULL,
  `ModifiedBy` bigint(20) NOT NULL,
  `Active` tinyint(4) NOT NULL,
  PRIMARY KEY (`MainHeaderId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping structure for tábla alap.picture
CREATE TABLE IF NOT EXISTS `picture` (
  `PictureId` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) DEFAULT NULL,
  `ThumbName` varchar(50) DEFAULT NULL,
  `MediaType` tinyint(4) DEFAULT NULL COMMENT '1: kép, 2: youtube video, 3: feltöltött video, 4: zene, 5: feltöltött file',
  `Created` datetime NOT NULL,
  `CreatedBy` bigint(20) NOT NULL,
  `Modified` datetime NOT NULL,
  `ModifiedBy` bigint(20) NOT NULL,
  `Active` tinyint(4) NOT NULL,
  PRIMARY KEY (`PictureId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping structure for tábla alap.role
CREATE TABLE IF NOT EXISTS `role` (
  `RoleId` bigint(20) NOT NULL,
  `RoleName` varchar(50) NOT NULL,
  `ControllerName` varchar(50) NOT NULL,
  PRIMARY KEY (`RoleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table alap.role: ~21 rows (approximately)
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` (`RoleId`, `RoleName`, `ControllerName`) VALUES
	(0, 'Index', 'Index'),
	(1, 'Menüpont', 'Menu'),
	(2, 'Hírfolyam', 'News'),
	(3, 'Cikk', 'Article'),
	(4, 'Galéria', 'Gallery'),
	(5, 'Galéria gyűjtemény', 'GalleryCollection'),
	(6, 'Tabella', 'Table'),
	(7, 'File feltöltés', 'FileView'),
	(8, 'Még készül', 'UC'),
	(9, 'Fórum téma', 'Forum'),
	(10, 'Contact', 'ContactForm'),
	(11, 'Regform', 'Registration'),
	(12, 'Crop', 'Crop'),
	(14, 'Landing page', 'Landing'),
	(15, 'Hírbox cover', 'NewsCover'),
	(16, 'Menu cover', 'MenuCover'),
	(17, 'Idővonal', 'Timeline'),
	(18, 'Alapbeállítás', 'SetupForm'),
	(19, 'Felhasználó', 'User'),
	(20, 'File feltöltő űrlap', 'FileUpload'),
	(21, 'Parallax gyűjtemény', 'Parallax');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;

-- Dumping structure for tábla alap.setupdata
CREATE TABLE IF NOT EXISTS `setupdata` (
  `SetupId` bigint(20) NOT NULL AUTO_INCREMENT,
  `SetupData` longtext NOT NULL,
  PRIMARY KEY (`SetupId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping structure for tábla alap.text
CREATE TABLE IF NOT EXISTS `text` (
  `TextId` bigint(20) NOT NULL AUTO_INCREMENT,
  `SuperiorId` bigint(20) DEFAULT NULL,
  `Type` bigint(20) DEFAULT NULL COMMENT '1: cikk bevezető, 2: cikk, 3: képaláírás, 4:termékleírás',
  `Title` varchar(255) DEFAULT NULL,
  `Text` longtext,
  `Language` varchar(50) DEFAULT NULL,
  `Created` datetime NOT NULL,
  `CreatedBy` bigint(20) NOT NULL,
  `Modified` datetime NOT NULL,
  `ModifiedBy` bigint(20) NOT NULL,
  `Active` tinyint(4) NOT NULL,
  PRIMARY KEY (`TextId`),
  KEY `Felettes_Id_Tipus` (`SuperiorId`,`Type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping data for table alap.text: ~0 rows (approximately)
/*!40000 ALTER TABLE `text` DISABLE KEYS */;
/*!40000 ALTER TABLE `text` ENABLE KEYS */;

-- Dumping structure for tábla alap.user
CREATE TABLE IF NOT EXISTS `user` (
  `UserId` bigint(20) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) CHARACTER SET utf8 COLLATE utf8_hungarian_ci DEFAULT NULL,
  `UserName` varchar(30) CHARACTER SET utf8 COLLATE utf8_hungarian_ci DEFAULT NULL,
  `Password` varchar(255) CHARACTER SET utf8 COLLATE utf8_hungarian_ci DEFAULT NULL,
  `Pwdr` varchar(50) CHARACTER SET utf8 COLLATE utf8_hungarian_ci DEFAULT NULL,
  `Email` varchar(50) CHARACTER SET utf8 COLLATE utf8_hungarian_ci DEFAULT NULL,
  `RightId` bigint(20) DEFAULT NULL,
  `News` varchar(50) CHARACTER SET utf8 COLLATE utf8_hungarian_ci DEFAULT NULL,
  `Created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CreatedBy` bigint(20) NOT NULL,
  `Modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ModifiedBy` bigint(20) NOT NULL,
  `Active` tinyint(4) NOT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Dumping structure for tábla alap.user_rights
CREATE TABLE IF NOT EXISTS `user_rights` (
  `userRightId` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `createdBy` bigint(20) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedBy` bigint(20) NOT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`userRightId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table alap.user_rights: ~1 rows (approximately)
/*!40000 ALTER TABLE `user_rights` DISABLE KEYS */;
INSERT INTO `user_rights` (`userRightId`, `name`, `createdBy`, `modified`, `modifiedBy`, `active`) VALUES
	(1, 'Administrator', 0, '2017-03-05 08:49:26', 0, 1);
/*!40000 ALTER TABLE `user_rights` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
