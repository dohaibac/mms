CREATE TABLE `m_gdex_06` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sponsor` varchar(255) NOT NULL COMMENT 'Ma',
  `created_at` datetime NOT NULL COMMENT 'Thời gian đăng ký',
  `created_by` int(10) unsigned NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1: da xac nhan; 0: chua xac nhan',
  `system_code` varchar(45) NOT NULL,
  `gd_id` int(10) unsigned NOT NULL,
  `amount` varchar(45) DEFAULT NULL COMMENT 'goc + lai tinh',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;