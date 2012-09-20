<?php
namespace org\opencomb\openoa\setup;

use org\jecat\framework\db\DB ;
use org\jecat\framework\message\Message;
use org\jecat\framework\message\MessageQueue;
use org\opencomb\platform\ext\Extension;
use org\opencomb\platform\ext\ExtensionMetainfo ;
use org\opencomb\platform\ext\IExtensionDataInstaller ;
use org\jecat\framework\fs\Folder;

// 这个 DataInstaller 程序是由扩展 development-toolkit 的 create data installer 模块自动生成
// 扩展 development-toolkit 版本：0.2.0.0
// create data installer 模块版本：1.0.10.0

class DataInstaller implements IExtensionDataInstaller
{
	public function install(MessageQueue $aMessageQueue,ExtensionMetainfo $aMetainfo)
	{
		$aExtension = new Extension($aMetainfo);
		
		// 1 . create data table
		
		$aDB = DB::singleton();
		
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_AssetManagement")."` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `sid` varchar(30) NOT NULL COMMENT '资产编号',
  `name` varchar(255) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1:在库;2:领用;3:维修;4:报废',
  PRIMARY KEY (`aid`),
  UNIQUE KEY `sid` (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_AssetManagement') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_AssetType")."` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`tid`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_AssetType') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_ContractManagement")."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` varchar(20) DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `starttime` int(11) NOT NULL COMMENT '合同时间始',
  `endtime` int(11) NOT NULL COMMENT '合同时间止',
  `remindtime` int(11) NOT NULL COMMENT '到期提醒时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_ContractManagement') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_DemissionMnagement")."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eid` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_DemissionMnagement') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_DepartmentManagement")."` (
  `did` int(11) NOT NULL AUTO_INCREMENT,
  `DepartmentName` varchar(32) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`did`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_DepartmentManagement') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_EmployeeManagement")."` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `eid` varchar(20) DEFAULT NULL COMMENT '员工工号',
  `name` varchar(10) DEFAULT NULL,
  `position` varchar(20) DEFAULT NULL COMMENT '职务',
  `sex` tinyint(1) NOT NULL,
  `birthday` varchar(10) DEFAULT NULL,
  `policital` varchar(20) DEFAULT NULL COMMENT '政治面貌',
  `worktime` int(100) NOT NULL,
  `protitle` varchar(20) DEFAULT NULL COMMENT '技术职称',
  `education` varchar(20) DEFAULT NULL COMMENT '学历',
  `graduationtime` varchar(10) NOT NULL,
  `school` varchar(50) DEFAULT NULL,
  `major` varchar(50) DEFAULT NULL COMMENT '专业',
  `factorytime` varchar(10) NOT NULL,
  `department` varchar(255) DEFAULT NULL COMMENT '部门',
  `phone` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1:在职,2:离职',
  `contract` int(1) NOT NULL DEFAULT '2' COMMENT '1:签订合同,2:未签订合同',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_EmployeeManagement') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_PersonnelContract")."` (
  `firsttime` int(11) NOT NULL,
  `lasttime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_PersonnelContract') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_PositionManagement")."` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_PositionManagement') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_Process_Node")."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) DEFAULT NULL,
  `gid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_Process_Node') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_Process_Record")."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `tid` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `date1` datetime NOT NULL,
  `date2` datetime NOT NULL,
  `explain` text NOT NULL,
  `nowNid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_Process_Record') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_Process_Record_Details")."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) DEFAULT NULL,
  `ids` int(11) DEFAULT NULL,
  `type` enum('node','status') NOT NULL COMMENT '0=node,1=status',
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_Process_Record_Details') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_Process_Status")."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` int(11) DEFAULT NULL,
  `tonid` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_Process_Status') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_Process_Task")."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `explain` text,
  `extension` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_Process_Task') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_ProjectManagement")."` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT '',
  `type` int(11) NOT NULL,
  `starttime` int(11) NOT NULL,
  `endtime` int(11) NOT NULL,
  `content` varchar(255) DEFAULT NULL,
  `publisher` int(11) NOT NULL,
  `responsibleperson` int(11) NOT NULL,
  `purview` int(1) DEFAULT '1' COMMENT '1:责任人；2;所有人',
  `remind` int(11) NOT NULL,
  `department` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1:进行中;2:终止;3:完成;4;暂停;5:延迟',
  `rates` int(11) NOT NULL DEFAULT '0',
  `bname` varchar(20) DEFAULT NULL,
  `bdepartment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_ProjectManagement') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_ProjectType")."` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_ProjectType') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_attendance_detail")."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `date` date NOT NULL,
  `am` time NOT NULL,
  `pm` time NOT NULL,
  `sort` tinyint(1) NOT NULL,
  `explain` varchar(255) NOT NULL,
  `verify` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='考勤表'" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_attendance_detail') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_message")."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `touid` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `draft` tinyint(1) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='考勤表'" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_message') );
		
