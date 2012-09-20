<?php

namespace org\opencomb\openoa\process;

use org\jecat\framework\util\EventManager;

use org\jecat\framework\db\DB;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class DetailRecord extends OpenOaController
{
    const onDetailRecord = 'onDetailRecord' ;
    
	protected $arrConfig = array
	(
		'title'=>'',
		'view' => array (
				'template' => 'process/DetailRecord.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    // 触发事件
// 	    $aEventManager = EventManager::singleton() ;
// 	    $arrEventArgvs = array($this,$this->params()->get('rid')) ;
// 	    $aEventManager->emitEvent(__CLASS__,self::onDetailRecord,$arrEventArgvs) ;
	    
	    $oModel = Model::create("openoa:Process_Record_Details");
        $oModel->hasOne("openoa:Process_Record","rid","id","record");
	    $oModel->load( array( $this->params()->get('rid')) , array('rid'));
	    
	    $aData = $oModel->alldata();
	    
	    $this->view()->variables()->set('list', $aData );
	}
}
