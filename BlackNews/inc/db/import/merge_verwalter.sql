-- ============================================================
-- Verwalter normalisieren (Sektion 27): Kombis splitten + Fuzzy-Merge
-- ============================================================
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

-- Kanon: Dr. Hubert Ampferl
INSERT INTO `drb26_mod_blackNewsTags` (`section_id`,`type`,`name`,`slug`)
VALUES (27, 'verwalter', 'Dr. Hubert Ampferl', 'dr-hubert-ampferl')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);
-- 'Dr. Hubert Ampferl' (tagID 3) -> 'Dr. Hubert Ampferl'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl'
WHERE et.`tagID` = 3
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- Kanon: Joachim Exner
INSERT INTO `drb26_mod_blackNewsTags` (`section_id`,`type`,`name`,`slug`)
VALUES (27, 'verwalter', 'Joachim Exner', 'joachim-exner')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);
-- 'Joachim Exner' (tagID 8) -> 'Joachim Exner'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner'
WHERE et.`tagID` = 8
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- 'Jachim Exner' (tagID 18) -> 'Joachim Exner'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner'
WHERE et.`tagID` = 18
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- Kanon: Dr. Ulf Pechartscheck
INSERT INTO `drb26_mod_blackNewsTags` (`section_id`,`type`,`name`,`slug`)
VALUES (27, 'verwalter', 'Dr. Ulf Pechartscheck', 'dr-ulf-pechartscheck')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);
-- 'Dr. Ulf Pechartscheck' (tagID 70) -> 'Dr. Ulf Pechartscheck'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-ulf-pechartscheck'
WHERE et.`tagID` = 70
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- 'Hubert Ampferl' (tagID 96) -> 'Dr. Hubert Ampferl'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl'
WHERE et.`tagID` = 96
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- Kanon: Michael Bauer
INSERT INTO `drb26_mod_blackNewsTags` (`section_id`,`type`,`name`,`slug`)
VALUES (27, 'verwalter', 'Michael Bauer', 'michael-bauer')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);
-- 'Michael Bauer' (tagID 101) -> 'Michael Bauer'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='michael-bauer'
WHERE et.`tagID` = 101
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- Kanon: Prof. Dr. Siegfried Beck
INSERT INTO `drb26_mod_blackNewsTags` (`section_id`,`type`,`name`,`slug`)
VALUES (27, 'verwalter', 'Prof. Dr. Siegfried Beck', 'prof-dr-siegfried-beck')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);
-- 'Joachim Exner, Prof. Dr. Siegfried Beck' (tagID 103) -> 'Joachim Exner'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner'
WHERE et.`tagID` = 103
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- 'Joachim Exner, Prof. Dr. Siegfried Beck' (tagID 103) -> 'Prof. Dr. Siegfried Beck'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck'
WHERE et.`tagID` = 103
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- 'Joachim Exner & Michael Bauer' (tagID 134) -> 'Joachim Exner'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner'
WHERE et.`tagID` = 134
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- 'Joachim Exner & Michael Bauer' (tagID 134) -> 'Michael Bauer'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='michael-bauer'
WHERE et.`tagID` = 134
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- Kanon: Mechthild Bruche
INSERT INTO `drb26_mod_blackNewsTags` (`section_id`,`type`,`name`,`slug`)
VALUES (27, 'verwalter', 'Mechthild Bruche', 'mechthild-bruche')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);
-- 'Mechthild Bruche' (tagID 161) -> 'Mechthild Bruche'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche'
WHERE et.`tagID` = 161
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- 'Dr. Hubert Ampferl & Dr. Ulf Pechartscheck' (tagID 172) -> 'Dr. Hubert Ampferl'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl'
WHERE et.`tagID` = 172
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- 'Dr. Hubert Ampferl & Dr. Ulf Pechartscheck' (tagID 172) -> 'Dr. Ulf Pechartscheck'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-ulf-pechartscheck'
WHERE et.`tagID` = 172
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- 'Joachim Exner & Dr. Hubert Ampferl' (tagID 210) -> 'Joachim Exner'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner'
WHERE et.`tagID` = 210
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- 'Joachim Exner & Dr. Hubert Ampferl' (tagID 210) -> 'Dr. Hubert Ampferl'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl'
WHERE et.`tagID` = 210
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- 'Prof. Dr. Siegfried Beck' (tagID 260) -> 'Prof. Dr. Siegfried Beck'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck'
WHERE et.`tagID` = 260
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- 'Prof. Dr. Siegfried Beck, Joachim Exner' (tagID 325) -> 'Prof. Dr. Siegfried Beck'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck'
WHERE et.`tagID` = 325
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;
-- 'Prof. Dr. Siegfried Beck, Joachim Exner' (tagID 325) -> 'Joachim Exner'
INSERT INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT et.`entryID`, t.`tagID`
FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsTags` t ON t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner'
WHERE et.`tagID` = 325
ON DUPLICATE KEY UPDATE `tagID`=`tagID`;

-- Alte verwalter-Tags entfernen (nach Umbiegen)
DELETE FROM `drb26_mod_blackNewsEntryTags` WHERE `tagID` = 3;
DELETE FROM `drb26_mod_blackNewsTags` WHERE `tagID` = 3 AND `type` = 'verwalter';
DELETE FROM `drb26_mod_blackNewsEntryTags` WHERE `tagID` = 8;
DELETE FROM `drb26_mod_blackNewsTags` WHERE `tagID` = 8 AND `type` = 'verwalter';
DELETE FROM `drb26_mod_blackNewsEntryTags` WHERE `tagID` = 18;
DELETE FROM `drb26_mod_blackNewsTags` WHERE `tagID` = 18 AND `type` = 'verwalter';
DELETE FROM `drb26_mod_blackNewsEntryTags` WHERE `tagID` = 70;
DELETE FROM `drb26_mod_blackNewsTags` WHERE `tagID` = 70 AND `type` = 'verwalter';
DELETE FROM `drb26_mod_blackNewsEntryTags` WHERE `tagID` = 96;
DELETE FROM `drb26_mod_blackNewsTags` WHERE `tagID` = 96 AND `type` = 'verwalter';
DELETE FROM `drb26_mod_blackNewsEntryTags` WHERE `tagID` = 101;
DELETE FROM `drb26_mod_blackNewsTags` WHERE `tagID` = 101 AND `type` = 'verwalter';
DELETE FROM `drb26_mod_blackNewsEntryTags` WHERE `tagID` = 103;
DELETE FROM `drb26_mod_blackNewsTags` WHERE `tagID` = 103 AND `type` = 'verwalter';
DELETE FROM `drb26_mod_blackNewsEntryTags` WHERE `tagID` = 134;
DELETE FROM `drb26_mod_blackNewsTags` WHERE `tagID` = 134 AND `type` = 'verwalter';
DELETE FROM `drb26_mod_blackNewsEntryTags` WHERE `tagID` = 161;
DELETE FROM `drb26_mod_blackNewsTags` WHERE `tagID` = 161 AND `type` = 'verwalter';
DELETE FROM `drb26_mod_blackNewsEntryTags` WHERE `tagID` = 172;
DELETE FROM `drb26_mod_blackNewsTags` WHERE `tagID` = 172 AND `type` = 'verwalter';
DELETE FROM `drb26_mod_blackNewsEntryTags` WHERE `tagID` = 210;
DELETE FROM `drb26_mod_blackNewsTags` WHERE `tagID` = 210 AND `type` = 'verwalter';
DELETE FROM `drb26_mod_blackNewsEntryTags` WHERE `tagID` = 260;
DELETE FROM `drb26_mod_blackNewsTags` WHERE `tagID` = 260 AND `type` = 'verwalter';
DELETE FROM `drb26_mod_blackNewsEntryTags` WHERE `tagID` = 325;
DELETE FROM `drb26_mod_blackNewsTags` WHERE `tagID` = 325 AND `type` = 'verwalter';

SET FOREIGN_KEY_CHECKS=1;