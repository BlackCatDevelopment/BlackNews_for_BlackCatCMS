-- --------------------------------------------------------
-- Please note:
-- The table prefix (cat_) will be replaced by the
-- installer! Do NOT use this file to create the tables
-- manually! (Or patch it to fit your needs first.)
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

CREATE TABLE IF NOT EXISTS `:prefix:mod_blackNewsForm` (
	`fieldID` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`entryID` int(11) unsigned NOT NULL,
	`name` varchar(64) NOT NULL DEFAULT '',
	`type` tinyint(1) unsigned NOT NULL DEFAULT 1,
	`require` boolean NULL DEFAULT false,
	`values` varchar(2047) NOT NULL DEFAULT '',
	`placeholder` varchar(512) NOT NULL DEFAULT '',
	`width` tinyint(1) unsigned NOT NULL  DEFAULT 1,
	`position` int(11) unsigned NOT NULL DEFAULT 1,
	PRIMARY KEY ( `fieldID` ),
	CONSTRAINT `entryForm` FOREIGN KEY (`entryID`) REFERENCES `:prefix:mod_blackNewsEntry`(`entryID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TRIGGER `blackNewsForm` BEFORE INSERT ON `:prefix:mod_blackNewsForm` FOR EACH ROW 
SET NEW.position = (
SELECT CASE
		WHEN (MAX(position) IS NULL) THEN 1
		ELSE MAX(position)+1
	END AS position
FROM `:prefix:mod_blackNewsForm` WHERE entryID = NEW.entryID)

