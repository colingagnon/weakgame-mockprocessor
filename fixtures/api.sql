SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
DROP TABLE IF EXISTS `transactions`;
DROP TABLE IF EXISTS `accounts`;
-- **24|because|MONEY|rest|57**
-- CREATE DATABASE IF NOT EXISTS mockprocessor;
-- CREATE USER 'mockprocessor'@'localhost' IDENTIFIED BY 'omgsosecretpass';
-- GRANT ALL PRIVILEGES ON mockprocessor . * TO 'mockprocessor'@'localhost';
-- FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(256) NOT NULL,
  `createdOn` datetime NOT NULL,
  `accountLimit` float(10,2) NOT NULL default 5000.00,
  `accountBalance` float(10,2) NOT NULL default 0.00,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

INSERT INTO `accounts` (`id`, `email`, `createdOn`, `accountLimit`, `accountBalance`) VALUES
  (1, 'gagnon.colin@gmail.com', now(), 5000.00, 100.00);

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `accountId` int(11) unsigned NOT NULL,
  `amount` float(10,2) NOT NULL default 0.00,
  `createdOn` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_ibfk_1` (`accountId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `transactions` (`id`, `accountId`, `amount`, `createdOn`) VALUES
  (1, 1, 100.00, now());

ALTER TABLE `transactions`
ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `accounts` (`id`);