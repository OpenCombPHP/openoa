<?php

namespace org\opencomb\openoa\office;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class Inbox extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'已收消息',
		'view' => array (
				'template' => 'office/Inbox.html',
		),
	) ;
	
	public function process()
	{
	    if(IdManager::singleton()->currentId() == null)
	    {
            $this->messageQueue ()->create ( Message::success, "请登陆" );
            $this->location('?c=login');
	    }
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    $oModel = Model::create("openoa:message");
        $oModel->hasOne("openoa:EmployeeManagement","uid","uid","userinfo");
	    $oList = $oModel->load( array($uid,'msg', 1) , array('touid','type','draft'));
	    
	    $this->view()->variables()->set('list', $oList );
	}
}
