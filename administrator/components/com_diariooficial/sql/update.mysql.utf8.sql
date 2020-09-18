
INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Diario','com_diariooficial.diario','{"special":{"dbtable":"#__diariooficial_diarios","key":"id","type":"Diario","prefix":"DiariooficialTable"}}', '{"formFile":"administrator\/components\/com_diariooficial\/models\/forms\/diario.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"imagem"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_diariooficial.diario')
) LIMIT 1;

UPDATE `#__content_types` SET
	`type_title` = 'Diario', 
	`table` = '{"special":{"dbtable":"#__diariooficial_diarios","key":"id","type":"Diario","prefix":"DiariooficialTable"}}', 
	`content_history_options` = '{"formFile":"administrator\/components\/com_diariooficial\/models\/forms\/diario.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"imagem"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}'
WHERE (`type_alias` = 'com_diariooficial.diario');
