/*------------------------------------------------------------------------------
-- DROP
------------------------------------------------------------------------------*/


	SET FOREIGN_KEY_CHECKS=0;

	DROP TABLE IF EXISTS `webapp_logs`;
	DROP TABLE IF EXISTS `webapp_logs_cookies`;
	DROP TABLE IF EXISTS `webapp_logs_languages`;
	DROP TABLE IF EXISTS `webapp_logs_referers`;
	DROP TABLE IF EXISTS `webapp_logs_uris`;
	DROP TABLE IF EXISTS `webapp_logs_useragents`;
	DROP TABLE IF EXISTS `webapp_scenarios`;
	DROP TABLE IF EXISTS `webapp_grants`;
	DROP TABLE IF EXISTS `webapp_options`;
	DROP TABLE IF EXISTS `webapp_users`;
	DROP TABLE IF EXISTS `webapp_groups`;


	SET FOREIGN_KEY_CHECKS=1;



/*------------------------------------------------------------------------------
-- DONNEES APPLI
------------------------------------------------------------------------------*/

	--
	-- Table structure for table `webapp_logs`
	--
	CREATE TABLE `webapp_logs` (
	  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `log_datetime` datetime DEFAULT NULL,
	  `log_runtime` float DEFAULT NULL,
	  `log_method` char(4) DEFAULT NULL,
	  `log_ip` int(10) unsigned DEFAULT NULL,
	  `log_port` smallint(5) unsigned DEFAULT NULL,
	  `user_id` int(10) unsigned DEFAULT NULL,
	  `cookie_id` int(10) unsigned DEFAULT NULL,
	  `useragent_id` int(10) unsigned DEFAULT NULL,
	  `uri_id` int(10) unsigned DEFAULT NULL,
	  `referer_id` int(10) unsigned DEFAULT NULL,
	  `language_id` int(10) unsigned DEFAULT NULL,
	  PRIMARY KEY (`log_id`),
	  KEY `fk_webapp_logs_0` (`user_id`),
	  KEY `fk_webapp_logs_1` (`cookie_id`),
	  KEY `fk_webapp_logs_2` (`useragent_id`),
	  KEY `fk_webapp_logs_3` (`uri_id`),
	  KEY `fk_webapp_logs_4` (`referer_id`),
	  KEY `fk_webapp_logs_5` (`language_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


	--
	-- Table structure for table `webapp_grants`
	--
	CREATE TABLE `webapp_grants` (
	  `group_name` varchar(50) NOT NULL,
	  `option_name` varchar(50) NOT NULL,
	  PRIMARY KEY (`option_name`,`group_name`),
	  KEY `fk_webapp_grants_1` (`group_name`),
	  KEY `fk_webapp_grants_2` (`option_name`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	--
	-- Table structure for table `webapp_groups`
	--
	CREATE TABLE `webapp_groups` (
	  `group_name` varchar(50) NOT NULL,
	  `group_description` varchar(255) DEFAULT NULL,
	  PRIMARY KEY (`group_name`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;


	--
	-- Table structure for table `webapp_users`
	--
	CREATE TABLE `webapp_users` (
	  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `user_login` varchar(50) NOT NULL,
	  `user_pass` varchar(40) NOT NULL,
	  `user_pass_change` tinyint(1) NOT NULL DEFAULT '0',
	  `user_state` tinyint(1) NOT NULL DEFAULT '1',
	  `group_name` varchar(50) DEFAULT NULL,
	  PRIMARY KEY (`user_id`),
	  UNIQUE KEY `user_login_UNIQUE` (`user_login`),
	  KEY `fk_webapp_users_1` (`group_name`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


	--
	-- Table structure for table `webapp_logs_cookies`
	--
	CREATE TABLE `webapp_logs_cookies` (
	  `cookie_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `cookie_content` text NOT NULL,
	  PRIMARY KEY (`cookie_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


	--
	-- Table structure for table `webapp_scenarios`
	--
	CREATE TABLE `webapp_scenarios` (
	  `scenario_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `scenario_datetime` datetime NOT NULL,
	  `scenario_name` varchar(150) NOT NULL,
	  `scenario_json` longtext NOT NULL,
	  `user_id` int(10) unsigned NOT NULL,
	  PRIMARY KEY (`scenario_id`),
	  KEY `fk_webapp_scenarios_1` (`user_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



	--
	-- Table structure for table `webapp_logs_languages`
	--
	CREATE TABLE `webapp_logs_languages` (
	  `language_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `language_content` varchar(255) NOT NULL,
	  PRIMARY KEY (`language_id`),
	  UNIQUE KEY `language_content_UNIQUE` (`language_content`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



	--
	-- Table structure for table `webapp_options`
	--
	CREATE TABLE `webapp_options` (
	  `option_name` varchar(50) NOT NULL,
	  `option_description` varchar(255) DEFAULT NULL,
	  PRIMARY KEY (`option_name`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;


	--
	-- Table structure for table `webapp_logs_referers`
	--
	CREATE TABLE `webapp_logs_referers` (
	  `referer_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `referer_content` varchar(255) NOT NULL,
	  PRIMARY KEY (`referer_id`),
	  UNIQUE KEY `referer_content_UNIQUE` (`referer_content`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


	--
	-- Table structure for table `webapp_logs_uris`
	--
	CREATE TABLE `webapp_logs_uris` (
	  `uri_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `uri_content` varchar(255) NOT NULL,
	  PRIMARY KEY (`uri_id`),
	  UNIQUE KEY `uri_content_UNIQUE` (`uri_content`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


	--
	-- Table structure for table `webapp_logs_useragents`
	--
	CREATE TABLE `webapp_logs_useragents` (
	  `useragent_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `useragent_content` text NOT NULL,
	  PRIMARY KEY (`useragent_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


/*------------------------------------------------------------------------------
-- CONSTRAINTS
------------------------------------------------------------------------------*/

	--
	-- Constraints for table `webapp_scenarios`
	--
	ALTER TABLE `webapp_scenarios`
	  ADD CONSTRAINT `fk_webapp_scenarios_1` FOREIGN KEY (`user_id`) REFERENCES `webapp_users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

	--
	-- Constraints for table `webapp_grants`
	--
	ALTER TABLE `webapp_grants`
	  ADD CONSTRAINT `fk_webapp_grants_1` FOREIGN KEY (`group_name`) REFERENCES `webapp_groups` (`group_name`) ON DELETE CASCADE ON UPDATE CASCADE,
	  ADD CONSTRAINT `fk_webapp_grants_2` FOREIGN KEY (`option_name`) REFERENCES `webapp_options` (`option_name`) ON DELETE CASCADE ON UPDATE CASCADE;

	--
	-- Constraints for table `webapp_logs`
	--
	ALTER TABLE `webapp_logs`
	  ADD CONSTRAINT `fk_webapp_logs_0` FOREIGN KEY (`user_id`) REFERENCES `webapp_users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
	  ADD CONSTRAINT `fk_webapp_logs_1` FOREIGN KEY (`cookie_id`) REFERENCES `webapp_logs_cookies` (`cookie_id`) ON DELETE SET NULL ON UPDATE CASCADE,
	  ADD CONSTRAINT `fk_webapp_logs_2` FOREIGN KEY (`useragent_id`) REFERENCES `webapp_logs_useragents` (`useragent_id`) ON DELETE SET NULL ON UPDATE CASCADE,
	  ADD CONSTRAINT `fk_webapp_logs_3` FOREIGN KEY (`uri_id`) REFERENCES `webapp_logs_uris` (`uri_id`) ON DELETE SET NULL ON UPDATE CASCADE,
	  ADD CONSTRAINT `fk_webapp_logs_4` FOREIGN KEY (`referer_id`) REFERENCES `webapp_logs_referers` (`referer_id`) ON DELETE SET NULL ON UPDATE CASCADE,
	  ADD CONSTRAINT `fk_webapp_logs_5` FOREIGN KEY (`language_id`) REFERENCES `webapp_logs_languages` (`language_id`) ON DELETE SET NULL ON UPDATE CASCADE;

	--
	-- Constraints for table `webapp_users`
	--
	ALTER TABLE `webapp_users`
	  ADD CONSTRAINT `fk_webapp_users_1` FOREIGN KEY (`group_name`) REFERENCES `webapp_groups` (`group_name`) ON DELETE SET NULL ON UPDATE CASCADE;



/*------------------------------------------------------------------------------
-- DUMPING
------------------------------------------------------------------------------*/

	--
	-- Dumping data for table `webapp_groups`
	--
	INSERT INTO `webapp_groups` (`group_name`, `group_description`) VALUES
	('root', 'Administrators group'),
	('users', 'Users group without options'),
	('demo', 'Users group with all options (scenario, etc...)');

	--
	-- Dumping data for table `webapp_options`
	--
	INSERT INTO `webapp_options` (`option_name`, `option_description`) VALUES
	('report', 'Report to pdf'),
	('scenario', 'scenarios online and offline'),
	('password', 'Change password');

	--
	-- Dumping data for table `webapp_grants`
	--
	INSERT INTO `webapp_grants` (`group_name`, `option_name`) VALUES
	('demo', 'scenario'),
	('demo', 'report'),
	('demo', 'password');

	--
	-- Dumping data for table `webapp_users`
	--
	INSERT INTO `webapp_users` (`user_login`, `user_pass`, `user_pass_change`, `user_state`, `group_name`) VALUES
	('user', SHA1('user'), 0, 1, 'users'),
	('demo', SHA1('demo'), 0, 1, 'demo'),
	('admin', SHA1('admin'), 0, 1, 'root');

	--
	-- Dumping data for table `webapp_scenarios`
	--

	INSERT INTO `webapp_scenarios` (`scenario_id`, `scenario_datetime`, `scenario_name`, `scenario_json`, `user_id`) VALUES
(1, '2014-02-13 16:45:33', 'Scénario 1', '[{"name":"DemoWebApp_USER_9","content":[{"ca":"90000","benef":"9000"}]},{"name":"DemoWebApp_USER_8","content":[{"ca":"80000","benef":"8000"}]},{"name":"DemoWebApp_USER_7","content":[{"ca":"70000","benef":"7000"}]},{"name":"DemoWebApp_USER_6","content":[{"ca":"60000","benef":"6000"}]},{"name":"DemoWebApp_USER_5","content":[{"ca":"50000","benef":"5000"}]},{"name":"DemoWebApp_USER_4","content":[{"ca":"40000","benef":"4000"}]},{"name":"DemoWebApp_USER_3","content":[{"ca":"30000","benef":"3000"}]},{"name":"DemoWebApp_USER_2","content":[{"ca":"20000","benef":"2000"}]},{"name":"DemoWebApp_USER_12","content":[{"ca":"120000","benef":"12000"}]},{"name":"DemoWebApp_USER_11","content":[{"ca":"110000","benef":"11000"}]},{"name":"DemoWebApp_USER_10","content":[{"ca":"100000","benef":"10000"}]},{"name":"DemoWebApp_USER_1","content":[{"ca":"10000","benef":"1000"}]}]', 2),
(4, '2014-02-13 17:08:00', 'Scénario 2', '[{"name":"DemoWebApp_USER_9","content":[{"ca":"40000","benef":"4000"}]},{"name":"DemoWebApp_USER_8","content":[{"ca":"50000","benef":"5000"}]},{"name":"DemoWebApp_USER_7","content":[{"ca":"60000","benef":"6000"}]},{"name":"DemoWebApp_USER_6","content":[{"ca":"70000","benef":"7000"}]},{"name":"DemoWebApp_USER_5","content":[{"ca":"80000","benef":"8000"}]},{"name":"DemoWebApp_USER_4","content":[{"ca":"90000","benef":"9000"}]},{"name":"DemoWebApp_USER_3","content":[{"ca":"100000","benef":"10000"}]},{"name":"DemoWebApp_USER_2","content":[{"ca":"110000","benef":"11000"}]},{"name":"DemoWebApp_USER_12","content":[{"ca":"10000","benef":"1000"}]},{"name":"DemoWebApp_USER_11","content":[{"ca":"20000","benef":"2000"}]},{"name":"DemoWebApp_USER_10","content":[{"ca":"30000","benef":"3000"}]},{"name":"DemoWebApp_USER_1","content":[{"ca":"120000","benef":"12000"}]}]', 2),
(5, '2014-02-13 17:10:56', 'Scénario 3', '[{"name":"DemoWebApp_USER_9","content":[{"ca":"21000","benef":"19000"}]},{"name":"DemoWebApp_USER_8","content":[{"ca":"25000","benef":"21000"}]},{"name":"DemoWebApp_USER_7","content":[{"ca":"30000","benef":"27000"}]},{"name":"DemoWebApp_USER_6","content":[{"ca":"25000","benef":"24600"}]},{"name":"DemoWebApp_USER_5","content":[{"ca":"21000","benef":"19000"}]},{"name":"DemoWebApp_USER_4","content":[{"ca":"24000","benef":"19500"}]},{"name":"DemoWebApp_USER_3","content":[{"ca":"14000","benef":"13000"}]},{"name":"DemoWebApp_USER_2","content":[{"ca":"18000","benef":"17000"}]},{"name":"DemoWebApp_USER_12","content":[{"ca":"12000","benef":"10000"}]},{"name":"DemoWebApp_USER_11","content":[{"ca":"15000","benef":"12000"}]},{"name":"DemoWebApp_USER_10","content":[{"ca":"18000","benef":"16000"}]},{"name":"DemoWebApp_USER_1","content":[{"ca":"10000","benef":"9000"}]}]', 2);



