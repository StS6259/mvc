CREATE TABLE `member_ips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `member_ips_id_uindex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1