DROP TABLE IF EXISTS `m_gds_#system_code#`;
CREATE TABLE  `am5`.`m_gds` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Ma',
  `sponsor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `amount` varchar(45) NOT NULL,
  `wallet` varchar(45) NOT NULL,
  `issued_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `system_code` varchar(45) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Trang thai cua PD; Cho PD, PD thuc te.',
  `num_days_gd_approve` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'So ngay cho PD',
  `bank_id` int(10) unsigned NOT NULL,
  `num_days_gd_pending` int(10) unsigned NOT NULL,
  `num_days_gd_pending_verification` int(10) unsigned NOT NULL,
  `auto_set` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1: manual set, 2: auto set',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;