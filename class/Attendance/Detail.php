<?php

namespace org\opencomb\openoa\Attendance;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class Detail extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'打卡签到',
		'view' => array (
				'template' => 'Attendance/Detail.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    $oModel = Model::create("openoa:attendance_detail"); 
	    $oModel->hasOne("openoa:EmployeeManagement","uid","uid","userinfo");
	    $oData = $oModel->load( array( $uid),array( 'uid'));
	    $this->view()->variables()->set('data', $oData );
	}
}
