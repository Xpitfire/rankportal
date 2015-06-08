
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `bookshop`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `books`
--

CREATE DATABASE bookshop;
USE bookshop;

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `categoryId` (`categoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Daten für Tabelle `books`
--

INSERT INTO `books` (`id`, `categoryId`, `title`, `author`, `isbn`, `price`) VALUES
(1, 1, 'Hello, Android: Introducing Google''s Mobile Development Platform', 'Ed Burnette', '9781934356562', 19.97),
(2, 1, 'Android Wireless Application Development', 'Shane Conder, Lauren Darcey', '0321743016', 31.22),
(5, 1, 'Professional Flash Mobile Development', 'Richard Wagner', '0470620072', 19.90),
(7, 1, 'Mobile Web Design For Dummies', 'Janine Warner, David LaFontaine', '9780470560969', 16.32),
(11, 2, 'Introduction to Functional Programming using Haskell', 'Richard Bird', '9780134843469', 74.75),
(12, 2, 'Scripting (Attacks) for Beginners - <script type="text/javascript">alert(''All your base are belong to us!'');</script>', 'John Doe', '1234567890', 9.99),
(14, 2, 'Expert F# (Expert''s Voice in .NET)', 'Antonio Cisternino, Adam Granicz, Don Syme', '9781590598504', 47.64),
(16, 3, 'C Programming Language (2nd Edition)', 'Brian W. Kernighan, Dennis M. Ritchie', '0131103628', 48.36),
(27, 3, 'C++ Primer Plus (5th Edition)', 'Stephan Prata', ' 9780672326974', 36.94),
(29, 3, 'The C++ Programming Language', 'Bjarne Stroustrup', '0201700735', 67.49);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Mobile & Wireless Computing'),
(2, 'Functional Programming'),
(3, 'C / C++'),
(4, '<< New Publications >>');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orderedbooks`
--

CREATE TABLE IF NOT EXISTS `orderedbooks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL,
  `bookId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orderId` (`orderId`),
  KEY `bookId` (`bookId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Daten für Tabelle `orderedbooks`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `creditCardNumber` char(16) NOT NULL,
  `creditCardHolder` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Daten für Tabelle `orders`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) NOT NULL,
  `passwordHash` char(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userName` (`userName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `userName`, `passwordHash`) VALUES
(1, 'scm4', 'a8af855d47d091f0376664fe588207f334cdad22');

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `orderedbooks`
--
ALTER TABLE `orderedbooks`
  ADD CONSTRAINT `orderedBooks_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderedBooks_ibfk_2` FOREIGN KEY (`bookId`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
