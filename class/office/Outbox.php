<?php

namespace org\opencomb\openoa\office;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class Outbox extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'已发消息',
		'view' => array (
				'template' => 'office/Outbox.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    $oModel = Model::create("openoa:message");
        $oModel->hasOne("openoa:EmployeeManagement","uid","uid","userinfo");
	    $oList = $oModel->load( array($uid,'msg', 1) , array('uid','type','draft'));
	    
	    $this->view()->variables()->set('list', $oList );
	}
}
