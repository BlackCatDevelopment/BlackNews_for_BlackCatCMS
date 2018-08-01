-- --------------------------------------------------------
-- Please note:
-- The table prefix (cat_) will be replaced by the
-- installer! Do NOT use this file to create the tables
-- manually! (Or patch it to fit your needs first.)
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;



CREATE TABLE IF NOT EXISTS `:prefix:mod_blackNews` (
	`bnID` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`page_id` int(11) NOT NULL,
	`section_id` int(11) NOT NULL,
	PRIMARY KEY (`bnID`),
	CONSTRAINT `pages` FOREIGN KEY (`page_id`) REFERENCES `:prefix:pages`(`page_id`) ON DELETE CASCADE,
	CONSTRAINT `sections` FOREIGN KEY (`section_id`) REFERENCES `:prefix:sections`(`section_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `:prefix:mod_blackNewsEntry` (
	`entryID` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`bnID` int(11) unsigned NOT NULL,
	`title` text NULL,
	`content` text NULL,
	`text` text NULL,
	`modified` DATETIME NULL,
	`created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	`publishDate` DATETIME NULL,
	`unpublishDate` DATETIME NULL,
	`userID` int(11) unsigned NULL,
	`seoURL` varchar(255) NOT NULL DEFAULT '',
	`position` int(11) unsigned NULL DEFAULT '1',
	`publish` DATETIME NULL,
	PRIMARY KEY (`entryID`),
	CONSTRAINT `blackNews` FOREIGN KEY (`bnID`) REFERENCES `:prefix:mod_blackNews`(`bnID`) ON DELETE CASCADE,
	CONSTRAINT `user` FOREIGN KEY (`userID`) REFERENCES `:prefix:users`(`user_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `:prefix:mod_blackNewsOptions` (
	`bnID` int(11) unsigned NOT NULL,
	`name` varchar(255) NOT NULL DEFAULT '',
	`value` text NULL,
	PRIMARY KEY (`bnID`, `name`),
	CONSTRAINT `blackNewsOptions` FOREIGN KEY (`bnID`) REFERENCES `:prefix:mod_blackNews`(`bnID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `:prefix:mod_blackNewsEntryOptions` (
	`entryID` int(11) unsigned NOT NULL,
	`name` varchar(255) NOT NULL DEFAULT '',
	`value` varchar(2047) NOT NULL DEFAULT '',
	PRIMARY KEY (`entryID`, `name`),
	CONSTRAINT `entryOptions` FOREIGN KEY (`entryID`) REFERENCES `:prefix:mod_blackNewsEntry`(`entryID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Is implemented in the class
-- CREATE TRIGGER `blackNewsEntryInsert` BEFORE INSERT ON `:prefix:mod_blackNewsEntry` FOR EACH ROW 
-- SET NEW.position = (
-- 	SELECT MAX(position)+1 AS position
-- 	FROM `:prefix:mod_blackNewsEntry`
-- 	WHERE bnID = NEW.bnID
-- );

CREATE TRIGGER `blackNewsEntryOptionsUpdate` BEFORE UPDATE ON `:prefix:mod_blackNewsEntryOptions`
	FOR EACH ROW
		UPDATE `:prefix:mod_blackNewsEntry`
			SET `modified` = CURRENT_TIMESTAMP
			WHERE `entryID` = NEW.entryID;











/*

CREATE TABLE IF NOT EXISTS `:prefix:mod_blackNewsForm` (
	`fieldID` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`entryID` int(11) unsigned NOT NULL,
	`name` varchar(64) NOT NULL DEFAULT '',
	`type` tinyint(1) unsigned NOT NULL DEFAULT 1,
	`required` boolean NULL DEFAULT false,
	`value` varchar(2047) NOT NULL DEFAULT '',
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