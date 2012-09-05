<?php

namespace org\opencomb\openoa\office;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class fileOutbox extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'已发文件',
		'view' => array (
				'template' => 'office/fileOutbox.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    $oModel = Model::create("openoa:message");
        $oModel->hasOne("openoa:EmployeeManagement","uid","uid","userinfo");
        $oModel->hasMany("openoa:message_attachment","id","mid","att");
	    $oList = $oModel->load( array($uid,'file') , array('uid','type'));
	    
	    $this->view()->variables()->set('list', $oList );
	}
}
