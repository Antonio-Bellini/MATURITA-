-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 05, 2024 alle 20:07
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `associazione_zerotre`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `assistiti`
--

CREATE TABLE `assistiti` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `cognome` varchar(30) DEFAULT NULL,
  `anamnesi` text DEFAULT NULL,
  `note` text DEFAULT NULL,
  `id_referente` int(11) DEFAULT NULL,
  `id_liberatoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `assistiti_evento`
--

CREATE TABLE `assistiti_evento` (
  `id_evento` int(11) NOT NULL,
  `id_assistito` int(11) NOT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `bacheca`
--

CREATE TABLE `bacheca` (
  `id` int(11) NOT NULL,
  `bacheca` text DEFAULT NULL,
  `data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `eventi`
--

CREATE TABLE `eventi` (
  `id` int(11) NOT NULL,
  `tipo_evento` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `liberatorie`
--

CREATE TABLE `liberatorie` (
  `id` int(11) NOT NULL,
  `liberatoria` text DEFAULT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `newsletter` text DEFAULT NULL,
  `data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `profili`
--

CREATE TABLE `profili` (
  `id` int(11) NOT NULL,
  `tipo_profilo` int(11) DEFAULT NULL,
  `tipo_funzione` int(11) DEFAULT NULL,
  `tipo_operazione` char(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `tipi_evento`
--

CREATE TABLE `tipi_evento` (
  `id` int(11) NOT NULL,
  `tipo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tipi_evento`
--

INSERT INTO `tipi_evento` (`id`, `tipo`) VALUES
(1, 'Piscina'),
(2, 'Montagna'),
(3, 'Mare'),
(4, 'Sedute fisioterapiche');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipi_funzione`
--

CREATE TABLE `tipi_funzione` (
  `id` int(11) NOT NULL,
  `tipo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tipi_funzione`
--

INSERT INTO `tipi_funzione` (`id`, `tipo`) VALUES
(1, 'gestione DB'),
(2, 'bacheca'),
(3, 'newsletter'),
(4, 'anamnesi');

-- --------------------------------------------------------

--
-- Struttura della tabella `tipi_profilo`
--

CREATE TABLE `tipi_profilo` (
  `id` int(11) NOT NULL,
  `tipo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `tipi_profilo`
--

INSERT INTO `tipi_profilo` (`id`, `tipo`) VALUES
(1, 'presidente'),
(2, 'admin'),
(3, 'terapista'),
(4, 'genitore');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `cognome` varchar(30) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `telefono_fisso` varchar(9) DEFAULT NULL,
  `telefono_mobile` varchar(9) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `numero_accessi` int(11) DEFAULT NULL,
  `id_profilo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `volontari`
--

CREATE TABLE `volontari` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `cognome` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `telefono_fisso` varchar(9) DEFAULT NULL,
  `telefono_mobile` varchar(9) DEFAULT NULL,
  `id_liberatoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `volontari_evento`
--

CREATE TABLE `volontari_evento` (
  `id_evento` int(11) NOT NULL,
  `id_volontario` int(11) NOT NULL,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `assistiti`
--
ALTER TABLE `assistiti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_referente` (`id_referente`),
  ADD KEY `id_liberatoria` (`id_liberatoria`);

--
-- Indici per le tabelle `assistiti_evento`
--
ALTER TABLE `assistiti_evento`
  ADD PRIMARY KEY (`id_evento`,`id_assistito`),
  ADD KEY `id_assistito` (`id_assistito`);

--
-- Indici per le tabelle `bacheca`
--
ALTER TABLE `bacheca`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `eventi`
--
ALTER TABLE `eventi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_evento` (`tipo_evento`);

--
-- Indici per le tabelle `liberatorie`
--
ALTER TABLE `liberatorie`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `profili`
--
ALTER TABLE `profili`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_profilo` (`tipo_profilo`),
  ADD KEY `tipo_funzione` (`tipo_funzione`);

--
-- Indici per le tabelle `tipi_evento`
--
ALTER TABLE `tipi_evento`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tipi_funzione`
--
ALTER TABLE `tipi_funzione`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tipi_profilo`
--
ALTER TABLE `tipi_profilo`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indici per le tabelle `volontari`
--
ALTER TABLE `volontari`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_liberatoria` (`id_liberatoria`);

--
-- Indici per le tabelle `volontari_evento`
--
ALTER TABLE `volontari_evento`
  ADD PRIMARY KEY (`id_evento`,`id_volontario`),
  ADD KEY `id_volontario` (`id_volontario`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `assistiti`
--
ALTER TABLE `assistiti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `bacheca`
--
ALTER TABLE `bacheca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `eventi`
--
ALTER TABLE `eventi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `liberatorie`
--
ALTER TABLE `liberatorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `profili`
--
ALTER TABLE `profili`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT per la tabella `tipi_evento`
--
ALTER TABLE `tipi_evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `tipi_funzione`
--
ALTER TABLE `tipi_funzione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `tipi_profilo`
--
ALTER TABLE `tipi_profilo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT per la tabella `volontari`
--
ALTER TABLE `volontari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `assistiti`
--
ALTER TABLE `assistiti`
  ADD CONSTRAINT `assistiti_ibfk_1` FOREIGN KEY (`id_referente`) REFERENCES `utenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assistiti_ibfk_2` FOREIGN KEY (`id_liberatoria`) REFERENCES `liberatorie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `assistiti_evento`
--
ALTER TABLE `assistiti_evento`
  ADD CONSTRAINT `assistiti_evento_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `eventi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assistiti_evento_ibfk_2` FOREIGN KEY (`id_assistito`) REFERENCES `assistiti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `eventi`
--
ALTER TABLE `eventi`
  ADD CONSTRAINT `eventi_ibfk_1` FOREIGN KEY (`tipo_evento`) REFERENCES `tipi_evento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `profili`
--
ALTER TABLE `profili`
  ADD CONSTRAINT `profili_ibfk_1` FOREIGN KEY (`tipo_profilo`) REFERENCES `tipi_profilo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profili_ibfk_2` FOREIGN KEY (`tipo_funzione`) REFERENCES `tipi_funzione` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `volontari`
--
ALTER TABLE `volontari`
  ADD CONSTRAINT `volontari_ibfk_1` FOREIGN KEY (`id_liberatoria`) REFERENCES `liberatorie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `volontari_ibfk_2` FOREIGN KEY (`id_liberatoria`) REFERENCES `liberatorie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `volontari_evento`
--
ALTER TABLE `volontari_evento`
  ADD CONSTRAINT `volontari_evento_ibfk_1` FOREIGN KEY (`id_evento`) REFERENCES `eventi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `volontari_evento_ibfk_2` FOREIGN KEY (`id_volontario`) REFERENCES `volontari` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
