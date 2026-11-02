-- --------------------------------------------------------
-- Please note:
-- The table prefix (cat_) will be replaced by the
-- installer! Do NOT use this file to create the tables
-- manually! (Or patch it to fit your needs first.)
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;



DROP TRIGGER IF EXISTS `:prefix:bNEntrIn`;
DROP TRIGGER IF EXISTS `:prefix:bNEntrOptUp`;
DROP TRIGGER IF EXISTS `:prefix:blackNewsForm`;

DROP TABLE IF EXISTS
`:prefix:mod_blackNewsForm`,
`:prefix:mod_blackNewsEntryTags`,
`:prefix:mod_blackNewsTags`,
`:prefix:mod_blackNewsCategoryEntries`,
`:prefix:mod_blackNewsCategory`,
`:prefix:mod_blackNewsOptions`,
`:prefix:mod_blackNewsEntryOptions`,
`:prefix:mod_blackNewsEntry`;
