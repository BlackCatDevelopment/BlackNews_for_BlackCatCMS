-- ============================================================
-- REPARATUR: Verwalter-Tags nach dem Merge wieder aufbauen
-- (Quelle: alter Dump vor dem Merge; Kombis splitten, Fuzzy-Merge)
-- ============================================================
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

-- Kanon: Dr. Hubert Ampferl
INSERT INTO `drb26_mod_blackNewsTags` (`section_id`,`type`,`name`,`slug`)
VALUES (27, 'verwalter', 'Dr. Hubert Ampferl', 'dr-hubert-ampferl')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);
-- Kanon: Dr. Ulf Pechartscheck
INSERT INTO `drb26_mod_blackNewsTags` (`section_id`,`type`,`name`,`slug`)
VALUES (27, 'verwalter', 'Dr. Ulf Pechartscheck', 'dr-ulf-pechartscheck')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);
-- Kanon: Joachim Exner
INSERT INTO `drb26_mod_blackNewsTags` (`section_id`,`type`,`name`,`slug`)
VALUES (27, 'verwalter', 'Joachim Exner', 'joachim-exner')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);
-- Kanon: Mechthild Bruche
INSERT INTO `drb26_mod_blackNewsTags` (`section_id`,`type`,`name`,`slug`)
VALUES (27, 'verwalter', 'Mechthild Bruche', 'mechthild-bruche')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);
-- Kanon: Michael Bauer
INSERT INTO `drb26_mod_blackNewsTags` (`section_id`,`type`,`name`,`slug`)
VALUES (27, 'verwalter', 'Michael Bauer', 'michael-bauer')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);
-- Kanon: Prof. Dr. Siegfried Beck
INSERT INTO `drb26_mod_blackNewsTags` (`section_id`,`type`,`name`,`slug`)
VALUES (27, 'verwalter', 'Prof. Dr. Siegfried Beck', 'prof-dr-siegfried-beck')
ON DUPLICATE KEY UPDATE `name`=VALUES(`name`);

INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1105, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1106, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1107, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1108, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1109, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1110, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1111, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1112, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1113, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1114, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1115, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1116, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1117, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1118, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1119, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1120, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1121, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1122, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1123, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1124, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1125, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1126, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1127, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1128, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1129, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1130, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1131, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1132, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1133, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1134, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1135, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1136, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1137, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1138, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1139, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1140, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1141, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1142, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1143, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1144, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1145, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1146, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1147, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1148, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1149, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1150, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1151, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1152, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1153, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1154, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1155, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1156, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1157, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1158, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1159, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1160, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1161, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1162, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1163, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1164, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1165, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1166, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1167, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1168, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1169, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-ulf-pechartscheck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1170, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1171, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1172, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1173, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1174, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1175, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1176, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1177, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1178, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1179, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1180, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1181, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1182, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1183, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1184, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1185, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1186, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1187, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1188, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1189, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1190, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1191, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1192, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1193, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1194, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1195, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1196, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1197, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1198, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1199, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1200, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='michael-bauer';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1201, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1201, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1202, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1202, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1203, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1203, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1204, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1205, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='michael-bauer';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1206, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1207, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1208, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1209, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1210, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='michael-bauer';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1211, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1212, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1213, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1214, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1215, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1216, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1217, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1218, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1219, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1220, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1221, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1222, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1223, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1224, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1225, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1226, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1227, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1228, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1229, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1230, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1231, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1232, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1233, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1234, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1235, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1236, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1237, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1238, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1239, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1240, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1241, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1241, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='michael-bauer';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1242, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1243, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1244, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1245, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1246, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1247, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1248, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1249, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1250, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1251, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1252, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1253, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1254, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1255, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1256, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1257, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1258, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1259, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1260, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1261, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1262, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1263, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1264, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1265, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1266, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1267, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1268, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1269, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1270, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1271, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1272, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1273, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1274, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1275, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1276, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1276, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-ulf-pechartscheck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1277, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1278, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1279, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1280, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1281, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1282, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1282, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-ulf-pechartscheck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1283, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1284, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1285, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1286, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1287, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1288, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1289, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1290, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1291, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1292, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1293, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1294, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1295, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1296, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1297, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1298, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1299, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1300, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1301, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1302, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1303, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1304, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1305, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1306, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1307, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1308, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1309, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1310, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1311, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1312, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1313, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1314, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1315, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1316, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1317, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1318, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1318, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1320, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1321, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1322, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1323, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1324, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1325, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1326, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1327, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1328, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1329, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1330, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1331, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1332, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1333, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1334, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1335, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1336, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1337, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1338, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1339, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1340, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1341, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1342, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1343, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1344, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1345, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1346, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1347, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1348, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1349, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1350, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1351, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1352, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1353, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1354, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1355, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1356, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1357, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1358, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1359, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1360, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1361, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1362, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1363, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1364, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1365, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1366, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1367, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1368, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1369, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1370, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1371, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1372, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1373, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1374, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1375, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1376, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1377, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1378, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1379, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1380, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1381, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1382, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1382, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1383, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1384, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1385, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1386, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1387, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1388, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1389, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1390, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1391, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1391, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1392, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1393, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1393, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1394, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1395, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1396, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1397, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1398, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1399, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1400, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1401, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1402, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1403, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1404, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1405, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1406, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1407, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1408, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1409, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1410, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1411, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1411, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1412, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1412, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1413, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1414, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1415, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1416, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1417, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1418, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1419, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1419, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1420, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1421, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1422, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1423, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1423, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1424, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1425, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1425, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1426, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1427, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1428, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1430, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1431, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1431, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1432, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1433, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1434, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1435, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1436, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1437, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1438, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1439, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1440, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1441, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1442, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1443, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1444, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1444, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1445, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1445, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1446, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1447, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1448, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1449, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1451, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1452, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1453, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1454, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1455, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1456, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1457, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1458, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1459, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1459, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1460, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1461, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1461, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1462, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1462, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1463, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1463, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1464, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1465, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1466, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1466, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1467, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1467, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1468, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1468, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1469, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1469, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1470, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1470, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1471, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1471, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1472, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1472, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1473, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1473, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1474, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1475, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1476, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1477, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1478, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1479, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1480, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1481, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1482, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1483, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1484, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1485, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1486, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1487, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1488, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1489, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1490, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1491, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1492, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1493, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1494, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1495, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1496, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1497, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1498, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1499, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1500, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1501, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1502, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1503, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1504, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1505, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1505, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1506, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1507, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1508, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1509, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1510, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1511, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1512, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1512, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1513, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1514, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1515, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1516, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1516, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1517, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1517, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1518, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1519, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1520, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1521, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1522, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1523, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1524, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1525, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1526, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1527, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1528, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1529, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1530, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1531, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1532, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1533, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1534, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1534, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1535, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1536, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1537, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1538, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1539, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1540, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1541, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1542, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1543, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1543, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1544, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1545, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1546, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1547, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1548, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1549, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1550, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1551, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1552, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1553, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1554, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1555, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1556, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1557, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1558, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1559, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1560, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1561, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1562, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1563, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1564, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1565, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1566, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1567, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1568, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1569, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1570, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1571, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1572, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1573, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1574, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1575, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1576, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1577, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1578, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1579, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1580, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1581, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1582, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1583, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1584, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1585, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1586, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1587, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1588, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1589, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1590, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1591, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1592, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1593, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1594, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1595, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1596, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1597, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1598, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1599, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1600, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1601, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1602, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1603, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1604, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1605, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1606, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1607, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1608, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1609, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1610, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1611, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1612, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1613, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='mechthild-bruche';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1614, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1615, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1616, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1617, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1618, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1619, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1620, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1621, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1622, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1623, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1624, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1625, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1626, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1627, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1628, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1629, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1630, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1631, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1632, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1633, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1634, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1635, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1636, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1637, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1638, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1639, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1640, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1641, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='dr-hubert-ampferl';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1642, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1643, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1644, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1645, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1646, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1647, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1648, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1649, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1650, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1651, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='prof-dr-siegfried-beck';
INSERT IGNORE INTO `drb26_mod_blackNewsEntryTags` (`entryID`,`tagID`)
SELECT 1652, t.`tagID` FROM `drb26_mod_blackNewsTags` t
WHERE t.`section_id`=27 AND t.`type`='verwalter' AND t.`slug`='joachim-exner';

SET FOREIGN_KEY_CHECKS=1;