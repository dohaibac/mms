ALTER TABLE `m_candidates` ADD `province_id` INT NOT NULL ;

update m_candidates set province_id = 1 where system_code=06;

update m_candidates set system_code='06', created_by = 1 ;
