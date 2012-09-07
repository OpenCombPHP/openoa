<?php

namespace org\opencomb\openoa\process;

use org\opencomb\platform\ext\Extension;

use org\jecat\framework\message\Message;

use org\jecat\framework\auth\IdManager;

use org\jecat\framework\mvc\model\Model;

use org\opencomb\openoa\controller\OpenOaController;

class MyRecord extends OpenOaController
{
	protected $arrConfig = array
	(
		'title'=>'',
		'view' => array (
				'template' => 'process/MyRecord.html',
		),
	) ;
	
	public function process()
	{
	    $uid = IdManager::singleton()->currentId()->userId();
	    
	    $oRecordModel = Model::create("openoa:Process_Record");
	    $oRecordModel->hasOne("openoa:Process_Task" ,"tid","id","task");
	    $oRecordModel->hasOne("openoa:Process_Node" ,"nowNid","id","node");
	    $oList = $oRecordModel->load( array($uid), array("uid"));
	    
	    $this->view()->variables()->set('list', $oList );
	}
}
