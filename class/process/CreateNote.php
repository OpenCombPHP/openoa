<?php

namespace org\opencomb\openoa\process;

use org\jecat\framework\mvc\model\Category;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class CreateNote extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'',
		'view' => array (
				'template' => 'process/CreateNote.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    $oModel = Model::create("openoa:message");
        $oModel->hasOne("openoa:EmployeeManagement","uid","uid","userinfo");
	    $oList = $oModel->load( array($uid,'msg', 1) , array('touid','type','draft'));
	    
	    $this->view()->variables()->set('list', $oList );
	    
	    
	    
	    // 群组
	    $aGroupModel = Model::create('coresystem:group');
	    Category::buildTree( $aGroupModel->load() ) ;
	    $this->view()->variables()->set('GroupModel', $aGroupModel );
	    
	}
}
