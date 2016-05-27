ALTER TABLE `m_plans` ADD `taskStatus` BOOLEAN; 
update `m_plans` set taskStatus = 1 where id in (1,2,5,8);
