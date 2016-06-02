--
-- Table structure for table `m_plans`
--

CREATE TABLE IF NOT EXISTS `m_plans` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `province_id` int(2) NOT NULL,
  `task_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=4 ;