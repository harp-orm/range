DROP TABLE IF EXISTS `TestModel`;
CREATE TABLE `TestModel` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `days` varchar(255) NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `TestModel` (`id`, `days`)
VALUES
  (1, '10|32'),
  (2, NULL);
