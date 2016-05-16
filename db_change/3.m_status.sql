--
-- Table structure for table `m_status`
--

CREATE TABLE IF NOT EXISTS `m_status` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `value` int(1) NOT NULL,
  `type` varchar(100) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `m_status`
--

INSERT INTO `m_status` (`id`, `name`, `value`, `type`) VALUES
(1, 'Pending', 1, 'pd'),
(2, 'Pending Payment', 2, 'pd'),
(3, 'Approved', 3, 'pd'),
(4, 'Pending', 1, 'gd'),
(5, 'Pending Veifycation', 2, 'gd'),
(6, 'Done', 3, 'gd');
