CREATE TABLE `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

CREATE TABLE `todolist` (
  `listID` int(11) NOT NULL AUTO_INCREMENT,
  `listName` varchar(45) NOT NULL,
  `dateCreated` varchar(45) NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY (`listID`),
  KEY `userID_idx` (`userID`),
  CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;

CREATE TABLE `todolistItem` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `listID` int(11) NOT NULL,
  `item` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`itemID`),
  KEY `listID_idx` (`listID`),
  CONSTRAINT `listID` FOREIGN KEY (`listID`) REFERENCES `todolist` (`listID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=latin1;

CREATE TABLE `categories` (
  `catID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `detail` varchar(225) DEFAULT NULL,
  `dateCreated` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`catID`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

CREATE TABLE `topics` (
  `topicID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `detail` varchar(225) NOT NULL,
  `dateCreated` varchar(45) NOT NULL,
  `userID_FK` int(11) NOT NULL,
  `catID_FK` int(11) NOT NULL,
  PRIMARY KEY (`topicID`),
  KEY `userID_FK_idx` (`userID_FK`),
  KEY `catID_FK_idx` (`catID_FK`),
  CONSTRAINT `userID_FK` FOREIGN KEY (`userID_FK`) REFERENCES `users` (`userID`) ON UPDATE CASCADE,
  CONSTRAINT `catID_FK` FOREIGN KEY (`catID_FK`) REFERENCES `categories` (`catID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=latin1;

CREATE TABLE `replies` (
  `replyID` int(11) NOT NULL AUTO_INCREMENT,
  `comment` varchar(45) DEFAULT NULL,
  `dateCreated` varchar(225) DEFAULT NULL,
  `userID_FK` int(11) DEFAULT NULL,
  `topicID_FK` int(11) DEFAULT NULL,
  PRIMARY KEY (`replyID`),
  KEY `userID_FK_idx` (`userID_FK`),
  KEY `topicID_FK_idx` (`topicID_FK`),
  CONSTRAINT `topicID_FK_idx` FOREIGN KEY (`topicID_FK`) REFERENCES `topics` (`topicID`) ON UPDATE CASCADE,
  CONSTRAINT `userID_FK_idx` FOREIGN KEY (`userID_FK`) REFERENCES `users` (`userID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1168 DEFAULT CHARSET=latin1;

CREATE TABLE `employees` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `address_street` varchar(45) NOT NULL,
  `address_city` varchar(45) NOT NULL,
  `address_state` varchar(45) NOT NULL,
  `address_zip` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL DEFAULT '123',
  `job_title` varchar(45) NOT NULL,
  `salary` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
