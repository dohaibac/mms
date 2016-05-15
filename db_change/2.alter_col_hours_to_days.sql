ALTER TABLE `m_pds` CHANGE COLUMN `num_hours_transfer` `num_days_transfer` INT(10) UNSIGNED NOT NULL COMMENT 'Thoi gian cho tranfer';
ALTER TABLE `m_gds` CHANGE COLUMN `num_hours_gd_approve` `num_days_gd_approve` INT(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'So ngay cho PD',
 ADD COLUMN `num_days_gd_pending` INTEGER UNSIGNED NOT NULL AFTER `bank_id`,
 ADD COLUMN `num_days_gd_pending_verification` INTEGER UNSIGNED NOT NULL AFTER `num_days_gd_pending`;