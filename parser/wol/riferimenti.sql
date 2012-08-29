DROP TABLE IF EXISTS `riferimenti`;
CREATE TABLE `riferimenti` (
  `id_riferimento` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `id_lang` smallint(5) unsigned NOT NULL,
  `id_versetto` smallint(5) unsigned NOT NULL,
  `offset` smallint(5) unsigned NOT NULL COMMENT 'SPAZI bianchi dall''inizio',
  `cosa` tinyint(3) unsigned NOT NULL,
  `text` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_riferimento`),
  UNIQUE KEY `id_lang` (`id_versetto`,`id_lang`,`offset`,`cosa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

