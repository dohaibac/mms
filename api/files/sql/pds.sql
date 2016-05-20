CREATE TABLE  `m_pds_#system_code#` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'Ma',
  `sponsor` varchar(255) CHARACTER SET utf8 NOT NULL,
  `amount` varchar(45) NOT NULL,
  `remain_amount` varchar(45) NOT NULL,
  `issued_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `system_code` varchar(45) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Trang thai cua PD; Cho PD, PD thuc te.',
  `num_days_pending` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'So ngay cho PD',
  `num_days_transfer` int(10) unsigned NOT NULL COMMENT 'Thoi gian cho tranfer',
  `bank_id` int(10) unsigned NOT NULL,
  `auto_set` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1: manual set, 2: autoset',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;