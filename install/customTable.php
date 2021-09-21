<?php

/*************************************************************************************
 * Enrollment System: Separate database for Elem, HS, College Level
 *************************************************************************************/
//$categoryDatabases[1]="elementary";
//$categoryDatabases[2]="highschool";
//$categoryDatabases[3]="college";
//$categoryDatabases[4]="preschool";

$categoryDatabases[1]=$sugar_config['dbconfig']['db_name']."_elementary";
$categoryDatabases[2]=$sugar_config['dbconfig']['db_name']."_highschool";
$categoryDatabases[3]=$sugar_config['dbconfig']['db_name']."_college";
$categoryDatabases[4]=$sugar_config['dbconfig']['db_name']."_preschool";

/**
 * Custom Table Structures
 */

$customTables = array(
'frameworkTables'=> array(
0 => array(
	'table_name'=>'system_versions',
	'table_structure'=>"
		CREATE TABLE `system_versions` (
		`name` varchar(15) NOT NULL,
		`updated_at` varchar(10) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
	),
1 => array(
	'table_name'=> 'tracker',
	'table_structure'=> "
	    CREATE TABLE `tracker` (
        `id` int( 11 ) NOT NULL AUTO_INCREMENT ,
        `user_id` char( 36 ) default NULL ,
        `module_name` varchar( 25 ) default NULL ,
        `item_id` char( 36 ) default NULL ,
        `item_summary` varchar( 255 ) default NULL ,
        `date_modified` datetime default NULL ,
        PRIMARY KEY ( `id` )
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8;"
	),
2 => array(
	'table_name'=> 'acl_roles_actions',
	'table_structure'=> "
	      CREATE TABLE `acl_roles_actions` (
          `id` varchar(36) NOT NULL,
          `role_id` varchar(36) default NULL,
          `action_id` varchar(36) default NULL,
          `access_override` int(3) default NULL,
          `date_modified` datetime default NULL,
          `deleted` tinyint(1) default '0',
          PRIMARY KEY  (`id`),
          KEY `idx_acl_role_id` (`role_id`),
          KEY `idx_acl_action_id` (`action_id`),
          KEY `idx_aclrole_action` (`role_id`,`action_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
	),
3 => array(
	'table_name'=> 'acl_roles_users',
	'table_structure'=> "
	      CREATE TABLE `acl_roles_users` (
          `id` varchar(36) NOT NULL,
          `role_id` varchar(36) default NULL,
          `user_id` varchar(36) default NULL,
          `date_modified` datetime default NULL,
          `deleted` tinyint(1) default '0',
          PRIMARY KEY  (`id`),
          KEY `idx_aclrole_id` (`role_id`),
          KEY `idx_acluser_id` (`user_id`),
          KEY `idx_aclrole_user` (`role_id`,`user_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
	),
4 => array(
	'table_name'=> 'user_groups',
	'table_structure'=> "
	     CREATE TABLE `user_groups` (
        `groupID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
        `name` VARCHAR( 30 ) NOT NULL ,
        `description` VARCHAR( 100 ) NULL ,
        `status` TINYINT NOT NULL DEFAULT '1'
        ) ENGINE = innodb;"
	),
 5 => array(
	'table_name'=> 'user_group_roles',
	'table_structure'=> "
	     CREATE TABLE `user_group_roles` (
        `grID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
        `groupID` INT NOT NULL ,
        `roleID` VARCHAR( 36 ) NOT NULL ,
        `status` TINYINT NOT NULL DEFAULT '1'
        ) ENGINE = innodb;"
	),
 6 => array(
	'table_name'=> 'orseries',
	'table_structure'=> "
	     CREATE TABLE `orseries` (
          `id` int(11) NOT NULL auto_increment,
          `fiscalYear` varchar(4) NOT NULL,
          `firstORNO` int(11) default NULL,
          `lastORNO` int(11) default NULL,
          `currentORNO` int(11) default NULL,
          `cancelledOR` int(11) default NULL,
          `cashier` varchar(36) default NULL,
          `rstatus` tinyint(4) default '1',
          PRIMARY KEY  (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;"
	),
    7 => array(
    	'table_name'=> 'chart_class',
    	'table_structure'=> "
    	   CREATE TABLE `chart_class` (
              `cid` int(11) NOT NULL default '0',
              `class_name` varchar(60) NOT NULL default '',
              PRIMARY KEY  (`cid`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
    	    "
    	),
    	
    8 => array(
    	'table_name'=> 'chart_master',
    	'table_structure'=> "
    	   CREATE TABLE `chart_master` (
              `account_code` varchar(11) NOT NULL default '',
              `account_name` varchar(60) NOT NULL default '',
              `account_type` int(11) NOT NULL default '0',
              PRIMARY KEY  (`account_code`),
              KEY `account_code` (`account_code`),
              KEY `account_name` (`account_name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
    	    "
    	),

    9 => array(
    	'table_name'=> 'chart_types',
    	'table_structure'=> "
            CREATE TABLE `chart_types` (
              `id` int(11) NOT NULL auto_increment,
              `name` varchar(60) NOT NULL default '',
              `class_id` tinyint(1) NOT NULL default '0',
              `parent` int(11) NOT NULL default '-1',
              PRIMARY KEY  (`id`),
              UNIQUE KEY `name` (`name`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
    	    "
    	),
),

$categoryDatabases[1].'Tables' => array(
    0 => array(
    	'table_name'=> 'account_notes',
    	'table_structure'=> "
    	   CREATE TABLE `account_notes` (
              `accNoteID` bigint(20) NOT NULL auto_increment,
              `accID` bigint(20) NOT NULL,
              `noteType` varchar(20) NOT NULL,
              `notes` text NOT NULL,
              `notedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`accNoteID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    1 => array(
    	'table_name'=> 'accounts',
    	'table_structure'=> "
    	   CREATE TABLE `accounts` (
              `accID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `yrLevel` CHAR( 1 ) NOT NULL,
              `oldBalance` float(15,2) NOT NULL,
              `totalFee` FLOAT( 15, 2 ) NOT NULL,
              `payment` FLOAT( 15, 2 ) NOT NULL,
              `balance` float(15,2) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`accID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    2 => array(
    	'table_name'=> 'assessments',
    	'table_structure'=> "
    	   CREATE TABLE `assessments` (
              `assID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `accID` bigint(20) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `yrLevel` CHAR( 1 ) NOT NULL,
              `term` tinyint(4) NOT NULL,
              `tuitionFee` float(15,2) NOT NULL,
              `labFee` float(15,2) NOT NULL,
              `regFee` float(15,2) NOT NULL,
              `miscFee` float(15,2) NOT NULL,
              `addAdj` float(15,2) NOT NULL,
              `lessAdj` float(15,2) NOT NULL,
              `oldBalance` float(15,2) NOT NULL,
              `totalFees` FLOAT( 15, 2 ) NOT NULL,
              `ttlPayment` FLOAT( 15, 2 ) NOT NULL,
              `balance` FLOAT( 15, 2 ) NOT NULL,
              `ttlDue` float(15,2) NOT NULL,
              `amtPaid` FLOAT( 15, 2 ) NOT NULL,
              `preparedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`assID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    3 => array(
    	'table_name'=> 'block_sections',
    	'table_structure'=> "
    	   CREATE TABLE `block_sections` (
              `secID` bigint(20) NOT NULL auto_increment,
              `secName` varchar(20) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `yrLevel` char(1) NOT NULL,
              `maxCapacity` INT NOT NULL,
              `noEnrolled` INT NOT NULL,
              `remarks` varchar(150) default NULL,
              `preparedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`secID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    4 => array(
    	'table_name'=> 'block_sections_details',
    	'table_structure'=> "
    	   CREATE TABLE `block_sections_details` (
              `secDetailID` bigint(20) NOT NULL auto_increment,
              `secID` bigint(20) NOT NULL,
              `schedID` bigint(20) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`secDetailID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    5 => array(
    	'table_name'=> 'configurations',
    	'table_structure'=> "
    	   CREATE TABLE `configurations` (
              `configID` bigint(20) NOT NULL auto_increment,
              `title` varchar(30) NOT NULL,
              `definition` text NOT NULL,
              `rstatus` tinyint(4) NOT NULL DEFAULT '1',
              PRIMARY KEY  (`configID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    6 => array(
    	'table_name'=> 'enrollment_details',
    	'table_structure'=> "
    	   CREATE TABLE `enrollment_details` (
              `endID` bigint(20) NOT NULL auto_increment,
              `enID` BIGINT NOT NULL,
              `schedID` bigint(20) NOT NULL,
              `subjID` BIGINT NOT NULL,
              `firstgrade` float(5,1) NOT NULL,
              `secondgrade` float(5,1) NOT NULL,
              `thirdgrade` float(5,1) NOT NULL,
              `fourthgrade` float(5,1) NOT NULL,
              `fgrade` float(5,1) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`endID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    7 => array(
    	'table_name'=> 'enrollment_table_logs',
    	'table_structure'=> "
    	   CREATE TABLE `enrollment_table_logs` (
              `logID` bigint(20) NOT NULL auto_increment,
              `docType` varchar(10) NOT NULL,
              `enID` bigint(20) NOT NULL,
              `logDate` datetime NOT NULL,
              `subjects` varchar(200) NOT NULL,
              `changeBy` VARCHAR( 36 ) NOT NULL,
              PRIMARY KEY  (`logID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    8 => array(
    	'table_name'=> 'enrollments',
    	'table_structure'=> "
    	   CREATE TABLE `enrollments` (
              `enID` bigint(20) NOT NULL auto_increment,
              `schYear` varchar(10) NOT NULL,
              `idno` varchar(15) NOT NULL,
              `yrLevel` char(1) NOT NULL,
              `secID` BIGINT NULL,
              `dateCreated` datetime NOT NULL,
              `ttlUnits` float(5,1) NOT NULL,
              `encodedBy` varchar(36) NOT NULL,
              `lastEdited` datetime NOT NULL,
              `studType` tinyint(4) NOT NULL default '1',
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`enID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    9 => array(
    	'table_name'=> 'form137',
    	'table_structure'=> "
	       CREATE TABLE `form137` (
              `gradeID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `yrLevel` CHAR( 1 ) NOT NULL,
              `endID` bigint(20) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `subjID` bigint(20) NOT NULL,
              `firstgrade` float(5,1) NOT NULL,
              `secondgrade` float(5,1) NOT NULL,
              `thirdgrade` float(5,1) NOT NULL,
              `fourthgrade` float(5,1) NOT NULL,
              `fgrade` float(5,1) NOT NULL,
              `units` float(5,1) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`gradeID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;
    	    "
    	),
    10 => array(
    	'table_name'=> 'form137_grade_logs',
    	'table_structure'=> "
    	   CREATE TABLE `form137_grade_logs` (
              `logID` bigint(20) NOT NULL,
              `idno` varchar(15) NOT NULL,
              `endID` bigint(20) NOT NULL,
              `changes` varchar(200) NOT NULL,
              `changeBy` VARCHAR( 36 ) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    	    "
    	),
    11 => array(
    	'table_name'=> 'grade_sheets',
    	'table_structure'=> "
    	   CREATE TABLE `grade_sheets` (
              `gsID` bigint(20) NOT NULL auto_increment,
              `schYear` varchar(10) NOT NULL,
              `profID` varchar(36) NOT NULL,
              `schedID` bigint(20) NOT NULL,
              `units` float(5,1) NOT NULL,
              `remarks` varchar(150) default NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`gsID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    12 => array(
    	'table_name'=> 'master_table_audit_logs',
    	'table_structure'=> "
    	   CREATE TABLE `master_table_audit_logs` (
              `logID` bigint(20) NOT NULL auto_increment,
              `docType` varchar(20) NOT NULL,
              `recID` bigint(20) NOT NULL,
              `logDate` datetime NOT NULL,
              `operation` varchar(10) NOT NULL,
              `fields` varchar(200) NOT NULL,
              `user_id` VARCHAR( 36 ) NOT NULL,
              PRIMARY KEY  (`logID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    13 => array(
    	'table_name'=> 'refunds',
    	'table_structure'=> "
           CREATE TABLE `refunds` (
              `refundID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `accID` bigint(20) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `date` datetime NOT NULL,
              `amount` float(15,2) NOT NULL,
              `preparedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`refundID`),
              KEY `idno` (`idno`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    14 => array(
    	'table_name'=> 'registrations',
    	'table_structure'=> "
    	   CREATE TABLE `registrations` (
              `regID` bigint(20) NOT NULL auto_increment,
              `fname` varchar(25) NOT NULL,
              `lname` varchar(25) NOT NULL,
              `mname` varchar(25) NOT NULL,
              `gender` char(1) NOT NULL,
              `age` int(11) NOT NULL,
              `bday` date NOT NULL,
              `cstatus` char(1) NOT NULL,
              `nationality` varchar(20) NOT NULL,
              `entryDocs` varchar(50) NOT NULL,
              `lastSchool` VARCHAR( 70 ) NULL,
              `sch_last_attended` date NOT NULL,
              `regDate` DATE NOT NULL,
              `encodedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`regID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    15 => array(
    	'table_name'=> 'schedules',
    	'table_structure'=> "
    	   CREATE TABLE `schedules` (
     	      `schedID` bigint(20) NOT NULL auto_increment,
    	      `schYear` VARCHAR( 10 ) NOT NULL,
    	      `yrLevel` CHAR( 1 ) NOT NULL,
              `schedCode` varchar(10) NOT NULL,
              `subjID` bigint(20) NOT NULL,
              `profID` varchar(36) NOT NULL,
              `startTime` time NOT NULL,
              `endTime` time NOT NULL,
              `onMon` tinyint(4) NOT NULL,
              `onTue` tinyint(4) NOT NULL,
              `onWed` tinyint(4) NOT NULL,
              `onThu` tinyint(4) NOT NULL,
              `onFri` tinyint(4) NOT NULL,
              `onSat` tinyint(4) NOT NULL,
              `onSun` tinyint(4) NOT NULL,
              `room` varchar(15) NOT NULL,
              `maxCapacity` int(11) NOT NULL,
              `noEnrolled` int(11) NOT NULL,
              `labFee` FLOAT( 15, 2 ) NOT NULL,
              `remarks` varchar(150) default NULL,
              `preparedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`schedID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    16 => array(
    	'table_name'=> 'school_fees',
    	'table_structure'=> "
    	   CREATE TABLE `school_fees` (
              `feeID` bigint(20) NOT NULL auto_increment,
              `schYear` varchar(10) NOT NULL,
              `account_code` int(11) NOT NULL,
              `yrLevel` CHAR( 1 ) NOT NULL,
              `item` varchar(100) NOT NULL,
              `amount` float(15,2) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`feeID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    17 => array(
    	'table_name'=> 'students',
    	'table_structure'=> "
            CREATE TABLE `students` (
              `recID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `accID` bigint(20) NOT NULL,
              `regID` bigint(20) NOT NULL,
              `fname` varchar(25) NOT NULL,
              `lname` varchar(25) NOT NULL,
              `mname` varchar(25) NOT NULL,
              `yrLevel` char(1) NOT NULL,
              `gender` char(1) NOT NULL,
              `age` int(11) NOT NULL,
              `bday` date NOT NULL,
              `permanentAddr` varchar(150) NOT NULL,
              `currentAddr` varchar(150) default NULL,
              `phone` varchar(25) default NULL,
              `cstatus` char(1) NOT NULL,
              `nationality` varchar(20) NOT NULL,
              `motherName` varchar(70) default NULL,
              `fatherName` varchar(70) default NULL,
              `guardian` varchar(70) default NULL,
              `motherOccupation` varchar(25) NOT NULL,
              `fatherOccupation` varchar(25) NOT NULL,
              `guardianOccupation` varchar(25) NOT NULL,
              `motherContact` varchar(25) NOT NULL,
              `fatherContact` varchar(25) NOT NULL,
              `guardianContact` varchar(25) NOT NULL,
              `entryDocs` varchar(50) NOT NULL,
              `entryDate` date NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`recID`),
              KEY `idno` (`idno`)
            ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    18 => array(
    	'table_name'=> 'subjects',
    	'table_structure'=> "
    	   CREATE TABLE `subjects` (
              `subjID` bigint(20) NOT NULL auto_increment,
              `yrLevel` char(1) NOT NULL,
              `subjCode` varchar(20) NOT NULL,
              `descTitle` varchar(100) NOT NULL,
              `subjDesc` text,
              `units` float(5,1) NOT NULL,
              `type` TINYINT NOT NULL DEFAULT '1',
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`subjID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

    	    "
    	),
    19 => array(
    	'table_name'=> 'registration_payments',
    	'table_structure'=> "
    	   CREATE TABLE `registration_payments` (
              `regPaymentID` bigint(20) NOT NULL auto_increment,
              `schYear` varchar(10) NOT NULL,
              `idno` varchar(15) NOT NULL,
              `ORno` varchar(10) NOT NULL,
              `type` char(1) NOT NULL default '1' COMMENT '1=Registration ; 2=Down Payment',
              `date` date NOT NULL,
              `amount` float(15,2) NOT NULL,
              `encodedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`regPaymentID`),
              KEY `idno` (`idno`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    	    "
    	),
    20 => array(
    	'table_name'=> 'account_details',
    	'table_structure'=> "
    	   CREATE TABLE `account_details` (
            `accDetailID` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `accID` BIGINT NOT NULL ,
            `feeType` VARCHAR( 15 ) NOT NULL ,
            `particular` VARCHAR( 100 ) NOT NULL ,
            `amount` FLOAT( 15, 2 ) NOT NULL ,
            `rstatus` TINYINT NOT NULL DEFAULT '1',
            INDEX ( `accID` )
            ) ENGINE = innodb;
    	    "
    	),
    21 => array(
    	'table_name'=> 'payment_table_logs',
    	'table_structure'=> "
    	   CREATE TABLE `payment_table_logs` (
			`logID` bigint( 20 ) NOT NULL AUTO_INCREMENT ,
			`docType` varchar( 20 ) NOT NULL ,
			`recID` bigint( 20 ) NOT NULL ,
			`logDate` datetime NOT NULL ,
			`operation` varchar( 10 ) NOT NULL ,
			`fields` varchar( 200 ) NOT NULL ,
			`user_id` varchar( 36 ) NOT NULL ,
			PRIMARY KEY ( `logID` )
			) ENGINE = InnoDB;
    	    "
    	),
    22 => array(
    	'table_name'=> 'account_table_logs',
    	'table_structure'=> "
    	   CREATE TABLE `account_table_logs` (
			  `logID` bigint(20) NOT NULL auto_increment,
			  `operation` varchar(10) NOT NULL,
			  `recID` bigint(20) NOT NULL,
			  `logDate` datetime NOT NULL,
			  `changes` varchar(200) NOT NULL,
			  `changeBy` varchar(36) NOT NULL,
			  PRIMARY KEY  (`logID`)
			) ENGINE=InnoDB ;
    	    "
    	),
    23 => array(
    	'table_name'=> 'misc',
    	'table_structure'=> "
			CREATE TABLE `misc` (
			  `miscID` int(11) NOT NULL auto_increment,
			  `schYear` varchar(10) NOT NULL,
			  `yrLevel` char(1) NOT NULL,
			  `particular` varchar(50) NOT NULL,
			  `amount` float(15,2) NOT NULL,
			  PRIMARY KEY  (`miscID`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
    	    "
    	),
    	
    24 => array(
    	'table_name'=> 'orheader',
    	'table_structure'=> "
            CREATE TABLE `orheader` (
              `paymentID` int(11) NOT NULL auto_increment,
              `orno` char(10) default NULL,
              `idno` char(15) default NULL,
              `accID` int(11) default NULL,
              `schYear` char(10) default NULL,
              `term` char(1) default NULL,
              `dateCreated` date default NULL,
              `timeCreated` time NOT NULL,
              `totalAmount` float(15,2) default NULL,
              `cashier` varchar(36) default NULL,
              `rstatus` tinyint(4) default '1',
              PRIMARY KEY  (`paymentID`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    	
    25 => array(
    	'table_name'=> 'ordetails',
    	'table_structure'=> "
            CREATE TABLE `ordetails` (
              `ordno` int(11) NOT NULL auto_increment,
              `orno` char(10) NOT NULL,
              `account_code` int(11) NOT NULL,
              `amount` float(15,2) NOT NULL,
              PRIMARY KEY  (`ordno`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),    	

),

$categoryDatabases[2].'Tables' => array(
    0 => array(
    	'table_name'=> 'account_notes',
    	'table_structure'=> "
    	   CREATE TABLE `account_notes` (
              `accNoteID` bigint(20) NOT NULL auto_increment,
              `accID` bigint(20) NOT NULL,
              `noteType` varchar(20) NOT NULL,
              `notes` text NOT NULL,
              `notedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`accNoteID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    1 => array(
    	'table_name'=> 'accounts',
    	'table_structure'=> "
    	   CREATE TABLE `accounts` (
              `accID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `yrLevel` CHAR( 1 ) NOT NULL,
              `oldBalance` float(15,2) NOT NULL,
              `totalFee` FLOAT( 15, 2 ) NOT NULL,
              `payment` FLOAT( 15, 2 ) NOT NULL,
              `balance` float(15,2) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`accID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    2 => array(
    	'table_name'=> 'assessments',
    	'table_structure'=> "
    	   CREATE TABLE `assessments` (
              `assID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `accID` bigint(20) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `yrLevel` CHAR( 1 ) NOT NULL,
              `term` tinyint(4) NOT NULL,
              `tuitionFee` float(15,2) NOT NULL,
              `labFee` float(15,2) NOT NULL,
              `regFee` float(15,2) NOT NULL,
              `miscFee` float(15,2) NOT NULL,
              `addAdj` float(15,2) NOT NULL,
              `lessAdj` float(15,2) NOT NULL,
              `oldBalance` float(15,2) NOT NULL,
              `totalFees` FLOAT( 15, 2 ) NOT NULL,
              `ttlPayment` FLOAT( 15, 2 ) NOT NULL,
              `balance` FLOAT( 15, 2 ) NOT NULL,
              `ttlDue` float(15,2) NOT NULL,
              `amtPaid` FLOAT( 15, 2 ) NOT NULL,
              `preparedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`assID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    3 => array(
    	'table_name'=> 'block_sections',
    	'table_structure'=> "
    	   CREATE TABLE `block_sections` (
              `secID` bigint(20) NOT NULL auto_increment,
              `secName` varchar(20) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `yrLevel` char(1) NOT NULL,
              `maxCapacity` INT NOT NULL,
              `noEnrolled` INT NOT NULL,
              `remarks` varchar(150) default NULL,
              `preparedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`secID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    4 => array(
    	'table_name'=> 'block_sections_details',
    	'table_structure'=> "
    	   CREATE TABLE `block_sections_details` (
              `secDetailID` bigint(20) NOT NULL auto_increment,
              `secID` bigint(20) NOT NULL,
              `schedID` bigint(20) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`secDetailID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    5 => array(
    	'table_name'=> 'configurations',
    	'table_structure'=> "
    	   CREATE TABLE `configurations` (
              `configID` bigint(20) NOT NULL auto_increment,
              `title` varchar(30) NOT NULL,
              `definition` text NOT NULL,
              `rstatus` tinyint(4) NOT NULL DEFAULT '1',
              PRIMARY KEY  (`configID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    6 => array(
    	'table_name'=> 'enrollment_details',
    	'table_structure'=> "
    	   CREATE TABLE `enrollment_details` (
              `endID` bigint(20) NOT NULL auto_increment,
              `enID` BIGINT NOT NULL,
              `schedID` bigint(20) NOT NULL,
              `subjID` BIGINT NOT NULL,
              `firstgrade` float(5,1) NOT NULL,
              `secondgrade` float(5,1) NOT NULL,
              `thirdgrade` float(5,1) NOT NULL,
              `fourthgrade` float(5,1) NOT NULL,
              `fgrade` float(5,1) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`endID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    7 => array(
    	'table_name'=> 'enrollment_table_logs',
    	'table_structure'=> "
    	   CREATE TABLE `enrollment_table_logs` (
              `logID` bigint(20) NOT NULL auto_increment,
              `docType` varchar(10) NOT NULL,
              `enID` bigint(20) NOT NULL,
              `logDate` datetime NOT NULL,
              `subjects` varchar(200) NOT NULL,
              `changeBy` VARCHAR( 36 ) NOT NULL,
              PRIMARY KEY  (`logID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    8 => array(
    	'table_name'=> 'enrollments',
    	'table_structure'=> "
    	   CREATE TABLE `enrollments` (
              `enID` bigint(20) NOT NULL auto_increment,
              `schYear` varchar(10) NOT NULL,
              `idno` varchar(15) NOT NULL,
              `yrLevel` char(1) NOT NULL,
              `secID` BIGINT NULL,
              `dateCreated` datetime NOT NULL,
              `ttlUnits` float(5,1) NOT NULL,
              `encodedBy` varchar(36) NOT NULL,
              `lastEdited` datetime NOT NULL,
              `studType` tinyint(4) NOT NULL default '1',
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`enID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    9 => array(
    	'table_name'=> 'form137',
    	'table_structure'=> "
	       CREATE TABLE `form137` (
              `gradeID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `yrLevel` CHAR( 1 ) NOT NULL,
              `endID` bigint(20) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `subjID` bigint(20) NOT NULL,
              `firstgrade` float(5,1) NOT NULL,
              `secondgrade` float(5,1) NOT NULL,
              `thirdgrade` float(5,1) NOT NULL,
              `fourthgrade` float(5,1) NOT NULL,
              `fgrade` float(5,1) NOT NULL,
              `units` float(5,1) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`gradeID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;
    	    "
    	),
    10 => array(
    	'table_name'=> 'form137_grade_logs',
    	'table_structure'=> "
    	   CREATE TABLE `form137_grade_logs` (
              `logID` bigint(20) NOT NULL,
              `idno` varchar(15) NOT NULL,
              `endID` bigint(20) NOT NULL,
              `changes` varchar(200) NOT NULL,
              `changeBy` VARCHAR( 36 ) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    	    "
    	),
    11 => array(
    	'table_name'=> 'grade_sheets',
    	'table_structure'=> "
    	   CREATE TABLE `grade_sheets` (
              `gsID` bigint(20) NOT NULL auto_increment,
              `schYear` varchar(10) NOT NULL,
              `profID` varchar(36) NOT NULL,
              `schedID` bigint(20) NOT NULL,
              `units` float(5,1) NOT NULL,
              `remarks` varchar(150) default NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`gsID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    12 => array(
    	'table_name'=> 'master_table_audit_logs',
    	'table_structure'=> "
    	   CREATE TABLE `master_table_audit_logs` (
              `logID` bigint(20) NOT NULL auto_increment,
              `docType` varchar(20) NOT NULL,
              `recID` bigint(20) NOT NULL,
              `logDate` datetime NOT NULL,
              `operation` varchar(10) NOT NULL,
              `fields` varchar(200) NOT NULL,
              `user_id` VARCHAR( 36 ) NOT NULL,
              PRIMARY KEY  (`logID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    13 => array(
    	'table_name'=> 'refunds',
    	'table_structure'=> "
	       CREATE TABLE `refunds` (
              `refundID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `accID` bigint(20) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `date` datetime NOT NULL,
              `amount` float(15,2) NOT NULL,
              `preparedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`refundID`),
              KEY `idno` (`idno`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    14 => array(
    	'table_name'=> 'registrations',
    	'table_structure'=> "
    	   CREATE TABLE `registrations` (
              `regID` bigint(20) NOT NULL auto_increment,
              `fname` varchar(25) NOT NULL,
              `lname` varchar(25) NOT NULL,
              `mname` varchar(25) NOT NULL,
              `gender` char(1) NOT NULL,
              `age` int(11) NOT NULL,
              `bday` date NOT NULL,
              `cstatus` char(1) NOT NULL,
              `nationality` varchar(20) NOT NULL,
              `entryDocs` varchar(50) NOT NULL,
              `lastSchool` VARCHAR( 70 ) NULL,
              `sch_last_attended` date NOT NULL,
              `regDate` DATE NOT NULL,
              `encodedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`regID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    15 => array(
    	'table_name'=> 'schedules',
    	'table_structure'=> "
    	   CREATE TABLE `schedules` (
              `schedID` bigint(20) NOT NULL auto_increment,
              `schYear` VARCHAR( 10 ),
              `yrLevel` CHAR( 1 ) NOT NULL,
              `schedCode` varchar(10) NOT NULL,
              `subjID` bigint(20) NOT NULL,
              `profID` varchar(36) NOT NULL,
              `startTime` time NOT NULL,
              `endTime` time NOT NULL,
              `onMon` tinyint(4) NOT NULL,
              `onTue` tinyint(4) NOT NULL,
              `onWed` tinyint(4) NOT NULL,
              `onThu` tinyint(4) NOT NULL,
              `onFri` tinyint(4) NOT NULL,
              `onSat` tinyint(4) NOT NULL,
              `onSun` tinyint(4) NOT NULL,
              `room` varchar(15) NOT NULL,
              `maxCapacity` int(11) NOT NULL,
              `noEnrolled` int(11) NOT NULL,
              `labFee` FLOAT( 15, 2 ) NOT NULL,
              `remarks` varchar(150) default NULL,
              `preparedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`schedID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    16 => array(
    	'table_name'=> 'school_fees',
    	'table_structure'=> "
    	   CREATE TABLE `school_fees` (
              `feeID` bigint(20) NOT NULL auto_increment,
              `account_code` int(11) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `yrLevel` CHAR( 1 ) NOT NULL,
              `item` varchar(100) NOT NULL,
              `amount` float(15,2) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`feeID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    17 => array(
    	'table_name'=> 'students',
    	'table_structure'=> "
	       CREATE TABLE `students` (
              `recID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `accID` bigint(20) NOT NULL,
              `regID` bigint(20) NOT NULL,
              `fname` varchar(25) NOT NULL,
              `lname` varchar(25) NOT NULL,
              `mname` varchar(25) NOT NULL,
              `yrLevel` char(1) NOT NULL,
              `gender` char(1) NOT NULL,
              `age` int(11) NOT NULL,
              `bday` date NOT NULL,
              `permanentAddr` varchar(150) NOT NULL,
              `currentAddr` varchar(150) default NULL,
              `phone` varchar(25) default NULL,
              `cstatus` char(1) NOT NULL,
              `nationality` varchar(20) NOT NULL,
              `motherName` varchar(70) default NULL,
              `fatherName` varchar(70) default NULL,
              `primary_edu` varchar(100) default NULL,
              `primary_schYear` varchar(10) default NULL,
              `guardian` varchar(70) default NULL,
              `motherOccupation` varchar(25) NOT NULL,
              `fatherOccupation` varchar(25) NOT NULL,
              `guardianOccupation` varchar(25) NOT NULL,
              `motherContact` varchar(25) NOT NULL,
              `fatherContact` varchar(25) NOT NULL,
              `guardianContact` varchar(25) NOT NULL,
              `entryDocs` varchar(50) NOT NULL,
              `entryDate` date NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`recID`),
              KEY `idno` (`idno`)
            ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    18 => array(
    	'table_name'=> 'subjects',
    	'table_structure'=> "
    	   CREATE TABLE `subjects` (
              `subjID` bigint(20) NOT NULL auto_increment,
              `yrLevel` char(1) NOT NULL,
              `subjCode` varchar(20) NOT NULL,
              `descTitle` varchar(100) NOT NULL,
              `subjDesc` text,
              `units` float(5,1) NOT NULL,
              `type` TINYINT NOT NULL DEFAULT '1',
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`subjID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

    	    "
    	),
    19 => array(
    	'table_name'=> 'registration_payments',
    	'table_structure'=> "
    	   CREATE TABLE `registration_payments` (
              `regPaymentID` bigint(20) NOT NULL auto_increment,
              `schYear` varchar(10) NOT NULL,
              `idno` varchar(15) NOT NULL,
              `ORno` varchar(10) NOT NULL,
              `type` char(1) NOT NULL default '1' COMMENT '1=Registration ; 2=Down Payment',
              `date` date NOT NULL,
              `amount` float(15,2) NOT NULL,
              `encodedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`regPaymentID`),
              KEY `idno` (`idno`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    	    "
    	),
    20 => array(
    	'table_name'=> 'account_details',
    	'table_structure'=> "
    	   CREATE TABLE `account_details` (
            `accDetailID` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `accID` BIGINT NOT NULL ,
            `feeType` VARCHAR( 15 ) NOT NULL ,
            `particular` VARCHAR( 100 ) NOT NULL ,
            `amount` FLOAT( 15, 2 ) NOT NULL ,
            `rstatus` TINYINT NOT NULL DEFAULT '1',
            INDEX ( `accID` )
            ) ENGINE = innodb;
    	    "
    	),
    21 => array(
    	'table_name'=> 'payment_table_logs',
    	'table_structure'=> "
    	   CREATE TABLE `payment_table_logs` (
			`logID` bigint( 20 ) NOT NULL AUTO_INCREMENT ,
			`docType` varchar( 20 ) NOT NULL ,
			`recID` bigint( 20 ) NOT NULL ,
			`logDate` datetime NOT NULL ,
			`operation` varchar( 10 ) NOT NULL ,
			`fields` varchar( 200 ) NOT NULL ,
			`user_id` varchar( 36 ) NOT NULL ,
			PRIMARY KEY ( `logID` )
			) ENGINE = InnoDB;
    	    "
    	),
    22 => array(
    	'table_name'=> 'account_table_logs',
    	'table_structure'=> "
    	   CREATE TABLE `account_table_logs` (
			  `logID` bigint(20) NOT NULL auto_increment,
			  `operation` varchar(10) NOT NULL,
			  `recID` bigint(20) NOT NULL,
			  `logDate` datetime NOT NULL,
			  `changes` varchar(200) NOT NULL,
			  `changeBy` varchar(36) NOT NULL,
			  PRIMARY KEY  (`logID`)
			) ENGINE=InnoDB ;
    	    "
    	),
    23 => array(
    	'table_name'=> 'misc',
    	'table_structure'=> "
			CREATE TABLE `misc` (
			  `miscID` int(11) NOT NULL auto_increment,
			  `schYear` varchar(10) NOT NULL,
			  `yrLevel` char(1) NOT NULL,
			  `particular` varchar(50) NOT NULL,
			  `amount` float(15,2) NOT NULL,
			  PRIMARY KEY  (`miscID`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
    	    "
    	),
    	
    24 => array(
    	'table_name'=> 'orheader',
    	'table_structure'=> "
            CREATE TABLE `orheader` (
              `paymentID` int(11) NOT NULL auto_increment,
              `orno` char(10) default NULL,
              `idno` char(15) default NULL,
              `accID` int(11) default NULL,
              `schYear` char(10) default NULL,
              `term` char(1) default NULL,
              `dateCreated` date default NULL,
              `timeCreated` time NOT NULL,
              `totalAmount` float(15,2) default NULL,
              `cashier` varchar(36) default NULL,
              `rstatus` tinyint(4) default '1',
              PRIMARY KEY  (`paymentID`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    	
    25 => array(
    	'table_name'=> 'ordetails',
    	'table_structure'=> "
            CREATE TABLE `ordetails` (
              `ordno` int(11) NOT NULL auto_increment,
              `orno` char(10) NOT NULL,
              `account_code` int(11) NOT NULL,
              `amount` float(15,2) NOT NULL,
              PRIMARY KEY  (`ordno`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
),

$categoryDatabases[3].'Tables' => array(
        	
    0 => array(
    	'table_name'=> 'accounts',
    	'table_structure'=> "
    	   CREATE TABLE `accounts` (
          `accID` bigint(20) NOT NULL auto_increment,
          `idno` varchar(15) NOT NULL,
          `schYear` varchar(10) NOT NULL,
          `semCode` char(1) NOT NULL,
          `courseID` INT NOT NULL,
          `yrLevel` CHAR( 1 ) NOT NULL,
          `oldBalance` float(15,2) NOT NULL,
          `totalFee` FLOAT( 15, 2 ) NOT NULL,
          `payment` FLOAT( 15, 2 ) NOT NULL,
          `balance` float(15,2) NOT NULL,
          `rstatus` tinyint(4) NOT NULL default '1',
          PRIMARY KEY  (`accID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;"
    	),
    1 => array(
    	'table_name'=> 'assessments',
    	'table_structure'=> "
    	   CREATE TABLE `assessments` (
          `assID` bigint(20) NOT NULL auto_increment,
          `idno` varchar(15) NOT NULL,
          `accID` bigint(20) NOT NULL,
          `schYear` varchar(10) NOT NULL,
          `semCode` char(1) NOT NULL,
          `courseID` INT NOT NULL,
          `yrLevel` CHAR( 1 ) NOT NULL,
          `term` tinyint(4) NOT NULL,
          `tuitionFee` float(15,2) NOT NULL,
          `labFee` float(15,2) NOT NULL,
          `regFee` float(15,2) NOT NULL,
          `miscFee` float(15,2) NOT NULL,
          `addAdj` float(15,2) NOT NULL,
          `lessAdj` float(15,2) NOT NULL,
          `oldBalance` float(15,2) NOT NULL,
          `totalFees` FLOAT( 15, 2 ) NOT NULL,
          `ttlPayment` FLOAT( 15, 2 ) NOT NULL,
          `balance` FLOAT( 15, 2 ) NOT NULL,
          `ttlDue` float(15,2) NOT NULL,
          `amtPaid` FLOAT( 15, 2 ) NOT NULL,
          `preparedBy` varchar(36) NOT NULL,
          `rstatus` tinyint(4) NOT NULL default '1',
          PRIMARY KEY  (`assID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 	
    2 => array(
    	'table_name'=> 'block_sections',
    	'table_structure'=> "
    	   CREATE TABLE `block_sections` (
          `secID` bigint(20) NOT NULL auto_increment,
          `secName` varchar(20) NOT NULL,
          `schYear` varchar(10) NOT NULL,
          `courseID` bigint(20) NOT NULL,
          `yrLevel` char(1) NOT NULL,
          `semCode` char(1) NOT NULL,
          `remarks` varchar(150) default NULL,
          `preparedBy` varchar(36) NOT NULL,
          `rstatus` tinyint(4) NOT NULL default '1',
          PRIMARY KEY  (`secID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	),
    3 => array(
    	'table_name'=> 'block_sections_details',
    	'table_structure'=> "
    	    CREATE TABLE `block_sections_details` (
          `secDetailID` bigint(20) NOT NULL auto_increment,
          `secID` bigint(20) NOT NULL,
          `schedID` bigint(20) NOT NULL,
          `rstatus` tinyint(4) NOT NULL default '1',
          PRIMARY KEY  (`secDetailID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	   "
    	), 	
	4 => array(
    	'table_name'=> 'configurations',
    	'table_structure'=> "
    	   CREATE TABLE `configurations` (
          `configID` bigint(20) NOT NULL auto_increment,
          `title` varchar(30) NOT NULL,
          `definition` text NOT NULL,
          `rstatus` tinyint(4) NOT NULL DEFAULT '1',
          PRIMARY KEY  (`configID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	),
    5 => array(
    	'table_name'=> 'courses',
    	'table_structure'=> "
    	    CREATE TABLE `courses` (
              `courseID` bigint(20) NOT NULL auto_increment,
              `courseCode` varchar(10) NOT NULL,
              `deptID` bigint(20) NOT NULL,
              `courseName` varchar(100) NOT NULL,
              `dean` varchar(36) default NULL,
              `remarks` varchar(150) default NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`courseID`),
			  KEY `deptID` (`deptID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	   "
    	), 	
	6 => array(
    	'table_name'=> 'credited_subjs',
    	'table_structure'=> "
    	   CREATE TABLE `credited_subjs` (
              `creID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `schYear` varchar( 10 ) NOT NULL,
              `yrLevel` CHAR( 1 ) NOT NULL,
              `semCode` CHAR( 1 ) NOT NULL,
              `fgrade` FLOAT( 5, 1 ) NOT NULL,
              `subjID` bigint(20) NOT NULL,
              `eqSubj` varchar(20) NOT NULL,
              `eqUnits` float(5,1) NOT NULL,
              `school` varchar(30) NOT NULL,
              `remarks` varchar(150) default NULL,
              `encodedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`creID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	),
    7 => array(
    	'table_name'=> 'curriculum_subjs',
    	'table_structure'=> "
    	   CREATE TABLE `curriculum_subjs` (
              `curSubjID` bigint(20) NOT NULL auto_increment,
              `curID` bigint(20) NOT NULL,
              `subjID` bigint(20) NOT NULL,
              `yrLevel` char(1) NOT NULL,
              `semCode` char(1) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`curSubjID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 	
	8 => array(
    	'table_name'=> 'curriculums',
    	'table_structure'=> "
    	   CREATE TABLE `curriculums` (
              `curID` bigint(20) NOT NULL auto_increment,
              `curName` varchar(100) NOT NULL,
              `courseID` bigint(20) NOT NULL,
              `effectivity` year(4) NOT NULL,
              `major` varchar(50) default NULL,
              `remarks` varchar(150) default NULL,
              `preparedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`curID`),
			  KEY `courseID` (`courseID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	   "
    	),
    9 => array(
    	'table_name'=> 'departments',
    	'table_structure'=> "
    	   CREATE TABLE `departments` (
              `deptID` bigint(20) NOT NULL auto_increment,
              `deptCode` varchar(10) NOT NULL,
              `deptName` varchar(100) NOT NULL,
              `deptChairman` varchar(100) NOT NULL,
              `remarks` varchar(150) default NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`deptID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

    	   "
    	), 	
	10 => array(
    	'table_name'=> 'enrollment_details',
    	'table_structure'=> "
    	   CREATE TABLE `enrollment_details` (
              `endID` bigint(20) NOT NULL auto_increment,
              `enID` BIGINT NOT NULL,
              `schedID` bigint(20) NOT NULL,
              `subjID` BIGINT NOT NULL,
              `pregrade` VARCHAR( 5 ) NOT NULL,
              `mgrade` VARCHAR( 5 ) NOT NULL,
              `prefigrade` VARCHAR( 5 ) NOT NULL,
              `fgrade` VARCHAR( 5 ) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`endID`),
			  KEY `subjID` (`subjID`),
			  KEY `schedID` (`schedID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	),
    11 => array(
    	'table_name'=> 'enrollment_table_logs',
    	'table_structure'=> "
    	   CREATE TABLE `enrollment_table_logs` (
              `logID` bigint(20) NOT NULL auto_increment,
              `docType` varchar(10) NOT NULL,
              `enID` bigint(20) NOT NULL,
              `logDate` datetime NOT NULL,
              `subjects` varchar(200) NOT NULL,
              `changeBy` VARCHAR( 36 ) NOT NULL,
              PRIMARY KEY  (`logID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    12 => array(
    	'table_name'=> 'enrollments',
    	'table_structure'=> "
    	   CREATE TABLE `enrollments` (
              `enID` bigint(20) NOT NULL auto_increment,
              `schYear` varchar(10) NOT NULL,
              `semCode` char(1) NOT NULL,
              `idno` varchar(15) NOT NULL,
              `curID` BIGINT NULL,
              `courseID` bigint(20) NOT NULL,
              `yrLevel` char(1) NOT NULL,
              `secID` BIGINT NULL,
              `dateCreated` datetime NOT NULL,
              `ttlUnits` float(5,1) NOT NULL,
              `encodedBy` varchar(36) NOT NULL,
              `lastEdited` datetime NOT NULL,
              `studType` tinyint(4) NOT NULL default '1',
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`enID`),
			  KEY `idno` (`idno`),
			  KEY `curID` (`curID`),
			  KEY `courseID` (`courseID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    13 => array(
    	'table_name'=> 'equivalency',
    	'table_structure'=> "
    	   CREATE TABLE `equivalency` (
              `eqID` bigint(20) NOT NULL auto_increment,
              `subjID` bigint(20) NOT NULL,
              `eqSubjID` bigint(20) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`eqID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    14 => array(
    	'table_name'=> 'grade_sheets',
    	'table_structure'=> "
    	   CREATE TABLE `grade_sheets` (
              `gsID` bigint(20) NOT NULL auto_increment,
              `schYear` varchar(10) NOT NULL,
              `semCode` char(1) NOT NULL,
              `profID` varchar(36) NOT NULL,
              `schedID` bigint(20) NOT NULL,
              `units` float(5,1) NOT NULL,
              `remarks` varchar(150) default NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`gsID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    15 => array(
    	'table_name'=> 'master_table_audit_logs',
    	'table_structure'=> "
    	   CREATE TABLE `master_table_audit_logs` (
              `logID` bigint(20) NOT NULL auto_increment,
              `docType` varchar(20) NOT NULL,
              `recID` bigint(20) NOT NULL,
              `logDate` datetime NOT NULL,
              `operation` varchar(10) NOT NULL,
              `fields` varchar(200) NOT NULL,
              `user_id` VARCHAR( 36 ) NOT NULL,
              PRIMARY KEY  (`logID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    16 => array(
    	'table_name'=> 'old_enrollment_details',
    	'table_structure'=> "
    	   CREATE TABLE `old_enrollment_details` (
              `oendID` bigint(20) NOT NULL auto_increment,
              `oenID` BIGINT NOT NULL,
              `subjID` bigint(20) NOT NULL,
              `fgrade` VARCHAR( 5 ) NOT NULL,
              `units` float(5,1) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`oendID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    17 => array(
    	'table_name'=> 'old_enrollments',
    	'table_structure'=> "
    	   CREATE TABLE `old_enrollments` (
              `oenID` bigint(20) NOT NULL auto_increment,
              `schYear` varchar(10) NOT NULL,
              `semCode` char(1) NOT NULL,
              `idno` varchar(15) NOT NULL,
              `courseID` bigint(20) NOT NULL,
              `yrLevel` char(1) NOT NULL,
              `dateCreated` datetime NOT NULL,
              `ttlUnits` float(5,1) NOT NULL,
              `remarks` varchar(150) default NULL,
              `encodedBy` VARCHAR( 32 ) NOT NULL,
              `lastEdited` DATETIME NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`oenID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    18 => array(
    	'table_name'=> 'prerequisites',
    	'table_structure'=> "
    	   CREATE TABLE `prerequisites` (
              `preID` bigint(20) NOT NULL auto_increment,
              `curID` bigint(20) NOT NULL,
              `subjID` bigint(20) NOT NULL,
              `preSubjID` bigint(20) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`preID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    19 => array(
    	'table_name'=> 'refunds',
    	'table_structure'=> "
    	   CREATE TABLE `refunds` (
              `refundID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `accID` bigint(20) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `semCode` char(1) NOT NULL,
              `date` datetime NOT NULL,
              `amount` float(15,2) NOT NULL,
              `preparedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`refundID`),
              KEY `idno` (`idno`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	   "
    	), 
    20 => array(
    	'table_name'=> 'schedules',
    	'table_structure'=> "
    	   CREATE TABLE `schedules` (
              `schedID` bigint(20) NOT NULL auto_increment,
              `schYear` VARCHAR( 10 ) NOT NULL,
              `yrLevel` CHAR( 1 ) NOT NULL,
              `semCode` CHAR( 1 ) NOT NULL,
              `curID` bigint(20) NOT NULL,
              `schedCode` varchar(10) NOT NULL,
              `courseID` bigint(20) NOT NULL,
              `subjID` bigint(20) NOT NULL,
              `profID` varchar(36) NOT NULL,
              `startTime` time NOT NULL,
              `endTime` time NOT NULL,
              `onMon` tinyint(4) NOT NULL,
              `onTue` tinyint(4) NOT NULL,
              `onWed` tinyint(4) NOT NULL,
              `onThu` tinyint(4) NOT NULL,
              `onFri` tinyint(4) NOT NULL,
              `onSat` tinyint(4) NOT NULL,
              `onSun` tinyint(4) NOT NULL,
              `room` varchar(15) NOT NULL,
              `maxCapacity` int(11) NOT NULL,
              `noReserved` int(11) NOT NULL,
              `noEnrolled` int(11) NOT NULL,
              `labFee` FLOAT( 15, 2 ) NOT NULL,
              `remarks` varchar(150) default NULL,
              `preparedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`schedID`),
			  KEY `subjID` (`subjID`),
			  KEY `curID` (`curID`),
			  KEY `courseID` (`courseID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    21 => array(
    	'table_name'=> 'school_fees',
    	'table_structure'=> "
    	   CREATE TABLE `school_fees` (
              `feeID` bigint(20) NOT NULL auto_increment,
              `account_code` int NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `courseID` bigint(20) NOT NULL,
              `yrLevel` CHAR( 1 ) NOT NULL,
              `item` varchar(100) NOT NULL,
              `amount` float(15,2) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`feeID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    22 => array(
    	'table_name'=> 'students',
    	'table_structure'=> "
    	  CREATE TABLE `students` (
          `recID` bigint(20) NOT NULL auto_increment,
          `idno` varchar(15) NOT NULL,
          `accID` bigint(20) NOT NULL,
          `curID` bigint(20) NOT NULL,
          `uname` varchar(30) NOT NULL,
          `pswd` varchar(36) NOT NULL,
          `tuitionFee` float(5,1) NOT NULL,
          `fname` varchar(25) NOT NULL,
          `lname` varchar(25) NOT NULL,
          `mname` varchar(25) NOT NULL,
          `courseID` bigint(20) NOT NULL,
          `yrLevel` char(1) NOT NULL,
          `gender` char(1) NOT NULL,
          `age` int(11) NOT NULL,
          `bday` date NOT NULL,
          `permanentAddr` varchar(150) NOT NULL,
          `currentAddr` varchar(150) default NULL,
          `phone` varchar(25) default NULL,
          `cstatus` char(1) NOT NULL,
          `nationality` varchar(20) NOT NULL,
          `motherName` varchar(70) default NULL,
          `fatherName` varchar(70) default NULL,
          `guardian` varchar(70) default NULL,
          `motherOccupation` varchar(25) default NULL,
          `fatherOccupation` varchar(25) default NULL,
          `guardianOccupation` varchar(25) default NULL,
          `motherContact` varchar(25) default NULL,
          `fatherContact` varchar(25) default NULL,
          `guardianContact` varchar(25) default NULL,
          `primary_edu` varchar(100) default NULL,
          `interm_edu` varchar(100) default NULL,
          `hs_edu` varchar(100) default NULL,
          `primary_schYear` varchar(10) default NULL,
          `interm_schYear` varchar(10) default NULL,
          `hs_schYear` varchar(10) default NULL,
          `entryDocs` varchar(50) NOT NULL,
          `entryDate` date NOT NULL,
          `rstatus` tinyint(4) NOT NULL default '1',
          PRIMARY KEY  (`recID`),
		  KEY `idno` (`idno`),
		  KEY `curID` (`curID`),
		  KEY `courseID` (`courseID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    23 => array(
    	'table_name'=> 'subjects',
    	'table_structure'=> "
    	   CREATE TABLE `subjects` (
              `subjID` bigint(20) NOT NULL auto_increment,
              `courseID` bigint(20) NOT NULL,
              `subjCode` varchar(20) NOT NULL,
              `descTitle` varchar(100) NOT NULL,
              `subjDesc` text,
              `units` float(5,1) NOT NULL,
              `type` TINYINT NOT NULL DEFAULT '1',
              `isCompSubj` TINYINT NOT NULL DEFAULT '0',
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`subjID`),
  			  KEY `courseID` (`courseID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    24 => array(
    	'table_name'=> 'temp_enrollment_details',
    	'table_structure'=> "
    	   CREATE TABLE `temp_enrollment_details` (
              `tedID` bigint(20) NOT NULL auto_increment,
              `schedID` bigint(20) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`tedID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    25 => array(
    	'table_name'=> 'temp_enrollments',
    	'table_structure'=> "
    	   CREATE TABLE `temp_enrollments` (
              `teID` bigint(20) NOT NULL auto_increment,
              `schYear` varchar(10) NOT NULL,
              `semCode` char(1) NOT NULL,
              `idno` varchar(15) NOT NULL,
              `courseID` bigint(20) NOT NULL,
              `yrLevel` char(1) NOT NULL,
              `dateCreated` datetime NOT NULL,
              `ttlUnits` float(5,2) NOT NULL,
              `lastEdited` datetime NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`teID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    26 => array(
    	'table_name'=> 'tor',
    	'table_structure'=> "
    	   CREATE TABLE `tor` (
          `torID` bigint(20) NOT NULL auto_increment,
          `recID` bigint(20) NOT NULL,
          `idno` varchar(15) NOT NULL,
          `endID` bigint(20) NOT NULL,
          `oendID` BIGINT NOT NULL,
          `creID` BIGINT NOT NULL,
          `schYear` varchar(10) NOT NULL,
          `semCode` char(1) NOT NULL,
          `yrLevel` char(1) NOT NULL,
          `subjID` bigint(20) NOT NULL,
          `fgrade` VARCHAR( 5 ) NOT NULL,
          `rstatus` tinyint(4) NOT NULL default '1',
          PRIMARY KEY  (`torID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    27 => array(
    	'table_name'=> 'tor_grade_logs',
    	'table_structure'=> "
    	   CREATE TABLE `tor_grade_logs` (
              `logID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `endID` bigint(20) NOT NULL,
              `changes` varchar(200) NOT NULL,
              `changeBy` VARCHAR( 36 ) NOT NULL,
              PRIMARY KEY  (`logID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ; 
    	   "
    	), 
    28 => array(
    	'table_name'=> 'account_details',
    	'table_structure'=> "
    	   CREATE TABLE `account_details` (
            `accDetailID` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `accID` BIGINT NOT NULL ,
            `feeType` VARCHAR( 15 ) NOT NULL ,
            `particular` VARCHAR( 100 ) NOT NULL ,
            `amount` FLOAT( 15, 2 ) NOT NULL ,
            `rstatus` TINYINT NOT NULL DEFAULT '1',
            INDEX ( `accID` )
            ) ENGINE = innodb;
    	    "
    	),
    29 => array(
    	'table_name'=> 'payment_table_logs',
    	'table_structure'=> "
    	   CREATE TABLE `payment_table_logs` (
			`logID` bigint( 20 ) NOT NULL AUTO_INCREMENT ,
			`docType` varchar( 20 ) NOT NULL ,
			`recID` bigint( 20 ) NOT NULL ,
			`logDate` datetime NOT NULL ,
			`operation` varchar( 10 ) NOT NULL ,
			`fields` varchar( 200 ) NOT NULL ,
			`user_id` varchar( 36 ) NOT NULL ,
			PRIMARY KEY ( `logID` )
			) ENGINE = InnoDB;
    	    "
    	),
    30 => array(
    	'table_name'=> 'account_table_logs',
    	'table_structure'=> "
    	   CREATE TABLE `account_table_logs` (
			  `logID` bigint(20) NOT NULL auto_increment,
			  `operation` varchar(10) NOT NULL,
			  `recID` bigint(20) NOT NULL,
			  `logDate` datetime NOT NULL,
			  `changes` varchar(200) NOT NULL,
			  `changeBy` varchar(36) NOT NULL,
			  PRIMARY KEY  (`logID`)
			) ENGINE=InnoDB ;
    	    "
    	),
    	
    31 => array(
    	'table_name'=> 'ordetails',
    	'table_structure'=> "
            CREATE TABLE `ordetails` (
              `ordno` int(11) NOT NULL auto_increment,
              `orno` char(10) NOT NULL,
              `account_code` int(11) NOT NULL,
              `amount` float(15,2) NOT NULL,
              PRIMARY KEY  (`ordno`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),

    32 => array(
    	'table_name'=> 'orheader',
    	'table_structure'=> "
            CREATE TABLE `orheader` (
              `paymentID` int(11) NOT NULL auto_increment,
              `orno` char(10) default NULL,
              `idno` char(15) default NULL,
              `accID` int(11) default NULL,
              `schYear` char(10) default NULL,
              `semCode` char(1) default NULL,
              `term` char(1) default NULL,
              `dateCreated` date default NULL,
              `timeCreated` TIME NOT NULL,
              `totalAmount` float(15,2) default NULL,
              `cashier` varchar(36) default NULL,
              `rstatus` tinyint(4) default '1',
              PRIMARY KEY  (`paymentID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),

	33 => array(
    	'table_name'=> 'misc',
    	'table_structure'=> "
           CREATE TABLE `misc` (
          `miscID` int(11) NOT NULL auto_increment,
          `schYear` varchar(10) NOT NULL,
          `courseID` int(11) NOT NULL,
          `yrLevel` char(1) NOT NULL,
          `particular` varchar(50) NOT NULL,
          `amount` float(15,2) NOT NULL,
          PRIMARY KEY  (`miscID`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
    	"
    	),

	34 => array(
    	'table_name'=> 'reservation',
    	'table_structure'=> "
           CREATE TABLE `reservation` (
		  `resID` bigint(20) NOT NULL auto_increment,
		  `idno` varchar(10) NOT NULL,
		  `courseID` bigint(20) NOT NULL,
		  `yrLevel` char(1) NOT NULL,
		  `semCode` char(1) NOT NULL,
		  `schYear` varchar(10) NOT NULL,
		  `remarks` varchar(150) default NULL,
		  `studType` tinyint(4) NOT NULL default '1',
		  `rstatus` tinyint(4) NOT NULL default '1',
		  PRIMARY KEY  (`resID`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    	"
    	),

	35 => array(
    	'table_name'=> 'reservation_details',
    	'table_structure'=> "
           CREATE TABLE `reservation_details` (
		  `resDetailID` bigint(20) NOT NULL auto_increment,
		  `resID` bigint(20) NOT NULL,
		  `subjID` bigint(20) NOT NULL,
		  `schedID` bigint(20) NOT NULL,
		  `secID` bigint(20) NOT NULL,
		  `profID` varchar(36) NOT NULL,
		  `rstatus` tinyint(4) NOT NULL default '1',
		  PRIMARY KEY  (`resDetailID`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    	"
    	),
    // constraints here
    37 => array(
    	'table_name'=> 'course constraints',
    	'table_structure'=> "
           ALTER TABLE `courses`
  			ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`deptID`) REFERENCES `departments` (`deptID`);
    	"
    	),
    38 => array(
    	'table_name'=> 'curriculums constraints',
    	'table_structure'=> "
           ALTER TABLE `curriculums`
  			ADD CONSTRAINT `curriculums_ibfk_1` FOREIGN KEY (`courseID`) REFERENCES `courses` (`courseID`);
    	"
    	),
    39 => array(
    	'table_name'=> 'curriculum_subjs constraints',
    	'table_structure'=> "
           ALTER TABLE `curriculum_subjs`
			ADD CONSTRAINT `curriculum_subjs_ibfk_1` FOREIGN KEY (`subjID`) REFERENCES `subjects` (`subjID`);
    	"
    	),
    40 => array(
    	'table_name'=> 'enrollments constraints',
    	'table_structure'=> "
           ALTER TABLE `enrollments`
		  ADD CONSTRAINT `enrollments_ibfk_4` FOREIGN KEY (`courseID`) REFERENCES `courses` (`courseID`),
		  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`idno`) REFERENCES `students` (`idno`);
    	"
    	),
    41 => array(
    	'table_name'=> 'enrollment_details constraints',
    	'table_structure'=> "
           ALTER TABLE `enrollment_details`
		  ADD CONSTRAINT `enrollment_details_ibfk_2` FOREIGN KEY (`subjID`) REFERENCES `subjects` (`subjID`),
		  ADD CONSTRAINT `enrollment_details_ibfk_1` FOREIGN KEY (`schedID`) REFERENCES `schedules` (`schedID`);
    	"
    	),
    42 => array(
    	'table_name'=> 'schedules constraints',
    	'table_structure'=> "
          ALTER TABLE `schedules`
		  ADD CONSTRAINT `schedules_ibfk_4` FOREIGN KEY (`subjID`) REFERENCES `subjects` (`subjID`),
		  ADD CONSTRAINT `schedules_ibfk_2` FOREIGN KEY (`curID`) REFERENCES `curriculums` (`curID`),
		  ADD CONSTRAINT `schedules_ibfk_3` FOREIGN KEY (`courseID`) REFERENCES `courses` (`courseID`);
    	"
    	),
     43 => array(
    	'table_name'=> 'subjects constraints',
    	'table_structure'=> "
          ALTER TABLE `subjects`
		  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`courseID`) REFERENCES `courses` (`courseID`);
    	"
    	),
),

$categoryDatabases[4].'Tables' => array(
    0 => array(
    	'table_name'=> 'account_notes',
    	'table_structure'=> "
    	   CREATE TABLE `account_notes` (
              `accNoteID` bigint(20) NOT NULL auto_increment,
              `accID` bigint(20) NOT NULL,
              `noteType` varchar(20) NOT NULL,
              `notes` text NOT NULL,
              `notedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`accNoteID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    1 => array(
    	'table_name'=> 'accounts',
    	'table_structure'=> "
    	   CREATE TABLE `accounts` (
              `accID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `yrLevel` CHAR( 1 ) NOT NULL,
              `oldBalance` float(15,2) NOT NULL,
              `totalFee` FLOAT( 15, 2 ) NOT NULL,
              `payment` FLOAT( 15, 2 ) NOT NULL,
              `balance` float(15,2) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`accID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    2 => array(
    	'table_name'=> 'assessments',
    	'table_structure'=> "
    	   CREATE TABLE `assessments` (
              `assID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `accID` bigint(20) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `yrLevel` CHAR( 1 ) NOT NULL,
              `term` tinyint(4) NOT NULL,
              `tuitionFee` float(15,2) NOT NULL,
              `labFee` float(15,2) NOT NULL,
              `regFee` float(15,2) NOT NULL,
              `miscFee` float(15,2) NOT NULL,
              `addAdj` float(15,2) NOT NULL,
              `lessAdj` float(15,2) NOT NULL,
              `oldBalance` float(15,2) NOT NULL,
              `totalFees` FLOAT( 15, 2 ) NOT NULL,
              `ttlPayment` FLOAT( 15, 2 ) NOT NULL,
              `balance` FLOAT( 15, 2 ) NOT NULL,
              `ttlDue` float(15,2) NOT NULL,
              `amtPaid` FLOAT( 15, 2 ) NOT NULL,
              `preparedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`assID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    3 => array(
    	'table_name'=> 'block_sections',
    	'table_structure'=> "
    	   CREATE TABLE `block_sections` (
              `secID` bigint(20) NOT NULL auto_increment,
              `secName` varchar(20) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `yrLevel` char(1) NOT NULL,
              `maxCapacity` INT NOT NULL,
              `noEnrolled` INT NOT NULL,
              `remarks` varchar(150) default NULL,
              `preparedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`secID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    4 => array(
    	'table_name'=> 'block_sections_details',
    	'table_structure'=> "
    	   CREATE TABLE `block_sections_details` (
              `secDetailID` bigint(20) NOT NULL auto_increment,
              `secID` bigint(20) NOT NULL,
              `schedID` bigint(20) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`secDetailID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    5 => array(
    	'table_name'=> 'configurations',
    	'table_structure'=> "
    	   CREATE TABLE `configurations` (
              `configID` bigint(20) NOT NULL auto_increment,
              `title` varchar(30) NOT NULL,
              `definition` text NOT NULL,
              `rstatus` tinyint(4) NOT NULL DEFAULT '1',
              PRIMARY KEY  (`configID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    6 => array(
    	'table_name'=> 'enrollment_details',
    	'table_structure'=> "
    	   CREATE TABLE `enrollment_details` (
              `endID` bigint(20) NOT NULL auto_increment,
              `enID` BIGINT NOT NULL,
              `schedID` bigint(20) NOT NULL,
              `subjID` BIGINT NOT NULL,
              `firstgrade` float(5,1) NOT NULL,
              `secondgrade` float(5,1) NOT NULL,
              `thirdgrade` float(5,1) NOT NULL,
              `fourthgrade` float(5,1) NOT NULL,
              `fgrade` float(5,1) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`endID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    7 => array(
    	'table_name'=> 'enrollment_table_logs',
    	'table_structure'=> "
    	   CREATE TABLE `enrollment_table_logs` (
              `logID` bigint(20) NOT NULL auto_increment,
              `docType` varchar(10) NOT NULL,
              `enID` bigint(20) NOT NULL,
              `logDate` datetime NOT NULL,
              `subjects` varchar(200) NOT NULL,
              `changeBy` VARCHAR( 36 ) NOT NULL,
              PRIMARY KEY  (`logID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    8 => array(
    	'table_name'=> 'enrollments',
    	'table_structure'=> "
    	   CREATE TABLE `enrollments` (
              `enID` bigint(20) NOT NULL auto_increment,
              `schYear` varchar(10) NOT NULL,
              `idno` varchar(15) NOT NULL,
              `yrLevel` char(1) NOT NULL,
              `secID` BIGINT NULL,
              `dateCreated` datetime NOT NULL,
              `ttlUnits` float(5,1) NOT NULL,
              `encodedBy` varchar(36) NOT NULL,
              `lastEdited` datetime NOT NULL,
              `studType` tinyint(4) NOT NULL default '1',
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`enID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    9 => array(
    	'table_name'=> 'form137',
    	'table_structure'=> "
	       CREATE TABLE `form137` (
              `gradeID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `yrLevel` CHAR( 1 ) NOT NULL,
              `endID` bigint(20) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `subjID` bigint(20) NOT NULL,
              `firstgrade` float(5,1) NOT NULL,
              `secondgrade` float(5,1) NOT NULL,
              `thirdgrade` float(5,1) NOT NULL,
              `fourthgrade` float(5,1) NOT NULL,
              `fgrade` float(5,1) NOT NULL,
              `units` float(5,1) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`gradeID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;
    	    "
    	),
    10 => array(
    	'table_name'=> 'form137_grade_logs',
    	'table_structure'=> "
    	   CREATE TABLE `form137_grade_logs` (
              `logID` bigint(20) NOT NULL,
              `idno` varchar(15) NOT NULL,
              `endID` bigint(20) NOT NULL,
              `changes` varchar(200) NOT NULL,
              `changeBy` VARCHAR( 36 ) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    	    "
    	),
    11 => array(
    	'table_name'=> 'grade_sheets',
    	'table_structure'=> "
    	   CREATE TABLE `grade_sheets` (
              `gsID` bigint(20) NOT NULL auto_increment,
              `schYear` varchar(10) NOT NULL,
              `profID` varchar(36) NOT NULL,
              `schedID` bigint(20) NOT NULL,
              `units` float(5,1) NOT NULL,
              `remarks` varchar(150) default NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`gsID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    12 => array(
    	'table_name'=> 'master_table_audit_logs',
    	'table_structure'=> "
    	   CREATE TABLE `master_table_audit_logs` (
              `logID` bigint(20) NOT NULL auto_increment,
              `docType` varchar(20) NOT NULL,
              `recID` bigint(20) NOT NULL,
              `logDate` datetime NOT NULL,
              `operation` varchar(10) NOT NULL,
              `fields` varchar(200) NOT NULL,
              `user_id` VARCHAR( 36 ) NOT NULL,
              PRIMARY KEY  (`logID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    13 => array(
    	'table_name'=> 'refunds',
    	'table_structure'=> "
           CREATE TABLE `refunds` (
              `refundID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `accID` bigint(20) NOT NULL,
              `schYear` varchar(10) NOT NULL,
              `date` datetime NOT NULL,
              `amount` float(15,2) NOT NULL,
              `preparedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`refundID`),
              KEY `idno` (`idno`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    14 => array(
    	'table_name'=> 'registrations',
    	'table_structure'=> "
    	   CREATE TABLE `registrations` (
              `regID` bigint(20) NOT NULL auto_increment,
              `fname` varchar(25) NOT NULL,
              `lname` varchar(25) NOT NULL,
              `mname` varchar(25) NOT NULL,
              `gender` char(1) NOT NULL,
              `age` int(11) NOT NULL,
              `bday` date NOT NULL,
              `cstatus` char(1) NOT NULL,
              `nationality` varchar(20) NOT NULL,
              `entryDocs` varchar(50) NOT NULL,
              `lastSchool` VARCHAR( 70 ) NULL,
              `sch_last_attended` date NOT NULL,
              `regDate` DATE NOT NULL,
              `encodedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`regID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    15 => array(
    	'table_name'=> 'schedules',
    	'table_structure'=> "
    	   CREATE TABLE `schedules` (
     	      `schedID` bigint(20) NOT NULL auto_increment,
    	      `schYear` VARCHAR( 10 ) NOT NULL,
    	      `yrLevel` CHAR( 1 ) NOT NULL,
              `schedCode` varchar(10) NOT NULL,
              `subjID` bigint(20) NOT NULL,
              `profID` varchar(36) NOT NULL,
              `startTime` time NOT NULL,
              `endTime` time NOT NULL,
              `onMon` tinyint(4) NOT NULL,
              `onTue` tinyint(4) NOT NULL,
              `onWed` tinyint(4) NOT NULL,
              `onThu` tinyint(4) NOT NULL,
              `onFri` tinyint(4) NOT NULL,
              `onSat` tinyint(4) NOT NULL,
              `onSun` tinyint(4) NOT NULL,
              `room` varchar(15) NOT NULL,
              `maxCapacity` int(11) NOT NULL,
              `noEnrolled` int(11) NOT NULL,
              `labFee` FLOAT( 15, 2 ) NOT NULL,
              `remarks` varchar(150) default NULL,
              `preparedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`schedID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    16 => array(
    	'table_name'=> 'school_fees',
    	'table_structure'=> "
    	   CREATE TABLE `school_fees` (
              `feeID` bigint(20) NOT NULL auto_increment,
              `schYear` varchar(10) NOT NULL,
              `account_code` int(11) NOT NULL,
              `yrLevel` CHAR( 1 ) NOT NULL,
              `item` varchar(100) NOT NULL,
              `amount` float(15,2) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`feeID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    17 => array(
    	'table_name'=> 'students',
    	'table_structure'=> "
            CREATE TABLE `students` (
              `recID` bigint(20) NOT NULL auto_increment,
              `idno` varchar(15) NOT NULL,
              `accID` bigint(20) NOT NULL,
              `regID` bigint(20) NOT NULL,
              `fname` varchar(25) NOT NULL,
              `lname` varchar(25) NOT NULL,
              `mname` varchar(25) NOT NULL,
              `yrLevel` char(1) NOT NULL,
              `gender` char(1) NOT NULL,
              `age` int(11) NOT NULL,
              `bday` date NOT NULL,
              `permanentAddr` varchar(150) NOT NULL,
              `currentAddr` varchar(150) default NULL,
              `phone` varchar(25) default NULL,
              `cstatus` char(1) NOT NULL,
              `nationality` varchar(20) NOT NULL,
              `motherName` varchar(70) default NULL,
              `fatherName` varchar(70) default NULL,
              `guardian` varchar(70) default NULL,
              `motherOccupation` varchar(25) NOT NULL,
              `fatherOccupation` varchar(25) NOT NULL,
              `guardianOccupation` varchar(25) NOT NULL,
              `motherContact` varchar(25) NOT NULL,
              `fatherContact` varchar(25) NOT NULL,
              `guardianContact` varchar(25) NOT NULL,
              `entryDocs` varchar(50) NOT NULL,
              `entryDate` date NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`recID`),
              KEY `idno` (`idno`)
            ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    18 => array(
    	'table_name'=> 'subjects',
    	'table_structure'=> "
    	   CREATE TABLE `subjects` (
              `subjID` bigint(20) NOT NULL auto_increment,
              `yrLevel` char(1) NOT NULL,
              `subjCode` varchar(20) NOT NULL,
              `descTitle` varchar(100) NOT NULL,
              `subjDesc` text,
              `units` float(5,1) NOT NULL,
              `type` TINYINT NOT NULL DEFAULT '1',
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`subjID`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

    	    "
    	),
    19 => array(
    	'table_name'=> 'registration_payments',
    	'table_structure'=> "
    	   CREATE TABLE `registration_payments` (
              `regPaymentID` bigint(20) NOT NULL auto_increment,
              `schYear` varchar(10) NOT NULL,
              `idno` varchar(15) NOT NULL,
              `ORno` varchar(10) NOT NULL,
              `type` char(1) NOT NULL default '1' COMMENT '1=Registration ; 2=Down Payment',
              `date` date NOT NULL,
              `amount` float(15,2) NOT NULL,
              `encodedBy` varchar(36) NOT NULL,
              `rstatus` tinyint(4) NOT NULL default '1',
              PRIMARY KEY  (`regPaymentID`),
              KEY `idno` (`idno`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8;

    	    "
    	),
    20 => array(
    	'table_name'=> 'account_details',
    	'table_structure'=> "
    	   CREATE TABLE `account_details` (
            `accDetailID` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `accID` BIGINT NOT NULL ,
            `feeType` VARCHAR( 15 ) NOT NULL ,
            `particular` VARCHAR( 100 ) NOT NULL ,
            `amount` FLOAT( 15, 2 ) NOT NULL ,
            `rstatus` TINYINT NOT NULL DEFAULT '1',
            INDEX ( `accID` )
            ) ENGINE = innodb;
    	    "
    	),
    21 => array(
    	'table_name'=> 'payment_table_logs',
    	'table_structure'=> "
    	   CREATE TABLE `payment_table_logs` (
			`logID` bigint( 20 ) NOT NULL AUTO_INCREMENT ,
			`docType` varchar( 20 ) NOT NULL ,
			`recID` bigint( 20 ) NOT NULL ,
			`logDate` datetime NOT NULL ,
			`operation` varchar( 10 ) NOT NULL ,
			`fields` varchar( 200 ) NOT NULL ,
			`user_id` varchar( 36 ) NOT NULL ,
			PRIMARY KEY ( `logID` )
			) ENGINE = InnoDB;
    	    "
    	),
    22 => array(
    	'table_name'=> 'account_table_logs',
    	'table_structure'=> "
    	   CREATE TABLE `account_table_logs` (
			  `logID` bigint(20) NOT NULL auto_increment,
			  `operation` varchar(10) NOT NULL,
			  `recID` bigint(20) NOT NULL,
			  `logDate` datetime NOT NULL,
			  `changes` varchar(200) NOT NULL,
			  `changeBy` varchar(36) NOT NULL,
			  PRIMARY KEY  (`logID`)
			) ENGINE=InnoDB ;
    	    "
    	),
    23 => array(
    	'table_name'=> 'misc',
    	'table_structure'=> "
			CREATE TABLE `misc` (
			  `miscID` int(11) NOT NULL auto_increment,
			  `schYear` varchar(10) NOT NULL,
			  `yrLevel` char(1) NOT NULL,
			  `particular` varchar(50) NOT NULL,
			  `amount` float(15,2) NOT NULL,
			  PRIMARY KEY  (`miscID`)
			) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
    	    "
    	),
    	
    24 => array(
    	'table_name'=> 'orheader',
    	'table_structure'=> "
            CREATE TABLE `orheader` (
              `paymentID` int(11) NOT NULL auto_increment,
              `orno` char(10) default NULL,
              `idno` char(15) default NULL,
              `accID` int(11) default NULL,
              `schYear` char(10) default NULL,
              `term` char(1) default NULL,
              `dateCreated` date default NULL,
              `timeCreated` time NOT NULL,
              `totalAmount` float(15,2) default NULL,
              `cashier` varchar(36) default NULL,
              `rstatus` tinyint(4) default '1',
              PRIMARY KEY  (`paymentID`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),
    	
    25 => array(
    	'table_name'=> 'ordetails',
    	'table_structure'=> "
            CREATE TABLE `ordetails` (
              `ordno` int(11) NOT NULL auto_increment,
              `orno` char(10) NOT NULL,
              `account_code` int(11) NOT NULL,
              `amount` float(15,2) NOT NULL,
              PRIMARY KEY  (`ordno`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
    	    "
    	),    	
)

);


echo "<br><b>Creating Custom Tables</b><br>";
// ******************************* create custom tables **************************************

foreach ($customTables['frameworkTables'] as $row) {
	mysql_query($row['table_structure']);
	if (!mysql_error()) {
		echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".$row['table_name']."...</b>&nbsp;&nbsp;&nbsp;&nbsp;done";
	}
}
// ******************************* end custom tables **************************************


// ******************************* create database(elementary/highschool/college/preschool) tables **************************************
foreach ($categoryDatabases as $rdb) {
    mysql_select_db($rdb);
    echo "<br><br><b>Creating ".$categoryDatabases[1]." Database Tables</b><br>";
    // ******************************* create $rdb tables **************************************
    
    foreach ($customTables[$rdb."Tables"] as $row) {
    	mysql_query($row['table_structure']);
    	if (!mysql_error()) {
    		echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".$row['table_name']."...</b>&nbsp;&nbsp;&nbsp;&nbsp;done";
    	}
    }
    // ******************************* end $rdb tables **************************************
}


// this will back to the framework default database
global $setup_db_database_name;
mysql_select_db($setup_db_database_name);

?>

