-- --------------------------------------------------------
-- 
-- ,-----.  ,--.              ,--.    ,-----.          ,--.       ,-----.,--.   ,--. ,---.   
-- |  |) /_ |  | ,--,--. ,---.|  |,-.'  .--./ ,--,--.,-'  '-.    '  .--./|   `.'   |'   .-'  
-- |  .-.  \|  |' ,-.  || .--'|     /|  |    ' ,-.  |'-.  .-'    |  |    |  |'.'|  |`.  `-.  
-- |  '--' /|  |\ '-'  |\ `--.|  \  \'  '--'\\ '-'  |  |  |      '  '--'\|  |   |  |.-'    | 
-- `------' `--' `--`--' `---'`--'`--'`-----' `--`--'  `--'       `-----'`--'   `--'`-----'  
-- 
--   This program is free software; you can redistribute it and/or modify
--   it under the terms of the GNU General Public License as published by
--   the Free Software Foundation; either version 3 of the License, or (at
--   your option) any later version.
-- 
--   This program is distributed in the hope that it will be useful, but
--   WITHOUT ANY WARRANTY; without even the implied warranty of
--   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
--   General Public License for more details.
-- 
--   You should have received a copy of the GNU General Public License
--   along with this program; if not, see <http://www.gnu.org/licenses/>.
-- 
--   @author			Matthias Glienke
--   @copyright			2018, Black Cat Development
--   @link				http://blackcat-cms.org
--   @license			http://www.gnu.org/licenses/gpl.html
--   @category			CAT_Modules
--   @package			blackNews
-- 
-- 
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


DROP TRIGGER IF EXISTS `:prefix:bNEntrIn`;
DROP TRIGGER IF EXISTS `:prefix:bNEntrOptUp`;
DROP TRIGGER IF EXISTS `:prefix:mod_blackNewsCategory`;
DROP TRIGGER IF EXISTS `:prefix:mod_blackNewsCategoryEntries`;


DROP TABLE IF EXISTS `:prefix:mod_blackNewsCategoryEntries`;
DROP TABLE IF EXISTS `:prefix:mod_blackNewsCategory`;

DROP TABLE IF EXISTS `:prefix:mod_blackNewsEntryOptions`;
DROP TABLE IF EXISTS `:prefix:mod_blackNewsOptions`;
DROP TABLE IF EXISTS `:prefix:mod_blackNewsEntry`;
DROP TABLE IF EXISTS `:prefix:mod_blackNews`;