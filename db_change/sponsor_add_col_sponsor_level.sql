ALTER TABLE `m_sponsor` ADD COLUMN `sponsor_level` VARCHAR(45) NOT NULL DEFAULT 'M0' COMMENT 'Cap do sponsor' AFTER `path`;
