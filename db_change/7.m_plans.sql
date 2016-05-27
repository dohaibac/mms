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

--
-- Dumping data for table `m_plans`
--

INSERT INTO `m_plans` (`id`, `user_id`, `content`, `province_id`, `task_date`) VALUES
(1, 1, 'Hop cung cac AE chien huu tai Ha Noi', 1, '2016-05-28 07:29:00'),
(2, 1, 'Hop cung cac AE chien huu tai Sai Gon', 2, '2016-05-30 08:30:00'),
(3, 1, 'Cafe cung cac AE chien huu tai Ha Noi', 1, '2016-06-10 09:30:00'),
(4, 1, 'Di xem co vu bong da', 2, '2016-07-12 08:50:00'),
(5, 1, 'Thao luan ve loai may tinh bang moi', 3, '2016-08-15 10:20:00'),
(6, 1, 'Gap mat chuyen gia tu van', 4, '2016-09-20 11:10:00'),
(7, 1, 'Hop mat chuan bi cong tac', 5, '2016-10-30 09:00:00'),
(8, 1, 'Di nghi chuan bi cuoi nam', 20, '2016-11-18 09:40:00');
