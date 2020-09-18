CREATE TABLE IF NOT EXISTS `#__diariooficial_diarios` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL DEFAULT 1,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00",
`created_by` INT(11)  NOT NULL ,
`modified_by` INT(11)  NOT NULL ,
`edicao` VARCHAR(255)  NOT NULL ,
`data` DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00",
`texto` LONGTEXT NOT NULL ,
`downloads` VARCHAR(255)  NOT NULL ,
`arquivo` TEXT NOT NULL ,
`imagem` TEXT NOT NULL ,
`url` VARCHAR(255)  NOT NULL ,
`destaque` BOOLEAN NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8mb4_unicode_ci;


INSERT INTO `#__content_types` (`type_title`, `type_alias`, `table`, `content_history_options`)
SELECT * FROM ( SELECT 'Diario','com_diariooficial.diario','{"special":{"dbtable":"#__diariooficial_diarios","key":"id","type":"Diario","prefix":"DiariooficialTable"}}', '{"formFile":"administrator\/components\/com_diariooficial\/models\/forms\/diario.xml", "hideFields":["checked_out","checked_out_time","params","language" ,"imagem"], "ignoreChanges":["modified_by", "modified", "checked_out", "checked_out_time"], "convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"catid","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"group_id","targetTable":"#__usergroups","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"created_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_by","targetTable":"#__users","targetColumn":"id","displayColumn":"name"}]}') AS tmp
WHERE NOT EXISTS (
	SELECT type_alias FROM `#__content_types` WHERE (`type_alias` = 'com_diariooficial.diario')
) LIMIT 1;
