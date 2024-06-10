-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 10, 2024 alle 17:22
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_testzerotre`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `assistiti`
--

CREATE TABLE `assistiti` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cognome` varchar(255) DEFAULT NULL,
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
-- Struttura della tabella `immagini`
--

CREATE TABLE `immagini` (
  `id` int(11) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `id_titolo` int(11) DEFAULT NULL
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
-- Struttura della tabella `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `id_image` int(11) NOT NULL,
  `titolo` text DEFAULT NULL,
  `data` date DEFAULT NULL,
  `testo` text DEFAULT NULL
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

--
-- Dump dei dati per la tabella `profili`
--

INSERT INTO `profili` (`id`, `tipo_profilo`, `tipo_funzione`, `tipo_operazione`) VALUES
(1, 1, 2, 'CRUD'),
(2, 1, 3, 'READ'),
(3, 1, 4, 'READ'),
(4, 2, 1, 'CRUD'),
(5, 3, 2, 'CRUD'),
(6, 3, 3, 'READ'),
(7, 3, 3, 'CRUD'),
(8, 3, 4, 'CRUD'),
(9, 4, 2, 'READ'),
(10, 4, 3, 'READ');

-- --------------------------------------------------------

--
-- Struttura della tabella `registro_associazione`
--

CREATE TABLE `registro_associazione` (
  `id` int(11) NOT NULL,
  `anni_associazione` varchar(255) DEFAULT NULL,
  `volontari_attivi` varchar(255) DEFAULT NULL,
  `famiglie_aiutate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `registro_associazione`
--

INSERT INTO `registro_associazione` (`id`, `anni_associazione`, `volontari_attivi`, `famiglie_aiutate`) VALUES
(1, '1', '2', '3');

-- --------------------------------------------------------

--
-- Struttura della tabella `sezioni_foto`
--

CREATE TABLE `sezioni_foto` (
  `id` int(11) NOT NULL,
  `titolo` varchar(255) NOT NULL
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
  `nome` varchar(255) DEFAULT NULL,
  `cognome` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono_fisso` varchar(255) DEFAULT NULL,
  `telefono_mobile` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `id_tipo_profilo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `nome`, `cognome`, `username`, `password`, `email`, `telefono_fisso`, `telefono_mobile`, `note`, `id_tipo_profilo`) VALUES
(1, 'Gianfranco', 'Lanza', 'lanza', '8d2495acbc5f5fb36231ee5b05cd8e6a9e204fdda78437ec69e5f35c507c72085ce0679d310948426aa8e71ed331537c2de12151aef1875abb6960a6f6670556:$FF98p0Q#yoW&{s3OgpPmzSP[xd$i<!o', 'bordo@gmail.com', '', '123456789', 'sono l admin di prova', 2),

-- --------------------------------------------------------

--
-- Struttura della tabella `volontari`
--

CREATE TABLE `volontari` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `cognome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefono_fisso` varchar(255) DEFAULT NULL,
  `telefono_mobile` varchar(255) DEFAULT NULL,
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
-- Indici per le tabelle `immagini`
--
ALTER TABLE `immagini`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_titolo` (`id_titolo`);

--
-- Indici per le tabelle `liberatorie`
--
ALTER TABLE `liberatorie`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_image` (`id_image`);

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
-- Indici per le tabelle `registro_associazione`
--
ALTER TABLE `registro_associazione`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `sezioni_foto`
--
ALTER TABLE `sezioni_foto`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_tipo_profilo` (`id_tipo_profilo`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT per la tabella `bacheca`
--
ALTER TABLE `bacheca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT per la tabella `eventi`
--
ALTER TABLE `eventi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT per la tabella `immagini`
--
ALTER TABLE `immagini`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT per la tabella `liberatorie`
--
ALTER TABLE `liberatorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT per la tabella `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT per la tabella `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT per la tabella `profili`
--
ALTER TABLE `profili`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `registro_associazione`
--
ALTER TABLE `registro_associazione`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `sezioni_foto`
--
ALTER TABLE `sezioni_foto`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `volontari`
--
ALTER TABLE `volontari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `assistiti`
--
ALTER TABLE `assistiti`
  ADD CONSTRAINT `assistiti_ibfk_1` FOREIGN KEY (`id_referente`) REFERENCES `utenti` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assistiti_ibfk_2` FOREIGN KEY (`id_liberatoria`) REFERENCES `liberatorie` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
-- Limiti per la tabella `immagini`
--
ALTER TABLE `immagini`
  ADD CONSTRAINT `immagini_ibfk_1` FOREIGN KEY (`id_titolo`) REFERENCES `sezioni_foto` (`id`);

--
-- Limiti per la tabella `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`id_image`) REFERENCES `immagini` (`id`),
  ADD CONSTRAINT `news_ibfk_2` FOREIGN KEY (`id_image`) REFERENCES `immagini` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `profili`
--
ALTER TABLE `profili`
  ADD CONSTRAINT `profili_ibfk_1` FOREIGN KEY (`tipo_profilo`) REFERENCES `tipi_profilo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `profili_ibfk_2` FOREIGN KEY (`tipo_funzione`) REFERENCES `tipi_funzione` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `utenti`
--
ALTER TABLE `utenti`
  ADD CONSTRAINT `utenti_ibfk_1` FOREIGN KEY (`id_tipo_profilo`) REFERENCES `tipi_profilo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `volontari`
--
ALTER TABLE `volontari`
  ADD CONSTRAINT `volontari_ibfk_1` FOREIGN KEY (`id_liberatoria`) REFERENCES `liberatorie` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `volontari_ibfk_2` FOREIGN KEY (`id_liberatoria`) REFERENCES `liberatorie` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
