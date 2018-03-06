-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server Version:               10.1.30-MariaDB - mariadb.org binary distribution
-- Server Betriebssystem:        Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Exportiere Datenbank Struktur für planer
CREATE DATABASE IF NOT EXISTS `planer` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `planer`;

-- Exportiere Struktur von Tabelle planer.faecher
CREATE TABLE IF NOT EXISTS `faecher` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle planer.kurs
CREATE TABLE IF NOT EXISTS `kurs` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(50) NOT NULL,
  `lehrerID` int(11) NOT NULL,
  `fachID` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bezeichnung` (`bezeichnung`),
  UNIQUE KEY `fachID` (`fachID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle planer.lehrer
CREATE TABLE IF NOT EXISTS `lehrer` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `vorname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwort` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle planer.lehrer_faecher
CREATE TABLE IF NOT EXISTS `lehrer_faecher` (
  `lehrer` int(11) NOT NULL,
  `fach` int(11) NOT NULL,
  PRIMARY KEY (`lehrer`,`fach`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle planer.schueler
CREATE TABLE IF NOT EXISTS `schueler` (
  `id` int(11) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `vorname` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `geburtstag` date DEFAULT NULL,
  `kursKlasse` varchar(50) DEFAULT NULL,
  UNIQUE KEY `unique ind` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt
-- Exportiere Struktur von Tabelle planer.schueler_klasse
CREATE TABLE IF NOT EXISTS `schueler_klasse` (
  `schueler` int(11) NOT NULL,
  `klasse` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Daten Export vom Benutzer nicht ausgewählt
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
