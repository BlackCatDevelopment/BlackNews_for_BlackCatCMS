-- --------------------------------------------------------
-- Please note:
-- The table prefix (cat_) will be replaced by the
-- installer! Do NOT use this file to create the tables
-- manually! (Or patch it to fit your needs first.)
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

DROP TABLE IF EXISTS
	`:prefix:mod_blackNewsForm`,
	`:prefix:mod_blackNewsOptions`,
	`:prefix:mod_blackNewsEntryOptions`,
	`:prefix:mod_blackNewsEntry`;

CREATE TABLE IF NOT EXISTS `:prefix:mod_blackNewsEntry` (
	`entryID` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`section_id` int(11) NOT NULL DEFAULT 0,
	`title` varchar(2047) NOT NULL DEFAULT '',
	`content` text NULL,
	`text` text NULL,
	`modified` DATETIME NULL DEFAULT NULL,
	`created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`publishDate` DATETIME NULL DEFAULT NULL,
	`unpublishDate` DATETIME NULL DEFAULT NULL,
	`userID` int(11) unsigned NULL,
	`seoURL` varchar(255) NOT NULL DEFAULT '',
	`position` int(11) unsigned NULL DEFAULT 1,
	`publish` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`entryID`),
	CONSTRAINT `:prefix:bN_User` FOREIGN KEY (`userID`) REFERENCES `:prefix:users`(`user_id`) ON DELETE CASCADE,
	CONSTRAINT `:prefix:bN_sections` FOREIGN KEY (`section_id`) REFERENCES `:prefix:sections`(`section_id`) ON DELETE CASCADE
) COMMENT='Main table for BlackNews'
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE='utf8_general_ci';


CREATE TABLE IF NOT EXISTS `:prefix:mod_blackNewsOptions` (
	`section_id` int(11) NOT NULL DEFAULT 0,
	`name` varchar(255) NOT NULL DEFAULT '',
	`value` TEXT DEFAULT '',
	PRIMARY KEY (`section_id`, `name`),
	CONSTRAINT `:prefix:bN_Options` FOREIGN KEY (`section_id`) REFERENCES `:prefix:sections`(`section_id`) ON DELETE CASCADE
) COMMENT='Options for BlackNews'
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE='utf8_general_ci';

CREATE TABLE IF NOT EXISTS `:prefix:mod_blackNewsEntryOptions` (
	`entryID` int(11) unsigned NOT NULL,
	`name` varchar(255) NOT NULL DEFAULT '',
	`value` TEXT DEFAULT '',
	PRIMARY KEY (`entryID`, `name`),
	CONSTRAINT `:prefix:bN_entrOpt` FOREIGN KEY (`entryID`) REFERENCES `:prefix:mod_blackNewsEntry`(`entryID`) ON DELETE CASCADE
) COMMENT='Options for BlackNews Entries'
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE='utf8_general_ci';


CREATE TRIGGER `:prefix:bNEntrIn` BEFORE INSERT ON `:prefix:mod_blackNewsEntry` FOR EACH ROW 
SET NEW.position = (
	SELECT MAX(position)+1 AS position
	FROM `:prefix:mod_blackNewsEntry`
	WHERE section_id = NEW.section_id
);

CREATE TRIGGER `:prefix:bNEntrOptUp` BEFORE UPDATE ON `:prefix:mod_blackNewsEntryOptions`
	FOR EACH ROW
		UPDATE `:prefix:mod_blackNewsEntry`
			SET `modified` = CURRENT_TIMESTAMP
			WHERE `entryID` = NEW.entryID;



CREATE TABLE IF NOT EXISTS `:prefix:mod_blackNewsCategory` (
	`catID` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`section_id` int(11) NOT NULL DEFAULT 0,
	`category` varchar(255) NOT NULL DEFAULT '',
	`url` varchar(255) NOT NULL DEFAULT '',
	PRIMARY KEY (`catID` ),
	UNIQUE INDEX `:prefix:secIDurl` (`section_id`,`url`),
	CONSTRAINT `:prefix:bN_CatSec` FOREIGN KEY (`section_id`) REFERENCES `:prefix:sections`(`section_id`) ON DELETE CASCADE
) COMMENT='Categories for BlackNews'
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE='utf8_general_ci';


CREATE TABLE IF NOT EXISTS `:prefix:mod_blackNewsCategoryEntries` (
	`catID` int(11) unsigned NOT NULL,
	`entryID` int(11) unsigned NOT NULL,
	PRIMARY KEY (`catID`, `entryID`),
	CONSTRAINT `:prefix:bN_CatcatID` FOREIGN KEY (`catID`) REFERENCES `:prefix:mod_blackNewsCategory`(`catID`) ON DELETE CASCADE,
	CONSTRAINT `:prefix:bN_CatEntry` FOREIGN KEY (`entryID`) REFERENCES `:prefix:mod_blackNewsEntry`(`entryID`) ON DELETE CASCADE
) COMMENT='Interconnection for BlackNews Entries and Categories'
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE='utf8_general_ci';






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
	CONSTRAINT `:prefix:bN_entrForm` FOREIGN KEY (`entryID`) REFERENCES `:prefix:mod_blackNewsEntry`(`entryID`) ON DELETE CASCADE
) COMMENT='Fields for BlackNews Form'
ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE='utf8_general_ci';


CREATE TRIGGER `:prefix:bN_Form` BEFORE INSERT ON `:prefix:mod_blackNewsForm` FOR EACH ROW 
SET NEW.position = (
SELECT CASE
		WHEN (MAX(position) IS NULL) THEN 1
		ELSE MAX(position)+1
	END AS position
FROM `:prefix:mod_blackNewsForm` WHERE entryID = NEW.entryID)


/*
	$insert_search = CAT_Helper_Page::getInstance()->db()->query( sprintf(
			"SELECT * FROM `%ssearch`
				WHERE `value` = '%s'",
			CAT_TABLE_PREFIX,
			'cc_multicolumn'
		)
	);
	if( $insert_search->numRows() == 0 )
	{
		// Insert info into the search table
		// Module query info
		$field_info = array(
			'page_id'			=> 'page_id',
			'title'				=> 'page_title',
			'link'				=> 'link',
			'description'		=> 'description',
			'modified_when'		=> 'modified_when',
			'modified_by'		=> 'modified_by'
		);

		$field_info = serialize($field_info);

		CAT_Helper_Page::getInstance()->db()->query( sprintf(
				"INSERT INTO `%ssearch`
					( `name`, `value`, `extra` ) VALUES
					( 'module', 'cc_multicolumn', '%s' )",
				CAT_TABLE_PREFIX,
				$field_info
			)
		);
		// Query start
		$query_start_code = "SELECT [TP]pages.page_id, [TP]pages.page_title, [TP]pages.link, [TP]pages.description, [TP]pages.modified_when, [TP]pages.modified_by FROM [TP]mod_blackNewsContent, [TP]pages WHERE ";

		CAT_Helper_Page::getInstance()->db()->query( sprintf(
				"INSERT INTO `%ssearch`
					( `name`, `value`, `extra` ) VALUES
					( 'query_start', '%s', '%s' )",
				CAT_TABLE_PREFIX,
				$query_start_code,
				'cc_multicolumn'
			)
		);
		// Query body
		$query_body_code = " [TP]pages.page_id = [TP]mod_blackNewsContent.page_id AND [TP]mod_blackNewsContent.text [O] \'[W][STRING][W]\' AND [TP]pages.searching = \'1\'";

		CAT_Helper_Page::getInstance()->db()->query( sprintf(
				"INSERT INTO `%ssearch`
					( `name`, `value`, `extra` ) VALUES
					( 'query_body', '%s', '%s' )",
				CAT_TABLE_PREFIX,
				$query_body_code,
				'mod_blackNewsContent'
			)
		);

		// Query end
		$query_end_code = "";
		CAT_Helper_Page::getInstance()->db()->query( sprintf(
				"INSERT INTO `%ssearch`
					( `name`, `value`, `extra` ) VALUES
					( 'query_end', '%s', '%s' )",
				CAT_TABLE_PREFIX,
				$query_end_code,
				'mod_blackNewsContent'
			)
		);


		// Insert blank row (there needs to be at least on row for the search to work)
		CAT_Helper_Page::getInstance()->db()->query( sprintf(
				"INSERT INTO `%smod_blackNewsContent`
					( `page_id`, `section_id`, `content`, `text` ) VALUES
					( '0', '0', '', '' )",
				CAT_TABLE_PREFIX
			)
		);
	}
	// add files to class_secure
	$addons_helper = new CAT_Helper_Addons();
	foreach(
		array(
			'save.php'
		)
		as $file
	) {
		if ( false === $addons_helper->sec_register_file( 'cc_multicolumn', $file ) )
		{
			 error_log( "Unable to register file -$file-!" );
		}
	}
*/


/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;