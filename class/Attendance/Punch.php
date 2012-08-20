<?php

namespace org\opencomb\openoa\Attendance;

use org\opencomb\openoa\controller\OpenOaController;

class Punch extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'截止2012年4月1日止2012年2月份及1-2月份水费回收率及清欠2011年末前欠费完成情况',
		'view' => array (
				'template' => 'Attendance/Punch.html',
		),
	) ;
	
	public function process()
	{
	    
	}
}
