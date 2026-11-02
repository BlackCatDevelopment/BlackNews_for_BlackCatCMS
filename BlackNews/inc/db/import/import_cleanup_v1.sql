-- ============================================================
-- Cleanup nach dem fehlerhaften v1-Import (Trigger hatte position
-- ueberschrieben, daher sind Verknuepfungen leer/falsch).
-- VORHER pruefen:  SELECT MIN(entryID), MAX(entryID) FROM `drb26_mod_blackNewsEntry` WHERE `section_id` = 27;
--                 SELECT COUNT(*) FROM `drb26_mod_blackNewsEntry` WHERE `section_id` = 27 AND `entryID` >= 606;
-- ============================================================
SET FOREIGN_KEY_CHECKS=0;
-- Verknuepfungen der importierten Eintraege loeschen
DELETE ce FROM `drb26_mod_blackNewsCategoryEntries` ce
JOIN `drb26_mod_blackNewsEntry` e ON e.`entryID` = ce.`entryID`
WHERE e.`section_id` = 27 AND e.`entryID` >= 606;

DELETE et FROM `drb26_mod_blackNewsEntryTags` et
JOIN `drb26_mod_blackNewsEntry` e ON e.`entryID` = et.`entryID`
WHERE e.`section_id` = 27 AND e.`entryID` >= 606;

DELETE eo FROM `drb26_mod_blackNewsEntryOptions` eo
JOIN `drb26_mod_blackNewsEntry` e ON e.`entryID` = eo.`entryID`
WHERE e.`section_id` = 27 AND e.`entryID` >= 606;

-- importierte Eintraege selbst loeschen (entryID ab 606 = Beginn des Imports)
DELETE FROM `drb26_mod_blackNewsEntry`
WHERE `section_id` = 27 AND `entryID` >= 606;

-- Tags der Sektion 27 loeschen (werden von v2 neu angelegt)
DELETE FROM `drb26_mod_blackNewsTags` WHERE `section_id` = 27;

SET FOREIGN_KEY_CHECKS=1;
