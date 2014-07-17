DROP TABLE IF EXISTS `TestModel`;
CREATE TABLE `TestModel` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `range` varchar(255) NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `TestModel` (`id`, `range`)
VALUES
  (1, '10|32'),
  (2, NULL);
