-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2025 at 02:22 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stacje`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `postoje`
--

CREATE TABLE `postoje` (
  `id_postoj` int(11) NOT NULL,
  `typ_postoj` text NOT NULL,
  `opis postoju` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `postoje`
--

INSERT INTO `postoje` (`id_postoj`, `typ_postoj`, `opis postoju`) VALUES
(1, 'ph', 'postój handlowy - obsługa pasażera'),
(2, 'pn', 'postój niehandlowy - tylko dla potrzeb przewoźnika'),
(3, 'zp', 'zatrzymuje się w razie potrzeby (stosuje się w przypadku dojazdu, zjazdu\r\npracowników kolejowych na posterunki blokowe, podstacje trakcyjne itp.) po\r\nuprzednim zgłoszeniu kierownikowi pociągu'),
(4, 'pm', 'praca manewrowa na stacji z wymianą grup wagonów bez zmiany brutta lub\r\nwymiana lokomotywy'),
(5, 'pt', 'postój tylko dla potrzeb technicznych'),
(6, 'zd', 'zmiana drużyny');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stacje`
--

CREATE TABLE `stacje` (
  `id_stacji` int(11) NOT NULL,
  `nazwa_stacji` text NOT NULL,
  `typ` text NOT NULL,
  `linia` int(3) NOT NULL,
  `czas` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stacje`
--

INSERT INTO `stacje` (`id_stacji`, `nazwa_stacji`, `typ`, `linia`, `czas`) VALUES
(1, 'Świnoujście Port\r\n', 'p.o', 401, '00:00:30'),
(2, 'Świnoujście\r\n', 'st.', 401, '00:00:45'),
(3, 'Świnoujście Warszów\r\n', 'p.o', 401, '00:01:00'),
(4, 'Świnoujście Przytór', 'p.o', 401, '00:01:00'),
(5, 'Lubiewo\r\n', 'st.', 401, '00:00:30'),
(6, 'Międzyzdroje\r\n', 'p.o', 401, '00:01:15'),
(7, 'Warnowo\r\n', 'st.', 401, '00:00:45'),
(8, 'Ładzin\r\n', 'p.o', 401, '00:01:00'),
(9, 'Mokrzyca Wielka\r\n', 'p.o', 401, '00:00:45'),
(10, 'Wolin\r\n', 'p.o', 401, '00:00:45'),
(11, 'Recław\r\n', 'st.', 401, '00:01:00'),
(12, 'Troszyn\r\n', 'st.', 401, '00:00:45'),
(13, 'Parłówko\r\n', 'st.', 401, '00:01:30'),
(14, 'Wysoka Kamieńska\r\n', 'st.', 401, '00:01:30'),
(15, 'Rokita\r\n', 'st.', 401, '00:01:30'),
(16, 'Łoźnica\r\n', 'st.', 401, '00:01:15'),
(17, 'Białuń\r\n', 'st.', 401, '00:01:15'),
(18, 'Goleniów\r\n', 'st.', 401, '00:01:00'),
(19, 'Goleniów Park Przemysłowy', 'p.o', 401, '00:00:45'),
(20, 'Rurka\r\n', 'st.', 401, '00:01:00'),
(21, 'Kliniska\r\n', 'st.', 401, '00:01:00'),
(22, 'Szczecin Załom\r\n', 'p.o', 401, '00:01:00'),
(23, 'Szczecin Trzebusz\r\n', 'st.', 401, '00:00:00'),
(24, 'Szczecin Dąbie SDC\r\n', 'podg', 401, '00:00:30'),
(25, 'Szczecin Dąbie\r\n', 'st.', 401, '00:01:30'),
(26, 'Szczecin Zdroje\r\n', 'st.', 351, '00:01:30'),
(27, 'Regalica\r\n', 'podg', 855, '00:01:00'),
(28, 'Szczecin Port Centralny\r\n', 'st.', 273, '00:02:30'),
(29, 'Szczecin Główny\r\n', 'st.', 351, '00:01:00'),
(30, 'Szczecin Wstowo\r\n', 'podg', 351, '00:01:30'),
(31, 'Dziewoklicz\r\n', 'podg', 351, '00:01:00'),
(32, 'Regalica\r\n', 'podg', 351, '00:01:15'),
(33, 'Szczecin Zdroje\r\n', 'st.', 351, '00:01:30'),
(34, 'Szczecin Dąbie\r\n', 'st.', 351, '00:00:45'),
(35, 'Szczecin Dąbie SDA\r\n', 'podg', 351, '00:01:00'),
(36, 'Szczecin Zdunowo\r\n', 'p.o', 351, '00:01:30'),
(19, 'Goleniów Park', 'p.o', 401, '00:00:00'),
(37, 'Reptowo\r\n', 'st.', 351, '00:01:30'),
(38, 'Miedwiecko\r\n', 'p.o\r\n', 351, '00:00:45'),
(39, 'Grzędzice \r\n', 'p.o', 351, '00:01:15'),
(40, 'Stargard\r\n', 'st.', 351, '00:01:45'),
(41, 'Witkowo Pyrzyckie\r\n', 'p.o', 351, '00:01:15'),
(42, 'Kolin\r\n', 'st.', 351, '00:01:15'),
(43, 'Morzyca\r\n', 'p.o', 351, '00:01:15'),
(44, 'Dolice\r\n', 'st.', 351, '00:01:30'),
(45, 'Ziemomyśl\r\n', 'p.o', 351, '00:01:15'),
(46, 'Choszczno\r\n', 'st.', 351, '00:01:15'),
(47, 'Stary Klukom\r\n', 'p.o', 351, '00:01:00'),
(48, 'Słonice\r\n', 'st.', 351, '00:01:45'),
(49, 'Rębusz', 'st.', 351, '00:00:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `stacje1`
--

CREATE TABLE `stacje1` (
  `id_stacji` int(11) NOT NULL,
  `nazwa_stacji` text NOT NULL,
  `typ` text NOT NULL,
  `linia` int(3) NOT NULL,
  `czas` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stacje1`
--

INSERT INTO `stacje1` (`id_stacji`, `nazwa_stacji`, `typ`, `linia`, `czas`) VALUES
(1, 'Świnoujście Port\r\n', 'p.o', 401, '00:00:00'),
(2, 'Świnoujście\r\n', 'st.', 401, '00:00:30'),
(3, 'Świnoujście Warszów\r\n', 'p.o', 401, '00:00:45'),
(4, 'Świnoujście Przytór', 'p.o', 401, '00:01:00'),
(5, 'Lubiewo\r\n', 'st.', 401, '00:01:00'),
(6, 'Międzyzdroje\r\n', 'p.o', 401, '00:00:30'),
(7, 'Warnowo\r\n', 'st.', 401, '00:01:15'),
(8, 'Ładzin\r\n', 'p.o', 401, '00:00:45'),
(9, 'Mokrzyca Wielka\r\n', 'p.o', 401, '00:01:00'),
(10, 'Wolin\r\n', 'p.o', 401, '00:00:45'),
(11, 'Recław\r\n', 'st.', 401, '00:00:45'),
(12, 'Troszyn\r\n', 'st.', 401, '00:01:00'),
(13, 'Parłówko\r\n', 'st.', 401, '00:00:45'),
(14, 'Wysoka Kamieńska\r\n', 'st.', 401, '00:01:30'),
(15, 'Rokita\r\n', 'st.', 401, '00:01:30'),
(16, 'Łoźnica\r\n', 'st.', 401, '00:01:30'),
(17, 'Białuń\r\n', 'st.', 401, '00:01:15'),
(18, 'Goleniów\r\n', 'st.', 401, '00:01:15'),
(20, 'Rurka\r\n', 'st.', 401, '00:01:45'),
(21, 'Kliniska\r\n', 'st.', 401, '00:01:00'),
(22, 'Szczecin Załom\r\n', 'p.o', 401, '00:01:00'),
(23, 'Szczecin Trzebusz\r\n', 'st.', 401, '00:00:00'),
(24, 'Szczecin Dąbie SDC\r\n', 'podg', 401, '00:01:00'),
(25, 'Szczecin Dąbie\r\n', 'st.', 401, '00:00:30'),
(26, 'Szczecin Zdroje\r\n', 'st.', 351, '00:01:30'),
(27, 'Regalica\r\n', 'podg', 855, '00:01:30'),
(28, 'Szczecin Port Centralny\r\n', 'st.', 273, '00:01:00'),
(29, 'Szczecin Główny\r\n', 'st.', 351, '00:01:00'),
(30, 'Szczecin Wstowo\r\n', 'podg', 351, '00:01:00'),
(31, 'Dziewoklicz\r\n', 'podg', 351, '00:01:15'),
(32, 'Regalica\r\n', 'podg', 351, '00:01:00'),
(33, 'Szczecin Zdroje\r\n', 'st.', 351, '00:01:15'),
(34, 'Szczecin Dąbie\r\n', 'st.', 351, '00:01:30'),
(35, 'Szczecin Dąbie SDA\r\n', 'podg', 351, '00:01:00'),
(36, 'Szczecin Zdunowo\r\n', 'p.o', 351, '00:01:00'),
(19, 'Goleniów Park', 'p.o', 401, '00:00:00'),
(37, 'Reptowo\r\n', 'st.', 351, '00:01:30'),
(38, 'Miedwiecko\r\n', 'p.o\r\n', 351, '00:01:00'),
(39, 'Grzędzice \r\n', 'p.o', 351, '00:00:45'),
(40, 'Stargard\r\n', 'st.', 351, '00:01:00'),
(41, 'Witkowo Pyrzyckie\r\n', 'p.o', 351, '00:02:00'),
(42, 'Kolin\r\n', 'st.', 351, '00:01:00'),
(43, 'Morzyca\r\n', 'p.o', 351, '00:01:15'),
(44, 'Dolice\r\n', 'st.', 351, '00:01:00'),
(45, 'Ziemomyśl\r\n', 'p.o', 351, '00:01:45'),
(46, 'Choszczno\r\n', 'st.', 351, '00:01:30'),
(47, 'Stary Klukom\r\n', 'p.o', 351, '00:01:45'),
(48, 'Słonice\r\n', 'st.', 351, '00:01:30'),
(49, 'Rębusz', 'st.', 351, '00:01:30');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `typ_pociagow`
--

CREATE TABLE `typ_pociagow` (
  `skrot` text NOT NULL,
  `opis` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `typ_pociagow`
--

INSERT INTO `typ_pociagow` (`skrot`, `opis`) VALUES
('EIE', 'Ekspresowy InterCity'),
('MHE', 'Międzywojewódzki pośpieszny typu\r\nhotelowego'),
('MPE ', 'Międzywojewódzki pośpieszny '),
('MOJ', 'Międzywojewódzki osobowy'),
('ROJ', 'Wojewódzki krajowy osobowy');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