		$aDB->execute( "CREATE TABLE IF NOT EXISTS `".$aDB->transTableName("openoa_message_attachment")."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mid` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='考勤表'" );
		$aMessageQueue->create(Message::success,'新建数据表： `%s` 成功',$aDB->transTableName('openoa_message_attachment') );
		
		
		// 2. insert table data
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_AssetManagement") . '` (`aid`,`sid`,`name`,`type`,`status`) VALUES ("1","0","sdfsdfsdf","2","4") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_AssetManagement") . '` (`aid`,`sid`,`name`,`type`,`status`) VALUES ("2","bianji","45445","4","3") ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_AssetManagement"),$nDataRows));
			
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_AssetType") . '` (`tid`,`name`) VALUES ("2","ewerwer") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_AssetType") . '` (`tid`,`name`) VALUES ("1","sdfsdf") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_AssetType") . '` (`tid`,`name`) VALUES ("3","w434") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_AssetType") . '` (`tid`,`name`) VALUES ("4","wwwerdd") ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_AssetType"),$nDataRows));
			
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ContractManagement") . '` (`id`,`cid`,`uid`,`starttime`,`endtime`,`remindtime`) VALUES ("7","test1","5","915120000","1354291200","1349020800") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ContractManagement") . '` (`id`,`cid`,`uid`,`starttime`,`endtime`,`remindtime`) VALUES ("8","test2","8","319910400","1345478400","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ContractManagement") . '` (`id`,`cid`,`uid`,`starttime`,`endtime`,`remindtime`) VALUES ("9","34234","6","2649600","2649600","-2620800") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ContractManagement") . '` (`id`,`cid`,`uid`,`starttime`,`endtime`,`remindtime`) VALUES ("10","234234","24","2649600","2649600","-2620800") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ContractManagement") . '` (`id`,`cid`,`uid`,`starttime`,`endtime`,`remindtime`) VALUES ("11","","9","2649600","2649600","-2620800") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ContractManagement") . '` (`id`,`cid`,`uid`,`starttime`,`endtime`,`remindtime`) VALUES ("12","44444","9","1344355200","1347638400","1342368000") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ContractManagement") . '` (`id`,`cid`,`uid`,`starttime`,`endtime`,`remindtime`) VALUES ("13","66666","6","1344355200","1354982400","1349712000") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ContractManagement") . '` (`id`,`cid`,`uid`,`starttime`,`endtime`,`remindtime`) VALUES ("14","88899988","23","1344355200","1355241600","1349971200") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ContractManagement") . '` (`id`,`cid`,`uid`,`starttime`,`endtime`,`remindtime`) VALUES ("15","61213","22","1344355200","1355241600","1349971200") ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_ContractManagement"),$nDataRows));
			
		
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("7","qixiu","3434234234") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("8","234",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("9","34344",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("12","2323",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("13","1111",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("14","4555",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("15","11223",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("16","333333",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("17","4444444",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("18","5555555",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("19","666666",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("20","a",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("21","b",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("22","c",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("23","d",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("24","e",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("25","f",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("26","g",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("27","h",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("28","i",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("29","j",NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_DepartmentManagement") . '` (`did`,`DepartmentName`,`Description`) VALUES ("30","k",NULL) ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_DepartmentManagement"),$nDataRows));
			
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_EmployeeManagement") . '` (`uid`,`eid`,`name`,`position`,`sex`,`birthday`,`policital`,`worktime`,`protitle`,`education`,`graduationtime`,`school`,`major`,`factorytime`,`department`,`phone`,`status`,`contract`) VALUES ("21","323333333","123123123","3","1",NULL,"","0","","","0","","","0","102","2147483647","2","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_EmployeeManagement") . '` (`uid`,`eid`,`name`,`position`,`sex`,`birthday`,`policital`,`worktime`,`protitle`,`education`,`graduationtime`,`school`,`major`,`factorytime`,`department`,`phone`,`status`,`contract`) VALUES ("22","ksjdkfjs",NULL,"3","1",NULL,"sdf","0",NULL,"sdfs","0","sdfsdf","sdfsdf","0","102","0","1","1") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_EmployeeManagement") . '` (`uid`,`eid`,`name`,`position`,`sex`,`birthday`,`policital`,`worktime`,`protitle`,`education`,`graduationtime`,`school`,`major`,`factorytime`,`department`,`phone`,`status`,`contract`) VALUES ("23","234234",NULL,"3","1",NULL,"234234","0",NULL,"","0","","","0","102","234","1","1") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_EmployeeManagement") . '` (`uid`,`eid`,`name`,`position`,`sex`,`birthday`,`policital`,`worktime`,`protitle`,`education`,`graduationtime`,`school`,`major`,`factorytime`,`department`,`phone`,`status`,`contract`) VALUES ("24","234234dee",NULL,"3","1",NULL,"","0",NULL,"","0","","","0","102","0","1","1") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_EmployeeManagement") . '` (`uid`,`eid`,`name`,`position`,`sex`,`birthday`,`policital`,`worktime`,`protitle`,`education`,`graduationtime`,`school`,`major`,`factorytime`,`department`,`phone`,`status`,`contract`) VALUES ("26","001",NULL,"3","1",NULL,"","0",NULL,"","0","","","0","102","0","1","2") ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_EmployeeManagement"),$nDataRows));
			
		
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_PositionManagement") . '` (`pid`,`name`) VALUES ("5","342342") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_PositionManagement") . '` (`pid`,`name`) VALUES ("4","dsfsdf") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_PositionManagement") . '` (`pid`,`name`) VALUES ("6","反反复复飞") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_PositionManagement") . '` (`pid`,`name`) VALUES ("3","组长") ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_PositionManagement"),$nDataRows));
			
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Node") . '` (`id`,`tid`,`gid`,`name`) VALUES ("1","1","102","") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Node") . '` (`id`,`tid`,`gid`,`name`) VALUES ("2","1","97","") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Node") . '` (`id`,`tid`,`gid`,`name`) VALUES ("3","2","98","") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Node") . '` (`id`,`tid`,`gid`,`name`) VALUES ("4","3","100","") ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_Process_Node"),$nDataRows));
			
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Record") . '` (`id`,`uid`,`tid`,`title`,`date1`,`date2`,`explain`,`nowNid`) VALUES ("1","9","1","我要旅游","2012-09-14 14:18:05","2012-09-14 14:18:05","","-1") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Record") . '` (`id`,`uid`,`tid`,`title`,`date1`,`date2`,`explain`,`nowNid`) VALUES ("2","9","1","111","2012-09-20 14:46:08","2012-09-20 14:46:08","222","2") ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_Process_Record"),$nDataRows));
			
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Record_Details") . '` (`id`,`rid`,`ids`,`type`,`datetime`) VALUES ("1","1","1","node","2012-09-14 14:18:17") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Record_Details") . '` (`id`,`rid`,`ids`,`type`,`datetime`) VALUES ("2","1","1","status","2012-09-14 14:18:37") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Record_Details") . '` (`id`,`rid`,`ids`,`type`,`datetime`) VALUES ("3","1","2","node","2012-09-14 14:18:37") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Record_Details") . '` (`id`,`rid`,`ids`,`type`,`datetime`) VALUES ("4","1","5","status","2012-09-14 14:18:45") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Record_Details") . '` (`id`,`rid`,`ids`,`type`,`datetime`) VALUES ("5","1","-1","node","2012-09-14 14:18:45") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Record_Details") . '` (`id`,`rid`,`ids`,`type`,`datetime`) VALUES ("6","2","1","node","2012-09-20 14:46:14") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Record_Details") . '` (`id`,`rid`,`ids`,`type`,`datetime`) VALUES ("7","2","1","status","2012-09-20 15:38:34") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Record_Details") . '` (`id`,`rid`,`ids`,`type`,`datetime`) VALUES ("8","2","2","node","2012-09-20 15:38:34") ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_Process_Record_Details"),$nDataRows));
			
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("1","1","2","同意") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("2","1","-2","不同意") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("3","1","-3","打回") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("4","1","-3","关闭") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("5","2","-1","同意") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("6","2","-2","不同意") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("7","2","1","打回") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("8","2","-3","关闭") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("9","3","-1","同意") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("10","3","-2","不同意") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("11","3","-3","打回") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("12","3","-3","关闭") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("13","4","-1","同意") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("14","4","-2","不同意") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("15","4","-3","打回") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Status") . '` (`id`,`nid`,`tonid`,`name`) VALUES ("16","4","-3","关闭") ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_Process_Status"),$nDataRows));
			
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Task") . '` (`id`,`nid`,`name`,`explain`,`extension`) VALUES ("1",NULL,"请假申请","请假申请","Leave") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Task") . '` (`id`,`nid`,`name`,`explain`,`extension`) VALUES ("2",NULL,"加班申请","加班申请","") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_Process_Task") . '` (`id`,`nid`,`name`,`explain`,`extension`) VALUES ("3",NULL,"外出申请","外出申请","") ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_Process_Task"),$nDataRows));
			
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("1","","0","0","0","0","0","0","0","0","0","0","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("2","","234","0","0","0","0","0","0","0","0","0","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("3","sdfsdf","2","2649600","2649600",NULL,"0","0",NULL,"0","0","0","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("5","test1","2","2649600","2649600",NULL,"0","21",NULL,"10","102","5","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("6","test2twerwerwerwerwerwer","2","2649600","2649600","","10","9",NULL,"10","113","3","60",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("7","wwewefwef","2","2649600","2649600",NULL,"0","22",NULL,"0","102","3","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("8","12","2","2649600","2649600","","0","25",NULL,"0","113","3","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("9","13","2","2649600","2649600","","0","25",NULL,"0","113","3","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("10","23324sdf","2","2649600","2649600",NULL,"0","25",NULL,"0","113","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("11","sdfsdf","2","1346256000","1346256000",NULL,"0","25",NULL,"0","113","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("12","23324sdf","2","2649600","2649600",NULL,"0","25",NULL,"0","113","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("13","werwerwer","2","1348070400","1348070400",NULL,"0","25",NULL,"0","113","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("14","","2","2649600","1345392000",NULL,"10","25",NULL,"0","113","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("15","test09-01","2","2649600","915120000",NULL,"10","19",NULL,"0","113","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("16","sdfsdfsdf","2","2649600","2649600",NULL,"10","10",NULL,"0","113","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("17","sdfsdfsdf","2","1348156800","1348156800",NULL,"10","10",NULL,"0","113","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("18","23423wsr","2","1350662400","1350662400",NULL,"10","10",NULL,"0","113","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("19","testRemind","2","2649600","2649600",NULL,"10","0","1","0","113","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("20","33333333","2","2649600","2649600",NULL,"10","0","2","0","113","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("21","ssdfsdf","2","2649600","2649600","","10","0","2","1","113","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("22","323424","2","2649600","2649600","","10","25",NULL,"2","113","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("23","234234111111","2","2649600","2649600","","10","0","1","1","113","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("24","2342testeee","2","2649600","2649600",NULL,"10","0","2","1","113","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("25","按时打算打算的","2","1344355200","1355241600","","1","20","2","3","102","1","60",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("26","阿斯达撒旦撒大赛的爱上","2","1344355200","1355241600","","1","5","2","3","102","2","60",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("27","更还没搞好发个帖若","2","1344355200","1355241600","","1","6",NULL,"1","102","3","100",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("28","大范甘迪鬼地方个电饭锅地方个","2","1344355200","1355241600","","1","7",NULL,"0","102","4","50",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("29","根深蒂固挨个","2","1344355200","1355241600","","1","24","1","1","98","5","80",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("30","werwe","2","2649600","2649600","sdfsdfsdfsdf","10","10",NULL,"0","102","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("31","testContract122222","2","1344355200","1355241600","sdfsdfsdfdsf","10","0",NULL,"0","102","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("32","DSDASDASDAS","2","1344355200","1355241600",NULL,"1","7",NULL,"0","102","1","0",NULL,NULL) ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectManagement") . '` (`pid`,`name`,`type`,`starttime`,`endtime`,`content`,`publisher`,`responsibleperson`,`purview`,`remind`,`department`,`status`,`rates`,`bname`,`bdepartment`) VALUES ("33","dddddddddd","2","1344355200","1355241600",NULL,"10","0",NULL,"0","102","1","0",NULL,NULL) ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_ProjectManagement"),$nDataRows));
			
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_ProjectType") . '` (`pid`,`type`) VALUES ("2","3333") ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_ProjectType"),$nDataRows));
			
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_attendance_detail") . '` (`id`,`uid`,`date`,`am`,`pm`,`sort`,`explain`,`verify`) VALUES ("1","9","2012-08-27","08:10:00","17:30:00","1","","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_attendance_detail") . '` (`id`,`uid`,`date`,`am`,`pm`,`sort`,`explain`,`verify`) VALUES ("2","9","2012-08-29","10:09:06","10:58:25","0","","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_attendance_detail") . '` (`id`,`uid`,`date`,`am`,`pm`,`sort`,`explain`,`verify`) VALUES ("3","9","2012-08-29","13:30:00","17:30:00","1","","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_attendance_detail") . '` (`id`,`uid`,`date`,`am`,`pm`,`sort`,`explain`,`verify`) VALUES ("4","9","2012-08-30","08:30:00","11:00:00","5","","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_attendance_detail") . '` (`id`,`uid`,`date`,`am`,`pm`,`sort`,`explain`,`verify`) VALUES ("5","9","2012-08-31","08:09:06","22:58:25","0","","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_attendance_detail") . '` (`id`,`uid`,`date`,`am`,`pm`,`sort`,`explain`,`verify`) VALUES ("6","10","2012-08-30","08:30:00","17:30:00","1","sdfsdf","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_attendance_detail") . '` (`id`,`uid`,`date`,`am`,`pm`,`sort`,`explain`,`verify`) VALUES ("10","10","2012-09-13","12:06:09","12:06:19","0","","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_attendance_detail") . '` (`id`,`uid`,`date`,`am`,`pm`,`sort`,`explain`,`verify`) VALUES ("9","9","2012-09-12","16:16:30","16:16:51","0","","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_attendance_detail") . '` (`id`,`uid`,`date`,`am`,`pm`,`sort`,`explain`,`verify`) VALUES ("12","9","2012-09-14","17:44:30","17:53:43","0","","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_attendance_detail") . '` (`id`,`uid`,`date`,`am`,`pm`,`sort`,`explain`,`verify`) VALUES ("13","9","2012-09-17","11:31:51","11:31:56","0","","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_attendance_detail") . '` (`id`,`uid`,`date`,`am`,`pm`,`sort`,`explain`,`verify`) VALUES ("14","9","2012-09-20","12:06:35","00:00:00","0","","0") ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_attendance_detail"),$nDataRows));
			
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message") . '` (`id`,`uid`,`touid`,`title`,`content`,`draft`,`type`,`date`) VALUES ("1","9","21","","","0","0","2012-08-27") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message") . '` (`id`,`uid`,`touid`,`title`,`content`,`draft`,`type`,`date`) VALUES ("10","9","9","月月月333","圭","0","0","0000-00-00") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message") . '` (`id`,`uid`,`touid`,`title`,`content`,`draft`,`type`,`date`) VALUES ("9","9","9","月月月","圭","0","0","0000-00-00") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message") . '` (`id`,`uid`,`touid`,`title`,`content`,`draft`,`type`,`date`) VALUES ("6","9","9","eee","eee","0","0","0000-00-00") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message") . '` (`id`,`uid`,`touid`,`title`,`content`,`draft`,`type`,`date`) VALUES ("7","9","9","3333","3333","0","0","0000-00-00") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message") . '` (`id`,`uid`,`touid`,`title`,`content`,`draft`,`type`,`date`) VALUES ("8","9","9","444","444","1","0","0000-00-00") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message") . '` (`id`,`uid`,`touid`,`title`,`content`,`draft`,`type`,`date`) VALUES ("12","9","9","333",NULL,NULL,"file","0000-00-00") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message") . '` (`id`,`uid`,`touid`,`title`,`content`,`draft`,`type`,`date`) VALUES ("13","9","9","333333333333",NULL,NULL,"file","0000-00-00") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message") . '` (`id`,`uid`,`touid`,`title`,`content`,`draft`,`type`,`date`) VALUES ("14","9","9","fff",NULL,NULL,"file","0000-00-00") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message") . '` (`id`,`uid`,`touid`,`title`,`content`,`draft`,`type`,`date`) VALUES ("15","9","9","复制的教训：C2C模式在中国还能走多久？","复制的教训：C2C模式在中国还能走多久？复制的教训：C2C模式在中国还能走多久？复制的教训：C2C模式在中国还能走多久？","1","msg","0000-00-00") ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_message"),$nDataRows));
			
		$nDataRows = 0 ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message_attachment") . '` (`id`,`mid`,`file`,`date`) VALUES ("1","9","","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message_attachment") . '` (`id`,`mid`,`file`,`date`) VALUES ("2","9","","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message_attachment") . '` (`id`,`mid`,`file`,`date`) VALUES ("3","9","","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message_attachment") . '` (`id`,`mid`,`file`,`date`) VALUES ("4","9","","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message_attachment") . '` (`id`,`mid`,`file`,`date`) VALUES ("5","9","","0") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message_attachment") . '` (`id`,`mid`,`file`,`date`) VALUES ("6","12","public/files/default/openoa/file/personnal.xls","1346472597") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message_attachment") . '` (`id`,`mid`,`file`,`date`) VALUES ("7","13","public/files/default/openoa/file/personnal.xls","1346481092") ') ;
		$nDataRows+= $aDB->execute( 'REPLACE INTO `' . $aDB->transTableName("openoa_message_attachment") . '` (`id`,`mid`,`file`,`date`) VALUES ("8","14","public/files/default/openoa/file/personnal.xls","1346481117") ') ;
		$aMessageQueue->create(Message::success,'向数据表%s插入了%d行记录。',array($aDB->transTableName("openoa_message_attachment"),$nDataRows));
			
		
		
		// 3. settings
		
		$aSetting = $aExtension->setting() ;
			
				
		$aSetting->setItem('/','Holidays','7');
				
		$aSetting->setItem('/','openoa_am','8:30');
				
		$aSetting->setItem('/','openoa_pm','17:30');
				
		$aSetting->setItem('/','openoa_wxs','11:30');
				
		$aSetting->setItem('/','openoa_wxt','13:00');
				
		$aMessageQueue->create(Message::success,'保存配置：%s',"/");
			
		
		
		// 4. files
		
	}
}
