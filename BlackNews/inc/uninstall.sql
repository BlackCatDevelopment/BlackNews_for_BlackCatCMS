-- --------------------------------------------------------
-- Please note:
-- The table prefix (cat_) will be replaced by the
-- installer! Do NOT use this file to create the tables
-- manually! (Or patch it to fit your needs first.)
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


DROP TRIGGER IF EXISTS `blackNewsEntryInsert`;
DROP TRIGGER IF EXISTS `blackNewsEntryUpdate`;
DROP TRIGGER IF EXISTS `blackNewsEntryOptionsUpdate`;

DROP TABLE IF EXISTS `:prefix:mod_blackNewsOptions`;
DROP TABLE IF EXISTS `:prefix:mod_blackNewsEntryOptions`;
DROP TABLE IF EXISTS `:prefix:mod_blackNewsEntry`;
DROP TABLE IF EXISTS `:prefix:mod_blackNews`;












DROP TRIGGER IF EXISTS `blackNewsForm`;
DROP TABLE IF EXISTS `:prefix:mod_blackNewsForm`;