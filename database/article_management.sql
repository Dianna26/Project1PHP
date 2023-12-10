-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2023 at 05:26 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `article_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `articole`
--

CREATE TABLE `articole`
(
    `id_articol`     int(11)      NOT NULL,
    `id_utilizator`  int(11)    DEFAULT NULL,
    `id_categorie`   int(11)    DEFAULT NULL,
    `titlu`          varchar(100) NOT NULL,
    `continut`       text         NOT NULL,
    `data_publicare` date       DEFAULT NULL,
    `aprobat`        tinyint(1) DEFAULT 0
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `articole`
--

INSERT INTO `articole` (`id_articol`, `id_utilizator`, `id_categorie`, `titlu`, `continut`, `data_publicare`, `aprobat`)
VALUES (1, 1, 1, 'Arta abstracta', 'Descriere articol artistic...', '2023-01-01', 1),
       (2, 2, 2, 'Ultima tehnologie', 'Descriere articol tehnic...', '2023-02-01', 1),
       (3, 1, 3, 'Descoperire stiintifica', 'Descriere articol stiintific...', '2023-03-01', 0),
       (4, 3, 4, 'Tendinte de moda', 'Descriere articol de moda...', '2023-04-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `articole_cititori`
--

CREATE TABLE `articole_cititori`
(
    `id_utilizator` int(11) NOT NULL,
    `id_articol`    int(11) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `articole_cititori`
--

INSERT INTO `articole_cititori` (`id_utilizator`, `id_articol`)
VALUES (3, 1),
       (3, 4),
       (4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `categorii`
--

CREATE TABLE `categorii`
(
    `id_categorie`   int(11)     NOT NULL,
    `nume_categorie` varchar(50) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `categorii`
--

INSERT INTO `categorii` (`id_categorie`, `nume_categorie`)
VALUES (1, 'artistic'),
       (2, 'technic'),
       (3, 'science'),
       (4, 'moda');

-- --------------------------------------------------------

--
-- Table structure for table `utilizatori`
--
CREATE TABLE roluri
(
    id  INT PRIMARY KEY AUTO_INCREMENT,
    rol VARCHAR(255) NOT NULL
);

INSERT INTO `roluri` (`rol`)
VALUES ('jurnalist'),
       ('cititor'),
       ('editor');

CREATE TABLE `utilizatori`
(
    `id`      int(11)      NOT NULL,
    `nume`   varchar(50)  NOT NULL,
    `email`  varchar(100) NOT NULL,
    `parola` varchar(100) NOT NULL,
    `rol_id` int(11)      NOT NULL,
    -- Define a foreign key constraint to link to the roles table
    FOREIGN KEY (`rol_id`) REFERENCES `roluri` (`id`)
        -- Ensure that the value of rol_id matches an existing role in roles table
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_general_ci;

--
-- Dumping data for table `utilizatori`
--

INSERT INTO `utilizatori` (`id`, `nume`, `email`, `parola`, `rol_id`)
VALUES (1, 'Jurnalist1', 'jurnalist1@example.com', 'parola123', 1),
       (2, 'Jurnalist2', 'jurnalist2@example.com', 'parola456', 1),
       (3, 'Cititor1', 'cititor1@example.com', 'parola789', 2),
       (4, 'Editor1', 'editor1@example.com', 'parola000', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articole`
--
ALTER TABLE `articole`
    ADD PRIMARY KEY (`id_articol`),
    ADD KEY `id_utilizator` (`id_utilizator`),
    ADD KEY `id_categorie` (`id_categorie`);

--
-- Indexes for table `articole_cititori`
--
ALTER TABLE `articole_cititori`
    ADD PRIMARY KEY (`id_utilizator`, `id_articol`),
    ADD KEY `id_articol` (`id_articol`);

--
-- Indexes for table `categorii`
--
ALTER TABLE `categorii`
    ADD PRIMARY KEY (`id_categorie`);

--
-- Indexes for table `utilizatori`
--
ALTER TABLE `utilizatori`
    ADD PRIMARY KEY (id);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articole`
--
ALTER TABLE `articole`
    MODIFY `id_articol` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT for table `categorii`
--
ALTER TABLE `categorii`
    MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT for table `utilizatori`
--
ALTER TABLE `utilizatori`
    MODIFY id int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articole`
--
ALTER TABLE `articole`
    ADD CONSTRAINT `articole_ibfk_1` FOREIGN KEY (`id_utilizator`) REFERENCES `utilizatori` (id),
    ADD CONSTRAINT `articole_ibfk_2` FOREIGN KEY (`id_categorie`) REFERENCES `categorii` (`id_categorie`);

--
-- Constraints for table `articole_cititori`
--
ALTER TABLE `articole_cititori`
    ADD CONSTRAINT `articole_cititori_ibfk_1` FOREIGN KEY (`id_utilizator`) REFERENCES `utilizatori` (id),
    ADD CONSTRAINT `articole_cititori_ibfk_2` FOREIGN KEY (`id_articol`) REFERENCES `articole` (`id_articol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
