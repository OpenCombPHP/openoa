<?php

namespace org\opencomb\openoa\office;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class fileDetail extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'详细信息',
		'view' => array (
				'template' => 'office/fileDetail.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    $oModel = Model::create("openoa:message");
        $oModel->hasOne("openoa:EmployeeManagement","uid","uid","userinfo");
        $oModel->hasMany("openoa:message_attachment","id","mid","att");
	    $oRow = $oModel->load( $this->params()->get('id') , 'id');
	    $this->view()->variables()->set('row', $oRow );
	}
}
