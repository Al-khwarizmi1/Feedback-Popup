<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('feedbackpopup')};
CREATE TABLE IF NOT EXISTS `feedbackpopup` (
  `feedbackpopup_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL,
  `options_type` int(6) NOT NULL,
  `displayeffect` smallint(6) NOT NULL,
  `show_at` varchar(255) NOT NULL,
  `displayposition` smallint(6) NOT NULL,
  `receiveremail` varchar(50) NOT NULL,
  `enablephonefield` smallint(6) NOT NULL,
  `enableaddressfield` smallint(6) NOT NULL,
  `enablecomment` smallint(6) NOT NULL,
  `hear_about` smallint(6) NOT NULL,
  `fromdate` datetime NOT NULL,
  `todate` datetime NOT NULL,
  `starttime` text NOT NULL,
  `closetime` text NOT NULL,
  `content_type` mediumtext NOT NULL,
  PRIMARY KEY (`feedbackpopup_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- DROP TABLE IF EXISTS {$this->getTable('eedbackpopup_store')};
CREATE TABLE IF NOT EXISTS `feedbackpopup_store` (
  `feedbackpopup_id` smallint(6) NOT NULL COMMENT 'Feedback ID',
  `store_id` smallint(5) unsigned NOT NULL COMMENT 'Store ID',
  PRIMARY KEY (`feedbackpopup_id`,`store_id`),
  KEY `IDX_feedback_store_STORE_ID` (`store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `feedbackpopup_store`
  ADD CONSTRAINT `feedbackpopup_store_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `core_store` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE;
");

$installer->endSetup(); 